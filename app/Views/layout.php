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
    </style>
</head>
<body class="bg-gray-50 text-gray-900">
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r h-screen fixed left-0 top-0 overflow-y-auto">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-blue-600">e-Beli</h1>
            </div>
            <nav class="mt-6 px-4 space-y-2">
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

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-8 min-h-screen">
            <div class="max-w-6xl mx-auto">
                <!-- Alerts -->
                <?php if (session()->getFlashdata('success')) : ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 flex justify-between items-center">
                        <span><?= session()->getFlashdata('success') ?></span>
                        <button onclick="this.parentElement.remove()" class="text-green-900 font-bold">&times;</button>
                    </div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex justify-between items-center">
                        <span><?= session()->getFlashdata('error') ?></span>
                        <button onclick="this.parentElement.remove()" class="text-red-900 font-bold">&times;</button>
                    </div>
                <?php endif; ?>

                <?= $this->renderSection('content') ?>
            </div>
        </main>
    </div>
</body>
</html>
