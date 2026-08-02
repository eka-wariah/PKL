@extends('student.master')

@section('title', 'Ubah Password')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">

                <div class="card shadow-sm mb-4">
                    <div class="card-body text-center py-4">
                        <h4 class="fw-semibold mb-1">Ubah Password</h4>
                        <p class="text-muted mb-0">Pastikan password baru mudah diingat dan aman</p>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
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

                <form method="POST" action="{{ route('student.update-password') }}">
                    @csrf
                    @method('PUT')

                    <div class="card shadow-sm mb-3">
                        <div class="card-body">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Password Saat Ini</label>
                                <input type="password" name="current_password" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Password Baru</label>
                                <input type="password" name="new_password" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
                                <input type="password" name="new_password_confirmation" class="form-control">
                            </div>

                        </div>
                    </div>

                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="ti ti-device-floppy me-2"></i> Simpan Password
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection