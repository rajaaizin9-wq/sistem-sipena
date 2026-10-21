<?php
// Runtime scripts are loaded in the parent document so the SCO iframe
// can discover the SCORM API through the window hierarchy.
?>

<script src="<?= base_url('assets/js/scorm/scorm-runtime.js') ?>"></script>
<script src="<?= base_url('assets/js/scorm/scorm-storage.js') ?>"></script>
<script src="<?= base_url('assets/js/scorm/scorm-api-12.js') ?>"></script>
<script src="<?= base_url('assets/js/scorm/scorm-api-2004.js') ?>"></script>

<style>
    .scorm-player-frame {
        display: block;
        width: 100%;
        height: 75vh;
        min-height: 520px;
        border: 0;
        background: #fff;
    }

    @media (max-width: 639px) {
        .scorm-player-frame {
            height: 65vh;
            min-height: 420px;
        }
    }

    /* Focus Fullscreen Mode - Covers navbar & footer completely */
    body.scorm-fullscreen-active {
        overflow: hidden !important;
    }
    #scorm-player-wrapper.is-fullscreen {
        position: fixed !important;
        inset: 0 !important;
        width: 100% !important;
        height: 100% !important;
        z-index: 99999 !important;
        border-radius: 0 !important;
        border: none !important;
        margin: 0 !important;
        padding: 0 !important;
        background: #0f172a !important;
        box-sizing: border-box !important;
    }
    #scorm-player-wrapper.is-fullscreen .scorm-player-frame {
        width: 100% !important;
        height: 100% !important;
        max-height: 100% !important;
        min-height: 100% !important;
    }
</style>

<!-- Floating Exit Fullscreen Button -->
<button type="button" id="btn-exit-fullscreen"
    class="hidden fixed top-4 right-4 z-[100000] items-center gap-1.5 px-3.5 py-2 text-xs font-bold text-white bg-slate-900/90 hover:bg-slate-900 backdrop-blur-md border border-white/20 rounded-xl shadow-xl transition-all">
    <svg class="w-4 h-4 text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
    </svg>
    <span>Tutup Layar Penuh</span>
</button>

<section class="border-b border-slate-200 bg-slate-50">

    <div class="container mx-auto w-[min(1160px,calc(100%-40px))] py-6 sm:py-10">

        <!-- Header -->
        <div class="flex flex-wrap items-center justify-between gap-3 mb-4 sm:mb-5">

            <!-- Content -->
            <div class="flex-1 min-w-0">

                <p class="mb-1 text-xs sm:text-sm font-semibold tracking-wide text-black uppercase">
                    Modul bacaan
                </p>

                <!-- Breadcrumb -->
                <nav class="mb-2.5 sm:mb-3 text-xs sm:text-sm" aria-label="Breadcrumb">
                    <ol class="flex items-center min-w-0 gap-2 text-slate-500">

                        <!-- Beranda -->
                        <li class="shrink-0">
                            <a
                                href="<?= base_url('/') ?>"
                                class="transition-colors text-sky-600 hover:text-sky-800">
                                Beranda
                            </a>
                        </li>

                        <!-- Separator -->
                        <li
                            aria-hidden="true"
                            class="flex items-center shrink-0 text-sky-700">

                            <svg
                                class="w-3.5 h-3.5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m9 5 7 7-7 7" />

                            </svg>

                        </li>

                        <!-- Bahan Bacaan -->
                        <li class="shrink-0">
                            <a
                                href="<?= base_url('bacaan') ?>"
                                class="transition-colors text-sky-600 hover:text-sky-800">
                                Bahan Bacaan
                            </a>
                        </li>

                        <!-- Separator -->
                        <li
                            aria-hidden="true"
                            class="flex items-center shrink-0 text-sky-700">

                            <svg
                                class="w-3.5 h-3.5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m9 5 7 7-7 7" />

                            </svg>

                        </li>

                        <!-- Current -->
                        <li
                            class="min-w-0 font-medium truncate text-sky-700 max-w-48 sm:max-w-xs"
                            aria-current="page">
                            Materi
                        </li>

                    </ol>
                </nav>

                <!-- Title -->
                <h1
                    class="max-w-3xl text-lg font-bold leading-tight break-words text-sky-950 sm:text-2xl line-clamp-3">
                    <?= esc($module['title'] ?? 'Modul Bacaan') ?>
                </h1>

            </div>

            <!-- Fullscreen Focus Button -->
            <button type="button" id="btn-focus-mode"
                class="inline-flex items-center gap-1.5 px-3.5 py-2 sm:px-4 sm:py-2.5 text-xs sm:text-sm font-semibold text-slate-700 bg-white border border-slate-200/90 rounded-xl shadow-xs hover:bg-sky-50 hover:text-sky-600 hover:border-sky-300 transition-all shrink-0">
                <svg class="w-4 h-4 text-sky-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
                </svg>
                <span>Layar Penuh</span>
            </button>

        </div>

        <!-- SCORM Player Container -->
        <div id="scorm-player-wrapper" class="overflow-hidden bg-white border rounded-xl shadow-sm border-slate-200">

            <iframe
                class="scorm-player-frame"
                src="<?= esc($launchUrl, 'attr') ?>"
                title="Isi modul bacaan"
                loading="eager"
                allow="fullscreen">
            </iframe>

        </div>

    </div>

</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btnFocus = document.getElementById('btn-focus-mode');
        const btnExit = document.getElementById('btn-exit-fullscreen');
        const wrapper = document.getElementById('scorm-player-wrapper');
        if (!btnFocus || !wrapper) return;

        function toggleFullscreen() {
            const isFull = wrapper.classList.toggle('is-fullscreen');
            document.body.classList.toggle('scorm-fullscreen-active', isFull);
            if (btnExit) {
                if (isFull) {
                    btnExit.classList.remove('hidden');
                    btnExit.classList.add('inline-flex');
                } else {
                    btnExit.classList.add('hidden');
                    btnExit.classList.remove('inline-flex');
                }
            }
        }

        btnFocus.addEventListener('click', toggleFullscreen);
        if (btnExit) btnExit.addEventListener('click', toggleFullscreen);

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && wrapper.classList.contains('is-fullscreen')) {
                toggleFullscreen();
            }
        });
    });
</script>