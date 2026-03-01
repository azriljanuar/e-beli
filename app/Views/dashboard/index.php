<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<h1 class="text-3xl font-bold mb-8 text-gray-800">Beranda Dashboard</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
    <!-- Total Pendapatan -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-blue-100 flex items-center space-x-4 transition-all hover:shadow-md">
        <div class="p-4 bg-blue-50 rounded-xl">
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-semibold uppercase tracking-wider">Total Pendapatan</p>
            <p class="text-2xl font-black text-gray-900">Rp <?= number_format($totalRevenue, 0, ',', '.') ?></p>
        </div>
    </div>

    <!-- Total Stok Tersisa -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-green-100 flex items-center space-x-4 transition-all hover:shadow-md">
        <div class="p-4 bg-green-50 rounded-xl">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-semibold uppercase tracking-wider">Stok Tersisa</p>
            <p class="text-2xl font-black text-gray-900"><?= number_format($totalStockRemaining, 2) ?> kg</p>
        </div>
    </div>

    <!-- Total Transaksi -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-purple-100 flex items-center space-x-4 transition-all hover:shadow-md">
        <div class="p-4 bg-purple-50 rounded-xl">
            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-semibold uppercase tracking-wider">Total Transaksi</p>
            <p class="text-2xl font-black text-gray-900"><?= $totalTransactions ?></p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Status Stok -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <h2 class="text-xl font-bold mb-6 flex items-center space-x-2 text-gray-800">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            <span>Status Stok Daging</span>
        </h2>
        <div class="space-y-5">
            <?php foreach ($items as $item) : ?>
                <div>
                    <div class="flex justify-between items-center mb-1.5">
                        <span class="text-sm font-bold text-gray-700"><?= esc($item['name']) ?></span>
                        <span class="text-sm font-black text-gray-900"><?= number_format($item['stock'], 2) ?> kg</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-3">
                        <div class="h-3 rounded-full transition-all duration-500 <?= $item['stock'] < 10 ? 'bg-red-500' : 'bg-blue-600' ?>" 
                             style="width: <?= min(100, ($item['stock'] / 100) * 100) ?>%"></div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($items)) : ?>
                <p class="text-gray-400 text-center py-8 italic">Belum ada data item.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Riwayat Transaksi -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <h2 class="text-xl font-bold mb-6 flex items-center space-x-2 text-gray-800">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>Transaksi Terbaru</span>
        </h2>
        <div class="space-y-4">
            <?php foreach ($transactions as $tx) : ?>
                <div class="flex items-center justify-between p-4 hover:bg-gray-50 rounded-xl transition-all border border-gray-50 hover:border-blue-100 group">
                    <div>
                        <p class="font-bold text-gray-900 group-hover:text-blue-600 transition-colors"><?= esc($tx['item_name']) ?></p>
                        <p class="text-xs text-gray-400 font-medium"><?= date('d M Y, H:i', strtotime($tx['transaction_date'])) ?></p>
                    </div>
                    <div class="text-right">
                        <p class="font-black text-blue-600">Rp <?= number_format($tx['total_price'], 0, ',', '.') ?></p>
                        <p class="text-xs text-gray-500 font-bold"><?= number_format($tx['weight'], 2) ?> kg</p>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($transactions)) : ?>
                <p class="text-gray-400 text-center py-8 italic">Belum ada riwayat transaksi.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
