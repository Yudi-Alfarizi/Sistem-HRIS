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
                            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('payrolls.index') }}">Daftar
                                    Gaji</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Daftar Gaji</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Formulir Data Gaji
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
                    <form action="{{ route('payrolls.update', $payroll->id) }}" method="POST">
                        @csrf
                        @method('PUT')<!-- method untuk mengirimkan permintaan PUT ke route update atau disebut spoofing method -->
                        <div class="mb-3">
                            <label for="" class="form-label">Karyawan</label>
                            <select type="text" class="form-select" name="employee_id" required>
                                <option value="">Pilih Karyawan</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}"
                                        {{ $employee->id == $payroll->employee_id ? 'selected' : '' }}>
                                        {{ $employee->fullname }}
                                    </option>
                                @endforeach
                            </select>
                            @error('employee_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Gaji Pokok</label>
                            <input type="number" class="form-control" name="salary"
                                value="{{ old('salary', $payroll->salary) }}" required>
                            @error('salary')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Bonus</label>
                            <input type="number" class="form-control" name="bonuses"
                                value="{{ old('bonuses', $payroll->bonuses) }}" required>
                            @error('bonuses')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Potongan</label>
                            <input type="number" class="form-control" name="deductions"
                                value="{{ old('deductions', $payroll->deductions) }}" required>
                            @error('deductions')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Tanggal Pembayaran</label>
                            <input type="text" class="form-control date" name="pay_date"
                                value="{{ old('pay_date', $payroll->pay_date) }}" required>
                            @error('pay_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('payrolls.index') }}" class="btn btn-secondary">Kembali ke Daftar
                            Gaji</a>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
