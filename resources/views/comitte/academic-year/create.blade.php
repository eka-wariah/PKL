@extends('comitte.master')

@push('link')
    
@endpush

@section('title')
    SiTAW | Tambah Tahun Ajaran
@endsection

@section('content')
   <div class="row">
    <div class="col-lg-12">
      <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
          <div class="row align-items-center">
            <div class="col-9">
              <h4 class="fw-semibold mb-8">TAHUN AJARAN</h4>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="/administration/school_year">Daftar Tahun Ajaran</a>
                  </li>
                <li class="breadcrumb-item" aria-current="page">Tambah Tahun Ajaran</li>
                  <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="/administration/school_year/{id}/edit">Edit Tahun Ajaran</a>
                  </li>
                </ol>
               
              </nav>
            </div>
            <div class="col-3">
              <div class="text-center mb-n5">
                <img src="{{ asset('assets/images/breadcrumb/ChatBc.png')}}" alt="modernize-img" class="img-fluid mb-n4" />
              </div>
            </div>
          </div>
        </div>
      </div>
        <div class="card">
          <div class="px-4 py-3 border-bottom">
            <h4 class="card-title mb-0">Tambah Tahun Ajaran </h4>
          </div>
          <form action="" method="post">
            @csrf
            <div class="card-body">
                  <div class="mb-4 row align-items-center">
                    <label for="Select" class="form-label col-sm-3 col-form-label">Awal Tahun</label>
                    <div class="col-sm-9">
                      <select id="Select" name="acy_year" class="form-control" required>
                          <option hidden value="">Pilih Tahun</option>
                  
                          @foreach ($years as $year)
                              <option value="{{ $year }}">{{ $year }}</option>
                          @endforeach
                  
                      </select>
                  
                      @error('adm_management_scope_id')
                          <div id="adm_id" class="form-text">{{ $message }}</div>
                      @enderror
                  </div>
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
