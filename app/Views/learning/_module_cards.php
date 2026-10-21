<?php foreach ($modules as $module): ?>

    <a
        href="<?= base_url('scorm/launch/' . esc($module['id'], 'url')) ?>"
        class="block min-w-0 group"
        data-search-content="<?= esc(strtolower($module['title'] . ' ' . ($module['description'] ?? '')), 'attr') ?>">

        <article
            class="flex flex-col h-full overflow-hidden transition-all duration-200 bg-white border rounded-lg shadow-md border-slate-200 hover:border-sky-300 hover:shadow-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-sky-600 focus-visible:ring-offset-2">

            <?php if (! empty($module['thumbnail'])): ?>

                <!-- Thumbnail -->
                <div class="overflow-hidden aspect-[16/9] bg-slate-100">
                    <img
                        src="<?= base_url($module['thumbnail']) ?>"
                        alt="<?= esc($module['title']) ?>"
                        class="object-cover w-full h-full transition-transform duration-300 group-hover:scale-[1.02]"
                        loading="lazy">
                </div>

            <?php else: ?>

                <!-- Vector SVG Fallback -->
                <div class="overflow-hidden aspect-[16/9] bg-gradient-to-br from-sky-50 via-blue-50 to-indigo-100/60 flex flex-col items-center justify-center p-4">
                    <div class="p-3.5 bg-white/90 rounded-2xl shadow-xs border border-sky-100 mb-1.5 transition-transform duration-300 group-hover:scale-110">
                        <svg class="w-8 h-8 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18c-2.305 0-4.408.867-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold tracking-wide text-sky-900/70">Modul Bacaan BNN</span>
                </div>

            <?php endif; ?>


            <!-- Content -->
            <div class="flex flex-col flex-1 min-w-0 p-5">

                <h3
                    class="text-base font-semibold leading-6 break-words line-clamp-3 text-sky-950">
                    <?= esc($module['title']) ?>
                </h3>

                <p
                    class="mt-2 text-sm leading-6 text-slate-600 line-clamp-3">
                    <?= esc(
                        $module['description']
                            ?: 'Membaca adalah awal dari memahami.'
                    ) ?>
                </p>

                <!-- CTA visual -->
                <div
                    class="flex items-center gap-1.5 mt-auto pt-5 text-sm font-medium text-sky-700">

                    <span>
                        Mulai belajar
                    </span>

                    <span
                        aria-hidden="true"
                        class="transition-transform duration-200 group-hover:translate-x-0.5">
                        →
                    </span>

                </div>

            </div>

        </article>

    </a>

<?php endforeach; ?>