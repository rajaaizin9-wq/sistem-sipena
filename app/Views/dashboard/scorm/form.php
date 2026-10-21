<?php $edit = $edit ?? false; ?>
<?php $module = $module ?? null; ?>

<!-- Page Header -->
<div class="mb-8">
    <p class="mb-1 text-xs font-bold tracking-widest uppercase text-sky-600">
        <?= $edit ? 'Edit Modul' : 'Tambah Modul' ?> Bacaan
    </p>
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-slate-800">
                <?= $edit ? 'Edit metadata modul' : 'Unggah modul edukasi baru' ?>
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                <?= $edit ? 'Ubah judul, deskripsi, atau thumbnail modul.' : 'Unggah paket modul atau dokumen PDF untuk dibuat menjadi modul bacaan.' ?>
            </p>
        </div>
    </div>
</div>

<?= view('dashboard/partials/flash_messages') ?>

<?php if ($edit && $module): ?>
    <form id="scorm-upload-form" method="post" action="<?= base_url('dashboard/scorm/update/' . esc($module['id'], 'url')) ?>" enctype="multipart/form-data" class="flex flex-col gap-6 lg:flex-row lg:gap-8">
<?php else: ?>
    <form id="scorm-upload-form" method="post" action="<?= base_url('dashboard/scorm/store') ?>" enctype="multipart/form-data" class="flex flex-col gap-6 lg:flex-row lg:gap-8">
<?php endif; ?>

    <?= csrf_field() ?>

    <!-- Main: Informasi Modul -->
    <div class="flex-1 space-y-6">
        <section class="overflow-hidden bg-white border shadow-sm rounded-xl border-slate-200">
            <div class="px-6 py-5 border-b border-slate-200 bg-slate-50/50">
                <h2 class="text-base font-semibold text-slate-800">Informasi Modul</h2>
                <p class="text-sm text-slate-500 mt-0.5">Isi metadata modul yang akan ditampilkan kepada pengguna.</p>
            </div>
            <div class="p-6 space-y-5">

                <!-- Judul -->
                <div>
                    <label for="title" class="block text-sm font-semibold text-slate-700 mb-1.5">Judul modul</label>
                    <input id="title" name="title" type="text"
                           value="<?= esc(old('title', $module['title'] ?? '')) ?>"
                           required
                           placeholder="Contoh: Bahaya Narkotika dan Psikotropika"
                           class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm bg-slate-50 focus:bg-white transition-colors">
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Deskripsi <span class="text-xs font-normal text-slate-400">(opsional)</span>
                    </label>
                    <textarea id="description" name="description" rows="5"
                               placeholder="Tulis ringkasan singkat isi modul…"
                               class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm bg-slate-50 focus:bg-white transition-colors resize-none"><?= esc(old('description', $module['description'] ?? '')) ?></textarea>
                </div>

                <!-- File Modul (hanya saat tambah) -->
                <?php if (! $edit): ?>
                    <div>
                        <label for="file" class="block text-sm font-semibold text-slate-700 mb-1.5">File modul</label>
                        <input id="file" name="file" type="file"
                               accept=".zip,.pdf,.ppt,.pptx"
                               required
                               class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-3.5 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 cursor-pointer transition-colors border border-slate-200 rounded-lg p-1">
                        <p class="mt-2 text-xs text-slate-500">Format yang diterima: ZIP File dan PDF.</p>
                    </div>
                <?php endif; ?>

            </div>
        </section>
    </div>

    <!-- Sidebar: Thumbnail & Status -->
    <aside class="flex-shrink-0 w-full space-y-6 lg:w-72">

        <!-- Thumbnail -->
        <section class="overflow-hidden bg-white border shadow-sm rounded-xl border-slate-200">
            <div class="px-6 py-5 border-b border-slate-200 bg-slate-50/50">
                <h2 class="text-base font-semibold text-slate-800">Thumbnail</h2>
                <p class="text-sm text-slate-500 mt-0.5">Tampil di daftar modul. Opsional.</p>
            </div>
            <div class="p-6 space-y-4">

                <!-- Preview thumbnail -->
                <div class="rounded-lg overflow-hidden border border-slate-200 bg-slate-50 flex items-center justify-center min-h-[140px]">
                    <?php if ($edit && $module && ! empty($module['thumbnail'])): ?>
                        <img src="<?= base_url($module['thumbnail']) ?>"
                             alt="Thumbnail modul saat ini"
                             class="object-cover w-full h-full">
                    <?php else: ?>
                        <div class="px-4 py-8 text-center">
                            <svg class="w-10 h-10 mx-auto text-slate-300" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="block mt-2 text-xs font-medium text-slate-400">Belum ada thumbnail</span>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Input thumbnail -->
                <div>
                    <input id="thumbnail" name="thumbnail" type="file"
                           accept="image/png,image/jpeg,image/jpg,image/gif,image/webp"
                           class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-3.5 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 cursor-pointer transition-colors border border-slate-200 rounded-lg p-1">
                    <p class="mt-2 text-xs text-slate-500">PNG, JPG, atau WebP. Maks. 2 MB.</p>
                </div>
            </div>
        </section>

        <!-- Status Publikasi -->
        <section class="overflow-hidden bg-white border shadow-sm rounded-xl border-slate-200">
            <div class="px-6 py-5 border-b border-slate-200 bg-slate-50/50">
                <h2 class="text-base font-semibold text-slate-800">Publikasi</h2>
                <p class="text-sm text-slate-500 mt-0.5">Atur visibilitas modul.</p>
            </div>
            <div class="p-6">
                <label for="published" class="block text-sm font-semibold text-slate-700 mb-1.5">Status</label>
                <select id="published" name="published"
                        class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm bg-slate-50 focus:bg-white cursor-pointer transition-colors">
                    <?php if ($edit && $module): ?>
                        <option value="0" <?= (old('published', (string) ($module['published'] ?? '0')) === '0') ? 'selected' : '' ?>>Draft</option>
                        <option value="1" <?= (old('published', (string) ($module['published'] ?? '0')) === '1') ? 'selected' : '' ?>>Terbit</option>
                    <?php else: ?>
                        <option value="0" <?= old('published', '0') === '0' ? 'selected' : '' ?>>Draft</option>
                        <option value="1" <?= old('published') === '1' ? 'selected' : '' ?>>Terbit</option>
                    <?php endif; ?>
                </select>
            </div>
        </section>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-3">
            <a href="<?= base_url('dashboard/scorm') ?>"
               class="inline-flex justify-center rounded-lg px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-100 border border-slate-300 transition-colors">
                Batal
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 justify-center rounded-lg bg-sky-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-sky-700 transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600 disabled:opacity-50 disabled:cursor-not-allowed">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <?php if ($edit): ?>
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline>
                    <?php else: ?>
                        <polyline points="16 16 12 12 8 16"></polyline><line x1="12" y1="12" x2="12" y2="21"></line><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"></path>
                    <?php endif; ?>
                </svg>
                <?= $edit ? 'Simpan perubahan' : 'Unggah modul' ?>
            </button>
        </div>

    </aside>

