@extends('layouts.app')

@section('title', 'Data Peminjaman')

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
            <h4 class="mb-0 fw-bold text-white">📦 Data Peminjaman</h4>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="text-center bg-light fw-bold">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Peminjam</th>
                            <th>Nama Alat</th>
                            <th>Tanggal Peminjaman</th>
                            <th>Tanggal Pengembalian</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($borrowings as $borrowing)
                        <tr>
                            <td class="text-center fw-bold">
                                {{ $borrowings->firstItem() + $loop->index }}
                            </td>

                            <td>{{ $borrowing->user->name ?? '-' }}</td>
                            <td>{{ $borrowing->tool->name_tool ?? '-' }}</td>
                            <td>{{ $borrowing->borrowed_at }}</td>
                            <td>{{ $borrowing->returned_at }}</td>

                            <td class="text-center">
                                {{-- APPROVE --}}
                                <form action="{{ route('officer.borrowings.approve', $borrowing->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button class="btn btn-success btn-sm">Setujui</button>
                                </form>

                                {{-- REJECT --}}
                                <form action="{{ route('officer.borrowings.reject', $borrowing->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button class="btn btn-danger btn-sm">Tolak</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Tidak ada data peminjaman</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINASI --}}
            <div class="d-flex justify-content-end">
                {{ $borrowings->links() }}
            </div>

        </div>
    </div>
</div>

@endsection
