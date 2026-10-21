<section class="py-6 sm:py-10 bg-slate-50/70">
    <div class="container">

        <!-- Heading -->
        <div class="max-w-2xl mx-auto text-center">
            <h2 class="text-2xl font-bold tracking-tight sm:text-3xl text-slate-900">
                Fakta Narkoba di Kota Tanjungpinang
            </h2>
            <div class="w-12 h-1.5 bg-blue-600 rounded-full mx-auto mt-3"></div>
        </div>

        <?php
        $factStyles = [
            [
                'border' => 'hover:border-blue-300',
                'icon' => '<svg class="w-8 h-8 text-blue-600 transition-transform duration-300 sm:w-11 sm:h-11 group-hover:scale-110" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/><path d="M14 9h5v5"/></svg>',
            ],
            [
                'border' => 'hover:border-rose-300',
                'icon' => '<svg class="w-8 h-8 transition-transform duration-300 sm:w-11 sm:h-11 text-rose-500 group-hover:scale-110" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
            ],
            [
                'border' => 'hover:border-amber-300',
                'icon' => '<svg class="w-8 h-8 transition-transform duration-300 sm:w-11 sm:h-11 text-amber-500 group-hover:scale-110" viewBox="0 0 24 24" fill="currentColor"><path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3z"/><path d="M5 13.18v4l7 3.82 7-3.82v-4L12 17l-7-3.82z"/></svg>',
            ],
            [
                'border' => 'hover:border-emerald-300',
                'icon' => '<svg class="w-8 h-8 transition-transform duration-300 sm:w-11 sm:h-11 text-emerald-500 group-hover:scale-110" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572"/><path d="M3 12h3l2 -4l3 8l2 -4h4"/></svg>',
            ],
        ];

        $defaultFacts = [
            ['value' => '289', 'title' => 'Kasus Tahun ini'],
            ['value' => '1200', 'title' => 'Penyalahgunaan total seluruh usia'],
            ['value' => '35%', 'title' => 'Adalah pelajar'],
            ['value' => '530', 'title' => 'Rehabilitasi'],
        ];

        $factsToDisplay = ! empty($drugFacts ?? []) ? $drugFacts : $defaultFacts;

        $ikmRaw = trim((string) ($settings['ikm_score'] ?? '-'));
        $ikmYear = $settings['ikm_year'] ?? date('Y');

        if (is_numeric($ikmRaw) && (float) $ikmRaw >= 0) {
            $numVal = min(4.0, max(0.0, (float) $ikmRaw));
            $ikmScore = number_format($numVal, 2);
            $ikmConverted = number_format($numVal * 25, 2);

            $ikmVal = (float) $ikmConverted;
            if ($ikmVal >= 88.31) {
                $ikmPredicate = 'Sangat Baik';
                $ikmBadgeStyle = 'bg-emerald-50 text-emerald-700 border-emerald-200';
            } elseif ($ikmVal >= 76.61) {
                $ikmPredicate = 'Baik';
                $ikmBadgeStyle = 'bg-blue-50 text-blue-700 border-blue-200';
            } elseif ($ikmVal >= 65.00) {
                $ikmPredicate = 'Kurang Baik';
                $ikmBadgeStyle = 'bg-amber-50 text-amber-700 border-amber-200';
            } else {
                $ikmPredicate = 'Tidak Baik';
                $ikmBadgeStyle = 'bg-rose-50 text-rose-700 border-rose-200';
            }
        } else {
            $ikmScore = '-';
            $ikmConverted = '-';
            $ikmPredicate = '-';
            $ikmBadgeStyle = 'bg-slate-50 text-slate-600 border-slate-200';
        }
        ?>

        <!-- Statistics Grid (4 columns side-by-side) -->
        <div class="grid grid-cols-4 gap-2 mt-8 sm:gap-6 sm:mt-10">
            <?php foreach ($factsToDisplay as $index => $fact): ?>
                <?php $style = $factStyles[$index % count($factStyles)]; ?>
                <div class="flex flex-col items-center justify-center p-2.5 sm:p-6 text-center bg-white rounded-xl border border-slate-200/70 shadow-[0_10px_25px_rgba(15,23,42,0.10)] sm:shadow-[0_12px_30px_rgba(15,23,42,0.12)] hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 group <?= $style['border'] ?>">

                    <!-- Icon Wrapper (No Background Color) -->
                    <div class="flex items-center justify-center h-10 mb-2 sm:h-14 sm:mb-3">
                        <?= $style['icon'] ?>
                    </div>

                    <!-- Number (Aligned Baseline) -->
                    <div class="flex items-center justify-center h-7 sm:h-9">
                        <p class="text-base font-bold tracking-tight sm:text-2xl text-slate-900">
                            <?= esc($fact['value']) ?>
                        </p>
                    </div>

                    <!-- Title (Slightly Smaller Font) -->
                    <div class="flex items-start justify-center h-8 mt-1 sm:h-10">
                        <p class="text-[9px] sm:text-xs font-medium text-slate-600 leading-tight">
                            <?= esc($fact['title']) ?>
                        </p>
                    </div>

                </div>
            <?php endforeach ?>
        </div>

        <!-- IKM Clean Highlight Card -->
        <div class="mt-6 p-4 sm:p-5 bg-white rounded-2xl border border-slate-200/80 shadow-[0_4px_20px_rgba(15,23,42,0.06)]">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                
                <!-- Left: Title & Info -->
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0 border border-sky-100">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-sm font-bold text-slate-900">Indeks Kepuasan Masyarakat (IKM)</h3>
                            <span class="text-[10px] font-semibold px-2 py-0.5 rounded bg-slate-100 text-slate-600 border border-slate-200">
                                Tahun <?= esc($ikmYear) ?>
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5">Layanan Rehabilitasi BNN Kota Tanjungpinang</p>
                    </div>
                </div>

                <!-- Right: Hero Metric Emphasis & Stats -->
                <div class="flex items-center gap-4 sm:gap-6 self-stretch sm:self-auto justify-between sm:justify-end pt-3 sm:pt-0 border-t sm:border-t-0 border-slate-100">
                    <!-- Hero Nilai (0-100) -->
                    <div class="text-left sm:text-right">
                        <span class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Nilai Kepuasan</span>
                        <div class="flex items-baseline gap-1">
                            <span class="text-2xl sm:text-3xl font-extrabold text-sky-600 tracking-tight"><?= $ikmConverted ?></span>
                            <span class="text-xs text-slate-400 font-medium">/ 100</span>
                        </div>
                    </div>

                    <div class="h-8 w-px bg-slate-200/80"></div>

                    <!-- Secondary Skala (0-4) -->
                    <div class="text-left sm:text-right">
                        <span class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Skala IKM</span>
                        <span class="text-lg sm:text-xl font-bold text-slate-800"><?= esc($ikmScore) ?></span>
                    </div>

                    <div class="h-8 w-px bg-slate-200/80"></div>

                    <!-- Mutu Predicate -->
                    <div class="text-left sm:text-right">
                        <span class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Mutu</span>
                        <span class="inline-block text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-0.5 rounded-md mt-0.5">
                            <?= $ikmPredicate ?>
                        </span>
                    </div>
                </div>

            </div>
        </div>

        <!-- Source Footer -->
        <p class="mt-4 text-xs font-normal text-center text-slate-400">
            * Data terverifikasi berdasarkan laporan resmi BNN Kota Tanjungpinang.
        </p>

        <!-- Line Chart Bulanan (SKHPN & Klien Rehabilitasi) -->
        <div class="p-5 mt-10 bg-white border shadow-sm sm:p-8 border-slate-200/80 rounded-2xl">
            <div class="flex flex-col gap-4 pb-4 border-b sm:flex-row sm:items-center sm:justify-between border-slate-100">
                <div>
                    <h3 class="flex items-center gap-2 text-base font-bold sm:text-lg text-slate-900">
                        <svg class="w-5 h-5 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                        </svg>
                        Grafik Layanan BNN Kota Tanjungpinang
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Penerbitan SKHPN dan jumlah Klien Rehabilitasi.</p>
                </div>

                <!-- Year Selector -->
                <div class="flex items-center gap-2">
                    <label for="public-stat-year" class="text-xs font-semibold text-slate-600">Tahun:</label>
                    <select id="public-stat-year" class="rounded-lg border-slate-300 text-xs py-1.5 px-3 bg-slate-50 text-slate-800 focus:ring-2 focus:ring-sky-600 cursor-pointer">
                        <?php foreach ($availableYears as $y): ?>
                            <option value="<?= $y ?>" <?= $y === $selectedYear ? 'selected' : '' ?>><?= $y ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Legends Header -->
            <div class="flex flex-wrap items-center gap-6 mt-4 text-xs font-semibold">
                <div class="flex items-center gap-2">
                    <span class="inline-block w-3 h-3 rounded-full bg-sky-600"></span>
                    <span class="text-slate-700">Layanan SKHPN</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-block w-3 h-3 rounded-full bg-emerald-500"></span>
                    <span class="text-slate-700">Klien Rehabilitasi</span>
                </div>
            </div>

            <!-- Canvas -->
            <div class="relative w-full h-64 mt-4 sm:h-80">
                <canvas id="monthlyTrendChart"></canvas>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
        <script>
            (function() {
                const monthsNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
                const rawData = <?= json_encode(array_values($monthlyData ?? [])) ?>;

                const skhpnData = rawData.map(d => d.skhpn_count);
                const rehabData = rawData.map(d => d.rehab_count);

                const ctx = document.getElementById('monthlyTrendChart').getContext('2d');

                const gradientSky = ctx.createLinearGradient(0, 0, 0, 300);
                gradientSky.addColorStop(0, 'rgba(2, 132, 199, 0.25)');
                gradientSky.addColorStop(1, 'rgba(2, 132, 199, 0.0)');

                const gradientEmerald = ctx.createLinearGradient(0, 0, 0, 300);
                gradientEmerald.addColorStop(0, 'rgba(16, 185, 129, 0.25)');
                gradientEmerald.addColorStop(1, 'rgba(16, 185, 129, 0.0)');

                const chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: monthsNames,
                        datasets: [{
                                label: 'Layanan SKHPN',
                                data: skhpnData,
                                borderColor: '#0284c7',
                                backgroundColor: gradientSky,
                                borderWidth: 2.5,
                                fill: true,
                                tension: 0.35,
                                pointBackgroundColor: '#0284c7',
                                pointRadius: 4,
                                pointHoverRadius: 6,
                            },
                            {
                                label: 'Klien Rehabilitasi',
                                data: rehabData,
                                borderColor: '#10b981',
                                backgroundColor: gradientEmerald,
                                borderWidth: 2.5,
                                fill: true,
                                tension: 0.35,
                                pointBackgroundColor: '#10b981',
                                pointRadius: 4,
                                pointHoverRadius: 6,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: '#0f172a',
                                titleFont: {
                                    family: 'system-ui',
                                    size: 12,
                                    weight: 'bold'
                                },
                                bodyFont: {
                                    family: 'system-ui',
                                    size: 12
                                },
                                padding: 10,
                                cornerRadius: 8,
                                displayColors: true,
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        size: 11,
                                        family: 'system-ui'
                                    },
                                    color: '#64748b'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: '#f1f5f9'
                                },
                                ticks: {
                                    precision: 0,
                                    font: {
                                        size: 11,
                                        family: 'system-ui'
                                    },
                                    color: '#64748b'
                                }
                            }
                        }
                    }
                });

                document.getElementById('public-stat-year')?.addEventListener('change', function() {
                    const year = this.value;
                    fetch('<?= base_url("api/monthly-stats") ?>?year=' + year)
                        .then(res => res.json())
                        .then(resData => {
                            if (resData.data) {
                                chart.data.datasets[0].data = resData.data.map(d => d.skhpn_count);
                                chart.data.datasets[1].data = resData.data.map(d => d.rehab_count);
                                chart.update();
                            }
                        });
                });
            })();
        </script>

    </div>
</section>