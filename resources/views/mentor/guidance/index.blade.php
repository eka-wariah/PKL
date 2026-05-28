@extends('mentor.master')

@push('link')
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('title')
    SiMAPUT | Daftar Bimbingan
@endsection

@section('content')
    <div class="datatables">
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">BIMBINGAN</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active" aria-current="page">Daftar Bimbingan</li>
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

        {{-- Tab Switch --}}
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs nav-bordered mb-4" id="bimbinganTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active d-flex align-items-center gap-2" id="reguler-tab"
                            data-bs-toggle="tab" data-bs-target="#reguler" type="button" role="tab">
                            <i class="ti ti-book"></i> Bimbingan Reguler
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link d-flex align-items-center gap-2" id="susulan-tab"
                            data-bs-toggle="tab" data-bs-target="#susulan" type="button" role="tab">
                            <i class="ti ti-book-2"></i> Bimbingan Susulan
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="bimbinganTabContent">

                    {{-- Tab Reguler --}}
                    <div class="tab-pane fade show active" id="reguler" role="tabpanel">
                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Daftar Bimbingan Reguler</h5>
                            <a href="/mentor/guidance/create" class="btn btn-primary btn-sm">
                                <i class="ti ti-plus me-1"></i> Tambah Bimbingan
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table id="table_reguler"
                                class="table w-100 table-striped table-bordered display text-nowrap">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Nama Bimbingan</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  
                                    

                                    @foreach ($news as $no=>$news)
                                        <tr>
                                        <td>{{$loop->iteration ??' -'}}</td>
                                        <td>{{$news->news_week_number ?? '-'}}</td>
                                        <td>{{$news->news_date?? '-'}}</td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="/mentor/guidance/{{$news->news_id}}/show" class="btn btn-sm btn-info" title="Detail">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                                <a href="#" class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="ti ti-edit"></i>
                                                </a>
                                                <a href="#" class="btn btn-sm btn-secondary"
                                                    title="Buat Bimbingan Susulan">
                                                    <i class="ti ti-calendar-plus"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger" title="Hapus"
                                                    onclick="confirmDelete(1)">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Bimbingan</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    {{-- Tab Susulan --}}
                    <div class="tab-pane fade" id="susulan" role="tabpanel">
                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Daftar Bimbingan Susulan</h5>
                            <a href="#" class="btn btn-primary btn-sm">
                                <i class="ti ti-plus me-1"></i> Tambah Susulan
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table id="table_susulan"
                                class="table w-100 table-striped table-bordered display text-nowrap">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Nama Bimbingan</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     @foreach ($newsFollowUp as $no=>$news)
                                        <tr>
                                        <td>{{$loop->iteration ??' -'}}</td>
                                        <td>{{$news->newsParent->news_week_number ?? '-'}}</td>
                                        <td>{{$news->news_date?? '-'}}</td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="#" class="btn btn-sm btn-info" title="Detail">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                                <a href="#" class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="ti ti-edit"></i>
                                                </a>
                                                <a href="#" class="btn btn-sm btn-secondary"
                                                    title="Buat Bimbingan Susulan">
                                                    <i class="ti ti-calendar-plus"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger" title="Hapus"
                                                    onclick="confirmDelete(1)">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Bimbingan</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

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

    <script>
        $(document).ready(function() {
            $('#table_reguler').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                buttons: ['excel', 'pdf', 'print'],
            });

            // inisiasi tabel susulan saat tab diklik
            $('#susulan-tab').on('shown.bs.tab', function() {
                if (!$.fn.DataTable.isDataTable('#table_susulan')) {
                    $('#table_susulan').DataTable({
                        responsive: true,
                        dom: 'Bfrtip',
                        buttons: ['excel', 'pdf', 'print'],
                    });
                }
            });
        });

        function confirmDelete(id) {
            if (confirm('Yakin ingin menghapus data ini?')) {
                // arahkan ke route delete
                window.location.href = `/mentor/bimbingan/${id}/delete`;
            }
        }
    </script>
@endpush