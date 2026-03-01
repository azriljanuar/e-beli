<!DOCTYPE html>
<html>
<head>
    <title>Laporan Rekapitulasi e-Beli</title>
    <style>
        body { font-family: sans-serif; color: #333; line-height: 1.5; }
        .header { text-align: center; border-bottom: 2px solid #444; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; color: #2563eb; }
        .header p { margin: 5px 0 0; font-size: 12px; color: #666; }
        
        .summary-box { width: 100%; margin-bottom: 30px; border-collapse: collapse; }
        .summary-box td { padding: 15px; border: 1px solid #e5e7eb; border-radius: 8px; }
        .summary-label { font-size: 12px; font-weight: bold; color: #6b7280; text-transform: uppercase; margin-bottom: 5px; }
        .summary-value { font-size: 18px; font-weight: bold; }
        
        .section-title { font-size: 16px; font-weight: bold; color: #1f2937; margin-bottom: 10px; border-left: 4px solid #2563eb; padding-left: 10px; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 11px; }
        th { background-color: #f9fafb; border-bottom: 1px solid #e5e7eb; padding: 10px; text-align: left; font-weight: bold; color: #4b5563; }
        td { border-bottom: 1px solid #f3f4f6; padding: 10px; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .text-blue { color: #2563eb; }
        .text-red { color: #dc2626; }
        .text-green { color: #16a34a; }
        
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; color: #9ca3af; padding: 10px 0; border-top: 1px solid #eee; }
    </style>
</head>
<body>
    <div class="header">
        <h1>e-Beli</h1>
        <p>Laporan Rekapitulasi Keuangan Seluruh Transaksi</p>
        <p>Dicetak pada: <?= $date ?></p>
    </div>

    <table class="summary-box">
        <tr>
            <td>
                <div class="summary-label">Total Penjualan</div>
                <div class="summary-value text-blue">Rp <?= number_format($totalSales, 0, ',', '.') ?></div>
            </td>
            <td>
                <div class="summary-label">Total Pengeluaran</div>
                <div class="summary-value text-red">Rp <?= number_format($totalExpenses, 0, ',', '.') ?></div>
            </td>
            <td>
                <div class="summary-label">Laba Bersih</div>
                <div class="summary-value text-green">Rp <?= number_format($netProfit, 0, ',', '.') ?></div>
            </td>
        </tr>
    </table>

    <div class="section-title">Detail Transaksi Penjualan</div>
    <table>
        <thead>
            <tr>
                <th>Waktu</th>
                <th>Kode</th>
                <th>Pembeli</th>
                <th>Daftar Item</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($groupedTx as $code => $orderItems) : 
                $first = $orderItems[0];
                $totalOrder = array_sum(array_column($orderItems, 'total_price'));
            ?>
                <tr>
                    <td><?= date('d/m/Y H:i', strtotime($first['transaction_date'])) ?></td>
                    <td><code style="font-size: 9px;"><?= $code ?></code></td>
                    <td><?= esc($first['customer_name']) ?></td>
                    <td>
                        <?php foreach ($orderItems as $it) : ?>
                            <div>• <?= esc($it['item_name']) ?> (<?= number_format($it['weight'], 2) ?> kg)</div>
                        <?php endforeach; ?>
                    </td>
                    <td class="text-right font-bold text-blue">Rp <?= number_format($totalOrder, 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="section-title" style="margin-top: 30px;">Detail Pengeluaran</div>
    <table>
        <thead>
            <tr>
                <th>Waktu</th>
                <th>Keterangan</th>
                <th class="text-right">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($expenses as $expense) : ?>
                <tr>
                    <td><?= date('d/m/Y H:i', strtotime($expense['expense_date'])) ?></td>
                    <td><?= esc($expense['description']) ?></td>
                    <td class="text-right font-bold text-red">Rp <?= number_format($expense['amount'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer">
        Aplikasi e-Beli - Sistem Manajemen Penjualan Daging
    </div>
</body>
</html>
