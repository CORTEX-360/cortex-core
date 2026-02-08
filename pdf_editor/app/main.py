# app/main.py (Versão 2.0 - Deep Extraction)
from fastapi import FastAPI, File, UploadFile, HTTPException, Form
from fastapi.responses import StreamingResponse
from fastapi.middleware.cors import CORSMiddleware
import fitz  # PyMuPDF
import os
import shutil
import uuid
import json
import io

app = FastAPI(title="CORTEX 360 PDF Engine", version="2.0")

# Permite conexões de qualquer origem (CORS)
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

UPLOAD_DIR = "/tmp/cortex_uploads"
os.makedirs(UPLOAD_DIR, exist_ok=True)

@app.get("/")
def read_root():
    return {"status": "online", "system": "Cortex PDF Engine v2.0 (Deep Edit)"}

@app.post("/analyze")
async def analyze_pdf(file: UploadFile = File(...)):
    if not file.filename.endswith(".pdf"):
        raise HTTPException(status_code=400, detail="Arquivo deve ser um PDF.")

    file_id = str(uuid.uuid4())
    file_path = os.path.join(UPLOAD_DIR, f"{file_id}.pdf")

    try:
        with open(file_path, "wb") as buffer:
            shutil.copyfileobj(file.file, buffer)

        doc = fitz.open(file_path)
        pages_data = []

        for page_num, page in enumerate(doc):
            # Extrai estrutura detalhada (Dicionário)
            page_dict = page.get_text("dict")
            width = page_dict["width"]
            height = page_dict["height"]
            
            extracted_lines = []

            # Navega na hierarquia: Bloco -> Linha -> Span (Pedaço de texto com mesma fonte)
            for block in page_dict.get("blocks", []):
                if block.get("type") == 0:  # Tipo 0 é texto
                    for line in block.get("lines", []):
                        for span in line.get("spans", []):
                            # Filtra textos muito pequenos ou invisíveis para não poluir a tela
                            if span['size'] > 2 and span['text'].strip()::
                                extracted_lines.append({
                                    "text": span['text'],
                                    "x": span['bbox'][0],
                                    "y": span['bbox'][1], # Topo da linha
                                    "width": span['bbox'][2] - span['bbox'][0],
                                    "height": span['bbox'][3] - span['bbox'][1],
                                    "size": span['size'],
                                    "font": span['font'],
                                    "color": span['color'] # Int (sRGB)
                                })
            
            pages_data.append({
                "page_number": page_num + 1,
                "width": width,
                "height": height,
                "text_objects": extracted_lines
            })

        doc.close()
        os.remove(file_path)

        return {
            "status": "success",
            "total_pages": len(pages_data),
            "pages": pages_data
        }

    except Exception as e:
        if os.path.exists(file_path):
            os.remove(file_path)
        print(f"Erro: {e}")
        raise HTTPException(status_code=500, detail=str(e))

@app.post("/sign")
async def sign_pdf(file: UploadFile = File(...), modifications: str = Form(...)):
    """
    Versão Avançada:
    1. Desenha um retângulo branco sobre o texto antigo (Redact/Whiteout).
    2. Escreve o novo texto por cima.
    """
    try:
        mods = json.loads(modifications)
        pdf_stream = await file.read()
        doc = fitz.open(stream=pdf_stream, filetype="pdf")

        for page_mod in mods:
            page_idx = page_mod['pageIndex']
            if page_idx < len(doc):
                page = doc[page_idx]
                
                for obj in page_mod['objects']:
                    x = obj['left']
                    y = obj['top'] + obj['fontSize'] # Ajuste de Baseline do PyMuPDF
                    text = obj['text']
                    size = obj['fontSize']
                    
                    # Definição de cor (Simplificada para Preto/Azul)
                    color = (0, 0, 0)
                    if obj.get('isSignature'):
                        color = (0, 0, 1)

                    # A MÁGICA DO WHITEOUT:
                    # Se NÃO for um texto novo (isNew=False), significa que estamos editando algo existente.
                    # Precisamos "apagar" o original desenhando um retângulo branco em cima.
                    if not obj.get('isNew', False):
                        # Criamos um retângulo ligeiramente maior que o texto para garantir a cobertura
                        rect = fitz.Rect(obj['left'], obj['top'], obj['left'] + obj['width'] + 2, obj['top'] + obj['height'] + 2)
                        page.draw_rect(rect, color=(1, 1, 1), fill=(1, 1, 1))

                    # Insere o novo texto
                    page.insert_text(
                        (x, y),
                        text,
                        fontsize=size,
                        color=color,
                        fontname="helv", # Usa Helvetica como padrão seguro
                    )

        output_buffer = io.BytesIO()
        doc.save(output_buffer)
        output_buffer.seek(0)
        
        return StreamingResponse(
            output_buffer, 
            media_type="application/pdf",
            headers={"Content-Disposition": f"attachment; filename=edited_{file.filename}"}
        )

    except Exception as e:
        print(f"Erro ao salvar: {e}")
        raise HTTPException(status_code=500, detail=str(e))