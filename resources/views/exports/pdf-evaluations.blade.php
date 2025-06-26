<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Evaluasi WP</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th, td {
            border: 1px solid #444;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        h3 {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <h3>Hasil Evaluasi WP</h3>
    <p><strong>Criteria Hash:</strong> {{ $hash }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>No Rekening</th>
                <th>Pendapatan</th>
                <th>Jaminan</th>
                <th>Tanggungan</th>
                <th>Pinjaman</th>
                <th>Nilai WP</th>
                <th>Normalisasi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($evaluations as $index => $eval)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $eval->loan->user->name }}</td>
                    <td>{{ $eval->loan->user->profile->nomor_rekening }}</td>
                    <td>{{ number_format($eval->loan->pendapatan) }}</td>
                    <td>{{ number_format($eval->loan->jaminan) }}</td>
                    <td>{{ $eval->loan->jumlah_tanggungan }}</td>
                    <td>{{ number_format($eval->loan->jumlah_pinjaman) }}</td>
                    <td>{{ number_format($eval->nilai_wp, 6) }}</td>
                    <td>{{ number_format($eval->normalized_wp, 6) }}</td>
                    <td>{{ ucfirst($eval->loan->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
