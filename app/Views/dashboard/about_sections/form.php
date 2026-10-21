<?php $edit = is_array($section); ?>

<!-- Page Header -->
<div class="mb-8">
    <p class="text-xs font-bold uppercase tracking-widest text-bnn-600 mb-1">Landing Page</p>
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-800 tracking-tight">
                <?= $edit ? 'Edit Section Tentang Kami' : 'Tambah Section Tentang Kami' ?>
            </h1>
            <p class="text-slate-500 mt-1 text-sm">Section ini opsional. Landing page hanya menampilkan satu section Tentang Kami.</p>
        </div>
    </div>
</div>

<?= view('dashboard/partials/flash_messages') ?>

<form method="post"
      action="<?= base_url($edit ? 'dashboard/landing-page/about/' . $section['id'] : 'dashboard/landing-page/about') ?>"
      enctype="multipart/form-data"
      class="flex flex-col lg:flex-row gap-6 lg:gap-8">
    <?= csrf_field() ?>

    <!-- Main Fields -->
    <div class="flex-1 space-y-6">
        <section class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="border-b border-slate-200 bg-slate-50/50 px-6 py-5">
                <h2 class="text-base font-semibold text-slate-800">Konten Section</h2>
                <p class="text-sm text-slate-500 mt-0.5">Isi judul, deskripsi, dan tautan yang akan ditampilkan.</p>
            </div>
            <div class="p-6 space-y-5">

                <!-- Judul -->
                <div>
                    <label for="title" class="block text-sm font-semibold text-slate-700 mb-1.5">Judul</label>
                    <input id="title" name="title" type="text"
                           value="<?= esc(old('title', $section['title'] ?? '')) ?>"
                           required maxlength="150"
                           placeholder="Contoh: Tentang BNN Kota Tanjungpinang"
                           class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-bnn-600 sm:text-sm bg-slate-50 focus:bg-white transition-colors">
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-slate-700 mb-1.5">Deskripsi</label>
                    <textarea id="description" name="description" rows="6"
                              required maxlength="1000"
                              placeholder="Tulis deskripsi singkat tentang BNN…"
                              class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-bnn-600 sm:text-sm bg-slate-50 focus:bg-white transition-colors resize-none"><?= esc(old('description', $section['description'] ?? '')) ?></textarea>
                </div>

                <!-- Link -->
                <div>
                    <label for="link" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Link <span class="text-xs font-normal text-slate-400">(opsional)</span>
                    </label>
                    <input id="link" name="link" type="text"
                           value="<?= esc(old('link', $section['link'] ?? '')) ?>"
                           maxlength="255"
                           placeholder="https://contoh.go.id atau /profil"
                           class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-bnn-600 sm:text-sm bg-slate-50 focus:bg-white transition-colors">
                </div>

            </div>
        </section>
    </div>

    <!-- Sidebar: Gambar & Actions -->
    <aside class="w-full lg:w-72 flex-shrink-0 space-y-6">
        <section class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="border-b border-slate-200 bg-slate-50/50 px-6 py-5">
                <h2 class="text-base font-semibold text-slate-800">Gambar</h2>
                <p class="text-sm text-slate-500 mt-0.5">Opsional. Tampil di samping teks.</p>
            </div>
            <div class="p-6 space-y-4">

                <!-- Preview gambar saat ini -->
                <div class="rounded-lg overflow-hidden border border-slate-200 bg-slate-50 flex items-center justify-center min-h-[140px]">
                    <?php if (! empty($section['image'])): ?>
                        <img class="w-full h-full object-cover"
                             src="<?= base_url($section['image']) ?>"
                             alt="Gambar section saat ini">
                    <?php else: ?>
                        <div class="text-center px-4 py-8">
                            <svg class="mx-auto h-10 w-10 text-slate-300" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="mt-2 block text-xs font-medium text-slate-400">Belum ada gambar</span>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Input file -->
                <div>
                    <input id="image" name="image" type="file"
                           accept="image/png,image/jpeg,image/jpg,image/webp"
                           class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-3.5 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-bnn-50 file:text-bnn-700 hover:file:bg-bnn-100 cursor-pointer transition-colors border border-slate-200 rounded-lg p-1">
                    <p class="mt-2 text-xs text-slate-500">JPG, PNG, atau WebP. Maks. 2 MB.</p>
                </div>
            </div>
        </section>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-3">
            <a href="<?= base_url('dashboard/landing-page') ?>"
               class="inline-flex justify-center rounded-lg px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-100 border border-slate-300 transition-colors">
                Batal
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 justify-center rounded-lg bg-bnn-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-bnn-800 transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-bnn-600">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                <?= $edit ? 'Simpan Perubahan' : 'Tambah Section' ?>
            </button>
        </div>
    </aside>
</form>

