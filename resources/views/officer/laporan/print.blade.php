<!DOCTYPE html>
<html>
<head>
    <title>Cetak Laporan</title>
    <style>
        body { font-family: Arial; }
        table {
            width:100%;
            border-collapse:collapse;
        }
        th, td {
            border:1px solid black;
            padding:8px;
            text-align:center;
        }
    </style>
</head>
<body onload="window.print()">

<h3 style="text-align:center;">LAPORAN PEMINJAMAN ALAT</h3>

<table>
    <tr>
        <th>No</th>
        <th>Peminjam</th>
        <th>Alat</th>
        <th>Tanggal Pinjam</th>
        <th>Status</th>
    </tr>

    @foreach($data as $item)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->user->name }}</td>
        <td>{{ $item->tool->name_tool }}</td>
        <td>{{ $item->borrowed_at->format('d-m-Y') }}</td>
        <td>{{ $item->status }}</td>
    </tr>
    @endforeach

</table>

</body>
</html>
