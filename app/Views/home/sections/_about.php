<?php if (! empty($aboutSection)): ?>
    <section class="py-6 sm:py-10 bg-slate-100/70">
        <div class="container">

            <div class="grid items-center gap-8 lg:grid-cols-2 lg:gap-14">

                <!-- Content -->
                <div class="max-w-xl">
                    <h2 class="max-w-md mt-2 text-2xl font-bold leading-tight tracking-tight text-bnn-950 sm:text-3xl">
                        <?= esc($aboutSection['title']) ?>
                    </h2>

                    <p class="max-w-lg mt-5 text-sm leading-7 text-slate-600 sm:text-base">
                        <?= esc($aboutSection['description']) ?>
                    </p>

                    <?php if (! empty($aboutSection['link'])): ?><a
                            href="<?= esc($aboutSection['link']) ?>"
                            class="inline-flex items-center gap-2 mt-6 text-sm font-semibold transition-colors text-bnn-700 hover:text-bnn-950 focus:outline-none focus-visible:ring-2 focus-visible:ring-bnn-600 focus-visible:ring-offset-2">

                            Selengkapnya

                            <svg
                                class="w-4 h-4 transition-transform duration-200 hover:translate-x-0.5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M5 12h14m-5-5 5 5-5 5" />

                            </svg>

                        </a><?php endif; ?>

                </div>


                <!-- Image -->
                <div class="lg:justify-self-end">

                    <div class="w-full max-w-md overflow-hidden shadow-sm rounded-xl bg-slate-100">
                        <?php if (! empty($aboutSection['image'])): ?><img
                                src="<?= base_url($aboutSection['image']) ?>"
                                alt="<?= esc($aboutSection['title']) ?>"
                                class="object-cover w-full aspect-[4/3]"
                                loading="lazy"><?php endif; ?>
                    </div>

                </div>

            </div>

        </div>
    </section>
<?php endif; ?>