</form>

<!-- Modal Upload Progress -->
<div id="upload-progress-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm hidden transition-opacity">
    <div class="w-full max-w-sm p-5 bg-white shadow-2xl rounded-2xl border border-slate-100 space-y-3.5">
        <div class="flex items-center gap-3">
            <div class="flex items-center justify-center w-9 h-9 rounded-full bg-sky-100 text-sky-600 flex-shrink-0">
                <svg class="w-5 h-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-800">Mengunggah Modul</h3>
                <p class="text-xs text-slate-500" id="upload-modal-status">Mengunggah...</p>
            </div>
        </div>

        <div class="space-y-1">
            <div class="flex justify-between text-xs font-semibold text-slate-600">
                <span id="upload-bytes-text">0 MB</span>
                <span id="upload-percent-text" class="text-sky-600 font-bold">0%</span>
            </div>
            <div class="w-full h-2.5 overflow-hidden rounded-full bg-slate-100">
                <div id="upload-progress-bar" class="h-full bg-sky-600 rounded-full transition-all duration-150 w-0"></div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('scorm-upload-form');
    if (!form) return;

    const fileInput = document.getElementById('file');
    const progressModal = document.getElementById('upload-progress-modal');
    const progressBar = document.getElementById('upload-progress-bar');
    const percentText = document.getElementById('upload-percent-text');
    const bytesText = document.getElementById('upload-bytes-text');
    const modalStatus = document.getElementById('upload-modal-status');
    const submitBtn = form.querySelector('button[type="submit"]');

    form.addEventListener('submit', function (e) {
        if (fileInput && fileInput.files && fileInput.files.length === 0) return;

        e.preventDefault();

        const formData = new FormData(form);
        const xhr = new XMLHttpRequest();

        progressModal.classList.remove('hidden');
        submitBtn.disabled = true;

        xhr.upload.onprogress = function (event) {
            if (event.lengthComputable) {
                const percent = Math.round((event.loaded / event.total) * 100);
                const loadedMB = (event.loaded / (1024 * 1024)).toFixed(1);
                const totalMB = (event.total / (1024 * 1024)).toFixed(1);

                progressBar.style.width = percent + '%';
                percentText.textContent = percent + '%';
                bytesText.textContent = loadedMB + ' / ' + totalMB + ' MB';

                if (percent >= 100) {
                    modalStatus.textContent = 'Memproses modul...';
                }
            }
        };

        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 400) {
                const targetUrl = xhr.responseURL || "<?= base_url('dashboard/scorm') ?>";
                const match = xhr.responseText.match(/window\.showToast\(\s*['"](success|error|warning|info)['"]\s*,\s*(["'].*?["'])\s*\)/);
                if (match) {
                    try {
                        sessionStorage.setItem('pending_toast', JSON.stringify({ type: match[1], message: JSON.parse(match[2]) }));
                    } catch (e) {}
                }
                window.location.href = targetUrl;
            } else {
                progressModal.classList.add('hidden');
                submitBtn.disabled = false;
                alert('Gagal mengunggah modul.');
            }
        };

        xhr.onerror = function () {
            progressModal.classList.add('hidden');
            submitBtn.disabled = false;
            alert('Kesalahan jaringan.');
        };

        xhr.open('POST', form.action, true);
        xhr.send(formData);
    });
});
</script>