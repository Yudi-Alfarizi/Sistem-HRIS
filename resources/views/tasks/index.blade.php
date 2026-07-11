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
                    <h3>Daftar Tugas</h3>
                    <p class="text-subtitle text-muted">Daftar semua tugas yang telah dibuat</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">Daftar Tugas</li>
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
                        Informasi Daftar Tugas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3 ms-auto">Tambah Tugas</a>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Ditugaskan Kepada</th>
                                <th>Tenggat Waktu</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td>{{ $task->title }}</td>
                                    <td>{{ $task->employee->fullname ?? 'Tidak ada karyawan yang ditugaskan' }}</td>
                                    <td>{{ $task->due_date }}</td>
                                    <td>
                                        @if ($task->status == 'pending')
                                            <span class="text-warning">Pending</span>
                                        @elseif ($task->status == 'selesai')
                                            <span class="text-success">Selesai</span>
                                        @elseif ($task->status == 'sedang dikerjakan')
                                            <span class="text-info">Sedang Dikerjakan</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="" class="btn btn-info btn-sm me-2">Lihat</a>
                                        @if ($task->status == 'pending')
                                            <a href="" class="btn btn-success btn-sm me-2">Selesai</a>
                                        @else
                                            <a href="" class="btn btn-warning btn-sm me-2">Pending</a>
                                        @endif
                                        <a href="" class="btn btn-primary btn-sm me-2">Edit</a>
                                        <a href="" class="btn btn-danger btn-sm me-2">Hapus</a>
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
