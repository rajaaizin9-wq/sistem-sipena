<!-- Page Header -->
<div class="mb-8">
    <p class="mb-1 text-xs font-bold tracking-widest uppercase text-bnn-600">Landing Page</p>
    <h1 class="text-2xl font-black tracking-tight text-slate-800">Kelola konten halaman depan</h1>
    <p class="mt-1 text-sm text-slate-500">Ubah hero section, deskripsi singkat, serta teks layanan dan akses cepat.</p>
</div>

<?= view('dashboard/partials/flash_messages') ?>

<!-- Section Tentang Kami -->
<div class="mb-6 overflow-hidden bg-white border shadow-sm rounded-xl border-slate-200">
    <div class="flex items-center justify-between px-6 py-5 border-b border-slate-200 bg-slate-50/50">
        <div>
            <h2 class="text-base font-semibold text-slate-800">Section Tentang Kami</h2>
            <p class="text-sm text-slate-500 mt-0.5">Opsional. Hanya satu section yang tampil pada landing page.</p>
        </div>
        <?php if (empty($aboutSection)): ?>
            <a href="<?= base_url('dashboard/landing-page/about/create') ?>"
                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white transition-all rounded-lg shadow-sm bg-bnn-600 hover:bg-bnn-800">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Tambah section
            </a>
        <?php endif; ?>
    </div>

    <?php if (empty($aboutSection)): ?>
        <div class="px-6 py-12 text-center">
            <div class="flex items-center justify-center mx-auto mb-3 rounded-full h-14 w-14 bg-slate-100">
                <svg class="h-7 w-7 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-sm font-medium text-slate-700">Belum ada section Tentang Kami.</p>
            <p class="mt-1 text-xs text-slate-400">Tambahkan section untuk menampilkannya di halaman publik.</p>
        </div>
    <?php else: ?>
        <?php $section = $aboutSection; ?>
        <div class="p-6">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-start">
                <!-- Gambar -->
                <div class="flex-shrink-0">
                    <?php if (! empty($section['image'])): ?>
                        <img class="object-cover w-24 h-24 rounded-lg shadow-sm ring-1 ring-slate-900/5" src="<?= base_url($section['image']) ?>" alt="">
                    <?php else: ?>
                        <div class="flex items-center justify-center w-24 h-24 text-xs font-medium rounded-lg bg-slate-100 text-slate-400 ring-1 ring-slate-900/5">No Image</div>
                    <?php endif; ?>
                </div>

                <!-- Info -->
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-slate-900"><?= esc($section['title']) ?></p>
                    <p class="mt-1 text-sm text-slate-500"><?= esc(mb_strimwidth($section['description'], 0, 120, '...')) ?></p>
                    <?php if (! empty($section['link'])): ?>
                        <a href="<?= esc($section['link']) ?>" target="_blank" rel="noopener"
                            class="inline-flex items-center gap-1 mt-2 text-xs font-semibold transition-colors text-bnn-600 hover:text-bnn-800">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                <polyline points="15 3 21 3 21 9"></polyline>
                                <line x1="10" y1="14" x2="21" y2="3"></line>
                            </svg>
                            Buka link
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Actions -->
                <div class="flex items-center flex-shrink-0 gap-3">
                    <a href="<?= base_url('dashboard/landing-page/about/' . $section['id']) ?>"
                        class="transition-colors text-slate-400 hover:text-bnn-600" title="Edit section">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 20h9"></path>
                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                        </svg>
                    </a>
                    <form method="post" action="<?= base_url('dashboard/landing-page/about/' . $section['id'] . '/delete') ?>" class="m-0" onsubmit="return confirmDelete(this, 'Hapus section Tentang Kami ini?')">
                        <?= csrf_field() ?>
                        <button type="submit" class="transition-colors cursor-pointer text-slate-400 hover:text-red-600" title="Hapus section">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Form Fakta Narkoba -->
