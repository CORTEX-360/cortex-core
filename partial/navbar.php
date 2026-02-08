<nav
  class="fixed top-3 sm:top-6 inset-x-0 mx-auto z-50
         glass rounded-2xl border border-[var(--border-ui)]
         shadow-lg shadow-cyan-500/5 transition-all duration-300
         w-[min(92vw,80rem)]
         py-3 sm:py-4 px-4 sm:px-6 md:px-12
         flex items-center justify-between"
>
  <a href="index.php" class="text-xl sm:text-2xl font-black title-font tracking-tighter leading-none whitespace-nowrap">
    CORTEX<span style="color: var(--accent-cyan)">360</span>
  </a>

  <!-- Desktop -->
  <div class="hidden md:flex space-x-6 mono text-[10px] font-bold uppercase tracking-widest items-center">
    <a href="index.php#tecnologias" class="hover:text-[var(--accent-cyan)] transition">/tecnologias</a>
    <a href="index.php#labs" class="hover:text-[var(--accent-cyan)] transition">/labs</a>
    <a href="index.php#tools" class="hover:text-[var(--accent-cyan)] transition">/ferramentas</a>
    <a href="index.php#parceiros" class="hover:text-[var(--accent-cyan)] transition">/parceiros</a>

    <button id="theme-toggle" type="button"
      class="ml-4 p-2 rounded-full hover:bg-[var(--border-ui)] transition-colors border border-transparent hover:border-[var(--accent-cyan)]"
      aria-label="Alternar tema">
      <span id="toggle-icon" class="text-lg">🌙</span>
    </button>
  </div>

  <!-- Mobile -->
  <div class="md:hidden flex items-center gap-2">
    <button id="theme-toggle-mobile" type="button"
      class="p-2 rounded-xl hover:bg-[var(--border-ui)] transition-colors border border-transparent hover:border-[var(--accent-cyan)]"
      aria-label="Alternar tema">
      <span id="toggle-icon-mobile" class="text-lg">🌙</span>
    </button>

    <button id="mobile-menu-btn" type="button"
      class="p-2 rounded-xl hover:bg-[var(--border-ui)] transition-colors border border-transparent hover:border-[var(--accent-cyan)]"
      aria-label="Abrir menu"
      aria-controls="mobile-menu"
      aria-expanded="false">
      <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
        <path d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
      </svg>
    </button>
  </div>

  <!-- Dropdown Mobile (fica dentro da largura do nav, sem estourar) -->
  <div id="mobile-menu" class="hidden md:hidden absolute left-0 right-0 top-full mt-3 px-2">
    <div class="glass rounded-2xl border border-[var(--border-ui)] shadow-lg shadow-cyan-500/5 overflow-hidden">
      <div class="p-3 flex flex-col gap-1">
        <a href="index.php#tecnologias" class="px-4 py-3 rounded-xl mono text-[11px] font-bold uppercase tracking-widest hover:bg-[var(--border-ui)] transition">/tecnologias</a>
        <a href="index.php#labs" class="px-4 py-3 rounded-xl mono text-[11px] font-bold uppercase tracking-widest hover:bg-[var(--border-ui)] transition">/labs</a>
        <a href="index.php#tools" class="px-4 py-3 rounded-xl mono text-[11px] font-bold uppercase tracking-widest hover:bg-[var(--border-ui)] transition">/ferramentas</a>
        <a href="index.php#parceiros" class="px-4 py-3 rounded-xl mono text-[11px] font-bold uppercase tracking-widest hover:bg-[var(--border-ui)] transition">/parceiros</a>
      </div>
    </div>
  </div>
</nav>

<script>
(function () {
  const btn = document.getElementById('mobile-menu-btn');
  const menu = document.getElementById('mobile-menu');
  if (!btn || !menu) return;

  const openMenu = () => { menu.classList.remove('hidden'); btn.setAttribute('aria-expanded','true'); };
  const closeMenu = () => { menu.classList.add('hidden'); btn.setAttribute('aria-expanded','false'); };
  const toggleMenu = () => menu.classList.contains('hidden') ? openMenu() : closeMenu();

  btn.addEventListener('click', (e) => { e.stopPropagation(); toggleMenu(); });

  document.addEventListener('click', (e) => {
    if (menu.classList.contains('hidden')) return;
    if (!menu.contains(e.target) && e.target !== btn) closeMenu();
  });

  document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeMenu(); });

  menu.querySelectorAll('a').forEach(a => a.addEventListener('click', closeMenu));
})();
</script>
