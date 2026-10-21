<?php
$quizzes = $quizzes ?? [];
$selectedQuiz = $selectedQuiz ?? null;
$sessions = $sessions ?? [];
$details = $details ?? [];
$submissionId = $submissionId ?? '';
$quizId = $quizId ?? 0;
$summary = $summary ?? ['total_sessions' => 0, 'unique_participants' => 0, 'average_score' => null, 'latest_submission' => null];
$selectedSession = $selectedSession ?? null;
$search = $search ?? '';
$sort   = $sort ?? 'submitted_at';
$order  = $order ?? 'desc';
$totalSessions = $totalSessions ?? count($sessions);
$pager  = $pager ?? null;

$quizSearch = $quizSearch ?? '';
$quizSort   = $quizSort ?? 'created_at';
$quizOrder  = $quizOrder ?? 'desc';
$quizTotal  = $quizTotal ?? count($quizzes);
$quizPager  = $quizPager ?? null;

function sessionSortUrl($col, $currentSort, $currentOrder, $quizId, $search) {
    $nextOrder = ($currentSort === $col && $currentOrder === 'asc') ? 'desc' : 'asc';
    $params = ['quiz_id' => $quizId, 'sort' => $col, 'order' => $nextOrder];
    if ($search !== '') {
        $params['search'] = $search;
    }
    return base_url('dashboard/quizzes/logs') . '?' . http_build_query($params);
}

function quizListSortUrl($col, $currentSort, $currentOrder, $quizSearch) {
    $nextOrder = ($currentSort === $col && $currentOrder === 'asc') ? 'desc' : 'asc';
    $params = ['quiz_sort' => $col, 'quiz_order' => $nextOrder];
    if ($quizSearch !== '') {
        $params['quiz_search'] = $quizSearch;
    }
    return base_url('dashboard/quizzes/logs') . '?' . http_build_query($params);
}

function quizListPageUrl($p, $quizSearch, $quizSort, $quizOrder) {
    $params = ['page_quiz' => $p];
    if ($quizSearch !== '') $params['quiz_search'] = $quizSearch;
    if ($quizSort !== '') $params['quiz_sort'] = $quizSort;
    if ($quizOrder !== '') $params['quiz_order'] = $quizOrder;
    return base_url('dashboard/quizzes/logs') . '?' . http_build_query($params);
}
?>

<div class="mb-8">
    <p class="mb-1 text-xs font-bold tracking-widest uppercase text-sky-600">Kuis</p>
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-slate-800">Log peserta</h1>
            <p class="mt-1 text-sm text-slate-500">Pantau hasil kuis, temukan peserta, dan periksa jawaban setiap sesi dengan cepat.</p>
        </div>
        <div class="flex items-center gap-3">
            <a class="inline-flex items-center justify-center gap-2 rounded-lg bg-white border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition-all hover:bg-slate-50" href="<?= base_url('dashboard/quizzes') ?>">
                Kembali ke daftar kuis
            </a>
        </div>
    </div>
</div>

