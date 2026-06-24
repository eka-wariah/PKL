<aside class="left-sidebar with-vertical">
  <div><!-- ---------------------------------- -->
      <!-- Start Vertical Layout Sidebar -->
      <!-- ---------------------------------- -->
      <div class="brand-logo d-flex align-items-center justify-content-between">
    
        <a href="../main/index.html" class="text-nowrap logo-img d-flex align-items-center">
            
            <!-- Logo -->
            <img
                class="logo-icon"
                src="{{ asset('assets/images/logos/1.png') }}"
                width="45"
                alt="Logo">
    
            <!-- Text -->
            <span class="logo-text ms-2">
                SIPKL
            </span>
    
        </a>
    
        <a href="javascript:void(0)"
            class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
            <i class="ti ti-x"></i>
        </a>
    
    </div>
    
    <style>
    /* Logo */
    .logo-icon {
        animation: logoZoom .5s ease;
    }
    
    /* Tulisan SIPKL */
    .logo-text {
        font-size: 22px;
        font-weight: 700;
        white-space: nowrap;
    
        opacity: 0;
        transform: translateX(-30px);
    
        animation: slideText .7s ease forwards;
        animation-delay: .35s;
    }
    
    /* Logo muncul dulu */
    @keyframes logoZoom {
        from {
            opacity: 0;
            transform: scale(.7);
        }
    
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
    
    /* SIPKL keluar dari samping logo */
    @keyframes slideText {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
    
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    </style>


      <nav class="sidebar-nav scroll-sidebar" data-simplebar>
          <ul id="sidebarnav">
              <!-- ---------------------------------- -->
              <!-- Home -->
              <!-- ---------------------------------- -->
              <li class="nav-small-cap">
                  <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                  <span class="hide-menu">Dashboard</span>
              </li>
              <!-- ---------------------------------- -->
              <!-- Dashboard -->
              <!-- ---------------------------------- -->
              <li class="sidebar-item">
                  <a class="sidebar-link" href="/student/" aria-expanded="false">
                      <span>
                          <i class="ti ti-aperture"></i>
                      </span>
                      <span class="hide-menu">Dashboard</span>
                  </a>
              </li>
              <li class="nav-small-cap">
                  <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                  <span class="hide-menu">Kegiatan PKL</span>
              </li>
              <li class="sidebar-item">
                  <a class="sidebar-link" href="/student/presence/" aria-expanded="false">
                      <span>
                        <i class="ti ti-calendar-user"></i>
                      </span>
                      <span class="hide-menu">Presensi</span>
                  </a>
              </li>
          </ul>
      </nav>

      <div class="fixed-profile p-3 mx-4 mb-2 bg-secondary-subtle rounded mt-3">
        <div class="hstack gap-3">
          <div class="john-img">
            <img src="{{ asset('assets/images/profile/user-1.jpg')}}" class="rounded-circle" width="40" height="40" alt="modernize-img" />
          </div>
          <div class="john-title">
            <h6 class="mb-0 fs-4 fw-semibold">{{ Auth::user()->name }}</h6>
            <span class="fs-2"> {{ auth()->user()->getRoleNames()->first() ?? '-' }}</span>
          </div>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
          <button class="border-0 bg-transparent text-primary ms-auto" tabindex="0" type="submit" aria-label="logout" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="logout">
            <i class="ti ti-power fs-6"></i>
          </button>
        </form>
        </div>
      </div>

      <!-- ---------------------------------- -->
      <!-- Start Vertical Layout Sidebar -->
      <!-- ---------------------------------- -->
  </div>
</aside>
