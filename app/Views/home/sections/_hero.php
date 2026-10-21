<section
    class="relative overflow-hidden bg-[position:75%_center] sm:bg-center bg-cover isolate"
    style="background-image: url('<?= base_url('assets/images/bg-home-2.png') ?>');">
    <div class="absolute inset-0 bg-gradient-to-r from-slate-950/65 via-slate-950/35 to-slate-950/10"></div>

    <div class="container relative py-8 sm:py-20 lg:py-28">

        <div class="max-w-2xl">

            <!-- Heading -->
            <h1 class="text-3xl font-bold leading-tight tracking-tight text-white sm:text-5xl lg:text-6xl">
                <span class="inline-block px-1.5 py-0.5 bg-sky-800"> Edukasi Narkoba </span>
                untuk
                <span class="text-white">
                    Masa Depan
                </span>
                <span class="text-white"> Indonesia </span>
            </h1>

            <!-- Description -->
            <p class="max-w-xl mt-4 text-sm font-normal leading-6 text-white drop-shadow-[0_1px_3px_rgba(0,0,0,0.2)] sm:mt-6 sm:text-lg sm:leading-7">
                Akses edukasi, informasi, layanan masyarakat, dan materi pembelajaran
                untuk bersama mencegah penyalahgunaan narkotika.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col items-start gap-2.5 mt-6 sm:flex-row sm:items-center sm:mt-8">
                <a href="<?= base_url('bacaan') ?>"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2 sm:px-4.5 sm:py-2 text-xs sm:text-sm font-semibold text-white transition-all duration-300 rounded-lg bg-sky-600 hover:bg-sky-700 shadow-md shadow-sky-950/30 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-sky-400">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span>Belajar Sekarang</span>
                </a>

                <a href="<?= base_url('quiz') ?>"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2 sm:px-4.5 sm:py-2 text-xs sm:text-sm font-semibold text-slate-900 transition-all duration-300 bg-white hover:bg-slate-300 rounded-lg shadow-md shadow-black/15 hover:-translate-y-0.5 focus:outline-none">
                    <svg class="w-4 h-4 shrink-0 text-slate-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    <span>Mulai Kuis</span>
                </a>
            </div>

        </div>

    </div>
</section>