# app/main.py (Versão 4.0 - True Redaction / Supressão Real)
from fastapi import FastAPI, File, UploadFile, HTTPException, Form
from fastapi.responses import StreamingResponse
from fastapi.middleware.cors import CORSMiddleware
import fitz  # PyMuPDF
import os
import shutil
import uuid
import json
import io

app = FastAPI(title="CORTEX 360 PDF Engine", version="4.0")

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

UPLOAD_DIR = "/tmp/cortex_uploads"
os.makedirs(UPLOAD_DIR, exist_ok=True)

def map_font_to_web(pdf_font_name):
    """Mapeia fontes do PDF para Web."""
    name = pdf_font_name.lower()
    if 'wingdings' in name or 'symbol' in name: return 'Segoe UI Symbol'
    if 'times' in name or 'roman' in name or 'serif' in name: return 'Times New Roman'
    elif 'courier' in name or 'mono' in name: return 'Courier New'
    elif 'arial' in name or 'helv' in name or 'sans' in name: return 'Arial'
    else: return 'Arial'

def hex_to_rgb(hex_color):
    """Converte HEX para RGB (0-1 float) para PyMuPDF."""
    if not hex_color or hex_color == 'transparent': return None
    hex_color = hex_color.lstrip('#')
    if len(hex_color) != 6: return None
    return tuple(int(hex_color[i:i+2], 16) / 255.0 for i in (0, 2, 4))

def get_smart_bg_color(page, bbox):
    """Detecta a cor do papel na área."""
    try:
        rect = fitz.Rect(bbox[0]-2, bbox[1]-2, bbox[2]+2, bbox[3]+2)
        pix = page.get_pixmap(clip=rect, matrix=fitz.Matrix(0.5, 0.5))
        r, g, b = pix.pixel(0, 0)
        # Evita preto absoluto (provavelmente pegou borda)
        if r < 30 and g < 30 and b < 30: return '#ffffff'
        return '#{:02x}{:02x}{:02x}'.format(r, g, b)
    except:
        return '#ffffff'

@app.post("/analyze")
async def analyze_pdf(file: UploadFile = File(...)):
    if not file.filename.endswith(".pdf"):
        raise HTTPException(status_code=400, detail="Arquivo inválido.")

    file_id = str(uuid.uuid4())
    file_path = os.path.join(UPLOAD_DIR, f"{file_id}.pdf")

    try:
        with open(file_path, "wb") as buffer:
            shutil.copyfileobj(file.file, buffer)

        doc = fitz.open(file_path)
        pages_data = []

        for page_num, page in enumerate(doc):
            page_dict = page.get_text("dict")
            extracted_lines = []

            for block in page_dict.get("blocks", []):
                if block.get("type") == 0:
                    for line in block.get("lines", []):
                        for span in line.get("spans", []):
                            if span['size'] > 2 and span['text'].strip():
                                
                                detected_bg = get_smart_bg_color(page, span['bbox'])
                                web_font = map_font_to_web(span['font'])

                                extracted_lines.append({
                                    "text": span['text'],
                                    "x": span['bbox'][0],
                                    "y": span['bbox'][1],
                                    "width": span['bbox'][2] - span['bbox'][0],
                                    "height": span['bbox'][3] - span['bbox'][1],
                                    "size": span['size'],
                                    "fontFamily": web_font,
                                    "fontWeight": 'bold' if 'bold' in span['font'].lower() else 'normal',
                                    "detectedBg": detected_bg
                                })
            
            pages_data.append({
                "page_number": page_num + 1,
                "width": page_dict["width"],
                "height": page_dict["height"],
                "text_objects": extracted_lines
            })

        doc.close()
        os.remove(file_path)
        return {"status": "success", "pages": pages_data}

    except Exception as e:
        if os.path.exists(file_path): os.remove(file_path)
        raise HTTPException(status_code=500, detail=str(e))

@app.post("/sign")
async def sign_pdf(file: UploadFile = File(...), modifications: str = Form(...)):
    """
    Versão 4.0: Usa REDACTION para remover o texto original fisicamente.
    """
    try:
        mods = json.loads(modifications)
        pdf_stream = await file.read()
        doc = fitz.open(stream=pdf_stream, filetype="pdf")

        for page_mod in mods:
            if page_mod['pageIndex'] < len(doc):
                page = doc[page_mod['pageIndex']]
                
                # 1. PRIMEIRO PASSO: APLICAR REDAÇÕES (APAGAR O VELHO)
                # Precisamos fazer isso antes de escrever o novo para não apagar o novo por acidente
                for obj in page_mod['objects']:
                    if not obj.get('isNew', False):
                        # Pega as dimensões da área ORIGINAL que deve ser apagada
                        # O Frontend deve enviar 'eraseWidth' e 'eraseHeight' baseados no original
                        e_width = obj.get('eraseWidth', obj['width'])
                        e_height = obj.get('eraseHeight', obj['height'])
                        
                        # Define a área de corte (Redaction)
                        rect = fitz.Rect(obj['left'], obj['top'], obj['left'] + e_width + 1, obj['top'] + e_height + 1)
                        
                        # Define a cor de preenchimento (Fundo do papel)
                        bg_color_hex = obj.get('backgroundColor', '#ffffff')
                        fill_color = hex_to_rgb(bg_color_hex)
                        
                        # Se for transparente no front, a gente tenta usar branco ou a cor detectada para tapar o buraco
                        # Redação precisa de cor de fill, senão fica preto ou vazio
                        if fill_color is None: 
                            fill_color = (1, 1, 1) # Fallback Branco se mandou transparente, pois tem que tapar o buraco
                        
                        # Adiciona a anotação de redação
                        page.add_redact_annot(rect, fill=fill_color)
                
                # Aplica o corte (Remove vetores e imagens na área marcada)
                page.apply_redactions(images=fitz.PDF_REDACT_IMAGE_NONE) # Tenta preservar imagens de fundo que não tocam o texto

                # 2. SEGUNDO PASSO: ESCREVER O NOVO TEXTO
                for obj in page_mod['objects']:
                    # Configurações de Fonte
                    font_mapper = {"Times New Roman": "tiro", "Courier New": "cour", "Arial": "helv"}
                    font_code = font_mapper.get(obj.get('fontFamily'), "helv")
                    if obj.get('fontWeight') == 'bold' and font_code == 'helv': font_code = 'helv-bo'
                    
                    color = (0, 0, 1) if obj.get('isSignature') else (0, 0, 0)
                    
                    page.insert_text(
                        (obj['left'], obj['top'] + obj['fontSize']), # PyMuPDF usa baseline
                        obj['text'],
                        fontsize=obj['fontSize'],
                        color=color,
                        fontname=font_code 
                    )

        output_buffer = io.BytesIO()
        doc.save(output_buffer)
        output_buffer.seek(0)
        return StreamingResponse(output_buffer, media_type="application/pdf", headers={"Content-Disposition": f"attachment; filename=edited_{file.filename}"})

    except Exception as e:
        raise HTTPException(status_code=500, detail=str(e))