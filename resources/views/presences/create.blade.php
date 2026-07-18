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
                    <h3>Daftar Kehadiran</h3>
                    <p class="text-subtitle text-muted">Daftar semua kehadiran yang telah direkam</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">Daftar Kehadiran</li>
                            <li class="breadcrumb-item active" aria-current="page">Buat Kehadiran</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Formulir Data Kehadiran
                    </h5>
                </div>
                <div class="card-body">
                    @if (session('role') === 'HR')
                        <form action="{{ route('presences.store') }}" method="POST">
                            @csrf
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
                            <div class="mb-3">
                                <label for="" class="form-label">Waktu Masuk</label>
                                <input type="text" class="form-control datetime" name="check_in" required>
                                @error('check_in')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Waktu Pulang</label>
                                <input type="text" class="form-control datetime" name="check_out">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Tanggal</label>
                                <input type="text" class="form-control date" name="date" required>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="">Pilih Status Kehadiran</option>
                                    <option value="hadir">Hadir</option>
                                    <option value="izin">Izin</option>
                                    <option value="sakit">Sakit</option>
                                    <option value="alpa">Alpa</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('presences.index') }}" class="btn btn-secondary">Kembali ke Daftar
                                Kehadiran</a>
                        </form>
                    @else
                        <form action="{{ route('presences.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <b>Note</b> : <i> izinkan akses lokasi pada perangkat Anda untuk merekam kehadiran.
                                    Pastikan juga koneksi internet Anda stabil.</i>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Lintang</label>
                                <input type="text" class="form-control" name="latitude" id="latitude" required>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Garis Bujur</label>
                                <input type="text" class="form-control" name="longitude" id="longitude" required>
                            </div>
                            <div class="mb-3">
                                <iframe width="500" height="300" frameborder="0" scrolling="no" marginheight="0"
                                    marginwidth="0" src=""></iframe>
                            </div>
                            <button type="submit" class="btn btn-primary" id="btn-present" disabled>Dapatkan
                                Lokasi</button>
                        </form>
                    @endif
                </div>
            </div>
        </section>
    </div>

    <script>
        const iframe = document.querySelector('iframe');

        const officeLat = -6.142244941159506; // Latitude UBS SLIPI
        const officeLng = 106.77647045659909; // Longitude UBS SLIPI
        const treshold = 0.01; // Batas jarak dalam derajat (misalnya 0.01 derajat)

        navigator.geolocation.getCurrentPosition(function(position) {
            const userLat = position.coords.latitude; // Latitude pengguna
            const userLng = position.coords.longitude; // Longitude pengguna
            iframe.src = `https://maps.google.com/maps?q=${userLat},${userLng}&hl=es;z=14&output=embed`;
        });

        document.addEventListener('DOMContentLoaded', (event) => {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const userLat = position.coords.latitude;
                    const userLng = position.coords.longitude;

                    // Set nilai latitude dan longitude ke input form
                    document.getElementById('latitude').value = userLat;
                    document.getElementById('longitude').value = userLng;

                    // Periksa apakah pengguna berada di dalam radius yang ditentukan
                    const distance = Math.sqrt(Math.pow(userLat - officeLat, 2) + Math.pow(userLng -
                        officeLng, 2));
                    if (distance <= treshold) {
                        alert('Anda berada di dalam radius yang ditentukan. Kehadiran dapat direkam.');
                        document.getElementById('btn-present').removeAttribute('disabled');
                    } else {
                        alert(
                            'Anda berada di luar radius yang ditentukan. Pastikan Anda berada di lokasi yang benar.'
                        );
                    }
                }, function(error) {
                    console.error("Error Code = " + error.code + " - " + error.message);
                });
            } else {
                alert('Geolocation tidak didukung oleh browser Anda.');
            }
        });
    </script>
@endsection
