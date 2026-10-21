<?php foreach ($quizzes as $quiz): ?>

    <article
        class="group flex flex-col overflow-hidden bg-white border rounded-xl shadow-sm border-slate-200 transition-all duration-200 hover:-translate-y-0.5 hover:border-bnn-300 hover:shadow-md">

        <!-- Image -->
        <div class="h-48 overflow-hidden bg-slate-100 sm:h-44 lg:h-48 relative">
            <?php if (! empty($quiz['image'])): ?>
                <img
                    src="<?= base_url($quiz['image']) ?>"
                    alt="Ilustrasi <?= esc($quiz['title']) ?>"
                    class="block w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.03]"
                    loading="lazy">
            <?php else: ?>
                <div class="flex flex-col items-center justify-center w-full h-full p-4 bg-gradient-to-br from-emerald-50 via-teal-50 to-sky-50">
                    <div class="p-3.5 bg-white/90 rounded-2xl shadow-xs border border-emerald-100 mb-1.5 transition-transform duration-300 group-hover:scale-110">
                        <svg class="w-8 h-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M12 18h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold tracking-wide text-emerald-900/70">Kuis Edukasi BNN</span>
                </div>
            <?php endif; ?>
        </div>

        <!-- Content -->
        <div class="flex flex-col flex-1 min-w-0 p-5 sm:p-6">

            <!-- Text -->
            <div class="min-w-0">

                <h2
                    class="text-lg font-bold leading-7 break-words text-sky-950 line-clamp-3">
                    <?= esc($quiz['title']) ?>
                </h2>

                <p
                    class="max-w-2xl mt-2 text-sm leading-6 line-clamp-3 text-bnn-muted">
                    <?= esc(
                        mb_strimwidth(
                            $quiz['description'] ?: 'Semangat mengerjakan kuisnya!',
                            0,
                            220,
                            '...'
                        )
                    ) ?>
                </p>

            </div>

            <!-- Footer -->
            <div class="pt-5 mt-auto">

                <!-- Question count -->
                <div class="flex items-center gap-2 text-sm font-medium text-bnn-muted">

                    <svg
                        class="w-4 h-4 text-bnn-600"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        aria-hidden="true">

                        <path d="M7 3a4 4 0 0 0-4 4v10a4 4 0 0 0 4 4h13v-2H7a2 2 0 0 1 2-4h13V7a4 4 0 0 0-4-4H7Zm0 4h9v2H7V7Zm0 4h6v2H7v-2Z" />

                    </svg>

                    <span>
                        <?= (int) ($quiz['question_count'] ?? 0) ?> soal
                    </span>

                </div>

                <!-- CTA -->
                <a
                    href="<?= base_url('quiz/' . $quiz['id']) ?>"
                    class="flex items-center justify-center w-full gap-2 px-5 py-2.5 mt-3 text-sm font-bold text-white transition rounded-md shadow-sm min-h-10 bg-bnn-600 hover:bg-bnn-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-bnn-600 focus-visible:ring-offset-2">

                    Mulai kuis

                    <svg
                        class="w-4 h-4"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5 12h14m-5-5 5 5-5 5" />

                    </svg>

                </a>

            </div>

        </div>

    </article>

<?php endforeach; ?>