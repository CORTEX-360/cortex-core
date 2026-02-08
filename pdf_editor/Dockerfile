# Dockerfile (Versão 3.0 - Com Suporte a Fontes MS)
FROM python:3.10-slim

# 1. Configuração de Repositórios para aceitar Fontes Proprietárias
# Adiciona 'contrib' e 'non-free' na lista de fontes do Debian (Bookworm)
RUN sed -i 's/main/main contrib non-free/' /etc/apt/sources.list.d/debian.sources || \
    echo "deb http://deb.debian.org/debian bookworm main contrib non-free" > /etc/apt/sources.list

# 2. Instalação de Dependências de Sistema e Fontes
# 'fontconfig' gerencia as fontes
# 'ttf-mscorefonts-installer' baixa Arial, Times, Verdana, etc.
RUN apt-get update && \
    # Instala utilitários básicos para lidar com o instalador de fontes
    apt-get install -y --no-install-recommends \
    libgl1 \
    libglib2.0-0 \
    poppler-utils \
    fontconfig \
    cabextract \
    xfonts-utils \
    curl && \
    # Aceita automaticamente a licença da Microsoft (evita travar o build)
    echo "ttf-mscorefonts-installer msttcorefonts/accepted-mscorefonts-eula select true" | debconf-set-selections && \
    # Instala as fontes
    apt-get install -y ttf-mscorefonts-installer && \
    # Limpeza para manter a imagem leve
    rm -rf /var/lib/apt/lists/*

# 3. Atualiza o Cache de Fontes do SO
# Isso garante que o Python/PyMuPDF encontre 'Arial' quando solicitado
RUN fc-cache -f -v

# Define diretório de trabalho
WORKDIR /code

# Copia e instala dependências Python
COPY ./requirements.txt /code/requirements.txt
RUN pip install --no-cache-dir --upgrade -r /code/requirements.txt

# Copia o código da aplicação
COPY ./app /code/app

# Comando para rodar a API (FastAPI)
CMD ["uvicorn", "app.main:app", "--host", "0.0.0.0", "--port", "8000"]