<style>
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 10px;
    }

    th, td {
        border: 1px solid #000;
        text-align: center;
        padding: 4px;
    }

    .hadir {
        background-color: #28a745;
        color: white;
    }

    .izin {
        background-color: #fd7e14;
        color: white;
    }

    .sakit {
        background-color: #0d6efd;
        color: white;
    }

    .alpha {
        background-color: #dc3545;
        color: white;
    }
</style>

<h3 align="center">
    Laporan Kehadiran Siswa
</h3>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>NIS</th>
            <th>Nama</th>

            @foreach($dates as $date)
                <th>{{ $date->format('d') }}</th>
            @endforeach
        </tr>
    </thead>

    <tbody>
        @foreach($students as $student)
            <tr>

                <td>{{ $loop->iteration }}</td>
                <td>{{ $student->student->std_nis }}</td>
                <td>
                    {{ $student->student->user->usr_name }}
                </td>

                @foreach($dates as $date)

                    @php
                        $attendance = $student->student->attendances
                            ->firstWhere(
                                'att_date',
                                $date->format('Y-m-d')
                            );
                    @endphp

                    @if($attendance)

                        @switch($attendance->att_status)

                            @case(1)
                                <td class="hadir">H</td>
                                @break

                            @case(2)
                                <td class="izin">I</td>
                                @break

                            @case(3)
                                <td class="sakit">S</td>
                                @break

                            @case(4)
                                <td class="alpha">A</td>
                                @break

                            @default
                                <td>-</td>

                        @endswitch

                    @else
                        <td>-</td>
                    @endif

                @endforeach

            </tr>
        @endforeach
    </tbody>
</table>