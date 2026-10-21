<section class="border-b bg-slate-50/70 border-slate-200/80">
    <div class="container max-w-5xl py-6 sm:py-10">

        <!-- Breadcrumb -->
        <nav class="mb-5 text-xs sm:text-sm" aria-label="Breadcrumb">
            <ol class="flex flex-wrap items-center gap-2 text-slate-500">
                <li>
                    <a href="<?= base_url('/') ?>" class="font-medium transition-colors hover:text-blue-600">
                        Beranda
                    </a>
                </li>
                <li aria-hidden="true" class="text-slate-400">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m9 5 7 7-7 7" />
                    </svg>
                </li>
                <li>
                    <a href="<?= base_url('artikel') ?>" class="font-medium transition-colors hover:text-blue-600">
                        Artikel
                    </a>
                </li>
                <li aria-hidden="true" class="text-slate-400">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m9 5 7 7-7 7" />
                    </svg>
                </li>
                <li class="font-semibold text-slate-800 truncate max-w-[200px] sm:max-w-xs" aria-current="page">
                    <?= esc($article['title']) ?>
                </li>
            </ol>
        </nav>

        <?php $articleDateStr = (! empty($article['created_at']) && strtotime($article['created_at']) > 0) ? $article['created_at'] : date('Y-m-d H:i:s'); ?>

        <!-- Hero Card Header (Clean & Minimal) -->
        <div class="p-5 bg-white border shadow-sm border-slate-200/90 rounded-2xl sm:p-7">
            <div class="flex flex-col-reverse justify-between gap-5 sm:flex-row sm:gap-7 sm:items-center">

                <!-- Left Content -->
                <div class="flex-1 min-w-0">
                    <!-- Category Tag & Date (No Author) -->
                    <div class="flex items-center gap-2.5 mb-2.5 flex-wrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 text-[11px] font-bold text-blue-700 bg-blue-50 border border-blue-200/60 rounded-md">
                            <?= esc($article['tag'] ?: 'Artikel') ?>
                        </span>
                        <span class="text-slate-300">•</span>
                        <time datetime="<?= esc(date('Y-m-d', strtotime($articleDateStr))) ?>" class="flex items-center gap-1 text-[11px] sm:text-xs font-medium text-slate-500">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span><?= esc(function_exists('tanggal_indonesia') ? tanggal_indonesia($articleDateStr) : date('d F Y', strtotime($articleDateStr))) ?></span>
                        </time>
                    </div>

                    <!-- Title (Proportional Font Size, max 4 lines) -->
                    <h1 class="text-lg sm:text-xl lg:text-2xl font-bold leading-snug tracking-tight text-slate-900 break-words [overflow-wrap:anywhere] line-clamp-4">
                        <?= esc($article['title']) ?>
                    </h1>

                    <!-- Excerpt -->
                    <p class="mt-2 text-xs font-normal leading-relaxed sm:text-sm text-slate-600 line-clamp-3">
                        <?= esc(
                            $article['description']
                                ?: mb_strimwidth(
                                    strip_tags($article['content']),
                                    0,
                                    200,
                                    '...'
                                )
                        ) ?>
                    </p>
                </div>

                <!-- Right Featured Image / Default Fallback -->
                <div class="w-full sm:w-48 md:w-56 lg:w-64 shrink-0">
                    <div class="overflow-hidden rounded-lg sm:rounded-xl border border-slate-200/80 shadow-xs bg-slate-100 aspect-[16/10] sm:aspect-[4/3]">
                        <?php if (! empty($article['image'])): ?>
                            <img
                                src="<?= base_url($article['image']) ?>"
                                alt="<?= esc($article['title']) ?>"
                                class="object-cover w-full h-full"
                                loading="eager">
                        <?php else: ?>
                            <div class="flex flex-col items-center justify-center w-full h-full p-4 bg-gradient-to-br from-slate-50 via-sky-50/40 to-blue-50/60">
                                <div class="p-2.5 bg-white rounded-xl shadow-xs border border-slate-200/80 mb-1.5 text-blue-600">
                                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5" />
                                    </svg>
                                </div>
                                <span class="text-[11px] font-semibold text-slate-500">Artikel BNN</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>


<!-- Isi Artikel -->
<article class="container max-w-3xl py-12 sm:py-16">

    <div class="leading-8 prose prose-slate max-w-none">
        <?= $article['content'] ?>
    </div>

</article>

