@extends('comitte.master')

@push('link')
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
@endpush

@section('title')
    SiMAPUT | Tambah Guru
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
                                <li class="breadcrumb-item active" aria-current="page">Tambah Guru</li>
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

        <div class="card">
            <div class="card-body">
                <div class="mb-4 position-relative">
                    <h4 class="card-title mb-0">Tambah Guru</h4>
                    <a href="/comitte/teacher" class="btn btn-secondary position-absolute top-0 end-0">
                        <i class="ti ti-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('comitte.student.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label fw-semibold">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="name" name="name" value="{{ old('name') }}"
                                placeholder="Masukkan nama lengkap">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="std_nis" class="form-label fw-semibold">
                                NIS <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('std_nis') is-invalid @enderror"
                                id="std_nis" name="std_nis" value="{{ old('std_nis') }}"
                                placeholder="Masukkan nomor Induk Siswa">
                            @error('mtr_gtk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="std_nisn" class="form-label fw-semibold">
                                NISN <span class="text-danger">*</span>
                            </label>
                            <input type="std_nisn" class="form-control @error('std_nisn') is-invalid @enderror"
                                id="std_nisn" name="std_nisn" value="{{ old('std_nisn') }}"
                                placeholder="Masukkan NISN">
                            @error('std_nisn')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="std_classes_id" class="form-label fw-semibold">
                                Kelas <span class="text-danger">*</span>
                            </label>
                            <select class="form-select mr-sm-2"  name="std_classes_id"
                                    oninvalid="this.setCustomValidity('Kelas wajib diisi')"
                                    onchange="this.setCustomValidity('')" required>
                                    <option selected value="">Pilih...</option>
                                    @foreach ($class as $cls)
                                        <option value="{{ $cls->cls_id }}">{{ $cls->cls_level }} {{ $cls->cls_major->mjr_abbr }} {{ $cls->cls_number }}</option>
                                    @endforeach
                                </select>
                            @error('std_classes_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="std_nickname" class="form-label fw-semibold">
                                Nickname <span class="text-danger">*</span>
                            </label>
                            <input type="std_nickname" class="form-control @error('std_nickname') is-invalid @enderror"
                                id="std_nickname" name="std_nickname" value="{{ old('std_nickname') }}"
                                placeholder="Masukkan email">
                            @error('std_nickname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="std_company_id" class="form-label fw-semibold">
                                Perusahaan <span class="text-danger">*</span>
                            </label>
                            <select class="form-select mr-sm-2"  name="std_company_id">
                                    <option selected value="">Pilih...</option>
                                    @foreach ($company as $cmp)
                                        <option value="{{ $cmp->cmp_id }}">{{ $cmp->cmp_name }}</option>
                                    @endforeach
                                </select>
                            @error('std_company_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label fw-semibold">
                                Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ old('email') }}"
                                placeholder="Masukkan email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label fw-semibold">
                                Password <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="Masukkan password">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="ti ti-eye" id="eyeIcon"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> 

                         <div class="col-md-6 mb-4">
                            <label for="password_confirmation" class="form-label fw-semibold">
                                Konfirmasi Password <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="password"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    id="password_confirmation" name="password_confirmation"
                                    placeholder="Ulangi password">
                                <button class="btn btn-outline-secondary" type="button" id="toggleConfirm">
                                    <i class="ti ti-eye" id="eyeIconConfirm"></i>
                                </button>
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="/comitte/teacher" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('ti-eye', 'ti-eye-off');
            } else {
                input.type = 'password';
                icon.classList.replace('ti-eye-off', 'ti-eye');
            }
        });

        document.getElementById('toggleConfirm').addEventListener('click', function() {
            const input = document.getElementById('password_confirmation');
            const icon = document.getElementById('eyeIconConfirm');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('ti-eye', 'ti-eye-off');
            } else {
                input.type = 'password';
                icon.classList.replace('ti-eye-off', 'ti-eye');
            }
        });
    </script>
@endpush