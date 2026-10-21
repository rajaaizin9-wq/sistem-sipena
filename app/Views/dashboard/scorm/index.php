<div class="mb-8">
    <p class="mb-1 text-xs font-bold tracking-widest uppercase text-bnn-600">Modul Bacaan</p>
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-slate-800">Kelola modul edukasi</h1>
            <p class="mt-1 text-sm text-slate-500">Tambah, publikasi, edit, dan hapus modul Bacaan yang tampil di ruang belajar.</p>
        </div>
        <a class="inline-flex items-center justify-center gap-2 rounded-lg bg-bnn-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:bg-bnn-800 hover:shadow-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-bnn-600 shrink-0" href="<?= base_url('dashboard/scorm/create') ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Tambah modul
        </a>
    </div>
</div>

<?= view('dashboard/partials/flash_messages') ?>

<?php
$modules = $modules ?? [];
$search  = $search ?? '';
$sort    = $sort ?? 'created_at';
$order   = $order ?? 'desc';
$total   = $total ?? count($modules);

function scormSortUrl($col, $currentSort, $currentOrder, $search)
{
    $nextOrder = ($currentSort === $col && $currentOrder === 'asc') ? 'desc' : 'asc';
    $params = ['sort' => $col, 'order' => $nextOrder];
    if ($search !== '') {
        $params['search'] = $search;
    }
    return base_url('dashboard/scorm') . '?' . http_build_query($params);
}
?>

