<div class="mb-8"><p class="text-xs font-bold uppercase tracking-[0.15em] text-bnn-600">Dashboard Humas Rehabilitasi</p><h1 class="mt-2 text-2xl font-semibold tracking-tight text-bnn-950 sm:text-3xl">Selamat datang, <?= esc($user['name']) ?>.</h1><p class="mt-2 text-sm text-slate-600">Ruang kerja untuk informasi dan edukasi rehabilitasi.</p></div>

<?= view('dashboard/partials/flash_messages') ?>

<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <article class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <span class="card-index"><?= esc($totalModules) ?></span>
        <h2>Total Modul Edukasi</h2>
        <p>Keseluruhan modul edukasi rehabilitasi yang tersimpan.</p>
    </article>
    <article class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <span class="card-index"><?= esc($publishedModules) ?></span>
        <h2>Modul Dipublikasikan</h2>
        <p>Modul yang aktif dan bisa diakses publik.</p>
    </article>
    <article class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <span class="card-index"><?= esc($draftModules) ?></span>
        <h2>Modul Draft</h2>
        <p>Modul yang belum diterbitkan.</p>
    </article>
    <article class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <span class="card-index"><?= esc($latestUpload) ?></span>
        <h2>Terakhir Diunggah</h2>
        <p>Modul terbaru yang ditambahkan ke sistem.</p>
    </article>
</div>

<?php if ($recentModules !== []): ?>
<div class="dashboard-panel">
    <h2>Modul Edukasi Terbaru</h2>
    <div class="dashboard-table-wrap">
        <table class="dashboard-table">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Status</th>
                    <th>Tanggal Upload</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentModules as $module): ?>
                    <tr>
                        <td><?= esc($module['title'] ?? '-') ?></td>
                        <td><?= ! empty($module['published']) ? 'Terbit' : 'Draft' ?></td>
                        <td><?= esc($module['created_at'] ?? '-') ?></td>
                        <td>
                            <a class="text-link" href="<?= base_url('dashboard/scorm/edit/' . esc($module['id'], 'url')) ?>">Edit</a>
                            <?php if (! empty($module['published'])): ?>
                                <a class="text-link" href="<?= base_url('dashboard/scorm/unpublish/' . esc($module['id'], 'url')) ?>" style="color: #b45309;">Tarik</a>
                            <?php else: ?>
                                <a class="text-link" href="<?= base_url('dashboard/scorm/publish/' . esc($module['id'], 'url')) ?>" style="color: #1f6b3d;">Terbitkan</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>
