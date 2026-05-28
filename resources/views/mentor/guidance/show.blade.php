@extends('mentor.master')

@section('title')
    SiMAPUT | Detail Bimbingan
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
                                <li class="breadcrumb-item">
                                    <a href="/mentor/bimbingan">Daftar Bimbingan</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Detail Bimbingan</li>
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

        <div class="row">
            {{-- Informasi Bimbingan --}}
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Detail Bimbingan</h4>
                            <div class="d-flex gap-2">
                                <a href=""
                                    class="btn btn-warning btn-sm">
                                    <i class="ti ti-edit me-1"></i> Edit
                                </a>
                                <a href="/mentor/bimbingan" class="btn btn-secondary btn-sm">
                                    <i class="ti ti-arrow-left me-1"></i> Kembali
                                </a>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td width="35%" class="fw-semibold text-muted">Minggu Ke</td>
                                        <td>: {{ $news->news_week_number }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-muted">Tanggal</td>
                                        <td>: {{ \Carbon\Carbon::parse($news->news_date)->translatedFormat('l, d F Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-muted">Jam</td>
                                        <td>: {{ \Carbon\Carbon::parse($news->news_start)->format('H:i') }} —
                                            {{ \Carbon\Carbon::parse($news->news_ended)->format('H:i') }} WIB</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-muted">Mentor</td>
                                        <td>: {{ $news->mentor->user->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-muted">Tahun Akademik</td>
                                        <td>: {{ $news->academicYear->acy_year." - ".$news->academicYear->acy_year+1 ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-muted">Jenis</td>
                                        <td>:
                                            @if ($news->news_parent_id)
                                                <span class="badge bg-warning text-dark">Susulan</span>
                                            @else
                                                <span class="badge bg-primary">Reguler</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <p class="fw-semibold mb-1">Isi Bimbingan</p>
                            <div class="p-3 bg-light rounded">
                                {{ $news->news_guidance_material ?? '-' }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <p class="fw-semibold mb-1">Kendala</p>
                            <div class="p-3 bg-light rounded">
                                {{ $news->news_problem ?? '-' }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <p class="fw-semibold mb-1">Catatan</p>
                            <div class="p-3 bg-light rounded">
                                {{ $news->news_note ?? '-' }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Siswa Hadir --}}
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="ti ti-users me-1 text-primary"></i>
                            Siswa Hadir
                            <span class="badge bg-primary ms-1">{{ $news->participants->count() ." / ". $totalMentee  }}</span>
                        </h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($news->participants as $key => $participant)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $participant->student->std_nis ?? '-' }}</td>
                                            <td>{{ $participant->student->user->name ?? '-' }}</td>
                                            <td>{{ $participant->student->class->cls_level ." ". $participant->student->class->cls_major->mjr_name." ". $participant->student->class->cls_number ?? '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Tidak ada siswa hadir.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-md-4">
                {{-- Foto Dokumentasi --}}
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="ti ti-photo me-1 text-primary"></i> Foto Dokumentasi
                        </h5>
                        @if ($news->news_image)
                            <img src="{{ Storage::url($news->news_image) }}"
                                alt="Foto Dokumentasi"
                                class="img-fluid rounded w-100"
                                style="max-height: 300px; object-fit: cover; cursor: pointer;"
                                onclick="bukaFoto(this.src)">
                            <small class="text-muted d-block mt-2 text-center">Klik foto untuk memperbesar.</small>
                        @else
                            <div class="text-center text-muted py-4">
                                <i class="ti ti-photo-off fs-1 mb-2 d-block"></i>
                                <span>Tidak ada foto dokumentasi.</span>
                            </div>
                        @endif
                    </div>
                </div>

                
            </div>
        </div>
    </div>

    {{-- Modal foto --}}
    <div class="modal fade" id="modalFoto" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Foto Dokumentasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center p-2">
                    <img id="modalFotoImg" src="" alt="foto" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function bukaFoto(src) {
            document.getElementById('modalFotoImg').src = src;
            new bootstrap.Modal(document.getElementById('modalFoto')).show();
        }
    </script>
@endpush