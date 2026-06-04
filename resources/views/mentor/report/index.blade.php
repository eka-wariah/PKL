<<<<<<< HEAD
@extends('mentor.master')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Laporan Kehadiran Siswa</h4>
    </div>

    <div class="card-body">
       <form action="{{ route('mentor.report.download') }}" method="GET" class="d-flex gap-2 align-items-end">
    <div>
        <label class="form-label fw-semibold mb-1">Bulan</label>
        <select name="month" class="form-select">
            @for ($m = 1; $m <= 12; $m++)
                <option value="{{ $m }}" {{ now()->month == $m ? 'selected' : '' }}>
                    {{ Carbon\Carbon::create(null, $m)->translatedFormat('F') }}
                </option>
            @endfor
        </select>
    </div>
    <div>
        <label class="form-label fw-semibold mb-1">Tahun</label>
        <select name="year" class="form-select">
            @for ($y = now()->year; $y >= now()->year - 3; $y--)
                <option value="{{ $y }}">{{ $y }}</option>
            @endfor
        </select>
    </div>
    <button type="submit" class="btn btn-success">
        <i class="ti ti-download me-1"></i> Download Laporan
    </button>
</form>
    </div>
</div>

@if(isset($students))
<div class="card mt-3">
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Hadir</th>
                    <th>Izin</th>
                    <th>Sakit</th>
                    <th>Alpha</th>
                </tr>
            </thead>

            <tbody>
                @foreach($students as $student)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $student->std_nis }}</td>
                    <td>{{ $student->user->usr_name }}</td>
                    <td>{{ $student->hadir }}</td>
                    <td>{{ $student->izin }}</td>
                    <td>{{ $student->sakit }}</td>
                    <td>{{ $student->alpha }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
