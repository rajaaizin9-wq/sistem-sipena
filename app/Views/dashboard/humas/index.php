<div class="flex flex-col justify-between gap-4 mb-8 sm:flex-row sm:items-center">
    <div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-sky-50 text-sky-700 border border-sky-200/60">
                SIPENA BNN Kota Tanjungpinang
            </span>
        </div>
        <h1 class="mt-2 text-2xl font-black tracking-tight sm:text-3xl text-slate-900">Selamat datang, <?= esc($user['name'] ?? 'Admin') ?>.</h1>
        <p class="mt-1 text-sm text-slate-500">Ringkasan pengelola edukasi dan informasi P4GN publik.</p>
    </div>
    
    <div class="flex flex-wrap items-center gap-2 shrink-0">
        <a href="<?= base_url('dashboard/scorm/create') ?>" class="inline-flex items-center justify-center gap-2 rounded-xl bg-sky-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-sky-700 cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            <span>Unggah Bacaan</span>
        </a>
        <a href="<?= base_url('dashboard/articles/create') ?>" class="inline-flex items-center justify-center gap-2 rounded-xl bg-white border border-slate-300 px-3.5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition-colors hover:bg-slate-50 cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
            <span>Tulis Artikel</span>
        </a>
        <a href="<?= base_url('dashboard/quizzes/create') ?>" class="inline-flex items-center justify-center gap-2 rounded-xl bg-white border border-slate-300 px-3.5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition-colors hover:bg-slate-50 cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            <span>Buat Kuis</span>
        </a>
    </div>
</div>

<?= view('dashboard/partials/flash_messages') ?>

<!-- 4 Essential Metric Cards -->
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
    
    <!-- Card 1: Modul Bacaan -->
    <a href="<?= base_url('dashboard/scorm') ?>" class="p-5 transition-all duration-200 bg-white border shadow-sm group border-slate-200/80 rounded-2xl hover:border-sky-300 hover:shadow-md">
        <div class="flex items-center justify-between gap-3">
            <span class="text-xs font-bold tracking-wider uppercase transition-colors text-slate-500 group-hover:text-sky-600">Modul Bacaan</span>
            <div class="flex items-center justify-center transition-colors w-9 h-9 rounded-xl bg-sky-50 text-sky-600 group-hover:bg-sky-600 group-hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg>
            </div>
        </div>
        <span class="block mt-3 text-3xl font-black transition-colors text-slate-900 group-hover:text-sky-600"><?= esc($totalModules ?? 0) ?></span>
        <p class="mt-2 text-xs font-medium text-slate-500">
            <span class="font-bold text-emerald-600"><?= esc($publishedModules ?? 0) ?> Terbit</span> • <?= esc($draftModules ?? 0) ?> Draft
        </p>
    </a>

    <!-- Card 2: Artikel -->
    <a href="<?= base_url('dashboard/articles') ?>" class="p-5 transition-all duration-200 bg-white border shadow-sm group border-slate-200/80 rounded-2xl hover:border-sky-300 hover:shadow-md">
        <div class="flex items-center justify-between gap-3">
            <span class="text-xs font-bold tracking-wider uppercase transition-colors text-slate-500 group-hover:text-sky-600">Artikel Edukasi</span>
            <div class="flex items-center justify-center text-blue-600 transition-colors w-9 h-9 rounded-xl bg-blue-50 group-hover:bg-blue-600 group-hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            </div>
        </div>
        <span class="block mt-3 text-3xl font-black transition-colors text-slate-900 group-hover:text-sky-600"><?= esc($totalArticles ?? 0) ?></span>
        <p class="mt-2 text-xs font-medium text-slate-500">
            <span class="font-bold text-emerald-600"><?= esc($publishedArticles ?? 0) ?> Terbit</span> • <?= esc($draftArticles ?? 0) ?> Draft
        </p>
    </a>

    <!-- Card 3: Kuis -->
    <a href="<?= base_url('dashboard/quizzes') ?>" class="p-5 transition-all duration-200 bg-white border shadow-sm group border-slate-200/80 rounded-2xl hover:border-sky-300 hover:shadow-md">
        <div class="flex items-center justify-between gap-3">
            <span class="text-xs font-bold tracking-wider uppercase transition-colors text-slate-500 group-hover:text-sky-600">Kuis Edukasi</span>
            <div class="flex items-center justify-center text-indigo-600 transition-colors w-9 h-9 rounded-xl bg-indigo-50 group-hover:bg-indigo-600 group-hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            </div>
        </div>
        <span class="block mt-3 text-3xl font-black transition-colors text-slate-900 group-hover:text-sky-600"><?= esc($totalQuizzes ?? 0) ?></span>
        <p class="mt-2 text-xs font-medium text-slate-500">Modul evaluasi pemahaman</p>
    </a>

    <!-- Card 4: Sesi Peserta Kuis -->
    <a href="<?= base_url('dashboard/quizzes/logs') ?>" class="p-5 transition-all duration-200 bg-white border shadow-sm group border-slate-200/80 rounded-2xl hover:border-sky-300 hover:shadow-md">
        <div class="flex items-center justify-between gap-3">
            <span class="text-xs font-bold tracking-wider uppercase transition-colors text-slate-500 group-hover:text-sky-600">Sesi Peserta Kuis</span>
            <div class="flex items-center justify-center transition-colors w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
        </div>
        <span class="block mt-3 text-3xl font-black transition-colors text-slate-900 group-hover:text-sky-600"><?= esc($totalQuizSessions ?? 0) ?></span>
        <p class="mt-2 text-xs font-medium text-slate-500">Total sesi pengerjakan publik</p>
    </a>

