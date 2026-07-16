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
                    <h3>Daftar Departemen</h3>
                    <p class="text-subtitle text-muted">Daftar semua departemen yang telah dibuat</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">Daftar Departemen</li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Departemen</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Formulir Data Departemen
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('departments.update', $department->id) }}" method="POST">
                        @csrf
                        @method('PUT')<!-- method untuk mengirimkan permintaan PUT ke route update atau disebut spoofing method -->
                        <div class="mb-3">
                            <label for="" class="form-label">Nama Departemen</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name', $department->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description', $department->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" name="status" id="status">
                                <option value="">Pilih Status</option>
                                <option value="aktif" {{ $department->status == 'aktif' ? 'selected' : '' }}>Aktif
                                </option>
                                <option value="tidak_aktif" {{ $department->status == 'tidak_aktif' ? 'selected' : '' }}>
                                    Tidak Aktif
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('departments.index') }}" class="btn btn-secondary">Kembali ke Daftar
                            Departemen</a>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
