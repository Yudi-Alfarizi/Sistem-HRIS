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
                    <h3>Daftar Karyawan</h3>
                    <p class="text-subtitle text-muted">Daftar semua karyawan</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">Daftar Karyawan</li>
                            <li class="breadcrumb-item active" aria-current="page">Detail Karyawan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Informasi Detail Karyawan
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Nama Lengkap</th>
                            <td>{{ $employee->fullname }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $employee->email }}</td>
                        </tr>
                        <tr>
                            <th>Nomor Telepon</th>
                            <td>{{ $employee->phone_number }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $employee->address }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Lahir</th>
                            <td>{{ $employee->birth_date }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Dipekerjakan</th>
                            <td>{{ $employee->hire_date }}</td>
                        </tr>
                        <tr>
                            <th>Departemen</th>
                            <td>{{ $employee->department->name ?? 'Tidak ada departemen' }}</td>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <td>{{ $employee->role->title ?? 'Tidak ada role' }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if ($employee->status == 'active')
                                    <span class="badge bg-success">{{ ucfirst($employee->status) }}</span>
                                @else
                                    <span class="badge bg-danger">{{ ucfirst($employee->status) }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Gaji</th>
                            <td>{{ 'Rp ' . number_format($employee->salary, 2, ',', '.') }}</td>
                        </tr>
                    </table>
                    <a href="{{ route('employees.index') }}" class="btn btn-secondary">Kembali ke Daftar Karyawan</a>
                </div>
            </div>
        </section>
    </div>
@endsection
