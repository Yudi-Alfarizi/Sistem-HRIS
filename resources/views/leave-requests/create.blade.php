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
                            <li class="breadcrumb-item active" aria-current="page">Buat Permohonan Cuti</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Buat Daftar Permohonan Cuti
                    </h5>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('leave-requests.store') }}" method="POST">
                        @csrf
                        @if (session('role') === 'HR')
                            <div class="mb-3">
                                <label for="" class="form-label">Karyawan</label>
                                <select type="text" class="form-select" name="employee_id" required>
                                    <option value="">Pilih Karyawan</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->fullname }}</option>
                                    @endforeach
                                </select>
                                @error('employee_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif
                        <div class="mb-3">
                            <label for="" class="form-label">Jenis Cuti</label>
                            <select type="text" class="form-select" name="leave_type" required>
                                <option value="">Pilih Jenis Cuti</option>
                                <option value="Cuti Tahunan">Cuti Tahunan</option>
                                <option value="Cuti Sakit">Cuti Sakit</option>
                                <option value="Cuti Melahirkan">Cuti Melahirkan</option>
                            </select>
                            @error('leave_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control date" name="start_date" required>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control date" name="end_date" required>
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('leave-requests.index') }}" class="btn btn-secondary">Kembali ke Daftar
                            Cuti</a>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
