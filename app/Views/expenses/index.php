<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<h1 class="text-3xl font-bold mb-8 text-gray-800">Manajemen Pengeluaran</h1>

<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-8 transition-all hover:shadow-md">
    <h2 class="text-xl font-bold mb-6 text-red-600 flex items-center space-x-2" id="form-title">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span>Tambah Pengeluaran Baru</span>
    </h2>
    <form action="<?= base_url('/expenses/save') ?>" method="post" class="grid grid-cols-1 md:grid-cols-2 gap-6 items-end">
        <input type="hidden" name="id" id="expense-id">
        <div class="space-y-1">
            <label class="block text-sm font-semibold text-gray-600">Keterangan Pengeluaran</label>
            <input type="text" name="description" id="expense-description" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 outline-none transition-all" placeholder="Contoh: Listrik, Gaji Karyawan, Transport" required>
        </div>
        <div class="space-y-1">
            <label class="block text-sm font-semibold text-gray-600">Jumlah (Rp)</label>
            <input type="number" name="amount" id="expense-amount" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 outline-none transition-all" placeholder="0" required min="0">
        </div>
        <div class="md:col-span-2 flex justify-end space-x-3 mt-4">
            <button type="button" id="cancel-btn" class="hidden items-center space-x-2 px-6 py-3 text-gray-500 hover:bg-gray-100 rounded-xl transition-all font-medium">
                <span>Batal</span>
            </button>
            <button type="submit" class="flex items-center space-x-2 px-8 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700 shadow-lg shadow-red-200 transition-all transform active:scale-[0.98] font-bold">
                <span id="submit-text">Simpan Pengeluaran</span>
            </button>
        </div>
    </form>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 font-semibold text-gray-600 text-sm">Waktu</th>
                    <th class="px-6 py-4 font-semibold text-gray-600 text-sm">Keterangan</th>
                    <th class="px-6 py-4 font-semibold text-gray-600 text-sm text-right">Jumlah</th>
                    <th class="px-6 py-4 font-semibold text-gray-600 text-sm text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php foreach ($expenses as $expense) : ?>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 text-xs text-gray-500"><?= date('d/m/Y H:i', strtotime($expense['expense_date'])) ?></td>
                        <td class="px-6 py-4 font-bold text-gray-800"><?= esc($expense['description']) ?></td>
                        <td class="px-6 py-4 text-right text-red-600 font-black">Rp <?= number_format($expense['amount'], 0, ',', '.') ?></td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end space-x-1">
                                <button onclick='editExpense(<?= json_encode($expense) ?>)' class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <form action="<?= base_url('/expenses/delete/'.$expense['id']) ?>" method="post" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-all" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($expenses)) : ?>
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-400 italic font-medium">Belum ada data pengeluaran.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function editExpense(expense) {
    document.getElementById('form-title').innerHTML = `
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
        <span>Edit Pengeluaran</span>
    `;
    document.getElementById('expense-id').value = expense.id;
    document.getElementById('expense-description').value = expense.description;
    document.getElementById('expense-amount').value = expense.amount;
    document.getElementById('submit-text').innerText = 'Perbarui Pengeluaran';
    document.getElementById('cancel-btn').classList.remove('hidden');
    document.getElementById('cancel-btn').classList.add('flex');
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

document.getElementById('cancel-btn').onclick = function() {
    document.getElementById('form-title').innerHTML = `
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span>Tambah Pengeluaran Baru</span>
    `;
    document.getElementById('expense-id').value = '';
    document.getElementById('expense-description').value = '';
    document.getElementById('expense-amount').value = '';
    document.getElementById('submit-text').innerText = 'Simpan Pengeluaran';
    this.classList.add('hidden');
    this.classList.remove('flex');
};
</script>
<?= $this->endSection() ?>
