@extends('comitte.master')

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
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-3 rounded bg-primary-subtle">
                                <i class="ti ti-building fs-4 text-primary"></i>
                            </div>
                            <div>
                              <p class="mb-0 text-muted">Jumlah Perusahaan</p>
                              <h3 class="fw-semibold mb-0">{{ $totalPerusahaan }}</h3>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-3 rounded bg-success-subtle">
                                <i class="ti ti-users fs-4 text-success"></i>
                            </div>
                            <div>
                              <p class="mb-0 text-muted">Jumlah Mentor</p>
                              <h3 class="fw-semibold mb-0">{{ $totalGuru }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-3 rounded bg-success-subtle">
                                <i class="ti ti-users fs-4 text-success"></i>
                            </div>
                            <div>
                                <p class="mb-0 text-muted">Siswa Presensi</p>
                                <h3 class="fw-semibold mb-0">{{$students->count()}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-3 rounded bg-success-subtle">
                                <i class="ti ti-users fs-4 text-success"></i>
                            </div>
                            <div>
                                <p class="mb-0 text-muted">Siswa Belum Presensi</p>
                                <h3 class="fw-semibold mb-0">{{$students->count()}}</h3>
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
                                <th>Perusahaan</th>
                                <th>Presensi</th>
                                <th>Aksi</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->student->std_nis }}</td>
                                    <td>{{ $item->student->user->name ?? '-' }}</td>
                                    <td>{{ $item->student->company->cmp_name ?? '-' }}</td>
                                 
                                    <td>
                                        @php
                                            $attendance = $item->student->attendanceToday;
                                        @endphp

                                        @if (!$attendance)
                                            <span class="badge bg-secondary">Belum Absen</span>
                                        @elseif ($attendance->att_status == 1)
                                            <span class="badge bg-success">Hadir</span>
                                        @elseif ($attendance->att_status == 2)
                                            <span class="badge bg-warning">Izin</span>
                                        @elseif ($attendance->att_status == 3)
                                            <span class="badge bg-info">Sakit</span>
                                        @elseif ($attendance->att_status == 4)
                                            <span class="badge bg-danger">Alpha</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                                <a href="/comitte/student-attendance/{{$item->student->std_id}}" class="btn btn-sm btn-info" title="Presensi">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                                
                                            </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Perusahaan</th>
                                <th>Presensi</th>
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
