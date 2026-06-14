@extends('mentor.master')

@push('link')
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
@endpush

@section('title')
    SIMaput | Rekap Absensi
@endsection

@section('content')
    <div class="datatables">

        {{-- Breadcrumb --}}
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Rekap Absensi Siswa</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/mentor/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Rekap Absensi</li>
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

        {{-- Summary Cards --}}
        @php
            $hadir = collect($report)->where('status', 1)->count();
            $izin = collect($report)->where('status', 2)->count();
            $sakit = collect($report)->where('status', 3)->count();
            $alpha = collect($report)->filter(fn($r) => !in_array($r['status'], [1, 2, 3]))->count();
        @endphp

        <div class="row mb-4">
            <div class="col-6 col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-3 rounded bg-success-subtle">
                                <i class="ti ti-circle-check fs-4 text-success"></i>
                            </div>
                            <div>
                                <p class="mb-0 text-muted small">Hadir</p>
                                <h3 class="fw-semibold mb-0 text-success">{{ $hadir }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-3 rounded bg-info-subtle">
                                <i class="ti ti-file-description fs-4 text-info"></i>
                            </div>
                            <div>
                                <p class="mb-0 text-muted small">Izin</p>
                                <h3 class="fw-semibold mb-0 text-info">{{ $izin }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-3 rounded bg-warning-subtle">
                                <i class="ti ti-heart-rate-monitor fs-4 text-warning"></i>
                            </div>
                            <div>
                                <p class="mb-0 text-muted small">Sakit</p>
                                <h3 class="fw-semibold mb-0 text-warning">{{ $sakit }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-3 rounded bg-danger-subtle">
                                <i class="ti ti-circle-x fs-4 text-danger"></i>
                            </div>
                            <div>
                                <p class="mb-0 text-muted small">Alpha</p>
                                <h3 class="fw-semibold mb-0 text-danger">{{ $alpha }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel --}}
        <div class="card">
            <div class="card-body">
                <div class="mb-4">
                    <h4 class="card-title mb-0">Detail Absensi {{ $student->user->name }}</h4>
                    <p class="text-muted small mb-0">{{ now()->translatedFormat('l, d F Y') }}</p>
                </div>
                <div class="table-responsive">
                    <table id="table_absensi" class="table w-100 table-striped table-bordered display text-nowrap">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Tanggal</th>
                                <th>Hari</th>
                                <th>Status</th>
                                <th>Waktu Masuk</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($report as $row)
                                @php
                                    $hari = \Carbon\Carbon::createFromFormat('d-m-Y', $row['date'])
                                        ->locale('id')
                                        ->translatedFormat('l');
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration ?? '-' }}</td>
                                    <td>{{ $row['date'] ?? '-' }}</td>
                                    <td>{{ $hari ?? '-' }}</td>
                                    <td>
                                        @if ($row['status'] == 1)
                                            <span class="badge bg-success">Hadir</span>
                                        @elseif ($row['status'] == 2)
                                            <span class="badge bg-info">Izin</span>
                                        @elseif ($row['status'] == 3)
                                            <span class="badge bg-warning">Sakit</span>
                                        @else
                                            <span class="badge bg-danger">Alpha</span>
                                        @endif
                                    </td>
                                    <td>{{ $row['time'] ?? '—' }}</td>
                                    <td>


                                        @if ($row['status'] == 1)
                                            <button type="button" class="btn btn-sm btn-primary preview-image"
                                                data-bs-toggle="modal" data-bs-target="#imageModal"
                                                data-image="{{ Storage::url($row['photo']) }}"
                                                data-download="/mentor/student-attendance/{{ $row['att_id'] }}/download">
                                                <i class="ti ti-photo"></i>
                                            </button>

                                            @if ($row['latitude'] && $row['longitude'])
                                                <button type="button" class="btn btn-sm btn-success preview-map"
                                                    data-bs-toggle="modal" data-bs-target="#mapModal"
                                                    data-lat="{{ $row['latitude'] }}" data-lng="{{ $row['longitude'] }}"
                                                    data-address="{{ $row['address'] ?? '-' }}">
                                                    <i class="ti ti-map-pin"></i>
                                                </button>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">Belum ada data absensi</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Hari</th>
                                <th>Status</th>
                                <th>Waktu Masuk</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>


    <div class="modal fade" id="imageModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        Preview Foto Bimbingan
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body text-center">

                    <img id="previewImage" src="" class="img-fluid rounded shadow" style="max-height:700px;">

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Kembali
                    </button>

                    <a href="#" id="downloadBtn" class="btn btn-success">
                        <i class="ti ti-download"></i>
                        Download
                    </a>

                </div>

            </div>
        </div>
    </div>
    {{-- modal map --}}
    <div class="modal fade" id="mapModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="ti ti-map-pin me-1 text-success"></i> Lokasi Presensi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    {{-- Info Alamat --}}
                    <div class="px-3 py-2 bg-light border-bottom d-flex align-items-center gap-2">
                        <i class="ti ti-home text-muted"></i>
                        <small id="mapAddress" class="text-muted">-</small>
                    </div>
                    {{-- Map --}}
                    <div id="mapContainer" style="height: 420px; width: 100%;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <a href="#" id="btnGoogleMaps" target="_blank" class="btn btn-success">
                        <i class="ti ti-brand-google-maps me-1"></i> Buka di Google Maps
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatable-advanced.init.js') }}"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        $('#table_absensi').DataTable({
            responsive: true,
            order: [],
        });

        $('.preview-image').click(function() {
            let image    = $(this).data('image');
            let download = $(this).data('download');
            $('#previewImage').attr('src', image);
            $('#downloadBtn').attr('href', download);
        });

        // map
        let mapLat = null;
        let mapLng = null;
        let mapInstance = null;

        $(document).on('click', '.preview-map', function() {
            mapLat = parseFloat($(this).data('lat'));
            mapLng = parseFloat($(this).data('lng'));
            const address = $(this).data('address');

            $('#mapAddress').text(address);
            $('#btnGoogleMaps').attr('href', `https://www.google.com/maps?q=${mapLat},${mapLng}`);
        });

        $('#mapModal').on('shown.bs.modal', function() {
            if (mapInstance) {
                mapInstance.remove();
                mapInstance = null;
            }

            mapInstance = L.map('mapContainer').setView([mapLat, mapLng], 16);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(mapInstance);

            L.marker([mapLat, mapLng])
                .addTo(mapInstance)
                .bindPopup(`<b>Lokasi Presensi</b><br>${$('#mapAddress').text()}`)
                .openPopup();
        });

        $('#mapModal').on('hidden.bs.modal', function() {
            if (mapInstance) {
                mapInstance.remove();
                mapInstance = null;
            }
        });
    </script>
@endpush
