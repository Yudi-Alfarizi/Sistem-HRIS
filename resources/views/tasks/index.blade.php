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
                        @if (session('role') == 'HR')
                            <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3 ms-auto">Tambah Tugas</a>
                        @endif
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
                                        @elseif ($task->status == 'proses')
                                            <span class="text-info">Proses</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('tasks.show', $task->id) }}"
                                            class="btn btn-info btn-sm me-2">Lihat</a>
                                        @if ($task->status == 'pending')
                                            <a href="{{ route('tasks.in-progress', $task->id) }}"
                                                class="btn btn-info btn-sm me-2">Tandai Proses</a>
                                        @elseif ($task->status == 'selesai')
                                            <a href="{{ route('tasks.pending', $task->id) }}"
                                                class="btn btn-warning btn-sm me-2">Tandai Pending</a>
                                        @else
                                            <a href="{{ route('tasks.done', $task->id) }}"
                                                class="btn btn-success btn-sm me-2">Tandai Selesai</a>
                                        @endif
                                        @if (session('role') == 'HR')
                                            <a href="{{ route('tasks.edit', $task->id) }}"
                                                class="btn btn-primary btn-sm me-2">Edit</a>
                                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus tugas ini?')">Hapus</button>
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
