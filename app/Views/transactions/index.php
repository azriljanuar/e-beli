<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<h1 class="text-3xl font-bold mb-8 text-gray-800">Transaksi Baru</h1>

<div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 max-w-5xl">
    <form action="<?= base_url('/transaction/save') ?>" method="post" class="space-y-8">
        <!-- Data Pembeli -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-3">
                <h2 class="text-lg font-semibold text-blue-600 border-b pb-2 mb-4">Data Pembeli & Admin</h2>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pembeli</label>
                <input type="text" name="customer_name" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all" placeholder="Nama pembeli" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">No. WhatsApp</label>
                <input type="tel" name="customer_whatsapp" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all" placeholder="0812345..." required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Admin</label>
                <select name="admin_name" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none bg-white" required>
                    <option value="">-- Pilih Admin --</option>
                    <?php foreach ($admins as $admin) : ?>
                        <option value="<?= $admin ?>"><?= $admin ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!-- Detail Pesanan (Multi-item) -->
        <div>
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-blue-600">Daftar Belanja</h2>
                <button type="button" onclick="addItemRow()" class="flex items-center space-x-2 px-4 py-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition-all font-bold text-sm border border-green-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Tambah Item</span>
                </button>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full" id="items-table">
                    <thead>
                        <tr class="text-left text-sm text-gray-500 border-b">
                            <th class="pb-3 font-semibold">Pilih Item</th>
                            <th class="pb-3 font-semibold w-32">Berat (kg)</th>
                            <th class="pb-3 font-semibold text-right w-40">Harga Satuan</th>
                            <th class="pb-3 font-semibold text-right w-40">Subtotal</th>
                            <th class="pb-3 w-12"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100" id="items-body">
                        <!-- Row template will be inserted here -->
                    </tbody>
                    <tfoot>
                        <tr class="text-right">
                            <td colspan="3" class="pt-6 font-bold text-gray-700 text-lg">Total Pembayaran:</td>
                            <td class="pt-6 font-black text-blue-600 text-2xl" id="grand-total">Rp 0</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <button type="submit" id="submit-btn" class="w-full flex items-center justify-center space-x-2 p-4 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all transform active:scale-[0.98] disabled:bg-gray-300 disabled:shadow-none disabled:cursor-not-allowed">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
            <span>Simpan Transaksi</span>
        </button>
    </form>
</div>

<div class="mt-12">
    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center space-x-2">
        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span>Riwayat Transaksi</span>
    </h2>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-xs uppercase tracking-wider">Waktu / Kode</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-xs uppercase tracking-wider">Admin & Pembeli</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-xs uppercase tracking-wider">Daftar Item</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-xs uppercase tracking-wider text-right">Total Bayar</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-xs uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <?php 
                    $groupedTx = [];
                    foreach ($transactions as $tx) {
                        $groupedTx[$tx['transaction_code']][] = $tx;
                    }
                    ?>
                    <?php foreach ($groupedTx as $code => $items) : 
                        $first = $items[0];
                        $totalOrder = array_sum(array_column($items, 'total_price'));
                    ?>
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-900"><?= date('d/m/Y H:i', strtotime($first['transaction_date'])) ?></div>
                                <div class="text-xs text-blue-500 font-mono"><?= $code ?></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-700">Admin: <?= esc($first['admin_name']) ?></div>
                                <div class="text-sm text-gray-800 font-bold">Cust: <?= esc($first['customer_name']) ?></div>
                            </td>
                            <td class="px-6 py-4">
                                <ul class="text-xs text-gray-600 space-y-1">
                                    <?php foreach ($items as $it) : ?>
                                        <li>• <?= esc($it['item_name']) ?> (<?= number_format($it['weight'], 2) ?> kg)</li>
                                    <?php endforeach; ?>
                                </ul>
                            </td>
                            <td class="px-6 py-4 text-right font-black text-blue-600">Rp <?= number_format($totalOrder, 0, ',', '.') ?></td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end space-x-2">
                                    <button onclick='downloadReceipt(<?= json_encode($items) ?>)' class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-all" title="Cetak Bukti">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    </button>
                                    <a href="<?= base_url('/transaction/delete/'.$code) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini? Stok akan dikembalikan otomatis.')" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-all" title="Hapus Transaksi">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Receipt Template (Hidden) -->
<div id="receipt-container" class="fixed -left-[9999px] top-0">
    <div id="receipt-template" class="bg-white p-8 w-[450px] border shadow-lg text-gray-800">
        <div class="text-center border-b-2 border-dashed pb-6 mb-6">
            <h1 class="text-3xl font-black text-blue-600 mb-1">e-Beli</h1>
            <p class="text-xs text-gray-500 font-bold uppercase tracking-widest">Bukti Pembelian Daging</p>
        </div>
        
        <div class="space-y-4 mb-8">
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Kode:</span>
                <span class="font-mono font-bold" id="r-code"></span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Tanggal:</span>
                <span class="font-bold" id="r-date"></span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Admin:</span>
                <span class="font-bold" id="r-admin"></span>
            </div>
            <div class="border-t pt-4">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Nama Pembeli:</span>
                    <span class="font-bold text-gray-900" id="r-customer"></span>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 mb-6">
            <div class="text-xs text-gray-400 uppercase font-bold mb-3">Detail Pesanan</div>
            <div id="r-items-list" class="space-y-2 mb-4">
                <!-- Items list will be injected -->
            </div>
            <div class="flex justify-between items-center pt-3 border-t-2 border-dashed border-gray-300">
                <span class="text-base font-black text-gray-900">Total Bayar</span>
                <span class="text-xl font-black text-blue-600" id="r-total"></span>
            </div>
        </div>

        <div class="text-center border-t-2 border-dashed pt-6">
            <p class="text-sm font-bold text-gray-800">Terima Kasih Atas Kunjungannya!</p>
            <p class="text-[10px] text-gray-400 mt-1 italic tracking-wider">E-BELI - FRESH & HALAL BEEF</p>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
