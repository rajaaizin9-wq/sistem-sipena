<div class="mb-8">
    <p class="mb-1 text-xs font-bold tracking-widest uppercase text-bnn-600">Manajemen Konten</p>
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-slate-800">Kelola kuis</h1>
            <p class="mt-1 text-sm text-slate-500">Atur pertanyaan edukasi yang dapat dikerjakan pengguna.</p>
        </div>
        <div class="flex items-center gap-3 shrink-0">
            <a class="inline-flex items-center justify-center gap-2 rounded-lg bg-white border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition-all hover:bg-slate-50" href="<?= base_url('dashboard/quizzes/logs') ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
                Log peserta
            </a>
            <a class="inline-flex items-center justify-center gap-2 rounded-lg bg-bnn-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:bg-bnn-800" href="<?= base_url('dashboard/quizzes/create') ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Tambah kuis
            </a>
        </div>
    </div>
</div>

<?= view('dashboard/partials/flash_messages') ?>

<?php 
$quizzes = $quizzes ?? []; 
$search  = $search ?? '';
$sort    = $sort ?? 'created_at';
$order   = $order ?? 'desc';
$total   = $total ?? count($quizzes);

function quizSortUrl($col, $currentSort, $currentOrder, $search) {
    $nextOrder = ($currentSort === $col && $currentOrder === 'asc') ? 'desc' : 'asc';
    $params = ['sort' => $col, 'order' => $nextOrder];
    if ($search !== '') {
        $params['search'] = $search;
    }
    return base_url('dashboard/quizzes') . '?' . http_build_query($params);
}
?>

