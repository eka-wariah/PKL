@extends('student.master')

@section('title', 'Presensi')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">

                <div class="card shadow-sm mb-4">
                    <div class="card-body text-center py-4">
                        <h4 class="fw-semibold mb-1">Presensi Harian</h4>
                        <div id="jamDigital" style="font-size:30px;font-weight:700;letter-spacing:5px;">
                            00 : 00 : 00
                        </div>
                        <p class="text-muted mb-0" id="tanggalHari"></p>
                        {{-- <div class="mb-2">
                            <select class="form-select" id="jenisPresensi">
                                <option value="hadir">Hadir</option>
                                <option value="izin">Izin</option>
                                <option value="sakit">Sakit</option>
                            </select>
                        </div> --}}
                    </div>
                </div>

                {{-- Status Presensi Hari Ini --}}
                @if ($already)
                    <div class="alert alert-success d-flex align-items-center gap-2">
                        <i class="ti ti-circle-check fs-5"></i>
                        <div>
                            <strong>Sudah presensi kehadiran</strong> hari ini pukul {{ $presenceData->att_time }}
                        </div>
                    </div>
                @endif

                <div id="formHadir">
                {{-- Kamera --}}
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <label class="form-label fw-semibold">Foto Presensi</label>
                        <div class="border rounded p-3 bg-light">

                            <video id="kameraPreview" class="w-100 rounded mb-2" autoplay playsinline
                                style="display:none; height: 300px; object-fit: cover;"></video>

                            <div id="fotoPreviewWrapper" style="display:none;" class="mb-2">
                                <img id="fotoPreview" src="" class="img-fluid rounded"
                                    style="height: 300px; object-fit: cover; width: 100%;">
                            </div>

                            <div id="fotoPlaceholder"
                                class="flex-column align-items-center justify-content-center text-muted rounded"
                                style="height: 300px; border: 2px dashed #ccc; background: #fff; display: flex;">
                                <i class="ti ti-camera fs-1 mb-2"></i>
                                <span>Belum ada foto</span>
                            </div>

                            <canvas id="fotoCanvas" style="display:none;"></canvas>
                            <input type="hidden" id="fotoDokumentasi">

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
                        </div>
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
                    <button type="button" id="btnSubmit" class="btn btn-success btn-lg" {{ (!$canCheckout || !$hasCheckin || $hasCheckout) ? 'disabled' : '' }} disabled>
                        <i class="ti ti-device-floppy me-2"></i>
                        @if(!$hasCheckin)

                            ❌ Kamu belum melakukan presensi masuk hari ini.
                    
                        @elseif($hasCheckout)

                   
                            ✅ Kamu sudah melakukan presensi pulang pukul
                            {{ $presenceData->att_checkout_time }}
                      

                        @else

                      
                            🎉 Silakan lakukan presensi pulang.
                   

                        @endif
                    </button>
                </div>
            </div>
            
            {{-- <div id="formIzin" style="display:none">

                <div class="card shadow-sm mb-3">
                    <div class="card-body">
            
                        <label class="form-label fw-semibold">
                            Alasan Izin
                        </label>
            
                        <textarea
                            class="form-control"
                            rows="4"
                            placeholder="Masukkan alasan izin..."
                            id="alasanIzin"></textarea>
            
                    </div>
                </div>
            
                <div class="d-grid mb-4">
                    <button type="button" id="btnIzin" class="btn btn-warning btn-lg"  {{ (!$canCheckout || !$hasCheckin || $hasCheckout) ? 'disabled' : '' }}>
                        <i class="ti ti-send me-2"></i>
                        @if(!$hasCheckin)

<div class="alert alert-danger">
    ❌ Kamu belum melakukan presensi masuk hari ini.
</div>

@elseif($hasCheckout)

<div class="alert alert-success">
    ✅ Kamu sudah melakukan presensi pulang pukul
    {{ $attendance->att_checkout_time }}
</div>

@elseif(!$canCheckout)

<div class="alert alert-warning">
    ⏳ Presensi pulang dapat dilakukan mulai pukul 12.00.
</div>

@else

<div class="alert alert-info">
    🎉 Silakan lakukan presensi pulang.
</div>

@endif
                       
                    </button>
                </div>
            
            </div> --}}
            {{-- <div id="formSakit" style="display:none">

                <div class="card shadow-sm mb-3">
                    <div class="card-body">
            
                        <label class="form-label fw-semibold">
                            Keterangan Sakit
                        </label>
            
                        <textarea
                            class="form-control"
                            rows="4"
                            placeholder="Masukkan keterangan sakit..."
                            id="alasanSakit"></textarea>
            
                    </div>
                </div>
            
                <div class="d-grid mb-4">
                    <button type="button" id="btnSakit" class="btn btn-danger btn-lg" {{ (!$canCheckout || !$hasCheckin || $hasCheckout) ? 'disabled' : '' }}>
                        <i class="ti ti-send me-2"></i>
                        @if(!$hasCheckin)

                        <div class="alert alert-danger">
                            ❌ Kamu belum melakukan presensi masuk hari ini.
                        </div>
                        
                        @elseif($hasCheckout)
                        
                        <div class="alert alert-success">
                            ✅ Kamu sudah melakukan presensi pulang pukul
                            {{ $attendance->att_checkout_time }}
                        </div>
                        
                        @elseif(!$canCheckout)
                        
                        <div class="alert alert-warning">
                            ⏳ Presensi pulang dapat dilakukan mulai pukul 12.00.
                        </div>
                        
                        @else
                        
                        <div class="alert alert-info">
                            🎉 Silakan lakukan presensi pulang.
                        </div>
                        
                        @endif
                       
                    </button>
                </div>
            
            </div> --}}
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
document.addEventListener('DOMContentLoaded', () => {

    // Elemen kamera
    let kameraStream = null;
    let fotoBase64   = null;
    let lokasiOk     = false;
    let fotoOk       = false;

    const video       = document.getElementById('kameraPreview');
    const canvas      = document.getElementById('fotoCanvas');
    const preview     = document.getElementById('fotoPreview');
    const placeholder = document.getElementById('fotoPlaceholder');
    const previewWrap = document.getElementById('fotoPreviewWrapper');
    const btnBuka     = document.getElementById('btnBukaKamera');
    const btnAmbil    = document.getElementById('btnAmbilFoto');
    const btnRetake   = document.getElementById('btnRetake');
    const btnSubmit   = document.getElementById('btnSubmit');
    const gpsStatus   = document.getElementById('gpsStatus');
    const lokasiInfo  = document.getElementById('lokasiInfo');
    // const jenisPresensi = document.getElementById('jenisPresensi');
    const canCheckout = @json($canCheckout);
    const hasCheckin = @json($hasCheckin);
const hasCheckout = @json($hasCheckout);

// jenisPresensi.addEventListener('change', function () {

//     document.getElementById('formHadir').style.display = 'none';
//     document.getElementById('formIzin').style.display = 'none';
//     document.getElementById('formSakit').style.display = 'none';

//     if (this.value === 'hadir') {
//         document.getElementById('formHadir').style.display = 'block';
//     }

//     if (this.value === 'izin') {
//         document.getElementById('formIzin').style.display = 'block';
//     }

//     if (this.value === 'sakit') {
//         document.getElementById('formSakit').style.display = 'block';
//     }
// });

    // Tanggal
    const now = new Date();
    document.getElementById('tanggalHari').textContent = now.toLocaleDateString('id-ID', {
        weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
    });

    // Buka kamera
    btnBuka.addEventListener('click', async function () {
        try {
            kameraStream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: 'user' }, audio: false
            });
            video.srcObject = kameraStream;
            video.style.display       = 'block';
            placeholder.style.display = 'none';
            previewWrap.style.display = 'none';
            btnBuka.style.display     = 'none';
            btnAmbil.style.display    = 'inline-block';
        } catch (err) {
            alert('Tidak bisa mengakses kamera: ' + err.message);
        }
    });

    // Ambil foto
    btnAmbil.addEventListener('click', function () {
        canvas.width  = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext('2d').drawImage(video, 0, 0);

        fotoBase64    = canvas.toDataURL('image/jpeg', 0.85);
        preview.src   = fotoBase64;

        kameraStream.getTracks().forEach(t => t.stop());
        video.style.display       = 'none';
        previewWrap.style.display = 'block';
        btnAmbil.style.display    = 'none';
        btnRetake.style.display   = 'inline-block';

        fotoOk = true;
        cekSiapSubmit();
    });

    // Ulangi foto
    btnRetake.addEventListener('click', function () {
        fotoBase64                = null;
        preview.src               = '';
        previewWrap.style.display = 'none';
        placeholder.style.display = 'flex';
        btnRetake.style.display   = 'none';
        btnBuka.style.display     = 'inline-block';

        fotoOk = false;
        cekSiapSubmit();
    });

    // GPS
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            pos => {
                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;
                document.getElementById('latitude').value  = lat;
                document.getElementById('longitude').value = lng;
                gpsStatus.className   = 'badge bg-success ms-auto';
                gpsStatus.textContent = 'Terdeteksi';
                lokasiInfo.textContent = `Lat: ${lat.toFixed(6)}, Lng: ${lng.toFixed(6)}`;
                lokasiOk = true;
                cekSiapSubmit();

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

// Belum jam checkout
if (!canCheckout) {
    btnSubmit.disabled = true;
    return;
}

// Belum presensi masuk
if (!hasCheckin) {
    btnSubmit.disabled = true;
    return;
}

// Sudah checkout
if (hasCheckout) {
    btnSubmit.disabled = true;
    return;
}

// Kalau semua syarat terpenuhi
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

            btnSubmit.disabled  = true;
            btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Mengirim...';

            fetch('{{ route("student.checkout.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    foto:      fotoBase64,
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
                    btnSubmit.disabled  = false;
                    btnSubmit.innerHTML = '<i class="ti ti-device-floppy me-2"></i> Kirim Presensi';
                }
            })
            .catch(() => {
                Swal.fire('Error', 'Koneksi bermasalah, coba lagi.', 'error');
                btnSubmit.disabled  = false;
                btnSubmit.innerHTML = '<i class="ti ti-device-floppy me-2"></i> Kirim Presensi';
            });
        });
    });

    const btnIzin = document.getElementById('btnIzin');

