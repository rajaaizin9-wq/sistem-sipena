<nav class="flex flex-col gap-1.5 sidebar-nav">
    <?php 
        $uri = ltrim(uri_string(), '/');
        $baseClass   = "group flex items-center gap-3.5 whitespace-nowrap rounded-xl px-3.5 py-2.5 text-sm font-medium text-slate-400 transition-colors hover:bg-white/5 hover:text-slate-200";
        $activeClass = "group flex items-center gap-3.5 whitespace-nowrap rounded-xl px-3.5 py-2.5 text-sm font-semibold text-white bg-white/10 border-l-4 border-sky-400";
    ?>
    <a class="<?= ($uri === 'dashboard' || $uri === '') ? $activeClass : $baseClass ?>" href="<?= base_url('dashboard') ?>" title="Beranda">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 transition-colors <?= ($uri === 'dashboard' || $uri === '') ? 'text-sky-400' : 'text-slate-400 group-hover:text-slate-200' ?>"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
        <span class="truncate sidebar-text">Beranda</span>
    </a>
    <a class="<?= ($uri === 'dashboard/landing-page') ? $activeClass : $baseClass ?>" href="<?= base_url('dashboard/landing-page') ?>" title="Landing Page">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 transition-colors <?= ($uri === 'dashboard/landing-page') ? 'text-sky-400' : 'text-slate-400 group-hover:text-slate-200' ?>"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
        <span class="truncate sidebar-text">Landing Page</span>
    </a>
    <a class="<?= str_starts_with($uri, 'dashboard/scorm') ? $activeClass : $baseClass ?>" href="<?= base_url('dashboard/scorm') ?>" title="Modul Bacaan">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 transition-colors <?= str_starts_with($uri, 'dashboard/scorm') ? 'text-sky-400' : 'text-slate-400 group-hover:text-slate-200' ?>"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
        <span class="truncate sidebar-text">Modul Bacaan</span>
    </a>
    <a class="<?= str_starts_with($uri, 'dashboard/articles') ? $activeClass : $baseClass ?>" href="<?= base_url('dashboard/articles') ?>" title="Artikel">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 transition-colors <?= str_starts_with($uri, 'dashboard/articles') ? 'text-sky-400' : 'text-slate-400 group-hover:text-slate-200' ?>"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
        <span class="truncate sidebar-text">Artikel</span>
    </a>
    <a class="<?= str_starts_with($uri, 'dashboard/quizzes') ? $activeClass : $baseClass ?>" href="<?= base_url('dashboard/quizzes') ?>" title="Kuis">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 transition-colors <?= str_starts_with($uri, 'dashboard/quizzes') ? 'text-sky-400' : 'text-slate-400 group-hover:text-slate-200' ?>"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
        <span class="truncate sidebar-text">Kuis</span>
    </a>
    <a class="<?= ($uri === 'dashboard/profile') ? $activeClass : $baseClass ?>" href="<?= base_url('dashboard/profile') ?>" title="Profil Akun">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 transition-colors <?= ($uri === 'dashboard/profile') ? 'text-sky-400' : 'text-slate-400 group-hover:text-slate-200' ?>"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
        <span class="truncate sidebar-text">Profil Akun</span>
    </a>
</nav>

