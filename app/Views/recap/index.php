<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<h1 class="text-3xl font-bold mb-8 text-gray-800">Rekapitulasi Keuangan</h1>

<div class="flex justify-end mb-8">
    <a href="<?= base_url('/recap/download') ?>" class="flex items-center space-x-2 px-6 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700 shadow-lg shadow-red-200 transition-all transform active:scale-[0.98] font-bold">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        <span>Download Laporan PDF</span>
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
    <!-- Total Penjualan -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-blue-100 flex items-center space-x-4 transition-all hover:shadow-md">
        <div class="p-4 bg-blue-50 rounded-xl">
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-semibold uppercase tracking-wider">Total Penjualan</p>
            <p class="text-2xl font-black text-blue-600">Rp <?= number_format($totalSales, 0, ',', '.') ?></p>
        </div>
    </div>

    <!-- Total Pengeluaran -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-red-100 flex items-center space-x-4 transition-all hover:shadow-md">
        <div class="p-4 bg-red-50 rounded-xl">
            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-semibold uppercase tracking-wider">Total Pengeluaran</p>
            <p class="text-2xl font-black text-red-600">Rp <?= number_format($totalExpenses, 0, ',', '.') ?></p>
        </div>
    </div>

    <!-- Laba Bersih -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-green-100 flex items-center space-x-4 transition-all hover:shadow-md">
        <div class="p-4 bg-green-50 rounded-xl">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-semibold uppercase tracking-wider">Laba Bersih</p>
            <p class="text-2xl font-black text-green-600">Rp <?= number_format($netProfit, 0, ',', '.') ?></p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Ringkasan Transaksi Penjualan -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <h2 class="text-xl font-bold mb-6 flex items-center space-x-2 text-gray-800">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>Penjualan Terbaru</span>
        </h2>
        <div class="space-y-4">
            <?php foreach ($groupedTx as $code => $orderItems) : 
                $first = $orderItems[0];
                $totalOrder = array_sum(array_column($orderItems, 'total_price'));
            ?>
                <div class="flex items-center justify-between p-4 hover:bg-gray-50 rounded-xl transition-all border border-gray-50 hover:border-blue-100">
                    <div>
                        <p class="font-bold text-gray-900"><?= esc($first['customer_name']) ?></p>
                        <p class="text-xs text-gray-400 font-medium"><?= date('d M Y, H:i', strtotime($first['transaction_date'])) ?> • <?= count($orderItems) ?> item</p>
                    </div>
                    <div class="text-right">
                        <p class="font-black text-blue-600">Rp <?= number_format($totalOrder, 0, ',', '.') ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($groupedTx)) : ?>
                <p class="text-gray-400 text-center py-8 italic">Belum ada riwayat penjualan.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Ringkasan Pengeluaran -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <h2 class="text-xl font-bold mb-6 flex items-center space-x-2 text-gray-800">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>Pengeluaran Terbaru</span>
        </h2>
        <div class="space-y-4">
            <?php foreach ($expenses as $expense) : ?>
                <div class="flex items-center justify-between p-4 hover:bg-gray-50 rounded-xl transition-all border border-gray-50 hover:border-red-100">
                    <div>
                        <p class="font-bold text-gray-900"><?= esc($expense['description']) ?></p>
                        <p class="text-xs text-gray-400 font-medium"><?= date('d M Y, H:i', strtotime($expense['expense_date'])) ?></p>
                    </div>
                    <div class="text-right">
                        <p class="font-black text-red-600">Rp <?= number_format($expense['amount'], 0, ',', '.') ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($expenses)) : ?>
                <p class="text-gray-400 text-center py-8 italic">Belum ada riwayat pengeluaran.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
