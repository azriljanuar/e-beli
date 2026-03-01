<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<h1 class="text-3xl font-bold mb-8 text-gray-800">Transaksi Baru</h1>

<div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 max-w-4xl">
    <form action="<?= base_url('/transaction/save') ?>" method="post" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Kolom Kiri: Detail Pembeli -->
        <div class="space-y-4">
            <h2 class="text-lg font-semibold text-blue-600 border-b pb-2">Data Pembeli</h2>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pembeli</label>
                <input type="text" name="customer_name" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all" placeholder="Masukkan nama pembeli" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">No. WhatsApp</label>
                <input type="tel" name="customer_whatsapp" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all" placeholder="Contoh: 08123456789" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Admin (Penerima Pesanan)</label>
                <select name="admin_name" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none appearance-none bg-white transition-all" required>
                    <option value="">-- Pilih Admin --</option>
                    <?php foreach ($admins as $admin) : ?>
                        <option value="<?= $admin ?>"><?= $admin ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!-- Kolom Kanan: Detail Pesanan -->
        <div class="space-y-4">
            <h2 class="text-lg font-semibold text-blue-600 border-b pb-2">Detail Pesanan</h2>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Bagian Daging</label>
                <select name="item_id" id="item_id" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none appearance-none bg-white transition-all" required>
                    <option value="">-- Pilih Item --</option>
                    <?php foreach ($items as $item) : ?>
                        <option value="<?= $item['id'] ?>" data-price="<?= $item['price_per_kg'] ?>" data-stock="<?= $item['stock'] ?>">
                            <?= esc($item['name']) ?> (Stok: <?= number_format($item['stock'], 2) ?> kg)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Berat (kg)</label>
                <input type="number" step="0.01" name="weight" id="weight" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all" placeholder="0.00" required min="0.01">
            </div>

            <div id="price-summary" class="hidden bg-blue-50 p-5 rounded-xl border border-blue-100 animate-fade-in">
                <div class="flex justify-between items-center mb-1">
                    <span class="text-sm text-gray-600">Harga per kg:</span>
                    <span class="text-sm text-gray-900 font-bold" id="display-price">Rp 0</span>
                </div>
                <div class="flex justify-between items-center mb-3 pb-3 border-b border-blue-200">
                    <span class="text-sm text-gray-600">Berat:</span>
                    <span class="text-sm text-gray-900 font-bold" id="display-weight">0 kg</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-800 font-bold">Total Bayar:</span>
                    <span class="text-xl text-blue-600 font-extrabold" id="display-total">Rp 0</span>
                </div>
            </div>

            <div id="stock-warning" class="hidden flex items-center space-x-2 text-red-600 bg-red-50 p-3 rounded-xl border border-red-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <span class="text-sm font-medium" id="warning-text">Stok tidak mencukupi!</span>
            </div>

            <button type="submit" id="submit-btn" class="w-full flex items-center justify-center space-x-2 p-4 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all transform active:scale-[0.98] disabled:bg-gray-300 disabled:shadow-none disabled:cursor-not-allowed">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                <span>Simpan Transaksi</span>
            </button>
        </div>
    </form>
</div>

<div class="mt-12">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-gray-800 flex items-center space-x-2">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            <span>Transaksi Terakhir</span>
        </h2>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-sm">Waktu</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-sm">Admin</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-sm">Pembeli</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-sm">Item</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-sm">Berat</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-sm text-right">Total</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-sm text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php foreach ($transactions as $tx) : ?>
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 text-xs text-gray-500"><?= date('d/m/Y H:i', strtotime($tx['transaction_date'])) ?></td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-700"><?= esc($tx['admin_name']) ?></td>
                            <td class="px-6 py-4 text-sm">
                                <div class="font-medium text-gray-800"><?= esc($tx['customer_name']) ?></div>
                                <div class="text-xs text-gray-500"><?= esc($tx['customer_whatsapp']) ?></div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700"><?= esc($tx['item_name']) ?></td>
                            <td class="px-6 py-4 text-sm text-gray-600"><?= number_format($tx['weight'], 2) ?> kg</td>
                            <td class="px-6 py-4 text-right font-bold text-blue-600">Rp <?= number_format($tx['total_price'], 0, ',', '.') ?></td>
                            <td class="px-6 py-4 text-right">
                                <button onclick='downloadReceipt(<?= json_encode($tx) ?>)' class="inline-flex items-center space-x-1 px-3 py-1 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition-colors text-xs font-bold">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    <span>Bukti</span>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($transactions)) : ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400 italic">Belum ada transaksi hari ini.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Receipt Template (Hidden) -->
