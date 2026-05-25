@extends('comitte.master')

@section('title')
    SiMAPUT | Import Data Guru
@endsection

@section('content')
    <div class="datatables">
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">GURU</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/comitte/mentor">Daftar Guru</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Import Data Guru</li>
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
            {{-- Form Import --}}
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Import Data Guru</h4>
                            <a href="/comitte/teacher" class="btn btn-secondary">
                                <i class="ti ti-arrow-left me-1"></i> Kembali
                            </a>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="ti ti-circle-check me-1"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="ti ti-alert-circle me-1"></i> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('comitte.teacher.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    Upload File <span class="text-danger">*</span>
                                </label>
                                <div class="border rounded p-4 text-center" id="dropZone"
                                    style="border-style: dashed !important; cursor: pointer;">
                                    <i class="ti ti-file-spreadsheet fs-1 text-success mb-2 d-block"></i>
                                    <p class="mb-1 fw-semibold">Klik untuk pilih file atau drag & drop</p>
                                    <p class="text-muted small mb-3">Format yang didukung: .xlsx, .xls, .csv</p>
                                    <input type="file" name="file" id="fileInput"
                                        class="form-control @error('file') is-invalid @enderror" accept=".xlsx,.xls,.csv"
                                        style="display: none;">
                                    <button type="button" class="btn btn-outline-success btn-sm"
                                        onclick="document.getElementById('fileInput').click()">
                                        <i class="ti ti-upload me-1"></i> Pilih File
                                    </button>
                                    @error('file')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div id="fileInfo" class="mt-2 d-none">
                                    <div class="d-flex align-items-center gap-2 p-2 bg-success-subtle rounded">
                                        <i class="ti ti-file-check text-success"></i>
                                        <span id="fileName" class="small text-success fw-semibold"></span>
                                        <button type="button" class="btn btn-sm btn-link text-danger ms-auto p-0"
                                            id="removeFile">
                                            <i class="ti ti-x"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex gap-2 justify-content-end">
                                <a href="/comitte/teacher" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-upload me-1"></i> Import Sekarang
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Panduan --}}
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="ti ti-info-circle me-1 text-info"></i> Panduan Import
                        </h5>
                        <ol class="ps-3 small text-muted">
                            <li class="mb-2">Download template Excel terlebih dahulu.</li>
                            <li class="mb-2">Isi data sesuai kolom yang tersedia.</li>
                            <li class="mb-2">Pastikan email tidak duplikat.</li>
                            <li class="mb-2">Kolom <strong>password</strong> opsional, jika kosong default
                                <code>password</code>.</li>
                            <li class="mb-2">Simpan file dalam format <strong>.xlsx</strong> atau <strong>.csv</strong>.
                            </li>
                            <li>Upload file dan klik <strong>Import Sekarang</strong>.</li>
                        </ol>

                        <hr>

                        <p class="small fw-semibold mb-2">Kolom yang diperlukan:</p>
                        <table class="table table-sm table-bordered small">
                            <thead class="table-light">
                                <tr>
                                    <th>Kolom</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>nama</code></td>
                                    <td>Nama lengkap guru</td>
                                </tr>
                                <tr>
                                    <td><code>email</code></td>
                                    <td>Email guru</td>
                                </tr>
                                <tr>
                                    <td><code>no_gtk</code></td>
                                    <td>Nomor GTK</td>
                                </tr>
                                <tr>
                                    <td><code>password</code></td>
                                    <td>Password (opsional)</td>
                                </tr>
                            </tbody>
                        </table>

                        <a href="{{ route('comitte.teacher.template') }}" class="btn btn-success w-100 mt-2">
                            <i class="ti ti-download me-1"></i> Download Template
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        const fileInput = document.getElementById('fileInput');
        const fileInfo = document.getElementById('fileInfo');
        const fileName = document.getElementById('fileName');
        const removeFile = document.getElementById('removeFile');
        const dropZone = document.getElementById('dropZone');

        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                fileName.textContent = this.files[0].name;
                fileInfo.classList.remove('d-none');
            }
        });

        removeFile.addEventListener('click', function() {
            fileInput.value = '';
            fileInfo.classList.add('d-none');
        });

        // Drag & drop
        dropZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('border-primary');
        });

        dropZone.addEventListener('dragleave', function() {
            this.classList.remove('border-primary');
        });

        dropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('border-primary');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                fileName.textContent = files[0].name;
                fileInfo.classList.remove('d-none');
            }
        });
    </script>
@endpush
