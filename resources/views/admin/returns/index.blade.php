@extends('layouts.app')

@section('title', 'Data Pengembalian')

@section('content')

<style>
    .table-bordered>:not(caption)>*>* {
        border-width: 1px !important;
    }
</style>

<div class="container mt-5">

    {{-- NOTIFIKASI --}}
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card shadow border-0">
        <div class="card-header bg-dark d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold text-white">Data Pengembalian</h4>
        </div>

        <div class="card-body">

            {{-- TABLE --}}
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="text-center bg-light fw-bold">
                        <tr>
                            <th>No</th>
                            <th>ID Peminjaman</th>
                            <th>Tanggal Kembali</th>
                            <th>Denda</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($returns as $item)
                        <tr>
                            <td class="text-center fw-bold">
                                {{ $returns->firstItem() + $loop->index }}
                            </td>

                            <td>{{ $item->borrowing_id }}</td>
                            <td>{{ $item->returned_at }}</td>
                            <td>Rp {{ number_format($item->fine_amount,0,',','.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3">
                                Belum ada data alat.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>

                {{-- Pagination --}}
                <div class="mt-3">
                    {{ $returns->links() }}
                </div>
            </div>

        </div>
    </div>

</div>

@endsection