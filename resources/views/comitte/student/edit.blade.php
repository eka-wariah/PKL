@extends('comitte.master')

@push('link')
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
@endpush

@section('title')
    SiMAPUT | Tambah Guru
@endsection

@section('content')
 
        <div class="container-fluid">
          <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
              <div class="row align-items-center">
                <div class="col-9">
                  <h4 class="fw-semibold mb-8">Account Setting</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="../main/index.html">Home</a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">Account Setting</li>
                    </ol>
                  </nav>
                </div>
                <div class="col-3">
                  <div class="text-center mb-n5">
                    <img src="../assets/images/breadcrumb/ChatBc.png" alt="modernize-img" class="img-fluid mb-n4" />
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card">
            <ul class="nav nav-pills user-profile-tab" id="pills-tab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link position-relative rounded-0 active d-flex align-items-center justify-content-center bg-transparent fs-3 py-3" id="pills-account-tab" data-bs-toggle="pill" data-bs-target="#pills-account" type="button" role="tab" aria-controls="pills-account" aria-selected="true">
                  <i class="ti ti-user-circle me-2 fs-6"></i>
                  <span class="d-none d-md-block">Account</span>
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-3" id="pills-security-tab" data-bs-toggle="pill" data-bs-target="#pills-security" type="button" role="tab" aria-controls="pills-security" aria-selected="false">
                  <i class="ti ti-lock me-2 fs-6"></i>
                  <span class="d-none d-md-block">Security</span>
                </button>
              </li>
            </ul>
            <div class="card-body">
              <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-account" role="tabpanel" aria-labelledby="pills-account-tab" tabindex="0">
                  <div class="row">
                    <div class="col-12">
                      <div class="card w-100 border position-relative overflow-hidden mb-0">
                        <div class="card-body p-4">
                          <h4 class="card-title">Edit Siswa</h4>
                          <br>
                          {{-- <p class="card-subtitle mb-4">To change your personal detail , edit and save from here</p> --}}
                          <form action="" method="post">
                            @csrf
                            <div class="row">
                              <div class="col-lg-6">
                                <div class="mb-3">
                                  <label for="exampleInputtext" class="form-label">Nama</label>
                                  <div class="col-sm-12">
                                    <input type="text" name="name" value="{{$student->name}}"  class="form-control" id="exampleInputText1" placeholder="Nama Jurusan" required oninvalid="this.setCustomValidity('Nama Jurusan Wajib Diisi')" 
                      onchange="this.setCustomValidity('')">
                                  </div>
                                </div>
                                <div class="mb-3">
                                  <label for="exampleInputtext" class="form-label">NIS</label>
                                  <div class="col-sm-12">
                                <input type="text" name="std_nis" value="{{$student->student->std_nis}}"  class="form-control" id="exampleInputText1" placeholder="Nama Jurusan" required oninvalid="this.setCustomValidity('Nama Jurusan Wajib Diisi')" 
                      onchange="this.setCustomValidity('')">
                              </div>
                                </div>
                                <div class="mb-3">
                                  <label for="exampleInputtext" class="form-label">NISN</label>
                              
                              <div class="col-sm-12">
                                <input type="text" name="std_nisn" value="{{$student->student->std_nisn}}"  class="form-control" id="exampleInputText1" placeholder="Nama Jurusan" required oninvalid="this.setCustomValidity('Nama Jurusan Wajib Diisi')" 
                      onchange="this.setCustomValidity('')">
                              </div>
                                </div>
                              </div>
                              <div class="col-lg-6">
                                {{-- <div class="mb-3">
                                  <label for="exampleInputtext2" class="form-label">Kelas</label> --}}
                                  <div class="mb-3">
                                    <label class="form-label">Kelas</label>
                                
                                    <select class="form-select"
                                            name="std_classes_id"
                                            required>
                                
                                        <option value="">Pilih Kelas</option>
                                
                                        @foreach ($class as $cls)
                                            <option value="{{ $cls->cls_id }}"
                                                {{ old('std_classes_id', $student->student->std_classes_id) == $cls->cls_id ? 'selected' : '' }}>
                                                {{ $cls->cls_level }}
                                                {{ $cls->cls_major->mjr_abbr }}
                                                {{ $cls->cls_number }}
                                            </option>
                                        @endforeach
                                
                                    </select>
                                </div>
                              
                              {{-- <div class="form-control bg-light">
                                {{ $student->student->classes->cls_level ?? '-' }} {{ $student->student->classes->cls_major->mjr_abbr ?? '-' }}  {{ $student->student->classes->cls_number ?? '-' }}
                              </div> --}}
                                {{-- </div> --}}
                                {{-- <div class="col-lg-6"> --}}
                                  {{-- <div class="mb-3">
                                    <label for="exampleInputtext2" class="form-label">Kelas</label> --}}
                                    <div class="mb-3">
                                      <label class="form-label">Perusahaan</label>
                              
                                  <select class="form-select" name="std_company_id" id="companySelect">
                                      <option value="">Pilih...</option>
                              
                                      @foreach ($company as $cmp)
                                          <option value="{{ $cmp->cmp_id }}"  data-address="{{ $cmp->cmp_adress }}"
                                              {{ $student->student->std_company_id == $cmp->cmp_id ? 'selected' : '' }}>
                                              {{ $cmp->cmp_name }}
                                          </option>
                                      @endforeach
                                  </select>
                              
                                  @error('std_company_id')
                                      <div class="invalid-feedback">{{ $message }}</div>
                                  @enderror
                              </div>
                              {{-- </div> --}}
                                <div class="mb-3">
                                  <label for="exampleInputtext3" class="form-label">Pembimbing</label>
                                  <div class="form-control bg-light">
                                    {{ $student->std_mentor?? '-'}}
                                  </div>
                                  {{-- <div class="col-sm-12">
                                    <input type="text" name="mjr_name" value="{{$student->std_mentor?? '-' }}"  class="form-control" id="exampleInputText1" placeholder="Nama Jurusan" required oninvalid="this.setCustomValidity('Nama Jurusan Wajib Diisi')" 
                          onchange="this.setCustomValidity('')">
                                  </div> --}}
                                </div>
                              </div>
                              <div class="col-12">
                                <div>
                                  <label for="exampleInputtext4" class="form-label">Alamat Perusahaan</label>
                              {{-- <div class="form-control bg-light">
                                {{ $student->student->company->cmp_adress ?? '-' }}
                              </div> --}}
                              <div class="col-sm-12">
                                <input type="text" name="cmp_adress" value="{{$student->student->company->cmp_adress ?? '-' }}"  class="form-control"  id="companyAddress" required oninvalid="this.setCustomValidity('Nama Jurusan Wajib Diisi')" 
                      onchange="this.setCustomValidity('')"  readonly>
                              </div>
                                </div>
                              </div>
                              <div class="col-12">
                                <div class="d-flex align-items-center justify-content-end mt-4 gap-6">
                                  <button type="submit" class="btn btn-primary" value="Kirim" id="">Save</button>
                                  {{-- <a href="{{ route('comitte.student.edit', $student->usr_id) }}" class="btn btn-primary">
                                    Edit
                                  </a> --}}
                                  {{-- <button class="btn bg-danger-subtle text-danger">Cancel</button> --}}
                                  <a href="{{ route('comitte.student.index') }}" class="btn bg-danger-subtle text-danger">
                                    Kembali
                                  </a>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                {{-- <div class="tab-pane fade" id="pills-notifications" role="tabpanel" aria-labelledby="pills-notifications-tab" tabindex="0">
                  <div class="row justify-content-center">
                    <div class="col-lg-9">
                      <div class="card border shadow-none">
                        <div class="card-body p-4">
                          <h4 class="card-title">Notification Preferences</h4>
                          <p class="card-subtitle mb-4">
                            Select the notificaitons ou would like to receive via email. Please note that you cannot opt
                            out of receving service
                            messages, such as payment, security or legal notifications.
                          </p>
                          <form class="mb-7">
                            <label for="exampleInputtext5" class="form-label">Email Address*</label>
                            <input type="text" class="form-control" id="exampleInputtext5" placeholder="" required>
                            <p class="mb-0">Required for notificaitons.</p>
                          </form>
                          <div>
                            <div class="d-flex align-items-center justify-content-between mb-4">
                              <div class="d-flex align-items-center gap-3">
                                <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                                  <i class="ti ti-article text-dark d-block fs-7" width="22" height="22"></i>
                                </div>
                                <div>
                                  <h5 class="fs-4 fw-semibold">Our newsletter</h5>
                                  <p class="mb-0">We'll always let you know about important changes</p>
                                </div>
                              </div>
                              <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked">
                              </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-4">
                              <div class="d-flex align-items-center gap-3">
                                <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                                  <i class="ti ti-checkbox text-dark d-block fs-7" width="22" height="22"></i>
                                </div>
                                <div>
                                  <h5 class="fs-4 fw-semibold">Order Confirmation</h5>
                                  <p class="mb-0">You will be notified when customer order any product</p>
                                </div>
                              </div>
                              <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked1" checked>
                              </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-4">
                              <div class="d-flex align-items-center gap-3">
                                <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                                  <i class="ti ti-clock-hour-4 text-dark d-block fs-7" width="22" height="22"></i>
                                </div>
                                <div>
                                  <h5 class="fs-4 fw-semibold">Order Status Changed</h5>
                                  <p class="mb-0">You will be notified when customer make changes to the order</p>
                                </div>
                              </div>
                              <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked2" checked>
                              </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-4">
                              <div class="d-flex align-items-center gap-3">
                                <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                                  <i class="ti ti-truck-delivery text-dark d-block fs-7" width="22" height="22"></i>
                                </div>
                                <div>
                                  <h5 class="fs-4 fw-semibold">Order Delivered</h5>
                                  <p class="mb-0">You will be notified once the order is delivered</p>
                                </div>
                              </div>
                              <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked3">
                              </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                              <div class="d-flex align-items-center gap-3">
                                <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                                  <i class="ti ti-mail text-dark d-block fs-7" width="22" height="22"></i>
                                </div>
                                <div>
                                  <h5 class="fs-4 fw-semibold">Email Notification</h5>
                                  <p class="mb-0">Turn on email notificaiton to get updates through email</p>
                                </div>
                              </div>
                              <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked4" checked>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-9">
                      <div class="card border shadow-none">
                        <div class="card-body p-4">
                          <h4 class="card-title">Date & Time</h4>
                          <p class="card-subtitle">Time zones and calendar display settings.</p>
                          <div class="d-flex align-items-center justify-content-between mt-7">
                            <div class="d-flex align-items-center gap-3">
                              <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                                <i class="ti ti-clock-hour-4 text-dark d-block fs-7" width="22" height="22"></i>
                              </div>
                              <div>
                                <p class="mb-0">Time zone</p>
                                <h5 class="fs-4 fw-semibold">(UTC + 02:00) Athens, Bucharet</h5>
                              </div>
                            </div>
                            <a class="text-dark fs-6 d-flex align-items-center justify-content-center bg-transparent p-2 fs-4 rounded-circle" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Download">
                              <i class="ti ti-download"></i>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-9">
                      <div class="card border shadow-none">
                        <div class="card-body p-4">
                          <h4 class="card-title">Ignore Tracking</h4>
                          <div class="d-flex align-items-center justify-content-between mt-7">
                            <div class="d-flex align-items-center gap-3">
                              <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                                <i class="ti ti-player-pause text-dark d-block fs-7" width="22" height="22"></i>
                              </div>
                              <div>
                                <h5 class="fs-4 fw-semibold">Ignore Browser Tracking</h5>
                                <p class="mb-0">Browser Cookie</p>
                              </div>
                            </div>
                            <div class="form-check form-switch mb-0">
                              <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked5">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="d-flex align-items-center justify-content-end gap-6">
                        <button class="btn btn-primary">Save</button>
                        <button class="btn bg-danger-subtle text-danger">Cancel</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="pills-bills" role="tabpanel" aria-labelledby="pills-bills-tab" tabindex="0">
                  <div class="row justify-content-center">
                    <div class="col-lg-9">
                      <div class="card border shadow-none">
                        <div class="card-body p-4">
                          <h4 class="card-title mb-3">Billing Information</h4>
                          <form>
                            <div class="row">
                              <div class="col-lg-6">
                                <div class="mb-3">
                                  <label for="exampleInputtext6" class="form-label">Business
                                    Name*</label>
                                  <input type="text" class="form-control" id="exampleInputtext6" placeholder="Visitor Analytics">
                                </div>
                                <div class="mb-3">
                                  <label for="exampleInputtext7" class="form-label">Business
                                    Address*</label>
                                  <input type="text" class="form-control" id="exampleInputtext7" placeholder="">
                                </div>
                                <div>
                                  <label for="exampleInputtext8" class="form-label">First Name*</label>
                                  <input type="text" class="form-control" id="exampleInputtext8" placeholder="">
                                </div>
                              </div>
                              <div class="col-lg-6">
                                <div class="mb-3">
                                  <label for="exampleInputtext9" class="form-label">Business
                                    Sector*</label>
                                  <input type="text" class="form-control" id="exampleInputtext9" placeholder="Arts, Media & Entertainment">
                                </div>
                                <div class="mb-3">
                                  <label for="exampleInputtext10" class="form-label">Country*</label>
                                  <input type="text" class="form-control" id="exampleInputtext10" placeholder="Romania">
                                </div>
                                <div>
                                  <label for="exampleInputtext11" class="form-label">Last Name*</label>
                                  <input type="text" class="form-control" id="exampleInputtext11" placeholder="">
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-9">
                      <div class="card border shadow-none">
                        <div class="card-body p-4">
                          <h4 class="card-title">Current Plan : <span class="text-success">Executive</span>
                          </h4>
                          <p class="card-subtitle">Thanks for being a premium member and supporting our development.</p>
                          <div class="d-flex align-items-center justify-content-between mt-7 mb-3">
                            <div class="d-flex align-items-center gap-3">
                              <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                                <i class="ti ti-package text-dark d-block fs-7" width="22" height="22"></i>
                              </div>
                              <div>
                                <p class="mb-0">Current Plan</p>
                                <h5 class="fs-4 fw-semibold">750.000 Monthly Visits</h5>
                              </div>
                            </div>
                            <a class="text-dark fs-6 d-flex align-items-center justify-content-center bg-transparent p-2 fs-4 rounded-circle" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add">
                              <i class="ti ti-circle-plus"></i>
                            </a>
                          </div>
                          <div class="d-flex align-items-center gap-3">
                            <button class="btn btn-primary">Change Plan</button>
                            <button class="btn bg-danger-subtle text-danger">Reset Plan</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-9">
                      <div class="card border shadow-none">
                        <div class="card-body p-4">
                          <h4 class="card-title">Payment Method</h4>
                          <p class="card-subtitle">On 26 December, 2024</p>
                          <div class="d-flex align-items-center justify-content-between mt-7">
                            <div class="d-flex align-items-center gap-3">
                              <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                                <i class="ti ti-credit-card text-dark d-block fs-7" width="22" height="22"></i>
                              </div>
                              <div>
                                <h5 class="fs-4 fw-semibold">Visa</h5>
                                <p class="mb-0 text-dark">*****2102</p>
                              </div>
                            </div>
                            <a class="text-dark fs-6 d-flex align-items-center justify-content-center bg-transparent p-2 fs-4 rounded-circle" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit">
                              <i class="ti ti-pencil-minus"></i>
                            </a>
                          </div>
                          <p class="my-2">If you updated your payment method, it will only be dislpayed here after your
                            next billing cycle.</p>
                          <div class="d-flex align-items-center gap-3">
                            <button class="btn bg-danger-subtle text-danger">Cancel Subscription</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="d-flex align-items-center justify-content-end gap-6">
                        <button class="btn btn-primary">Save</button>
                        <button class="btn bg-danger-subtle text-danger">Cancel</button>
                      </div>
                    </div>
                  </div>
                </div> --}}
                <div class="tab-pane fade" id="pills-security" role="tabpanel" aria-labelledby="pills-security-tab" tabindex="0">
                  <div class="row">
                    <div class="col-12">
                        <div class="card border shadow-none">
                            <div class="card-body p-4">
            
                                <h4 class="card-title">Ubah Password</h4>
                                <p class="card-subtitle mb-4">
                                    Untuk keamanan akun, masukkan password lama dan password baru.
                                </p>
                                @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <form action="{{ route('comitte.student.password.update', $student->usr_id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
            
                                    <div class="mb-3">
                                      <label class="form-label">Password Lama</label>
                                      <div class="input-group">
                                          <span class="input-group-text">
                                              <i class="ti ti-lock"></i>
                                          </span>
                                  
                                          <input type="password"
                                              class="form-control"
                                              id="current_password"
                                              name="current_password"
                                              placeholder="Masukkan password lama">
                                  
                                          <button class="btn btn-outline-secondary"
                                              type="button"
                                              id="toggleCurrentPassword">
                                              <i class="ti ti-eye" id="eyeIconCurrent"></i>
                                          </button>
                                          @error('current_password')
    <small class="text-danger">{{ $message }}</small>
