@extends('comitte.master')

@push('link')
@endpush

@section('title')
    SiMaput | Kelas
@endsection

@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">KELAS</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="../main/index.html">Home</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Daftar Kelas</li>
                            <li class="breadcrumb-item" aria-current="page">Tambah Kelas Kelas</li>


                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="{{asset('assets/images/breadcrumb/ChatBc.png')}}" alt="modernize-img" class="img-fluid mb-n4" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="px-4 py-3 border-bottom">
                    <h4 class="card-title mb-0">Tambah Kelas</h4>
                </div>
                <form action="" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="mb-4 row align-items-center">
                            <label for="exampleInputText1" class="form-label col-sm-3 col-form-label">Tingkatan</label>
                            <div class="col-sm-9">
                                <select class="form-select mr-sm-2" name="cls_level"
                                    oninvalid="this.setCustomValidity('Tingkatan wajib diisi')"
                                    oninput="this.setCustomValidity('')" required>
                                    <option hidden value="">Pilih Tingkatan</option>
                                    <option value="X" {{ $edit_class->cls_level == 'X' ? 'selected' : '' }}>X</option>
                                    <option value="XI" {{ $edit_class->cls_level == 'XI' ? 'selected' : '' }}>XI</option>
                                    <option value="XII" {{ $edit_class->cls_level == 'XII' ? 'selected' : '' }}>XII</option>
                                </select>

                            </div>
                            @error('mjr_name')
                                <div>error</div>
                            @enderror
                        </div>
                        <div class="mb-4 row align-items-center">
                            <label for="exampleInputText1" class="form-label col-sm-3 col-form-label">Jurusan</label>
                            <div class="col-sm-9">
                                <select class="form-select mr-sm-2" name="cls_major_id"
                                oninvalid="this.setCustomValidity('Jurusan wajib diisi')"
                                oninput="this.setCustomValidity('')" required>
                            <option hidden value="">Pilih Jurusan...</option>
                            @foreach ($majors as $major)
                                <option value="{{ $major->mjr_id }}" {{ $edit_class->cls_major_id == $major->mjr_id ? 'selected' : '' }}>
                                    {{ $major->mjr_abbr }} - {{ $major->mjr_name }}
                                </option>
                            @endforeach
                        </select>
                        
                            </div>
                            @error('cls_major_id')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4 row align-items-center">
                            <label for="exampleInputText2" class="form-label col-sm-3 col-form-label">Nomor</label>
                            <div class="col-sm-9">
                                <input type="text" name="cls_number" value="{{$edit_class->cls_number}}" class="form-control" id="exampleInputText2"
                                    placeholder="" required oninvalid="this.setCustomValidity('Singkatan Wajib Diisi')"
                                    onchange="this.setCustomValidity('')">
                            </div>
                            @error('mjr_prefix')
                                <div>error</div>
                            @enderror
                        </div>

                        

                        <div class="mb-4 row align-items-center">
                            <label for="exampleInputText1" class="form-label col-sm-3 col-form-label">Tahun Ajaran</label>
                            <div class="col-sm-9">
                                <select class="form-select mr-sm-2"  name="cls_acy_id"
                                    oninvalid="this.setCustomValidity('Jurusan wajib diisi')"
                                    onchange="this.setCustomValidity('')" required>
                                    <option selected value="">Pilih...</option>
                                    @foreach ($academic_year as $acy)
                                        <option value="{{ $acy->acy_id }}" {{ $edit_class->cls_acy_id == $acy->acy_id ? 'selected' : '' }}>{{ $acy->acy_year}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('cls_acy_id')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9">
                                <input type="submit" class="btn btn-primary" value="Kirim" id="">
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection



@push('script')
@endpush
