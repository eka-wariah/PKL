@extends('mentor.master')

@push('link')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
@endpush

@section('title')
    SiMAPUT | Tambah Bimbingan
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
                                <li class="breadcrumb-item active" aria-current="page">Tambah Bimbingan</li>
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
                    <h4 class="card-title mb-0">Tambah Bimbingan</h4>
                    <a href="/mentor/bimbingan" class="btn btn-secondary">
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

                <form action="/mentor/guidance/{{$news->news_id}}/follow-up" method="POST">
                    @csrf
                    <input type="hidden" name="news_parent_id" value="{{$news->news_id}}">

                    {{-- Minggu & Jam --}}
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Bimbingan Minggu Ke</label>
                            <input type="number" class="form-control bg-light"
                                name="news_week_number" value="{{ $news->news_week_number }}" readonly>
                            <small class="text-muted">Dihitung otomatis oleh sistem.</small>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                Jam Mulai <span class="text-danger">*</span>
                            </label>
                            <input type="time" class="form-control @error('news_start') is-invalid @enderror"
                                name="news_start" value="{{ old('news_start') }}">
                            @error('news_start')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                Jam Selesai <span class="text-danger">*</span>
                            </label>
                            <input type="time" class="form-control @error('news_ended') is-invalid @enderror"
                                name="news_ended" value="{{ old('news_ended') }}">
                            @error('news_ended')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Siswa Hadir --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Siswa Hadir <span class="text-danger">*</span>
                        </label>
                        <select class="form-control @error('siswa_hadir') is-invalid @enderror"
                            name="siswa_hadir[]" id="siswaHadir" multiple>
                            @foreach ($students as $student)
                                <option value="{{ $student->std_id }}"
                                    {{ in_array($student->std_id, old('siswa_hadir', [])) ? 'selected' : '' }}>
                                    {{ $student->user->name }} — {{ $student->std_nis ?? 'NIS belum diisi' }}
                                </option>
                            @endforeach
                        </select>
                        @error('siswa_hadir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Bisa pilih lebih dari satu siswa.</small>
                    </div>

                    {{-- Foto Dokumentasi --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Foto Dokumentasi</label>
                        <div class="border rounded p-3 bg-light">

                            <video id="kameraPreview" class="w-100 rounded mb-2" autoplay playsinline
                                style="display:none; max-height: 320px; object-fit: cover;"></video>

                            <div id="fotoPreviewWrapper" style="display:none;" class="mb-2">
                                <img id="fotoPreview" src="" class="img-fluid rounded"
                                    style="max-height: 320px; object-fit: cover; width: 100%;">
                            </div>

                            <div id="fotoPlaceholder"
                                class="flex-column align-items-center justify-content-center text-muted rounded"
                                style="height: 180px; border: 2px dashed #ccc; background: #fff; display: flex;">
                                <i class="ti ti-camera fs-1 mb-2"></i>
                                <span>Belum ada foto</span>
                            </div>

                            <canvas id="fotoCanvas" style="display:none;"></canvas>

                            <input type="hidden" name="news_image" id="fotoDokumentasi">

                            <div class="d-flex gap-2 mt-3">
                                <button type="button" class="btn btn-outline-primary" id="btnBukaKamera">
                                    <i class="ti ti-camera me-1"></i> Buka Kamera
                                </button>
                                <button type="button" class="btn btn-success" id="btnAmbilFoto" style="display:none;">
                                    <i class="ti ti-aperture me-1"></i> Ambil Foto
                                </button>
                                <button type="button" class="btn btn-outline-danger" id="btnRetake" style="display:none;">
                                    <i class="ti ti-refresh me-1"></i> Ulangi
                                </button>
                            </div>

                            <small class="text-muted d-block mt-2">Foto dokumentasi kegiatan bimbingan (opsional).</small>
                        </div>
                    </div>

                    {{-- Isi Bimbingan --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Isi Bimbingan <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control @error('news_guidance_material') is-invalid @enderror"
                            name="news_guidance_material" rows="4"
                            placeholder="Tuliskan isi/materi bimbingan...">{{ old('news_guidance_material') }}</textarea>
                        @error('news_guidance_material')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kendala --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kendala</label>
                        <textarea class="form-control @error('news_problem') is-invalid @enderror"
                            name="news_problem" rows="3"
                            placeholder="Tuliskan kendala yang dihadapi (jika ada)...">{{ old('news_problem') }}</textarea>
                        @error('news_problem')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Catatan --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Catatan</label>
                        <textarea class="form-control @error('news_note') is-invalid @enderror"
                            name="news_note" rows="3"
                            placeholder="Tuliskan catatan tambahan (jika ada)...">{{ old('news_note') }}</textarea>
                        @error('news_note')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="/mentor/bimbingan" class="btn btn-secondary">Batal</a>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#siswaHadir').select2({
                theme: 'bootstrap-5',
                placeholder: 'Cari dan pilih siswa yang hadir...',
                allowClear: true,
            });
        });
    </script>
    <script>
        let kameraStream = null;

        const video       = document.getElementById('kameraPreview');
        const canvas      = document.getElementById('fotoCanvas');
        const preview     = document.getElementById('fotoPreview');
        const placeholder = document.getElementById('fotoPlaceholder');
        const previewWrap = document.getElementById('fotoPreviewWrapper');
        const inputFoto   = document.getElementById('fotoDokumentasi');
        const btnBuka     = document.getElementById('btnBukaKamera');
        const btnAmbil    = document.getElementById('btnAmbilFoto');
        const btnRetake   = document.getElementById('btnRetake');

        btnBuka.addEventListener('click', async function() {
            try {
                kameraStream = await navigator.mediaDevices.getUserMedia({
                    video: { facingMode: 'environment' }
                });
                video.srcObject = kameraStream;
                video.style.display      = 'block';
                placeholder.style.display = 'none';
                previewWrap.style.display = 'none';
                btnBuka.style.display    = 'none';
                btnAmbil.style.display   = 'inline-block';
            } catch (err) {
                alert('Tidak bisa mengakses kamera.');
                console.error(err);
            }
        });

        btnAmbil.addEventListener('click', function() {
            canvas.width  = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0);

            const base64   = canvas.toDataURL('image/jpeg', 0.85);
            inputFoto.value = base64;
            preview.src     = base64;

            kameraStream.getTracks().forEach(t => t.stop());
            video.style.display       = 'none';
            previewWrap.style.display = 'block';
            btnAmbil.style.display    = 'none';
            btnRetake.style.display   = 'inline-block';
        });

        btnRetake.addEventListener('click', function() {
            inputFoto.value           = '';
            preview.src               = '';
            previewWrap.style.display = 'none';
            placeholder.style.display = 'flex';
            btnRetake.style.display   = 'none';
            btnBuka.style.display     = 'inline-block';
        });
    </script>
@endpush