@extends('layouts.dashboard')

@section('content')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading no-print">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Daftar Gaji</h3>
                    <p class="text-subtitle text-muted">Detail informasi dan cetak slip gaji karyawan</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="{{ route('payrolls.index') }}">Daftar
                                    Gaji</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Slip Gaji</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center no-print border-bottom">
                <h5 class="card-title mb-0">
                    Slip Gaji Karyawan
                </h5>
                <div>
                    <a href="{{ route('payrolls.index') }}" class="btn btn-secondary ">
                        Kembali ke Daftar Gaji
                    </a>
                    <button type="button" id="printButton" class="btn btn-primary ">
                        <i class="bi bi-printer"></i> Cetak Dokumen
                    </button>
                </div>
            </div>

            <div class="card-body py-5">
                <!-- Area Cetak Dimulai -->
                <div id="print-area" class="payslip-container">

                    <!-- Header Perusahaan -->
                    <div class="text-center border-bottom pb-4 mb-4">
                        <h3 class="fw-bold text-uppercase mb-1" style="letter-spacing: 1px;">PT. YAOP</h3>
                        <p class="text-muted mb-0">Human Resource Management</p>
                        <h4 class="fw-bold mt-4 mb-1 text-uppercase text-decoration-underline">Slip Gaji Karyawan</h4>
                        <p class="text-muted mb-0">
                            Periode Pembayaran:
                            {{ \Carbon\Carbon::parse($payroll->pay_date)->locale('id')->translatedFormat('F Y') }}
                        </p>
                    </div>

                    <!-- Informasi Karyawan -->
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <table class="table table-sm table-borderless mb-0 employee-info">
                                <tr>
                                    <td width="35%" class="fw-bold text-secondary">Nama Karyawan</td>
                                    <td width="5%">:</td>
                                    <td class="fw-semibold">{{ $payroll->employee->fullname }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-secondary">Departemen</td>
                                    <td>:</td>
                                    <td>{{ $payroll->employee->department->name ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm-6">
                            <table class="table table-sm table-borderless mb-0 employee-info">
                                <tr>
                                    <td width="40%" class="fw-bold text-secondary">Tgl. Pembayaran</td>
                                    <td width="5%">:</td>
                                    <td>{{ \Carbon\Carbon::parse($payroll->pay_date)->locale('id')->translatedFormat('d F Y') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-secondary">Jabatan/Posisi</td>
                                    <td>:</td>
                                    <td>{{ $payroll->employee->role->title ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Rincian Gaji -->
                    <div class="row">
                        <!-- Kolom Pendapatan -->
                        <div class="col-md-6 mb-3">
                            <div class="p-3 border rounded h-100">
                                <h6 class="fw-bold border-bottom pb-2 mb-3 text-success">PENERIMAAN</h6>
                                <table class="table table-sm table-borderless mb-0">
                                    <tr>
                                        <td>Gaji Pokok</td>
                                        <td class="text-end">Rp {{ number_format($payroll->salary, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Bonus / Tunjangan</td>
                                        <td class="text-end">Rp {{ number_format($payroll->bonuses, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <hr class="my-1">
                                        </td>
                                    </tr>
                                    <tr class="fw-bold">
                                        <td>Total Penerimaan</td>
                                        <td class="text-end">Rp
                                            {{ number_format($payroll->salary + $payroll->bonuses, 0, ',', '.') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Kolom Potongan -->
                        <div class="col-md-6 mb-3">
                            <div class="p-3 border rounded h-100">
                                <h6 class="fw-bold border-bottom pb-2 mb-3 text-danger">POTONGAN</h6>
                                <table class="table table-sm table-borderless mb-0">
                                    <tr>
                                        <td>BPJS</td>
                                        <td class="text-end">Rp {{ number_format($payroll->deductions, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <hr class="my-1">
                                        </td>
                                    </tr>
                                    <tr class="fw-bold">
                                        <td>Total Potongan</td>
                                        <td class="text-end">Rp {{ number_format($payroll->deductions, 0, ',', '.') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Gaji Bersih / Take Home Pay -->
                    <div class="take-home-pay mt-3 p-4 rounded text-center">
                        <p class="mb-1 text-muted fw-bold text-uppercase">Penerimaan Bersih (Take Home Pay)</p>
                        <h2 class="fw-bold mb-0" style="color: #2c3e50;">
                            Rp {{ number_format($payroll->net_salary, 0, ',', '.') }}
                        </h2>
                    </div>

                    <!-- Tanda Tangan -->
                    <div class="row mt-5 pt-4">
                        <div class="col-6 text-center">
                            <p class="mb-5">Diterima Oleh,</p>
                            <br><br>
                            <p class="fw-bold mb-0 text-decoration-underline">{{ $payroll->employee->fullname }}</p>
                            <p class="text-muted small">Karyawan</p>
                        </div>
                        <div class="col-6 text-center">
                            <p class="mb-5">Menyetujui,</p>
                            <br><br>
                            <p class="fw-bold mb-0 text-decoration-underline">HR Manager</p>
                            <p class="text-muted small">PT. YAOP</p>
                        </div>
                    </div>

                    <!-- Keterangan Footer Cetak -->
                    <div class="text-center mt-2 pt-2 border-top">
                        <small class="text-muted fst-italic">
                            Dokumen ini dicetak secara otomatis oleh sistem HRIS dan sah meskipun tanpa stempel basah.
                        </small>
                    </div>

                </div>
                <!-- Area Cetak Selesai -->
            </div>
        </div>
    </section>

    <!-- CSS Khusus untuk Tampilan Slip Gaji & Cetak (Print) -->
    <style>
        /* Styling Umum Kontainer Slip Gaji */
        .payslip-container {
            max-width: 850px;
            margin: 0 auto;
            background: #fff;
            color: #333;
            font-family: 'Arial', sans-serif;
        }

        .employee-info td {
            padding-bottom: 0.5rem;
        }

        .take-home-pay {
            background-color: #f8f9fa;
            border: 2px dashed #cbd5e1;
        }

        /* Aturan Khusus Saat Dokumen Dicetak (Ctrl+P) */
        @media print {
            @page {
                size: A4 portrait;
                margin: 20mm;
            }

            body {
                background: #fff !important;
            }

            /* Sembunyikan semua elemen kecuali print-area */
            body * {
                visibility: hidden;
            }

            #print-area,
            #print-area * {
                visibility: visible;
            }

            /* Posisikan print-area di ujung atas kertas */
            #print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 0;
            }

            /* Hilangkan elemen yang tidak perlu dicetak (tombol, navbar, background) */
            .no-print,
            header,
            .sidebar,
            .page-heading {
                display: none !important;
            }

            /* Format warna untuk cetakan grayscale yang tajam */
            .text-success,
            .text-danger,
            .text-primary {
                color: #000 !important;
            }

            .text-muted {
                color: #555 !important;
            }

            .take-home-pay {
                background-color: #f1f5f9 !important;
                border: 2px solid #000 !important;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }

            .card {
                border: none !important;
                box-shadow: none !important;
            }
        }
    </style>

    <!-- JavaScript untuk Tombol Cetak -->
    <script>
        document.getElementById('printButton').addEventListener('click', function() {
            window.print();
        });
    </script>
@endsection
