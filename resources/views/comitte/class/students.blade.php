@extends('comitte.master')

@push('link')
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('title')
    SiMAPUT | Daftar Siswa Kelas {{ $class->cls_code }}
@endsection

@section('content')
    <div class="datatables">

        {{-- Breadcrumb Header --}}
        <div class="card bg-success-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">DAFTAR SISWA</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="/comitte/classes">Daftar
                                        Kelas</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Siswa Kelas {{ $class->cls_code }}
                                </li>
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

        {{-- Info Cards --}}
        <div class="row mb-4">
            <div class="col-sm-6 col-xl-3">
                <div class="card overflow-hidden rounded-2">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="p-2 bg-primary-subtle rounded-2 d-flex align-items-center justify-content-center"
                                style="width:42px;height:42px">
                                <i class="ti ti-school text-primary fs-5"></i>
                            </div>
                            <span class="fw-semibold text-dark fs-4">{{ $class->cls_code }}</span>
                        </div>
                        <p class="mb-0 fs-2 text-muted">Kode Kelas</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card overflow-hidden rounded-2">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="p-2 bg-warning-subtle rounded-2 d-flex align-items-center justify-content-center"
                                style="width:42px;height:42px">
                                <i class="ti ti-building text-warning fs-5"></i>
                            </div>
                            <span class="fw-semibold text-dark fs-4">{{ $class->cls_major->mjr_abbr ?? '-' }}</span>
                        </div>
                        <p class="mb-0 fs-2 text-muted">Jurusan</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card overflow-hidden rounded-2">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="p-2 bg-info-subtle rounded-2 d-flex align-items-center justify-content-center"
                                style="width:42px;height:42px">
                                <i class="ti ti-user-check text-info fs-5"></i>
                            </div>
                            <span class="fw-semibold text-dark fs-4">{{ $class->cls_homeroom->usr_name ?? '-' }}</span>
                        </div>
                        <p class="mb-0 fs-2 text-muted">Wali Kelas</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card overflow-hidden rounded-2">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="p-2 bg-success-subtle rounded-2 d-flex align-items-center justify-content-center"
                                style="width:42px;height:42px">
                                <i class="ti ti-users text-success fs-5"></i>
                            </div>
                            <span class="fw-semibold text-dark fs-4">{{ $class->students->count() }}</span>
                        </div>
                        <p class="mb-0 fs-2 text-muted">Total Siswa</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Siswa --}}
        <div class="card">
            <div class="card-body">
                <div class="mb-4 position-relative d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="card-title mb-1">Siswa Kelas {{ $class->cls_code }}</h4>
                        <p class="text-muted fs-2 mb-0">Tingkat {{ $class->cls_level }} &mdash;
                            {{ $class->cls_major->mjr_name ?? '-' }}</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="/comitte/classes" class="btn btn-light">
                            <i class="ti ti-arrow-left me-1"></i> Kembali
                        </a>
                        <a href="/comitte/classes/{{ $class->cls_id }}/students/create" class="btn btn-primary">
                            <i class="ti ti-user-plus me-1"></i> Tambah Siswa
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                {{-- <th width="15%">Aksi</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($class->students as $no => $student)
                                <tr>
                                    <td>{{ $no + 1 }}</td>
                                    <td>{{ $student->std_nis }}</td>
                                    <td>{{ $student->user->usr_name }}</td>
                                    <td>
                                        @if ($student->biodata->stb_gender == 1)
                                            Laki-laki
                                        @else
                                            Perempuan
                                        @endif
                                    </td>
                                    


                                </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <th width="5%">No</th>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                {{-- <th width="15%">Aksi</th> --}}
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
    <script src="{{ asset('assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="{{ asset('assets/js/datatable/datatable-advanced.init.js') }}"></script>
@endpush
