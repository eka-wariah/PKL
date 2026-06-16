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
                    <label>Bulan</label>
                    <select name="month" class="form-control" required>
                        <option value="">Pilih Bulan</option>
        
                        @php
                            $months = [
                                1 => 'Januari',
                                2 => 'Februari',
                                3 => 'Maret',
                                4 => 'April',
                                5 => 'Mei',
                                6 => 'Juni',
                                7 => 'Juli',
                                8 => 'Agustus',
                                9 => 'September',
                                10 => 'Oktober',
                                11 => 'November',
                                12 => 'Desember'
                            ];
                        @endphp
        
                        @foreach($months as $key => $month)
                            <option value="{{ $key }}"
                                {{ request('month') == $key ? 'selected' : '' }}>
                                {{ $month }}
                            </option>
                        @endforeach
                    </select>
                </div>
        
                <div class="col-md-4">
                    <label>Tahun</label>
                    <select name="year" class="form-control" required>
                        @for($year = date('Y'); $year >= date('Y') - 5; $year--)
                            <option value="{{ $year }}"
                                {{ request('year') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endfor
                    </select>
                </div>
        
                <div class="col-md-4 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary text-nowrap">
                        Tampilkan
                    </button>
        
                    @if(request('month') && request('year'))
                        <a href="{{ route('comitte.attendanceReport.pdf', [
                            'month' => request('month'),
                            'year' => request('year')
                        ]) }}"
                           class="btn btn-danger text-nowrap">
                            Cetak PDF
                        </a>
                        <a href="{{ route('comitte.attendanceReport.excel', [
                            'month' => request('month'),
                            'year' => request('year')
                        ]) }}"
                           class="btn btn-success text-nowrap">
                            Download Excel
                        </a>
                    @endif
                </div>
            </div>
        </form>
        {{-- <form method="GET" action="">
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
        </form> --}}
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
                    <td>{{ $student->user->name }}</td>
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