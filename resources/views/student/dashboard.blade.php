@extends('student.master')

@push('link')
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('title')
    SIMaput | Dashboard
@endsection

@section('content')
    <div class="datatables">
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
              <div class="row align-items-center">
                <div class="col-9">
                  <h4 class="fw-semibold mb-8">Dashboard</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page">Dashboard</li>
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
       
          <div class="row">
    
            <div class="col-lg-8 d-flex align-items-stretch">
            <div class="card w-100 bg-primary-subtle overflow-hidden shadow-none">
              <div class="card-body position-relative">
                <div class="row">
                  <div class="col-lg-8">
                      <div class="card bg-{{ $bg }}-subtle border-0 shadow-sm">
                          <div class="card-body">
                  
                              <div class="row align-items-center">
                  
                                  <div class="col-md-8">
                  
                                      <h3 class="fw-bold mb-2">
                                          Halo, {{ auth()->user()->name }}
                                      </h3>
                  
                                      <h5 class="text-{{ $bg }}">
                                          {{ $title }}
                                      </h5>
                  
                                      <p class="mb-4">
                                          {{ $message }}
                                      </p>
                  
                                      <a href="{{ route('student.presence.index') }}"
                                         class="btn btn-primary btn-lg">
                                          📍 Presensi Sekarang
                                      </a>
                  
                                  </div>
                  
                                  <div class="col-md-4 text-center">
                                      <div class="emoji-float">
                                          {{ $emoji }}
                                      </div>
                                  </div>
                  
                              </div>
                  
                          </div>
                      </div>
                  </div>
                  
                  <div class="col-lg-4">
                      <div class="card border-0 shadow-sm">
                          <div class="card-body">
                  
                              <h5 class="mb-3">
                                  🏆 Tingkat Kehadiran
                              </h5>
                  
                              <div class="progress" style="height:25px">
                                  <div class="progress-bar bg-success"
                                       style="width: {{ $persentase }}%">
                                      {{ $persentase }}%
                                  </div>
                              </div>
                  
                              <div class="mt-3">
                                  <strong>{{ $persentase }}%</strong> Kehadiran
                              </div>
                  
                          </div>
                      </div>
                  </div>
                
                  
                  </div>
                  
                  <div class="row mt-4">
                  
                
                  <div class="col-md-3">
                      <div class="card border-start border-success border-4">
                          <div class="card-body text-center">
                              <h2>🟢</h2>
                              <h3>{{ $hadir }}</h3>
                              <p class="mb-0">Hadir</p>
                          </div>
                      </div>
                  </div>
                  
                  <div class="col-md-3">
                      <div class="card border-start border-warning border-4">
                          <div class="card-body text-center">
                              <h2>📝</h2>
                              <h3>{{ $izin }}</h3>
                              <p class="mb-0">Izin</p>
                          </div>
                      </div>
                  </div>
                  
                  <div class="col-md-3">
                      <div class="card border-start border-info border-4">
                          <div class="card-body text-center">
                              <h2>🤒</h2>
                              <h3>{{ $sakit }}</h3>
                              <p class="mb-0">Sakit</p>
                          </div>
                      </div>
                  </div>
                  
                  <div class="col-md-3">
                      <div class="card border-start border-danger border-4">
                          <div class="card-body text-center">
                              <h2>🚫</h2>
                              <h3>{{ $alpha }}</h3>
                              <p class="mb-0">Alfa</p>
                          </div>
                      </div>
                  </div>
                
                  
                  </div>
                  
                  <div class="row mt-3">
                      <div class="col-12">
                          <div class="alert alert-info border-0 shadow-sm">
                              {{ $quote }}
                          </div>
                      </div>
                  </div>
                  
              </div>
            </div>
           
          </div>
          <div class="col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
        
                    <h5 class="mb-4 fw-semibold">
                        🕒 Jam Sekarang
                    </h5>
        
                    <div class="clock">
                        <div class="hand hour"></div>
                        <div class="hand minute"></div>
                        <div class="hand second"></div>
                        <div class="center-dot"></div>
                    </div>
        
                    <div id="digitalClock" class="mt-4 fs-5 fw-bold"></div>
        
                </div>
            </div>
        </div>
          </div>
          
        
        </div>
         
    </div>
    
    
@endsection



@push('script')
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    <script src="{{ asset('assets/js/datatable/datatable-advanced.init.js') }}"></script>
    <style>
      .emoji-float{
          font-size: 90px;
          animation: floating 2s ease-in-out infinite;
      }
      
      @keyframes floating{
          0%{
              transform: translateY(0);
          }
          50%{
              transform: translateY(-12px);
          }
          100%{
              transform: translateY(0);
          }
          
      }
      .clock{
    width:220px;
    height:220px;
    border:8px solid #5d87ff;
    border-radius:50%;
    position:relative;
    background:#fff;
}

.hand{
    position:absolute;
    left:50%;
    bottom:50%;
    transform-origin:bottom;
    border-radius:10px;
}

.hour{
    width:6px;
    height:60px;
    background:#333;
}

.minute{
    width:4px;
    height:85px;
    background:#555;
}

.second{
    width:2px;
    height:95px;
    background:red;
}

.center-dot{
    width:14px;
    height:14px;
    background:#333;
    border-radius:50%;
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
}
      </style>
      <script>
        function updateClock() {
    const now = new Date();

    const second = now.getSeconds();
    const minute = now.getMinutes();
    const hour = now.getHours();

    const secondDeg = second * 6;
    const minuteDeg = minute * 6 + second * 0.1;
    const hourDeg = (hour % 12) * 30 + minute * 0.5;

    document.querySelector('.second').style.transform =
        `translateX(-50%) rotate(${secondDeg}deg)`;

    document.querySelector('.minute').style.transform =
        `translateX(-50%) rotate(${minuteDeg}deg)`;

    document.querySelector('.hour').style.transform =
        `translateX(-50%) rotate(${hourDeg}deg)`;

    document.getElementById('digitalClock').innerHTML =
        now.toLocaleTimeString('id-ID');
}

setInterval(updateClock, 1000);
updateClock();
      </script>
@endpush
