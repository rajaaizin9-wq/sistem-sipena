<section
    class="relative min-h-[380px] sm:min-h-[440px] flex items-center overflow-hidden border-b border-slate-200"
    aria-labelledby="layanan-title">

    <!-- Background Image -->
    <div
        class="absolute inset-0 bg-center bg-cover"
        style="background-image: url('<?= base_url('assets/images/bnn-tpi.png') ?>');">
    </div>

    <!-- Gradient Overlay for Contrast -->
    <div class="absolute inset-0 bg-gradient-to-r from-sky-950/65 via-sky-950/50 to-sky-900/35"></div>

    <!-- Content -->
    <div class="container relative z-10 py-16 sm:py-20 lg:py-24">
        <div class="max-w-3xl">
            <h1
                id="layanan-title"
                class="text-3xl font-semibold leading-tight tracking-tight text-white sm:text-4xl lg:text-5xl">
                <?= esc($settings['hero_title']) ?>
            </h1>

            <p class="max-w-2xl mt-4 text-sm leading-relaxed sm:text-base lg:text-lg text-sky-100/90">
                <?= esc($settings['hero_subtitle']) ?>
            </p>

            <div class="flex flex-wrap items-center gap-4 mt-8">
                <a
                    href="<?= esc($settings['hero_cta_url'], 'attr') ?>"
                    class="inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold text-white transition-colors rounded-lg shadow-sm bg-sky-700 hover:bg-sky-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-sky-950">
                    <?= esc($settings['hero_cta_label']) ?>
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Layanan Utama -->
<section id="layanan" class="border-b py-14 sm:py-16 bg-slate-50 border-slate-200/80" aria-labelledby="services-title">
    <div class="container">
        <div class="max-w-2xl">
            <h2 id="services-title" class="text-2xl font-bold tracking-tight sm:text-3xl text-sky-950">
                <?= esc($settings['services_title']) ?>
            </h2>
            <p class="mt-2 text-sm leading-6 sm:text-base text-slate-600">
                <?= esc($settings['services_body']) ?>
            </p>
        </div>

        <div class="grid grid-cols-1 gap-6 mt-8 sm:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($services as $service): ?>
                <a href="<?= esc($service_links[$service['title']] ?? '#akses', 'attr') ?>" class="block group">
                    <article class="flex flex-col h-full p-6 transition-all duration-300 bg-white border shadow-md border-slate-200/90 rounded-2xl shadow-slate-200/60 hover:-translate-y-1 hover:border-sky-400 hover:shadow-xl hover:shadow-sky-100/60">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center justify-center w-12 h-12 border rounded-xl bg-sky-50 border-sky-100 text-sky-700" aria-hidden="true">
                                <?= $service['icon'] ?>
                            </div>
                            <span class="inline-flex items-center gap-1 text-xs font-semibold text-sky-700 bg-sky-50 px-2.5 py-1 rounded-full border border-sky-100 group-hover:bg-sky-600 group-hover:text-white transition-colors">
                                Lihat Alur
                                <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-5-5 5 5-5 5" />
                                </svg>
                            </span>
                        </div>

                        <h3 class="mt-5 text-lg font-bold text-sky-950">
                            <?= esc($service['title']) ?>
                        </h3>
                        <p class="mt-2 text-sm leading-6 text-slate-600">
                            <?= esc($service['description']) ?>
                        </p>
                    </article>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Layanan Gurindam Banner -->
<section id="akses" class="py-12 bg-white border-b border-slate-200/80">
    <div class="container">
        <div class="flex flex-col gap-6 p-6 border shadow-sm sm:p-8 bg-slate-50 border-slate-200/90 rounded-2xl sm:flex-row sm:items-center sm:justify-between">
            <div class="max-w-2xl">
                <h2 class="text-xl font-bold tracking-tight sm:text-2xl text-sky-950">
                    Layanan Gurindam BNN Kota Tanjungpinang
                </h2>
                <p class="mt-2 text-sm leading-relaxed sm:text-base text-slate-600">
                    Akses praktis berbagai pelayanan publik seperti penerbitan SKHPN, tes urine, permohonan penyuluhan/narasumber, hingga pendaftaran rehabilitasi.
                </p>
            </div>

            <div class="flex-shrink-0">
                <a
                    href="https://linktr.ee/layananbnnktpi"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white bg-sky-700 rounded-lg shadow-sm hover:bg-sky-800 transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-sky-600 focus-visible:ring-offset-2">
                    Buka Layanan Gurindam
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6m4-3h6v6m-11 5L21 3" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>