<form method="post" action="<?= base_url('dashboard/landing-page/save') ?>" class="space-y-6">
    <?= csrf_field() ?>

    <div class="overflow-hidden bg-white border shadow-sm rounded-xl border-slate-200">
        <div class="px-6 py-5 border-b border-slate-200 bg-slate-50/50">
            <h2 class="text-base font-semibold text-slate-800">Fakta narkoba</h2>
            <p class="text-sm text-slate-500 mt-0.5">Empat fakta ini tampil pada halaman depan.</p>
        </div>
        <div class="grid grid-cols-1 p-6 sm:grid-cols-2 gap-x-8 gap-y-6">
            <?php foreach ($facts as $index => $fact): ?>
                <div class="p-4 space-y-4 border rounded-lg bg-slate-50 border-slate-100">
                    <p class="text-xs font-bold tracking-widest uppercase text-slate-500">Fakta <?= $index + 1 ?></p>
                    <div>
                        <label for="fact-title-<?= $fact['id'] ?>" class="block text-sm font-semibold text-slate-700 mb-1.5">Judul fakta</label>
                        <input id="fact-title-<?= $fact['id'] ?>"
                            name="facts[<?= $fact['id'] ?>][title]"
                            type="text"
                            value="<?= esc(old('facts.' . $fact['id'] . '.title', $fact['title'])) ?>"
                            required maxlength="100"
                            placeholder="Contoh: Pengguna narkoba…"
                            class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-bnn-600 sm:text-sm bg-slate-50 focus:bg-white transition-colors">
                    </div>
                    <div>
                        <label for="fact-value-<?= $fact['id'] ?>" class="block text-sm font-semibold text-slate-700 mb-1.5">Nilai / angka</label>
                        <input id="fact-value-<?= $fact['id'] ?>"
                            name="facts[<?= $fact['id'] ?>][value]"
                            type="text"
                            value="<?= esc(old('facts.' . $fact['id'] . '.value', $fact['value'])) ?>"
                            required maxlength="30"
                            placeholder="Contoh: 3,4 Juta"
                            class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-bnn-600 sm:text-sm bg-slate-50 focus:bg-white transition-colors">
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>

    <!-- Indeks Kepuasan Masyarakat (IKM) Layanan Rehabilitasi -->
    <div class="overflow-hidden bg-white border shadow-sm rounded-xl border-slate-200">
        <div class="px-6 py-5 border-b border-slate-200 bg-slate-50/50">
            <h2 class="text-base font-semibold text-slate-800">Indeks Kepuasan Masyarakat (IKM) Layanan Rehabilitasi</h2>
            <p class="text-sm text-slate-500 mt-0.5">Input nilai IKM (skala 0 - 4).</p>
        </div>
        <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2">
            <div>
                <label for="ikm_score" class="block text-sm font-semibold text-slate-700 mb-1.5">Nilai IKM (Skala 0 - 4)</label>
                <input id="ikm_score"
                    name="ikm_score"
                    type="text"
                    value="<?= esc(old('ikm_score', $settings['ikm_score'] ?? '-')) ?>"
                    required
                    placeholder="Contoh: 3.65 atau -"
                    oninput="updateIkmPreview(this.value)"
                    class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-bnn-600 sm:text-sm bg-slate-50 focus:bg-white transition-colors">
                <p class="mt-1.5 text-xs text-slate-500">Nilai angka antara 0.00 hingga 4.00, atau isikan "-" jika belum ada data.</p>
            </div>

            <div>
                <label for="ikm_year" class="block text-sm font-semibold text-slate-700 mb-1.5">Tahun Penilaian IKM</label>
                <input id="ikm_year"
                    name="ikm_year"
                    type="number"
                    min="2000"
                    max="2100"
                    value="<?= esc(old('ikm_year', $settings['ikm_year'] ?? date('Y'))) ?>"
                    required
                    placeholder="Contoh: 2026"
                    class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-bnn-600 sm:text-sm bg-slate-50 focus:bg-white transition-colors">
                <p class="mt-1.5 text-xs text-slate-500">Tahun pelaksanaan survei kepuasan.</p>
            </div>

            <!-- Auto Live Conversion Preview -->
            <div class="flex flex-wrap items-center justify-between gap-4 p-4 text-xs border rounded-lg sm:col-span-2 bg-sky-50 border-sky-200 sm:text-sm text-sky-950">
                <div>
                    <span class="font-bold text-sky-900">Hasil Konversi Otomatis:</span>
                    <span id="ikm-converted-preview" class="ml-2 text-base font-black text-sky-700">
                        <?php
                        $rawS = trim((string)($settings['ikm_score'] ?? '-'));
                        echo (is_numeric($rawS) && (float)$rawS >= 0) ? number_format(((float)$rawS) * 25, 2) : '-';
                        ?>
                    </span>
                    <span class="text-xs text-sky-700">(Skala 25 - 100)</span>
                </div>
                <div>
                    <span class="font-bold text-sky-900">Mutu Pelayanan:</span>
                    <span id="ikm-grade-preview" class="ml-2 font-bold px-2.5 py-1 rounded-md bg-emerald-600 text-white text-xs">
                        <?php
                        $rawS = trim((string)($settings['ikm_score'] ?? '-'));
                        if (is_numeric($rawS) && (float)$rawS >= 0) {
                            $conv = ((float)$rawS) * 25;
                            if ($conv >= 88.31) echo 'Sangat Baik';
                            elseif ($conv >= 76.61) echo 'Baik';
                            elseif ($conv >= 65.00) echo 'Kurang Baik';
                            else echo 'Tidak Baik';
                        } else {
                            echo '-';
                        }
                        ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateIkmPreview(val) {
            const trimmed = String(val).trim();
            const score = parseFloat(val);
            const gradeEl = document.getElementById('ikm-grade-preview');
            const convertedEl = document.getElementById('ikm-converted-preview');

            if (isNaN(score) || trimmed === '-' || trimmed === '') {
                convertedEl.textContent = '-';
                gradeEl.textContent = '-';
                gradeEl.className = 'ml-2 font-bold px-2.5 py-1 rounded-md bg-slate-200 text-slate-700 text-xs';
                return;
            }

            const converted = (Math.min(4.0, Math.max(0.0, score)) * 25).toFixed(2);
            convertedEl.textContent = converted;

            if (converted >= 88.31) {
                gradeEl.textContent = 'Sangat Baik';
                gradeEl.className = 'ml-2 font-bold px-2.5 py-1 rounded-md bg-emerald-600 text-white text-xs';
            } else if (converted >= 76.61) {
                gradeEl.textContent = 'Baik';
                gradeEl.className = 'ml-2 font-bold px-2.5 py-1 rounded-md bg-sky-600 text-white text-xs';
            } else if (converted >= 65.00) {
                gradeEl.textContent = 'Kurang Baik';
                gradeEl.className = 'ml-2 font-bold px-2.5 py-1 rounded-md bg-amber-600 text-white text-xs';
            } else {
                gradeEl.textContent = 'Tidak Baik';
                gradeEl.className = 'ml-2 font-bold px-2.5 py-1 rounded-md bg-rose-600 text-white text-xs';
            }
        }
    </script>

    <div class="flex justify-end">
        <button type="submit"
            class="inline-flex items-center gap-2 rounded-lg bg-bnn-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:bg-bnn-800 hover:shadow-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-bnn-600">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                <polyline points="17 21 17 13 7 13 7 21"></polyline>
                <polyline points="7 3 7 8 15 8"></polyline>
            </svg>
            Simpan perubahan
        </button>
    </div>