<!-- Section Komentar -->
<section id="komentar" class="border-t border-slate-200 bg-slate-50/50 py-12 sm:py-16">
    <div class="container max-w-3xl">

        <!-- Flash messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                <span><?= esc(session()->getFlashdata('success')) ?></span>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-medium flex items-center gap-2">
                <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                <span><?= esc(session()->getFlashdata('error')) ?></span>
            </div>
        <?php endif; ?>

        <h3 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
            <svg class="w-6 h-6 text-sky-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
            </svg>
            Komentar (<?= esc($totalComments ?? count($comments ?? [])) ?>)
        </h3>

        <!-- Form Tambah Komentar -->
        <div class="mb-10 p-6 bg-white border border-slate-200/90 rounded-2xl shadow-xs">
            <h4 class="text-sm font-bold text-slate-800 mb-4">Tulis Komentar</h4>
            <form method="post" action="<?= base_url('artikel/' . $article['id'] . '/komentar') ?>" class="space-y-4">
                <?= csrf_field() ?>
                <div>
                    <label for="name" class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                    <input id="name" name="name" type="text" value="<?= esc(old('name')) ?>" required maxlength="100" placeholder="Masukkan nama Anda" class="w-full rounded-lg border border-slate-300 py-2.5 px-3.5 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-600 focus:border-transparent bg-slate-50 focus:bg-white transition-colors">
                </div>
                <div>
                    <label for="comment" class="block text-xs font-semibold text-slate-700 mb-1">Komentar</label>
                    <textarea id="comment" name="comment" rows="3" required maxlength="1000" placeholder="Tulis tanggapan atau pertanyaan Anda mengenai artikel ini..." class="w-full rounded-lg border border-slate-300 py-2.5 px-3.5 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-600 focus:border-transparent bg-slate-50 focus:bg-white transition-colors resize-none"><?= esc(old('comment')) ?></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white bg-sky-700 hover:bg-sky-800 rounded-lg shadow-xs transition-colors focus:outline-none focus:ring-2 focus:ring-sky-600 focus:ring-offset-2">
                        Kirim Komentar
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- Daftar Komentar -->
        <?php if (! empty($comments)): ?>
            <div id="comments-container" class="space-y-4">
                <?= view('articles/_comment_items', ['comments' => $comments]) ?>
            </div>

            <?php if (! empty($hasMore)): ?>
                <div id="load-more-container" class="mt-6 text-center">
                    <button id="load-more-comments-btn" data-offset="<?= count($comments) ?>" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-sky-700 bg-sky-50 hover:bg-sky-100 border border-sky-200 rounded-lg transition-colors cursor-pointer">
                        <span>Muat Komentar Lainnya</span>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                </div>

                <script>
                document.getElementById('load-more-comments-btn')?.addEventListener('click', function() {
                    const btn = this;
                    const offset = parseInt(btn.getAttribute('data-offset') || '0', 10);
                    btn.disabled = true;
                    btn.querySelector('span').textContent = 'Memuat...';

                    fetch('<?= base_url("artikel/{$article['id']}/komentar-lainnya") ?>?offset=' + offset)
                        .then(res => res.json())
                        .then(data => {
                            if (data.html) {
                                document.getElementById('comments-container').insertAdjacentHTML('beforeend', data.html);
                                btn.setAttribute('data-offset', offset + 5);
                            }
                            if (!data.hasMore) {
                                document.getElementById('load-more-container')?.remove();
                            } else {
                                btn.disabled = false;
                                btn.querySelector('span').textContent = 'Muat Komentar Lainnya';
                            }
                        })
                        .catch(() => {
                            btn.disabled = false;
                            btn.querySelector('span').textContent = 'Coba Lagi';
                        });
                });
                </script>
            <?php endif; ?>
        <?php else: ?>
            <div class="text-center py-8 text-slate-500 bg-white border border-slate-200/80 rounded-xl p-6">
                <svg class="mx-auto h-10 w-10 text-slate-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                <p class="text-sm font-medium">Belum ada komentar.</p>
                <p class="text-xs text-slate-400 mt-0.5">Jadilah yang pertama memberikan komentar pada artikel ini.</p>
            </div>
        <?php endif; ?>

    </div>
</section>

<style>
/* Rich Text / Prose Content Formatting */
.prose { color: #334155; max-width: 100%; }
.prose h1 { font-size: 2.25rem !important; font-weight: 800 !important; margin-top: 2rem !important; margin-bottom: 1rem !important; line-height: 1.25 !important; color: #0f172a !important; }
.prose h2 { font-size: 1.5rem !important; font-weight: 700 !important; margin-top: 1.75rem !important; margin-bottom: 0.75rem !important; line-height: 1.35 !important; color: #0f172a !important; }
.prose h3 { font-size: 1.25rem !important; font-weight: 700 !important; margin-top: 1.5rem !important; margin-bottom: 0.5rem !important; line-height: 1.4 !important; color: #1e293b !important; }
.prose h4 { font-size: 1.125rem !important; font-weight: 600 !important; margin-top: 1.25rem !important; margin-bottom: 0.5rem !important; color: #1e293b !important; }
.prose p { margin-top: 1rem !important; margin-bottom: 1rem !important; line-height: 1.75 !important; color: #334155 !important; }
.prose ul { list-style-type: disc !important; padding-left: 1.75rem !important; margin-top: 1rem !important; margin-bottom: 1rem !important; }
.prose ol { list-style-type: decimal !important; padding-left: 1.75rem !important; margin-top: 1rem !important; margin-bottom: 1rem !important; }
.prose li { margin-top: 0.375rem !important; margin-bottom: 0.375rem !important; line-height: 1.6 !important; display: list-item !important; }
.prose li > ul, .prose li > ol { margin-top: 0.25rem !important; margin-bottom: 0.25rem !important; }
.prose strong, .prose b { font-weight: 700 !important; color: #0f172a !important; }
.prose em, .prose i { font-style: italic !important; }
.prose u { text-decoration: underline !important; }
.prose blockquote { border-left: 4px solid #0284c7 !important; padding-left: 1rem !important; font-style: italic !important; color: #475569 !important; margin-top: 1.5rem !important; margin-bottom: 1.5rem !important; background: #f8fafc !important; padding-top: 0.5rem !important; padding-bottom: 0.5rem !important; border-radius: 0 0.5rem 0.5rem 0 !important; }
.prose a { color: #0284c7 !important; text-decoration: underline !important; font-weight: 500 !important; }
.prose a:hover { color: #075985 !important; }
.prose img { max-width: 100% !important; height: auto !important; border-radius: 0.75rem !important; margin-top: 1.5rem !important; margin-bottom: 1.5rem !important; }
.prose table { width: 100% !important; border-collapse: collapse !important; margin-top: 1.5rem !important; margin-bottom: 1.5rem !important; }
.prose th, .prose td { border: 1px solid #e2e8f0 !important; padding: 0.75rem !important; text-align: left !important; }
.prose th { background-color: #f8fafc !important; font-weight: 600 !important; }
</style>