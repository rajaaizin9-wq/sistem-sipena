<div class="mb-8 flex flex-col md:flex-row md:items-start justify-between gap-6">
    <div class="flex-1">
        <p class="text-xs font-bold uppercase tracking-widest text-sky-600 mb-1">Profil Akun</p>
        <h1 class="text-2xl font-black text-slate-800 tracking-tight">Kelola informasi akun dan keamanan akses</h1>
        <p class="text-slate-500 mt-1 text-sm">Perbarui detail profil Anda dengan mudah dan tetap aman.</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 w-full md:w-72 shrink-0">
        <p class="text-xs font-bold uppercase tracking-widest text-slate-500 mb-4">Akun Saat Ini</p>
        <div class="flex items-center gap-3 mb-4">
            <div class="w-12 h-12 rounded-full bg-sky-100 flex items-center justify-center text-sky-700 font-bold text-lg">
                <?= esc(strtoupper(substr($user['name'] ?? 'U', 0, 1))) ?>
            </div>
            <div>
                <p class="text-sm font-bold text-slate-900"><?= esc($user['name'] ?? '-') ?></p>
                <p class="text-xs font-medium text-sky-600 bg-sky-50 px-2 py-0.5 rounded-md inline-block mt-1"><?= esc(str_replace('_', ' ', $user['role'] ?? 'User')) ?></p>
            </div>
        </div>
        <div class="space-y-2 text-sm">
            <div class="flex justify-between border-t border-slate-100 pt-2 break-all">
                <span class="text-slate-500 mr-2 shrink-0">Email</span>
                <strong class="text-slate-900 text-right"><?= esc($user['email'] ?? '-') ?></strong>
            </div>
            <div class="flex justify-between border-t border-slate-100 pt-2 break-all">
                <span class="text-slate-500 mr-2 shrink-0">Username</span>
                <strong class="text-slate-900 text-right"><?= esc($user['username'] ?? '-') ?></strong>
            </div>
        </div>
    </div>
</div>

<?= view('dashboard/partials/flash_messages') ?>

<form method="post" action="<?= base_url('dashboard/profile/update') ?>" class="mt-6">
    <?= csrf_field() ?>

    <div class="flex flex-col lg:flex-row gap-6">
        <section class="flex-1 bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="border-b border-slate-200 bg-slate-50/50 px-6 py-5">
                <h2 class="text-base font-semibold text-slate-800">Informasi dasar</h2>
                <p class="text-sm text-slate-500 mt-0.5">Perbarui identitas dan informasi kontak Anda.</p>
            </div>
            
            <div class="p-6 space-y-5">
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">Nama lengkap</label>
                    <input id="name" name="name" type="text" value="<?= esc($user['name'] ?? '') ?>" required class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm bg-slate-50 focus:bg-white transition-colors">
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Email</label>
                    <input id="email" name="email" type="email" value="<?= esc($user['email'] ?? '') ?>" class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm bg-slate-50 focus:bg-white transition-colors">
                </div>

                <div>
                    <label for="username" class="block text-sm font-semibold text-slate-700 mb-1.5">Username</label>
                    <input id="username" name="username" type="text" value="<?= esc($user['username'] ?? '') ?>" disabled class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-500 shadow-sm ring-1 ring-inset ring-slate-200 bg-slate-100 sm:text-sm cursor-not-allowed">
                    <p class="text-xs text-slate-500 mt-1.5 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Username tidak dapat diubah.
                    </p>
                </div>
            </div>
        </section>

        <section class="w-full lg:w-96 shrink-0 bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden h-fit">
            <div class="border-b border-slate-200 bg-slate-50/50 px-6 py-5">
                <h2 class="text-base font-semibold text-slate-800">Keamanan</h2>
                <p class="text-sm text-slate-500 mt-0.5">Kosongkan jika tidak ingin mengganti password.</p>
            </div>
            
            <div class="p-6 space-y-5">
                <div>
                    <label for="current_password" class="block text-sm font-semibold text-slate-700 mb-1.5">Password saat ini</label>
                    <input id="current_password" name="current_password" type="password" class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm bg-slate-50 focus:bg-white transition-colors">
                </div>

                <div class="pt-2">
                    <label for="new_password" class="block text-sm font-semibold text-slate-700 mb-1.5">Password baru</label>
                    <input id="new_password" name="new_password" type="password" class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm bg-slate-50 focus:bg-white transition-colors">
                </div>

                <div>
                    <label for="confirm_password" class="block text-sm font-semibold text-slate-700 mb-1.5">Konfirmasi password baru</label>
                    <input id="confirm_password" name="confirm_password" type="password" class="block w-full rounded-lg border-0 py-2.5 px-3.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm bg-slate-50 focus:bg-white transition-colors">
                </div>
            </div>
        </section>
    </div>

    <div class="mt-8 flex justify-end">
        <button class="inline-flex items-center justify-center gap-2 rounded-lg bg-sky-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition-all hover:bg-sky-700 focus:ring-2 focus:ring-sky-600 focus:ring-offset-2 w-full sm:w-auto" type="submit">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            Simpan perubahan
        </button>
    </div>
</form>
