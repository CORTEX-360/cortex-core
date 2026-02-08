<?php
$BASE = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
if ($BASE === '/' || $BASE === '\\') $BASE = '';
require_once __DIR__ . '/api/metricas_acesso.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicons (assets/) -->
    <link rel="icon" href="<?= htmlspecialchars($BASE, ENT_QUOTES, 'UTF-8') ?>/assets/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= htmlspecialchars($BASE, ENT_QUOTES, 'UTF-8') ?>/assets/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= htmlspecialchars($BASE, ENT_QUOTES, 'UTF-8') ?>/assets/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= htmlspecialchars($BASE, ENT_QUOTES, 'UTF-8') ?>/assets/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="<?= htmlspecialchars($BASE, ENT_QUOTES, 'UTF-8') ?>/assets/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="<?= htmlspecialchars($BASE, ENT_QUOTES, 'UTF-8') ?>/assets/android-chrome-512x512.png">
    <title>CORTEX 360 | Automação & BI de Alta Performance</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=JetBrains+Mono:wght@400;700&family=Outfit:wght@700;900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="overflow-x-hidden">

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

    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
      <div class="bg-glow absolute -top-24 -left-24"></div>
      <div class="bg-glow absolute bottom-[20%] -right-24"
           style="background: radial-gradient(circle, #818CF8 0%, transparent 70%);">
      </div>
    </div>

    <?php include 'partial/navbar.php'; ?>

    <section class="relative min-h-screen flex items-center justify-center pt-28 sm:pt-32 md:pt-40 px-4 sm:px-6">
        <div class="max-w-5xl text-center relative">
            <div class="mono text-[9px] sm:text-[10px] text-[var(--accent-cyan)] mb-6 tracking-[0.35em] sm:tracking-[0.5em] uppercase font-bold">
                [ Advanced BI & Hyper-Automation ]
            </div>
            <h1 class="title-font text-4xl sm:text-5xl md:text-8xl font-black leading-tight mb-8">
                Inteligência que <span class="gradient-text">Conecta</span>,<br>
                Automação que <span class="gradient-text">Escala</span>.
            </h1>
            <p class="text-base sm:text-lg md:text-xl max-w-2xl mx-auto mb-10 sm:mb-12 opacity-80" style="color: var(--text-secondary)">
                Desenvolvemos arquiteturas de dados e ecossistemas de automação para empresas que buscam 
                decisões baseadas em fatos, não em intuição.
            </p>
            <div class="flex flex-col md:flex-row gap-4 justify-center">
                <a href="#labs" class="bg-[var(--accent-cyan)] btn-primary text-slate-900 w-full sm:w-auto px-8 sm:px-10 py-4 sm:py-5 rounded-xl font-bold text-base sm:text-lg hover:scale-105 transition-all shadow-xl shadow-cyan-500/20">
                    Explorar Labs
                </a>
                <a href="#tecnologias" class="glass w-full sm:w-auto px-8 sm:px-10 py-4 sm:py-5 rounded-xl font-bold text-base sm:text-lg hover:bg-[var(--text-main)] hover:text-[var(--bg-color)] transition-all">
                    Nossa Stack
                </a>
            </div>
        </div>
    </section>

    <section id="tecnologias" class="py-20 sm:py-24 px-4 sm:px-6 md:px-20">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12 items-center">
            <div class="space-y-4">
                <div class="text-4xl font-black title-font mb-6">Nossa <span style="color: var(--accent-cyan)">Stack</span></div>
                <p style="color: var(--text-secondary)" class="text-sm leading-relaxed">
                    Não usamos ferramentas prontas para problemas únicos.
                    Construímos soluções sob medida com tecnologias de elite.
                </p>
            </div>
            <div class="md:col-span-2 grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4 mono text-[10px]">
                <div class="glass p-6 text-center rounded-2xl glow-hover transition cursor-default">PYTHON / FASTAPI</div>
                <div class="glass p-6 text-center rounded-2xl glow-hover transition cursor-default">N8N / DOCKER</div>
                <div class="glass p-6 text-center rounded-2xl glow-hover transition cursor-default">SQL / POSTGRES</div>
                <div class="glass p-6 text-center rounded-2xl glow-hover transition cursor-default">LLM / RAG</div>
                <div class="glass p-6 text-center rounded-2xl glow-hover transition cursor-default">STREAMLIT / BI</div>
                <div class="glass p-6 text-center rounded-2xl glow-hover transition cursor-default">PANDAS / NUMPY</div>
                <div class="glass p-6 text-center rounded-2xl glow-hover transition cursor-default">LINUX DEBIAN 13</div>
                <div class="glass p-6 text-center rounded-2xl glow-hover transition cursor-default">TAILWIND / JS</div>
            </div>
        </div>
    </section>

    <section id="labs" class="py-24 sm:py-32 px-4 sm:px-6 md:px-20 relative">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
            <div class="max-w-xl">
                <span class="mono text-[var(--accent-cyan)] text-xs uppercase tracking-widest font-bold">/ Portfólio Técnico</span>
                <h2 class="text-3xl sm:text-5xl font-black title-font mt-4 uppercase">Cortex <span class="gradient-text">Labs</span></h2>
                <p class="mt-4 opacity-70" style="color: var(--text-secondary)">Amostras de tecnologias implementadas em ambientes de alta complexidade.</p>
            </div>
            <a href="#" class="mono text-xs underline hover:text-[var(--accent-cyan)] opacity-50 cursor-not-allowed" title="Repositório Privado">VER REPOSITÓRIO COMPLETO</a>
        </div>

        <div class="flex justify-center">
            <div class="glass p-1 rounded-[2.5rem] glow-hover transition-all group overflow-hidden w-full max-w-2xl">
                <a href="bi-alem-do-bi.php" class="p-7 sm:p-10 h-full flex flex-col justify-between block hover:no-underline">
                    <div>
                        <div class="flex justify-between items-start mb-12">
                            <div class="w-16 h-16 bg-cyan-500/10 rounded-2xl flex items-center justify-center text-cyan-400 group-hover:bg-cyan-400 group-hover:text-slate-900 transition-colors">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            </div>
                        </div>
                        <h3 class="text-3xl font-bold mb-4">BI muito além do BI</h3>
                        <p style="color: var(--text-secondary)" class="text-sm leading-relaxed mb-8">
                            Dashboard interativo para monitoramento de investimentos em expansão de rede, integrando dados de campo e orçamentários.
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="tech-tag px-4 py-1.5 rounded-full text-[10px] mono font-bold">Python</span>
                        <span class="tech-tag px-4 py-1.5 rounded-full text-[10px] mono font-bold">PostgreSQL</span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <section id="tools" class="py-20 sm:py-24 px-4 sm:px-6 md:px-20 relative overflow-hidden">
        <div class="bg-glow left-[50%] top-[20%] translate-x-[-50%]" style="width: 300px; height: 300px; opacity: 0.1;"></div>

        <div class="text-center mb-16 relative z-10">
            <span class="mono text-[var(--accent-cyan)] text-xs uppercase tracking-widest font-bold">/ Utilities</span>
            <h2 class="title-font text-4xl md:text-5xl font-black mt-4 mb-4">
                Aplicações <span class="gradient-text">Gratuitas</span>
            </h2>
            <p style="color: var(--text-secondary)" class="max-w-2xl mx-auto">
                Ferramentas úteis desenvolvidas internamente para otimizar seu dia a dia. 
                Sem custo, sem anúncios, apenas código funcional.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8 max-w-4xl mx-auto relative z-10">
            <a href="tools_pdf.php" class="glass p-6 sm:p-8 rounded-[2rem] hover:border-[var(--accent-cyan)] transition-all group relative overflow-hidden hover:-translate-y-1">
                <div class="w-14 h-14 bg-red-500/10 rounded-2xl flex items-center justify-center text-red-400 mb-6 group-hover:bg-red-500 group-hover:text-white transition-colors">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h3 class="text-2xl font-bold mb-2">Separador de PDF</h3>
                <p style="color: var(--text-secondary)" class="text-sm leading-relaxed">
                    Extraia páginas específicas de documentos PDF volumosos de forma instantânea e segura, sem subir seus dados para servidores desconhecidos.
                </p>
                <div class="mt-6 flex items-center gap-2 text-[var(--accent-cyan)] text-xs font-bold uppercase tracking-wider opacity-0 group-hover:opacity-100 transition-opacity">
                    Acessar Ferramenta ->
                </div>
            </a>
            
            <a href="tools_converter.php" class="glass p-6 sm:p-8 rounded-[2rem] hover:border-[var(--accent-cyan)] transition-all group relative overflow-hidden hover:-translate-y-1">
                <div class="w-14 h-14 bg-blue-500/10 rounded-2xl flex items-center justify-center text-blue-400 mb-6 group-hover:bg-blue-500 group-hover:text-white transition-colors">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                </div>
                <h3 class="text-2xl font-bold mb-2">Conversor Universal</h3>
                <p style="color: var(--text-secondary)" class="text-sm leading-relaxed">
                    Transforme imagens, documentos e planilhas entre diferentes formatos (PNG, JPG, PDF, XLSX) com um clique.
                </p>
                <div class="mt-6 flex items-center gap-2 text-[var(--accent-cyan)] text-xs font-bold uppercase tracking-wider opacity-0 group-hover:opacity-100 transition-opacity">
                    Acessar Ferramenta ->
                </div>
            </a>
        </div>
    </section>

    <section id="parceiros" class="py-24 sm:py-32 px-4 sm:px-6 md:px-20 relative">
        <div class="text-center mb-24">
            <h2 class="title-font text-3xl sm:text-5xl font-black uppercase mb-4">Parceiros do <span class="gradient-text">Projeto</span></h2>
            <p style="color: var(--text-secondary)" class="max-w-xl mx-auto italic">Engenharia de telecomunicações e inovação em saneamento unidas em um só propósito.</p>
        </div>

        <div class="flex flex-col md:flex-row justify-center gap-10 sm:gap-16">
            <div class="glass p-8 sm:p-12 rounded-[3.5rem] text-center max-w-sm hover:-translate-y-2 transition-transform relative group">
                <div class="w-32 h-32 sm:w-40 sm:h-40 bg-slate-800 rounded-full mx-auto mb-8 sm:mb-10 border-4 border-cyan-400/20 p-1 group-hover:border-cyan-400 transition-colors">
                    <img src="<?= htmlspecialchars($BASE, ENT_QUOTES, 'UTF-8') ?>/assets/heraldo.jpg" class="rounded-full w-full h-full object-cover" alt="Heraldo" onerror="this.onerror=null;this.src='<?= htmlspecialchars($BASE, ENT_QUOTES, 'UTF-8') ?>/assets/heraldo.jpeg';">
                </div>
                <h3 class="text-2xl font-black title-font mb-2">Heraldo <span class="text-cyan-400">.</span></h3>
                <p class="mono text-[10px] uppercase text-cyan-400 mb-8 tracking-widest font-bold">Senior Tech Engineer</p>
                <p style="color: var(--text-secondary)" class="text-sm leading-relaxed mb-10">
                    Especialista em infraestrutura crítica e arquitetura de dados em larga escala.
                </p>
                <a href="heraldo.php" class="mono text-[10px] border border-cyan-400/30 px-8 py-3 rounded-full hover:bg-cyan-400 hover:text-slate-900 transition font-bold uppercase">Ver_Perfil</a>
            </div>

            <div class="glass p-8 sm:p-12 rounded-[3.5rem] text-center max-w-sm hover:-translate-y-2 transition-transform relative group">
                <div class="w-32 h-32 sm:w-40 sm:h-40 bg-slate-800 rounded-full mx-auto mb-8 sm:mb-10 border-4 border-indigo-400/20 p-1 group-hover:border-indigo-400 transition-colors">
                    <img src="<?= htmlspecialchars($BASE, ENT_QUOTES, 'UTF-8') ?>/assets/vinicius.jpg" class="rounded-full w-full h-full object-cover" alt="Vinicius" onerror="this.onerror=null;this.src='<?= htmlspecialchars($BASE, ENT_QUOTES, 'UTF-8') ?>/assets/vinicius.JPG';">
                </div>
                <h3 class="text-2xl font-black title-font mb-2">Vinicius <span class="text-indigo-400">_</span></h3>
                <p class="mono text-[10px] uppercase text-indigo-400 mb-8 tracking-widest font-bold">Automation Developer</p>
                <p style="color: var(--text-secondary)" class="text-sm leading-relaxed mb-10">
                    Expert em automação de fluxos corporativos e integração de inteligência artificial.
                </p>
                <a href="vinicius.php" class="mono text-[10px] border border-indigo-400/30 px-8 py-3 rounded-full hover:bg-indigo-400 hover:text-white transition font-bold uppercase">Ver_Perfil</a>
            </div>
        </div>
    </section>

    <?php include 'partial/footer.php'; ?>

    <script src="js/main.js"></script>
</body>
</html>