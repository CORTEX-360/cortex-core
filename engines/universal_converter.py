#!/usr/bin/env python3
import sys
import json
import os
import pandas as pd
from PIL import Image

def convert_image(input_path, output_path, target_ext):
    img = Image.open(input_path)
    # Converter para RGB se for salvar em JPG (remove transparência)
    if target_ext in ['jpg', 'jpeg'] and img.mode in ('RGBA', 'P'):
        img = img.convert('RGB')
    img.save(output_path)

def convert_spreadsheet(input_path, output_path, target_ext):
    # Detectar origem
    if input_path.endswith('.csv'):
        df = pd.read_csv(input_path)
    elif input_path.endswith('.xlsx'):
        df = pd.read_excel(input_path)
    elif input_path.endswith('.json'):
        df = pd.read_json(input_path)
    else:
        raise ValueError("Formato de entrada de planilha não suportado.")

    # Salvar destino
    if target_ext == 'csv':
        df.to_csv(output_path, index=False)
    elif target_ext == 'json':
        df.to_json(output_path, orient='records', indent=4)
    elif target_ext == 'xlsx':
        df.to_excel(output_path, index=False)
    elif target_ext == 'html':
        df.to_html(output_path, index=False)
    else:
        raise ValueError(f"Conversão para {target_ext} não suportada para planilhas.")

def main():
    try:
        if len(sys.argv) < 4:
            raise ValueError("Argumentos insuficientes.")

        input_path = sys.argv[1]
        output_dir = sys.argv[2] # Diretório de saída
        target_format = sys.argv[3].lower()

        filename = os.path.basename(input_path)
        name_only = os.path.splitext(filename)[0]
        output_filename = f"{name_only}_converted.{target_format}"
        output_path = os.path.join(output_dir, output_filename)

        # Lógica de Roteamento de Tipo
        if target_format in ['png', 'jpg', 'jpeg', 'webp', 'bmp']:
            convert_image(input_path, output_path, target_format)
        
        elif target_format in ['csv', 'json', 'xlsx', 'html']:
            convert_spreadsheet(input_path, output_path, target_format)
            
        # Adicionar aqui lógica para Docs/PDF se instalar LibreOffice no futuro
        
        else:
            raise ValueError(f"Formato alvo '{target_format}' não implementado neste motor.")

        print(json.dumps({
            "status": "success",
            "message": "Conversão realizada.",
            "download_url": f"uploads/{output_filename}" 
        }))

    except Exception as e:
        print(json.dumps({
            "status": "error",
            "message": str(e)
        }))

if __name__ == "__main__":
    main()