<div id="receipt-container" class="fixed -left-[9999px] top-0">
    <div id="receipt-template" class="bg-white p-8 w-[400px] border shadow-lg text-gray-800">
        <div class="text-center border-b-2 border-dashed pb-6 mb-6">
            <h1 class="text-3xl font-black text-blue-600 mb-1">e-Beli</h1>
            <p class="text-xs text-gray-500 font-bold uppercase tracking-widest">Bukti Pembelian Daging</p>
        </div>
        
        <div class="space-y-4 mb-8">
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Tanggal:</span>
                <span class="font-bold" id="r-date"></span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Admin:</span>
                <span class="font-bold" id="r-admin"></span>
            </div>
            <div class="border-t pt-4">
                <div class="text-xs text-gray-400 uppercase font-bold mb-2">Data Pembeli</div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Nama:</span>
                    <span class="font-bold text-gray-900" id="r-customer"></span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">WhatsApp:</span>
                    <span class="font-bold text-gray-900" id="r-whatsapp"></span>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 mb-6">
            <div class="text-xs text-gray-400 uppercase font-bold mb-3">Detail Pesanan</div>
            <div class="flex justify-between items-center mb-2">
                <span class="text-sm font-bold text-gray-800" id="r-item"></span>
                <span class="text-sm font-black text-gray-900" id="r-weight"></span>
            </div>
            <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                <span class="text-base font-black text-gray-900">Total Bayar</span>
                <span class="text-xl font-black text-blue-600" id="r-total"></span>
            </div>
        </div>

        <div class="text-center border-t-2 border-dashed pt-6">
            <p class="text-sm font-bold text-gray-800">Terima Kasih Atas Kunjungannya!</p>
            <p class="text-[10px] text-gray-400 mt-1 italic">Simpan bukti ini sebagai tanda terima yang sah.</p>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
const itemIdSelect = document.getElementById('item_id');
const weightInput = document.getElementById('weight');
const priceSummary = document.getElementById('price-summary');
const stockWarning = document.getElementById('stock-warning');
const submitBtn = document.getElementById('submit-btn');

function formatRupiah(number) {
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
}

function downloadReceipt(tx) {
    // Populate template
    document.getElementById('r-date').innerText = new Date(tx.transaction_date).toLocaleString('id-ID');
    document.getElementById('r-admin').innerText = tx.admin_name;
    document.getElementById('r-customer').innerText = tx.customer_name;
    document.getElementById('r-whatsapp').innerText = tx.customer_whatsapp;
    document.getElementById('r-item').innerText = tx.item_name;
    document.getElementById('r-weight').innerText = parseFloat(tx.weight).toFixed(2) + ' kg';
    document.getElementById('r-total').innerText = formatRupiah(tx.total_price);

    // Capture template
    const template = document.getElementById('receipt-template');
    html2canvas(template, {
        scale: 2, // Better quality
        backgroundColor: '#ffffff'
    }).then(canvas => {
        const link = document.createElement('a');
        link.download = `Bukti-Beli-${tx.customer_name}-${tx.id}.png`;
        link.href = canvas.toDataURL('image/png');
        link.click();
    });
}

function updateSummary() {
    const selectedOption = itemIdSelect.options[itemIdSelect.selectedIndex];
    const weight = parseFloat(weightInput.value) || 0;

    if (itemIdSelect.value && weight > 0) {
        const pricePerKg = parseFloat(selectedOption.getAttribute('data-price'));
        const stock = parseFloat(selectedOption.getAttribute('data-stock'));
        const totalPrice = pricePerKg * weight;

        document.getElementById('display-price').innerText = formatRupiah(pricePerKg);
        document.getElementById('display-weight').innerText = weight.toFixed(2) + ' kg';
        document.getElementById('display-total').innerText = formatRupiah(totalPrice);
        
        priceSummary.classList.remove('hidden');

        if (weight > stock) {
            stockWarning.classList.remove('hidden');
            submitBtn.disabled = true;
        } else {
            stockWarning.classList.add('hidden');
            submitBtn.disabled = false;
        }
    } else {
        priceSummary.classList.add('hidden');
        stockWarning.classList.add('hidden');
        submitBtn.disabled = true;
    }
}

itemIdSelect.addEventListener('change', updateSummary);
weightInput.addEventListener('input', updateSummary);
</script>
<?= $this->endSection() ?>