<div class="mt-6 overflow-hidden bg-white border shadow-sm rounded-xl border-slate-200">
    <!-- Header Filter & Search Bar -->
    <form method="get" action="<?= base_url('dashboard/quizzes') ?>" class="border-b border-slate-200 bg-slate-50/50 px-6 py-4 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="relative w-full sm:w-80">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
                </svg>
            </div>
            <input type="text" name="search" value="<?= esc($search) ?>" placeholder="Cari judul kuis..." class="block w-full pl-9 pr-8 py-2 text-sm text-slate-900 bg-white border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-colors placeholder:text-slate-400">
            <?php if ($search !== ''): ?>
                <a href="<?= base_url('dashboard/quizzes') ?>" class="absolute inset-y-0 right-0 pr-2.5 flex items-center text-slate-400 hover:text-slate-600" title="Hapus pencarian">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </a>
            <?php endif; ?>
            <?php if ($sort !== ''): ?><input type="hidden" name="sort" value="<?= esc($sort) ?>"><?php endif; ?>
            <?php if ($order !== ''): ?><input type="hidden" name="order" value="<?= esc($order) ?>"><?php endif; ?>
        </div>

        <div class="flex items-center gap-2 text-xs font-semibold text-slate-500">
            <span class="inline-flex items-center rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 ring-1 ring-inset ring-blue-700/10">
                Total: <?= $total ?> kuis
            </span>
        </div>
    </form>

    <?php if (empty($quizzes)): ?>
        <div class="px-6 py-16 text-center">
            <div class="flex items-center justify-center mx-auto mb-4 rounded-full w-14 h-14 bg-slate-100">
                <svg class="w-7 h-7 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                    <path d="M12 17h.01"></path>
                </svg>
            </div>
            <?php if ($search !== ''): ?>
                <strong class="block mb-1 text-sm font-semibold text-slate-900">Kuis tidak ditemukan</strong>
                <p class="mb-4 text-sm text-slate-500">Tidak ada kuis yang cocok dengan kata kunci "<?= esc($search) ?>".</p>
                <a href="<?= base_url('dashboard/quizzes') ?>" class="inline-flex items-center text-sm font-semibold text-bnn-600 hover:text-bnn-800">
                    Reset pencarian
                </a>
            <?php else: ?>
                <strong class="block mb-1 text-sm font-semibold text-slate-900">Belum ada kuis</strong>
                <p class="mb-6 text-sm text-slate-500">Tambahkan kuis pertama untuk mulai menguji pengetahuan pengguna.</p>
                <a href="<?= base_url('dashboard/quizzes/create') ?>" class="inline-flex items-center min-h-10 gap-1.5 px-4 py-2 text-sm font-semibold transition rounded-lg text-bnn-800 bg-slate-50 hover:bg-bnn-50 hover:text-bnn-950">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M12 5v14M5 12h14"></path>
                    </svg>
                    Tambah kuis
                </a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[720px] table-fixed divide-y divide-slate-200">
                <colgroup>
                    <col class="w-[30%]">
                    <col class="w-[38%]">
                    <col class="w-[17%]">
                    <col class="w-[15%]">
                </colgroup>

                <thead class="bg-slate-50 select-none">
                    <tr>
                        <th scope="col" class="py-3.5 pl-6 pr-3 text-left text-xs font-semibold tracking-wider text-slate-600 uppercase">
                            <a href="<?= quizSortUrl('title', $sort, $order, $search) ?>" class="inline-flex items-center gap-1.5 hover:text-sky-600 transition-colors" title="Urutkan berdasarkan Judul">
                                <span>Judul Kuis</span>
                                <?php if ($sort === 'title'): ?>
                                    <span class="text-sky-600 font-bold"><?= $order === 'asc' ? '↑' : '↓' ?></span>
                                <?php else: ?>
                                    <span class="text-slate-300">↕</span>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold tracking-wider text-slate-600 uppercase">
                            <a href="<?= quizSortUrl('description', $sort, $order, $search) ?>" class="inline-flex items-center gap-1.5 hover:text-sky-600 transition-colors" title="Urutkan berdasarkan Deskripsi">
                                <span>Deskripsi</span>
                                <?php if ($sort === 'description'): ?>
                                    <span class="text-sky-600 font-bold"><?= $order === 'asc' ? '↑' : '↓' ?></span>
                                <?php else: ?>
                                    <span class="text-slate-300">↕</span>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold tracking-wider text-slate-600 uppercase">
                            <a href="<?= quizSortUrl('created_at', $sort, $order, $search) ?>" class="inline-flex items-center gap-1.5 hover:text-sky-600 transition-colors" title="Urutkan berdasarkan Tanggal">
                                <span>Dibuat Pada</span>
                                <?php if ($sort === 'created_at'): ?>
                                    <span class="text-sky-600 font-bold"><?= $order === 'asc' ? '↑' : '↓' ?></span>
                                <?php else: ?>
                                    <span class="text-slate-300">↕</span>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th scope="col" class="py-3.5 pl-3 pr-6 text-right text-xs font-semibold tracking-wider text-slate-600 uppercase">Aksi</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-slate-100">
                    <?php foreach ($quizzes as $quiz): ?>
                        <tr class="transition-colors group hover:bg-slate-50/75">
                            <td class="py-4 pl-6 pr-4 align-top">
                                <p class="text-sm font-medium leading-6 break-words [overflow-wrap:anywhere] transition-colors text-slate-900 group-hover:text-sky-800 line-clamp-3" title="<?= esc($quiz['title'] ?? '') ?>">
                                    <?= esc($quiz['title'] ?? '-') ?>
                                </p>
                            </td>

                            <td class="px-3 py-4 align-top max-w-[15rem] sm:max-w-xs md:max-w-sm">
                                <p class="text-sm leading-6 break-words text-slate-600 line-clamp-2">
                                    <?= esc($quiz['description'] ?? '-') ?>
                                </p>
                            </td>

                            <td class="px-3 py-4 text-sm align-top text-slate-600">
                                <span class="whitespace-nowrap">
                                    <?= esc($quiz['created_at'] ?? '-') ?>
                                </span>
                            </td>

                            <td class="py-4 pl-3 pr-6 text-sm font-medium text-right align-top">
                                <div class="flex items-center justify-end gap-3">
                                    <button type="button" onclick="openQrModal('<?= esc(base_url('quiz/' . $quiz['id']), 'js') ?>', '<?= esc($quiz['title'], 'js') ?>')" class="transition-colors text-slate-400 hover:text-sky-600 cursor-pointer" title="Bagikan & QR Code Kuis">
                                        <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="3" width="7" height="7" rx="1"></rect>
                                            <rect x="14" y="3" width="7" height="7" rx="1"></rect>
                                            <rect x="3" y="14" width="7" height="7" rx="1"></rect>
                                            <path d="M14 14h3v3h-3z"></path>
                                            <path d="M17 17h4v4h-4z"></path>
                                            <path d="M14 20h3v1h-3z"></path>
                                            <path d="M20 14v3"></path>
                                        </svg>
                                    </button>

                                    <a href="<?= base_url('dashboard/quizzes/edit/' . esc($quiz['id'], 'url')) ?>" class="transition-colors text-slate-400 hover:text-bnn-600" title="Edit kuis">
                                        <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path d="M12 20h9"></path>
                                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                        </svg>
                                    </a>

                                    <form method="post" action="<?= base_url('dashboard/quizzes/delete/' . esc($quiz['id'], 'url')) ?>" class="m-0" onsubmit="return confirmDelete(this, 'Hapus kuis ini secara permanen?')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="transition-colors cursor-pointer text-slate-400 hover:text-red-600" title="Hapus kuis">
                                            <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path d="M3 6h18"></path>
                                                <path d="M8 6V4h8v2"></path>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path>
                                                <path d="M10 11v6M14 11v6"></path>
                                            </svg>
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
        $currentPage = (int) ($pager ? $pager->getCurrentPage('quiz') : 1);
        $totalPages  = (int) ($pager ? $pager->getPageCount('quiz') : ceil($total / 10));
        if ($totalPages < 1) $totalPages = 1;

        function quizPageUrl($p, $search, $sort, $order) {
            $params = ['page_quiz' => $p];
            if ($search !== '') $params['search'] = $search;
            if ($sort !== '') $params['sort'] = $sort;
            if ($order !== '') $params['order'] = $order;
            return base_url('dashboard/quizzes') . '?' . http_build_query($params);
        }
        ?>

        <?php if ($totalPages > 1): ?>
            <div class="px-6 py-4 border-t border-slate-200 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="text-xs text-slate-500 font-medium">
                    Halaman <strong class="text-slate-800"><?= $currentPage ?></strong> dari <strong class="text-slate-800"><?= $totalPages ?></strong>
                </div>

                <div class="flex items-center gap-1.5">
                    <?php if ($currentPage > 1): ?>
                        <a href="<?= quizPageUrl($currentPage - 1, $search, $sort, $order) ?>" class="px-3 py-1.5 rounded-lg border border-slate-300 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
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
                            <a href="<?= quizPageUrl($p, $search, $sort, $order) ?>" class="px-3 py-1.5 rounded-lg border border-slate-300 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                                <?= $p ?>
                            </a>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <?php if ($currentPage < $totalPages): ?>
                        <a href="<?= quizPageUrl($currentPage + 1, $search, $sort, $order) ?>" class="px-3 py-1.5 rounded-lg border border-slate-300 bg-white text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
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

