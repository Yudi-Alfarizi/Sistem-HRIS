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
                    <h3>Daftar Kehadiran</h3>
                    <p class="text-subtitle text-muted">Daftar semua kehadiran yang telah direkam</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">Daftar Kehadiran</li>
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
                        Informasi Daftar Kehadiran
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <a href="{{ route('presences.create') }}" class="btn btn-primary mb-3 ms-auto">Tambah
                            Kehadiran</a>
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
                                <th>Waktu Masuk</th>
                                <th>Waktu Pulang</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($presences as $presence)
                                <tr>
                                    <td>{{ $presence->employee->fullname }}</td>
                                    <td>{{ $presence->check_in }}</td>
                                    <td>{{ $presence->check_out }}</td>
                                    <td>{{ $presence->date }}</td>
                                    <td>
                                        @if ($presence->status === 'hadir')
                                            <span class="badge bg-success">{{ ucfirst($presence->status) }}</span>
                                        @elseif ($presence->status === 'izin')
                                            <span class="badge bg-warning">{{ ucfirst($presence->status) }}</span>
                                        @elseif ($presence->status === 'sakit')
                                            <span class="badge bg-info">{{ ucfirst($presence->status) }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ ucfirst($presence->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('presences.edit', $presence->id) }}"
                                            class="btn btn-primary btn-sm me-2">Edit</a>
                                        <form action="{{ route('presences.destroy', $presence->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus kehadiran ini?')">Hapus</button>
                                        </form>
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
