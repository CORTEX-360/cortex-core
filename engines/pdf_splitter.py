#!/usr/bin/env python3
import sys
import json
import os
import zipfile
import io
from PyPDF2 import PdfReader, PdfWriter

# Função auxiliar para entender "1-3" ou "5"
def parse_single_group_indices(group_str, max_pages):
    indices = []
    part = group_str.strip()
    try:
        if '-' in part:
            start_s, end_s = part.split('-')
            start = int(start_s) - 1 # Ajuste base 0
            end = int(end_s)
        else:
            start = int(part) - 1
            end = start + 1
        
        # Limites de segurança
        start = max(0, start)
        end = min(max_pages, end)
        
        if start < end:
            return list(range(start, end))
    except ValueError:
        pass
    return []

def main():
    try:
        # Argumentos: script.py [input_pdf] [output_zip_path] [ranges_string]
        if len(sys.argv) < 4:
            raise ValueError("Argumentos insuficientes.")

        input_path = sys.argv[1]
        output_zip_path = sys.argv[2] # Agora esperamos um caminho para o ZIP
        ranges_string = sys.argv[3]   # Ex: "1-2, 5-8"

        if not os.path.exists(input_path):
            raise FileNotFoundError(f"Arquivo de entrada não encontrado: {input_path}")

        reader = PdfReader(input_path)
        total_pages = len(reader.pages)
        
        # Cria o ZIP
        with zipfile.ZipFile(output_zip_path, 'w', zipfile.ZIP_DEFLATED) as zipf:
            groups = [g.strip() for g in ranges_string.split(',')]
            files_created = 0

            for idx, group in enumerate(groups):
                selected_indices = parse_single_group_indices(group, total_pages)
                
                if not selected_indices:
                    continue

                writer = PdfWriter()
                for i in selected_indices:
                    writer.add_page(reader.pages[i])

                # Salva PDF parcial na memória para adicionar ao ZIP
                pdf_bytes = io.BytesIO()
                writer.write(pdf_bytes)
                
                # Nome do arquivo dentro do ZIP
                filename_inside_zip = f"cortex_part_{idx+1}_pages_{group}.pdf"
                zipf.writestr(filename_inside_zip, pdf_bytes.getvalue())
                files_created += 1

        if files_created == 0:
            raise ValueError("Nenhuma página válida foi processada.")

        # Retorno JSON para o PHP
        filename = os.path.basename(output_zip_path)
        print(json.dumps({
            "status": "success",
            "message": "Processamento concluído.",
            "file": filename,
            "download_url": f"uploads/{filename}", 
            "parts_created": files_created
        }))

    except Exception as e:
        # Garante que o PHP receba um JSON de erro
        print(json.dumps({
            "status": "error",
            "message": str(e)
        }))

if __name__ == "__main__":
    main()