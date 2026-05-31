@extends('student.master')

@section('title', 'Presensi')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">

            <div class="card shadow-sm mb-4">
                <div class="card-body text-center py-4">
                    <h4 class="fw-semibold mb-1">Presensi Harian</h4>
                    <p class="text-muted mb-0" id="tanggalHari"></p>
                </div>
            </div>

            {{-- Status Presensi Hari Ini --}}
            @if($already)
            <div class="alert alert-success d-flex align-items-center gap-2">
                <i class="ti ti-circle-check fs-5"></i>
                <div>
                    <strong>Sudah presensi</strong> hari ini pukul {{ $presenceData->att_time }}
                </div>
            </div>
            @endif

            {{-- Kamera --}}
            <div class="card shadow-sm mb-3">
                <div class="card-body p-0 position-relative">
                    <video id="video" autoplay playsinline
                        class="w-100 rounded-top"
                        style="height: 300px; object-fit: cover; background: #000;"></video>
                    <canvas id="canvas" style="display:none;"></canvas>
                    <div id="previewContainer" style="display:none;">
                        <img id="preview" class="w-100 rounded-top" style="height:300px; object-fit:cover;" />
                        <button type="button" id="btnRetake"
                            class="btn btn-sm btn-secondary position-absolute top-0 end-0 m-2">
                            <i class="ti ti-camera-rotate me-1"></i> Ambil Ulang
                        </button>
                    </div>
                    <div id="loadingCamera" class="position-absolute top-50 start-50 translate-middle text-white text-center" style="display:none;">
                        <div class="spinner-border spinner-border-sm me-2"></div> Memuat kamera...
                    </div>
                </div>
                <div class="card-footer text-center">
                    <button type="button" id="btnCapture" class="btn btn-primary px-4" disabled>
                        <i class="ti ti-camera me-1"></i> Ambil Foto
                    </button>
                </div>
            </div>

            {{-- Lokasi --}}
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="ti ti-map-pin text-danger fs-5"></i>
                        <span class="fw-medium">Lokasi GPS</span>
                        <span id="gpsStatus" class="badge bg-warning text-dark ms-auto">Mendeteksi...</span>
                    </div>
                    <div id="lokasiInfo" class="text-muted small" style="min-height: 40px;">
                        Sedang mendeteksi lokasi Anda...
                    </div>
                    <input type="hidden" id="latitude" name="latitude">
                    <input type="hidden" id="longitude" name="longitude">
                    <input type="hidden" id="alamat" name="alamat">
                </div>
            </div>

            {{-- Tombol Submit --}}
            <div class="d-grid mb-4">
                <button type="button" id="btnSubmit" class="btn btn-success btn-lg" disabled>
                    <i class="ti ti-device-floppy me-2"></i> Kirim Presensi
                </button>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const video        = document.getElementById('video');
const canvas       = document.getElementById('canvas');
const preview      = document.getElementById('preview');
const btnCapture   = document.getElementById('btnCapture');
const btnRetake    = document.getElementById('btnRetake');
const btnSubmit    = document.getElementById('btnSubmit');
const previewCont  = document.getElementById('previewContainer');
const loadingCam   = document.getElementById('loadingCamera');
const gpsStatus    = document.getElementById('gpsStatus');
const lokasiInfo   = document.getElementById('lokasiInfo');

let fotoBase64 = null;
let lokasiOk   = false;
let fotoOk     = false;

// Tanggal
const now = new Date();
document.getElementById('tanggalHari').textContent = now.toLocaleDateString('id-ID', {
    weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
});

// Start kamera
loadingCam.style.display = 'block';
navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' }, audio: false })
    .then(stream => {
        video.srcObject = stream;
        video.onloadedmetadata = () => {
            loadingCam.style.display = 'none';
            btnCapture.disabled = false;
        };
    })
    .catch(err => {
        loadingCam.style.display = 'none';
        lokasiInfo.innerHTML = '<span class="text-danger">Kamera tidak dapat diakses: ' + err.message + '</span>';
    });

// Ambil foto
btnCapture.addEventListener('click', () => {
    canvas.width  = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext('2d').drawImage(video, 0, 0);
    fotoBase64 = canvas.toDataURL('image/jpeg', 0.8);
    preview.src = fotoBase64;
    video.style.display        = 'none';
    previewCont.style.display  = 'block';
    fotoOk = true;
    cekSiapSubmit();
});

// Retake
btnRetake.addEventListener('click', () => {
    video.style.display       = 'block';
    previewCont.style.display = 'none';
    fotoBase64 = null;
    fotoOk     = false;
    btnSubmit.disabled = true;
});

// GPS
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
        pos => {
            const lat = pos.coords.latitude;
            const lng = pos.coords.longitude;
            document.getElementById('latitude').value  = lat;
            document.getElementById('longitude').value = lng;
            gpsStatus.className = 'badge bg-success ms-auto';
            gpsStatus.textContent = 'Terdeteksi';
            lokasiInfo.textContent = `Lat: ${lat.toFixed(6)}, Lng: ${lng.toFixed(6)}`;
            lokasiOk = true;
            cekSiapSubmit();

            // Reverse geocode pakai Nominatim (gratis)
            fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`)
                .then(r => r.json())
                .then(data => {
                    const alamat = data.display_name || '';
                    document.getElementById('alamat').value = alamat;
                    lokasiInfo.textContent = alamat;
                })
                .catch(() => {});
        },
        err => {
            gpsStatus.className   = 'badge bg-danger ms-auto';
            gpsStatus.textContent = 'Gagal';
            lokasiInfo.innerHTML  = '<span class="text-danger">GPS tidak dapat diakses. Pastikan izin lokasi aktif.</span>';
        },
        { enableHighAccuracy: true, timeout: 10000 }
    );
} else {
    gpsStatus.className   = 'badge bg-secondary ms-auto';
    gpsStatus.textContent = 'Tidak Didukung';
}

function cekSiapSubmit() {
    btnSubmit.disabled = !(fotoOk && lokasiOk);
}

// Submit
btnSubmit.addEventListener('click', () => {
    Swal.fire({
        title: 'Konfirmasi Presensi',
        text: 'Yakin ingin mengirim presensi sekarang?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Kirim',
        cancelButtonText: 'Batal',
    }).then(result => {
        if (!result.isConfirmed) return;

        btnSubmit.disabled = true;
        btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Mengirim...';

        fetch('{{ route("student.presence.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                foto: fotoBase64,
                latitude:  document.getElementById('latitude').value,
                longitude: document.getElementById('longitude').value,
                alamat:    document.getElementById('alamat').value,
            })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                Swal.fire('Berhasil!', data.message, 'success').then(() => location.reload());
            } else {
                Swal.fire('Gagal', data.message || 'Terjadi kesalahan.', 'error');
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = '<i class="ti ti-device-floppy me-2"></i> Kirim Presensi';
            }
        })
        .catch(() => {
            Swal.fire('Error', 'Koneksi bermasalah, coba lagi.', 'error');
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = '<i class="ti ti-device-floppy me-2"></i> Kirim Presensi';
        });
    });
});
</script>
@endpush