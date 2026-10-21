<?php
$stepIcons = [
    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3h7.5M6 20.25h12A2.25 2.25 0 0 0 20.25 18V8.25A2.25 2.25 0 0 0 18 6H6A2.25 2.25 0 0 0 3.75 8.25v9.75A2.25 2.25 0 0 0 6 20.25Z" />',
    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2z" />',
    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0 1 12 2.944a11.955 11.955 0 0 1-8.618 3.04A12.02 12.02 0 0 0 3 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />',
    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197M12 14a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm-6 4.72a9.094 9.094 0 0 1-3.741-.479 3 3 0 0 1 4.682-2.72m-.94 3.198a11.94 11.94 0 0 1 .037-.666M6 18.72a5.971 5.971 0 0 1 .941-3.197" />',
    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-12M10.125 2.25h.375a2.625 2.625 0 0 1 2.625 2.625v2.625h2.625A2.625 2.625 0 0 1 18.375 10.125v.375M10.125 2.25A2.625 2.625 0 0 0 7.5 4.875v.375m10.875 4.875h-3.375a1.125 1.125 0 0 1-1.125-1.125V5.625" />',
    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m5.25 12.75 4.5 4.5 9-9" />',
];
?>

<section class="border-b border-slate-200 bg-slate-50/70" aria-labelledby="tat-title">
    <div class="container max-w-6xl py-14 sm:py-20">
        <div class="max-w-4xl">
            <p class="text-xs font-bold uppercase tracking-[0.16em] text-sky-600">Layanan TAT BNN</p>
            <h1 id="tat-title" class="mt-3 text-3xl font-semibold tracking-tight text-sky-950 sm:text-4xl">
                Alur Lengkap Tim Asesmen Terpadu (TAT) BNN
            </h1>
            
            <div class="p-4 mt-5 border bg-white/90 border-slate-200 rounded-xl shadow-xs">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Dasar Hukum Utama:</p>
                <p class="text-sm leading-relaxed text-slate-700">
                    <strong class="font-semibold text-sky-950">Peraturan Kepala BNN No. 11 Tahun 2014</strong> tentang Tata Cara Penanganan Tersangka dan/atau Terdakwa Pecandu Narkotika dan Korban Penyalahgunaan Narkotika ke Dalam Lembaga Rehabilitasi, serta <strong class="font-semibold text-sky-950">Peraturan Bersama 7 Kementerian/Lembaga</strong> dan <strong class="font-semibold text-sky-950">SEMA No. 4 Tahun 2010</strong>.
                </p>
            </div>

            <div class="flex flex-wrap items-center mt-6 text-sm gap-x-5 gap-y-2 text-slate-500">
                <span class="inline-flex items-center gap-2 font-semibold text-sky-800">
                    <span class="grid text-xs font-bold text-white rounded-full h-7 w-7 place-items-center bg-sky-800"><?= count($steps) ?></span>
                    Tahapan
                </span>
                <span class="w-1 h-1 rounded-full bg-slate-300" aria-hidden="true"></span>
                <span>Proses Hukum & Rekomendasi Rehabilitasi</span>
            </div>
        </div>
    </div>
</section>

