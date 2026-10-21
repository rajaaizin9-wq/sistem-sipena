<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Website resmi BNN Kota Tanjungpinang untuk informasi, edukasi P4GN, dan akses layanan masyarakat.">
    <title><?= esc($title ?? 'BNN Kota Tanjungpinang') ?></title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/logo-bnn.png') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/tailwind.css') ?>">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Compact SweetAlert2 Toast & Popup Styling */
        .swal2-toast {
            padding: 0.45rem 0.75rem !important;
            font-size: 0.8125rem !important;
            border-radius: 0.6rem !important;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.12) !important;
            max-width: 320px !important;
            align-items: center !important;
        }
        .swal2-toast .swal2-title {
            font-size: 0.8125rem !important;
            font-weight: 600 !important;
            color: #1e293b !important;
            margin: 0 0.5rem !important;
        }
        .swal2-toast .swal2-icon {
            width: 1.25rem !important;
            height: 1.25rem !important;
            margin: 0 !important;
        }
        .swal2-toast .swal2-icon .swal2-icon-content {
            font-size: 0.875rem !important;
        }
        .swal2-toast .swal2-close {
            font-size: 1rem !important;
            width: 1.25rem !important;
            height: 1.25rem !important;
        }

        /* Compact Confirm Modal */
        .swal2-popup:not(.swal2-toast) {
            padding: 1.15rem 1.25rem !important;
            width: 21rem !important;
            border-radius: 0.85rem !important;
            font-size: 0.875rem !important;
        }
        .swal2-popup:not(.swal2-toast) .swal2-title {
            font-size: 1rem !important;
            font-weight: 700 !important;
            padding: 0.2rem 0 0 0 !important;
        }
        .swal2-popup:not(.swal2-toast) .swal2-html-container {
            font-size: 0.8125rem !important;
            margin: 0.4rem 0 0.85rem 0 !important;
            color: #475569 !important;
        }
        .swal2-popup:not(.swal2-toast) .swal2-icon {
            width: 2.75rem !important;
            height: 2.75rem !important;
            margin: 0.4rem auto 0.2rem auto !important;
        }
        .swal2-popup:not(.swal2-toast) .swal2-actions {
            margin-top: 0.65rem !important;
            gap: 0.4rem !important;
        }
        .swal2-popup:not(.swal2-toast) .swal2-styled {
            padding: 0.38rem 0.8rem !important;
            font-size: 0.8125rem !important;
            border-radius: 0.5rem !important;
        }

        /* SweetAlert2 Toast Slide Animation (From Right to Left) */
        .swal2-toast.swal2-show {
            animation: swal2-toast-slide-in 0.35s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }
        .swal2-toast.swal2-hide {
            animation: swal2-toast-slide-out 0.25s cubic-bezier(0.7, 0, 0.84, 0) forwards !important;
        }
        @keyframes swal2-toast-slide-in {
            0% { transform: translateX(120%); opacity: 0; }
            100% { transform: translateX(0); opacity: 1; }
        }
        @keyframes swal2-toast-slide-out {
            0% { transform: translateX(0); opacity: 1; }
            100% { transform: translateX(120%); opacity: 0; }
        }

        .public-nav-toggle {
            display: none;
        }

        .public-nav-menu {
            display: flex;
        }

        @media (max-width: 767px) {
            .public-nav-wrap {
                position: relative;
            }

            .public-nav-toggle {
                display: inline-flex;
            }

            .public-nav-menu {
                position: absolute;
                top: 100%;
                left: 50%;
                width: 100vw;
                margin-left: -50vw;
                flex-direction: column;
                align-items: stretch;
                gap: 6px;
                padding: 12px 20px 16px 20px;
                background: rgba(255, 255, 255, .98);
                border-top: 1px solid var(--bnn-line, #dbe3e8);
                box-shadow: 0 10px 16px rgba(15, 23, 42, .08);
                transition: opacity 160ms ease, transform 160ms ease, visibility 160ms ease;
            }

            .public-nav-menu.hidden {
                display: flex;
                pointer-events: none;
                visibility: hidden;
                opacity: 0;
                transform: translateY(-8px);
            }
        }
    </style>
</head>

<body>
    <a class="skip-link" href="#main-content">Lewati ke konten utama</a>
    <header class="sticky top-0 z-50 border-b border-bnn-line bg-white/95 backdrop-blur-md">
        <div class="public-nav-wrap container flex min-h-[74px] items-center justify-between gap-[18px]">
            <a class="inline-flex items-center gap-2.5 font-bold tracking-[.01em] text-bnn-ink" href="<?= base_url('/') ?>" aria-label="BNN Kota Tanjungpinang, beranda">
                <img
                    src="<?= base_url('assets/images/logo-bnn.png') ?>"
                    alt="Logo BNN Kota Tanjungpinang"
                    class="object-contain w-10 h-10">
                <div class="flex flex-col leading-tight">
                    <span>Badan Narkotika Nasional</span>
                    <span class="text-sm font-medium">
                        Kota Tanjungpinang
                    </span>
                </div>
            </a>
            <button id="site-nav-toggle" type="button" class="items-center justify-center transition border rounded-md public-nav-toggle h-11 w-11 border-bnn-line text-bnn-800 hover:bg-bnn-100 focus:outline-none focus:ring-2 focus:ring-bnn-600" aria-expanded="false" aria-controls="site-navigation">
                <span class="sr-only">Buka menu navigasi</span>
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round" />
                </svg>
            </button>
            <?php
            $currentPath = trim((string) uri_string(), '/');
            $navItems = [
                ['label' => 'Beranda', 'url' => base_url('/'), 'active' => $currentPath === ''],
                ['label' => 'Artikel', 'url' => base_url('artikel'), 'active' => str_starts_with($currentPath, 'artikel')],
                ['label' => 'Kuis', 'url' => base_url('quiz'), 'active' => str_starts_with($currentPath, 'quiz')],
                ['label' => 'Bacaan', 'url' => base_url('bacaan'), 'active' => str_starts_with($currentPath, 'bacaan')],
                ['label' => 'Layanan', 'url' => base_url('layanan'), 'active' => str_starts_with($currentPath, 'layanan')],
            ];
            ?>
            <nav id="site-navigation" class="items-center hidden gap-3 public-nav-menu sm:gap-4" aria-label="Navigasi utama">
                <?php foreach ($navItems as $item): ?>
                    <a class="inline-flex min-h-11 items-center text-[.93rem] font-semibold transition-colors duration-150 <?= !empty($item['active']) ? 'text-sky-600' : 'text-slate-600 hover:text-sky-600' ?>"
                       href="<?= $item['url'] ?>">
                        <?= esc($item['label']) ?>
                    </a>
                <?php endforeach; ?>

                <a href="https://wa.me/6281275405434"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="inline-flex items-center justify-center px-3.5 py-1.5 text-[.93rem] font-semibold text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 hover:text-sky-600 hover:border-sky-500 transition-colors shrink-0 w-auto self-start sm:self-center my-1 sm:my-0 sm:ml-1">
                    Hubungi Kami
                </a>
            </nav>
        </div>
    </header>

    <main id="main-content">
        <?= $content ?? '' ?>
    </main>

    <footer id="kontak" class="text-white bg-bnn-950">
        <div class="container py-12 sm:py-14 lg:py-16">

            <!-- Main Footer -->
            <div class="grid gap-10 lg:grid-cols-[1.4fr_1fr] lg:gap-20">

                <!-- Brand -->
                <div class="max-w-xl">

                    <!-- Brand Marks -->
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:gap-6">

                        <!-- BNN Logo -->
                        <div class="flex items-center gap-3 shrink-0">
                            <div class="flex items-center justify-center shrink-0 w-11 h-11">
                                <img
                                    src="<?= base_url('assets/images/logo-bnn.png') ?>"
                                    alt="Logo BNN Kota Tanjungpinang"
                                    class="object-contain w-full h-full">
                            </div>

                            <div>
                                <p class="text-sm font-semibold text-white">
                                    Badan Narkotika Nasional
                                </p>

                                <p class="mt-0.5 text-xs text-blue-200">
                                    Kota Tanjungpinang
                                </p>
                            </div>
                        </div>

                        <!-- Vertical Divider (Desktop) -->
                        <div class="hidden w-px h-10 sm:block bg-white/20 shrink-0"></div>

                        <!-- Horizontal Divider (Mobile) -->
                        <div class="block w-full h-px sm:hidden bg-white/10"></div>

                        <!-- SIPENA Logo -->
                        <div class="flex items-center gap-3">
                            <div class="flex items-center shrink-0">
                                <img
                                    src="<?= base_url('assets/images/siperna.png') ?>"
                                    alt="Logo SIPENA - Sistem Pencegahan dan Edukasi Narkotika"
                                    class="object-contain w-auto h-10 sm:h-11">
                            </div>

                            <div>
                                <p class="text-xs font-semibold text-blue-200">
                                    Sistem Pencegahan, Rehabilitasi dan Edukasi Narkotika
                                </p>
                            </div>
                        </div>

                    </div>

                    <p class="max-w-lg mt-5 text-sm leading-6 text-blue-100/80">
                        Bersama mewujudkan Indonesia bersih dari penyalahgunaan
                        dan peredaran gelap narkotika melalui pencegahan,
                        pemberantasan, dan rehabilitasi.
                    </p>

                </div>


                <!-- Contact -->
                <div>

                    <h2 class="text-sm font-semibold text-white">
                        Kontak
                    </h2>

                    <div class="mt-4 space-y-4">

                        <!-- Address -->
                        <div class="flex gap-3">

                            <svg
                                class="flex-shrink-0 w-5 h-5 mt-0.5 text-blue-200"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                aria-hidden="true">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />

                            </svg>

                            <p class="text-sm leading-6 text-blue-100/80">
                                Jl. Daeng Kamboja, Senggarang, Kec. Tj. Pinang Kota,
                                Kota Tanjung Pinang, Kepulauan Riau
                            </p>

                        </div>


                        <!-- Phone -->
                        <a
                            href="tel:+6281275405434"
                            class="flex items-center gap-3 text-sm transition-colors text-blue-100/80 hover:text-white">

                            <svg
                                class="flex-shrink-0 w-5 h-5 text-blue-200"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                aria-hidden="true">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />

                            </svg>

                            <span>
                                +62 812-7540-5434
                            </span>

                        </a>

                        <!-- Email -->
                        <a
                            href="mailto:bnnkota_tanjungpinang@bnn.go.id"
                            class="flex items-center gap-3 text-sm transition-colors text-blue-100/80 hover:text-white">

                            <svg
                                class="flex-shrink-0 w-5 h-5 text-blue-200"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                aria-hidden="true">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="M3 6.75A2.75 2.75 0 015.75 4h12.5A2.75 2.75 0 0121 6.75v10.5A2.75 2.75 0 0118.25 20H5.75A2.75 2.75 0 013 17.25V6.75Z" />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="m4 6 8 6 8-6" />

                            </svg>

                            <span>bnnkota_tanjungpinang@bnn.go.id</span>

                        </a>

                    </div>

                </div>

            </div>


            <!-- Divider -->
            <div class="h-px mt-10 bg-white/10"></div>


            <!-- Bottom -->
            <div class="flex flex-col gap-2 pt-5 text-xs text-blue-200/60 sm:flex-row sm:items-center sm:justify-between">

                <p>
                    &copy; <?= date('Y') ?> BNN Kota Tanjungpinang.
                    Hak cipta dilindungi.
                </p>

                <div class="flex flex-wrap items-center gap-3">
                    <p>
                        Dikelola oleh Humas BNN Kota Tanjungpinang
                    </p>
                    <span class="text-white/20">•</span>
                    <a href="<?= base_url('login') ?>" class="inline-flex items-center gap-1 transition-colors text-blue-200/60 hover:text-white" title="Portal Petugas / Login Admin">
                        <svg class="w-3.5 h-3.5 text-blue-300/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <span>Portal Petugas</span>
                    </a>
                </div>

            </div>

        </div>
    </footer>
    <script>
        (() => {
            const toggle = document.getElementById('site-nav-toggle');
            const navigation = document.getElementById('site-navigation');

            if (!toggle || !navigation) return;

            const setMenuOpen = (isOpen) => {
                navigation.classList.toggle('hidden', !isOpen);
                toggle.setAttribute('aria-expanded', String(isOpen));
                toggle.querySelector('.sr-only').textContent = isOpen ? 'Tutup menu navigasi' : 'Buka menu navigasi';
            };

            toggle.addEventListener('click', () => {
                setMenuOpen(toggle.getAttribute('aria-expanded') !== 'true');
            });

            navigation.querySelectorAll('a').forEach((link) => {
                link.addEventListener('click', () => setMenuOpen(false));
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && toggle.getAttribute('aria-expanded') === 'true') {
                    setMenuOpen(false);
                    toggle.focus();
                }
            });
        })();

        // Global SweetAlert2 Toast & Confirm Helpers
        let publicSwalToast = null;
        function getPublicSwalToast() {
            if (!publicSwalToast && typeof Swal !== 'undefined') {
                publicSwalToast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3500,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
            }
            return publicSwalToast;
        }

        window.showToast = function (icon, title) {
            const toast = getPublicSwalToast();
            if (toast) {
                toast.fire({ icon: icon, title: title });
            } else if (typeof Swal !== 'undefined') {
                Swal.fire({ icon: icon, title: title, toast: true, position: 'top-end', timer: 3500, timerProgressBar: true });
            }
        };

        window.confirmDelete = function (element, message = 'Apakah Anda yakin ingin menghapus data ini?') {
            if (typeof event !== 'undefined' && event && event.preventDefault) {
                event.preventDefault();
            }
            const targetForm = element instanceof HTMLFormElement ? element : (element.closest ? element.closest('form') : null);

            if (typeof Swal === 'undefined') {
                if (confirm(message)) {
                    if (targetForm && targetForm.submit) targetForm.submit();
                    else if (typeof element === 'string') window.location.href = element;
                }
                return false;
            }

            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-xl',
                    confirmButton: 'rounded-lg px-4 py-2 text-sm font-semibold',
                    cancelButton: 'rounded-lg px-4 py-2 text-sm font-semibold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    if (targetForm && targetForm.submit) {
                        targetForm.submit();
                    } else if (typeof element === 'string') {
                        window.location.href = element;
                    }
                }
            });
            return false;
        };
    </script>
</body>

</html>