@enderror
                                      </div>
                                  </div>
            
                                    <div class="mb-3">
                                      <label class="form-label">Password Baru</label>
                                      <div class="input-group">
                                          <span class="input-group-text">
                                              <i class="ti ti-key"></i>
                                          </span>
                                  
                                          <input type="password"
                                              class="form-control"
                                              id="password"
                                              name="password"
                                              placeholder="Masukkan password baru">
                                  
                                          <button class="btn btn-outline-secondary"
                                              type="button"
                                              id="togglePassword">
                                              <i class="ti ti-eye" id="eyeIcon"></i>
                                          </button>
                                          @error('password')
    <small class="text-danger">{{ $message }}</small>
@enderror
                                      </div>
                                  </div>
            
                                  <div class="mb-4">
                                    <label class="form-label">Konfirmasi Password Baru</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="ti ti-shield-lock"></i>
                                        </span>
                                
                                        <input type="password"
                                            class="form-control"
                                            id="password_confirmation"
                                            name="password_confirmation"
                                            placeholder="Ulangi password baru">
                                
                                        <button class="btn btn-outline-secondary"
                                            type="button"
                                            id="toggleConfirm">
                                            <i class="ti ti-eye" id="eyeIconConfirm"></i>
                                        </button>
                                    </div>
                                </div>
            
                                    <div class="alert alert-light border">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="ti ti-info-circle text-primary"></i>
                                            <small>
                                                Password minimal 8 karakter dan disarankan
                                                mengandung huruf besar, huruf kecil, angka,
                                                serta simbol.
                                            </small>
                                        </div>
                                    </div>
            
                                    <div class="d-flex justify-content-end gap-2 mt-4">
                                        <button type="reset" class="btn btn-light">
                                            Reset
                                        </button>
            
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ti ti-device-floppy me-1"></i>
                                            Simpan Password
                                        </button>
                                    </div>
            
                                </form>
            
                            </div>
                        </div>
            
                    </div>
                </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection

@push('script')
<script>
  // Password Lama
  document.getElementById('toggleCurrentPassword').addEventListener('click', function() {
      const input = document.getElementById('current_password');
      const icon = document.getElementById('eyeIconCurrent');

      if (input.type === 'password') {
          input.type = 'text';
          icon.classList.replace('ti-eye', 'ti-eye-off');
      } else {
          input.type = 'password';
          icon.classList.replace('ti-eye-off', 'ti-eye');
      }
  });

  // Password Baru
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

  // Konfirmasi Password
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
    {{-- <script>
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
    </script> --}}
    <script>
      document.addEventListener('DOMContentLoaded', function () {
      
          const companySelect = document.getElementById('companySelect');
          const companyAddress = document.getElementById('companyAddress');
      
          function updateAddress() {
              const selectedOption =
                  companySelect.options[companySelect.selectedIndex];
      
              companyAddress.value =
                  selectedOption.getAttribute('data-address') || '';
          }
      
          companySelect.addEventListener('change', updateAddress);
      
          // untuk pertama kali saat halaman dibuka
          updateAddress();
      });
      </script>
@endpush