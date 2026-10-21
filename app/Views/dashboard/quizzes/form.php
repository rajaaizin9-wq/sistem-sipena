<?php $edit = is_array($quiz); ?>

<!-- Page Header -->
<div class="mb-8">
    <p class="text-xs font-bold uppercase tracking-widest text-sky-600 mb-1">Manajemen Kuis</p>
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-800 tracking-tight">
                <?= $edit ? 'Edit kuis' : 'Tambah kuis baru' ?>
            </h1>
            <p class="text-slate-500 mt-1 text-sm">
                <?= $edit ? 'Perbarui informasi kuis dan kelola pertanyaan.' : 'Buat kuis edukasi dengan beberapa pertanyaan pilihan ganda.' ?>
            </p>
        </div>
        <a href="<?= base_url('dashboard/quizzes') ?>"
           class="inline-flex items-center gap-2 justify-center rounded-lg px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-100 border border-slate-300 transition-colors shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
            Kembali
        </a>
    </div>
</div>

<?= view('dashboard/partials/flash_messages') ?>

<form method="post" action="<?= base_url($edit ? 'dashboard/quizzes/update/' . $quiz['id'] : 'dashboard/quizzes') ?>" enctype="multipart/form-data" class="flex flex-col lg:flex-row gap-6 lg:gap-8">
    <?= csrf_field() ?>

    <!-- Main: Informasi Kuis + Pertanyaan -->
    <div class="flex-1 min-w-0 space-y-6">

        <!-- Informasi Kuis -->
        <section class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="border-b border-slate-200 bg-slate-50/50 px-6 py-5">
                <h2 class="text-base font-semibold text-slate-800">Informasi Kuis</h2>
                <p class="text-sm text-slate-500 mt-0.5">Isi judul dan deskripsi untuk kuis ini.</p>
            </div>
            <div class="p-6 space-y-5">

                <!-- Judul -->
                <div>
                    <label for="title" class="block text-sm font-semibold text-slate-700 mb-1.5">Judul kuis</label>
                    <input id="title" name="title" type="text"
                           value="<?= esc(old('title', $quiz['title'] ?? '')) ?>"
                           maxlength="255" required
                           placeholder="Contoh: Bahaya Narkotika bagi Remaja"
                           class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm bg-slate-50 focus:bg-white transition-colors">
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Deskripsi <span class="text-xs font-normal text-slate-400">(opsional)</span>
                    </label>
                    <textarea id="description" name="description" rows="4" maxlength="5000"
                              placeholder="Tulis ringkasan singkat tentang kuis ini…"
                              class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm bg-slate-50 focus:bg-white transition-colors resize-none"><?= esc(old('description', $quiz['description'] ?? '')) ?></textarea>
                </div>

            </div>
        </section>

        <!-- Pertanyaan -->
        <section class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="border-b border-slate-200 bg-slate-50/50 px-6 py-5 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-semibold text-slate-800">Pertanyaan</h2>
                    <p class="text-sm text-slate-500 mt-0.5">Tambahkan satu atau beberapa pertanyaan pilihan ganda.</p>
                </div>
                <button type="button" id="add-question"
                        class="inline-flex items-center gap-1.5 rounded-lg bg-sky-50 border border-sky-200 px-3 py-1.5 text-xs font-semibold text-sky-700 hover:bg-sky-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    Tambah pertanyaan
                </button>
            </div>

            <div id="no-question-alert" class="hidden mx-6 mt-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-700 text-xs font-medium flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 text-red-500"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                <span>Kuis harus memiliki minimal 1 pertanyaan sebelum disimpan.</span>
            </div>

            <div id="questions-container" class="divide-y divide-slate-100">
                <?php
                $oldQuestions = old('question');
                $oldOptionA   = old('option_a');
                $oldOptionB   = old('option_b');
                $oldOptionC   = old('option_c');
                $oldOptionD   = old('option_d');
                $oldCorrect   = old('correct_option');
                $oldIds       = old('question_id');
                $rendered     = false;

                if (is_array($oldQuestions)) {
                    foreach ($oldQuestions as $i => $qText) {
                        $qText = $qText ?? '';
                ?>
                        <div class="question-block p-6 space-y-4" data-index="<?= $i ?>">
                            <div class="flex items-center justify-between">
                                <span class="question-number-label text-xs font-bold uppercase tracking-widest text-sky-600">Pertanyaan <?= $i + 1 ?></span>
                                <button type="button" class="remove-question inline-flex items-center gap-1 text-xs font-medium text-red-500 hover:text-red-700 hover:bg-red-50 rounded-md px-2 py-1 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                    Hapus
                                </button>
                            </div>
                            <input type="hidden" name="question_id[]" value="<?= esc($oldIds[$i] ?? '') ?>">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Teks pertanyaan</label>
                                <textarea name="question[]" rows="3" required
                                          placeholder="Tulis pertanyaan di sini…"
                                          class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm bg-slate-50 focus:bg-white transition-colors resize-none"><?= esc($qText) ?></textarea>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Pilihan A</label>
                                    <input name="option_a[]" type="text" value="<?= esc($oldOptionA[$i] ?? '') ?>" maxlength="255" required placeholder="Isi pilihan A…" class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm bg-slate-50 focus:bg-white transition-colors">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Pilihan B</label>
                                    <input name="option_b[]" type="text" value="<?= esc($oldOptionB[$i] ?? '') ?>" maxlength="255" required placeholder="Isi pilihan B…" class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm bg-slate-50 focus:bg-white transition-colors">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Pilihan C</label>
                                    <input name="option_c[]" type="text" value="<?= esc($oldOptionC[$i] ?? '') ?>" maxlength="255" required placeholder="Isi pilihan C…" class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm bg-slate-50 focus:bg-white transition-colors">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Pilihan D</label>
                                    <input name="option_d[]" type="text" value="<?= esc($oldOptionD[$i] ?? '') ?>" maxlength="255" required placeholder="Isi pilihan D…" class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm bg-slate-50 focus:bg-white transition-colors">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Jawaban benar</label>
                                <select name="correct_option[]"
                                        class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm bg-slate-50 focus:bg-white cursor-pointer transition-colors">
                                    <?php foreach ([1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D'] as $number => $lbl): ?>
                                        <option value="<?= $number ?>" <?= ((int) ($oldCorrect[$i] ?? 1) === $number) ? 'selected' : '' ?>>Pilihan <?= $lbl ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                <?php
                        $rendered = true;
                    }
                }

                if (! $rendered && isset($questions) && is_array($questions) && count($questions) > 0) {
                    foreach ($questions as $i => $q) {
                ?>
                        <div class="question-block p-6 space-y-4" data-index="<?= $i ?>">
                            <div class="flex items-center justify-between">
                                <span class="question-number-label text-xs font-bold uppercase tracking-widest text-sky-600">Pertanyaan <?= $i + 1 ?></span>
                                <button type="button" class="remove-question inline-flex items-center gap-1 text-xs font-medium text-red-500 hover:text-red-700 hover:bg-red-50 rounded-md px-2 py-1 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                    Hapus
                                </button>
                            </div>
                            <input type="hidden" name="question_id[]" value="<?= (int) ($q['id'] ?? 0) ?>">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Teks pertanyaan</label>
                                <textarea name="question[]" rows="3" required
                                          placeholder="Tulis pertanyaan di sini…"
                                          class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm bg-slate-50 focus:bg-white transition-colors resize-none"><?= esc($q['question'] ?? '') ?></textarea>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Pilihan A</label>
                                    <input name="option_a[]" type="text" value="<?= esc($q['option_a'] ?? '') ?>" maxlength="255" required placeholder="Isi pilihan A…" class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm bg-slate-50 focus:bg-white transition-colors">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Pilihan B</label>
                                    <input name="option_b[]" type="text" value="<?= esc($q['option_b'] ?? '') ?>" maxlength="255" required placeholder="Isi pilihan B…" class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm bg-slate-50 focus:bg-white transition-colors">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Pilihan C</label>
                                    <input name="option_c[]" type="text" value="<?= esc($q['option_c'] ?? '') ?>" maxlength="255" required placeholder="Isi pilihan C…" class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm bg-slate-50 focus:bg-white transition-colors">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Pilihan D</label>
                                    <input name="option_d[]" type="text" value="<?= esc($q['option_d'] ?? '') ?>" maxlength="255" required placeholder="Isi pilihan D…" class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm bg-slate-50 focus:bg-white transition-colors">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Jawaban benar</label>
                                <select name="correct_option[]"
                                        class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm bg-slate-50 focus:bg-white cursor-pointer transition-colors">
                                    <?php foreach ([1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D'] as $number => $lbl): ?>
                                        <option value="<?= $number ?>" <?= ((int) ($q['correct_option'] ?? 1) === $number) ? 'selected' : '' ?>>Pilihan <?= $lbl ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            </div>

            <!-- Empty state -->
            <div id="empty-questions" class="text-center py-12 px-6 text-slate-400">
                <svg class="mx-auto h-10 w-10 mb-3 text-slate-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                <p class="text-sm font-medium text-slate-500">Belum ada pertanyaan</p>
                <p class="text-xs text-slate-400 mt-1">Klik "Tambah pertanyaan" untuk mulai.</p>
            </div>
        </section>

    </div>

    <!-- Sidebar: Gambar & Action -->
    <aside class="w-full lg:w-72 flex-shrink-0 space-y-6">

        <!-- Gambar Kuis -->
        <section class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="border-b border-slate-200 bg-slate-50/50 px-6 py-5">
                <h2 class="text-base font-semibold text-slate-800">Gambar Kuis</h2>
                <p class="text-sm text-slate-500 mt-0.5">Opsional. Ditampilkan di halaman kuis.</p>
            </div>
            <div class="p-6 space-y-4">
                <div class="rounded-lg overflow-hidden border border-slate-200 bg-slate-50 flex items-center justify-center min-h-[140px]">
                    <?php if (! empty($quiz['image'])): ?>
                        <img src="<?= base_url($quiz['image']) ?>" alt="Gambar kuis saat ini" class="w-full h-full object-cover">
                    <?php else: ?>
                        <div class="text-center px-4 py-8">
                            <svg class="mx-auto h-10 w-10 text-slate-300" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd"/></svg>
                            <span class="mt-2 block text-xs font-medium text-slate-400">Belum ada gambar</span>
                        </div>
                    <?php endif; ?>
                </div>
                <div>
                    <input id="image" name="image" type="file"
                           accept="image/png,image/jpeg,image/jpg,image/webp"
                           class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-3.5 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 cursor-pointer transition-colors border border-slate-200 rounded-lg p-1">
                    <p class="mt-2 text-xs text-slate-500">JPG, PNG, atau WebP. Maks. 2 MB.</p>
                </div>
            </div>
        </section>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-3">
            <a href="<?= base_url('dashboard/quizzes') ?>"
               class="inline-flex justify-center rounded-lg px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-100 border border-slate-300 transition-colors">
                Batal
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 justify-center rounded-lg bg-sky-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-sky-700 transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                <?= $edit ? 'Simpan perubahan' : 'Simpan kuis' ?>
            </button>
        </div>

    </aside>

</form>

<script>
    (() => {
        const form       = document.querySelector('form');
        const container  = document.getElementById('questions-container');
        const addBtn     = document.getElementById('add-question');
        const emptyState = document.getElementById('empty-questions');
        const alertBox   = document.getElementById('no-question-alert');

        const inputCls    = "block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm bg-slate-50 focus:bg-white transition-colors";
        const selectCls   = "block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm bg-slate-50 focus:bg-white cursor-pointer transition-colors";
        const textareaCls = inputCls + " resize-none";

        function getCount() {
            return container.querySelectorAll('.question-block').length;
        }

        function updateLabels() {
            container.querySelectorAll('.question-block').forEach((block, i) => {
                const lbl = block.querySelector('.question-number-label');
                if (lbl) lbl.textContent = 'Pertanyaan ' + (i + 1);
            });
        }

        function checkEmpty() {
            const count = getCount();
            if (emptyState) emptyState.classList.toggle('hidden', count > 0);
            if (count > 0 && alertBox) alertBox.classList.add('hidden');
        }

        if (form) {
            form.addEventListener('submit', (e) => {
                if (getCount() === 0) {
                    e.preventDefault();
                    if (alertBox) {
                        alertBox.classList.remove('hidden');
                        alertBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }
            });
        }

        function createBlock(data = {}) {
            const i   = getCount();
            const div = document.createElement('div');
            div.className = 'question-block p-6 space-y-4 border-t border-slate-100';
            div.innerHTML = `
            <div class="flex items-center justify-between">
                <span class="question-number-label text-xs font-bold uppercase tracking-widest text-sky-600">Pertanyaan ${i + 1}</span>
                <button type="button" class="remove-question inline-flex items-center gap-1 text-xs font-medium text-red-500 hover:text-red-700 hover:bg-red-50 rounded-md px-2 py-1 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                    Hapus
                </button>
            </div>
            <input type="hidden" name="question_id[]" value="${data.id ?? ''}">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Teks pertanyaan</label>
                <textarea name="question[]" rows="3" required placeholder="Tulis pertanyaan di sini…" class="${textareaCls}">${data.question ?? ''}</textarea>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                ${['A','B','C','D'].map(l => `
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Pilihan ${l}</label>
                    <input name="option_${l.toLowerCase()}[]" type="text" value="${data['option_'+l.toLowerCase()] ?? ''}" maxlength="255" required placeholder="Isi pilihan ${l}…" class="${inputCls}">
                </div>`).join('')}
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Jawaban benar</label>
                <select name="correct_option[]" class="${selectCls}">
                    <option value="1" ${(data.correct_option ?? 1) == 1 ? 'selected' : ''}>Pilihan A</option>
                    <option value="2" ${(data.correct_option ?? 1) == 2 ? 'selected' : ''}>Pilihan B</option>
                    <option value="3" ${(data.correct_option ?? 1) == 3 ? 'selected' : ''}>Pilihan C</option>
                    <option value="4" ${(data.correct_option ?? 1) == 4 ? 'selected' : ''}>Pilihan D</option>
                </select>
            </div>
            `;
            attachRemove(div);
            return div;
        }

        function attachRemove(block) {
            const btn = block.querySelector('.remove-question');
            if (btn) btn.addEventListener('click', () => {
                block.remove();
                updateLabels();
                checkEmpty();
            });
        }

        if (addBtn) addBtn.addEventListener('click', () => {
            const block = createBlock();
            container.appendChild(block);
            block.scrollIntoView({ behavior: 'smooth', block: 'center' });
            checkEmpty();
        });

        document.querySelectorAll('.question-block').forEach(attachRemove);
        checkEmpty();
    })();
</script>

