<?php
$modules = $modules ?? [];
$hasMore = $hasMore ?? false;
?>

<section
    class="relative overflow-hidden bg-[position:right_center] bg-cover bg-no-repeat isolate"
    style="background-image: url('<?= base_url('assets/images/bg-bacaan-2.png') ?>');">
    <div class="absolute inset-0 bg-gradient-to-r from-slate-950/85 via-slate-950/50 to-slate-950/20"></div>

    <div class="container relative py-8 sm:py-20 lg:py-28">

        <div class="max-w-2xl">

            <!-- Breadcrumb -->
            <nav class="mb-3 text-xs sm:text-sm" aria-label="Breadcrumb">
                <ol class="flex items-center gap-1.5 text-slate-300">
                    <li>
                        <a href="<?= base_url('/') ?>" class="transition-colors hover:text-white">Beranda</a>
                    </li>
                    <li aria-hidden="true" class="text-slate-400">/</li>
                    <li class="font-medium text-sky-400" aria-current="page">Bahan Bacaan</li>
                </ol>
            </nav>

            <!-- Heading -->
            <h1 class="text-3xl font-bold leading-tight tracking-tight text-white sm:text-5xl lg:text-6xl">
                Bahan <span class="inline-block px-1.5 py-0.5 bg-sky-800 text-white">Bacaan</span>
            </h1>

            <!-- Description -->
            <p class="max-w-xl mt-4 text-sm font-normal leading-6 text-slate-200 drop-shadow-[0_1px_3px_rgba(0,0,0,0.3)] sm:mt-6 sm:text-lg sm:leading-7">
                Materi bacaan interaktif dan modul edukasi untuk menambah pengetahuan dan wawasanmu seputar narkoba.
            </p>

            <!-- CTA Button -->
            <div class="mt-6 sm:mt-8">
                <a href="#bacaan"
                    class="inline-flex items-center gap-2 px-4 py-2 sm:px-4.5 sm:py-2 text-xs sm:text-sm font-semibold text-white transition-all duration-300 rounded-lg bg-sky-600 hover:bg-sky-700 shadow-md shadow-sky-950/30 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-sky-400">
                    <span>Jelajahi Bacaan</span>
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5L12 21m0 0l-7.5-7.5M12 21V3" />
                    </svg>
                </a>
            </div>

        </div>

    </div>
</section>

<section id="bacaan" class="py-14 bg-slate-50">
    <div class="container">

        <!-- Heading & Search Form -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div class="max-w-2xl">
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-sky-950">
                    Bahan Bacaan
                </h1>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Materi bacaan untuk menambah pengetahuan seputar pencegahan dan bahaya narkoba.
                </p>
            </div>

            <!-- Search Box (Real-time Instant Search) -->
            <form onsubmit="return false;" class="relative w-full max-w-sm shrink-0">
                <div class="relative flex items-center">
                    <input
                        type="text"
                        id="bacaan-search-input"
                        name="q"
                        value="<?= esc($search ?? '') ?>"
                        placeholder="Ketik untuk mencari bahan bacaan..."
                        class="w-full pl-9 pr-9 py-2.5 text-sm bg-white border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:border-sky-600 focus:ring-2 focus:ring-sky-600/20 transition-all placeholder:text-slate-400"
                        aria-label="Cari bahan bacaan"
                        autocomplete="off">
                    <div class="absolute pointer-events-none left-3 text-slate-400">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.35-4.35" />
                        </svg>
                    </div>
                    <button
                        type="button"
                        id="bacaan-search-clear"
                        class="absolute right-3 text-slate-400 hover:text-slate-600 transition-colors<?= empty($search) ? ' hidden' : '' ?>"
                        title="Bersihkan pencarian">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 6 6 18M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <div id="bacaan-search-info" class="flex items-center gap-2 mt-6 text-sm text-slate-600<?= empty($search) ? ' hidden' : '' ?>">
            <span>Hasil pencarian untuk: <strong id="bacaan-search-keyword" class="text-sky-950">"<?= esc($search ?? '') ?>"</strong></span>
        </div>

        <!-- Modules Grid -->
        <div id="bacaan-list" class="grid gap-5 mt-8 md:grid-cols-2 lg:grid-cols-3">
            <?= view('learning/_module_cards', ['modules' => $modules]) ?>
        </div>

        <div id="bacaan-more-wrap" class="mt-10 text-center<?= ! ($hasMore ?? false) ? ' hidden' : '' ?>">
            <button id="bacaan-more" type="button" class="min-h-11 border border-sky-800 px-5 py-2.5 text-sm font-semibold text-sky-800 rounded-lg transition hover:bg-sky-800 hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-sky-600 focus-visible:ring-offset-2">
                Muat lebih banyak
            </button>
        </div>

        <!-- Empty State -->
        <div id="bacaan-empty-state" class="p-8 mt-8 text-center bg-white border border-slate-200 rounded-2xl shadow-sm<?= ($modules !== []) ? ' hidden' : '' ?>">
            <svg class="w-12 h-12 mx-auto text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="11" cy="11" r="8" />
                <path d="m21 21-4.35-4.35" />
            </svg>
            <p class="mt-3 text-base font-semibold text-slate-800">
                Bahan bacaan tidak ditemukan
            </p>
            <p class="mt-1 text-sm text-slate-500">
                Tidak ada bahan bacaan yang cocok dengan kata kunci pencarian.
            </p>
        </div>

    </div>
