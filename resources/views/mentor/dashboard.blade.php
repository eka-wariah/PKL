@extends('mentor.master')

@push('link')
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('title')
    SIMaput | Dashboard
@endsection

@section('content')
    <div class="datatables">
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Dashboard</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item" aria-current="page">Dashboard</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center mb-n5">
                            <img src="{{ asset('assets/images/breadcrumb/ChatBc.png') }}" alt="modernize-img"
                                class="img-fluid mb-n4" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stat Cards --}}
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-3 rounded bg-primary-subtle">
                                <i class="ti ti-book fs-4 text-primary"></i>
                            </div>
                            <div>
                                <p class="mb-0 text-muted">Jumlah Bimbingan</p>
                                <h3 class="fw-semibold mb-0">3</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-3 rounded bg-success-subtle">
                                <i class="ti ti-users fs-4 text-success"></i>
                            </div>
                            <div>
                                <p class="mb-0 text-muted">Jumlah Siswa Dibimbing</p>
                                <h3 class="fw-semibold mb-0">24</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Siswa --}}
        <div class="card">
            <div class="card-body">
                <div class="mb-4">
                    <h4 class="card-title mb-0">Daftar Siswa Bimbingan</h4>
                    <p class="text-muted small mb-0">Kehadiran hari ini: {{ now()->translatedFormat('l, d F Y') }}</p>
                </div>
                <div class="table-responsive">
                    <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Kehadiran Hari Ini</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>2024001</td>
                                <td>Ahmad Fauzi</td>
                                <td>X RPL 1</td>
                                <td>
                                    <span class="badge bg-success">Hadir</span>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info">
                                        <i class="ti ti-user"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>2024002</td>
                                <td>Budi Santoso</td>
                                <td>X RPL 1</td>
                                <td>
                                    <span class="badge bg-danger">Tidak Hadir</span>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info">
                                        <i class="ti ti-user"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>2024003</td>
                                <td>Citra Dewi</td>
                                <td>X RPL 2</td>
                                <td>
                                    <span class="badge bg-warning text-dark">Izin</span>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info">
                                        <i class="ti ti-user"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>2024004</td>
                                <td>Deni Kurniawan</td>
                                <td>X RPL 2</td>
                                <td>
                                    <span class="badge bg-info">Sakit</span>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info">
                                        <i class="ti ti-user"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>2024005</td>
                                <td>Eka Putri</td>
                                <td>X TKJ 1</td>
                                <td>
                                    <span class="badge bg-success">Hadir</span>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info">
                                        <i class="ti ti-user"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>2024006</td>
                                <td>Fajar Ramadhan</td>
                                <td>X TKJ 1</td>
                                <td>
                                    <span class="badge bg-secondary">Belum Tercatat</span>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info">
                                        <i class="ti ti-user"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Kehadiran Hari Ini</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="{{ asset('assets/js/datatable/datatable-advanced.init.js') }}"></script>
@endpush