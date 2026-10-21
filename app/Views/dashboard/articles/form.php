<?php $edit = is_array($article); ?>
<div class="mb-8">
    <p class="text-xs font-bold uppercase tracking-widest text-bnn-600 mb-1">Artikel</p>
    <h1 class="text-2xl font-black text-slate-800 tracking-tight"><?= $edit ? 'Edit Artikel' : 'Tambah Artikel' ?></h1>
    <p class="text-slate-500 mt-1 text-sm"><?= $edit ? 'Perbarui isi, gambar utama, atau status publikasi artikel.' : 'Siapkan artikel untuk disimpan sebagai draft atau langsung diterbitkan.' ?></p>
</div>

<?= view('dashboard/partials/flash_messages') ?>

<form method="post" action="<?= base_url($edit ? 'dashboard/articles/update/' . $article['id'] : 'dashboard/articles') ?>" enctype="multipart/form-data" class="flex flex-col lg:flex-row gap-6 lg:gap-8">
    <?= csrf_field() ?>
    
    <!-- Main Content Form -->
    <div class="flex-1 space-y-6">
        <section class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="border-b border-slate-200 bg-slate-50/50 px-6 py-5">
                <h2 class="text-base font-semibold text-slate-800">Konten Artikel</h2>
                <p class="text-sm text-slate-500 mt-0.5">Tulis informasi yang akan dibaca publik.</p>
            </div>
            
            <div class="p-6 space-y-5">
                <div>
                    <label for="title" class="block text-sm font-semibold text-slate-700 mb-2">Judul</label>
                    <input id="title" name="title" type="text" value="<?= esc(old('title', $article['title'] ?? '')) ?>" required maxlength="255" placeholder="Masukkan judul artikel" class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-bnn-600 sm:text-sm sm:leading-6 bg-slate-50 focus:bg-white transition-colors">
                </div>
                
                <div>
                    <label for="tag" class="block text-sm font-semibold text-slate-700 mb-2">Tag</label>
                    <input id="tag" name="tag" type="text" value="<?= esc(old('tag', $article['tag'] ?? '')) ?>" maxlength="100" placeholder="Contoh: Edukasi" class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-bnn-600 sm:text-sm sm:leading-6 bg-slate-50 focus:bg-white transition-colors">
                </div>
                
                <div>
                    <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi</label>
                    <textarea id="description" name="description" rows="3" maxlength="500" placeholder="Ringkasan singkat artikel (opsional)" class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-bnn-600 sm:text-sm sm:leading-6 bg-slate-50 focus:bg-white transition-colors resize-none"><?= esc(old('description', $article['description'] ?? '')) ?></textarea>
                </div>
                
                <div>
                    <label for="content" class="block text-sm font-semibold text-slate-700 mb-2">Isi artikel</label>
                    <div class="prose-editor-container rounded-lg shadow-sm overflow-hidden border border-slate-300 focus-within:ring-2 focus-within:ring-bnn-600 focus-within:border-transparent transition-all">
                        <textarea id="content" name="content" rows="12"><?= esc(old('content', $article['content'] ?? '')) ?></textarea>
                    </div>
                </div>
            </div>
        </section>
    </div>
    
    <!-- Sidebar Settings -->
    <aside class="w-full lg:w-80 flex-shrink-0 space-y-6">
        <section class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="border-b border-slate-200 bg-slate-50/50 px-6 py-5">
                <h2 class="text-base font-semibold text-slate-800">Publikasi</h2>
                <p class="text-sm text-slate-500 mt-0.5">Atur visibilitas dan gambar utama.</p>
            </div>
            
            <div class="p-6 space-y-5">
                <div>
                    <label for="status" class="block text-sm font-semibold text-slate-700 mb-2">Status</label>
                    <select id="status" name="status" class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-bnn-600 sm:text-sm sm:leading-6 bg-slate-50 focus:bg-white cursor-pointer transition-colors">
                        <option value="draft" <?= old('status', $article['status'] ?? 'draft') === 'draft' ? 'selected' : '' ?>>Simpan sebagai draft</option>
                        <option value="published" <?= old('status', $article['status'] ?? '') === 'published' ? 'selected' : '' ?>>Terbitkan sekarang</option>
                    </select>
                </div>
                
                <div>
                    <label for="created_at" class="block text-sm font-semibold text-slate-700 mb-2">Waktu Publikasi</label>
                    <input id="created_at" name="created_at" type="datetime-local" value="<?= esc(old('created_at', ! empty($article['created_at']) ? date('Y-m-d\TH:i', strtotime($article['created_at'])) : date('Y-m-d\TH:i'))) ?>" class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-bnn-600 sm:text-sm sm:leading-6 bg-slate-50 focus:bg-white cursor-pointer transition-colors">
                    <p class="mt-1.5 text-xs text-slate-500">Tanggal & waktu tayang artikel (bisa disunting).</p>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Gambar utama</label>
                    
                    <div class="mt-2 mb-4 rounded-lg overflow-hidden border border-slate-200 bg-slate-50 flex items-center justify-center min-h-[160px]">
                        <?php if (! empty($article['image'])): ?>
                            <img class="w-full h-full object-cover" src="<?= base_url($article['image']) ?>" alt="Gambar utama artikel saat ini">
                        <?php else: ?>
                            <div class="text-center px-4 py-8">
                                <svg class="mx-auto h-12 w-12 text-slate-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" /></svg>
                                <span class="mt-2 block text-sm font-medium text-slate-400">Belum ada gambar</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="relative">
                        <input id="image" name="image" type="file" accept="image/png,image/jpeg,image/jpg,image/webp" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-bnn-50 file:text-bnn-700 hover:file:bg-bnn-100 cursor-pointer transition-colors border border-slate-200 rounded-lg p-1">
                    </div>
                    <p class="mt-2 text-xs leading-5 text-slate-500">Opsional. JPG, PNG, atau WebP. Maksimal 2 MB.</p>
                </div>
            </div>
        </section>
        
        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="<?= base_url('dashboard/articles') ?>" class="inline-flex justify-center rounded-lg px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-100 border border-slate-300 transition-colors">Batal</a>
            <button type="submit" class="inline-flex justify-center rounded-lg bg-bnn-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-bnn-800 transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-bnn-600">
                <?= $edit ? 'Simpan Perubahan' : 'Simpan Artikel' ?>
            </button>
        </div>
    </aside>
</form>

<style>
/* CKEditor overrides for better Tailwind integration */
.ck-editor__editable_inline { min-height: 300px; padding: 0 1.5rem !important; }
.ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) { border-color: transparent !important; }
.ck.ck-editor__main>.ck-editor__editable.ck-focused { box-shadow: none !important; border-color: transparent !important; }
.ck.ck-toolbar { border: none !important; border-bottom: 1px solid #e2e8f0 !important; background-color: #f8fafc !important; }
</style>
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
    ClassicEditor.create(document.querySelector('#content'), {
        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'undo', 'redo'],
        heading: { options: [{ model: 'paragraph', title: 'Paragraf', class: 'ck-heading_paragraph' }, { model: 'heading2', view: 'h2', title: 'Judul', class: 'ck-heading_heading2' }, { model: 'heading3', view: 'h3', title: 'Subjudul', class: 'ck-heading_heading3' }] },
    }).catch((error) => console.error(error));
</script>
