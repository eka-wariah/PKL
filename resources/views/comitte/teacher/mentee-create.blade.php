@extends('comitte.master')

@push('link')
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
@endpush

@section('title')
    SiMAPUT | Tambah Mentee
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
                                    <a href="/comitte/teacher">Daftar Guru</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="/comitte/teacher/{{ $mentor->mtr_id }}/mentee">Siswa Bimbingan</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Tambah Mentee</li>
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
                <div class="mb-4 d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">
                        Tambah Mentee — {{ $mentor->user->name }}
                    </h4>
                    <a href="/comitte/teacher/{{ $mentor->user->usr_id }}/mentee" class="btn btn-secondary">
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

                <form action="{{ route('comitte.teacher.mentee.store', $mentor->mtr_id) }}" method="POST">
                    @csrf

                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="mb-4">
                                <label for="students" class="form-label fw-semibold">
                                    Pilih Siswa <span class="text-danger">*</span>
                                </label>
                                <select class="form-control @error('students') is-invalid @enderror"
                                    id="students" name="students[]" multiple>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->std_id }}"
                                            {{ in_array($student->std_id, old('students', [])) ? 'selected' : '' }}>
                                            {{ $student->user->name }} — {{ $student->std_nis ?? 'NIS belum diisi' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('students')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Bisa pilih lebih dari satu siswa.</small>
                            </div>

                            <div class="d-flex gap-2 justify-content-end">
                                <a href="/comitte/teacher/{{ $mentor->mtr_id }}/mentee" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy me-1"></i> Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('#students').select2({
            theme: 'bootstrap-5',
            placeholder: 'Cari dan pilih siswa...',
            allowClear: true,
        });
    </script>
@endpush