<?php if (empty($selectedQuiz)): ?>
    <div class="mt-6 overflow-hidden bg-white border shadow-sm rounded-xl border-slate-200">
        <!-- Search & Header Bar for Selecting Quiz -->
        <form method="get" action="<?= base_url('dashboard/quizzes/logs') ?>" class="flex flex-col sm:flex-row items-center justify-between gap-4 px-6 py-4 border-b border-slate-200 bg-slate-50/50">
            <?php if ($quizSort !== ''): ?><input type="hidden" name="quiz_sort" value="<?= esc($quizSort) ?>"><?php endif; ?>
            <?php if ($quizOrder !== ''): ?><input type="hidden" name="quiz_order" value="<?= esc($quizOrder) ?>"><?php endif; ?>

            <div>
                <h2 class="text-base font-semibold text-slate-800">Pilih kuis</h2>
                <p class="text-xs text-slate-500 mt-0.5">Pilih kuis yang ingin Anda lihat log pesertanya.</p>
            </div>

            <div class="flex items-center gap-3 w-full sm:w-auto">
                <div class="relative w-full sm:w-72">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
                        </svg>
                    </div>
                    <input type="text" name="quiz_search" value="<?= esc($quizSearch) ?>" placeholder="Cari judul kuis..." class="block w-full pl-9 pr-8 py-2 text-sm text-slate-900 bg-white border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-colors placeholder:text-slate-400">
                    <?php if ($quizSearch !== ''): ?>
                        <a href="<?= base_url('dashboard/quizzes/logs') ?>" class="absolute inset-y-0 right-0 pr-2.5 flex items-center text-slate-400 hover:text-slate-600" title="Hapus pencarian">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </a>
                    <?php endif; ?>
                </div>

                <span class="hidden sm:inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600 whitespace-nowrap">
                    Total: <?= $quizTotal ?> kuis
                </span>
            </div>
        </form>

        <?php if (empty($quizzes)): ?>
            <div class="px-6 py-16 text-center">
                <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full bg-slate-100">
                    <svg class="w-8 h-8 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                </div>
                <?php if ($quizSearch !== ''): ?>
                    <strong class="block mb-1 text-sm font-semibold text-slate-900">Kuis tidak ditemukan</strong>
                    <p class="mb-4 text-sm text-slate-500">Tidak ada kuis yang cocok dengan kata kunci "<?= esc($quizSearch) ?>".</p>
                    <a href="<?= base_url('dashboard/quizzes/logs') ?>" class="inline-flex items-center text-sm font-semibold text-sky-600 hover:text-sky-800">
                        Reset pencarian
                    </a>
                <?php else: ?>
                    <strong class="block mb-1 text-sm font-semibold text-slate-900">Belum ada kuis</strong>
                    <p class="text-sm text-slate-500">Tidak ada kuis tersedia untuk ditinjau.</p>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50 select-none">
                        <tr>
                            <th scope="col" class="py-3.5 pl-6 pr-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider w-1/3">
                                <a href="<?= quizListSortUrl('title', $quizSort, $quizOrder, $quizSearch) ?>" class="inline-flex items-center gap-1.5 hover:text-sky-600 transition-colors" title="Urutkan berdasarkan Judul">
                                    <span>Judul Kuis</span>
                                    <?php if ($quizSort === 'title'): ?>
                                        <span class="text-sky-600 font-bold"><?= $quizOrder === 'asc' ? '↑' : '↓' ?></span>
                                    <?php else: ?>
                                        <span class="text-slate-300">↕</span>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                <a href="<?= quizListSortUrl('description', $quizSort, $quizOrder, $quizSearch) ?>" class="inline-flex items-center gap-1.5 hover:text-sky-600 transition-colors" title="Urutkan berdasarkan Deskripsi">
                                    <span>Deskripsi</span>
                                    <?php if ($quizSort === 'description'): ?>
                                        <span class="text-sky-600 font-bold"><?= $quizOrder === 'asc' ? '↑' : '↓' ?></span>
                                    <?php else: ?>
                                        <span class="text-slate-300">↕</span>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider w-36">
                                <a href="<?= quizListSortUrl('created_at', $quizSort, $quizOrder, $quizSearch) ?>" class="inline-flex items-center gap-1.5 hover:text-sky-600 transition-colors" title="Urutkan berdasarkan Tanggal Dibuat">
                                    <span>Dibuat</span>
                                    <?php if ($quizSort === 'created_at'): ?>
                                        <span class="text-sky-600 font-bold"><?= $quizOrder === 'asc' ? '↑' : '↓' ?></span>
                                    <?php else: ?>
                                        <span class="text-slate-300">↕</span>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th scope="col" class="py-3.5 pl-3 pr-6 text-right text-xs font-semibold text-slate-600 uppercase tracking-wider w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        <?php foreach ($quizzes as $quiz): ?>
                            <tr class="transition-colors hover:bg-slate-50/75 group">
                                <td class="py-4 pl-6 pr-3 text-sm font-medium text-slate-900">
                                    <div class="font-semibold text-slate-900 truncate max-w-xs" title="<?= esc($quiz['title'] ?? '') ?>">
                                        <?= esc($quiz['title'] ?? '-') ?>
                                    </div>
                                </td>
                                <td class="px-3 py-4 text-sm text-slate-500">
                                    <div class="truncate max-w-xs sm:max-w-sm md:max-w-md" title="<?= esc($quiz['description'] ?? '') ?>">
                                        <?= esc(! empty($quiz['description']) ? $quiz['description'] : '-') ?>
                                    </div>
                                </td>
                                <td class="px-3 py-4 text-sm whitespace-nowrap text-slate-600">
                                    <?= ! empty($quiz['created_at']) ? esc(date('d M Y', strtotime((string) $quiz['created_at']))) : '-' ?>
                                </td>
                                <td class="relative py-4 pl-3 pr-6 text-sm font-medium text-right whitespace-nowrap">
                                    <a class="transition-colors text-sky-600 hover:text-sky-800 font-semibold" href="<?= base_url('dashboard/quizzes/logs?quiz_id=' . (int) $quiz['id']) ?>">Buka log &rarr;</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Quiz List Pagination Footer -->
            <?php
            $currentQuizPage = (int) ($quizPager ? $quizPager->getCurrentPage('quiz') : 1);
            $totalQuizPages  = (int) ($quizPager ? $quizPager->getPageCount('quiz') : ceil($quizTotal / 10));
            if ($totalQuizPages < 1) $totalQuizPages = 1;
            ?>

            <?php if ($totalQuizPages > 1): ?>
                <div class="px-6 py-4 border-t border-slate-200 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between gap-3">
                    <div class="text-xs text-slate-500 font-medium">
                        Halaman <strong class="text-slate-800"><?= $currentQuizPage ?></strong> dari <strong class="text-slate-800"><?= $totalQuizPages ?></strong>
                    </div>

                    <div class="flex items-center gap-1.5">
                        <?php if ($currentQuizPage > 1): ?>
                            <a href="<?= quizListPageUrl($currentQuizPage - 1, $quizSearch, $quizSort, $quizOrder) ?>" class="px-3 py-1.5 rounded-lg border border-slate-300 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                                &larr; Prev
                            </a>
                        <?php else: ?>
                            <span class="px-3 py-1.5 rounded-lg border border-slate-200 bg-slate-100 text-xs font-semibold text-slate-400 cursor-not-allowed">
                                &larr; Prev
                            </span>
                        <?php endif; ?>

                        <?php
                        $startQuizPage = max(1, $currentQuizPage - 2);
                        $endQuizPage   = min($totalQuizPages, $currentQuizPage + 2);
                        for ($qp = $startQuizPage; $qp <= $endQuizPage; $qp++):
                        ?>
                            <?php if ($qp === $currentQuizPage): ?>
                                <span class="px-3 py-1.5 rounded-lg bg-sky-600 text-white text-xs font-bold shadow-sm">
                                    <?= $qp ?>
                                </span>
                            <?php else: ?>
                                <a href="<?= quizListPageUrl($qp, $quizSearch, $quizSort, $quizOrder) ?>" class="px-3 py-1.5 rounded-lg border border-slate-300 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                                    <?= $qp ?>
                                </a>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <?php if ($currentQuizPage < $totalQuizPages): ?>
                            <a href="<?= quizListPageUrl($currentQuizPage + 1, $quizSearch, $quizSort, $quizOrder) ?>" class="px-3 py-1.5 rounded-lg border border-slate-300 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
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
<?php else: ?>
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mt-8 mb-4">
        <div class="min-w-0 flex-1">
            <h2 class="text-lg font-bold text-slate-800 leading-snug break-words break-all sm:break-words">Log peserta: <?= esc($selectedQuiz['title']) ?></h2>
            <p class="text-sm text-slate-500 mt-0.5"><?= (int) $summary['total_sessions'] ?> sesi tercatat untuk kuis ini. Pilih sesi untuk melihat rincian jawaban.</p>
        </div>
        <a class="text-sm font-semibold transition-colors text-sky-600 hover:text-sky-800 shrink-0" href="<?= base_url('dashboard/quizzes/logs') ?>">Pilih kuis lain &rarr;</a>
    </div>

    <section class="grid grid-cols-1 gap-4 mb-8 sm:grid-cols-2 lg:grid-cols-4" aria-label="Ringkasan log kuis">
        <div class="flex flex-col p-5 bg-white border shadow-sm rounded-xl border-slate-200">
            <span class="mb-1 text-xs font-semibold tracking-wider uppercase text-slate-500">Total sesi</span>
            <strong class="mb-1 text-2xl font-black text-slate-800"><?= (int) $summary['total_sessions'] ?></strong>
            <small class="mt-auto text-xs text-slate-500">Pengerjaan tercatat</small>
        </div>
        <div class="flex flex-col p-5 bg-white border shadow-sm rounded-xl border-slate-200">
            <span class="mb-1 text-xs font-semibold tracking-wider uppercase text-slate-500">Peserta unik</span>
            <strong class="mb-1 text-2xl font-black text-slate-800"><?= (int) $summary['unique_participants'] ?></strong>
            <small class="mt-auto text-xs text-slate-500">Berdasarkan nama peserta</small>
        </div>
        <div class="flex flex-col p-5 bg-white border shadow-sm rounded-xl border-slate-200">
            <span class="mb-1 text-xs font-semibold tracking-wider uppercase text-slate-500">Rata-rata nilai</span>
            <strong class="mb-1 text-2xl font-black text-slate-800"><?= $summary['average_score'] === null ? '-' : number_format((float) $summary['average_score'], 0) . '%' ?></strong>
            <small class="mt-auto text-xs text-slate-500">Seluruh sesi kuis ini</small>
        </div>
        <div class="flex flex-col p-5 bg-white border shadow-sm rounded-xl border-slate-200">
            <span class="mb-1 text-xs font-semibold tracking-wider uppercase text-slate-500">Aktivitas terbaru</span>
            <strong class="mb-1 text-lg font-bold text-slate-800"><?= ! empty($summary['latest_submission']) ? esc(date('d M Y', strtotime((string) $summary['latest_submission']))) : '-' ?></strong>
            <small class="mt-auto text-xs text-slate-500"><?= ! empty($summary['latest_submission']) ? esc(date('H:i', strtotime((string) $summary['latest_submission']))) . ' WIB' : 'Belum ada data' ?></small>
        </div>
    </section>

    <div class="overflow-hidden bg-white border shadow-sm rounded-xl border-slate-200">
        <!-- Search & Filter Bar -->
        <form method="get" action="<?= base_url('dashboard/quizzes/logs') ?>" class="flex flex-col sm:flex-row items-center justify-between gap-4 px-6 py-4 border-b border-slate-200 bg-slate-50/50">
            <input type="hidden" name="quiz_id" value="<?= (int) $selectedQuiz['id'] ?>">
            <?php if ($sort !== ''): ?><input type="hidden" name="sort" value="<?= esc($sort) ?>"><?php endif; ?>
            <?php if ($order !== ''): ?><input type="hidden" name="order" value="<?= esc($order) ?>"><?php endif; ?>

            <div class="relative w-full sm:w-80">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
                    </svg>
                </div>
                <input type="text" name="search" value="<?= esc($search) ?>" placeholder="Cari nama peserta..." class="block w-full pl-9 pr-8 py-2 text-sm text-slate-900 bg-white border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-colors placeholder:text-slate-400">
                <?php if ($search !== ''): ?>
                    <a href="<?= base_url('dashboard/quizzes/logs?quiz_id=' . (int) $selectedQuiz['id']) ?>" class="absolute inset-y-0 right-0 pr-2.5 flex items-center text-slate-400 hover:text-slate-600" title="Hapus pencarian">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </a>
                <?php endif; ?>
            </div>

            <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                Total: <?= $totalSessions ?> sesi
            </span>
        </form>

        <?php if (empty($sessions)): ?>
            <div class="px-6 py-16 text-center">
                <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full bg-slate-100">
                    <svg class="w-8 h-8 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                </div>
                <?php if ($search !== ''): ?>
                    <strong class="block mb-1 text-sm font-semibold text-slate-900">Peserta tidak ditemukan</strong>
                    <p class="mb-4 text-sm text-slate-500">Tidak ada peserta yang cocok dengan kata kunci "<?= esc($search) ?>".</p>
                    <a href="<?= base_url('dashboard/quizzes/logs?quiz_id=' . (int) $selectedQuiz['id']) ?>" class="inline-flex items-center text-sm font-semibold text-sky-600 hover:text-sky-800">
                        Reset pencarian
                    </a>
                <?php else: ?>
                    <strong class="block mb-1 text-sm font-semibold text-slate-900">Belum ada peserta</strong>
                    <p class="text-sm text-slate-500">Belum ada peserta yang mengisi kuis ini.</p>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50 select-none">
                        <tr>
                            <th scope="col" class="py-3.5 pl-6 pr-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                <a href="<?= sessionSortUrl('participant_name', $sort, $order, $selectedQuiz['id'], $search) ?>" class="inline-flex items-center gap-1.5 hover:text-sky-600 transition-colors" title="Urutkan berdasarkan Nama">
                                    <span>Nama</span>
                                    <?php if ($sort === 'participant_name'): ?>
                                        <span class="text-sky-600 font-bold"><?= $order === 'asc' ? '↑' : '↓' ?></span>
                                    <?php else: ?>
                                        <span class="text-slate-300">↕</span>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                <a href="<?= sessionSortUrl('participant_age', $sort, $order, $selectedQuiz['id'], $search) ?>" class="inline-flex items-center gap-1.5 hover:text-sky-600 transition-colors" title="Urutkan berdasarkan Umur">
                                    <span>Umur</span>
                                    <?php if ($sort === 'participant_age'): ?>
                                        <span class="text-sky-600 font-bold"><?= $order === 'asc' ? '↑' : '↓' ?></span>
                                    <?php else: ?>
                                        <span class="text-slate-300">↕</span>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Hasil</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                <a href="<?= sessionSortUrl('submitted_at', $sort, $order, $selectedQuiz['id'], $search) ?>" class="inline-flex items-center gap-1.5 hover:text-sky-600 transition-colors" title="Urutkan berdasarkan Waktu">
                                    <span>Waktu Submit</span>
                                    <?php if ($sort === 'submitted_at'): ?>
                                        <span class="text-sky-600 font-bold"><?= $order === 'asc' ? '↑' : '↓' ?></span>
                                    <?php else: ?>
                                        <span class="text-slate-300">↕</span>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th scope="col" class="py-3.5 pl-3 pr-6 text-right text-xs font-semibold text-slate-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        <?php foreach ($sessions as $session): ?>
                            <?php
                            $questionCount = max(0, (int) ($session['question_count'] ?? 0));
                            $correctCount  = max(0, (int) ($session['correct_count'] ?? 0));
                            $score         = $questionCount > 0 ? (int) round(($correctCount / $questionCount) * 100) : 0;
                            $isSelected    = (string) ($session['submission_id'] ?? '') === (string) $submissionId;

                            $scoreColor = 'text-emerald-700 bg-emerald-50 ring-emerald-600/20';
                            if ($score < 60) {
                                $scoreColor = 'text-red-700 bg-red-50 ring-red-600/10';
                            } elseif ($score < 80) {
                                $scoreColor = 'text-amber-700 bg-amber-50 ring-amber-600/20';
                            }
                            ?>
                            <tr class="hover:bg-slate-50/75 transition-colors group <?= $isSelected ? 'bg-sky-50/50' : '' ?>">
                                <td class="py-4 pl-6 pr-3 whitespace-nowrap">
                                    <strong class="text-sm font-semibold text-slate-900 block max-w-xs truncate" title="<?= esc($session['participant_name'] ?? '') ?>"><?= esc($session['participant_name'] ?? '-') ?></strong>
                                </td>
                                <td class="px-3 py-4 text-sm whitespace-nowrap text-slate-600">
                                    <?= esc($session['participant_age'] ?? '-') ?>
                                </td>
                                <td class="px-3 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset <?= $scoreColor ?>">
                                            <?= $score ?>%
                                        </span>
                                        <span class="text-xs text-slate-500"><?= $correctCount ?>/<?= $questionCount ?> benar</span>
                                    </div>
                                </td>
                                <td class="px-3 py-4 text-sm whitespace-nowrap text-slate-600">
                                    <?php $submittedAt = $session['submitted_at'] ?? $session['created_at'] ?? null; ?>
                                    <time datetime="<?= esc((string) $submittedAt, 'attr') ?>"><?= $submittedAt ? esc(date('d M Y, H:i', strtotime((string) $submittedAt))) : '-' ?></time>
                                </td>
                                <td class="relative py-4 pl-3 pr-6 text-sm font-medium text-right whitespace-nowrap">
                                    <a class="inline-flex items-center gap-1 transition-colors quiz-log-detail-button text-sky-600 hover:text-sky-800" href="<?= base_url('dashboard/quizzes/logs?quiz_id=' . (int) $selectedQuiz['id'] . '&submission_id=' . rawurlencode((string) ($session['submission_id'] ?? ''))) ?>" aria-label="Lihat jawaban <?= esc($session['participant_name'] ?? 'peserta') ?>">
                                        Lihat jawaban
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination Footer -->
            <?php
            $currentPage = (int) ($pager ? $pager->getCurrentPage('session') : 1);
            $totalPages  = (int) ($pager ? $pager->getPageCount('session') : ceil($totalSessions / 10));
            if ($totalPages < 1) $totalPages = 1;

            function sessionPageUrl($p, $quizId, $search, $sort, $order) {
                $params = ['quiz_id' => $quizId, 'page_session' => $p];
                if ($search !== '') $params['search'] = $search;
                if ($sort !== '') $params['sort'] = $sort;
                if ($order !== '') $params['order'] = $order;
                return base_url('dashboard/quizzes/logs') . '?' . http_build_query($params);
            }
            ?>

            <?php if ($totalPages > 1): ?>
                <div class="px-6 py-4 border-t border-slate-200 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between gap-3">
                    <div class="text-xs text-slate-500 font-medium">
                        Halaman <strong class="text-slate-800"><?= $currentPage ?></strong> dari <strong class="text-slate-800"><?= $totalPages ?></strong>
                    </div>

                    <div class="flex items-center gap-1.5">
                        <?php if ($currentPage > 1): ?>
                            <a href="<?= sessionPageUrl($currentPage - 1, $selectedQuiz['id'], $search, $sort, $order) ?>" class="px-3 py-1.5 rounded-lg border border-slate-300 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
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
                                <a href="<?= sessionPageUrl($p, $selectedQuiz['id'], $search, $sort, $order) ?>" class="px-3 py-1.5 rounded-lg border border-slate-300 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                                    <?= $p ?>
                                </a>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <?php if ($currentPage < $totalPages): ?>
                            <a href="<?= sessionPageUrl($currentPage + 1, $selectedQuiz['id'], $search, $sort, $order) ?>" class="px-3 py-1.5 rounded-lg border border-slate-300 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
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
<?php endif; ?>

