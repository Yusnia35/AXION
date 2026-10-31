<!--begin::Sidebar-->
<aside class="app-sidebar axion-custom-sidebar" data-bs-theme="light">

  <!-- BRAND HEADER WITH OFFICIAL AXION LOGO -->
  <div class="axion-sidebar-brand">
    <div class="brand-link-custom">
      <div class="brand-logo-img-box">
        <img src="{{ asset('images/axion.jpeg') }}" alt="AXION" class="brand-img">
      </div>
      <span class="brand-title-text">AXION</span>
    </div>
  </div>

  <!-- MAIN NAVIGATION MENU -->
  <div class="sidebar-wrapper axion-sidebar-scroll">
    <nav class="mt-1" aria-label="Main navigation">
      <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

        <!-- DASHBOARD -->
        <li class="nav-item">
          <a href="{{ route('dashboard') }}" class="nav-link axion-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <span class="nav-icon-box"><i class="bi bi-grid-1x2-fill"></i></span>
            <span class="nav-label">Dashboard Utama</span>
          </a>
        </li>

        <!-- SECTION: OPERASIONAL KANDANG & IOT -->
        <li class="axion-nav-header">
          <span>OPERASIONAL & IOT</span>
        </li>

        <!-- KANDANG SAYA -->
        <li class="nav-item">
          <a href="{{ route('kandang.index') }}" class="nav-link axion-nav-link {{ request()->routeIs('kandang.*') ? 'active' : '' }}">
            <span class="nav-icon-box"><i class="bi bi-house-door-fill"></i></span>
            <span class="nav-label">Daftar Kandang</span>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('sensor.index') }}" class="nav-link axion-nav-link {{ request()->routeIs('sensor.*') ? 'active' : '' }}">
            <span class="nav-icon-box"><i class="bi bi-router"></i></span>
            <span class="nav-label">Sensor IoT</span>
            <span class="axion-badge badge-teal ms-auto">ESP32</span>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('monitoring.suhu') }}" class="nav-link axion-nav-link {{ request()->routeIs('monitoring.*') ? 'active' : '' }}">
            <span class="nav-icon-box"><i class="bi bi-thermometer-half"></i></span>
            <span class="nav-label">Monitoring Suhu</span>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('kondisi-lingkungan.index') }}" class="nav-link axion-nav-link {{ request()->routeIs('kondisi-lingkungan.*') ? 'active' : '' }}">
            <span class="nav-icon-box"><i class="bi bi-wind"></i></span>
            <span class="nav-label">Kondisi Lingkungan</span>
          </a>
        </li>

        <!-- SECTION: DATA & KESEHATAN AYAM -->
        <li class="axion-nav-header">
          <span>DATA POPULASI & FLOK</span>
        </li>

        <li class="nav-item">
          <a href="{{ route('kelompok-ayam.index') }}" class="nav-link axion-nav-link {{ request()->routeIs('kelompok-ayam.*') ? 'active' : '' }}">
            <span class="nav-icon-box"><i class="bi bi-collection-fill"></i></span>
            <span class="nav-label">Kelompok Ayam</span>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('pemeriksaan-ayam.index') }}" class="nav-link axion-nav-link {{ request()->routeIs('pemeriksaan-ayam.*') ? 'active' : '' }}">
            <span class="nav-icon-box"><i class="bi bi-clipboard2-pulse-fill"></i></span>
            <span class="nav-label">Pemeriksaan Gejala</span>
          </a>
        </li>

        <!-- SECTION: SISTEM PAKAR (FORWARD CHAINING) -->
        <li class="axion-nav-header">
          <span>SISTEM PAKAR</span>
        </li>

        <li class="nav-item">
          <a href="{{ route('rules.index') }}" class="nav-link axion-nav-link {{ request()->routeIs('rules.*') ? 'active' : '' }}">
            <span class="nav-icon-box"><i class="bi bi-journal-check"></i></span>
            <span class="nav-label">Basis Aturan</span>
            <span class="axion-badge badge-amber ms-auto">8 Rules</span>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('analisis.index') }}" class="nav-link axion-nav-link {{ request()->routeIs('analisis.*') ? 'active' : '' }}">
            <span class="nav-icon-box"><i class="bi bi-lightning-charge-fill"></i></span>
            <span class="nav-label">Hasil Diagnosa</span>
            <span class="axion-badge badge-blue ms-auto">FC Engine</span>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('rekomendasi.index') }}" class="nav-link axion-nav-link {{ request()->routeIs('rekomendasi.*') ? 'active' : '' }}">
            <span class="nav-icon-box"><i class="bi bi-shield-check"></i></span>
            <span class="nav-label">Rekomendasi Tindakan</span>
          </a>
        </li>

        <!-- SECTION: RIWAYAT & ARSIP -->
        <li class="axion-nav-header">
          <span>RIWAYAT & PELAPORAN</span>
        </li>

        <li class="nav-item">
          <a href="{{ route('riwayat.index') }}" class="nav-link axion-nav-link {{ request()->routeIs('riwayat.*') ? 'active' : '' }}">
            <span class="nav-icon-box"><i class="bi bi-clock-history"></i></span>
            <span class="nav-label">Riwayat Analisis</span>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('laporan.index') }}" class="nav-link axion-nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
            <span class="nav-icon-box"><i class="bi bi-file-earmark-bar-graph-fill"></i></span>
            <span class="nav-label">Laporan & Ekspor</span>
          </a>
        </li>

        <!-- SECTION: KHUSUS ADMINISTRATOR -->
        @if (($currentUser->role ?? '') === 'admin')
        <li class="axion-nav-header">
          <span>KONTROL SISTEM</span>
        </li>

        <li class="nav-item">
          <a href="{{ route('users.index') }}" class="nav-link axion-nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <span class="nav-icon-box"><i class="bi bi-people-fill"></i></span>
            <span class="nav-label">Manajemen User</span>
            <span class="axion-badge badge-rose ms-auto">Admin</span>
          </a>
        </li>
        @endif

      </ul>
    </nav>
  </div>

</aside>
<!--end::Sidebar-->