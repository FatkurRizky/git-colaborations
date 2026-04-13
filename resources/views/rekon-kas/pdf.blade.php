<!DOCTYPE html>
<html>
<head>
    <title>Laporan Rekon Kas</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .header { text-align: center; margin-bottom: 20px; }
        .status-success { color: green; font-weight: bold; }
        .status-danger { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN REKAPITULASI KAS</h2>
        <p>Dicetak pada: {{ date('d-m-Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Saldo Awal</th>
                <th>Pemasukan</th>
                <th>Pengeluaran</th>
                <th>Kas Aktual</th>
                <th>Selisih</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rekons as $index => $rekon)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $rekon->rekon_date->format('d/m/Y') }}</td>
                    <td class="text-right">Rp {{ number_format($rekon->opening_cash, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($rekon->cash_income, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($rekon->operational_cash, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($rekon->actual_cash, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($rekon->difference, 0, ',', '.') }}</td>
                    <td>
                        <span class="{{ $rekon->status == 'sesuai' ? 'status-success' : 'status-danger' }}">
                            {{ ucfirst($rekon->status) }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>