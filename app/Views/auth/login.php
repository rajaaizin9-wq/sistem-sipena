<!doctype html>
<html lang="id" class="h-full bg-slate-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | BNN Kota Tanjungpinang</title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/logo-bnn.png') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/tailwind.css') ?>">
    <style>
        /* Hide native browser password reveal icon in Edge/IE/Chrome */
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none !important;
        }
    </style>
</head>

<body class="h-full font-sans antialiased text-slate-800 bg-slate-50 selection:bg-sky-500 selection:text-white flex flex-col justify-between min-h-screen">

    <!-- Header Navigation -->
    <header class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-2">
        <div class="flex items-center justify-between">
            <a href="<?= base_url('/') ?>" class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-sky-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m12 19-7-7 7-7"/>
                    <path d="M19 12H5"/>
                </svg>
                <span>Kembali ke Website Utama</span>
            </a>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold rounded-full bg-sky-50 text-sky-700 border border-sky-200/60">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
                <span>Portal Resmi Admin</span>
            </div>
        </div>
    </header>

    <!-- Main Content Shell -->
    <main class="flex-1 flex items-center justify-center p-4 sm:p-6 lg:p-8">
        <div class="w-full max-w-4xl bg-white rounded-2xl shadow-xl shadow-slate-200/60 border border-slate-200/80 overflow-hidden grid grid-cols-1 md:grid-cols-12 min-h-[520px]">
            
            <!-- Left Panel: Branding & Information Showcase -->
            <div class="md:col-span-5 bg-gradient-to-br from-sky-900 via-sky-950 to-slate-900 text-white p-8 sm:p-10 flex flex-col justify-between relative overflow-hidden">
                <!-- Ambient decorative elements -->
                <div class="absolute -right-16 -top-16 w-64 h-64 rounded-full bg-sky-500/10 blur-2xl pointer-events-none"></div>
                <div class="absolute -left-16 -bottom-16 w-64 h-64 rounded-full bg-sky-400/10 blur-2xl pointer-events-none"></div>

                <div class="relative z-10 space-y-6">
                    <div class="flex items-center gap-3">
                        <img src="<?= base_url('assets/images/logo-bnn.png') ?>" alt="Logo BNN" class="w-12 h-12 object-contain drop-shadow">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-sky-400">BNN RI</p>
                            <p class="text-sm font-semibold text-slate-100">Kota Tanjungpinang</p>
                        </div>
                    </div>

                    <div class="pt-4 space-y-3">
                        <h2 class="text-2xl font-bold text-white tracking-tight leading-tight">
                            Panel Operasional & Manajemen Informasi
                        </h2>
                        <p class="text-sm text-sky-100/80 leading-relaxed">
                            Sistem terintegrasi untuk pengelolaan konten edukasi publik, layanan rehabilitasi, dan publikasi HUMAS BNN Kota Tanjungpinang.
                        </p>
                    </div>
                </div>

                <div class="relative z-10 pt-8 border-t border-white/10 space-y-3">
                    <div class="flex items-start gap-2.5 text-xs text-sky-200/90">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 mt-0.5 text-sky-400">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/>
                            <path d="m9 12 2 2 4-4"/>
                        </svg>
                        <span>Akses terbatas hanya untuk personel terotorisasi. Aktivitas tercatat untuk pengawasan keamanan.</span>
                    </div>
                </div>
            </div>

            <!-- Right Panel: Login Form -->
            <div class="md:col-span-7 p-8 sm:p-10 lg:p-12 flex flex-col justify-center bg-white">
                <div class="max-w-md w-full mx-auto space-y-6">
                    
                    <div>
                        <span class="inline-block text-xs font-bold tracking-wider text-sky-600 uppercase mb-1">Otentikasi System</span>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Masuk ke Dashboard</h1>
                        <p class="text-sm text-slate-500 mt-1">Masukkan kredensial akun Anda untuk mengakses sistem</p>
                    </div>

                    <?php if (! empty($error)): ?>
                        <div class="flex items-start gap-3 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 mt-0.5 text-red-600">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="12" x2="12" y1="8" y2="12"/>
                                <line x1="12" x2="12.01" y1="16" y2="16"/>
                            </svg>
                            <div class="font-medium"><?= esc($error) ?></div>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?= base_url('login') ?>" class="space-y-5" novalidate>
                        <?= csrf_field() ?>
                        
                        <!-- Username Field -->
                        <div>
                            <label for="username" class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Username
                            </label>
                            <div class="relative rounded-lg shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                                        <circle cx="12" cy="7" r="4"/>
                                    </svg>
                                </div>
                                <input 
                                    id="username" 
                                    name="username" 
                                    type="text" 
                                    value="<?= esc(old('username')) ?>" 
                                    autocomplete="username" 
                                    required 
                                    autofocus
                                    placeholder="Masukkan username Anda"
                                    class="block w-full pl-10 pr-4 py-2.5 text-sm text-slate-900 bg-white border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-colors placeholder:text-slate-400"
                                >
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label for="password" class="block text-sm font-semibold text-slate-700">
                                    Password
                                </label>
                            </div>
                            <div class="relative rounded-lg shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                    </svg>
                                </div>
                                <input 
                                    id="password" 
                                    name="password" 
                                    type="password" 
                                    autocomplete="current-password" 
                                    required
                                    placeholder="••••••••"
                                    class="block w-full pl-10 pr-10 py-2.5 text-sm text-slate-900 bg-white border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition-colors placeholder:text-slate-400"
                                >
                                <button 
                                    type="button" 
                                    id="togglePassword" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none transition-colors"
                                    title="Tampilkan password"
                                    aria-label="Tampilkan password"
                                >
                                    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    <svg id="eyeOffIcon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="hidden">
                                        <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/>
                                        <path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/>
                                        <path d="M6.61 6.61A13.52 13.52 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/>
                                        <line x1="2" x2="22" y1="2" y2="22"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button 
                            type="submit" 
                            class="w-full py-2.5 px-4 bg-sky-600 hover:bg-sky-700 active:bg-sky-800 text-white font-semibold rounded-lg shadow-sm shadow-sky-600/30 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 transition-colors flex items-center justify-center gap-2 group cursor-pointer"
                        >
                            <span>Masuk ke Dashboard</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform group-hover:translate-x-0.5">
                                <path d="M5 12h14"/>
                                <path d="m12 5 7 7-7 7"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 text-center text-xs text-slate-500">
        <p>&copy; <?= date('Y') ?> BNN Kota Tanjungpinang. Hak Cipta Dilindungi.</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const togglePasswordBtn = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            const eyeOffIcon = document.getElementById('eyeOffIcon');

            if (togglePasswordBtn && passwordInput) {
                togglePasswordBtn.addEventListener('click', function () {
                    const isPassword = passwordInput.getAttribute('type') === 'password';
                    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                    eyeIcon.classList.toggle('hidden', isPassword);
                    eyeOffIcon.classList.toggle('hidden', !isPassword);
                });
            }
        });
    </script>
</body>

</html>