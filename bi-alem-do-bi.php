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

    <link rel="icon" href="<?= htmlspecialchars($BASE, ENT_QUOTES, 'UTF-8') ?>/assets/favicon.ico">
    <title>BI Além do Dashboard | CORTEX 360</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=JetBrains+Mono:wght@400;700&family=Outfit:wght@700;900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="css/style.css">
    
    <style>
        /* Card estilo IDE/Terminal - Mantém escuro mesmo no light mode para contraste */
        .code-card {
            background-color: #0f172a; 
            border: 1px solid rgba(255,255,255,0.1);
            box-shadow: 0 0 20px rgba(0,0,0,0.5);
            color: #e2e8f0;
        }
    </style>
</head>
<body class="overflow-x-hidden antialiased transition-colors duration-300">

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

    <div class="bg-glow top-[-100px] left-[-100px] pointer-events-none -z-10"></div>
    <div class="bg-glow top-[40%] right-[-150px] pointer-events-none -z-10" style="background: radial-gradient(circle, #06b6d4 0%, transparent 70%); opacity: 0.15;"></div>

    <?php include 'partial/navbar.php'; ?>

    <section class="relative min-h-[80vh] flex items-center justify-center pt-40 px-6">
        <div class="max-w-5xl text-center relative z-10">
            <div class="mono text-[10px] text-[var(--accent-cyan)] mb-6 tracking-[0.5em] uppercase font-bold animate-pulse">
                [ Philosophy & Strategy ]
            </div>
            
            <h1 class="title-font text-5xl md:text-7xl font-black leading-tight mb-8" style="color: var(--text-main);">
                BI não é um <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600">Software</span>.<br>
                É uma <span class="gradient-text">Estratégia</span>.
            </h1>
            
            <p class="text-lg md:text-xl max-w-3xl mx-auto mb-12 opacity-80 leading-relaxed" style="color: var(--text-secondary);">
                O mercado vende dashboards coloridos como se fossem a solução final. 
                Nós acreditamos que a verdadeira inteligência acontece antes do gráfico: na engenharia do dado, 
                na performance da query e na arquitetura da informação.
            </p>
            
            <div class="flex justify-center">
                <a href="#falacia" class="glass px-10 py-4 rounded-full font-bold text-sm mono hover:bg-[var(--accent-cyan)] hover:text-slate-900 transition-all border border-white/10" style="color: var(--text-main);">
                    ENTENDA O CONCEITO ↓
                </a>
            </div>
        </div>
    </section>

    <section id="falacia" class="py-24 px-6 md:px-20 relative" style="background-color: var(--bg-card);">
        
        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-32 h-64 bg-purple-500/20 blur-[100px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 items-center relative z-10">
            
            <div class="space-y-8">
                <h2 class="text-3xl md:text-5xl font-black title-font" style="color: var(--text-main);">
                    A Falácia do <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-500">Low-Code</span>
                </h2>
                <div class="space-y-6 text-lg leading-relaxed" style="color: var(--text-secondary);">
                    <p>
                        Ferramentas de "arrastar e soltar" (como Power BI ou Tableau) são excelentes para prototipar, mas tornam-se âncoras financeiras quando você precisa escalar.
                    </p>
                    <p>
                        Quando a licença por usuário inviabiliza o projeto, ou quando o refresh dos dados leva horas, é hora de voltar à engenharia real. É hora do <strong>Code-First</strong>.
                    </p>
                    <ul class="space-y-4 mt-6 mono text-sm">
                        <li class="flex items-center gap-3">
                            <span class="text-[var(--accent-cyan)] font-bold text-lg">✓</span> Performance em Tempo Real (NRT)
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="text-[var(--accent-cyan)] font-bold text-lg">✓</span> Sem custos de licenciamento
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="text-[var(--accent-cyan)] font-bold text-lg">✓</span> Soberania total dos dados
                        </li>
                    </ul>
                </div>
            </div>

            <div class="relative group">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-600 to-cyan-600 rounded-2xl blur opacity-30 group-hover:opacity-75 transition duration-1000 group-hover:duration-200"></div>
                
                <div class="relative code-card p-8 rounded-2xl">
                    <div class="flex justify-between items-center mb-6 border-b border-white/10 pb-4">
                        <span class="mono text-xs text-slate-400">VS_COMPARISON.json</span>
                        <div class="flex gap-2">
                            <div class="w-3 h-3 rounded-full bg-red-500/50"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-500/50"></div>
                            <div class="w-3 h-3 rounded-full bg-green-500/50"></div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="p-4 bg-red-900/10 rounded-lg border border-red-500/20 flex justify-between items-center group/item">
                            <div>
                                <div class="font-bold text-red-400">Mercado Tradicional</div>
                                <div class="mono text-xs text-red-300/60 mt-1">Dashboards Lentos & Caros</div>
                            </div>
                            <span class="text-red-500 opacity-50 group-hover/item:opacity-100 transition">✕</span>
                        </div>

                        <div class="flex justify-center">
                            <svg class="w-6 h-6 text-slate-500 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                        </div>

                        <div class="p-5 bg-cyan-950/30 rounded-lg border border-cyan-500/30 flex justify-between items-center shadow-[0_0_15px_rgba(6,182,212,0.1)]">
                            <div>
                                <div class="font-bold text-cyan-400 flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse"></span>
                                    Abordagem Cortex
                                </div>
                                <div class="mono text-xs text-cyan-300/70 mt-1">High-Code & Performance</div>
                            </div>
                            <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section id="monitor" class="py-32 px-6 md:px-20 relative overflow-hidden">
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-[var(--accent-cyan)] opacity-5 blur-[120px] rounded-full pointer-events-none -z-10"></div>

        <div class="max-w-4xl mx-auto text-center relative z-10">
            <span class="mono text-[var(--accent-cyan)] text-xs uppercase tracking-widest font-bold">/ Lab 01: Telemetria</span>
            <h2 class="title-font text-4xl md:text-5xl font-black mt-6 mb-8" style="color: var(--text-main);">
                Prova de Conceito: <br>Monitoramento <span class="gradient-text">NRT</span>
            </h2>
            <p class="text-lg mb-12 max-w-2xl mx-auto" style="color: var(--text-secondary);">
                Para provar nosso ponto, não usamos Google Analytics neste site.
                Desenvolvemos nossa própria API de telemetria usando PHP puro e arquivos JSON.
                Sem cookies invasivos. Sem peso extra. 
            </p>

            <div class="glass p-1 rounded-[2.5rem] glow-hover transition-all group inline-block w-full max-w-3xl border border-white/10">
                <div class="p-10 md:p-14 flex flex-col items-center justify-center rounded-[2.2rem]" style="background-color: var(--bg-card);">
                    
                    <div class="w-20 h-20 bg-cyan-500/10 rounded-full flex items-center justify-center text-cyan-400 mb-8 animate-pulse border border-cyan-500/20">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>

                    <h3 class="text-2xl font-bold mb-2" style="color: var(--text-main);">Acesse o Dashboard Live</h3>
                    <p class="text-sm mb-8 font-mono" style="color: var(--text-secondary);">Veja os dados de acesso deste servidor agora.</p>

                    <a href="metrics.php" class="bg-[var(--accent-cyan)] btn-primary text-slate-900 px-12 py-4 rounded-xl font-bold text-lg hover:scale-105 transition-all shadow-xl shadow-cyan-500/20 flex items-center gap-3">
                        <span class="relative flex h-3 w-3">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-slate-900 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-3 w-3 bg-slate-800"></span>
                        </span>
                        Abrir Dashboard (metrics.php)
                    </a>

                    <div class="mt-8 grid grid-cols-3 gap-4 w-full max-w-md border-t border-white/5 pt-6">
                        <div class="text-center">
                            <div class="mono text-[10px] uppercase opacity-50" style="color: var(--text-secondary);">Stack</div>
                            <div class="font-bold text-cyan-400 text-sm">PHP 8.x</div>
                        </div>
                        <div class="text-center border-l border-white/5">
                            <div class="mono text-[10px] uppercase opacity-50" style="color: var(--text-secondary);">Database</div>
                            <div class="font-bold text-cyan-400 text-sm">JSON Flat</div>
                        </div>
                        <div class="text-center border-l border-white/5">
                            <div class="mono text-[10px] uppercase opacity-50" style="color: var(--text-secondary);">Front</div>
                            <div class="font-bold text-cyan-400 text-sm">Chart.JS</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'partial/footer.php'; ?>
    <script src="js/main.js"></script>

</body>
</html>