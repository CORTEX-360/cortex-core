# Dockerfile
FROM python:3.10-slim

# Instala dependências do sistema
# Ajuste: libgl1 substitui o antigo libgl1-mesa-glx no Debian novo
RUN apt-get update && apt-get install -y     libgl1     libglib2.0-0     poppler-utils     && rm -rf /var/lib/apt/lists/*

# Define diretório de trabalho
WORKDIR /code

# Copia e instala dependências Python
COPY ./requirements.txt /code/requirements.txt
RUN pip install --no-cache-dir --upgrade -r /code/requirements.txt

# Copia o código da aplicação
COPY ./app /code/app

# Comando para rodar a API (FastAPI)
CMD ["uvicorn", "app.main:app", "--host", "0.0.0.0", "--port", "8000"]
