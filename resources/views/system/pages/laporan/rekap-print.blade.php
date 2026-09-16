<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Rekap Laporan per Jenis Surat - {{ $periodeLabel }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #222;
            padding: 24px;
        }

        h1 {
            font-size: 20px;
            margin-bottom: 4px;
        }

        .subtitle {
            color: #666;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #999;
            padding: 8px 10px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
        }

        .text-end {
            text-align: right;
        }

        tfoot th,
        tfoot td {
            background: #f2f2f2;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h1>Rekap Laporan per Jenis Surat</h1>
    <div class="subtitle">Periode: {{ $periodeLabel }}</div>

    @if ($totalRekap === 0)
        <p>Belum ada surat selesai pada periode ini.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Jenis Surat</th>
                    <th class="text-end">Jumlah</th>
                    <th class="text-end">Persentase</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rekap as $baris)
                    <tr>
                        <td>{{ $baris['jenis'] }}</td>
                        <td class="text-end">{{ $baris['jumlah'] }}</td>
                        <td class="text-end">{{ number_format($baris['persentase'], 1, ',', '.') }}%</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Total</th>
                    <th class="text-end">{{ $totalRekap }}</th>
                    <th class="text-end">100%</th>
                </tr>
            </tfoot>
        </table>
    @endif

    <script>
        window.onload = function () {
            window.print();
        };
    </script>
</body>

</html>
