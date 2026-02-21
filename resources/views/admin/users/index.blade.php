@extends('layouts.app')

@section('title', 'Data User')

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
            <h4 class="mb-0 fw-bold text-white">Data User</h4>
            <a href="{{ route('admin.users.create') }}" class="btn btn-light btn-sm text-dark fw-bold">
                + Tambah User
            </a>
        </div>

        <div class="card-body">

            {{-- TABLE --}}
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="text-center bg-light fw-bold">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama User</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($users as $user)
                        <tr>
                            <td class="text-center fw-bold">
                                {{ $users->firstItem() + $loop->index }}
                            </td>

                            <td>{{ $user->name ?? '-' }}</td>
                            <td>{{ $user->email ?? '-' }}</td>
                            <td class="text-capitalize text-center">{{ $user->role ?? '-' }}</td>

                            <td class="text-center">
                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                   class="btn btn-warning btn-sm m-0 text-white">
                                   Edit
                                </a>

                                <form action="{{ route('admin.users.destroy', $user->id) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm m-0">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">
                                Belum ada data user.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="mt-3">
                    {{ $users->links() }}
                </div>
            </div>

        </div>
    </div>

</div>

@endsection
