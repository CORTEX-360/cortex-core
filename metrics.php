<!DOCTYPE html>
<html lang="pt-br" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CORTEX 360 | Inteligência Operacional</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root { --brand-primary: #6366f1; --brand-secondary: #0ea5e9; --bg-deep: #020617; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: var(--bg-deep); background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.02) 1px, transparent 0); background-size: 32px 32px; }
        .mono { font-family: 'JetBrains Mono', monospace; }
        .glass { background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.08); }
        .neon-border-indigo { border-bottom: 3px solid var(--brand-primary); box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.2); }
        .neon-border-emerald { border-bottom: 3px solid #10b981; box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.2); }
        .neon-border-rose { border-bottom: 3px solid #f43f5e; box-shadow: 0 10px 15px -3px rgba(244, 63, 94, 0.2); }
        .neon-border-blue { border-bottom: 3px solid var(--brand-secondary); box-shadow: 0 10px 15px -3px rgba(14, 165, 233, 0.2); }
        .chart-container { position: relative; height: 300px; width: 100%; }
        .status-dot { animation: pulse-glow 2s infinite; }
        @keyframes pulse-glow { 0%, 100% { opacity: 0.5; } 50% { opacity: 1; } }
    </style>
</head>
<body class="text-slate-200 antialiased min-h-screen p-4 md:p-8">

    <nav class="max-w-7xl mx-auto flex justify-between items-center mb-12">
        <div class="flex items-center gap-5">
            <div class="relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-indigo-600 to-blue-500 rounded-xl blur opacity-25 group-hover:opacity-100 transition duration-1000"></div>
                <div class="relative w-12 h-12 bg-slate-900 rounded-xl flex items-center justify-center border border-white/10">
                    <span class="text-white font-black text-2xl tracking-tighter">C</span>
                </div>
            </div>
            <div>
                <h1 class="text-2xl font-extrabold tracking-tight text-white uppercase italic">Cortex <span class="text-indigo-500">360</span></h1>
                <p class="text-[9px] text-indigo-400 font-bold uppercase tracking-[0.4em] leading-none">Automação & BI Intelligence</p>
            </div>
        </div>
        
        <div class="flex items-center gap-4">
            <a href="index.php" class="flex items-center gap-2 px-5 py-2 glass rounded-lg text-[10px] font-black uppercase tracking-widest text-slate-300 hover:bg-slate-800 transition-all border border-white/5">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Voltar ao Início
            </a>
            <button onclick="updateDashboard()" class="hidden md:block px-6 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-[10px] font-black uppercase tracking-widest rounded-lg transition-all shadow-lg shadow-indigo-600/20 active:scale-95">
                Sincronizar Dados
            </button>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto space-y-8">
        
        <header class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 border-l-4 border-indigo-600 pl-8">
            <div class="space-y-1">
                <h2 class="text-5xl font-black text-white tracking-tighter uppercase leading-none">Painel Operacional</h2>
                <p class="text-slate-500 text-sm font-medium italic tracking-wide">Monitoramento de tráfego de rede em tempo real para infraestrutura crítica.</p>
            </div>
            <div class="flex flex-col items-end">
                <p class="text-[9px] text-slate-500 font-bold uppercase tracking-widest mb-1 text-right">Última Transmissão do Nó</p>
                <p id="timestamp" class="mono text-indigo-400 text-sm font-bold bg-indigo-500/5 px-4 py-1 rounded-md border border-indigo-500/10 tracking-tighter">--/--/-- --:--:--</p>
            </div>
        </header>

        <section class="glass p-5 rounded-2xl border border-white/5 bg-gradient-to-r from-indigo-500/5 to-transparent">
            <div class="flex flex-col md:flex-row gap-6 items-center">
                <div class="flex-shrink-0 flex items-center gap-2 px-3 py-1.5 bg-indigo-500/10 border border-indigo-500/20 rounded-md">
                    <div class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></div>
                    <span class="mono text-[10px] font-bold text-indigo-400 uppercase tracking-tighter">System_Overview.v3</span>
                </div>
                <div class="h-px md:h-8 w-full md:w-px bg-white/10"></div>
                <p class="text-[11px] md:text-xs text-slate-400 leading-relaxed font-medium">
                    <strong class="text-slate-200">Arquitetura de Baixa Latência:</strong> Interface engine construída com 
                    <span class="text-indigo-400 font-bold">Vanilla JS</span> e <span class="text-indigo-400 font-bold">Tailwind CSS</span>. 
                    Solução otimizada para renderização <span class="italic">Edge-Computing</span> com telemetria via API nativa integrada ao core da <b>CORTEX 360</b>, garantindo performance máxima em monitoramento de ativos críticos.
                </p>
            </div>
        </section>

        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="glass p-6 rounded-2xl neon-border-blue transition-transform hover:-translate-y-1">
                <p class="text-slate-500 text-[10px] font-bold uppercase tracking-[0.2em]">Volume Total</p>
                <p id="kpi-total" class="text-4xl font-black mt-2 text-white">0</p>
                <p class="mt-4 text-[9px] text-slate-400 font-semibold uppercase">Status: <span class="text-blue-400">Processando</span></p>
            </div>

            <div class="glass p-6 rounded-2xl neon-border-emerald transition-transform hover:-translate-y-1">
                <p class="text-slate-500 text-[10px] font-bold uppercase tracking-[0.2em]">Disponibilidade</p>
                <p id="kpi-availability" class="text-4xl font-black mt-2 text-emerald-400">100%</p>
                <div class="mt-4 w-full bg-slate-800/50 h-1 rounded-full overflow-hidden">
                    <div id="availability-bar" class="bg-emerald-500 h-full transition-all duration-1000" style="width: 100%"></div>
                </div>
            </div>

            <div class="glass p-6 rounded-2xl neon-border-rose transition-transform hover:-translate-y-1">
                <p class="text-slate-500 text-[10px] font-bold uppercase tracking-[0.2em]">Taxa de Incidentes</p>
                <p id="kpi-errors" class="text-4xl font-black mt-2 text-rose-500">0%</p>
                <p class="mt-4 text-[9px] text-slate-400 font-semibold uppercase italic">Limite: <span class="text-rose-400">Máx 2.5%</span></p>
            </div>

            <div class="glass p-6 rounded-2xl neon-border-indigo transition-transform hover:-translate-y-1">
                <p class="text-slate-500 text-[10px] font-bold uppercase tracking-[0.2em]">Carga Média</p>
                <p id="kpi-payload" class="text-4xl font-black mt-2 text-indigo-400">0.00 KB</p>
                <p class="mt-4 text-[9px] text-slate-400 font-semibold uppercase italic">Unidade: <span class="text-indigo-400">Kilobytes</span></p>
            </div>
        </section>

        <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-1 glass p-8 rounded-3xl">
                <h3 class="font-bold uppercase text-[10px] tracking-[0.3em] text-indigo-400 mb-8 flex items-center gap-3">
                    <span class="w-2 h-2 bg-indigo-500 rounded-full"></span> Saúde do Tráfego (HTTP)
                </h3>
                <div class="chart-container">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>

            <div class="lg:col-span-2 glass p-8 rounded-3xl">
                <h3 class="font-bold uppercase text-[10px] tracking-[0.3em] text-blue-400 mb-8 flex items-center gap-3">
                    <span class="w-2 h-2 bg-blue-500 rounded-full"></span> Atividade por Endpoint do Cluster
                </h3>
                <div class="chart-container">
                    <canvas id="endpointChart"></canvas>
                </div>
            </div>
        </section>

        <footer class="flex flex-col md:flex-row justify-between items-center py-8 border-t border-white/5 gap-4">
            <p class="text-[8px] text-slate-600 font-bold uppercase tracking-[0.8em]">
                &copy; 2026 Cortex 360 Core // Solução de BI de Alta Performance
            </p>
            <div class="flex gap-4 items-center">
                <div class="w-2 h-2 rounded-full bg-emerald-500 status-dot"></div>
                <span class="text-[9px] font-black uppercase tracking-widest text-slate-500">Conexão Segura Ativa (SSL/TSL)</span>
            </div>
        </footer>
    </main>

    <script>
        let charts = {};

        async function updateDashboard() {
            try {
                const response = await fetch('api/get_metrics.php');
                const data = await response.json();

                if (data.status === 'success') {
                    document.getElementById('kpi-total').innerText = data.kpis.total_requests;
                    document.getElementById('kpi-errors').innerText = data.kpis.error_rate + '%';
                    document.getElementById('kpi-payload').innerText = data.kpis.avg_payload_kb + ' KB';
                    document.getElementById('kpi-availability').innerText = (100 - parseFloat(data.kpis.error_rate)).toFixed(1) + '%';
                    document.getElementById('availability-bar').style.width = (100 - parseFloat(data.kpis.error_rate)) + '%';
                    document.getElementById('timestamp').innerText = data.server_info.timestamp;
                    renderCharts(data.charts);
                }
            } catch (error) { console.error('Falha na Sincronização:', error); }
        }

        function renderCharts(chartData) {
            const fontConfig = { family: "'JetBrains Mono', monospace", size: 9, weight: 'bold' };
            if (charts.status) charts.status.destroy();
            charts.status = new Chart(document.getElementById('statusChart'), {
                type: 'doughnut',
                data: {
                    labels: chartData.status_distribution.map(d => `Status ${d.label}`),
                    datasets: [{
                        data: chartData.status_distribution.map(d => d.value),
                        backgroundColor: ['#6366f1', '#10b981', '#f59e0b', '#f43f5e'],
                        borderWidth: 0, hoverOffset: 15
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, cutout: '85%', plugins: { legend: { position: 'bottom', labels: { padding: 25, usePointStyle: true, font: fontConfig, color: '#64748b' } } } }
            });

            if (charts.endpoint) charts.endpoint.destroy();
            charts.endpoint = new Chart(document.getElementById('endpointChart'), {
                type: 'bar',
                data: {
                    labels: chartData.top_endpoints.map(d => d.label),
                    datasets: [{
                        data: chartData.top_endpoints.map(d => d.value),
                        backgroundColor: 'rgba(99, 102, 241, 0.15)',
                        borderColor: '#6366f1', borderWidth: 1, borderRadius: 10, hoverBackgroundColor: '#6366f1'
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, scales: { y: { grid: { color: 'rgba(255,255,255,0.03)' }, ticks: { font: fontConfig, color: '#475569' } }, x: { grid: { display: false }, ticks: { font: fontConfig, color: '#475569' } } }, plugins: { legend: { display: false } } }
            });
        }

        setInterval(updateDashboard, 15000);
        updateDashboard();
    </script>
</body>
</html>