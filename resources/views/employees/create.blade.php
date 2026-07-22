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
                    <p class="text-subtitle text-muted">Daftar semua karyawan yang terdaftar</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('employees.index') }}">Daftar
                                    Karyawan</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Buat Karyawan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Formulir Data Karyawan
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('employees.store') }}" method="POST">
                        @csrf
                        <!-- Nama Lengkap -->
                        <div class="mb-3">
                            <label for="" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="fullname" required>
                            @error('fullname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Password Akun Karyawan -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password Awal Akun</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" required>
                            <small class="text-muted">Password minimal 8 karakter.</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" name="password_confirmation" required>
                        </div>
                        <!-- Nomor Telepon -->
                        <div class="mb-3">
                            <label for="" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" name="phone_number" required>
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Alamat -->
                        <div class="mb-3">
                            <label for="" class="form-label">Alamat</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" name="address" required></textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Tanggal Lahir -->
                        <div class="mb-3">
                            <label for="" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control date" name="birth_date" required>
                            @error('birth_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Tanggal Bergabung -->
                        <div class="mb-3">
                            <label for="" class="form-label">Tanggal Bergabung</label>
                            <input type="date" class="form-control date" name="hire_date" required>
                            @error('hire_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Departemen -->
                        <div class="mb-3">
                            <label for="" class="form-label">Departemen</label>
                            <select class="form-select @error('department_id') is-invalid @enderror" name="department_id"
                                required>
                                <option value="">Pilih Departemen</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Peran -->
                        <div class="mb-3">
                            <label for="" class="form-label">Peran</label>
                            <select class="form-select @error('role_id') is-invalid @enderror" name="role_id" required>
                                <option value="">Pilih Peran</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->title }}</option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Status -->
                        <div class="mb-3">
                            <label for="" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="aktif">Aktif</option>
                                <option value="tidak_aktif">Tidak Aktif</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Gaji -->
                        <div class="mb-3">
                            <label for="" class="form-label">Gaji</label>
                            <input type="number" class="form-control" name="salary" required>
                            @error('salary')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('employees.index') }}" class="btn btn-secondary">Kembali ke Daftar Karyawan</a>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
