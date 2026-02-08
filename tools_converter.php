<?php
require_once __DIR__ . '/api/metricas_acesso.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicons (assets/) -->
    <link rel="icon" href="/assets/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/assets/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="/assets/android-chrome-512x512.png">
    <title>Universal Converter | Cortex 360 Tools</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=JetBrains+Mono:wght@400;700&family=Outfit:wght@700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    
    <style>
        .upload-zone {
            border: 2px dashed var(--border-ui);
            transition: all 0.3s ease;
            background: linear-gradient(180deg, rgba(34, 211, 238, 0.02) 0%, transparent 100%);
        }
        .upload-zone.drag-over {
            border-color: var(--accent-cyan);
            background: rgba(34, 211, 238, 0.05);
            transform: scale(1.01);
        }
        @keyframes pulse-border {
            0% { box-shadow: 0 0 0 0 rgba(34, 211, 238, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(34, 211, 238, 0); }
            100% { box-shadow: 0 0 0 0 rgba(34, 211, 238, 0); }
        }
        .processing-pulse {
            animation: pulse-border 2s infinite;
        }
    </style>
</head>
<body class="overflow-x-hidden min-h-screen flex flex-col justify-between">

    <script>
        (function() {
            try {
                const savedTheme = localStorage.getItem('cortex_theme');
                if (savedTheme === 'light') { document.body.classList.add('light-mode'); }
            } catch (e) {}
        })();
    </script>

    <div class="bg-glow top-[-10%] right-[-10%] opacity-20" style="background: radial-gradient(circle, #818CF8 0%, transparent 70%);"></div>
    <div class="bg-glow bottom-[10%] left-[-5%] opacity-10"></div>

    <?php include 'partial/navbar.php'; ?>

    <main class="flex-grow pt-28 sm:pt-32 px-4 sm:px-6 md:px-12 relative z-10">
        
        <div class="max-w-4xl mx-auto text-center mb-12 animate-fade-in-up">
            <a href="index.php#tools" class="mono text-[var(--accent-cyan)] text-[10px] uppercase tracking-[0.3em] font-bold hover:underline mb-4 inline-block">
                [ <- Voltar para Tools ]
            </a>
            <div class="inline-flex items-center gap-2 mb-4 px-3 py-1 rounded-full border border-yellow-500/20 bg-yellow-500/5">
                <span class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse"></span>
                <span class="mono text-[10px] text-yellow-400 font-bold uppercase tracking-widest">DEV_STAGE // BETA</span>
            </div>
            <h1 class="title-font text-3xl sm:text-4xl md:text-6xl font-black mb-4">
                UNIVERSAL <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-500">CONVERTER</span>
            </h1>
            <p style="color: var(--text-secondary)" class="max-w-2xl mx-auto text-sm md:text-base">
                Engine de transformação de dados agnóstica. Suporta Imagens, Documentos e Planilhas.
                <span class="block mt-2 text-[10px] mono opacity-60">PYTHON_PANDAS // PILLOW // OPENPYXL</span>
            </p>
        </div>

        <div class="max-w-3xl mx-auto">
            
            <div class="glass rounded-[2rem] p-1 md:p-2 border border-[var(--border-ui)] shadow-2xl relative overflow-hidden" id="tool-card">
                
                <div class="bg-[var(--bg-color)]/50 rounded-[1.8rem] p-6 sm:p-8 md:p-12 backdrop-blur-sm">
                    
                    <form id="converter-form" class="space-y-8">
                        
                        <div class="space-y-3">
                            <label class="mono text-xs font-bold text-indigo-400 uppercase tracking-widest">
                                01 // SOURCE_DATA
                            </label>
                            
                            <div id="drop-zone" class="upload-zone rounded-xl h-40 sm:h-48 flex flex-col items-center justify-center cursor-pointer relative group border-indigo-500/20 hover:border-indigo-500/50">
                                <input type="file" id="file-input" name="source_file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                
                                <div id="upload-placeholder" class="text-center transition-all duration-300 group-hover:-translate-y-1">
                                    <div class="w-16 h-16 bg-[var(--card-glass)] border border-[var(--border-ui)] rounded-full flex items-center justify-center mx-auto mb-4 group-hover:border-indigo-400 group-hover:shadow-[0_0_15px_rgba(129,140,248,0.3)] transition-all">
                                        <svg class="w-6 h-6 text-[var(--text-secondary)] group-hover:text-indigo-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                    </div>
                                    <p class="font-bold text-lg">Input File</p>
                                    <p class="text-xs mono mt-2 opacity-50">SUPPORTED: IMG, XLSX, CSV, JSON</p>
                                </div>

                                <div id="file-info" class="hidden text-center animate-fade-in">
                                    <div class="w-16 h-16 bg-indigo-500/10 rounded-xl flex items-center justify-center mx-auto mb-3 text-indigo-400">
                                        <span id="file-ext-icon" class="font-black mono text-xl">FILE</span>
                                    </div>
                                    <p id="filename-display" class="font-mono text-sm font-bold text-[var(--text-main)] break-all px-4"></p>
                                    <p id="filesize-display" class="text-xs mono opacity-50 mt-1"></p>
                                    <p class="text-[10px] text-red-400 mt-2 cursor-pointer hover:underline" onclick="resetFile(event)">[ CANCELAR ]</p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3 opacity-50 pointer-events-none transition-opacity duration-300" id="config-section">
                            <label class="mono text-xs font-bold text-indigo-400 uppercase tracking-widest flex justify-between">
                                <span>02 // OUTPUT_FORMAT</span>
                                <span class="opacity-50 text-[10px] normal-case tracking-normal">Detectado Automaticamente</span>
                            </label>
                            
                            <div class="relative">
                                <select id="format-select" name="target_format" class="w-full bg-[var(--bg-color)] border border-[var(--border-ui)] rounded-xl py-4 pl-4 pr-10 font-mono text-sm focus:outline-none focus:border-indigo-400 focus:shadow-[0_0_15px_rgba(129,140,248,0.1)] transition-all text-[var(--text-main)] appearance-none cursor-pointer">
                                    <option value="" disabled selected>Selecione um arquivo primeiro...</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-[var(--text-secondary)]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit" id="submit-btn" disabled
                                class="w-full py-5 rounded-xl font-bold uppercase tracking-widest transition-all duration-300 flex items-center justify-center gap-3 group
                                disabled:opacity-50 disabled:cursor-not-allowed disabled:bg-[var(--border-ui)] disabled:text-[var(--text-secondary)]
                                enabled:bg-indigo-500 enabled:text-white enabled:hover:scale-[1.02] enabled:hover:shadow-[0_0_20px_rgba(99,102,241,0.4)]">
                                
                                <span id="btn-text">INITIATE TRANSFORMATION</span>
                                <svg id="btn-icon" class="w-5 h-5 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                
                                <svg id="btn-spinner" class="animate-spin h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        </div>

                        <div id="console-output" class="hidden mt-6 p-4 bg-black/40 rounded-lg border border-indigo-500/20 font-mono text-[10px] text-indigo-300 h-32 overflow-y-auto custom-scrollbar">
                            <p class="opacity-50">> System Ready...</p>
                        </div>

                    </form>
                </div>
            </div>
            
            <p class="text-center mono text-[10px] opacity-30 mt-8 max-w-lg mx-auto">
                NOTE: O suporte a formatos proprietários utiliza bibliotecas open-source e pode apresentar variações de formatação.
            </p>

        </div>
    </main>

    <?php include 'partial/footer.php'; ?>
    
    <script src="js/main.js"></script>

    <script>
        // --- Mapas de Conversão ---
        const conversionMap = {
            'image': {
                'label': 'Imagem (PNG/JPG/WEBP)',
                'formats': [
                    { val: 'png', text: 'Converter para PNG (Lossless)' },
                    { val: 'jpg', text: 'Converter para JPG (Otimizado)' },
                    { val: 'webp', text: 'Converter para WebP (Next-Gen)' }
                ]
            },
            'spreadsheet': {
                'label': 'Planilha (XLSX/CSV)',
                'formats': [
                    { val: 'csv', text: 'Converter para CSV (Universal)' },
                    { val: 'json', text: 'Converter para JSON (API Ready)' },
                    { val: 'html', text: 'Converter para HTML Table' },
                    { val: 'xlsx', text: 'Converter para Excel (.xlsx)' }
                ]
            }
        };

        const dropZone = document.getElementById('drop-zone');
        const fileInput = document.getElementById('file-input');
        const uploadPlaceholder = document.getElementById('upload-placeholder');
        const fileInfo = document.getElementById('file-info');
        const filenameDisplay = document.getElementById('filename-display');
        const filesizeDisplay = document.getElementById('filesize-display');
        const fileExtIcon = document.getElementById('file-ext-icon');
        const configSection = document.getElementById('config-section');
        const formatSelect = document.getElementById('format-select');
        const submitBtn = document.getElementById('submit-btn');
        const toolCard = document.getElementById('tool-card');
        const form = document.getElementById('converter-form');
        const consoleOutput = document.getElementById('console-output');

        // Drag & Drop
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(e => dropZone.addEventListener(e, prevent, false));
        function prevent(e) { e.preventDefault(); e.stopPropagation(); }
        ['dragenter', 'dragover'].forEach(e => dropZone.classList.add('drag-over'));
        ['dragleave', 'drop'].forEach(e => dropZone.classList.remove('drag-over'));

        // --- MANIPULAÇÃO DE ARQUIVO E SINCRONIA ---
        dropZone.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            // Sincroniza o input file oculto com o que foi arrastado
            fileInput.files = files; 
            
            handleFiles(files);
        });

        fileInput.addEventListener('change', () => handleFiles(fileInput.files));

        function handleFiles(files) {
            if (files.length === 0) return;
            const file = files[0];
            const ext = file.name.split('.').pop().toLowerCase();
            let type = null;

            // Simple Mime Detection
            if (['png','jpg','jpeg','webp','bmp'].includes(ext)) type = 'image';
            else if (['xlsx','xls','csv','json'].includes(ext)) type = 'spreadsheet';

            if (!type) {
                alert('Nesta versão Beta, suportamos apenas Imagens e Planilhas (CSV/Excel).');
                resetFile();
                return;
            }

            // Update UI
            uploadPlaceholder.classList.add('hidden');
            fileInfo.classList.remove('hidden');
            filenameDisplay.textContent = file.name;
            filesizeDisplay.textContent = (file.size / 1024 / 1024).toFixed(2) + ' MB';
            fileExtIcon.textContent = ext.toUpperCase();
            
            // Populate Select
            formatSelect.innerHTML = '<option value="" disabled selected>Escolha o formato de destino...</option>';
            conversionMap[type].formats.forEach(fmt => {
                if (fmt.val !== ext) { 
                    const opt = document.createElement('option');
                    opt.value = fmt.val;
                    opt.textContent = fmt.text;
                    formatSelect.appendChild(opt);
                }
            });

            configSection.classList.remove('opacity-50', 'pointer-events-none');
            configSection.classList.add('opacity-100');
            
            logToConsole(`> File loaded: ${file.name}`);
        }

        formatSelect.addEventListener('change', () => {
            if(formatSelect.value) submitBtn.disabled = false;
        });

        function resetFile(e) {
            if(e) e.preventDefault();
            fileInput.value = '';
            uploadPlaceholder.classList.remove('hidden');
            fileInfo.classList.add('hidden');
            configSection.classList.add('opacity-50', 'pointer-events-none');
            submitBtn.disabled = true;
            formatSelect.innerHTML = '<option value="" disabled selected>Selecione um arquivo primeiro...</option>';
            
            consoleOutput.classList.add('hidden');
            consoleOutput.innerHTML = '<p class="opacity-50">> System Ready...</p>';
            
            // Reset Button Style
            submitBtn.classList.remove('bg-green-500', 'text-white', 'hover:bg-green-600');
            submitBtn.classList.add('enabled:bg-indigo-500', 'enabled:text-white');
            document.getElementById('btn-text').textContent = 'INITIATE TRANSFORMATION';
            document.getElementById('btn-icon').classList.remove('hidden');
            document.getElementById('btn-icon').innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>';
        }

        function logToConsole(message, type = 'info') {
            consoleOutput.classList.remove('hidden');
            const p = document.createElement('p');
            p.textContent = message;
            if (type === 'error') p.classList.add('text-red-400');
            else if (type === 'success') p.classList.add('text-green-400');
            
            consoleOutput.appendChild(p);
            consoleOutput.scrollTop = consoleOutput.scrollHeight;
        }

        // --- CONEXÃO COM BACKEND PYTHON ---
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            toolCard.classList.add('processing-pulse');
            submitBtn.disabled = true;
            document.getElementById('btn-text').textContent = 'TRANSCODING...';
            document.getElementById('btn-icon').classList.add('hidden');
            document.getElementById('btn-spinner').classList.remove('hidden');

            const formData = new FormData();
            // Verifica se o arquivo existe antes de enviar
            if (fileInput.files.length === 0) {
                 logToConsole("> ERROR: Nenhum arquivo selecionado no input interno.", 'error');
                 toolCard.classList.remove('processing-pulse');
                 submitBtn.disabled = false;
                 return;
            }

            formData.append('file', fileInput.files[0]);
            formData.append('target_format', formatSelect.value);
            formData.append('tool_type', 'converter');

            try {
                logToConsole("> Uploading stream to engine...");

                const response = await fetch('api/process.php', {
                    method: 'POST',
                    body: formData
                });

                if (!response.ok) throw new Error(`HTTP Error: ${response.status}`);
                
                const result = await response.json();

                if (result.status === 'success') {
                    logToConsole("> Transformation complete.", 'success');
                    finishProcess(result.download_url);
                } else {
                    throw new Error(result.message || "Unknown error.");
                }

            } catch (error) {
                console.error(error);
                logToConsole(`> ERROR: ${error.message}`, 'error');
                
                toolCard.classList.remove('processing-pulse');
                submitBtn.disabled = false;
                document.getElementById('btn-text').textContent = 'TRY AGAIN';
                document.getElementById('btn-spinner').classList.add('hidden');
            }
        });

        function finishProcess(downloadUrl) {
            toolCard.classList.remove('processing-pulse');
            
            const btn = submitBtn;
            btn.disabled = false;
            
            // Estilo Sucesso
            btn.classList.remove('enabled:bg-indigo-500', 'enabled:text-white');
            btn.classList.add('bg-green-500', 'text-white', 'hover:bg-green-600');
            
            document.getElementById('btn-text').textContent = 'DOWNLOAD FILE';
            document.getElementById('btn-spinner').classList.add('hidden');
            
            // Icone Download
            const icon = document.getElementById('btn-icon');
            icon.classList.remove('hidden');
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0L8 8m4-4v12"></path>';

            btn.onclick = (e) => {
                e.preventDefault();
                window.location.href = downloadUrl;
            };
            
            logToConsole("> Link generated successfully.", 'success');
        }
    </script>
</body>
</html>