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
                    <h3>Daftar Gaji</h3>
                    <p class="text-subtitle text-muted">Daftar semua gaji yang telah dibuat</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">Daftar Gaji</li>
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
                        Informasi Daftar Gaji
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        @if (session('role') === 'HR')
                            <a href="{{ route('payrolls.create') }}" class="btn btn-primary mb-3 ms-auto">Tambah
                                Daftar Gaji</a>
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
                                <th>Karyawan</th>
                                <th>Gaji Pokok</th>
                                <th>Bonus</th>
                                <th>Potongan</th>
                                <th>Total Gaji</th>
                                <th>Tanggal Pembayaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payrolls as $payroll)
                                <tr>
                                    <td>{{ $payroll->employee->fullname }}</td>
                                    <td>{{ 'Rp ' . number_format($payroll->salary) }}</td>
                                    <td>{{ 'Rp ' . number_format($payroll->bonuses) }}</td>
                                    <td>{{ 'Rp ' . number_format($payroll->deductions) }}</td>
                                    <td>{{ 'Rp ' . number_format($payroll->net_salary) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($payroll->pay_date)->locale('id')->translatedFormat('d F Y') }}
                                    </td>
                                    <td>
                                        <a href="{{ route('payrolls.show', $payroll->id) }}"
                                            class="btn btn-info btn-sm me-2">Lihat Slip Gaji</a>
                                        @if (session('role') === 'HR')
                                            <a href="{{ route('payrolls.edit', $payroll->id) }}"
                                                class="btn btn-primary btn-sm me-2">Edit</a>
                                            <form action="{{ route('payrolls.destroy', $payroll->id) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus kehadiran ini?')">Hapus</button>
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
