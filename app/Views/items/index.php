<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<h1 class="text-3xl font-bold mb-8 text-gray-800">Data Master Daging</h1>

<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-8 transition-all hover:shadow-md">
    <h2 class="text-xl font-bold mb-6 text-blue-600 flex items-center space-x-2" id="form-title">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span>Tambah Bagian Daging Baru</span>
    </h2>
    <form action="<?= base_url('/master/save') ?>" method="post" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
        <input type="hidden" name="id" id="item-id">
        <div class="space-y-1">
            <label class="block text-sm font-semibold text-gray-600">Nama Item (Bagian Daging)</label>
            <input type="text" name="name" id="item-name" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all" placeholder="Contoh: Daging, Jeroan, Iga" required>
        </div>
        <div class="space-y-1">
            <label class="block text-sm font-semibold text-gray-600">Harga per Kg (Rp)</label>
            <input type="number" name="price_per_kg" id="item-price" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all" placeholder="0" required min="0">
        </div>
        <div class="space-y-1">
            <label class="block text-sm font-semibold text-gray-600">Stok Awal (kg)</label>
            <input type="number" step="0.01" name="stock" id="item-stock" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all" placeholder="0.00" required min="0">
        </div>
        <div class="md:col-span-3 flex justify-end space-x-3 mt-4">
            <button type="button" id="cancel-btn" class="hidden items-center space-x-2 px-6 py-3 text-gray-500 hover:bg-gray-100 rounded-xl transition-all font-medium">
                <span>Batal</span>
            </button>
            <button type="submit" class="flex items-center space-x-2 px-8 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all transform active:scale-[0.98] font-bold">
                <span id="submit-text">Simpan Item</span>
            </button>
        </div>
    </form>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 font-semibold text-gray-600 text-sm">Nama Bagian</th>
                    <th class="px-6 py-4 font-semibold text-gray-600 text-sm">Harga/kg</th>
                    <th class="px-6 py-4 font-semibold text-gray-600 text-sm text-center">Stok (kg)</th>
                    <th class="px-6 py-4 font-semibold text-gray-600 text-sm text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php foreach ($items as $item) : ?>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 font-bold text-gray-800"><?= esc($item['name']) ?></td>
                        <td class="px-6 py-4 text-gray-600 font-medium">Rp <?= number_format($item['price_per_kg'], 0, ',', '.') ?></td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 rounded-full text-sm font-bold <?= $item['stock'] <= 5 ? 'bg-red-50 text-red-600' : 'bg-green-50 text-green-600' ?>">
                                <?= number_format($item['stock'], 2) ?> kg
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end space-x-1">
                                <button onclick='editItem(<?= json_encode($item) ?>)' class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <form action="<?= base_url('/master/delete/'.$item['id']) ?>" method="post" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-all" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($items)) : ?>
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-400 italic font-medium">Belum ada data daging. Silakan tambah data baru.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function editItem(item) {
    document.getElementById('form-title').innerHTML = `
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
        <span>Edit Bagian Daging</span>
    `;
    document.getElementById('item-id').value = item.id;
    document.getElementById('item-name').value = item.name;
    document.getElementById('item-price').value = item.price_per_kg;
    document.getElementById('item-stock').value = item.stock;
    document.getElementById('submit-text').innerText = 'Perbarui Item';
    document.getElementById('cancel-btn').classList.remove('hidden');
    document.getElementById('cancel-btn').classList.add('flex');
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

document.getElementById('cancel-btn').onclick = function() {
    document.getElementById('form-title').innerHTML = `
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span>Tambah Bagian Daging Baru</span>
    `;
    document.getElementById('item-id').value = '';
    document.getElementById('item-name').value = '';
    document.getElementById('item-price').value = '';
    document.getElementById('item-stock').value = '';
    document.getElementById('submit-text').innerText = 'Simpan Item';
    this.classList.add('hidden');
    this.classList.remove('flex');
};
</script>
<?= $this->endSection() ?>
