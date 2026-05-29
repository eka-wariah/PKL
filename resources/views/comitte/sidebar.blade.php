<aside class="left-sidebar with-vertical">
    <div><!-- ---------------------------------- -->
      <!-- Start Vertical Layout Sidebar -->
      <!-- ---------------------------------- -->
      <div class="brand-logo d-flex align-items-center justify-content-between">
        <a href="../main/index.html" class="text-nowrap logo-img">
          <img src="{{ asset('assets/images/logos/dark-logo.svg')}}" class="dark-logo" alt="Logo-Dark" />
          <img src="{{ asset('assets/images/logos/light-logo.svg')}}" class="light-logo" alt="Logo-light" />
        </a>
        <a href="javascript:void(0)" class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
          <i class="ti ti-x"></i>
        </a>
      </div>

      <nav class="sidebar-nav scroll-sidebar" data-simplebar>
        @php
    $dashboardActive = request()->routeIs('comitte.index*') ? 'active' : '';
    $studentActive = request()->routeIs('comitte.student.*') ? 'active' : '';
    $teacherActive = request()->routeIs('comitte.teacher.*') ? 'active' : '';
    $academicActive = request()->routeIs('comitte.academic-years.*') ? 'active' : '';
    $majorActive = request()->routeIs('comitte.major.*') ? 'active' : '';
    $classActive = request()->routeIs('comitte.classes.*') ? 'active' : '';
    $companyActive = request()->routeIs('comitte.company.*') ? 'active' : '';
        @endphp
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
            <a class="sidebar-link {{ $dashboardActive }}" href="/comitte/"  aria-expanded="false">
              <span>
                <i class="ti ti-aperture"></i>
              </span>
              <span class="hide-menu">Dashboard</span>
            </a>
          </li>
          <!-- ---------------------------------- -->
          <!-- akademik -->
          <!-- ---------------------------------- -->
          <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
<<<<<<< HEAD
            <span class="hide-menu">Akademik</span>
=======
            <span class="hide-menu">Data Siswa</span>
>>>>>>> 8f2ae9cfecebc6d2650792c1ce3f356bbae9628d
          </li>
          <!-- ---------------------------------- -->
          <!-- Dashboard -->
          <!-- ---------------------------------- -->
          <li class="sidebar-item">
<<<<<<< HEAD
            <a class="sidebar-link" href="/comitte/academic-years/"  aria-expanded="false">
              <span>
                <i class="ti ti-user"></i>
              </span>
              <span class="hide-menu">Tahun Ajaran</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="/comitte/major/"  aria-expanded="false">
              <span>
                <i class="ti ti-user"></i>
              </span>
              <span class="hide-menu">Jurusan</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="/comitte/classes/"  aria-expanded="false">
              <span>
                <i class="ti ti-user"></i>
              </span>
              <span class="hide-menu">Kelas</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="/comitte/company/"  aria-expanded="false">
              <span>
                <i class="ti ti-user"></i>
              </span>
              <span class="hide-menu">Perusahaan</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="/comitte/student/"  aria-expanded="false">
=======
            <a class="sidebar-link {{ $studentActive }}" href="/comitte/student/"  aria-expanded="false">
>>>>>>> 8f2ae9cfecebc6d2650792c1ce3f356bbae9628d
              <span>
                <i class="ti ti-user"></i>
              </span>
              <span class="hide-menu">Siswa</span>
            </a>
          </li>
         
          <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">Data Guru</span>
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link {{ $teacherActive }}" href="/comitte/teacher/"  aria-expanded="false">
              <span>
                <i class="ti ti-users"></i>
              </span>
              <span class="hide-menu">Guru</span>
            </a>
          </li>

          <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">Akademik</span>
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link {{ $academicActive }}" href="/comitte/academic-years/"  aria-expanded="false">
              <span>
               <i class="ti ti-building-skyscraper"></i>
              </span>
              <span class="hide-menu">Tahun Ajaran</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link {{ $majorActive }}" href="/comitte/major/"  aria-expanded="false">
              <span>
                <i class="ti ti-brain"></i>
              </span>
              <span class="hide-menu">Jurusan</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link {{ $classActive }}" href="/comitte/classes/"  aria-expanded="false">
              <span>
                <i class="ti ti-file-text-spark"></i>
              </span>
              <span class="hide-menu">Kelas</span>
            </a>
          </li>

          <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">Hubungan Industri</span>
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link {{ $companyActive }}" href="/comitte/company/"  aria-expanded="false">
              <span>
                <i class="ti ti-building-skyscraper"></i>
              </span>
              <span class="hide-menu">Perusahaan</span>
            </a>
          </li>



      </nav>

      <div class="fixed-profile p-3 mx-4 mb-2 bg-secondary-subtle rounded mt-3">
        <div class="hstack gap-3">
          <div class="john-img">
            <img src="{{ asset('assets/images/profile/user-1.jpg')}}" class="rounded-circle" width="40" height="40" alt="modernize-img" />
          </div>
          <div class="john-title">
            <h6 class="mb-0 fs-4 fw-semibold">Mathew</h6>
            <span class="fs-2">Designer</span>
          </div>
          <button class="border-0 bg-transparent text-primary ms-auto" tabindex="0" type="button" aria-label="logout" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="logout">
            <i class="ti ti-power fs-6"></i>
          </button>
        </div>
      </div>

      <!-- ---------------------------------- -->
      <!-- Start Vertical Layout Sidebar -->
      <!-- ---------------------------------- -->
    </div>
  </aside>