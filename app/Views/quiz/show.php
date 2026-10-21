<?php $questionCount = count($questions); ?>
<section class="bg-slate-50 py-8 sm:py-12 min-h-[calc(100vh-140px)] flex flex-col justify-center">
    <div class="w-full max-w-2xl px-4 mx-auto sm:px-6">

        <!-- Top Navigation -->
        <div class="flex items-center justify-between mb-4">
            <a href="<?= base_url('quiz') ?>" class="inline-flex items-center gap-2 text-sm font-semibold transition-colors text-slate-600 hover:text-sky-600">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m12 19-7-7 7-7" />
                    <path d="M19 12H5" />
                </svg>
                <span>Kembali ke Daftar Kuis</span>
            </a>
            <span class="px-3 py-1 text-xs font-semibold border rounded-full bg-sky-50 text-sky-700 border-sky-200/60">
                SIPENA • Kuis Edukasi
            </span>
        </div>

        <?= view('dashboard/partials/flash_messages') ?>

        <?php if ($questionCount === 0): ?>
            <div class="p-8 space-y-4 text-center bg-white border shadow-xl rounded-2xl shadow-slate-200/60 border-slate-200/80">
                <div class="flex items-center justify-center w-16 h-16 mx-auto rounded-full bg-slate-100 text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3" />
                        <line x1="12" y1="17" x2="12.01" y2="17" />
                    </svg>
                </div>
                <h1 class="text-xl font-bold text-slate-900"><?= esc($quiz['title']) ?></h1>
                <p class="text-sm text-slate-500">Belum ada pertanyaan pada kuis ini.</p>
            </div>
        <?php else: ?>
            <form id="quiz-player-form" method="post" action="<?= base_url('quiz/' . $quiz['id'] . '/submit') ?>" class="bg-white rounded-2xl shadow-xl shadow-slate-200/60 border border-slate-200/80 overflow-hidden flex flex-col min-h-[480px]" novalidate>
                <?= csrf_field() ?>

                <!-- Card Header -->
                <header class="flex items-center justify-between gap-4 p-6 border-b border-slate-100 bg-slate-50/50">
                    <div class="flex items-center min-w-0 gap-3">
                        <img src="<?= base_url('assets/images/logo-bnn.png') ?>" alt="Logo BNN" class="object-contain w-10 h-10 shrink-0">
                        <div class="min-w-0">
                            <h2 class="text-base font-bold truncate text-slate-900" title="<?= esc($quiz['title']) ?>"><?= esc($quiz['title']) ?></h2>
                            <p class="text-xs font-medium text-slate-500">BNN Kota Tanjungpinang</p>
                        </div>
                    </div>
                    <div class="text-right shrink-0">
                        <span id="quiz-step-indicator" class="inline-flex items-center gap-1 px-3 py-1 text-xs font-bold border rounded-full bg-sky-50 text-sky-700 border-sky-200/60">
                            <span id="quiz-current-number">Data</span>
                            <span id="quiz-total-number" class="font-normal text-sky-600/70">/ <?= $questionCount ?></span>
                        </span>
                    </div>
                </header>

                <!-- Progress Bar -->
                <div class="w-full bg-slate-100 h-1.5 overflow-hidden" role="progressbar" aria-label="Kemajuan kuis">
                    <div id="quiz-progress-bar" class="w-0 h-full transition-all duration-300 ease-out bg-gradient-to-r from-sky-500 to-sky-600"></div>
                </div>

                <!-- Main Form Body -->
                <div class="flex flex-col justify-between flex-1 p-6 sm:p-8">

                    <!-- Step 0: Participant Data -->
                    <section class="space-y-6 quiz-step" data-step="0">
                        <div>
                            <h1 class="mt-1 text-xl font-bold sm:text-2xl text-slate-900">Data Diri Peserta</h1>
                            <p class="mt-1 text-sm text-slate-500">Silakan isi data diri Anda sebelum memulai pengerjaan kuis.</p>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label for="participant_name" class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap</label>
                                <div class="relative rounded-lg shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                            <circle cx="12" cy="7" r="4" />
                                        </svg>
                                    </div>
                                    <input id="participant_name" name="participant_name" value="<?= esc(old('participant_name')) ?>" maxlength="100" required autocomplete="name" placeholder="Masukkan nama lengkap Anda" class="block w-full pl-10 pr-4 py-2.5 text-sm text-slate-900 bg-white border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-colors placeholder:text-slate-400">
                                </div>
                            </div>

                            <div>
                                <label for="participant_age" class="block text-sm font-semibold text-slate-700 mb-1.5">Umur (Tahun)</label>
                                <div class="relative rounded-lg shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect width="18" height="18" x="3" y="4" rx="2" ry="2" />
                                            <line x1="16" y1="2" x2="16" y2="6" />
                                            <line x1="8" y1="2" x2="8" y2="6" />
                                            <line x1="3" y1="10" x2="21" y2="10" />
                                        </svg>
                                    </div>
                                    <input id="participant_age" name="participant_age" type="number" value="<?= esc(old('participant_age')) ?>" min="7" max="80" required inputmode="numeric" placeholder="Contoh: 17" class="block w-full pl-10 pr-4 py-2.5 text-sm text-slate-900 bg-white border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-colors placeholder:text-slate-400">
                                </div>
                            </div>
                        </div>

                        <div class="quiz-step-error hidden p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs font-medium flex items-center gap-2.5" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-500 shrink-0">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" x2="12" y1="8" y2="12" />
                                <line x1="12" x2="12.01" y1="16" y2="16" />
                            </svg>
                            <span>Harap lengkapi nama dan umur Anda terlebih dahulu.</span>
                        </div>

                        <div class="flex justify-end pt-4">
                            <button type="button" data-next class="w-full sm:w-auto px-6 py-2.5 bg-sky-600 hover:bg-sky-700 active:bg-sky-800 text-white font-semibold text-sm rounded-xl shadow-sm shadow-sky-600/30 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 transition-colors flex items-center justify-center gap-2 group cursor-pointer">
                                <span>Mulai Kuis</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform group-hover:translate-x-0.5">
                                    <path d="M5 12h14" />
                                    <path d="m12 5 7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </section>

                    <!-- Steps 1..N: Questions -->
                    <?php foreach ($questions as $index => $question): ?>
                        <section class="hidden space-y-6 quiz-step" data-step="<?= $index + 1 ?>">
                            <div>
                                <span class="text-xs font-extrabold tracking-wider uppercase text-sky-600">Pertanyaan <?= $index + 1 ?> dari <?= $questionCount ?></span>
                                <h2 class="mt-1 text-lg font-bold leading-snug sm:text-xl text-slate-900"><?= esc($question['question']) ?></h2>
                            </div>

                            <div class="grid grid-cols-1 gap-3 quiz-options">
                                <?php foreach (['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4] as $key => $number): ?>
                                    <label class="quiz-option-card group relative flex items-center gap-3.5 p-4 rounded-xl border border-slate-200 bg-white hover:border-sky-300 hover:bg-sky-50/50 cursor-pointer transition-all duration-150 select-none">
                                        <input type="radio" name="answer[<?= $question['id'] ?>]" value="<?= $number ?>" class="sr-only">
                                        <span class="flex items-center justify-center text-sm font-bold transition-colors border rounded-lg option-badge shrink-0 w-9 h-9 bg-slate-100 text-slate-600 border-slate-200 group-hover:border-sky-300 group-hover:text-sky-700">
                                            <?= strtoupper($key) ?>
                                        </span>
                                        <span class="flex-1 text-sm font-medium leading-snug text-slate-800 group-hover:text-slate-900">
                                            <?= esc($question['option_' . $key]) ?>
                                        </span>
                                    </label>
                                <?php endforeach; ?>
                            </div>

                            <div class="quiz-step-error hidden p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs font-medium flex items-center gap-2.5" role="alert">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-500 shrink-0">
                                    <circle cx="12" cy="12" r="10" />
                                    <line x1="12" x2="12" y1="8" y2="12" />
                                    <line x1="12" x2="12.01" y1="16" y2="16" />
                                </svg>
                                <span>Pilih salah satu jawaban terlebih dahulu.</span>
                            </div>

                            <div class="flex items-center justify-between gap-3 pt-4 border-t border-slate-100">
                                <button type="button" data-previous class="px-5 py-2.5 border border-slate-300 hover:bg-slate-100 text-slate-700 font-semibold text-sm rounded-xl transition-colors flex items-center gap-2 cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m15 18-6-6 6-6" />
                                    </svg>
                                    <span>Kembali</span>
                                </button>

                                <button type="button" data-next class="px-6 py-2.5 bg-sky-600 hover:bg-sky-700 active:bg-sky-800 text-white font-semibold text-sm rounded-xl shadow-sm shadow-sky-600/30 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 transition-colors flex items-center gap-2 group cursor-pointer">
                                    <span><?= $index + 1 === $questionCount ? 'Gass Kirim' : 'Lanjut' ?></span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform group-hover:translate-x-0.5">
                                        <path d="M5 12h14" />
                                        <path d="m12 5 7 7-7 7" />
                                    </svg>
                                </button>
                            </div>
                        </section>
                    <?php endforeach; ?>

                </div>
            </form>
        <?php endif; ?>
    </div>
</section>

<?php if ($questionCount > 0): ?>
    <script>
        (() => {
            const form = document.getElementById('quiz-player-form');
            if (!form) return;

            const steps = Array.from(form.querySelectorAll('.quiz-step'));
            const currentNumber = document.getElementById('quiz-current-number');
            const totalNumber = document.getElementById('quiz-total-number');
            const progressBar = document.getElementById('quiz-progress-bar');
            const questionCount = <?= $questionCount ?>;
            let activeStep = 0;

            function updateOptionStyles(stepElement) {
                stepElement.querySelectorAll('.quiz-option-card').forEach((card) => {
                    const radio = card.querySelector('input[type="radio"]');
                    const badge = card.querySelector('.option-badge');

                    if (radio && radio.checked) {
                        card.classList.add('border-sky-600', 'bg-sky-50/80', 'ring-2', 'ring-sky-600/20', 'text-sky-950', 'font-semibold', 'shadow-sm');
                        card.classList.remove('border-slate-200', 'bg-white');
                        if (badge) {
                            badge.classList.add('bg-sky-600', 'text-white', 'border-sky-600', 'shadow-sm');
                            badge.classList.remove('bg-slate-100', 'text-slate-600', 'border-slate-200');
                        }
                    } else {
                        card.classList.remove('border-sky-600', 'bg-sky-50/80', 'ring-2', 'ring-sky-600/20', 'text-sky-950', 'font-semibold', 'shadow-sm');
                        card.classList.add('border-slate-200', 'bg-white');
                        if (badge) {
                            badge.classList.remove('bg-sky-600', 'text-white', 'border-sky-600', 'shadow-sm');
                            badge.classList.add('bg-slate-100', 'text-slate-600', 'border-slate-200');
                        }
                    }
                });
            }

            function showStep(nextStep) {
                activeStep = nextStep;
                steps.forEach((step, index) => {
                    const isActive = index === activeStep;
                    step.classList.toggle('hidden', !isActive);
                    if (isActive) updateOptionStyles(step);
                });

                if (currentNumber && totalNumber) {
                    if (activeStep === 0) {
                        currentNumber.textContent = 'Data';
                        totalNumber.textContent = `/ ${questionCount}`;
                    } else {
                        currentNumber.textContent = activeStep;
                        totalNumber.textContent = `/ ${questionCount}`;
                    }
                }

                if (progressBar) {
                    const pct = activeStep === 0 ? 0 : Math.round((activeStep / questionCount) * 100);
                    progressBar.style.width = `${pct}%`;
                }

                const activeInput = steps[activeStep]?.querySelector('input:not([type="hidden"]), button');
                if (activeInput) activeInput.focus();
            }

            form.addEventListener('click', (event) => {
                const nextBtn = event.target.closest('[data-next]');
                const prevBtn = event.target.closest('[data-previous]');

                if (prevBtn) {
                    showStep(Math.max(0, activeStep - 1));
                    return;
                }

                if (nextBtn) {
                    handleNext();
                }
            });

            function handleNext() {
                const step = steps[activeStep];
                if (!step) return;
                const error = step.querySelector('.quiz-step-error');

                if (activeStep === 0) {
                    const nameInput = step.querySelector('#participant_name');
                    const ageInput = step.querySelector('#participant_age');
                    const nameVal = nameInput?.value.trim();
                    const ageVal = ageInput?.value.trim();
                    const ageNum = Number(ageVal);

                    let errorMsg = '';
                    if (!nameVal) {
                        errorMsg = 'Harap isi nama lengkap Anda.';
                        nameInput?.focus();
                    } else if (!ageVal) {
                        errorMsg = 'Harap isi umur Anda.';
                        ageInput?.focus();
                    } else if (isNaN(ageNum) || !Number.isInteger(ageNum) || ageNum < 7 || ageNum > 80) {
                        errorMsg = 'Umur tidak valid! Harap masukkan umur berupa angka 7 - 80 tahun.';
                        ageInput?.focus();
                    }

                    if (errorMsg) {
                        if (error) {
                            const span = error.querySelector('span') || error;
                            span.textContent = errorMsg;
                            error.classList.remove('hidden');
                        }
                        return;
                    }
                } else {
                    const checked = step.querySelector('input[type="radio"]:checked');
                    if (!checked) {
                        if (error) error.classList.remove('hidden');
                        return;
                    }
                }

                if (error) error.classList.add('hidden');

                if (activeStep === questionCount) {
                    form.submit();
                } else {
                    showStep(activeStep + 1);
                }
            }

            form.addEventListener('change', (event) => {
                const step = steps[activeStep];
                if (step) {
                    updateOptionStyles(step);
                    const error = step.querySelector('.quiz-step-error');
                    if (error) error.classList.add('hidden');
                }
            });

            // Keyboard shortcuts (A, B, C, D or 1, 2, 3, 4 or Enter)
            document.addEventListener('keydown', (event) => {
                if (event.target.tagName === 'INPUT' || event.target.tagName === 'TEXTAREA') {
                    if (event.key === 'Enter' && activeStep === 0) {
                        event.preventDefault();
                        handleNext();
                    }
                    return;
                }

                const step = steps[activeStep];
                if (!step || activeStep === 0) return;

                const keyMap = {
                    'a': 0,
                    'A': 0,
                    '1': 0,
                    'b': 1,
                    'B': 1,
                    '2': 1,
                    'c': 2,
                    'C': 2,
                    '3': 2,
                    'd': 3,
                    'D': 3,
                    '4': 3,
                };

                if (keyMap.hasOwnProperty(event.key)) {
                    const index = keyMap[event.key];
                    const radios = Array.from(step.querySelectorAll('input[type="radio"]'));
                    if (radios[index]) {
                        radios[index].checked = true;
                        updateOptionStyles(step);
                        const error = step.querySelector('.quiz-step-error');
                        if (error) error.classList.add('hidden');
                    }
                } else if (event.key === 'Enter') {
                    event.preventDefault();
                    handleNext();
                } else if (event.key === 'ArrowLeft' && activeStep > 1) {
                    event.preventDefault();
                    showStep(activeStep - 1);
                } else if (event.key === 'ArrowRight' && activeStep < questionCount) {
                    event.preventDefault();
                    handleNext();
                }
            });

            showStep(0);
        })();
    </script>
<?php endif; ?>