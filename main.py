from sqlalchemy import create_engine, text

# --- CONFIGURAÇÕES DE PRODUÇÃO ---
# IMPORTANTE: Como estamos dentro de um container Docker,
# 'localhost' se refere ao container, não ao servidor.
# Para acessar o banco no servidor (Host), usamos o Gateway do Docker: 172.17.0.1

DB_HOST = "72.60.244.132"  # IP do Host visto de dentro do Docker
DB_PORT = "3306"        # MySQL = 3306 | PostgreSQL = 5432
DB_USER = "portifolio"        # Ajuste para o usuário real do banco
DB_PASS = "L8WWJGdhDX6nJjEP" # A senha que você mencionou
DB_NAME = "portifolio"   # Nome do banco existente

# --- STRING DE CONEXÃO (Escolha uma) ---

# OPÇÃO 1: MySQL
CONN_STR = f"mysql+mysqlconnector://{DB_USER}:{DB_PASS}@{DB_HOST}:{DB_PORT}/{DB_NAME}"

# OPÇÃO 2: PostgreSQL (Descomente se for Postgres)
# CONN_STR = f"postgresql+psycopg2://{DB_USER}:{DB_PASS}@{DB_HOST}:{DB_PORT}/{DB_NAME}"

def testar_conexao():
    print(f"📡 Tentando conectar em {DB_HOST}:{DB_PORT} no banco '{DB_NAME}'...")
    
    try:
        engine = create_engine(CONN_STR)
        
        # Tenta conectar efetivamente
        with engine.connect() as conn:
            print("✅ SUCESSO! Conexão estabelecida com o banco de produção.")
            
            # Teste simples: Listar tabelas
            print("\n📋 Tabelas encontradas:")
            
            # Query ajustável conforme o banco
            if "mysql" in CONN_STR:
                query = text("SHOW TABLES;")
            else:
                query = text("SELECT table_name FROM information_schema.tables WHERE table_schema='public';")
                
            result = conn.execute(query)
            tabelas = result.fetchall()
            
            if not tabelas:
                print("   (Nenhuma tabela encontrada ou banco vazio)")
            else:
                for tabela in tabelas:
                    print(f"   - {tabela[0]}")

    except Exception as e:
        print("\n❌ FALHA NA CONEXÃO:")
        print(e)
        print("\nDYNO TIP: Verifique se o usuário do banco tem permissão para conectar a partir de '172.17.0.1' ou '%'")

if __name__ == "__main__":
    testar_conexao()