<!-- Modal QR Code Share -->
<div id="qrModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex min-h-screen items-center justify-center p-4 text-center">
        <div class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm" onclick="closeQrModal()"></div>
        
        <div class="relative w-full max-w-sm sm:max-w-md my-8 transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all">
            <div class="bg-gradient-to-r from-bnn-900 to-sky-900 px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-2.5 text-white">
                    <div class="p-2 bg-white/10 rounded-lg">
                        <svg class="w-5 h-5 text-sky-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="7" height="7" rx="1"></rect>
                            <rect x="14" y="3" width="7" height="7" rx="1"></rect>
                            <rect x="3" y="14" width="7" height="7" rx="1"></rect>
                            <path d="M14 14h3v3h-3z"></path>
                            <path d="M17 17h4v4h-4z"></path>
                            <path d="M14 20h3v1h-3z"></path>
                            <path d="M20 14v3"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-white">Bagikan Kuis</h3>
                        <p class="text-xs text-sky-200">Pindai QR Code untuk menuju kuis</p>
                    </div>
                </div>
                <button type="button" onclick="closeQrModal()" class="text-white/70 hover:text-white p-1 rounded-lg hover:bg-white/10 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="p-6 text-center">
                <h4 id="qrModalQuizTitle" class="text-base font-bold text-slate-800 mb-1 line-clamp-2 px-2 break-words"></h4>
                <p class="text-xs text-slate-500 mb-5">Tunjukkan QR code ini kepada peserta kuis untuk dipindai.</p>

                <!-- QR Code Box -->
                <div class="inline-flex flex-col items-center justify-center p-4 bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl mb-5 shadow-inner">
                    <div id="qrcode" class="p-3 bg-white rounded-xl shadow-md border border-slate-100 flex items-center justify-center min-w-[180px] min-h-[180px]"></div>
                    <span class="mt-2 text-[11px] font-semibold text-slate-400 tracking-wide uppercase">BNN Kota Tanjungpinang</span>
                </div>

                <!-- Link & Copy -->
                <div class="mb-5">
                    <label class="block text-left text-xs font-semibold text-slate-600 mb-1.5">Tautan Kuis Tujuan:</label>
                    <div class="flex items-center gap-2">
                        <input type="text" id="qrModalQuizUrl" readonly class="w-full px-3 py-2 text-xs font-mono bg-slate-100 border border-slate-200 rounded-lg text-slate-700 focus:outline-none select-all">
                        <button type="button" id="copyUrlBtn" onclick="copyQuizUrl()" class="shrink-0 inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-white bg-sky-600 hover:bg-sky-700 active:bg-sky-800 rounded-lg transition-colors shadow-sm">
                            <svg id="copyIcon" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            <span id="copyText">Salin</span>
                        </button>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeQrModal()" class="px-4 py-2 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors">
                        Tutup
                    </button>
                    <button type="button" onclick="downloadQrCode()" class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-semibold text-white bg-bnn-600 hover:bg-bnn-800 rounded-lg shadow-sm transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Unduh QR Code
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    let currentQrUrl = '';
    let currentQuizTitle = '';

    function openQrModal(url, title) {
        currentQrUrl = url;
        currentQuizTitle = title;

        document.getElementById('qrModalQuizTitle').innerText = title;
        document.getElementById('qrModalQuizUrl').value = url;
        
        const qrcodeContainer = document.getElementById('qrcode');
        qrcodeContainer.innerHTML = '';

        if (typeof QRCode !== 'undefined') {
            new QRCode(qrcodeContainer, {
                text: url,
                width: 180,
                height: 180,
                colorDark: '#0f172a',
                colorLight: '#ffffff',
                correctLevel: QRCode.CorrectLevel.H
            });
        } else {
            const img = document.createElement('img');
            img.src = 'https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=' + encodeURIComponent(url);
            img.alt = 'QR Code';
            img.className = 'w-[180px] h-[180px] object-contain';
            qrcodeContainer.appendChild(img);
        }

        document.getElementById('qrModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeQrModal() {
        document.getElementById('qrModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        resetCopyButton();
    }

    function copyQuizUrl() {
        const input = document.getElementById('qrModalQuizUrl');
        navigator.clipboard.writeText(input.value).then(() => {
            const copyText = document.getElementById('copyText');
            const copyBtn = document.getElementById('copyUrlBtn');
            copyText.innerText = 'Tersalin!';
            copyBtn.classList.remove('bg-sky-600', 'hover:bg-sky-700');
            copyBtn.classList.add('bg-emerald-600', 'hover:bg-emerald-700');
            setTimeout(resetCopyButton, 2000);
        }).catch(() => {
            input.select();
            document.execCommand('copy');
            alert('Tautan berhasil disalin!');
        });
    }

    function resetCopyButton() {
        const copyText = document.getElementById('copyText');
        const copyBtn = document.getElementById('copyUrlBtn');
        if (copyText && copyBtn) {
            copyText.innerText = 'Salin';
            copyBtn.classList.remove('bg-emerald-600', 'hover:bg-emerald-700');
            copyBtn.classList.add('bg-sky-600', 'hover:bg-sky-700');
        }
    }

    function downloadQrCode() {
        const container = document.getElementById('qrcode');
        const img = container.querySelector('img');
        const canvas = container.querySelector('canvas');
        
        let imgData = '';
        if (canvas) {
            imgData = canvas.toDataURL('image/png');
        } else if (img && img.src) {
            imgData = img.src;
        }

        if (!imgData) {
            alert('Gagal mengunduh QR code.');
            return;
        }

        const a = document.createElement('a');
        a.href = imgData;
        const filename = 'QR-Kuis-' + currentQuizTitle.replace(/[^a-zA-Z0-9]/g, '_') + '.png';
        a.download = filename;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !document.getElementById('qrModal').classList.contains('hidden')) {
            closeQrModal();
        }
    });
</script>