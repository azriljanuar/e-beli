<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'e-Beli' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        @media (max-width: 1024px) {
            .sidebar-closed { transform: translateX(-100%); }
            .main-expanded { margin-left: 0 !important; }
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">
    <!-- Mobile Header -->
    <header class="lg:hidden bg-white border-b px-4 py-3 flex items-center justify-between sticky top-0 z-50">
        <h1 class="text-xl font-bold text-blue-600">e-Beli</h1>
        <button id="menu-toggle" class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
    </header>

    <div class="flex">
        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-white border-r h-screen fixed left-0 top-0 overflow-y-auto z-40 transition-transform duration-300 lg:translate-x-0 sidebar-closed">
            <div class="p-6 flex items-center justify-between">
                <h1 class="text-2xl font-bold text-blue-600">e-Beli</h1>
                <button id="menu-close" class="lg:hidden p-2 text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <nav class="mt-2 px-4 space-y-2">
                <a href="<?= base_url('/') ?>" class="flex items-center space-x-3 p-3 rounded-lg transition-colors <?= current_url() == base_url('/') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-100' ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span class="font-medium">Beranda</span>
                </a>
                <a href="<?= base_url('/master') ?>" class="flex items-center space-x-3 p-3 rounded-lg transition-colors <?= strpos(current_url(), '/master') !== false ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-100' ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    <span class="font-medium">Data Master Daging</span>
                </a>
                <a href="<?= base_url('/transaction') ?>" class="flex items-center space-x-3 p-3 rounded-lg transition-colors <?= strpos(current_url(), '/transaction') !== false ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-100' ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span class="font-medium">Transaksi Jual</span>
                </a>
                <a href="<?= base_url('/expenses') ?>" class="flex items-center space-x-3 p-3 rounded-lg transition-colors <?= strpos(current_url(), '/expenses') !== false ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-100' ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-medium">Pengeluaran</span>
                </a>
                <a href="<?= base_url('/recap') ?>" class="flex items-center space-x-3 p-3 rounded-lg transition-colors <?= strpos(current_url(), '/recap') !== false ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-100' ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 2v-6m-8 9h10a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2z"></path></svg>
                    <span class="font-medium">Rekapitulasi</span>
                </a>
            </nav>
        </aside>

        <!-- Overlay -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden"></div>

        <!-- Main Content -->
        <main class="flex-1 lg:ml-64 p-4 md:p-8 min-h-screen main-expanded">
            <div class="max-w-6xl mx-auto">
                <!-- Alerts -->
                <?php if (session()->getFlashdata('success')) : ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex justify-between items-center text-sm md:text-base">
                        <span><?= session()->getFlashdata('success') ?></span>
                        <button onclick="this.parentElement.remove()" class="text-green-900 font-bold">&times;</button>
                    </div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex justify-between items-center text-sm md:text-base">
                        <span><?= session()->getFlashdata('error') ?></span>
                        <button onclick="this.parentElement.remove()" class="text-red-900 font-bold">&times;</button>
                    </div>
                <?php endif; ?>

                <?= $this->renderSection('content') ?>
            </div>
        </main>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const menuToggle = document.getElementById('menu-toggle');
        const menuClose = document.getElementById('menu-close');

        function toggleMenu() {
            sidebar.classList.toggle('sidebar-closed');
            overlay.classList.toggle('hidden');
            document.body.classList.toggle('overflow-hidden');
        }

        menuToggle.addEventListener('click', toggleMenu);
        menuClose.addEventListener('click', toggleMenu);
        overlay.addEventListener('click', toggleMenu);
    </script>
</body>
</html>