const itemsBody = document.getElementById('items-body');
const grandTotalDisplay = document.getElementById('grand-total');

function formatRupiah(number) {
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
}

function addItemRow() {
    const row = document.createElement('tr');
    row.className = 'group hover:bg-gray-50 transition-colors';
    row.innerHTML = `
        <td class="py-4 pr-4">
            <select name="item_id[]" class="item-select w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none bg-white" required onchange="calculateRow(this)">
                <option value="">-- Pilih Item --</option>
                <?php foreach ($items as $item) : ?>
                    <option value="<?= $item['id'] ?>" data-price="<?= $item['price_per_kg'] ?>" data-stock="<?= $item['stock'] ?>">
                        <?= esc($item['name']) ?> (Stok: <?= number_format($item['stock'], 2) ?> kg)
                    </option>
                <?php endforeach; ?>
            </select>
        </td>
        <td class="py-4 pr-4">
            <input type="number" step="0.01" name="weight[]" class="weight-input w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none" placeholder="0.00" required min="0.01" oninput="calculateRow(this)">
        </td>
        <td class="py-4 text-right pr-4 text-sm font-medium text-gray-500 unit-price">Rp 0</td>
        <td class="py-4 text-right pr-4 text-sm font-bold text-gray-800 subtotal">Rp 0</td>
        <td class="py-4 text-right">
            <button type="button" onclick="removeRow(this)" class="p-2 text-gray-300 hover:text-red-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </button>
        </td>
    `;
    itemsBody.appendChild(row);
}

function removeRow(btn) {
    if (itemsBody.children.length > 1) {
        btn.closest('tr').remove();
        calculateGrandTotal();
    }
}

function calculateRow(input) {
    const row = input.closest('tr');
    const select = row.querySelector('.item-select');
    const weight = parseFloat(row.querySelector('.weight-input').value) || 0;
    const option = select.options[select.selectedIndex];
    
    if (select.value && weight > 0) {
        const price = parseFloat(option.getAttribute('data-price'));
        const stock = parseFloat(option.getAttribute('data-stock'));
        const subtotal = price * weight;
        
        row.querySelector('.unit-price').innerText = formatRupiah(price);
        row.querySelector('.subtotal').innerText = formatRupiah(subtotal);
        
        if (weight > stock) {
            row.querySelector('.weight-input').classList.add('border-red-500', 'text-red-600');
        } else {
            row.querySelector('.weight-input').classList.remove('border-red-500', 'text-red-600');
        }
    } else {
        row.querySelector('.unit-price').innerText = 'Rp 0';
        row.querySelector('.subtotal').innerText = 'Rp 0';
    }
    calculateGrandTotal();
}

function calculateGrandTotal() {
    let total = 0;
    document.querySelectorAll('.subtotal').forEach(el => {
        const val = parseInt(el.innerText.replace(/[^0-9]/g, '')) || 0;
        total += val;
    });
    grandTotalDisplay.innerText = formatRupiah(total);
}

function downloadReceipt(items) {
    const first = items[0];
    document.getElementById('r-code').innerText = first.transaction_code;
    document.getElementById('r-date').innerText = new Date(first.transaction_date).toLocaleString('id-ID');
    document.getElementById('r-admin').innerText = first.admin_name;
    document.getElementById('r-customer').innerText = first.customer_name;
    
    const list = document.getElementById('r-items-list');
    list.innerHTML = '';
    let total = 0;
    
    items.forEach(it => {
        total += parseFloat(it.total_price);
        const div = document.createElement('div');
        div.className = 'flex justify-between text-sm';
        div.innerHTML = `
            <span class="text-gray-700">${it.item_name} <span class="text-gray-400 text-xs">x${parseFloat(it.weight).toFixed(2)}</span></span>
            <span class="font-bold">${formatRupiah(it.total_price)}</span>
        `;
        list.appendChild(div);
    });
    
    document.getElementById('r-total').innerText = formatRupiah(total);

    const template = document.getElementById('receipt-template');
    html2canvas(template, { scale: 2, backgroundColor: '#ffffff' }).then(canvas => {
        const link = document.createElement('a');
        link.download = `Nota-${first.customer_name}-${first.transaction_code}.png`;
        link.href = canvas.toDataURL('image/png');
        link.click();
    });
}

// Init first row
addItemRow();
</script>
<?= $this->endSection() ?>
