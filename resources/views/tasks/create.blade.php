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
                            <li class="breadcrumb-item active" aria-current="page">Buat Tugas</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Formulir Data Tugas
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('tasks.store') }}" method="POST">
                        @csrf
                        <!-- Judul Tugas -->
                        <div class="mb-3">
                            <label for="" class="form-label">Judul Tugas</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                                value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Ditugaskan Kepada -->
                        <div class="mb-3">
                            <label for="" class="form-label">Ditugaskan Kepada</label>
                            <select class="form-select @error('assigned_to') is-invalid @enderror" name="assigned_to"
                                required>
                                <option value="">Pilih Karyawan</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}" @if (old('assigned_to') == $employee->id) selected @endif>
                                        {{ $employee->fullname }}
                                    </option>
                                @endforeach
                            </select>
                            @error('assigned_to')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deskripsi Tugas -->
                        <div class="mb-3">
                            <label for="" class="form-label">Deskripsi Tugas</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tenggat Waktu -->
                        <div class="mb-3">
                            <label for="" class="form-label">Tenggat Waktu</label>
                            <input type="date" class="form-control date @error('due_date') is-invalid @enderror"
                                value="{{ @old('due_date') }}" name="due_date" required>
                            @error('due_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status Tugas -->
                        <div class="mb-3">
                            <label for="" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" name="status" id="status">
                                <option value="">Pilih Status</option>
                                <option value="pending">Pending</option>
                                <option value="proses">Proses</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Kembali ke Daftar Tugas</a>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
