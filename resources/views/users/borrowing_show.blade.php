@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')

<style>
    .status-badge {
        font-size: 1.1rem;
        padding: 0.5rem 1rem;
    }
</style>

<div class="container mt-5">

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

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card shadow border-0">
                <div class="card-header bg-dark">
                    <h4 class="mb-0 fw-bold text-white">Detail Peminjaman</h4>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted text-uppercase fw-bold">Nama Alat</h6>
                            <p class="fs-5 fw-bold">{{ $borrowing->tool->name_tool ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted text-uppercase fw-bold">Kategori</h6>
                            <p class="fs-5 fw-bold">{{ $borrowing->tool->category->name_category ?? '-' }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted text-uppercase fw-bold">Tanggal Peminjaman</h6>
                            <p class="fs-5">{{ $borrowing->borrowed_at->format('d-m-Y') ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted text-uppercase fw-bold">Tanggal Pengembalian</h6>
                            <p class="fs-5">
                                @if ($borrowing->returned_at)
                                    {{ $borrowing->returned_at->format('d-m-Y') }}
                                @else
                                    <span class="text-muted">Belum dikembalikan</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted text-uppercase fw-bold">Status Peminjaman</h6>
                            <p>
                                @if ($borrowing->status === 'borrowed')
                                    <span class="badge bg-primary status-badge">Sedang Dipinjam</span>
                                @elseif ($borrowing->status === 'returned')
                                    <span class="badge bg-secondary status-badge">Dikembalikan</span>
                                @else
                                    <span class="badge bg-light text-dark status-badge">{{ ucfirst($borrowing->status) }}</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted text-uppercase fw-bold">Status Persetujuan</h6>
                            <p>
                                @if ($borrowing->approval_status === 'pending')
                                    <span class="badge bg-warning text-dark status-badge">Menunggu Persetujuan</span>
                                @elseif ($borrowing->approval_status === 'approved')
                                    <span class="badge bg-success status-badge">Disetujui</span>
                                @elseif ($borrowing->approval_status === 'rejected')
                                    <span class="badge bg-danger status-badge">Ditolak</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted text-uppercase fw-bold">Disetujui Oleh</h6>
                            <p class="fs-5">
                                @if ($borrowing->approvedBy)
                                    {{ $borrowing->approvedBy->name }}
                                @else
                                    <span class="text-muted">Belum disetujui</span>
                                @endif
                            </p>
                        </div>
                    </div>

                </div>

                <div class="card-footer bg-light">
                    <div class="d-flex gap-2">
                        <a href="{{ route('user.borrowings.list') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>

                        @if ($borrowing->approval_status === 'pending')
                            <form action="{{ route('user.borrowings.cancel', $borrowing->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Batalkan peminjaman ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">
                                    <i class="fas fa-times"></i> Batalkan Permintaan
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Timeline -->
        <div class="col-lg-4">
            <div class="card shadow border-0">
                <div class="card-header bg-dark">
                    <h5 class="mb-0 fw-bold text-white">Timeline</h5>
                </div>

                <div class="card-body">
                    <div class="timeline">
                        <!-- Requested -->
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <p class="timeline-content fw-bold">Permintaan Dibuat</p>
                            <small class="text-muted">{{ $borrowing->created_at->format('d-m-Y H:i') }}</small>
                        </div>

                        <!-- Approved -->
                        @if ($borrowing->approval_status === 'approved')
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <p class="timeline-content fw-bold">Disetujui</p>
                                <small class="text-muted">{{ $borrowing->updated_at->format('d-m-Y H:i') }}</small>
                            </div>
                        @elseif ($borrowing->approval_status === 'rejected')
                            <div class="timeline-item">
                                <div class="timeline-marker bg-danger"></div>
                                <p class="timeline-content fw-bold">Ditolak</p>
                                <small class="text-muted">{{ $borrowing->updated_at->format('d-m-Y H:i') }}</small>
                            </div>
                        @endif

                        <!-- Borrowed -->
                        @if ($borrowing->status === 'borrowed')
                            <div class="timeline-item">
                                <div class="timeline-marker bg-info"></div>
                                <p class="timeline-content fw-bold">Sedang Dipinjam</p>
                                <small class="text-muted">{{ $borrowing->borrowed_at->format('d-m-Y H:i') }}</small>
                            </div>
                        @endif

                        <!-- Returned -->
                        @if ($borrowing->status === 'returned')
                            <div class="timeline-item">
                                <div class="timeline-marker bg-secondary"></div>
                                <p class="timeline-content fw-bold">Dikembalikan</p>
                                <small class="text-muted">{{ $borrowing->returned_at->format('d-m-Y H:i') }}</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    .timeline {
        position: relative;
        padding-left: 2rem;
    }

    .timeline-item {
        margin-bottom: 2rem;
        position: relative;
    }

    .timeline-item:not(:last-child)::before {
        content: '';
        position: absolute;
        left: -1.25rem;
        top: 2rem;
        width: 2px;
        height: calc(100% + 1rem);
        background-color: #dee2e6;
    }

    .timeline-marker {
        position: absolute;
        left: -1.75rem;
        top: 0.25rem;
        width: 1.25rem;
        height: 1.25rem;
        border-radius: 50%;
        border: 2px solid white;
    }

    .timeline-content {
        margin-bottom: 0.25rem;
    }
</style>

@endsection
