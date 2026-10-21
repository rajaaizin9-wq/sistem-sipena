<?php
$stepIcons = [
    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 19.128a9.38 9.38 0 0 0 2.25-1.724 9.38 9.38 0 0 0-2.25-1.724M15 19.128v-1.724a6.75 6.75 0 0 0-6-6.75 6.75 0 0 0-6 6.75v1.724m12 0a9.38 9.38 0 0 1-2.25-1.724m0 0a9.38 9.38 0 0 1-2.25 1.724M12 11.25a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />',
    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />',
    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.75 3.75h4.5l1.5 3h3.75v13.5h-15V6.75h3.75l1.5-3ZM9 11.25h6M9 15h4.5" />',
    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.75 3.75v16.5h16.5M7.5 15l3-3 2.25 2.25 4.5-5.25" />',
    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6v12m6-6H6m13.5 0a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />',
    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 21a9 9 0 1 0-9-9c0 1.7.47 3.29 1.29 4.65L3 21l4.35-1.29A8.96 8.96 0 0 0 12 21Z" />',
    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m5.25 12.75 4.5 4.5 9-9" />',
];
?>

<section class="border-b border-slate-200 bg-slate-50/70" aria-labelledby="rehab-title">
    <div class="container max-w-6xl py-14 sm:py-20">
        <div class="max-w-3xl">
            <p class="text-xs font-bold uppercase tracking-[0.16em] text-sky-600">Layanan Rehabilitasi</p>
            <h1 id="rehab-title" class="mt-3 text-3xl font-semibold tracking-tight text-sky-950 sm:text-4xl">
                Alur rehabilitasi narkoba rawat jalan
            </h1>
            <p class="max-w-2xl mt-4 text-base leading-8 text-slate-600">
                Tahapan layanan rehabilitasi yang membantu proses pemulihan secara terarah dan berkelanjutan.
            </p>
            <div class="flex flex-wrap items-center mt-8 text-sm gap-x-5 gap-y-2 text-slate-500">
                <span class="inline-flex items-center gap-2 font-semibold text-sky-800">
                    <span class="grid text-xs font-bold text-white rounded-full h-7 w-7 place-items-center bg-sky-800"><?= count($steps) ?></span>
                    tahapan
                </span>
                <span class="w-1 h-1 rounded-full bg-slate-300" aria-hidden="true"></span>
                <span>Layanan terpadu dan berkelanjutan</span>
            </div>
        </div>
    </div>
</section>

<section class="py-12 bg-white sm:py-16" aria-labelledby="rehab-steps-title">
    <div class="container max-w-4xl">
        <h2 id="rehab-steps-title" class="sr-only">Tahapan rehabilitasi narkoba</h2>

        <div class="space-y-8">
            <?php foreach ($steps as $index => $step): ?>
                <article class="grid grid-cols-[32px_minmax(0,1fr)] gap-4 sm:grid-cols-[40px_minmax(0,1fr)] sm:gap-5">

                    <!-- Timeline -->
                    <div class="flex flex-col items-center">
                        <div class="z-10 grid border-4 border-white rounded-full h-7 w-7 shrink-0 place-items-center bg-sky-700 ring-1 ring-sky-200 sm:h-8 sm:w-8">
                            <span class="text-[10px] font-bold text-white">
                                <?= $index + 1 ?>
                            </span>
                        </div>

                        <?php if ($index < count($steps) - 1): ?>
                            <div class="flex-1 w-px mt-2 bg-slate-200"></div>
                        <?php endif; ?>
                    </div>

                    <!-- Content -->
                    <div class="min-w-0 pb-2">
                        <div class="p-5 bg-white border shadow-sm rounded-xl border-slate-200 sm:p-6">
                            <div class="flex items-start gap-3">
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-semibold leading-7 break-words text-sky-950 sm:text-xl">
                                        <?= esc($step['title']) ?>
                                    </h3>
                                </div>

                                <svg class="w-5 h-5 shrink-0 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <?= $stepIcons[$index] ?? $stepIcons[0] ?>
                                </svg>
                            </div>

                            <p class="mt-4 text-sm leading-6 break-words text-slate-600">
                                <?= esc($step['description']) ?>
                            </p>
                        </div>
                    </div>

                </article>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Back to Services -->
    <div class="flex justify-center pt-6 mt-2">
        <a href="<?= base_url('layanan') ?>"
            class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-sky-700 transition border rounded-lg border-slate-200 bg-slate-50 hover:border-sky-300 hover:bg-sky-50">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7 7-7-7 7-7" />
            </svg>
            Kembali ke Layanan
        </a>
    </div>
</section>