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
                    <p class="text-subtitle text-muted">Detail gaji karyawan</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">Daftar Gaji</li>
                            <li class="breadcrumb-item active" aria-current="page">Lihat Slip Gaji</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Slip Gaji Karyawan
                    </h5>
                </div>
                <div class="card-body">
                    <div id="print-area">
                        <div class="mb-3">
                            <label for="" class="form-label fw-bold">Karyawan</label>
                            <input type="text" class="form-control" value="{{ $payroll->employee->fullname }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label fw-bold">Gaji Pokok</label>
                            <input type="text" class="form-control"
                                value="{{ 'Rp ' . number_format($payroll->salary, 0, ',', '.') }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label fw-bold">Bonus</label>
                            <input type="text" class="form-control"
                                value="{{ 'Rp ' . number_format($payroll->bonuses, 0, ',', '.') }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label fw-bold">Potongan</label>
                            <input type="text" class="form-control"
                                value="{{ 'Rp ' . number_format($payroll->deductions, 0, ',', '.') }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label fw-bold">Total Gaji</label>
                            <input type="text" class="form-control"
                                value="{{ 'Rp ' . number_format($payroll->net_salary, 0, ',', '.') }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label fw-bold">Tanggal Pembayaran</label>
                            <!-- Menggunakan Carbon untuk memformat tanggal pembayaran menjadi format tanggal indonesia yang lebih mudah dibaca -->
                            <input type="text" class="form-control"
                                value="{{ \Carbon\Carbon::parse($payroll->pay_date)->locale('id')->translatedFormat('d F Y') }}"
                                readonly>
                        </div>
                    </div>
                    <a href="{{ route('payrolls.index') }}" class="btn btn-secondary">Kembali ke Daftar Gaji</a>
                    <button type="button" id="printButton" class="btn btn-primary"><span class="bi bi-printer"></span>
                        Cetak</button>
                </div>
            </div>
        </section>
    </div>

    <!-- CSS untuk mengatur tampilan saat mencetak -->
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #print-area,
            #print-area * {
                visibility: visible;
            }

            #print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>

    <!-- JavaScript untuk menangani tombol cetak -->
    <script>
        document.getElementById('printButton').addEventListener('click', function() {
            window.print();
        });
    </script>
@endsection
