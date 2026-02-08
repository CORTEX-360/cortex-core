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

    <title>Vinicius | Sistemas & Infraestrutura - CORTEX 360</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=JetBrains+Mono:wght@400;700&family=Outfit:wght@700;900&display=swap" rel="stylesheet">

    <!-- ✅ CSS IDÊNTICO AO DO HERALDO (NÃO ALTERADO) -->
    <style>
        :root {
            --bg-color: #0F172A;
            --text-main: #F8FAFC;
            --text-secondary: #94A3B8;
            --accent-color: #22D3EE;
            --card-glass: rgba(30, 41, 59, 0.6);
            --border-ui: rgba(148, 163, 184, 0.1);
            --grid-color: rgba(34, 211, 238, 0.05);
            --glow-opacity: 0.15;
            --tech-tag-bg: rgba(34, 211, 238, 0.1);
        }

        body.light-mode {
            --bg-color: #F8FAFC;
            --text-main: #0F172A;
            --text-secondary: #475569;
            --accent-color: #0891B2;
            --card-glass: rgba(255, 255, 255, 0.8);
            --border-ui: rgba(15, 23, 42, 0.1);
            --grid-color: rgba(8, 145, 178, 0.08);
            --glow-opacity: 0.1;
            --tech-tag-bg: rgba(8, 145, 178, 0.1);
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
        .mono { font-family: 'JetBrains Mono', monospace; }

        .glass {
            background: var(--card-glass);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border-ui);
            transition: all 0.4s ease;
        }

        .gradient-text {
            background: linear-gradient(90deg, var(--accent-color), #818CF8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .bg-glow {
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, var(--accent-color) 0%, transparent 70%);
            border-radius: 50%;
            filter: blur(80px);
            z-index: -1;
            opacity: var(--glow-opacity);
            pointer-events: none;
        }

        .border-left-tech {
            border-left: 2px solid var(--border-ui);
            transition: border-color 0.3s;
        }
        .border-left-tech:hover {
            border-left-color: var(--accent-color);
        }

        .tech-tag {
            background-color: var(--tech-tag-bg);
            color: var(--accent-color);
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.7rem;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            border: 1px solid var(--border-ui);
            font-weight: 700;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-up { animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; }

        @media (max-width: 640px) {
            .bg-glow { width: 320px; height: 320px; filter: blur(50px); }
        }
    </style>
</head>

<body class="overflow-x-hidden min-h-screen">

    <div class="bg-glow top-[-150px] left-[-150px]"></div>
    <div class="bg-glow bottom-[20%] right-[-100px]" style="background: radial-gradient(circle, #818CF8 0%, transparent 70%);"></div>

    <nav class="w-full py-4 sm:py-6 px-4 sm:px-6 md:px-20 flex justify-between items-center absolute top-0 z-50">
        <a href="index.php" class="mono text-[10px] font-bold tracking-[0.2em] hover:text-[var(--accent-color)] transition uppercase">
            [ <- Voltar_Home ]
        </a>
        <div class="flex items-center gap-4">
            <div class="text-xl font-black title-font tracking-tighter">
                VINICIUS<span style="color: var(--accent-color)">.</span>
            </div>
            <button id="theme-toggle" class="glass p-2 rounded-full hover:scale-110 transition-all border-cyan-400/20">
                <span id="toggle-icon" class="text-sm">🌙</span>
            </button>
        </div>
    </nav>

    <main class="pt-28 sm:pt-32 pb-16 sm:pb-20 px-4 sm:px-6 md:px-20 max-w-7xl mx-auto">

        <!-- HERO (layout do Heraldo, dados do Vinícius) -->
        <header class="grid grid-cols-1 md:grid-cols-12 gap-10 md:gap-12 items-center mb-20 sm:mb-32 animate-up">
            <div class="md:col-span-8">
                <div class="flex flex-wrap gap-2 mb-6">
                    <span class="tech-tag">SISTEMAS</span>
                    <span class="tech-tag">INFRA & SERVIDORES</span>
                    <span class="tech-tag">AUTOMAÇÃO</span>
                </div>

                <h1 class="title-font text-4xl sm:text-5xl md:text-8xl font-black mb-6 leading-tight">
                    Vinicius <span class="gradient-text">Dev.</span>
                </h1>

                <p class="text-base sm:text-lg md:text-xl opacity-80 leading-relaxed max-w-3xl mb-8" style="color: var(--text-secondary)">
                    Profissional resiliente e multifacetado, focado na entrega de soluções técnicas e gerenciais alinhadas ao negócio.
                    <br><br>
                    Especialista em converter necessidades complexas em sistemas eficientes, escaláveis e centrados no usuário, com experiência
                    na implementação de tecnologias emergentes para otimização de processos e integração de fluxos em ambientes corporativos.
                </p>
            </div>

            <div class="md:col-span-4 relative group mx-auto md:mx-0">
                <div class="absolute inset-0 bg-[var(--accent-color)] blur-3xl opacity-20 group-hover:opacity-40 transition-opacity duration-700"></div>
                <div class="relative glass rounded-[3rem] overflow-hidden p-3 w-full max-w-xs mx-auto transform group-hover:scale-[1.02] transition-transform duration-500">
                    <img src="<?= htmlspecialchars($BASE, ENT_QUOTES, 'UTF-8') ?>/assets/vinicius.jpg"
                         alt="Vinicius"
                         class="w-full h-full object-cover rounded-[2.5rem]"
                         style="object-position: 50% 25%;"
                         onerror="this.onerror=null;this.src='<?= htmlspecialchars($BASE, ENT_QUOTES, 'UTF-8') ?>/assets/vinicius.JPG';">
                </div>
            </div>
        </header>

        <!-- Tech Arsenal (layout do Heraldo, dados do Vinícius) -->
        <section class="mb-20 sm:mb-32 animate-up" style="animation-delay: 0.2s;">
            <div class="flex items-end justify-between mb-12">
                <h2 class="title-font text-2xl sm:text-3xl font-bold">Tech Arsenal <span style="color: var(--accent-color)">.</span></h2>
                <span class="mono text-xs opacity-40 hidden md:inline">STACK ATUALIZADA 2026</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="glass p-8 rounded-3xl hover:border-[var(--accent-color)] transition-colors group">
                    <div class="w-12 h-12 bg-purple-500/10 rounded-2xl flex items-center justify-center text-purple-400 mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <h3 class="font-bold text-xl mb-4">Sistemas & Automação</h3>
                    <p class="text-sm opacity-60 mb-6 leading-relaxed">
                        Desenvolvimento e melhoria de sistemas internos, automações operacionais e otimização de rotinas, reduzindo trabalho manual e aumentando confiabilidade do fluxo.
                    </p>
                    <div class="flex flex-wrap gap-2">
                        <span class="tech-tag">Python</span>
                        <span class="tech-tag">SQL</span>
                        <span class="tech-tag">Workflows</span>
                    </div>
                </div>

                <div class="glass p-8 rounded-3xl hover:border-[var(--accent-color)] transition-colors group">
                    <div class="w-12 h-12 bg-cyan-500/10 rounded-2xl flex items-center justify-center text-cyan-400 mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <h3 class="font-bold text-xl mb-4">Infraestrutura & Servidores</h3>
                    <p class="text-sm opacity-60 mb-6 leading-relaxed">
                        Administração e sustentação de ambientes: manutenção preventiva/corretiva, monitoramento de disponibilidade e segurança, com foco em continuidade do negócio.
                    </p>
                    <div class="flex flex-wrap gap-2">
                        <span class="tech-tag">Windows Server</span>
                        <span class="tech-tag">Linux</span>
                        <span class="tech-tag">Redes</span>
                    </div>
                </div>

                <div class="glass p-8 rounded-3xl hover:border-[var(--accent-color)] transition-colors group">
                    <div class="w-12 h-12 bg-orange-500/10 rounded-2xl flex items-center justify-center text-orange-400 mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="font-bold text-xl mb-4">Deploy & Implantação</h3>
                    <p class="text-sm opacity-60 mb-6 leading-relaxed">
                        Implementação e arquitetura de sistemas: deploy, configuração e alinhamento de ferramentas às necessidades específicas do negócio e dos times.
                    </p>
                    <div class="flex flex-wrap gap-2">
                        <span class="tech-tag">Deploy</span>
                        <span class="tech-tag">Config</span>
                        <span class="tech-tag">Suporte</span>
                    </div>
                </div>

            </div>
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 animate-up" style="animation-delay: 0.4s;">

            <!-- Carreira & Projetos (layout do Heraldo) -->
            <div class="lg:col-span-8">
                <section>
                    <h2 class="mono text-[var(--accent-color)] text-sm uppercase tracking-[0.3em] mb-12 flex items-center gap-4">
                        / Carreira & Projetos
                    </h2>

                    <div class="space-y-12 relative">
                        <div class="absolute left-[7px] top-2 bottom-0 w-px bg-[var(--border-ui)]"></div>

                        <!-- ATUAL -->
                        <div class="pl-10 relative group">
                            <div class="absolute w-4 h-4 bg-[var(--accent-color)] rounded-full left-0 top-1.5 shadow-[0_0_15px_var(--accent-color)] z-10"></div>
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h3 class="text-2xl font-bold">Analista de Sistemas e Infraestrutura</h3>
                                    <p class="mono text-xs opacity-50 uppercase mt-1">COHIDRO PROJETOS EM ENG. (Subsidiária EMOP-RJ) // Jul-2025 - Atual</p>
                                </div>
                                <span class="tech-tag hidden md:inline-block">ATUAL</span>
                            </div>
                            <p style="color: var(--text-secondary)" class="text-sm leading-relaxed mb-4">
                                Modernização de ecossistemas tecnológicos, migração de tecnologias legadas para plataformas modernas, deploy e configuração de novos sistemas de gestão,
                                além de sustentação avançada de servidores com foco em disponibilidade, segurança e continuidade operacional.
                            </p>
                        </div>

                        <!-- PASSADO -->
                        <div class="pl-10 relative group">
                            <div class="absolute w-3 h-3 bg-[var(--border-ui)] rounded-full left-[2px] top-2 group-hover:bg-[var(--accent-color)] transition-colors z-10"></div>
                            <h3 class="text-xl font-bold mb-1">Sócio Executivo</h3>
                            <p class="mono text-xs opacity-50 uppercase mb-3">CAMALU ENTRETENIMENTOS // Jul-2016 - Jul-2021</p>
                            <p style="color: var(--text-secondary)" class="text-sm leading-relaxed">
                                Administração, personalização e manutenção de softwares para operação de eventos. Gestão de contratos e coordenação de equipes técnicas/operacionais,
                                com foco em entrega eficiente e melhoria da experiência do usuário final. Criação de artes e elementos digitais aplicando conceitos de interface.
                            </p>
                        </div>

                        <!-- PASSADO -->
                        <div class="pl-10 relative group">
                            <div class="absolute w-3 h-3 bg-[var(--border-ui)] rounded-full left-[2px] top-2 group-hover:bg-[var(--accent-color)] transition-colors z-10"></div>
                            <h3 class="text-xl font-bold mb-1">Analista de Sistemas e Suporte</h3>
                            <p class="mono text-xs opacity-50 uppercase mb-3">JAJ DISTRIBUIDORA E COMÉRCIO DE LIVROS // Fev-2006 - Fev-2016</p>
                            <p style="color: var(--text-secondary)" class="text-sm leading-relaxed">
                                Manutenção e otimização de ERP (estoque e compras), garantindo integridade dos dados e eficiência do fluxo. Administração e monitoramento de servidores Windows,
                                gestão de redes e suporte técnico avançado com soluções de acesso remoto seguro. Interface técnico-comercial para traduzir requisitos em melhorias funcionais.
                            </p>
                        </div>

                    </div>
                </section>
            </div>

            <!-- Sidebar (layout do Heraldo, dados do Vinícius) -->
            <aside class="lg:col-span-4 space-y-8">

                <div class="glass p-8 rounded-3xl border-t-2 border-[var(--accent-color)]">
                    <h3 class="mono text-xs uppercase tracking-widest mb-6 opacity-40">Hard_Skills</h3>
                    <div class="flex flex-wrap gap-2">
                        <span class="tech-tag">SQL</span>
                        <span class="tech-tag">BANCO DE DADOS</span>
                        <span class="tech-tag">SERVIDORES</span>
                        <span class="tech-tag">REDES</span>
                        <span class="tech-tag">ERP</span>
                        <span class="tech-tag">SUPORTE</span>
                        <span class="tech-tag">DEPLOY</span>
                        <span class="tech-tag">AUTOMAÇÃO</span>
                        <span class="tech-tag">SISTEMAS</span>
                    </div>
                </div>

                <div class="glass p-8 rounded-[2.5rem] border-[var(--accent-color)] border-opacity-20">
                  <h3 class="text-xl font-bold mb-6">Conexões</h3>
                  <div class="space-y-4">
                    <a href="#" class="flex items-center gap-4 group">
                      <div class="w-10 h-10 bg-indigo-500/10 rounded-xl flex items-center justify-center text-indigo-400 group-hover:bg-indigo-500 group-hover:text-white transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.761 0 5-2.239 5-5v-14c0-2.761-2.239-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                        </svg>
                      </div>
                      <span class="text-sm opacity-70 group-hover:opacity-100 transition">LinkedIn/vinicius</span>
                    </a>
                
                    <a href="#" class="flex items-center gap-4 group">
                      <div class="w-10 h-10 bg-slate-500/10 rounded-xl flex items-center justify-center text-slate-400 group-hover:bg-white group-hover:text-slate-900 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                        </svg>
                      </div>
                      <span class="text-sm opacity-70 group-hover:opacity-100 transition">GitHub/vinigit-dev</span>
                    </a>
                  </div>
                </div>
                
                <div class="glass p-8 rounded-[2.5rem] bg-indigo-500/5 border-indigo-500/20">
                  <p class="text-sm italic leading-relaxed text-[var(--text-secondary)]">
                    "Meu foco é transformar complexidade em eficiência através do código. Cada linha deve resolver um problema real de negócio."
                  </p>
                </div>

            </aside>
        </div>

        <!-- Formação e Cursos (layout do Heraldo, dados do Vinícius) -->
        <section class="mt-32 mb-16 animate-up" style="animation-delay: 0.6s;">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 border-t border-[var(--border-ui)] pt-12">

                <div>
                    <h3 class="mono text-[var(--accent-color)] text-xs uppercase tracking-widest mb-6 font-bold">/ Base_Acadêmica</h3>
                    <ul class="space-y-6">
                        <li>
                            <h4 class="text-lg font-bold">Bacharelado em Análise de Sistemas</h4>
                            <p style="color: var(--text-secondary)" class="text-sm">2014</p>
                            <p class="text-xs opacity-50 mt-1">Formação voltada para desenvolvimento, arquitetura e fundamentos de sistemas.</p>
                        </li>
                        <li>
                            <h4 class="text-lg font-bold">Superior em Gestão de Eventos</h4>
                            <p style="color: var(--text-secondary)" class="text-sm">2009</p>
                            <p class="text-xs opacity-50 mt-1">Base em organização, operações e gestão de projetos com foco em execução.</p>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="mono text-[var(--accent-color)] text-xs uppercase tracking-widest mb-6 font-bold">/ Educação_Contínua_&_Tech</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-4">
                        <div>
                            <h4 class="font-bold text-sm mb-1">Projetos de Sistemas</h4>
                            <p class="text-xs opacity-60">Modelagem, requisitos e planejamento de soluções.</p>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm mb-1">Administração de Banco de Dados</h4>
                            <p class="text-xs opacity-60">Gestão, manutenção e boas práticas de dados.</p>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm mb-1">Administração/Planejamento Financeiro (IFRS)</h4>
                            <p class="text-xs opacity-60">Visão de negócio aplicada à operação e gestão.</p>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm mb-1">FullStack em linguagem DEVOPS</h4>
                            <p class="text-xs opacity-60">Base prática para implantação e ciclo de vida do software.</p>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm mb-1">Planejamento Estratégico (ENAP)</h4>
                            <p class="text-xs opacity-60">Alinhamento estratégico e execução por metas.</p>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm mb-1">Inglês</h4>
                            <p class="text-xs opacity-60">Nível: Inglês (conforme currículo).</p>
                        </div>
                    </div>

                    <div class="mt-8 glass p-5 rounded-2xl">
                        <p class="text-xs opacity-70 leading-relaxed" style="color: var(--text-secondary)">
                            <b>Informações complementares:</b> CNH B • Disponibilidade para viagens.
                        </p>
                    </div>
                </div>

            </div>
        </section>

    </main>

    <footer class="py-12 border-t border-[var(--border-ui)] text-center">
        <p class="mono text-[10px] opacity-20 uppercase tracking-[0.4em]">
            Vinicius // CORTEX 360 // 2026
        </p>
    </footer>

    <script>
        const themeToggle = document.getElementById('theme-toggle');
        const body = document.body;
        const icon = document.getElementById('toggle-icon');

        if (localStorage.getItem('cortex_theme') === 'light') {
            body.classList.add('light-mode');
            icon.textContent = '☀️';
        }

        themeToggle.addEventListener('click', () => {
            body.classList.toggle('light-mode');
            const isLight = body.classList.contains('light-mode');
            localStorage.setItem('cortex_theme', isLight ? 'light' : 'dark');
            icon.textContent = isLight ? '☀️' : '🌙';
        });

        document.addEventListener('mousemove', (e) => {
            const glows = document.querySelectorAll('.bg-glow');
            const x = (e.clientX / window.innerWidth) - 0.5;
            const y = (e.clientY / window.innerHeight) - 0.5;

            glows.forEach((glow, index) => {
                const speed = (index + 1) * 30;
                glow.style.transform = `translate(${x * speed}px, ${y * speed}px)`;
            });
        });
    </script>
</body>
</html>