</div>

<!-- Recent Content Overview (Split Grid) -->
<div class="grid grid-cols-1 gap-6 mt-8 lg:grid-cols-2">
    
    <!-- Left: Modul Bacaan Terbaru -->
    <div class="flex flex-col justify-between overflow-hidden bg-white border shadow-sm border-slate-200/80 rounded-2xl">
        <div>
            <div class="flex items-center justify-between gap-4 p-5 border-b border-slate-100 bg-slate-50/50">
                <div>
                    <h2 class="text-base font-bold text-slate-900">Modul Bacaan Terbaru</h2>
                    <p class="text-xs text-slate-500">Materi edukasi interaktif P4GN</p>
                </div>
                <a href="<?= base_url('dashboard/scorm') ?>" class="text-xs font-bold transition-colors text-sky-600 hover:text-sky-800">Lihat Semua &rarr;</a>
            </div>

            <?php if (empty($recentModules)): ?>
                <div class="p-8 text-sm text-center text-slate-500">Belum ada modul Bacaan.</div>
            <?php else: ?>
                <div class="divide-y divide-slate-100">
                    <?php foreach ($recentModules as $module): ?>
                        <div class="flex items-center justify-between gap-3 p-4 transition-colors hover:bg-slate-50/80">
                            <div class="flex-1 min-w-0">
                                <a href="<?= base_url('dashboard/scorm/edit/' . esc($module['id'], 'url')) ?>" class="block text-sm font-bold truncate transition-colors text-slate-900 hover:text-sky-600" title="<?= esc($module['title'] ?? '') ?>">
                                    <?= esc($module['title'] ?? '-') ?>
                                </a>
                                <span class="text-xs text-slate-400 block mt-0.5"><?= esc($module['created_at'] ?? '-') ?></span>
                            </div>
                            <span class="shrink-0 inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold <?= !empty($module['published']) ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' ?>">
                                <?= !empty($module['published']) ? 'Terbit' : 'Draft' ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Right: Artikel Terbaru -->
    <div class="flex flex-col justify-between overflow-hidden bg-white border shadow-sm border-slate-200/80 rounded-2xl">
        <div>
            <div class="flex items-center justify-between gap-4 p-5 border-b border-slate-100 bg-slate-50/50">
                <div>
                    <h2 class="text-base font-bold text-slate-900">Artikel Edukasi Terbaru</h2>
                    <p class="text-xs text-slate-500">Informasi & berita P4GN BNN</p>
                </div>
                <a href="<?= base_url('dashboard/articles') ?>" class="text-xs font-bold transition-colors text-sky-600 hover:text-sky-800">Lihat Semua &rarr;</a>
            </div>

            <?php if (empty($recentArticles)): ?>
                <div class="p-8 text-sm text-center text-slate-500">Belum ada artikel edukasi.</div>
            <?php else: ?>
                <div class="divide-y divide-slate-100">
                    <?php foreach ($recentArticles as $article): ?>
                        <div class="flex items-center justify-between gap-3 p-4 transition-colors hover:bg-slate-50/80">
                            <div class="flex-1 min-w-0">
                                <a href="<?= base_url('dashboard/articles/edit/' . esc($article['id'], 'url')) ?>" class="block text-sm font-bold truncate transition-colors text-slate-900 hover:text-sky-600" title="<?= esc($article['title'] ?? '') ?>">
                                    <?= esc($article['title'] ?? '-') ?>
                                </a>
                                <span class="text-xs text-slate-400 block mt-0.5"><?= esc(date('d M Y', strtotime($article['created_at']))) ?></span>
                            </div>
                            <span class="shrink-0 inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold <?= ($article['status'] ?? '') === 'published' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' ?>">
                                <?= ($article['status'] ?? '') === 'published' ? 'Terbit' : 'Draft' ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>