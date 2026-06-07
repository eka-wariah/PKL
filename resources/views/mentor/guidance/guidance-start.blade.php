@extends('mentor.master')

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

                <form action="" method="POST">
                    @csrf

                    <div class="row justify-content-center">
                        <div class="col-md-8">


                            <div class="mb-3">
                                <label class="form-label fw-semibold">Bimbingan Minggu Ke</label>
                                <input type="number" class="form-control bg-light" name="news_week_number"
                                    value="{{ $weekNumber }}" readonly>
                                <small class="text-muted">Dihitung otomatis oleh sistem.</small>
                            </div>

                            {{-- Metode Bimbingan --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    Metode Bimbingan <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('news_method') is-invalid @enderror" name="news_method">
                                    <option value="" disabled selected>-- Pilih Metode --</option>
                                    <option value="1" {{ old('news_method') == 'tatap_muka' ? 'selected' : '' }}>
                                        Tatap Muka
                                    </option>
                                    <option value="2" {{ old('news_method') == 'online' ? 'selected' : '' }}>
                                        Online
                                    </option>
                                    <option value="3" {{ old('news_method') == 'hybrid' ? 'selected' : '' }}>
                                        Hybrid
                                    </option>
                                </select>
                                @error('news_method')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tempat Bimbingan --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    Tempat Bimbingan <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('news_location') is-invalid @enderror"
                                    name="news_location" value="{{ old('news_location') }}"
                                    placeholder="Contoh: Sekolah, Google Meet, dll.">
                                @error('news_location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2 justify-content-end">
                                <a href="/mentor/bimbingan" class="btn btn-secondary">Batal</a>
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
