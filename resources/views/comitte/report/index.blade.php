@extends('comitte.master')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Laporan Kehadiran Siswa</h4>
    </div>

    <div class="card-body">
        <form method="GET" action="">
            <div class="row">
                <div class="col-md-4">
                    <label>Tanggal Awal</label>
                    <input type="date"
                           name="start_date"
                           class="form-control"
                           value="{{ request('start_date') }}"
                           required>
                </div>

                <div class="col-md-4">
                    <label>Tanggal Akhir</label>
                    <input type="date"
                           name="end_date"
                           class="form-control"
                           value="{{ request('end_date') }}"
                           required>
                </div>

                <div class="col-md-4 d-flex align-items-end gap-2">
                    <button type="submit"
                            class="btn btn-primary">
                        Tampilkan
                    </button>

                    @if(request('start_date') && request('end_date'))
                        <a href="{{ route('comitte.attendanceReport.pdf', [
                            'start_date' => request('start_date'),
                            'end_date' => request('end_date')
                        ]) }}"
                           class="btn btn-danger">
                            Cetak PDF
                        </a>
                    @endif
                </div>
            </div>
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