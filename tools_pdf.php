<?php
// Configuração dinâmica do Base Path
$BASE = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
if ($BASE === '/' || $BASE === '\\') $BASE = '';

// Rastreamento de Métricas
require_once __DIR__ . '/api/metricas_acesso.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CORTEX 360 | PDF Splitter Engine</title>

    <link rel="icon" href="<?= htmlspecialchars($BASE, ENT_QUOTES, 'UTF-8') ?>/assets/favicon.ico">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=JetBrains+Mono:wght@400;700&family=Outfit:wght@700;900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="css/style.css">

    <style>
        /* --- LÓGICA DE TEMA (DARK PADRÃO / LIGHT MODE) --- */
        :root {
            /* Padrão Dark (Cyberpunk) */
            --panel-bg: rgba(30, 41, 59, 0.4);
            --panel-border: rgba(255, 255, 255, 0.05);
            
            /* Área da Lista (Escuro translúcido) */
            --list-bg: rgba(15, 23, 42, 0.3); 
            --list-border: rgba(51, 65, 85, 0.5);

            /* Inputs */
            --input-bg: rgba(15, 23, 42, 0.6);
            --input-border: rgba(148, 163, 184, 0.2);
            --input-text: #e2e8f0;
            
            /* Textos */
            --text-heading: #ffffff;
            --text-body: #94a3b8;
            
            /* Upload Area */
            --dropzone-bg: rgba(15, 23, 42, 0.4);
            --dropzone-border: rgba(51, 65, 85, 1);
            --dropzone-icon: #94a3b8;
        }

        /* Override quando o JS adiciona .light-mode no body */
        body.light-mode {
            --panel-bg: #ffffff; /* Fundo Painel Branco Puro */
            --panel-border: #e2e8f0;
            
            /* Área da Lista (Cinza Profissional e Limpo) */
            --list-bg: #f1f5f9; /* Slate-100: Cinza muito suave */
            --list-border: #cbd5e1;

            /* Inputs (Branco sobre o cinza da lista) */
            --input-bg: #ffffff;
            --input-border: #cbd5e1;
            --input-text: #1e293b; /* Slate-800 */
            
            /* Textos */
            --text-heading: #0f172a; /* Slate-900 */
            --text-body: #475569;    /* Slate-600 */
            
            /* Upload Area */
            --dropzone-bg: #f8fafc; /* Slate-50 */
            --dropzone-border: #cbd5e1;
            --dropzone-icon: #64748b;
        }

        /* Componentes usando as variáveis dinâmicas */
        .glass-panel {
            background: var(--panel-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--panel-border);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            transition: background 0.3s, border 0.3s;
        }

        /* Container da Lista de Regras */
        .list-container {
            background: var(--list-bg);
            border: 1px solid var(--list-border);
            transition: background 0.3s, border 0.3s;
        }

        .tech-input {
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            color: var(--input-text);
            transition: all 0.3s ease;
        }
        
        .tech-input:focus {
            border-color: #06b6d4;
            box-shadow: 0 0 15px rgba(6, 182, 212, 0.15);
            outline: none;
        }

        .drop-zone {
            background: var(--dropzone-bg);
            border: 2px dashed var(--dropzone-border);
            transition: all 0.3s ease;
        }
        
        .drop-icon {
            color: var(--dropzone-icon);
            transition: color 0.3s ease;
        }

        /* Tipografia */
        .title-font { font-family: 'Outfit', sans-serif; color: var(--text-heading); }
        .body-text { color: var(--text-body); }
        .mono-font { font-family: 'JetBrains Mono', monospace; }

        /* Animações e Scroll */
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .range-row { animation: slideIn 0.3s ease-out; }

        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: rgba(0,0,0,0.05); }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 2px; }
    </style>
