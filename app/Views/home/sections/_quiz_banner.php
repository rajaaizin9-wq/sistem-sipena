<section class="py-6 sm:py-10 bg-slate-100/70">
    <div class="container">

        <div class="flex items-center w-full overflow-hidden shadow-md bg-gradient-to-r from-sky-800 to-sky-700 rounded-xl">

            <!-- Illustration -->
            <div class="flex items-center justify-center flex-shrink-0 w-32 h-36 sm:w-48 sm:h-44 lg:w-64 lg:h-48">
                <img
                    src="<?= base_url('assets/images/kuis.png') ?>"
                    alt="Ilustrasi kuis"
                    class="object-contain w-full h-full"
                    loading="lazy">
            </div>

            <!-- Content -->
            <div class="flex-1 py-6 pr-5 sm:py-8 sm:pr-10 lg:pr-16">

                <h2 class="text-lg font-semibold leading-tight text-white sm:text-2xl">
                    Uji pengetahuanmu!
                </h2>

                <p class="max-w-xl mt-2 text-xs leading-5 text-sky-100 sm:text-sm sm:leading-6">
                    Kerjakan kuis seru dengan materi terkait seputar
                    penyalahgunaan Narkoba dan dampaknya bagi kesehatan.
                </p>

                <a href="<?= base_url('quiz') ?>"
                    class="inline-flex items-center gap-2 px-4 py-2.5 mt-4 text-xs font-semibold
                           text-sky-900 transition-all duration-200 bg-white rounded-lg
                           hover:bg-slate-50 hover:shadow-md
                           sm:text-sm">

                    <svg class="w-4 h-4 shrink-0 text-sky-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    <span>Mulai Kuis Sekarang</span>

                </a>

            </div>

        </div>

    </div>
</section>