<section class="py-12 bg-white sm:py-16" aria-labelledby="tat-steps-title">
    <div class="container max-w-4xl">
        <h2 id="tat-steps-title" class="sr-only">Tahapan Tim Asesmen Terpadu (TAT)</h2>

        <div class="space-y-8">
            <?php foreach ($steps as $index => $step): ?>
                <article class="grid grid-cols-[32px_minmax(0,1fr)] gap-4 sm:grid-cols-[40px_minmax(0,1fr)] sm:gap-5">

                    <!-- Timeline Marker -->
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

                    <!-- Content Card -->
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

                            <p class="mt-3 text-sm leading-6 break-words text-slate-600">
                                <?= esc($step['description']) ?>
                            </p>

                            <!-- Table (Step 1) -->
                            <?php if (!empty($step['tables'])): ?>
                                <div class="mt-4 overflow-x-auto border rounded-lg border-slate-200">
                                    <table class="w-full text-left text-xs sm:text-sm text-slate-700">
                                        <thead class="bg-slate-50 text-sky-950 font-semibold border-b border-slate-200">
                                            <tr>
                                                <?php foreach ($step['tables']['headers'] as $header): ?>
                                                    <th scope="col" class="px-3 py-2.5 sm:px-4 sm:py-3"><?= esc($header) ?></th>
                                                <?php endforeach; ?>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-200">
                                            <?php foreach ($step['tables']['rows'] as $row): ?>
                                                <tr class="hover:bg-slate-50/50">
                                                    <td class="px-3 py-2 sm:px-4 sm:py-2.5 font-medium text-slate-900"><?= esc($row[0]) ?></td>
                                                    <td class="px-3 py-2 sm:px-4 sm:py-2.5"><?= esc($row[1]) ?></td>
                                                    <td class="px-3 py-2 sm:px-4 sm:py-2.5 font-medium text-sky-900"><?= esc($row[2]) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>

                            <!-- Documents List (Step 1) -->
                            <?php if (!empty($step['documents'])): ?>
                                <div class="mt-5 p-4 rounded-lg bg-sky-50/60 border border-sky-100">
                                    <h4 class="text-xs font-bold uppercase tracking-wider text-sky-900">Dokumen yang dilampirkan:</h4>
                                    <ul class="mt-2.5 space-y-1.5 text-xs sm:text-sm text-slate-700">
                                        <?php foreach ($step['documents'] as $doc): ?>
                                            <li class="flex items-start gap-2">
                                                <svg class="w-4 h-4 text-sky-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                <span><?= esc($doc) ?></span>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <!-- Teams List (Step 3) -->
                            <?php if (!empty($step['teams'])): ?>
                                <div class="mt-4 space-y-4">
                                    <?php foreach ($step['teams'] as $team): ?>
                                        <div class="p-4 border rounded-lg bg-slate-50 border-slate-200">
                                            <h4 class="text-sm font-bold text-sky-950 flex items-center gap-2">
                                                <span class="w-2 h-2 rounded-full bg-sky-600"></span>
                                                <?= esc($team['name']) ?>
                                            </h4>
                                            <ul class="mt-2 space-y-1.5 text-xs sm:text-sm text-slate-600 pl-4 list-disc">
                                                <?php foreach ($team['points'] as $pt): ?>
                                                    <li><?= esc($pt) ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <!-- Recommendations Table (Step 5) -->
                            <?php if (!empty($step['recommendations'])): ?>
                                <div class="mt-4 overflow-x-auto border rounded-lg border-slate-200">
                                    <table class="w-full text-left text-xs sm:text-sm text-slate-700">
                                        <thead class="bg-slate-50 text-sky-950 font-semibold border-b border-slate-200">
                                            <tr>
                                                <th scope="col" class="px-3 py-2.5 sm:px-4 sm:py-3 w-1/3">Status</th>
                                                <th scope="col" class="px-3 py-2.5 sm:px-4 sm:py-3">Rekomendasi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-200">
                                            <?php foreach ($step['recommendations'] as $rec): ?>
                                                <tr class="hover:bg-slate-50/50">
                                                    <td class="px-3 py-2 sm:px-4 sm:py-2.5 font-bold text-slate-900"><?= esc($rec['status']) ?></td>
                                                    <td class="px-3 py-2 sm:px-4 sm:py-2.5"><?= esc($rec['rekomendasi']) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>

                            <!-- Outcomes List (Step 6) -->
                            <?php if (!empty($step['outcomes'])): ?>
                                <ul class="mt-3 space-y-1.5 text-xs sm:text-sm text-slate-600 pl-4 list-disc">
                                    <?php foreach ($step['outcomes'] as $outcome): ?>
                                        <li><?= esc($outcome) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>

                </article>
            <?php endforeach; ?>
        </div>

        <!-- Ringkasan Alur Sederhana -->
        <div class="mt-14 p-6 sm:p-8 bg-slate-50 border border-slate-200/90 rounded-2xl shadow-xs">
            <div class="max-w-2xl">
                <h3 class="text-lg sm:text-xl font-bold tracking-tight text-sky-950">Ringkasan Alur TAT untuk Masyarakat</h3>
                <p class="mt-1.5 text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Gambaran sederhana bagaimana proses Tim Asesmen Terpadu (TAT) BNN berjalan dari awal hingga keputusan akhir:
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
                <!-- Step 1 -->
                <div class="p-4 bg-white border border-slate-200 rounded-xl shadow-2xs flex flex-col justify-between">
                    <div>
                        <span class="inline-block px-2.5 py-0.5 text-[11px] font-bold text-sky-700 bg-sky-50 rounded-full border border-sky-100 mb-2">Langkah 1</span>
                        <h4 class="text-sm font-semibold text-sky-950">Permohonan Resmi</h4>
                        <p class="mt-1 text-xs text-slate-600 leading-normal">
                            Diajukan oleh Polisi, BNN, Jaksa, atau Hakim. <span class="text-slate-500 italic">(Tidak dapat diajukan langsung oleh keluarga/tersangka)</span>.
                        </p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="p-4 bg-white border border-slate-200 rounded-xl shadow-2xs flex flex-col justify-between">
                    <div>
                        <span class="inline-block px-2.5 py-0.5 text-[11px] font-bold text-sky-700 bg-sky-50 rounded-full border border-sky-100 mb-2">Langkah 2</span>
                        <h4 class="text-sm font-semibold text-sky-950">Penerimaan Berkas</h4>
                        <p class="mt-1 text-xs text-slate-600 leading-normal">
                            Petugas BNN menerima permohonan, mencatat berkas, dan menjadwalkan pemeriksaan.
                        </p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="p-4 bg-white border border-slate-200 rounded-xl shadow-2xs flex flex-col justify-between">
                    <div>
                        <span class="inline-block px-2.5 py-0.5 text-[11px] font-bold text-sky-700 bg-sky-50 rounded-full border border-sky-100 mb-2">Langkah 3</span>
                        <h4 class="text-sm font-semibold text-sky-950">Pemeriksaan Terpadu</h4>
                        <p class="mt-1 text-xs text-slate-600 leading-normal">
                            Pemeriksaan fisik/urine oleh Tim Medis dan analisis peran hukum oleh Tim Hukum.
                        </p>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="p-4 bg-white border border-slate-200 rounded-xl shadow-2xs flex flex-col justify-between">
                    <div>
                        <span class="inline-block px-2.5 py-0.5 text-[11px] font-bold text-sky-700 bg-sky-50 rounded-full border border-sky-100 mb-2">Langkah 4</span>
                        <h4 class="text-sm font-semibold text-sky-950">Rapat Pembahasan</h4>
                        <p class="mt-1 text-xs text-slate-600 leading-normal">
                            Tim Medis dan Tim Hukum rapat bersama mendiskusikan hasil pemeriksaan secara menyeluruh.
                        </p>
                    </div>
                </div>

                <!-- Step 5 -->
                <div class="p-4 bg-white border border-slate-200 rounded-xl shadow-2xs flex flex-col justify-between">
                    <div>
                        <span class="inline-block px-2.5 py-0.5 text-[11px] font-bold text-sky-700 bg-sky-50 rounded-full border border-sky-100 mb-2">Langkah 5</span>
                        <h4 class="text-sm font-semibold text-sky-950">Hasil Rekomendasi</h4>
                        <p class="mt-1 text-xs text-slate-600 leading-normal">
                            Menentukan apakah tersangka mendapatkan <strong>Rehabilitasi</strong> (murni korban/pecandu) atau <strong>Proses Hukum Pidana Lanjut</strong> (pengedar).
                        </p>
                    </div>
                </div>

                <!-- Step 6 -->
                <div class="p-4 bg-white border border-slate-200 rounded-xl shadow-2xs flex flex-col justify-between">
                    <div>
                        <span class="inline-block px-2.5 py-0.5 text-[11px] font-bold text-sky-700 bg-sky-50 rounded-full border border-sky-100 mb-2">Langkah 6</span>
                        <h4 class="text-sm font-semibold text-sky-950">Penyerahan Hasil</h4>
                        <p class="mt-1 text-xs text-slate-600 leading-normal">
                            Surat rekomendasi diserahkan ke Penegak Hukum/Hakim sebagai bahan pertimbangan putusan.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back to Services -->
        <div class="flex justify-center pt-8 mt-4">
            <a href="<?= base_url('layanan') ?>"
                class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-sky-700 transition border rounded-lg border-slate-200 bg-slate-50 hover:border-sky-300 hover:bg-sky-50">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7 7-7-7 7-7" />
                </svg>
                Kembali ke Layanan
            </a>
        </div>
    </div>
</section>