if(btnIzin){

    btnIzin.addEventListener('click', () => {

        const alasan = document
            .getElementById('alasanIzin')
            .value
            .trim();

        if(!alasan){
            Swal.fire(
                'Peringatan',
                'Alasan izin wajib diisi',
                'warning'
            );
            return;
        }

        fetch('{{ route("student.presence.permission.store") }}', {

            method: 'POST',

            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },

            body: JSON.stringify({
                description: alasan
            })

        })
        .then(r => r.json())
        .then(data => {

            if(data.success){

                btnIzin.disabled = true;

                Swal.fire(
                    'Berhasil',
                    data.message,
                    'success'
                ).then(() => location.reload());

            }else{

                Swal.fire(
                    'Gagal',
                    data.message,
                    'error'
                );

            }

        });

    });

}
const btnSakit = document.getElementById('btnSakit');

if(btnSakit){

    btnSakit.addEventListener('click', () => {

        const alasan = document
            .getElementById('alasanSakit')
            .value
            .trim();

        if(!alasan){
            Swal.fire(
                'Peringatan',
                'Keterangan sakit wajib diisi',
                'warning'
            );
            return;
        }

        fetch('{{ route("student.presence.sick.store") }}', {

            method: 'POST',

            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },

            body: JSON.stringify({
                description: alasan
            })

        })
        .then(r => r.json())
        .then(data => {

            if(data.success){

                btnSakit.disabled = true;

                Swal.fire(
                    'Berhasil',
                    data.message,
                    'success'
                ).then(() => location.reload());

            }else{

                Swal.fire(
                    'Gagal',
                    data.message,
                    'error'
                );

            }

        });

    });

}


});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function updateJam() {
        const sekarang = new Date();

        // Jam
        let jam = String(sekarang.getHours()).padStart(2, '0');
        let menit = String(sekarang.getMinutes()).padStart(2, '0');
        let detik = String(sekarang.getSeconds()).padStart(2, '0');

        document.getElementById('jamDigital').innerHTML =
            `${jam} : ${menit} : ${detik}`;

        // Tanggal Indonesia
        const hari = [
            'Minggu', 'Senin', 'Selasa', 'Rabu',
            'Kamis', 'Jumat', 'Sabtu'
        ];

        const bulan = [
            'Januari', 'Februari', 'Maret', 'April',
            'Mei', 'Juni', 'Juli', 'Agustus',
            'September', 'Oktober', 'November', 'Desember'
        ];

        const tanggal =
            `${hari[sekarang.getDay()]}, ${sekarang.getDate()} ${bulan[sekarang.getMonth()]} ${sekarang.getFullYear()}`;

        document.getElementById('tanggalHari').innerHTML = tanggal;
    }

    updateJam();
    setInterval(updateJam, 1000);
</script>

@endpush