</head>
<body class="overflow-x-hidden transition-colors duration-300">

    <script>
        (function() {
            try {
                const savedTheme = localStorage.getItem('cortex_theme');
                if (savedTheme === 'light') {
                    document.body.classList.add('light-mode');
                }
            } catch (e) {}
        })();
    </script>

    <div class="fixed top-[-100px] left-[-100px] w-[500px] h-[500px] bg-blue-500/20 rounded-full blur-[120px] pointer-events-none z-[-1]"></div>
    <div class="fixed bottom-[20%] right-[-100px] w-[500px] h-[500px] bg-cyan-500/10 rounded-full blur-[120px] pointer-events-none z-[-1]"></div>

    <?php include 'partial/navbar.php'; ?>

    <section class="relative min-h-screen flex items-center justify-center pt-32 pb-20 px-6">
        <div class="w-full max-w-6xl">
            
            <div class="text-center mb-16">
                <span class="mono-font text-cyan-500 text-xs uppercase tracking-[0.3em] font-bold animate-pulse">
                    [ PYTHON ENGINE LOCAL ]
                </span>
                <h1 class="title-font text-4xl md:text-6xl font-black mt-4 mb-6">
                    PDF <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-500">Splitter Pro</span>
                </h1>
                <p class="body-text max-w-2xl mx-auto text-lg">
                    Segmente documentos complexos com precisão cirúrgica. Processamento local seguro, sem envio de dados para terceiros.
                </p>
            </div>

            <div class="glass-panel rounded-[2rem] p-8 md:p-12 relative overflow-hidden">
                <form id="pdfForm" class="grid lg:grid-cols-12 gap-12 relative z-10">
                    
                    <div class="lg:col-span-5 flex flex-col gap-6">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="w-8 h-8 rounded-full bg-cyan-500/10 flex items-center justify-center text-cyan-500 font-bold text-sm">1</span>
                            <h3 class="title-font text-xl font-bold uppercase">Arquivo Master</h3>
                        </div>

                        <div class="relative group flex-1 min-h-[300px]">
                            <input type="file" id="fileInput" name="file" accept=".pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20" required>
                            
                            <div id="dropZone" class="drop-zone h-full rounded-2xl flex flex-col items-center justify-center text-center p-8 transition-all duration-300 group-hover:border-cyan-500 group-hover:bg-cyan-500/5">
                                <div class="w-20 h-20 rounded-full bg-slate-500/10 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                                    <svg class="w-10 h-10 drop-icon group-hover:text-cyan-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                </div>
                                <p id="fileName" class="text-lg font-medium body-text group-hover:text-cyan-500 transition-colors">Arraste ou clique para carregar</p>
                                <p class="text-sm text-slate-500 mt-2 mono-font">Suporta PDF até 50MB</p>
                            </div>
                        </div>
                    </div>

                    <div class="hidden lg:block w-[1px] bg-gradient-to-b from-transparent via-slate-500/30 to-transparent absolute left-[41.6%] top-0 bottom-0"></div>

                    <div class="lg:col-span-7 flex flex-col h-full pl-0 lg:pl-12">
                        <div class="flex justify-between items-center mb-8">
                            <div class="flex items-center gap-3">
                                <span class="w-8 h-8 rounded-full bg-cyan-500/10 flex items-center justify-center text-cyan-500 font-bold text-sm">2</span>
                                <h3 class="title-font text-xl font-bold uppercase">Regras de Corte</h3>
                            </div>
                            <button type="button" onclick="addRangeRow()" class="mono-font text-xs border border-cyan-500/30 px-4 py-2 rounded-full hover:bg-cyan-500 hover:text-white transition text-cyan-500 font-bold uppercase flex items-center gap-2">
                                <span>+</span> Adicionar
                            </button>
                        </div>

                        <div class="flex-1 list-container rounded-2xl p-4 mb-8 min-h-[250px] relative">
                            <div id="rangesContainer" class="absolute inset-4 overflow-y-auto custom-scrollbar space-y-3 pr-2">
                                </div>
                        </div>

                        <button type="submit" id="submitBtn" class="w-full bg-cyan-500 text-white font-bold py-5 rounded-xl text-lg hover:scale-[1.02] hover:shadow-lg hover:shadow-cyan-500/20 transition-all title-font uppercase tracking-wider flex justify-center items-center gap-3 disabled:opacity-50 disabled:cursor-not-allowed">
                            <span>Processar Agora</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </form>

                <div id="statusArea" class="hidden mt-8 bg-slate-900 rounded-xl p-6 border border-slate-700 mono-font text-xs relative z-10">
                    <div class="flex items-center gap-2 mb-3 border-b border-slate-700 pb-3">
                        <div class="w-2 h-2 rounded-full bg-yellow-500 animate-pulse"></div>
                        <span class="text-slate-400">System Output Log</span>
                    </div>
                    <p id="statusText" class="text-cyan-400">> Aguardando inicialização do motor...</p>
                </div>
            </div>

            <div class="mt-8 text-center">
                <p class="mono-font text-[10px] text-slate-500 uppercase tracking-widest">
                    Server: 72.60.244.132 | Engine: Python 3.x | Latency: Localhost
                </p>
            </div>
        </div>
    </section>

    <?php include 'partial/footer.php'; ?>


    <template id="rowTemplate">
        <div class="range-row flex items-center gap-3 p-3 rounded-xl border border-slate-500/20 hover:border-cyan-500/50 transition-colors group bg-white/5 dark:bg-slate-800/20">
            <div class="w-8 flex justify-center">
                <span class="mono-font text-xs text-slate-500">#<span class="row-index">1</span></span>
            </div>
            
            <div class="flex-1 flex items-center gap-3">
                <div class="flex-1 relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[10px] text-slate-500 font-bold uppercase pointer-events-none">De</span>
                    <input type="number" class="start-page tech-input w-full pl-8 pr-3 py-2 rounded-lg mono-font text-sm" placeholder="Pg" min="1">
                </div>
                <div class="w-2 h-[1px] bg-slate-500/50"></div>
                <div class="flex-1 relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[10px] text-slate-500 font-bold uppercase pointer-events-none">Até</span>
                    <input type="number" class="end-page tech-input w-full pl-10 pr-3 py-2 rounded-lg mono-font text-sm" placeholder="Pg" min="1">
                </div>
            </div>

            <button type="button" onclick="removeRow(this)" class="p-2 text-slate-500 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition-colors" title="Remover">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </button>
        </div>
    </template>

    <script>
        const container = document.getElementById('rangesContainer');
        const template = document.getElementById('rowTemplate');
        
        document.addEventListener('DOMContentLoaded', () => {
            addRangeRow();
        });

        function addRangeRow() {
            const clone = template.content.cloneNode(true);
            const index = container.children.length + 1;
            clone.querySelector('.row-index').textContent = index;
            container.appendChild(clone);
            container.scrollTop = container.scrollHeight;
            updateIndexes();
        }

        window.removeRow = function(btn) {
            const row = btn.closest('.range-row');
            if(container.children.length > 1) {
                row.remove();
                updateIndexes();
            } else {
                row.querySelectorAll('input').forEach(i => i.value = '');
            }
        }

        function updateIndexes() {
            Array.from(container.children).forEach((row, i) => {
                row.querySelector('.row-index').textContent = i + 1;
            });
        }

        document.getElementById('fileInput').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            const dropZone = document.getElementById('dropZone');
            const label = document.getElementById('fileName');
            
            if (fileName) {
                label.innerText = fileName;
                label.className = "text-xl font-bold text-cyan-500 break-all title-font";
                dropZone.style.borderColor = "#06b6d4";
                dropZone.style.backgroundColor = "rgba(6, 182, 212, 0.05)";
            }
        });

        document.getElementById('pdfForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const btn = document.getElementById('submitBtn');
            const statusArea = document.getElementById('statusArea');
            const statusText = document.getElementById('statusText');
            const originalBtnText = btn.innerHTML;

            const ranges = [];
            document.querySelectorAll('.range-row').forEach(row => {
                const start = row.querySelector('.start-page').value;
                const end = row.querySelector('.end-page').value;
                if (start && end) {
                    ranges.push(`${start}-${end}`);
                } else if (start) {
                    ranges.push(`${start}-${start}`);
                }
            });

            if (ranges.length === 0) {
                alert("Por favor, defina pelo menos um intervalo.");
                return;
            }

            const finalRangeString = ranges.join(',');

            // Loading
            btn.disabled = true;
            btn.innerHTML = `<span class="animate-pulse">PROCESSANDO...</span>`;
            statusArea.classList.remove('hidden');
            statusText.innerHTML = `> Iniciando engine Python em modo shell_exec...\n> Analisando PDF...`;
            statusText.className = "text-yellow-400 whitespace-pre-line";

            const formData = new FormData();
            formData.append('file', document.getElementById('fileInput').files[0]);
            formData.append('ranges', finalRangeString);

            try {
                const response = await fetch('api/process_python_local.php', {
                    method: 'POST',
                    body: formData
                });

                const textResult = await response.text();
                let result;
                try {
                    result = JSON.parse(textResult);
                } catch(e) {
                    throw new Error("Resposta inválida do servidor: " + textResult.substring(0, 100) + "...");
                }

                if (response.ok && result.status === 'success') {
                    statusText.innerHTML += `\n> Sucesso! Gerando ZIP...`;
                    statusText.className = "text-green-400 font-bold whitespace-pre-line";
                    
                    const a = document.createElement('a');
                    a.href = result.download_url;
                    a.download = result.file || "cortex_split_files.zip";
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                    
                    btn.innerHTML = `✅ SUCESSO`;
                    
                    setTimeout(() => { 
                        btn.disabled = false; 
                        btn.innerHTML = originalBtnText;
                        statusArea.classList.add('hidden');
                    }, 5000);

                } else {
                    throw new Error(result.message || "Erro desconhecido");
                }
            } catch (err) {
                console.error(err);
                statusText.innerHTML += `\n> ERRO CRÍTICO: ${err.message}`;
                statusText.className = "text-red-500 font-bold whitespace-pre-line";
                btn.disabled = false;
                btn.innerHTML = `❌ ERRO`;
            }
        });
    </script>
    
    <script src="js/main.js"></script>
</body>
</html>