@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')

@section('content')

<style>
    .table-bordered>:not(caption)>*>* {
        border-width: 1px !important;
    }
    .badge-pending {
        background-color: #ffc107;
        color: #000;
    }
    .badge-approved {
        background-color: #28a745;
    }
    .badge-rejected {
        background-color: #dc3545;
    }
    .badge-borrowed {
        background-color: #007bff;
    }
    .badge-returned {
        background-color: #6c757d;
    }
</style>

<div class="container mt-5" style="margin-left: 250px;">

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
            <h4 class="mb-0 fw-bold text-white">📋 Riwayat Peminjaman</h4>
            <a href="{{ route('user.borrowings_create') }}" class="btn btn-light btn-sm text-dark fw-bold">
                <i class="fas fa-plus"></i> Pinjam Alat
            </a>
        </div>

        <div class="card-body">

            {{-- TABLE --}}
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="text-center bg-light fw-bold">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Alat</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status Peminjaman</th>
                            <th>Status Persetujuan</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($borrowings as $borrowing)
                            <tr>
                                <td class="text-center fw-bold">
                                    {{ $borrowings->firstItem() + $loop->index }}
                                </td>

                                <td class="fw-bold">{{ $borrowing->tool->name_tool ?? '-' }}</td>
                                <td class="text-center">{{ $borrowing->borrowed_at->format('d-m-Y') ?? '-' }}</td>
                                <td class="text-center">
                                    @if ($borrowing->returned_at)
                                        {{ $borrowing->returned_at->format('d-m-Y') }}
                                    @else
                                        <span class="text-muted">Belum dikembalikan</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    @if ($borrowing->status === 'borrowed')
                                        <span class="badge badge-borrowed">Sedang Dipinjam</span>
                                    @elseif ($borrowing->status === 'returned')
                                        <span class="badge badge-returned">Dikembalikan</span>
                                    @else
                                        <span class="badge badge-secondary">{{ ucfirst($borrowing->status) }}</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    @if ($borrowing->approval_status === 'pending')
                                        <span class="badge badge-pending">Menunggu Persetujuan</span>
                                    @elseif ($borrowing->approval_status === 'approved')
                                        <span class="badge badge-approved">Disetujui</span>
                                    @elseif ($borrowing->approval_status === 'rejected')
                                        <span class="badge badge-rejected">Ditolak</span>
                                    @endif
                                </td>

                                <td class="text-center">

                                    @if ($borrowing->status === 'borrowed' && $borrowing->approval_status === 'approved')
                                        <form action="{{ route('user.borrowings.return', $borrowing->id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Kembalikan alat ini?')">
                                            @csrf
                                            <button class="btn btn-success btn-sm" title="Kembalikan">
                                                <i class="fas fa-undo"></i> Kembalikan
                                            </button>
                                        </form>
                                    @endif

                                    @if ($borrowing->approval_status === 'pending')
                                        <form action="{{ route('user.borrowings.cancel', $borrowing->id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Batalkan peminjaman ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" title="Batalkan">
                                                <i class="fas fa-times"></i> Batalkan
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox"></i> Belum ada riwayat peminjaman
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            @if ($borrowings->hasPages())
                <div class="d-flex justify-content-end mt-3">
                    {{ $borrowings->links() }}
                </div>
            @endif

        </div>
    </div>

</div>

@endsection
