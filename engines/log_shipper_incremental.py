import mysql.connector
import re
import os
import json
import random
from datetime import datetime, timedelta

# ==========================================
# ⚙️ CONFIGURAÇÃO ESTRATÉGICA CORTEX 360
# ==========================================
REAL_LOG_PATH = '/www/wwwlogs/cortex360.com.br.log' 
LOCAL_LOG_PATH = os.path.join(os.getcwd(), 'cortex_simulation.log')
STATE_FILE = os.path.join(os.path.dirname(os.path.abspath(__file__)), 'cortex_shipper_state.json')

DB_CONFIG = {
    'host': '72.60.244.132',
    'user': 'cortex360',      
    'password': 'Cortex360Vini', 
    'database': 'cortex360',
    'charset': 'utf8mb4'
}

SIMULATION_COUNT = 50000 
BATCH_SIZE = 2000 

LOG_PATTERN = re.compile(
    r'(?P<ip>[\d\.]+) - - \[(?P<time>.*?)\] "(?P<method>\w+) (?P<path>.*?) HTTP/.*?" (?P<status>\d+) (?P<bytes>\d+) "(?P<referer>.*?)" "(?P<agent>.*?)"'
)

# ==========================================
# 🛠️ GERAÇÃO DE DADOS (APENAS SE NECESSÁRIO)
# ==========================================

def generate_simulation_logs(count):
    """Gera logs para garantir que o Dashboard nunca esteja vazio"""
    print(f"📡 [MODO SIMULAÇÃO] Gerando {count} logs de alta volumetria...")
    methods = ['GET', 'POST', 'PUT']
    paths = ['/', '/dashboard', '/api/get_metrics.php', '/labs', '/api/login']
    statuses = [200]*80 + [404]*10 + [500]*10
    
    with open(LOCAL_LOG_PATH, 'w') as f:
        for _ in range(count):
            ip = f"{random.randint(100,200)}.{random.randint(10,100)}.{random.randint(1,255)}.{random.randint(1,254)}"
            log_time = (datetime.now() - timedelta(seconds=random.randint(0, 86400))).strftime('%d/%b/%Y:%H:%M:%S +0000')
            line = f'{ip} - - [{log_time}] "{random.choice(methods)} {random.choice(paths)} HTTP/1.1" {random.choice(statuses)} {random.randint(300,9000)} "-" "CortexBot/2.0"\n'
            f.write(line)
    return LOCAL_LOG_PATH

# ==========================================
# 🚀 LÓGICA HÍBRIDA (REAL vs SINTÉTICO)
# ==========================================

def get_best_data_source():
    """Prioridade: 1. Log Real com Dados | 2. Log Sintético"""
    if os.path.exists(REAL_LOG_PATH) and os.path.getsize(REAL_LOG_PATH) > 0:
        print("✅ [FONTE: REAL] Processando tráfego real do Nginx.")
        return REAL_LOG_PATH
    else:
        print("💡 [FONTE: SINTÉTICA] Sem tráfego real. Ativando Faker Strategy.")
        return generate_simulation_logs(SIMULATION_COUNT)

def run_shipper():
    log_file = get_best_data_source()
    file_stat = os.stat(log_file)
    curr_inode = file_stat.st_ino
    
    try:
        conn = mysql.connector.connect(**DB_CONFIG)
        cursor = conn.cursor()

        # Verifica se a tabela foi truncada (Auto-Healing)
        cursor.execute("SELECT COUNT(*) FROM access_logs")
        if cursor.fetchone()[0] == 0:
            print("📉 Base limpa detectada. Executando Full Load.")
            start_pos = 0
        else:
            if os.path.exists(STATE_FILE):
                with open(STATE_FILE, 'r') as fs:
                    state = json.load(fs)
                    start_pos = state.get('position', 0) if state.get('inode') == curr_inode else 0
            else:
                start_pos = 0

        batch = []
        with open(log_file, 'r', encoding='utf-8', errors='ignore') as f:
            f.seek(start_pos)
            for line in f:
                match = LOG_PATTERN.match(line)
                if match:
                    d = match.groupdict()
                    dt = datetime.strptime(d['time'].split()[0], '%d/%b/%Y:%H:%M:%S').strftime('%Y-%m-%d %H:%M:%S')
                    batch.append((dt, d['ip'], d['method'], d['path'], int(d['status']), int(d['bytes']), d['referer'], d['agent']))
                
                if len(batch) >= BATCH_SIZE:
                    cursor.executemany("INSERT INTO access_logs (log_time, ip_address, method, url_path, status_code, bytes_sent, referer, user_agent) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)", batch)
                    conn.commit()
                    batch = []

            if batch:
                cursor.executemany("INSERT INTO access_logs (log_time, ip_address, method, url_path, status_code, bytes_sent, referer, user_agent) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)", batch)
                conn.commit()

            # Salva progresso para ser incremental
            with open(STATE_FILE, 'w') as fs:
                json.dump({'inode': curr_inode, 'position': f.tell()}, fs)
            
            print(f"🚀 Sincronização Concluída: {len(batch)} novos registos.")

    except Exception as e:
        print(f"❌ Erro: {e}")
    finally:
        if 'conn' in locals() and conn.is_connected():
            cursor.close()
            conn.close()

if __name__ == "__main__":
    run_shipper()