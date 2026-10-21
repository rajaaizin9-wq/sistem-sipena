<section class="py-6 sm:py-10 bg-slate-50/70">
    <div class="container">

        <!-- Section Header -->
        <div class="flex flex-col gap-4 mb-6 sm:flex-row sm:items-end sm:justify-between sm:mb-8">
            <div class="max-w-xl">
                <h2 class="text-2xl font-bold tracking-tight sm:text-3xl text-slate-900">
                    Artikel & Kegiatan
                </h2>
                <p class="mt-1 text-xs sm:text-sm text-slate-600">
                    Baca informasi, berita, dan edukasi seputar pencegahan penyalahgunaan narkotika.
                </p>
            </div>

            <a href="<?= base_url('artikel') ?>"
                class="inline-flex items-center gap-2 text-xs font-semibold text-blue-600 transition-colors sm:text-sm hover:text-blue-800 shrink-0">
                <span>Semua Artikel</span>
                <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-5-5 5 5-5 5" />
                </svg>
            </a>
        </div>

        <?php if (! empty($articles)): ?>
            <!-- Desktop Layout (2 Columns Grid) -->
            <div class="hidden gap-6 sm:grid sm:grid-cols-2">
                <?php foreach (array_slice($articles, 0, 2) as $article): ?>
                    <a href="<?= base_url('artikel/' . $article['id']) ?>"
                        class="flex flex-col overflow-hidden transition-all duration-300 bg-white border shadow-lg border-slate-200/80 rounded-xl shadow-slate-200/70 hover:shadow-xl hover:border-blue-300 group">

                        <!-- Top Banner Image -->
                        <div class="relative overflow-hidden h-52 sm:h-64 bg-slate-100">
                            <img src="<?= base_url($article['image'] ?: 'assets/images/default-foto.png') ?>"
                                alt="<?= esc($article['title']) ?>"
                                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-[1.03]"
                                loading="lazy">
                        </div>

                        <!-- Card Content -->
                        <div class="flex flex-col flex-1 p-6 sm:p-7">
                            <!-- Category Badge -->
                            <div>
                                <span class="inline-flex items-center px-3 py-1 text-[11px] font-bold text-white bg-blue-600 rounded-full mb-3 shadow-xs">
                                    <?= esc($article['tag'] ?: 'Kegiatan') ?>
                                </span>
                            </div>

                            <!-- Title -->
                            <h3 class="mb-2 text-base font-bold leading-snug sm:text-lg text-slate-900 line-clamp-2">
                                <?= esc($article['title']) ?>
                            </h3>

                            <!-- Excerpt -->
                            <p class="mb-4 text-xs leading-relaxed sm:text-sm text-slate-500 line-clamp-2">
                                <?= esc(
                                    mb_strimwidth(
                                        $article['description'] ?: strip_tags($article['content']),
                                        0,
                                        140,
                                        '...'
                                    )
                                ) ?>
                            </p>

                            <!-- CTA Button & Arrow -->
                            <div class="flex items-center gap-2 mt-auto text-sm font-bold text-blue-600 group-hover:text-blue-700">
                                <span>Baca Selengkapnya</span>
                                <div class="flex items-center justify-center w-6 h-6 text-white transition-transform bg-blue-600 rounded-full group-hover:translate-x-1">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- Mobile Layout (Single Card Carousel with Slide Animation) -->
            <div class="relative block sm:hidden">
                <div class="p-3 -m-3 overflow-hidden">
                    <div id="mobile-article-track" class="flex transition-transform duration-500 ease-out" style="transform: translateX(0%);">
                        <?php foreach ($articles as $index => $article): ?>
                            <div class="flex-shrink-0 w-full px-1">
                                <a href="<?= base_url('artikel/' . $article['id']) ?>"
                                    class="flex flex-col overflow-hidden transition-all duration-300 bg-white border shadow-lg border-slate-200/80 rounded-xl shadow-slate-200/70 group">

                                    <!-- Top Banner Image -->
                                    <div class="relative h-48 overflow-hidden bg-slate-100">
                                        <?php if (! empty($article['image'])): ?>
                                            <img src="<?= base_url($article['image']) ?>"
                                                alt="<?= esc($article['title']) ?>"
                                                class="object-cover w-full h-full transition-transform duration-300 group-hover:scale-105"
                                                loading="lazy">
                                        <?php else: ?>
                                            <div class="flex flex-col items-center justify-center w-full h-full p-4 bg-gradient-to-br from-sky-50 via-slate-50 to-blue-100/60">
                                                <div class="p-3 bg-white/90 rounded-2xl shadow-xs border border-sky-100 mb-1.5 transition-transform duration-300 group-hover:scale-110">
                                                    <svg class="w-8 h-8 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5" />
                                                    </svg>
                                                </div>
                                                <span class="text-xs font-semibold tracking-wide text-sky-900/60">Artikel BNN</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Card Content -->
                                    <div class="flex flex-col p-5">
                                        <!-- Category Badge -->
                                        <div>
                                            <span class="inline-flex items-center px-3 py-1 text-[10px] font-bold text-white bg-blue-600 rounded-full mb-2.5 shadow-xs">
                                                <?= esc($article['tag'] ?: 'Kegiatan') ?>
                                            </span>
                                        </div>

                                        <!-- Title -->
                                        <h3 class="text-base font-bold leading-snug text-slate-900 line-clamp-2 mb-1.5">
                                            <?= esc($article['title']) ?>
                                        </h3>

                                        <!-- Excerpt -->
                                        <p class="text-xs text-slate-500 leading-relaxed line-clamp-2 mb-3.5">
                                            <?= esc(
                                                mb_strimwidth(
                                                    $article['description'] ?: strip_tags($article['content']),
                                                    0,
                                                    120,
                                                    '...'
                                                )
                                            ) ?>
                                        </p>

                                        <!-- CTA Button & Arrow -->
                                        <div class="flex items-center gap-2 text-xs font-bold text-blue-600">
                                            <span>Baca Selengkapnya</span>
                                            <div class="flex items-center justify-center w-5 h-5 text-white bg-blue-600 rounded-full">
                                                <svg class="w-3 h-3" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Interactive Pagination Dots (Mobile Only) -->
                <div class="flex items-center justify-center gap-2 mt-5">
                    <?php foreach ($articles as $index => $article): ?>
                        <button type="button"
                            class="mobile-article-dot transition-all duration-300 h-2.5 rounded-full <?= $index === 0 ? 'w-7 bg-blue-600' : 'w-2.5 bg-slate-300' ?>"
                            data-target="<?= $index ?>"
                            aria-label="Artikel <?= $index + 1 ?>">
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const track = document.getElementById('mobile-article-track');
                    const dots = document.querySelectorAll('.mobile-article-dot');
                    if (!track || !dots.length) return;

                    let currentIndex = 0;
                    const total = dots.length;
                    let timer = null;
                    let startX = 0;
                    let currentX = 0;
                    let isDragging = false;
                    let isDragged = false;
                    let startTranslate = 0;

                    function showSlide(index) {
                        currentIndex = index;
                        track.style.transition = 'transform 0.4s cubic-bezier(0.16, 1, 0.3, 1)';
                        track.style.transform = `translateX(-${index * 100}%)`;
                        dots.forEach((dot, i) => {
                            dot.classList.toggle('w-7', i === index);
                            dot.classList.toggle('bg-blue-600', i === index);
                            dot.classList.toggle('w-2.5', i !== index);
                            dot.classList.toggle('bg-slate-300', i !== index);
                        });
                    }

                    function nextSlide() {
                        showSlide((currentIndex + 1) % total);
                    }

                    function prevSlide() {
                        showSlide((currentIndex - 1 + total) % total);
                    }

                    function startAutoPlay() {
                        if (total > 1 && !timer) {
                            timer = setInterval(nextSlide, 4000);
                        }
                    }

                    function stopAutoPlay() {
                        if (timer) {
                            clearInterval(timer);
                            timer = null;
                        }
                    }

                    dots.forEach((dot) => {
                        dot.addEventListener('click', function () {
                            const target = parseInt(this.getAttribute('data-target'), 10);
                            showSlide(target);
                            stopAutoPlay();
                            startAutoPlay();
                        });
                    });

                    // Touch & Drag Handling (Smooth Hero Carousel style)
                    function getClientX(e) {
                        return e.touches ? e.touches[0].clientX : e.clientX;
                    }

                    function onStart(e) {
                        isDragging = true;
                        isDragged = false;
                        startX = getClientX(e);
                        currentX = startX;
                        const width = track.offsetWidth;
                        startTranslate = -currentIndex * width;
                        track.style.transition = 'none';
                        stopAutoPlay();
                    }

                    function onMove(e) {
                        if (!isDragging) return;
                        currentX = getClientX(e);
                        const diffX = currentX - startX;
                        if (Math.abs(diffX) > 8) isDragged = true;
                        track.style.transform = `translateX(${startTranslate + diffX}px)`;
                    }

                    function onEnd() {
                        if (!isDragging) return;
                        isDragging = false;
                        const diffX = currentX - startX;
                        let targetIndex = currentIndex;

                        if (diffX < -50 && currentIndex < total - 1) {
                            targetIndex = currentIndex + 1;
                        } else if (diffX > 50 && currentIndex > 0) {
                            targetIndex = currentIndex - 1;
                        }

                        showSlide(targetIndex);
                        startAutoPlay();
                    }

                    // Prevent click/navigation when user dragged card
                    track.addEventListener('click', (e) => {
                        if (isDragged) {
                            e.preventDefault();
                            e.stopPropagation();
                        }
                    }, true);

                    // Touch events
                    track.addEventListener('touchstart', onStart, { passive: true });
                    track.addEventListener('touchmove', onMove, { passive: true });
                    track.addEventListener('touchend', onEnd, { passive: true });

                    // Mouse drag support
                    track.addEventListener('mousedown', onStart);
                    window.addEventListener('mousemove', onMove);
                    window.addEventListener('mouseup', onEnd);

                    // Mouse hover pause
                    const container = track.parentElement;
                    if (container) {
                        container.addEventListener('mouseenter', stopAutoPlay);
                        container.addEventListener('mouseleave', startAutoPlay);
                    }

                    startAutoPlay();
                });
            </script>
        <?php else: ?>
            <div class="flex flex-col items-center justify-center max-w-3xl p-8 mx-auto text-center bg-white border shadow-sm sm:p-12 border-slate-200/90 rounded-3xl">
                <div class="flex items-center justify-center w-12 h-12 mb-3 border rounded-xl bg-slate-50 text-slate-400 border-slate-200/60">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-slate-800">Belum Ada Artikel</h3>
                <p class="max-w-sm mt-1 text-xs sm:text-sm text-slate-500">
                    Artikel informasi dan edukasi belum tersedia saat ini.
                </p>
            </div>
        <?php endif; ?>

    </div>
</section>
