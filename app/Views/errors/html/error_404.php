<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Halaman Tidak Ditemukan - BNN Kota Tanjungpinang</title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/logo-bnn.png') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/tailwind.css') ?>">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen bg-slate-50 text-slate-800 antialiased selection:bg-sky-500 selection:text-white">

    <!-- Konten Utama 404 -->
    <main class="flex-1 flex items-center justify-center p-6 sm:p-12">
        <div class="max-w-lg w-full text-center">
            
            <!-- Logo BNN Header Centered -->
            <div class="flex items-center justify-center gap-3 mb-6">
                <img src="<?= base_url('assets/images/logo-bnn.png') ?>" alt="Logo BNN" class="w-10 h-10 object-contain">
                <div class="text-left leading-tight">
                    <span class="block text-xs font-bold text-slate-900 tracking-wide">Badan Narkotika Nasional</span>
                    <span class="block text-xs font-medium text-slate-500">Kota Tanjungpinang</span>
                </div>
            </div>

            <!-- Gambar 404 -->
            <div class="mb-6 flex justify-center">
                <img src="<?= base_url('assets/images/page_404.png') ?>" alt="404 Halaman Tidak Ditemukan" class="max-w-[280px] sm:max-w-[340px] w-full h-auto object-contain">
            </div>

            <!-- Judul & Deskripsi -->
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mb-3">
                Halaman tidak ditemukan
            </h1>
            <p class="text-slate-600 text-sm sm:text-base leading-relaxed mb-8">
                Maaf, halaman yang Anda tuju tidak dapat ditemukan atau telah dipindahkan. Silakan periksa kembali alamat URL atau kembali ke beranda.
            </p>

            <!-- Tombol Aksi -->
            <div class="flex flex-wrap items-center justify-center gap-3">
                <a href="<?= base_url('/') ?>" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg bg-sky-600 hover:bg-sky-700 text-white font-semibold text-sm shadow-sm transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Kembali ke Beranda</span>
                </a>
                <button onclick="window.history.back()" type="button" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg bg-white hover:bg-slate-100 text-slate-700 font-semibold text-sm border border-slate-300 shadow-sm transition-colors">
                    <span>Halaman Sebelumnya</span>
                </button>
            </div>

        </div>
    </main>

    <!-- Footer Sederhana -->
    <footer class="border-t border-slate-200/80 bg-white py-4 text-center text-xs text-slate-500">
        <div class="container mx-auto px-4">
            &copy; <?= date('Y') ?> BNN Kota Tanjungpinang. Hak Cipta Dilindungi.
        </div>
    </footer>

</body>
</html>