<!-- Modal -->
<div id="quizAnswerModal" class="fixed inset-0 z-50 flex items-center justify-center hidden p-4 sm:p-6" role="dialog" aria-modal="true" aria-labelledby="quizAnswerModalTitle">
    <div class="fixed inset-0 transition-opacity bg-slate-900/50 backdrop-blur-sm"></div>
    <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-xl overflow-hidden flex flex-col max-h-[90vh]">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200 bg-slate-50">
            <div>
                <h2 id="quizAnswerModalTitle" class="text-lg font-bold text-slate-800">Rincian Jawaban</h2>
                <p id="quizAnswerModalSubtitle" class="text-sm text-slate-500"></p>
            </div>
            <button type="button" id="quizAnswerModalClose" class="p-2 transition-colors rounded-lg text-slate-400 hover:text-slate-500 hover:bg-slate-200" aria-label="Tutup rincian jawaban">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="relative flex-1 p-6 overflow-y-auto custom-scrollbar">
            <div id="quizAnswerLoading" class="absolute inset-0 z-10 flex items-center justify-center bg-white/80" style="display: none;">
                <div class="flex items-center gap-2 text-sky-600">
                    <svg class="w-5 h-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-sm font-medium">Memuat jawaban...</span>
                </div>
            </div>

            <div class="flex items-center justify-between pb-4 mb-6 border-b border-slate-100">
                <span class="text-sm font-semibold text-slate-700">Skor Total</span>
                <span id="quizAnswerTotalScore" class="inline-flex items-center px-3 py-1 text-sm font-bold rounded-md bg-sky-50 text-sky-700 ring-1 ring-inset ring-sky-600/20"></span>
            </div>

            <ol id="quizAnswerList" class="space-y-6"></ol>
        </div>
    </div>
