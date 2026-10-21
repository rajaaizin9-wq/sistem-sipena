<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | BNN Kota Tanjungpinang</title>
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

        /* Desktop Sidebar Collapsed Rules */
        @media (min-width: 1024px) {
            #adminSidebar.sidebar-collapsed {
                width: 5rem !important; /* 80px */
            }
            #adminSidebar.sidebar-collapsed .sidebar-text {
                display: none !important;
            }
            #adminSidebar.sidebar-collapsed .sidebar-nav a {
                justify-content: center;
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }
            #adminSidebar.sidebar-collapsed #collapseIcon {
                transform: rotate(180deg);
            }
            #adminSidebar.sidebar-collapsed .sidebar-header {
                justify-content: center;
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }
            #adminSidebar.sidebar-collapsed .sidebar-footer {
                justify-content: center;
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }
        }
    </style>
</head>

<body class="font-sans antialiased dashboard-page bg-slate-50 text-slate-800 selection:bg-sky-500 selection:text-white">
    <?php $user = $user ?? session()->get('auth_user') ?? []; ?>
    
    <div class="flex h-screen overflow-hidden bg-slate-100">

        <!-- Mobile Backdrop -->
        <div id="sidebarBackdrop" class="fixed inset-0 z-30 hidden bg-slate-900/50 backdrop-blur-sm lg:hidden transition-opacity" onclick="toggleMobileSidebar()"></div>

        <!-- Sidebar -->
        <aside id="adminSidebar" class="fixed inset-y-0 left-0 z-40 flex flex-col flex-shrink-0 w-64 text-white transition-all duration-300 ease-in-out -translate-x-full shadow-2xl bg-gradient-to-b from-slate-950 via-slate-900 to-sky-950 lg:static lg:translate-x-0">
            
            <script>
                if (localStorage.getItem('adminSidebarCollapsed') === 'true' && window.innerWidth >= 1024) {
                    document.getElementById('adminSidebar').classList.add('sidebar-collapsed');
                }
            </script>

            <!-- Sidebar Header / Brand -->
            <div class="flex items-center justify-between h-16 px-4 border-b border-white/10 shrink-0 bg-white/5 backdrop-blur-sm sidebar-header">
                <a class="flex items-center gap-3 overflow-hidden text-white transition-opacity hover:opacity-90" href="<?= base_url('dashboard') ?>" title="SIPENA - BNN Kota Tanjungpinang">
                    <img src="<?= base_url('assets/images/logo-bnn.png') ?>" alt="Logo BNN" class="object-contain w-9 h-9 shrink-0">
                    <div class="flex flex-col sidebar-text truncate">
                        <span class="text-sm font-bold tracking-widest text-transparent uppercase bg-clip-text bg-gradient-to-r from-white to-sky-300">
                            SIPENA
                        </span>
                        <span class="text-[10px] text-sky-300/80 font-medium tracking-wide truncate">BNN Kota Tanjungpinang</span>
                    </div>
                </a>

                <!-- Desktop Collapse Button inside Sidebar Header -->
                <button type="button" onclick="toggleDesktopSidebar()" class="hidden lg:flex items-center justify-center p-1.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/10 transition-colors" title="Ciutkan / Lebarkan Sidebar">
                    <svg id="collapseIcon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform duration-300">
                        <rect width="18" height="18" x="3" y="3" rx="2"/>
                        <path d="M9 3v18"/>
                        <path d="m14 9-3 3 3 3"/>
                    </svg>
                </button>

                <!-- Mobile Close Button -->
                <button type="button" onclick="toggleMobileSidebar()" class="flex items-center justify-center p-1.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/10 transition-colors lg:hidden" title="Tutup Sidebar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18"/>
                        <path d="m6 6 12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <div class="flex-1 px-3 py-6 space-y-1 overflow-y-auto custom-scrollbar">
                <?php
                $role = $user['role'] ?? 'humas';
                if ($role === 'humas_rehabilitasi') {
                    echo view('dashboard/partials/sidebar_humas_rehabilitasi');
                } elseif ($role === 'humas_umum') {
                    echo view('dashboard/partials/sidebar_humas_umum');
                } else {
                    echo view('dashboard/partials/sidebar_humas');
                }
                ?>
            </div>

            <!-- Sidebar Footer (User Info) -->
            <div class="p-3 border-t border-white/10 shrink-0 bg-black/20 backdrop-blur-md sidebar-footer">
                <a href="<?= base_url('dashboard/profile') ?>" class="flex items-center gap-3 p-2 transition-colors rounded-xl cursor-pointer hover:bg-white/10 group" title="Profil Akun (<?= esc($user['name'] ?? 'Admin') ?>)">
                    <div class="flex items-center justify-center text-sm font-bold uppercase border rounded-xl shadow-inner w-9 h-9 bg-gradient-to-br from-sky-600 to-sky-800 shrink-0 border-white/20 text-white">
                        <?= substr($user['name'] ?? 'A', 0, 1) ?>
                    </div>
                    <div class="overflow-hidden sidebar-text">
                        <p class="text-sm font-semibold text-white truncate group-hover:text-sky-300 transition-colors" title="<?= esc($user['name'] ?? 'Admin') ?>"><?= esc($user['name'] ?? 'Admin') ?></p>
                        <p class="text-[10px] text-sky-300/80 truncate uppercase tracking-wider font-medium"><?= esc(str_replace('_', ' ', $user['role'] ?? 'user')) ?></p>
                    </div>
                </a>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="relative flex flex-col flex-1 min-w-0 overflow-hidden bg-slate-50">

            <!-- Header -->
            <header class="sticky top-0 z-10 flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8 border-b shadow-sm bg-white/80 backdrop-blur-md border-slate-200/60 shrink-0">
                <div class="flex items-center gap-3">
                    <!-- Mobile Hamburger Button -->
                    <button type="button" onclick="toggleMobileSidebar()" class="p-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors lg:hidden" aria-label="Buka Menu">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="4" x2="20" y1="12" y2="12"/>
                            <line x1="4" x2="20" y1="6" y2="6"/>
                            <line x1="4" x2="20" y1="18" y2="18"/>
                        </svg>
                    </button>

                    <!-- Desktop Hamburger / Toggle Button -->
                    <button type="button" onclick="toggleDesktopSidebar()" class="hidden lg:flex items-center gap-2 px-3 py-1.5 rounded-lg text-slate-600 hover:text-sky-700 hover:bg-sky-50/80 transition-colors border border-slate-200 text-xs font-semibold" title="Ciutkan / Lebarkan Sidebar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="4" x2="20" y1="12" y2="12"/>
                            <line x1="4" x2="20" y1="6" y2="6"/>
                            <line x1="4" x2="20" y1="18" y2="18"/>
                        </svg>
                        <span>Toggle Sidebar</span>
                    </button>
                </div>

                <div class="flex items-center gap-4 sm:gap-5">
                    <span class="inline-flex items-center justify-center px-3 py-1 text-xs font-semibold capitalize rounded-full shadow-sm bg-sky-50 text-sky-700 ring-1 ring-inset ring-sky-600/20">
                        <?= esc(str_replace('_', ' ', $user['role'] ?? 'user')) ?>
                    </span>

                    <div class="w-px h-6 bg-slate-200"></div>

                    <form method="post" action="<?= base_url('logout') ?>" class="m-0">
                        <?= csrf_field() ?>
                        <button type="submit" class="group flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-red-600 transition-all duration-200 px-3 py-1.5 rounded-md hover:bg-red-50">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform group-hover:-translate-x-1">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                            <span class="hidden font-semibold sm:inline">Keluar</span>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="relative flex-1 p-4 sm:p-6 lg:p-8 overflow-y-auto custom-scrollbar">
                <div class="absolute inset-0 bg-grid-slate-100 [mask-image:linear-gradient(0deg,white,rgba(255,255,255,0.6))] -z-10 pointer-events-none"></div>
                <div class="w-full mx-auto max-w-7xl">
                    <?= $content ?? '' ?>
                </div>
            </main>
        </div>
    </div>

    <script>
        (function () {
            const sidebar = document.getElementById('adminSidebar');
            const backdrop = document.getElementById('sidebarBackdrop');

            window.toggleDesktopSidebar = function () {
                if (!sidebar) return;
                sidebar.classList.toggle('sidebar-collapsed');
                const isCollapsed = sidebar.classList.contains('sidebar-collapsed');
                localStorage.setItem('adminSidebarCollapsed', isCollapsed ? 'true' : 'false');
            };

            window.toggleMobileSidebar = function () {
                if (!sidebar || !backdrop) return;
                const isHidden = sidebar.classList.contains('-translate-x-full');
                if (isHidden) {
                    sidebar.classList.remove('-translate-x-full');
                    backdrop.classList.remove('hidden');
                } else {
                    sidebar.classList.add('-translate-x-full');
                    backdrop.classList.add('hidden');
                }
            };
        })();

        // Global SweetAlert2 Toast & Confirm Helpers
        let swalToastInstance = null;
        function getSwalToast() {
            if (!swalToastInstance && typeof Swal !== 'undefined') {
                swalToastInstance = Swal.mixin({
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
            return swalToastInstance;
        }

        window.showToast = function (icon, title) {
            const toast = getSwalToast();
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