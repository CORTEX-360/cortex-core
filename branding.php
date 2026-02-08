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
    <title>Brandbook Visual | CORTEX 360</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;800&family=JetBrains+Mono:wght@400;700&family=Outfit:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #0F172A;
            --text-main: #F8FAFC;
            --text-secondary: #94A3B8;
            --accent-cyan: #22D3EE;
            --card-glass: rgba(30, 41, 59, 0.6);
            --border-ui: rgba(148, 163, 184, 0.1);
            --grid-color: rgba(34, 211, 238, 0.05);
            --glow-opacity: 0.3;
        }

        body.light-mode {
            --bg-color: #F8FAFC;
            --text-main: #0F172A;
            --text-secondary: #475569;
            --accent-cyan: #0891B2; /* Cyan mais escuro para contraste no claro */
            --card-glass: rgba(255, 255, 255, 0.7);
            --border-ui: rgba(15, 23, 42, 0.1);
            --grid-color: rgba(8, 145, 178, 0.08);
            --glow-opacity: 0.15;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-main);
            font-family: 'Inter', sans-serif;
            background-image: 
                linear-gradient(var(--grid-color) 1px, transparent 1px),
                linear-gradient(90deg, var(--grid-color) 1px, transparent 1px);
            background-size: 50px 50px;
            transition: background-color 0.4s ease, color 0.4s ease;
        }

        .title-font { font-family: 'Outfit', sans-serif; }
        .mono-font { font-family: 'JetBrains Mono', monospace; }

        .glow-cyan {
            box-shadow: 0 0 20px rgba(34, 211, 238, var(--glow-opacity));
        }

        .card-glass {
            background: var(--card-glass);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border-ui);
            border-radius: 1.5rem;
            transition: background 0.4s ease, border 0.4s ease;
        }

        .gradient-border {
            position: relative;
            border-radius: 1.5rem;
            padding: 1px;
            background: linear-gradient(135deg, var(--accent-cyan), transparent, rgba(129, 140, 248, 0.5));
        }

        .inner-content {
            background: var(--bg-color);
            border-radius: calc(1.5rem - 1px);
            transition: background 0.4s ease;
        }

        .color-swatch {
            transition: transform 0.3s ease;
        }
        .color-swatch:hover {
            transform: translateY(-5px);
        }

        @keyframes pulse-glow {
            0%, 100% { opacity: 0.4; }
            50% { opacity: 0.7; }
        }

        .bg-glow {
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, var(--accent-cyan) 0%, transparent 70%);
            border-radius: 50%;
            filter: blur(40px);
            z-index: -1;
            animation: pulse-glow 4s infinite ease-in-out;
            opacity: var(--glow-opacity);
        }

        /* Toggle Button Styles */
        #theme-toggle {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        #theme-toggle:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body class="min-h-screen py-12 px-6">

    <div class="max-w-5xl mx-auto relative">
        <div class="bg-glow -top-20 -left-20"></div>
        <div class="bg-glow top-1/2 -right-20" style="animation-delay: 2s;"></div>

        <!-- Floating Theme Toggle -->
        <div class="fixed top-8 right-8 z-50">
            <button id="theme-toggle" class="card-glass p-3 flex items-center gap-2 group">
                <span id="toggle-icon" class="text-xl">🌙</span>
                <span class="mono-font text-[10px] font-bold tracking-widest uppercase hidden md:inline">ALTERAR TEMA</span>
            </button>
        </div>

        <!-- Header -->
        <header class="mb-20 text-center">
            <div class="inline-block mono-font text-xs tracking-[0.3em] text-[var(--accent-cyan)] mb-4 border border-[var(--accent-cyan)] border-opacity-30 px-4 py-1 rounded-full bg-[var(--accent-cyan)] bg-opacity-5">
                INTERNAL BRAND GUIDELINES
            </div>
            <h1 class="title-font text-6xl md:text-8xl font-black tracking-tighter mb-4">
                CORTEX<span style="color: var(--accent-cyan)">360</span>
            </h1>
            <p style="color: var(--text-secondary)" class="text-xl max-w-2xl mx-auto">
                Intelligence that connects, Automation that scales.
            </p>
        </header>

        <!-- Concept -->
        <section class="mb-24">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <div class="card-glass p-10">
                    <h2 class="title-font text-3xl font-bold mb-6 flex items-center gap-3">
                        <span class="w-2 h-8 rounded-full" style="background-color: var(--accent-cyan)"></span>
                        O Conceito
                    </h2>
                    <p style="color: var(--text-secondary)" class="leading-relaxed mb-6">
                        A <span style="color: var(--text-main)" class="font-bold underline decoration-[var(--accent-cyan)] decoration-opacity-50">CORTEX 360</span> é o ponto de encontro entre o processamento neural (Inteligência/BI) e a execução periférica (Automação). 
                    </p>
                    <p style="color: var(--text-secondary)" class="leading-relaxed italic">
                        O "360" representa a visão holística do dado: da extração à decisão automatizada.
                    </p>
                </div>
                <div class="flex justify-center">
                    <div class="relative w-64 h-64 border-2 border-[var(--accent-cyan)] border-opacity-20 rounded-full flex items-center justify-center animate-[spin_20s_linear_infinite]">
                        <div class="absolute -top-3 left-1/2 -translate-x-1/2 w-6 h-6 rounded-full glow-cyan" style="background-color: var(--accent-cyan)"></div>
                        <div class="w-48 h-48 border border-[var(--text-main)] border-opacity-10 rounded-full flex items-center justify-center animate-[spin_10s_linear_infinite_reverse]">
                            <div style="color: var(--accent-cyan)" class="mono-font text-[10px] font-bold">DATA_FLOW</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Paleta de Cores -->
        <section class="mb-24">
            <h2 class="title-font text-3xl font-bold mb-10">Paleta de Cores</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <!-- Color 1 -->
                <div class="color-swatch flex flex-col gap-3">
                    <div class="h-40 rounded-3xl bg-[#0F172A] border border-white/10 flex items-end p-4">
                        <span class="mono-font text-xs font-bold text-white/50">#0F172A</span>
                    </div>
                    <div class="px-2">
                        <h3 class="font-bold text-sm">Deep Space</h3>
                        <p style="color: var(--text-secondary)" class="text-xs">Base Principal</p>
                    </div>
                </div>
                <!-- Color 2 -->
                <div class="color-swatch flex flex-col gap-3">
                    <div class="h-40 rounded-3xl bg-[#22D3EE] shadow-[0_0_20px_rgba(34,211,238,0.4)] flex items-end p-4">
                        <span class="mono-font text-xs font-bold text-slate-900">#22D3EE</span>
                    </div>
                    <div class="px-2">
                        <h3 class="font-bold text-sm">Electric Cyan</h3>
                        <p style="color: var(--text-secondary)" class="text-xs">Ação & Identidade</p>
                    </div>
                </div>
                <!-- Color 3 -->
                <div class="color-swatch flex flex-col gap-3">
                    <div class="h-40 rounded-3xl bg-[#94A3B8] flex items-end p-4">
                        <span class="mono-font text-xs font-bold text-slate-900">#94A3B8</span>
                    </div>
                    <div class="px-2">
                        <h3 class="font-bold text-sm">Neural Silver</h3>
                        <p style="color: var(--text-secondary)" class="text-xs">Texto Secundário</p>
                    </div>
                </div>
                <!-- Color 4 -->
                <div class="color-swatch flex flex-col gap-3">
                    <div class="h-40 rounded-3xl bg-[#F8FAFC] border border-slate-200 flex items-end p-4">
                        <span class="mono-font text-xs font-bold text-slate-900">#F8FAFC</span>
                    </div>
                    <div class="px-2">
                        <h3 class="font-bold text-sm">Main White</h3>
                        <p style="color: var(--text-secondary)" class="text-xs">Base Versão Light</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tipografia e Tom -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-24">
            <!-- Typography -->
            <div>
                <h2 class="title-font text-3xl font-bold mb-8">Tipografia</h2>
                <div class="space-y-8">
                    <div class="card-glass p-6">
                        <p style="color: var(--accent-cyan)" class="text-xs mono-font mb-2 uppercase">TITLES: OUTFIT / INTER BOLD</p>
                        <p class="title-font text-4xl font-black">THE CORE ARCHITECTURE</p>
                    </div>
                    <div class="card-glass p-6">
                        <p style="color: var(--accent-cyan)" class="text-xs mono-font mb-2 uppercase">BODY: JETBRAINS MONO</p>
                        <p style="color: var(--text-secondary)" class="mono-font text-sm leading-relaxed">
                            function deployIntelligence() {<br>
                            &nbsp;&nbsp;const status = "Cortex 360 Active";<br>
                            &nbsp;&nbsp;return scale_automation(status);<br>
                            }
                        </p>
                    </div>
                </div>
            </div>

            <!-- Tone of Voice -->
            <div>
                <h2 class="title-font text-3xl font-bold mb-8">Tom de Voz</h2>
                <div class="gradient-border">
                    <div class="inner-content p-8 space-y-6">
                        <div class="flex gap-4">
                            <div style="color: var(--accent-cyan); background-color: rgba(34, 211, 238, 0.1);" class="w-10 h-10 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold">Técnico & Acessível</h4>
                                <p style="color: var(--text-secondary)" class="text-sm">Simplificamos a complexidade, eliminando a burocracia.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div style="color: var(--accent-cyan); background-color: rgba(34, 211, 238, 0.1);" class="w-10 h-10 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold">Foco Total em ROI</h4>
                                <p style="color: var(--text-secondary)" class="text-sm">O dado só tem valor se economizar tempo ou dinheiro.</p>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-[var(--text-secondary)] border-opacity-10">
                            <p style="color: var(--text-secondary)" class="mono-font text-xs text-center opacity-40 italic">
                                "Inteligência que conecta, Automação que escala."
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Elementos Gráficos -->
        <section class="mb-24">
            <h2 class="title-font text-3xl font-bold mb-10">Interface Elements</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="space-y-4">
                    <p style="color: var(--text-secondary)" class="text-xs mono-font uppercase">Buttons & States</p>
                    <button style="background-color: var(--accent-cyan)" class="w-full text-slate-900 font-bold py-4 rounded-xl glow-cyan hover:scale-105 transition-all">
                        DEPLOY PROJECT
                    </button>
                    <button style="color: var(--text-main); border: 1px solid var(--border-ui)" class="w-full font-bold py-4 rounded-xl card-glass hover:bg-opacity-80 transition-all">
                        SECONDARY ACTION
                    </button>
                </div>
                <div class="space-y-4">
                    <p style="color: var(--text-secondary)" class="text-xs mono-font uppercase">Progress / Data</p>
                    <div style="background-color: var(--border-ui)" class="w-full h-2 rounded-full overflow-hidden">
                        <div style="background-color: var(--accent-cyan)" class="h-full w-[75%] glow-cyan"></div>
                    </div>
                    <div style="color: var(--accent-cyan)" class="flex justify-between mono-font text-[10px] opacity-60">
                        <span>SYSTEM_READY</span>
                        <span>75% CPU</span>
                    </div>
                </div>
                <div class="space-y-4">
                    <p style="color: var(--text-secondary)" class="text-xs mono-font uppercase">Status Indicators</p>
                    <div class="flex gap-3">
                        <div style="background-color: var(--accent-cyan)" class="w-3 h-3 rounded-full glow-cyan"></div>
                        <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                        <div style="background-color: var(--text-secondary)" class="w-3 h-3 rounded-full opacity-30"></div>
                    </div>
                </div>
            </div>
        </section>

        <footer class="text-center pt-20 border-t border-[var(--border-ui)]">
            <p style="color: var(--text-secondary)" class="mono-font text-[10px] tracking-widest uppercase opacity-30">
                &copy; 2026 Cortex 360 // Infrastructure by Heraldo & Vinicius
            </p>
        </footer>
    </div>

    <script>
        const themeToggle = document.getElementById('theme-toggle');
        const body = document.body;
        const icon = document.getElementById('toggle-icon');

        themeToggle.addEventListener('click', () => {
            body.classList.toggle('light-mode');
            
            if (body.classList.contains('light-mode')) {
                icon.textContent = '☀️';
            } else {
                icon.textContent = '🌙';
            }
        });
    </script>
</body>
</html>