</div>

<?php if (! empty($selectedQuiz)): ?>
    <script>
        (() => {
            const search = document.getElementById('participant-search');
            const rows = Array.from(document.querySelectorAll('[data-participant-name]'));
            const count = document.getElementById('visible-session-count');
            const modal = document.getElementById('quizAnswerModal');
            const closeButton = document.getElementById('quizAnswerModalClose');
            const subtitle = document.getElementById('quizAnswerModalSubtitle');
            const totalScore = document.getElementById('quizAnswerTotalScore');
            const answerList = document.getElementById('quizAnswerList');
            const loading = document.getElementById('quizAnswerLoading');
            const detailButtons = Array.from(document.querySelectorAll('.quiz-log-detail-button'));
            let lastFocused = null;

            if (search && count) {
                search.addEventListener('input', () => {
                    const term = search.value.trim().toLocaleLowerCase('id-ID');
                    let visible = 0;
                    rows.forEach((row) => {
                        const match = row.dataset.participantName.includes(term);
                        row.hidden = !match;
                        visible += match ? 1 : 0;
                    });
                    count.textContent = `${visible} sesi`;
                });
            }

            function setModalContent(payload) {
                const participantName = payload.selectedSession?.participant_name || 'Peserta';
                const age = payload.selectedSession?.participant_age ? `, ${payload.selectedSession.participant_age} tahun` : '';
                subtitle.textContent = `${participantName}${age}. ${payload.details.length} pertanyaan dijawab.`;
                const total = payload.selectedSession?.question_count ? `${payload.selectedSession.correct_count}/${payload.selectedSession.question_count} benar` : '';
                totalScore.textContent = total;
                const escapeHtml = (value) => String(value ?? '-').replace(/[&<>'"]/g, (char) => ({
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    "'": '&#39;',
                    '\"': '&quot;'
                } [char]));

                answerList.innerHTML = payload.details.map((detail, index) => {
                    const options = [null, detail.option_a, detail.option_b, detail.option_c, detail.option_d];
                    const answer = Number(detail.answer) || 0;
                    const correct = Number(detail.correct_option) || 0;
                    const isCorrect = detail.is_correct === '1' || detail.is_correct === 1 || detail.is_correct === true;

                    const badgeClass = isCorrect ?
                        'bg-green-50 text-green-700 ring-green-600/20' :
                        'bg-red-50 text-red-700 ring-red-600/10';

                    return `
                        <li class="p-5 border bg-slate-50 rounded-xl border-slate-200">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs font-bold tracking-widest uppercase text-slate-500">Pertanyaan ${index + 1}</span>
                                <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset ${badgeClass}">${isCorrect ? 'Benar' : 'Salah'}</span>
                            </div>
                            <h3 class="mb-4 text-sm font-semibold text-slate-800">${escapeHtml(detail.question)}</h3>
                            
                            <div class="space-y-2 text-sm">
                                <div class="flex flex-col sm:flex-row sm:items-baseline gap-1 sm:gap-2 p-2.5 rounded-lg ${isCorrect ? 'bg-green-100/50' : 'bg-red-100/50'}">
                                    <span class="w-32 text-xs font-medium text-slate-500 shrink-0">Jawaban peserta:</span>
                                    <strong class="${isCorrect ? 'text-green-800' : 'text-red-800'}">${escapeHtml(answer >= 1 && answer <= 4 ? String.fromCharCode(64 + answer) + '. ' + (options[answer] || '-') : '-')}</strong>
                                </div>
                                ${!isCorrect ? `
                                <div class="flex flex-col sm:flex-row sm:items-baseline gap-1 sm:gap-2 p-2.5 rounded-lg bg-white border border-slate-200">
                                    <span class="w-32 text-xs font-medium text-slate-500 shrink-0">Jawaban benar:</span>
                                    <strong class="text-slate-800">${escapeHtml(correct >= 1 && correct <= 4 ? String.fromCharCode(64 + correct) + '. ' + (options[correct] || '-') : '-')}</strong>
                                </div>
                                ` : ''}
                            </div>
                        </li>
                    `;
                }).join('');
            }

            function openModal() {
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
                closeButton.focus();
            }

            function closeModal() {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
                if (lastFocused) lastFocused.focus();
            }

            async function fetchSubmissionDetails(url) {
                const response = await fetch(`${url}&ajax=1`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                });
                if (!response.ok) {
                    throw new Error('Gagal memuat rincian jawaban.');
                }
                return response.json();
            }

            detailButtons.forEach((button) => {
                button.addEventListener('click', async (event) => {
                    event.preventDefault();
                    lastFocused = button;
                    openModal();
                    loading.style.display = 'flex';
                    answerList.innerHTML = '';
                    try {
                        const payload = await fetchSubmissionDetails(button.href);
                        if (!payload || !payload.details) {
                            throw new Error('Data jawaban tidak tersedia.');
                        }
                        setModalContent(payload);
                    } catch (error) {
                        // eslint-disable-next-line no-console
                        console.error(error);
                        alert('Terjadi kesalahan saat memuat jawaban peserta. Silakan coba lagi.');
                        closeModal();
                    } finally {
                        loading.style.display = 'none';
                    }
                });
            });

            closeButton.addEventListener('click', closeModal);
            modal.addEventListener('click', (event) => {
                if (event.target === modal || event.target.closest('.fixed.inset-0.bg-slate-900\\/50')) {
                    closeModal();
                }
            });
            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
                    closeModal();
                }
            });
        })();
    </script>
<?php endif; ?>