<!-- Bidang Organisasi -->
<section class="bg-white border-b py-14 sm:py-16 border-slate-200/80" aria-labelledby="bnn-fields-title">
    <div class="container">
        <div class="max-w-2xl">
            <h2 id="bnn-fields-title" class="text-2xl font-bold tracking-tight sm:text-3xl text-sky-950">
                Bidang Kerja BNN Kota Tanjungpinang
            </h2>
            <p class="mt-2 text-sm sm:text-base text-slate-600">
                Setiap bidang bertugas memberikan pelayanan, pencegahan, pemberdayaan, serta pemulihan secara terpadu.
            </p>
        </div>

        <div class="grid gap-5 mt-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5">
            <?php
            $fields = [
                ['Sub Bagian Umum', 'Administrasi, tata kelola kelembagaan, dan koordinasi umum.', 'bg-sky-50 text-sky-700 border-sky-100', '<path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />'],
                ['Seksi Rehabilitasi', 'Layanan pemulihan medis & sosial serta pendampingan klien.', 'bg-emerald-50 text-emerald-700 border-emerald-100', '<path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />'],
                ['Seksi Dayamas', 'Pemberdayaan masyarakat & penguatan ketahanan kawasan.', 'bg-amber-50 text-amber-700 border-amber-100', '<path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />'],
                ['Seksi Pencegahan', 'Edukasi P4GN, sosialisasi, dan pencegahan dini bahaya narkoba.', 'bg-indigo-50 text-indigo-700 border-indigo-100', '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />'],
                ['Seksi Pemberantasan', 'Intelijen, penyelidikan, penyidikan, penindakan, dan pemutusan jaringan peredaran gelap narkotika.', 'bg-rose-50 text-rose-700 border-rose-100', '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />'],
            ];
            foreach ($fields as [$name, $description, $badgeStyle, $iconSvg]):
            ?>
                <div class="flex flex-col p-6 transition-all bg-white border shadow-sm border-slate-200/90 rounded-2xl hover:shadow-md hover:border-sky-300">
                    <div class="flex items-center justify-center w-11 h-11 rounded-xl border <?= $badgeStyle ?>">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <?= $iconSvg ?>
                        </svg>
                    </div>

                    <h3 class="mt-4 text-base font-bold text-sky-950">
                        <?= esc($name) ?>
                    </h3>
                    <p class="mt-2 text-xs leading-6 sm:text-sm text-slate-600">
                        <?= esc($description) ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Lokasi Kantor -->
<section id="lokasi" class="py-14 sm:py-16 bg-slate-50" aria-labelledby="location-title">
    <div class="container">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div class="max-w-2xl">
                <h2 id="location-title" class="text-2xl font-bold tracking-tight sm:text-3xl text-sky-950">
                    Lokasi Kantor BNN
                </h2>
                <p class="mt-2 text-sm sm:text-base text-slate-600">
                    Kunjungi kantor BNN Kota Tanjungpinang untuk konsultasi dan pelayanan tatap muka.
                </p>
            </div>
            <a
                href="https://maps.google.com/?q=0.953596554,104.44287277788504"
                target="_blank"
                rel="noopener noreferrer"
                class="inline-flex items-center gap-2 px-4 py-2.5 text-xs sm:text-sm font-semibold text-sky-700 bg-white border border-slate-300 rounded-lg shadow-sm hover:bg-sky-50 hover:border-sky-400 transition-colors shrink-0">
                <svg class="w-4 h-4 text-sky-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Buka di Google Maps
            </a>
        </div>

        <!-- Address Card & Map -->
        <div class="grid gap-6 mt-8 lg:grid-cols-3">
            <div class="flex flex-col justify-between p-6 bg-white border shadow-sm sm:p-7 border-slate-200/90 rounded-2xl lg:col-span-1">
                <div>
                    <!-- Card Header -->
                    <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                        <svg class="w-6 h-6 text-sky-900 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <div>
                            <h3 class="text-base font-bold text-sky-950">
                                Kantor BNN
                            </h3>
                            <p class="text-xs font-medium text-slate-500">
                                Kota Tanjungpinang
                            </p>
                        </div>
                    </div>

                    <!-- Details List -->
                    <div class="mt-5 space-y-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-slate-500 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <div>
                                <h4 class="text-xs font-semibold tracking-wider uppercase text-slate-600">Alamat Kantor</h4>
                                <p class="mt-1 text-xs font-medium leading-relaxed sm:text-sm text-slate-700">
                                    Jl. Daeng Kamboja, Senggarang, Kec. Tanjungpinang Kota, Kota Tanjungpinang, Kepulauan Riau
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-slate-500 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <h4 class="text-xs font-semibold tracking-wider uppercase text-slate-600">Jam Operasional</h4>
                                <p class="mt-1 text-xs font-semibold sm:text-sm text-slate-800">
                                    Senin - Jumat: <span class="text-sky-700">08:00 - 16:00 WIB</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden bg-white border shadow-sm border-slate-200/90 rounded-2xl lg:col-span-2">
                <iframe
                    src="https://www.openstreetmap.org/export/embed.html?bbox=104.44151759147645%2C0.9529207887887423%2C104.44357216358186%2C0.9544869818596032&layer=mapnik&marker=0.953596554%2C104.44287277788504"
                    class="w-full h-64 border-0 sm:h-80"
                    loading="lazy"
                    title="Lokasi BNN Kota Tanjungpinang">
                </iframe>
            </div>
        </div>
    </div>
</section>