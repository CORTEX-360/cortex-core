document.addEventListener('DOMContentLoaded', () => {
    
    // =================================================================
    // 1. GERENCIAMENTO DE TEMA (DARK / LIGHT)
    // =================================================================
    const themeToggle = document.getElementById('theme-toggle');
    const themeToggleMobile = document.getElementById('theme-toggle-mobile');
    const body = document.body;
    const icon = document.getElementById('toggle-icon');
    const iconMobile = document.getElementById('toggle-icon-mobile');

    function updateIcons(isLight) {
        const symbol = isLight ? '☀️' : '🌙';
        if(icon) icon.textContent = symbol;
        if(iconMobile) iconMobile.textContent = symbol;
    }

    const savedTheme = localStorage.getItem('cortex_theme');
    if (savedTheme === 'light') {
        body.classList.add('light-mode');
        updateIcons(true);
    }

    function toggleTheme() {
        body.classList.toggle('light-mode');
        const isLight = body.classList.contains('light-mode');
        localStorage.setItem('cortex_theme', isLight ? 'light' : 'dark');
        updateIcons(isLight);
    }

    if(themeToggle) themeToggle.addEventListener('click', toggleTheme);
    if(themeToggleMobile) themeToggleMobile.addEventListener('click', toggleTheme);


    // =================================================================
    // 2. NAVEGAÇÃO INTELIGENTE (SCROLL SUAVE SEM RELOAD)
    // =================================================================
    
    // Seleciona todos os links internos (âncoras, relativos e index.php)
    const links = document.querySelectorAll('a[href^="index.php"], a[href^="#"], a[href^="/"]');

    links.forEach(link => {
        link.addEventListener('click', function(e) {
            // Cria objetos URL para comparar o destino com a página atual
            // 'this.href' retorna o caminho absoluto completo
            const targetUrl = new URL(this.href, window.location.href);
            const currentUrl = new URL(window.location.href);

            // Verifica se o caminho do arquivo é o mesmo (ex: ambos são /index.php)
            // Isso ignora a query string (?id=1) e o hash (#labs)
            if (targetUrl.pathname === currentUrl.pathname) {
                
                // ESTAMOS NA MESMA PÁGINA -> Cancelar Reload
                e.preventDefault();

                // Cenário A: Link com #ID (ex: index.php#labs)
                if (targetUrl.hash) {
                    const targetElement = document.querySelector(targetUrl.hash);
                    if (targetElement) {
                        // Scroll suave até a seção
                        targetElement.scrollIntoView({ behavior: 'smooth' });
                        // Atualiza a URL na barra de endereço sem recarregar
                        history.pushState(null, null, targetUrl.hash);
                    }
                } 
                // Cenário B: Link sem hash (ex: Logo ou index.php puro) -> Vai pro topo
                else {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    // Remove o hash antigo da URL (limpa a barra de endereço)
                    history.pushState(null, null, targetUrl.pathname);
                }
            }
            // SE FOR OUTRA PÁGINA:
            // O código ignora e deixa o navegador carregar a nova página normalmente.
            // O CSS `html { scroll-behavior: smooth }` lidará com a chegada na nova página.
        });
    });


    // =================================================================
    // 3. EFEITO PARALLAX SUTIL (MOUSE MOVE)
    // =================================================================
    document.addEventListener('mousemove', (e) => {
        const glows = document.querySelectorAll('.bg-glow');
        
        // Posição relativa do mouse (0.0 a 1.0)
        const x = e.clientX / window.innerWidth;
        const y = e.clientY / window.innerHeight;
        
        glows.forEach((glow, index) => {
            // Fator de movimento baseado no índice para profundidade
            const speed = (index + 1) * 20; 
            glow.style.transform = `translate(${x * speed}px, ${y * speed}px)`;
        });
    });

});