</section>

<script>
    (() => {
        const input = document.getElementById('bacaan-search-input');
        const clearBtn = document.getElementById('bacaan-search-clear');
        const searchInfo = document.getElementById('bacaan-search-info');
        const searchKeywordSpan = document.getElementById('bacaan-search-keyword');
        const list = document.getElementById('bacaan-list');
        const wrap = document.getElementById('bacaan-more-wrap');
        const button = document.getElementById('bacaan-more');
        const emptyState = document.getElementById('bacaan-empty-state');

        let debounceTimer;

        const performSearch = async () => {
            const query = input.value.trim();

            if (clearBtn) clearBtn.classList.toggle('hidden', query === '');
            if (searchInfo) {
                searchInfo.classList.toggle('hidden', query === '');
                if (searchKeywordSpan) searchKeywordSpan.textContent = '"' + query + '"';
            }

            const newUrl = new URL(window.location.href);
            if (query) {
                newUrl.searchParams.set('q', query);
            } else {
                newUrl.searchParams.delete('q');
            }
            window.history.replaceState({}, '', newUrl);

            try {
                const response = await fetch('<?= base_url('bacaan/lebih-banyak') ?>?offset=0&q=' + encodeURIComponent(query));
                if (!response.ok) throw new Error();
                const data = await response.json();

                list.innerHTML = data.html;

                const hasContent = data.html && data.html.trim() !== '';
                if (emptyState) emptyState.classList.toggle('hidden', hasContent);
                if (wrap) {
                    wrap.classList.toggle('hidden', !data.hasMore);
                    if (button) {
                        button.disabled = !data.hasMore;
                        button.textContent = 'Muat lebih banyak';
                    }
                }
            } catch (e) {
                console.error('Bacaan search error:', e);
            }
        };

        // Realtime typing with 250ms debounce
        input?.addEventListener('input', () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(performSearch, 250);
        });

        // Clear button handler
        clearBtn?.addEventListener('click', () => {
            input.value = '';
            performSearch();
        });

        // Load more handler
        button?.addEventListener('click', async () => {
            button.disabled = true;
            button.textContent = 'Memuat...';
            const query = input ? input.value.trim() : '';
            try {
                const url = '<?= base_url('bacaan/lebih-banyak') ?>?offset=' + list.children.length + (query ? '&q=' + encodeURIComponent(query) : '');
                const response = await fetch(url);
                if (!response.ok) throw new Error();
                const data = await response.json();
                list.insertAdjacentHTML('beforeend', data.html);
                if (wrap) wrap.classList.toggle('hidden', !data.hasMore);
                button.disabled = !data.hasMore;
                button.textContent = 'Muat lebih banyak';
            } catch {
                button.disabled = false;
                button.textContent = 'Coba lagi';
            }
        });
    })();
</script>