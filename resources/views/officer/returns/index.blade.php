@extends('layouts.app')

@section('title', 'Data Pengembalian')

@section('content')

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
            <h4 class="mb-0 fw-bold text-white">📦 Data Pengembalian</h4>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="bg-light fw-bold">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Peminjam</th>
                            <th>Nama Alat</th>
                            <th>Tanggal Pengembalian</th>
                            <th>Kondisi Alat</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($returns as $return)
                            <tr>
                                <td>{{ $returns->firstItem() + $loop->index }}</td>

                                <td>{{ $return->user->name ?? '-' }}</td>

                                <td>{{ $return->tool->name_tool ?? '-' }}</td>

                                <td>
                                    {{ \Carbon\Carbon::parse($return->returned_at)->format('d M Y') }}
                                </td>

                                <td>
                                    @if ($return->tool_condition == 'baik')
                                        <span class="badge bg-success">Baik</span>
                                    @elseif ($return->tool_condition == 'rusak')
                                        <span class="badge bg-danger">Rusak</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $return->tool_condition }}</span>
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ route('officer.returns.show', $return->id) }}"
                                       class="btn btn-info btn-sm">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    Tidak ada data pengembalian.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            <div class="d-flex justify-content-end mt-3">
                {{ $returns->links() }}
            </div>

        </div>
    </div>

</div>

@endsection
