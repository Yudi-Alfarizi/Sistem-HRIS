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
                            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('tasks.index') }}">Daftar
                                    Tugas</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detail Tugas</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Informasi Detail Tugas
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Judul</th>
                            <td>{{ $task->title }}</td>
                        </tr>
                        <tr>
                            <th>Ditugaskan Kepada</th>
                            <td>{{ $task->employee->fullname ?? 'Tidak ada karyawan yang ditugaskan' }}</td>
                        </tr>
                        <tr>
                            <th>Deskripsi</th>
                            <td>{{ $task->description }}</td>
                        </tr>
                        <tr>
                            <th>Tenggat Waktu</th>
                            <td>{{ $task->due_date }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if ($task->status == 'pending')
                                    <span class="badge bg-warning"><i class="bi bi-clock-history me-1"></i> Pending</span>
                                @elseif ($task->status == 'proses')
                                    <span class="badge bg-info"><i class="bi bi-arrow-repeat me-1"></i> Proses</span>
                                @elseif ($task->status == 'selesai')
                                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Selesai</span>
                                @else
                                    <span class="badge bg-secondary">{{ $task->status }}</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Kembali ke Daftar Tugas</a>
                </div>
            </div>
        </section>
    </div>
@endsection
