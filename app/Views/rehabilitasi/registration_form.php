<section class="bg-slate-50 py-12 sm:py-16">
    <div class="container max-w-4xl">
        <div class="mb-8">
            <a class="inline-flex min-h-11 items-center text-sm font-semibold text-bnn-800 hover:text-bnn-600" href="<?= base_url('/#akses') ?>">
                <span aria-hidden="true" class="mr-2 text-lg">&larr;</span> Kembali ke akses layanan
            </a>
            <p class="mb-3 mt-7 text-xs font-extrabold uppercase tracking-[.12em] text-bnn-600">Layanan rehabilitasi</p>
            <h1 class="max-w-3xl text-3xl font-bold leading-tight text-bnn-950 sm:text-4xl">Pendaftaran Rehabilitasi Rawat Jalan</h1>
            <p class="mt-3 text-base leading-7 text-bnn-muted">Salam Sehat Tanpa Narkoba</p>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="mb-6 border-l-4 border-emerald-600 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800" role="status">
                <?= esc(session()->getFlashdata('success')) ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="mb-6 border-l-4 border-red-600 bg-red-50 px-4 py-3 text-sm font-medium text-red-800" role="alert">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <?php if ($validationErrors !== []): ?>
            <div class="mb-6 border-l-4 border-red-600 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">
                <p class="font-bold">Periksa kembali data berikut:</p>
                <ul class="mt-2 list-disc space-y-1 pl-5">
                    <?php foreach ($validationErrors as $validationError): ?>
                        <li><?= esc($validationError) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form class="border border-bnn-line bg-white p-5 shadow-sm sm:p-8" method="post" action="<?= base_url('pendaftaran-rehabilitasi') ?>">
            <?= csrf_field() ?>

            <div>
                <h2 class="border-b border-bnn-line pb-4 text-xl font-bold text-bnn-950">Data klien</h2>
                <div class="mt-6 grid gap-5 md:grid-cols-2">
                    <label class="text-sm font-semibold text-bnn-ink">Nama Klien <span class="text-red-600">*</span>
                        <input class="mt-2 min-h-11 w-full rounded-md border border-slate-300 bg-white px-3 py-2.5 text-sm font-normal text-bnn-ink placeholder:text-slate-400 focus:border-bnn-600 focus:outline-none focus:ring-2 focus:ring-bnn-100" type="text" name="client_name" value="<?= esc(old('client_name')) ?>" maxlength="255" autocomplete="name" required>
                    </label>
                    <label class="text-sm font-semibold text-bnn-ink">NIK/SIM/Paspor <span class="text-red-600">*</span>
                        <input class="mt-2 min-h-11 w-full rounded-md border border-slate-300 bg-white px-3 py-2.5 text-sm font-normal text-bnn-ink focus:border-bnn-600 focus:outline-none focus:ring-2 focus:ring-bnn-100" type="text" name="client_nik" value="<?= esc(old('client_nik')) ?>" maxlength="50" required>
                    </label>
                    <fieldset>
                        <legend class="text-sm font-semibold text-bnn-ink">Jenis Kelamin <span class="text-red-600">*</span></legend>
                        <div class="mt-3 flex min-h-11 flex-wrap items-center gap-5">
                            <label class="inline-flex items-center gap-2 text-sm font-normal text-bnn-ink"><input class="h-4 w-4 accent-bnn-800" type="radio" name="gender" value="Laki-laki" <?= old('gender') === 'Laki-laki' ? 'checked' : '' ?> required> Laki-laki</label>
                            <label class="inline-flex items-center gap-2 text-sm font-normal text-bnn-ink"><input class="h-4 w-4 accent-bnn-800" type="radio" name="gender" value="Perempuan" <?= old('gender') === 'Perempuan' ? 'checked' : '' ?>> Perempuan</label>
                        </div>
                    </fieldset>
                    <label class="text-sm font-semibold text-bnn-ink">Tempat Lahir <span class="text-red-600">*</span>
                        <input class="mt-2 min-h-11 w-full rounded-md border border-slate-300 px-3 py-2.5 text-sm font-normal text-bnn-ink focus:border-bnn-600 focus:outline-none focus:ring-2 focus:ring-bnn-100" type="text" name="birth_place" value="<?= esc(old('birth_place')) ?>" maxlength="150" required>
                    </label>
                    <label class="text-sm font-semibold text-bnn-ink">Tanggal Lahir <span class="text-red-600">*</span>
                        <input class="mt-2 min-h-11 w-full rounded-md border border-slate-300 px-3 py-2.5 text-sm font-normal text-bnn-ink focus:border-bnn-600 focus:outline-none focus:ring-2 focus:ring-bnn-100" type="date" name="birth_date" value="<?= esc(old('birth_date')) ?>" required>
                    </label>
                    <label class="text-sm font-semibold text-bnn-ink">Umur Klien <span class="text-red-600">*</span>
                        <input class="mt-2 min-h-11 w-full rounded-md border border-slate-300 px-3 py-2.5 text-sm font-normal text-bnn-ink focus:border-bnn-600 focus:outline-none focus:ring-2 focus:ring-bnn-100" type="number" name="client_age" value="<?= esc(old('client_age')) ?>" min="0" max="120" required>
                    </label>
                    <label class="text-sm font-semibold text-bnn-ink">No. HP Klien <span class="text-red-600">*</span>
                        <input class="mt-2 min-h-11 w-full rounded-md border border-slate-300 px-3 py-2.5 text-sm font-normal text-bnn-ink focus:border-bnn-600 focus:outline-none focus:ring-2 focus:ring-bnn-100" type="tel" name="client_phone" value="<?= esc(old('client_phone')) ?>" maxlength="20" autocomplete="tel" required>
                    </label>
                    <label class="text-sm font-semibold text-bnn-ink md:col-span-2">Alamat Klien <span class="text-red-600">*</span>
                        <textarea class="mt-2 w-full rounded-md border border-slate-300 px-3 py-2.5 text-sm font-normal text-bnn-ink focus:border-bnn-600 focus:outline-none focus:ring-2 focus:ring-bnn-100" name="client_address" rows="3" required><?= esc(old('client_address')) ?></textarea>
                    </label>
                </div>
            </div>

            <div class="mt-9 border-t border-bnn-line pt-8">
                <h2 class="border-b border-bnn-line pb-4 text-xl font-bold text-bnn-950">Data penjamin, wali, orang tua, atau saudara</h2>
                <div class="mt-6 grid gap-5 md:grid-cols-2">
                    <label class="text-sm font-semibold text-bnn-ink">Nama Penjamin/Wali/Orang Tua/Saudara <span class="text-red-600">*</span>
                        <input class="mt-2 min-h-11 w-full rounded-md border border-slate-300 px-3 py-2.5 text-sm font-normal text-bnn-ink focus:border-bnn-600 focus:outline-none focus:ring-2 focus:ring-bnn-100" type="text" name="guardian_name" value="<?= esc(old('guardian_name')) ?>" maxlength="255" required>
                    </label>
                    <label class="text-sm font-semibold text-bnn-ink">NIK Penjamin/Wali/Orang Tua/Saudara
                        <input class="mt-2 min-h-11 w-full rounded-md border border-slate-300 px-3 py-2.5 text-sm font-normal text-bnn-ink focus:border-bnn-600 focus:outline-none focus:ring-2 focus:ring-bnn-100" type="text" name="guardian_nik" value="<?= esc(old('guardian_nik')) ?>" maxlength="50">
                    </label>
                    <label class="text-sm font-semibold text-bnn-ink">No. HP Penjamin/Wali/Orang Tua/Saudara
                        <input class="mt-2 min-h-11 w-full rounded-md border border-slate-300 px-3 py-2.5 text-sm font-normal text-bnn-ink focus:border-bnn-600 focus:outline-none focus:ring-2 focus:ring-bnn-100" type="tel" name="guardian_phone" value="<?= esc(old('guardian_phone')) ?>" maxlength="20" autocomplete="tel">
                    </label>
                    <label class="text-sm font-semibold text-bnn-ink">Keperluan <span class="text-red-600">*</span>
                        <input class="mt-2 min-h-11 w-full rounded-md border border-slate-300 px-3 py-2.5 text-sm font-normal text-bnn-ink focus:border-bnn-600 focus:outline-none focus:ring-2 focus:ring-bnn-100" type="text" name="purpose" value="<?= esc(old('purpose')) ?>" maxlength="255" required>
                    </label>
                    <label class="text-sm font-semibold text-bnn-ink md:col-span-2">Alamat Penjamin/Wali/Orang Tua/Saudara <span class="text-red-600">*</span>
                        <textarea class="mt-2 w-full rounded-md border border-slate-300 px-3 py-2.5 text-sm font-normal text-bnn-ink focus:border-bnn-600 focus:outline-none focus:ring-2 focus:ring-bnn-100" name="guardian_address" rows="3" required><?= esc(old('guardian_address')) ?></textarea>
                    </label>
                </div>
            </div>

            <div class="mt-8 flex flex-col gap-4 border-t border-bnn-line pt-6 sm:flex-row sm:items-center sm:justify-between">
                <p class="m-0 text-sm text-bnn-muted"><span class="text-red-600">*</span> Wajib diisi</p>
                <button class="inline-flex min-h-11 items-center justify-center rounded-md bg-bnn-800 px-5 py-3 text-sm font-bold text-white transition hover:bg-bnn-950 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-bnn-800" type="submit">
                    Kirim Pendaftaran <span aria-hidden="true" class="ml-2 text-base">&rarr;</span>
                </button>
            </div>
        </form>
    </div>
</section>
