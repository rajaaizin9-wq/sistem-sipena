<div class="mb-8">
    <p class="text-xs font-bold uppercase tracking-widest text-bnn-600 mb-1">Artikel</p>
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-800 tracking-tight">Kelola Artikel</h1>
            <p class="text-slate-500 mt-1 text-sm">Buat, perbarui, dan atur publikasi informasi untuk halaman publik.</p>
        </div>
        <a class="inline-flex items-center justify-center gap-2 rounded-lg bg-bnn-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:bg-bnn-800 hover:shadow-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-bnn-600 shrink-0" href="<?= base_url('dashboard/articles/create') ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Tambah Artikel
        </a>
    </div>
</div>

<?= view('dashboard/partials/flash_messages') ?>

<?php 
$articles = $articles ?? []; 
$search   = $search ?? '';
$sort     = $sort ?? 'created_at';
$order    = $order ?? 'desc';
$total    = $total ?? count($articles);

function articleSortUrl($col, $currentSort, $currentOrder, $search) {
    $nextOrder = ($currentSort === $col && $currentOrder === 'asc') ? 'desc' : 'asc';
    $params = ['sort' => $col, 'order' => $nextOrder];
    if ($search !== '') {
        $params['search'] = $search;
    }
    return base_url('dashboard/articles') . '?' . http_build_query($params);
}
?>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <!-- Search Bar & Filters -->
    <form method="get" action="<?= base_url('dashboard/articles') ?>" class="border-b border-slate-200 bg-slate-50/50 px-6 py-4 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="relative w-full sm:w-80">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
                </svg>
            </div>
            <input type="text" name="search" value="<?= esc($search) ?>" placeholder="Cari judul artikel / tag..." class="block w-full pl-9 pr-8 py-2 text-sm text-slate-900 bg-white border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-colors placeholder:text-slate-400">
            <?php if ($search !== ''): ?>
                <a href="<?= base_url('dashboard/articles') ?>" class="absolute inset-y-0 right-0 pr-2.5 flex items-center text-slate-400 hover:text-slate-600" title="Hapus pencarian">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </a>
            <?php endif; ?>
            <?php if ($sort !== ''): ?><input type="hidden" name="sort" value="<?= esc($sort) ?>"><?php endif; ?>
            <?php if ($order !== ''): ?><input type="hidden" name="order" value="<?= esc($order) ?>"><?php endif; ?>
        </div>

        <div class="flex items-center gap-2 text-xs font-semibold text-slate-500">
            <span class="inline-flex items-center rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 ring-1 ring-inset ring-blue-700/10">
                Total: <?= $total ?> artikel
            </span>
        </div>
    </form>

    <?php if (empty($articles)): ?>
        <div class="text-center py-16 px-6">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-slate-100 mb-4">
                <svg class="h-8 w-8 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5L18.5 7H20M9 11h6m-6 4h6" /></svg>
            </div>
            <?php if ($search !== ''): ?>
                <strong class="block text-sm font-semibold text-slate-900 mb-1">Artikel tidak ditemukan</strong>
                <p class="text-sm text-slate-500 mb-4">Tidak ada artikel yang cocok dengan kata kunci "<?= esc($search) ?>".</p>
                <a class="inline-flex items-center text-sm font-semibold text-bnn-600 hover:text-bnn-800" href="<?= base_url('dashboard/articles') ?>">
                    Reset pencarian
                </a>
            <?php else: ?>
                <strong class="block text-sm font-semibold text-slate-900 mb-1">Belum ada artikel</strong>
                <p class="text-sm text-slate-500 mb-6">Tambahkan artikel pertama untuk mulai membagikan informasi.</p>
                <a class="inline-flex items-center text-sm font-semibold text-bnn-600 hover:text-bnn-800" href="<?= base_url('dashboard/articles/create') ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    Tambah Artikel Sekarang
                </a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50 select-none">
                    <tr>
                        <th scope="col" class="py-3.5 pl-6 pr-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                            <a href="<?= articleSortUrl('title', $sort, $order, $search) ?>" class="inline-flex items-center gap-1.5 hover:text-sky-600 transition-colors" title="Urutkan berdasarkan Judul">
                                <span>Artikel</span>
                                <?php if ($sort === 'title'): ?>
                                    <span class="text-sky-600 font-bold"><?= $order === 'asc' ? '↑' : '↓' ?></span>
                                <?php else: ?>
                                    <span class="text-slate-300">↕</span>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                            <a href="<?= articleSortUrl('status', $sort, $order, $search) ?>" class="inline-flex items-center gap-1.5 hover:text-sky-600 transition-colors" title="Urutkan berdasarkan Status">
                                <span>Status</span>
                                <?php if ($sort === 'status'): ?>
                                    <span class="text-sky-600 font-bold"><?= $order === 'asc' ? '↑' : '↓' ?></span>
                                <?php else: ?>
                                    <span class="text-slate-300">↕</span>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider whitespace-nowrap">
                            <a href="<?= articleSortUrl('created_at', $sort, $order, $search) ?>" class="inline-flex items-center gap-1.5 hover:text-sky-600 transition-colors" title="Urutkan berdasarkan Tanggal">
                                <span>Dibuat Pada</span>
                                <?php if ($sort === 'created_at'): ?>
                                    <span class="text-sky-600 font-bold"><?= $order === 'asc' ? '↑' : '↓' ?></span>
                                <?php else: ?>
                                    <span class="text-slate-300">↕</span>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th scope="col" class="py-3.5 pl-3 pr-6 text-right text-xs font-semibold text-slate-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                <?php foreach ($articles as $article): ?>
                    <tr class="hover:bg-slate-50/75 transition-colors group">
                        <td class="whitespace-nowrap py-4 pl-6 pr-3 sm:pl-6">
                            <div class="flex items-center gap-4">
                                <?php if (! empty($article['image'])): ?>
                                    <img class="h-12 w-16 rounded object-cover shadow-sm ring-1 ring-slate-900/5" src="<?= base_url($article['image']) ?>" alt="">
                                <?php else: ?>
                                    <div class="flex h-12 w-16 items-center justify-center rounded bg-slate-100 text-xs font-medium text-slate-400 ring-1 ring-slate-900/5">IMG</div>
                                <?php endif; ?>
                                <div class="min-w-0 max-w-xs md:max-w-md lg:max-w-lg">
                                    <p class="truncate text-sm font-bold text-slate-900 group-hover:text-bnn-800 transition-colors"><?= esc($article['title']) ?></p>
                                    <p class="truncate text-xs text-slate-500 mt-0.5"><?= esc(mb_strimwidth($article['description'] ?: strip_tags($article['content']), 0, 88, '...')) ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm">
                            <?php if($article['status'] === 'published'): ?>
                                <span class="inline-flex items-center rounded-md bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">Terbit</span>
                            <?php else: ?>
                                <span class="inline-flex items-center rounded-md bg-amber-50 px-2 py-1 text-xs font-medium text-amber-700 ring-1 ring-inset ring-amber-600/20">Draft</span>
                            <?php endif; ?>
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-600">
                            <?= esc(! empty($article['created_at']) && strtotime($article['created_at']) > 0 ? date('d M Y', strtotime($article['created_at'])) : date('d M Y')) ?>
                        </td>
                        <td class="relative whitespace-nowrap py-4 pl-3 pr-6 text-right text-sm font-medium">
                            <div class="flex items-center justify-end gap-3">
                                <a href="<?= base_url('dashboard/articles/edit/' . $article['id']) ?>" class="text-slate-400 hover:text-bnn-600 transition-colors" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                </a>
                                <form method="post" action="<?= base_url('dashboard/articles/delete/' . $article['id']) ?>" class="m-0" onsubmit="return confirmDelete(this, 'Anda yakin ingin menghapus artikel ini? Tindakan ini tidak dapat dibatalkan.')">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="text-slate-400 hover:text-red-600 transition-colors cursor-pointer" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        <?php
        $currentPage = (int) ($pager ? $pager->getCurrentPage('article') : 1);
        $totalPages  = (int) ($pager ? $pager->getPageCount('article') : ceil($total / 10));
        if ($totalPages < 1) $totalPages = 1;

        function articlePageUrl($p, $search, $sort, $order) {
            $params = ['page_article' => $p];
            if ($search !== '') $params['search'] = $search;
            if ($sort !== '') $params['sort'] = $sort;
            if ($order !== '') $params['order'] = $order;
            return base_url('dashboard/articles') . '?' . http_build_query($params);
        }
        ?>

        <?php if ($totalPages > 1): ?>
            <div class="px-6 py-4 border-t border-slate-200 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="text-xs text-slate-500 font-medium">
                    Halaman <strong class="text-slate-800"><?= $currentPage ?></strong> dari <strong class="text-slate-800"><?= $totalPages ?></strong>
                </div>

                <div class="flex items-center gap-1.5">
                    <?php if ($currentPage > 1): ?>
                        <a href="<?= articlePageUrl($currentPage - 1, $search, $sort, $order) ?>" class="px-3 py-1.5 rounded-lg border border-slate-300 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                            &larr; Prev
                        </a>
                    <?php else: ?>
                        <span class="px-3 py-1.5 rounded-lg border border-slate-200 bg-slate-100 text-xs font-semibold text-slate-400 cursor-not-allowed">
                            &larr; Prev
                        </span>
                    <?php endif; ?>

                    <?php
                    $startPage = max(1, $currentPage - 2);
                    $endPage   = min($totalPages, $currentPage + 2);
                    for ($p = $startPage; $p <= $endPage; $p++):
                    ?>
                        <?php if ($p === $currentPage): ?>
                            <span class="px-3 py-1.5 rounded-lg bg-sky-600 text-white text-xs font-bold shadow-sm">
                                <?= $p ?>
                            </span>
                        <?php else: ?>
                            <a href="<?= articlePageUrl($p, $search, $sort, $order) ?>" class="px-3 py-1.5 rounded-lg border border-slate-300 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                                <?= $p ?>
                            </a>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <?php if ($currentPage < $totalPages): ?>
                        <a href="<?= articlePageUrl($currentPage + 1, $search, $sort, $order) ?>" class="px-3 py-1.5 rounded-lg border border-slate-300 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                            Next &rarr;
                        </a>
                    <?php else: ?>
                        <span class="px-3 py-1.5 rounded-lg border border-slate-200 bg-slate-100 text-xs font-semibold text-slate-400 cursor-not-allowed">
                            Next &rarr;
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

