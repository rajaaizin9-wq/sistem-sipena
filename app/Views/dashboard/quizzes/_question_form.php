<?php $edit = is_array($question); ?>

<!-- Page Header -->
<div class="mb-8">
    <p class="text-xs font-bold uppercase tracking-widest text-sky-600 mb-1">Manajemen Kuis</p>
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-800 tracking-tight">
                <?= $edit ? 'Edit pertanyaan' : 'Tambah pertanyaan' ?> — <span class="text-sky-700"><?= esc($quiz['title']) ?></span>
            </h1>
            <p class="text-slate-500 mt-1 text-sm">
                <?= $edit ? 'Perbarui teks pertanyaan dan pilihan jawaban.' : 'Tambahkan pertanyaan baru ke kuis ini.' ?>
            </p>
        </div>
        <a href="<?= base_url('dashboard/quizzes/' . $quiz['id'] . '/questions') ?>"
           class="inline-flex items-center gap-2 justify-center rounded-lg px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-100 border border-slate-300 transition-colors shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
            Kembali
        </a>
    </div>
</div>

<?= view('dashboard/partials/flash_messages') ?>

<form method="post" action="<?= base_url($edit ? 'dashboard/quizzes/' . $quiz['id'] . '/questions/update/' . $question['id'] : 'dashboard/quizzes/' . $quiz['id'] . '/questions') ?>" class="flex flex-col lg:flex-row gap-6 lg:gap-8">
    <?= csrf_field() ?>

    <!-- Main: Pertanyaan -->
    <div class="flex-1 min-w-0">
        <section class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="border-b border-slate-200 bg-slate-50/50 px-6 py-5">
                <h2 class="text-base font-semibold text-slate-800">Pertanyaan</h2>
                <p class="text-sm text-slate-500 mt-0.5">Isi teks pertanyaan dan empat pilihan jawaban.</p>
            </div>
            <div class="p-6 space-y-5">

                <!-- Teks Pertanyaan -->
                <div>
                    <label for="question" class="block text-sm font-semibold text-slate-700 mb-1.5">Teks pertanyaan</label>
                    <textarea id="question" name="question" rows="4" required
                              placeholder="Tulis pertanyaan di sini…"
                              class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm bg-slate-50 focus:bg-white transition-colors resize-none"><?= esc(old('question', $question['question'] ?? '')) ?></textarea>
                </div>

                <!-- Pilihan Jawaban -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="option_a" class="block text-sm font-semibold text-slate-700 mb-1.5">Pilihan A</label>
                        <input id="option_a" name="option_a" type="text"
                               value="<?= esc(old('option_a', $question['option_a'] ?? '')) ?>"
                               maxlength="255" required
                               placeholder="Isi pilihan A…"
                               class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm bg-slate-50 focus:bg-white transition-colors">
                    </div>
                    <div>
                        <label for="option_b" class="block text-sm font-semibold text-slate-700 mb-1.5">Pilihan B</label>
                        <input id="option_b" name="option_b" type="text"
                               value="<?= esc(old('option_b', $question['option_b'] ?? '')) ?>"
                               maxlength="255" required
                               placeholder="Isi pilihan B…"
                               class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm bg-slate-50 focus:bg-white transition-colors">
                    </div>
                    <div>
                        <label for="option_c" class="block text-sm font-semibold text-slate-700 mb-1.5">Pilihan C</label>
                        <input id="option_c" name="option_c" type="text"
                               value="<?= esc(old('option_c', $question['option_c'] ?? '')) ?>"
                               maxlength="255" required
                               placeholder="Isi pilihan C…"
                               class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm bg-slate-50 focus:bg-white transition-colors">
                    </div>
                    <div>
                        <label for="option_d" class="block text-sm font-semibold text-slate-700 mb-1.5">Pilihan D</label>
                        <input id="option_d" name="option_d" type="text"
                               value="<?= esc(old('option_d', $question['option_d'] ?? '')) ?>"
                               maxlength="255" required
                               placeholder="Isi pilihan D…"
                               class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm bg-slate-50 focus:bg-white transition-colors">
                    </div>
                </div>

                <!-- Jawaban Benar -->
                <div>
                    <label for="correct_option" class="block text-sm font-semibold text-slate-700 mb-1.5">Jawaban benar</label>
                    <select id="correct_option" name="correct_option"
                            class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm bg-slate-50 focus:bg-white cursor-pointer transition-colors">
                        <?php foreach ([1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D'] as $number => $label): ?>
                            <option value="<?= $number ?>" <?= (int) old('correct_option', $question['correct_option'] ?? 1) === $number ? 'selected' : '' ?>>Pilihan <?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>
        </section>
    </div>

    <!-- Sidebar: Action -->
    <aside class="w-full lg:w-64 flex-shrink-0">
        <div class="flex items-center justify-end gap-3">
            <a href="<?= base_url('dashboard/quizzes/' . $quiz['id'] . '/questions') ?>"
               class="inline-flex justify-center rounded-lg px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-100 border border-slate-300 transition-colors">
                Batal
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 justify-center rounded-lg bg-sky-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-sky-700 transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                <?= $edit ? 'Perbarui pertanyaan' : 'Tambah pertanyaan' ?>
            </button>
        </div>
    </aside>

</form>