<div class="overflow-hidden bg-white border shadow-sm rounded-xl border-slate-200">
    <!-- Header Filter & Search Bar -->
    <form method="get" action="<?= base_url('dashboard/scorm') ?>" class="flex flex-col items-center justify-between gap-4 px-6 py-4 border-b border-slate-200 bg-slate-50/50 sm:flex-row">
        <div class="relative w-full sm:w-80">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.3-4.3" />
                </svg>
            </div>
            <input type="text" name="search" value="<?= esc($search) ?>" placeholder="Cari judul modul..." class="block w-full py-2 pr-8 text-sm transition-colors bg-white border rounded-lg pl-9 text-slate-900 border-slate-300 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 placeholder:text-slate-400">
            <?php if ($search !== ''): ?>
                <a href="<?= base_url('dashboard/scorm') ?>" class="absolute inset-y-0 right-0 pr-2.5 flex items-center text-slate-400 hover:text-slate-600" title="Hapus pencarian">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </a>
            <?php endif; ?>
            <?php if ($sort !== ''): ?><input type="hidden" name="sort" value="<?= esc($sort) ?>"><?php endif; ?>
            <?php if ($order !== ''): ?><input type="hidden" name="order" value="<?= esc($order) ?>"><?php endif; ?>
        </div>

        <div class="flex items-center gap-2 text-xs font-semibold text-slate-500">
            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold text-blue-700 rounded-full bg-blue-50 ring-1 ring-inset ring-blue-700/10">
                Total: <?= $total ?> modul
            </span>
        </div>
    </form>

    <?php if (empty($modules)): ?>
        <div class="px-6 py-16 text-center">
            <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full bg-slate-100">
                <svg class="w-8 h-8 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <?php if ($search !== ''): ?>
                <strong class="block mb-1 text-sm font-semibold text-slate-900">Modul tidak ditemukan</strong>
                <p class="mb-4 text-sm text-slate-500">Tidak ada modul yang cocok dengan kata kunci "<?= esc($search) ?>".</p>
                <a class="inline-flex items-center text-sm font-semibold text-bnn-600 hover:text-bnn-800" href="<?= base_url('dashboard/scorm') ?>">
                    Reset pencarian
                </a>
            <?php else: ?>
                <strong class="block mb-1 text-sm font-semibold text-slate-900">Belum ada modul bacaan</strong>
                <p class="mb-6 text-sm text-slate-500">Klik "Tambah modul" untuk mengunggah modul pertama.</p>
                <a class="inline-flex items-center text-sm font-semibold text-bnn-600 hover:text-bnn-800" href="<?= base_url('dashboard/scorm/create') ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1.5">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Tambah modul sekarang
                </a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="select-none bg-slate-50">
                    <tr>
                        <th scope="col" class="py-3.5 pl-6 pr-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                            <a href="<?= scormSortUrl('title', $sort, $order, $search) ?>" class="inline-flex items-center gap-1.5 hover:text-sky-600 transition-colors" title="Urutkan berdasarkan Judul">
                                <span>Modul</span>
                                <?php if ($sort === 'title'): ?>
                                    <span class="font-bold text-sky-600"><?= $order === 'asc' ? '↑' : '↓' ?></span>
                                <?php else: ?>
                                    <span class="text-slate-300">↕</span>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                            <a href="<?= scormSortUrl('published', $sort, $order, $search) ?>" class="inline-flex items-center gap-1.5 hover:text-sky-600 transition-colors" title="Urutkan berdasarkan Status">
                                <span>Status</span>
                                <?php if ($sort === 'published'): ?>
                                    <span class="font-bold text-sky-600"><?= $order === 'asc' ? '↑' : '↓' ?></span>
                                <?php else: ?>
                                    <span class="text-slate-300">↕</span>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider whitespace-nowrap">
                            <a href="<?= scormSortUrl('created_at', $sort, $order, $search) ?>" class="inline-flex items-center gap-1.5 hover:text-sky-600 transition-colors" title="Urutkan berdasarkan Tanggal">
                                <span>Tanggal Upload</span>
                                <?php if ($sort === 'created_at'): ?>
                                    <span class="font-bold text-sky-600"><?= $order === 'asc' ? '↑' : '↓' ?></span>
                                <?php else: ?>
                                    <span class="text-slate-300">↕</span>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th scope="col" class="py-3.5 pl-3 pr-6 text-right text-xs font-semibold text-slate-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-100">
                    <?php foreach ($modules as $module): ?>
                        <tr class="transition-colors hover:bg-slate-50/75 group">
                            <td class="py-4 pl-6 pr-3 whitespace-nowrap sm:pl-6">
                                <div class="flex items-center gap-4">
                                    <?php if (! empty($module['thumbnail'])): ?>
                                        <img class="object-cover w-12 h-12 rounded-lg shadow-sm ring-1 ring-slate-900/5" src="<?= base_url($module['thumbnail']) ?>" alt="<?= esc($module['title']) ?>">
                                    <?php else: ?>
                                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-bnn-50 text-[10px] font-bold text-bnn-700 ring-1 ring-bnn-700/10">BACAAN</div>
                                    <?php endif; ?>
                                    <div class="max-w-xs min-w-0 md:max-w-md">
                                        <p class="text-sm font-bold truncate transition-colors text-slate-900 group-hover:text-bnn-800"><?= esc($module['title'] ?? '-') ?></p>
                                        <?php if (! empty($module['description'])): ?>
                                            <p class="truncate text-xs text-slate-500 mt-0.5"><?= esc(mb_strimwidth($module['description'], 0, 60, '...')) ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 py-4 text-sm whitespace-nowrap">
                                <?php if (! empty($module['published'])): ?>
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-md bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20">Terbit</span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-md bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-600/20">Draft</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-3 py-4 text-sm whitespace-nowrap text-slate-600">
                                <?= esc($module['created_at'] ?? '-') ?>
                            </td>
                            <td class="relative py-4 pl-3 pr-6 text-sm font-medium text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="<?= base_url('dashboard/scorm/edit/' . esc($module['id'], 'url')) ?>" class="transition-colors text-slate-400 hover:text-bnn-600" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 20h9"></path>
                                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                        </svg>
                                    </a>

                                    <?php if (! empty($module['published'])): ?>
                                        <a href="<?= base_url('dashboard/scorm/unpublish/' . esc($module['id'], 'url')) ?>" class="transition-colors text-slate-400 hover:text-amber-600" title="Tarik">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"></path>
                                            </svg>
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= base_url('dashboard/scorm/publish/' . esc($module['id'], 'url')) ?>" class="transition-colors text-slate-400 hover:text-emerald-600" title="Terbitkan">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
                                            </svg>
                                        </a>
                                    <?php endif; ?>

                                    <a href="<?= base_url('dashboard/scorm/delete/' . esc($module['id'], 'url')) ?>" class="transition-colors text-slate-400 hover:text-red-600" title="Hapus" onclick="return confirmDelete(this.href, 'Yakin ingin menghapus modul ini? Semua file akan dihapus permanen.')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        <?php
        $currentPage = (int) ($pager ? $pager->getCurrentPage('scorm') : ($page ?? 1));
        $totalPages  = (int) ($pager ? $pager->getPageCount('scorm') : ceil($total / ($perPage ?? 10)));
        if ($totalPages < 1) $totalPages = 1;

        function scormPageUrl($p, $search, $sort, $order)
        {
            $params = ['page_scorm' => $p];
            if ($search !== '') $params['search'] = $search;
            if ($sort !== '') $params['sort'] = $sort;
            if ($order !== '') $params['order'] = $order;
            return base_url('dashboard/scorm') . '?' . http_build_query($params);
        }
        ?>

        <?php if ($totalPages > 1): ?>
            <div class="flex flex-col items-center justify-between gap-3 px-6 py-4 border-t border-slate-200 bg-slate-50/50 sm:flex-row">
                <div class="text-xs font-medium text-slate-500">
                    Halaman <strong class="text-slate-800"><?= $currentPage ?></strong> dari <strong class="text-slate-800"><?= $totalPages ?></strong>
                </div>

                <div class="flex items-center gap-1.5">
                    <?php if ($currentPage > 1): ?>
                        <a href="<?= scormPageUrl($currentPage - 1, $search, $sort, $order) ?>" class="px-3 py-1.5 rounded-lg border border-slate-300 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
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
                            <a href="<?= scormPageUrl($p, $search, $sort, $order) ?>" class="px-3 py-1.5 rounded-lg border border-slate-300 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                                <?= $p ?>
                            </a>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <?php if ($currentPage < $totalPages): ?>
                        <a href="<?= scormPageUrl($currentPage + 1, $search, $sort, $order) ?>" class="px-3 py-1.5 rounded-lg border border-slate-300 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
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