<section class="py-6 sm:py-10 bg-slate-50/70">
    <div class="container">

        <!-- Heading Header -->
        <div class="flex flex-col gap-4 mb-6 sm:flex-row sm:items-end sm:justify-between sm:mb-8">
            <div class="max-w-xl">
                <h2 class="text-2xl font-bold tracking-tight sm:text-3xl text-slate-900">
                    Bahan bacaan pilihan
                </h2>
                <p class="mt-1 text-xs sm:text-sm text-slate-600">
                    Bahan bacaan dan modul interaktif untuk menambah pengetahuan Anda.
                </p>
            </div>

            <a href="<?= base_url('bacaan') ?>"
                title="Lihat semua bacaan"
                class="inline-flex shrink-0 items-center gap-1.5 text-xs sm:text-sm font-bold text-blue-600 hover:text-blue-800 transition-colors">
                <span>Lihat semua bacaan</span>
                <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-5-5 5 5-5 5" />
                </svg>
            </a>
        </div>

        <?php
        $readingStyles = [
            [
                'bg' => 'bg-[#b4c8ff]',
                'icon' => '<svg class="w-12 h-12 text-blue-600 transition-transform duration-300 sm:w-16 sm:h-16 drop-shadow-md group-hover:scale-110" viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 14H6v-2h6v2zm5-4H6v-2h11v2zm0-4H6V7h11v2z"/></svg>',
            ],
            [
                'bg' => 'bg-[#d2b8e8]',
                'icon' => '<svg class="w-12 h-12 text-purple-600 transition-transform duration-300 sm:w-16 sm:h-16 drop-shadow-md group-hover:scale-110" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5a3 3 0 1 0-5.997.125 4 4 0 0 0-2.526 5.77 4 4 0 0 0 .556 6.588A4 4 0 1 0 12 18Z" /><path d="M12 5a3 3 0 1 1 5.997.125 4 4 0 0 1 2.526 5.77 4 4 0 0 1-.556 6.588A4 4 0 1 1 12 18Z" /><path d="M15 13a2.5 2.5 0 0 1-2.5-2.5V9" /><path d="M9 13a2.5 2.5 0 0 0 2.5-2.5V9" /><path d="M12 5v14" /></svg>',
            ],
            [
                'bg' => 'bg-[#b2f0b7]',
                'icon' => '<svg class="w-12 h-12 transition-transform duration-300 sm:w-16 sm:h-16 text-emerald-600 drop-shadow-md group-hover:scale-110" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-5.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg>',
            ],
        ];
        ?>

        <!-- Reading List Content (2 Columns Grid on Desktop) -->
        <?php if (! empty($readingModules)): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                <?php foreach ($readingModules as $index => $module): ?>
                    <?php $style = $readingStyles[$index % count($readingStyles)]; ?>
                    <a href="<?= base_url('scorm/launch/' . esc($module['id'], 'url')) ?>"
                        class="flex flex-row overflow-hidden bg-white border border-slate-100 rounded-xl shadow-[0_10px_25px_rgba(15,23,42,0.08)] hover:shadow-xl hover:border-blue-200 hover:-translate-y-1 transition-all duration-300 group min-h-[120px] sm:min-h-[140px]">
                        
                        <!-- Left Icon / Image Box -->
                        <div class="relative w-28 sm:w-40 shrink-0 flex items-center justify-center p-3 sm:p-4 <?= $style['bg'] ?> rounded-l-xl overflow-hidden">
                            <?php if (! empty($module['thumbnail'])): ?>
                                <img src="<?= base_url($module['thumbnail']) ?>" alt="<?= esc($module['title']) ?>" class="object-cover w-full h-full transition-transform duration-300 rounded-l-xl group-hover:scale-105">
                            <?php else: ?>
                                <?= $style['icon'] ?>
                            <?php endif; ?>
                        </div>

                        <!-- Right Content Body -->
                        <div class="flex flex-col justify-center flex-1 min-w-0 p-4 sm:p-5">
                            <h3 class="text-sm font-bold leading-snug transition-colors sm:text-base text-slate-900 group-hover:text-blue-700 line-clamp-2">
                                <?= esc($module['title']) ?>
                            </h3>
                            <p class="mt-1 text-xs leading-relaxed text-slate-600 line-clamp-2">
                                <?= esc($module['description'] ?: 'Kenali pengertian narkotika, jenis dan dampak nya bagi kehidupan') ?>
                            </p>
                            <div class="flex items-center gap-1.5 mt-2.5 sm:mt-3 text-xs font-bold text-slate-600">
                                <svg class="w-4 h-4 text-slate-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <circle cx="12" cy="12" r="9"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"/>
                                </svg>
                                <span><?= esc($module['reading_time'] ?? '7 menit baca') ?></span>
                            </div>
                        </div>

                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="flex flex-col items-center justify-center max-w-3xl p-8 mx-auto text-center bg-white border shadow-sm sm:p-12 border-slate-200/90 rounded-xl">
                <div class="flex items-center justify-center w-12 h-12 mb-3 border rounded-xl bg-slate-50 text-slate-400 border-slate-200/60">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-slate-800">Belum Ada Bacaan</h3>
                <p class="max-w-sm mt-1 text-xs sm:text-sm text-slate-500">
                    Bahan bacaan dan modul interaktif belum tersedia saat ini.
                </p>
            </div>
        <?php endif; ?>

    </div>
</section>