</form>

<!-- Form Grafik Bulanan -->
<div class="mt-8 overflow-hidden bg-white border shadow-sm rounded-xl border-slate-200">
    <div class="flex flex-col gap-4 px-6 py-5 border-b border-slate-200 bg-slate-50/50 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-base font-semibold text-slate-800">Grafik Statistik Bulanan (SKHPN & Klien Rehabilitasi)</h2>
            <p class="text-sm text-slate-500 mt-0.5">Input jumlah bulanan yang tampil pada grafik Line Chart di halaman depan.</p>
        </div>
        <form method="get" action="<?= base_url('dashboard/landing-page') ?>" class="flex items-center gap-2 m-0">
            <label for="admin-year-select" class="text-xs font-semibold text-slate-600">Tahun:</label>
            <select id="admin-year-select" name="year" onchange="if(this.value==='new'){const y=prompt('Masukkan tahun yang ingin diisi (contoh: 2025 atau 2027):'); if(y && !isNaN(y) && y >= 2000 && y <= 2100){window.location.href='<?= base_url('dashboard/landing-page') ?>?year='+y;} else {this.value='<?= $selectedYear ?>';}} else {this.form.submit();}" class="rounded-lg border-slate-300 text-xs py-1.5 px-3 bg-white text-slate-800 shadow-xs focus:ring-2 focus:ring-bnn-600 cursor-pointer">
                <?php foreach ($availableYears as $y): ?>
                    <option value="<?= $y ?>" <?= $y === $selectedYear ? 'selected' : '' ?>><?= $y ?></option>
                <?php endforeach; ?>
                <option value="new">+ Tambah Tahun Lain...</option>
            </select>
        </form>
    </div>

    <form method="post" action="<?= base_url('dashboard/landing-page/save-monthly-stats') ?>" class="p-6">
        <?= csrf_field() ?>
        <input type="hidden" name="year" value="<?= $selectedYear ?>">

        <div class="overflow-x-auto border rounded-lg border-slate-200">
            <table class="w-full text-xs text-left sm:text-sm text-slate-700">
                <thead class="font-semibold border-b bg-slate-50 text-slate-900 border-slate-200">
                    <tr>
                        <th class="px-4 py-3">Bulan</th>
                        <th class="px-4 py-3">Jumlah SKHPN</th>
                        <th class="px-4 py-3">Jumlah Klien Rehabilitasi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    <?php foreach ($monthlyData as $m => $d): ?>
                        <tr class="hover:bg-slate-50/60">
                            <td class="px-4 py-2.5 font-bold text-slate-800 w-1/3">
                                <?= esc($d['name']) ?>
                            </td>
                            <td class="px-4 py-2">
                                <input type="number" name="months[<?= $m ?>][skhpn_count]" min="0" value="<?= esc($d['skhpn_count']) ?>" required class="w-full max-w-[160px] rounded-lg border-0 py-1.5 px-3 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-bnn-600 sm:text-xs bg-slate-50 focus:bg-white">
                            </td>
                            <td class="px-4 py-2">
                                <input type="number" name="months[<?= $m ?>][rehab_count]" min="0" value="<?= esc($d['rehab_count']) ?>" required class="w-full max-w-[160px] rounded-lg border-0 py-1.5 px-3 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-bnn-600 sm:text-xs bg-slate-50 focus:bg-white">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="flex justify-end mt-5">
            <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-bnn-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition-all hover:bg-bnn-800 hover:shadow-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-bnn-600">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                    <polyline points="7 3 7 8 15 8"></polyline>
                </svg>
                Simpan Grafik Bulanan (<?= $selectedYear ?>)
            </button>
        </div>
    </form>
</div>