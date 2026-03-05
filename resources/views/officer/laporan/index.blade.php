@extends('layouts.app')

@section('title', 'Laporan')

@section('content')

<div class="container mt-4">

    <h4>Laporan Peminjaman</h4>

    <a href="{{ route('officer.laporan.print') }}"
       target="_blank"
       class="btn btn-success mb-3">
        Cetak Laporan
    </a>

    <table class="table table-bordered">
        <thead>
            <tr> 
                <th>No</th>
                <th>Peminjam</th>
                <th>Alat</th>
                <th>Tanggal Pinjam</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->tool->name_tool }}</td>
                <td>{{ $item->borrowed_at->format('d-m-Y') }}</td>
                <td>{{ $item->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection
