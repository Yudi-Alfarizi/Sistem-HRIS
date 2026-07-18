@extends('layouts.dashboard')

@section('content')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Daftar Permohonan Cuti</h3>
                    <p class="text-subtitle text-muted">Daftar semua permohonan cuti yang telah dibuat</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">Daftar Cuti</li>
                            <li class="breadcrumb-item active" aria-current="page">Indeks</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Informasi Daftar Permohonan Cuti
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <a href="{{ route('leave-requests.create') }}" class="btn btn-primary mb-3 ms-auto">Tambah
                            Permohonan Cuti</a>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>Karyawan</th>
                                <th>Jenis Cuti</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Status</th>
                                @if (session('role') === 'HR')
                                    <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($leaveRequests as $leaveRequest)
                                <tr>
                                    <td>{{ $leaveRequest->employee->fullname }}</td>
                                    <td>{{ $leaveRequest->leave_type }}</td>
                                    <td>{{ \Carbon\Carbon::parse($leaveRequest->start_date)->locale('id')->translatedFormat('d F Y') }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($leaveRequest->end_date)->locale('id')->translatedFormat('d F Y') }}
                                    </td>
                                    <td>
                                        @if ($leaveRequest->status === 'pending')
                                            <span class="badge bg-warning">{{ ucfirst($leaveRequest->status) }}</span>
                                        @elseif ($leaveRequest->status === 'disetujui')
                                            <span class="badge bg-success">{{ ucfirst($leaveRequest->status) }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ ucfirst($leaveRequest->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if (session('role') === 'HR')
                                            @if ($leaveRequest->status === 'pending' || $leaveRequest->status === 'ditolak')
                                                <a href="{{ route('leave-requests.confirm', $leaveRequest->id) }}"
                                                    class="btn btn-success btn-sm me-2">Setujui</a>
                                            @else
                                                <a href="{{ route('leave-requests.reject', $leaveRequest->id) }}"
                                                    class="btn btn-danger btn-sm me-2">Tolak</a>
                                            @endif
                                            <a href="{{ route('leave-requests.edit', $leaveRequest->id) }}"
                                                class="btn btn-primary btn-sm me-2">Edit</a>
                                            <form action="{{ route('leave-requests.destroy', $leaveRequest->id) }}"
                                                method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus cuti ini?')">Hapus</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection
