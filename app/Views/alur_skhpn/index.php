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

/** Convert the controller's description string into readable points. */
function skhpnPoints(string $description): array
{
    $description = trim(preg_replace('/\s+/', ' ', $description));
    $points = preg_split('/(?=\d+\.\s)/', $description, -1, PREG_SPLIT_NO_EMPTY);

    return array_values(array_map(static function (string $point): string {
        return trim(preg_replace('/^\d+\.\s*/', '', $point));
    }, $points ?: [$description]));
}
?>

<section class="border-b border-slate-200 bg-slate-50/70" aria-labelledby="skhpn-title">
    <div class="container max-w-6xl py-14 sm:py-20">
        <div class="max-w-3xl">
            <p class="text-xs font-bold uppercase tracking-[0.16em] text-bnn-600">Layanan SKHPN</p>
            <h1 id="skhpn-title" class="mt-3 text-3xl font-semibold tracking-tight text-bnn-950 sm:text-4xl">
                Alur permohonan SKHPN
            </h1>
            <p class="max-w-2xl mt-4 text-base leading-8 text-slate-600">
                Tujuh tahapan untuk mendapatkan Surat Keterangan Hasil Pemeriksaan Narkoba di BNN Kota Tanjungpinang.
            </p>
            <div class="flex flex-wrap items-center mt-8 text-sm gap-x-5 gap-y-2 text-slate-500">
                <span class="inline-flex items-center gap-2 font-semibold text-bnn-800"><span class="grid text-xs text-white rounded-full h-7 w-7 place-items-center bg-bnn-800"><?= count($steps) ?></span> tahapan</span>
                <span class="w-1 h-1 rounded-full bg-slate-300" aria-hidden="true"></span>
                <span>Siapkan KTP dan pas foto</span>
            </div>
        </div>
    </div>
</section>

<section class="py-12 bg-white sm:py-16" aria-labelledby="steps-title">
    <div class="container max-w-4xl">
        <h2 id="steps-title" class="sr-only">Tahapan layanan SKHPN</h2>

        <div class="space-y-8">
            <?php foreach ($steps as $index => $step): ?>
                <?php $points = skhpnPoints($step['description']); ?>

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

                            <div class="mt-4 space-y-2 text-sm leading-6 text-slate-600">
                                <?php foreach ($points as $point): ?>
                                    <div class="flex gap-2.5">
                                        <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-sky-500"></span>
                                        <span class="min-w-0 break-words"><?= esc($point) ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <!-- Question Card -->
        <div class="p-6 mt-12 border bg-sky-50 border-sky-100 rounded-xl sm:p-8 sm:flex sm:items-center sm:justify-between sm:gap-6">
            <div>
                <h3 class="text-lg font-semibold text-sky-950">Ingin daftar SKHPN sekarang?</h3>
                <p class="mt-2 text-sm text-sky-700">Lanjutkan pendaftaran secara online melalui portal BOSS BNN.</p>
            </div>
            <div class="mt-5 sm:mt-0 sm:shrink-0">
                <a href="https://boss.bnn.go.id/layanan_skhpn/daftarskhpn" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold text-white transition bg-sky-700 rounded-lg hover:bg-sky-800 w-full sm:w-auto">
                    Daftar SKHPN Online
                    <svg class="w-4 h-4 ml-2 -mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <div class="flex justify-center pt-6 mt-2">
        <a href="<?= base_url('layanan') ?>"
            class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-sky-700 transition border rounded-lg border-slate-200 bg-slate-50 hover:border-sky-300 hover:bg-sky-50">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7 7-7-7 7-7" />
            </svg>
            Kembali ke Layanan
        </a>
    </div>
</section>
