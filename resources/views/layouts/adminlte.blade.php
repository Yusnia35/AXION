<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AXION - Monitoring & Sistem Pakar')</title>

    <!--begin::Theme Init (prevents flash of incorrect theme on load)-->
    <script>
      (() => {
        'use strict';
        const root = document.documentElement;
        if (root.getAttribute('data-lte-color-mode') === 'off') {
          return;
        }

        const STORAGE_KEY = 'lte-theme';
        let stored = null;
        try {
          stored = localStorage.getItem(STORAGE_KEY);
        } catch {}

        const authored = root.getAttribute('data-bs-theme');
        let resolved = 'light';
        if (stored === 'dark' || stored === 'light') {
          resolved = stored;
        } else if (authored === 'dark' || authored === 'light') {
          resolved = authored;
        } else if (globalThis.matchMedia('(prefers-color-scheme: dark)').matches) {
          resolved = 'dark';
        }
        root.setAttribute('data-bs-theme', resolved);
        root.style.colorScheme = resolved;
        if (resolved !== authored) {
          root.setAttribute('data-lte-theme-resolved', '');
        }
      })();
    </script>
    <!--end::Theme Init-->

    <!--begin::Preload & Fonts-->
    <link rel="preload" href="{{ asset('adminlte/css/adminlte.min.css') }}" as="style" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,400;0,6..72,500;0,6..72,600;0,6..72,700;1,6..72,500&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,500&display=swap" rel="stylesheet">
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
      media="print"
      onload="this.media = 'all'"
    />
    <!--end::Preload & Fonts-->

    <!--begin::Third Party Plugins-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
      crossorigin="anonymous"
    />
    <!--end::Third Party Plugins-->

    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.min.css') }}" />
    <!--end::Required Plugin(AdminLTE)-->

    <!--begin::Custom Modern Orange & White Theme Styling-->
    <style>
      :root {
        --axion-orange: #ea580c;
        --axion-orange-light: #f97316;
        --axion-orange-dark: #c2410c;
        --axion-orange-soft: #fff7ed;
        --axion-orange-border: #fed7aa;
        --axion-white: #ffffff;
        --axion-bg: #fcf9f6;
        --axion-text: #1e293b;
        --axion-muted: #64748b;
        --bs-primary: #ea580c;
        --bs-primary-rgb: 234, 88, 12;
      }

      body,
      .app-wrapper,
      .app-main {
        background-color: var(--axion-bg) !important;
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        color: var(--axion-text);
      }

      /* Top Navbar */
      .app-header.navbar {
        background-color: #ffffff !important;
        border-bottom: 1px solid #ffedd5 !important;
        box-shadow: 0 2px 12px rgba(234, 88, 12, 0.04);
      }

      /* Sidebar Container (Clean White & Orange Aesthetic) */
      .axion-custom-sidebar {
        background: #ffffff !important;
        border-right: 1px solid #fed7aa !important;
        box-shadow: 4px 0 24px rgba(234, 88, 12, 0.06) !important;
        display: flex !important;
        flex-direction: column !important;
      }

      /* Brand Header */
      .axion-sidebar-brand {
        height: 74px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 8px 16px;
        border-bottom: 1px solid #ffedd5;
        background: linear-gradient(180deg, #fffaf5 0%, #ffffff 100%);
        flex-shrink: 0;
      }
      .brand-link-custom {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        text-decoration: none;
        width: 100%;
        cursor: default;
        pointer-events: none;
        user-select: none;
      }
      .brand-logo-img-box {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
      }
      .brand-img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        transform: scale(1.35);
        display: block;
      }
      .brand-title-text {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 1.45rem;
        font-weight: 800;
        letter-spacing: 0.04em;
        color: #1e293b;
        line-height: 1;
      }

      /* User Profile Section */
      .sidebar-user-section {
        flex-shrink: 0;
      }
      .user-chip-card {
        margin: 12px 14px 6px;
        padding: 10px 12px;
        background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%);
        border: 1px solid #fed7aa;
        border-radius: 14px;
        display: flex;
        align-items: center;
        gap: 11px;
      }
      .user-avatar-initials {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
        color: #ffffff;
        font-weight: 700;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(255, 255, 255, 0.4);
        box-shadow: 0 3px 10px rgba(234, 88, 12, 0.3);
        flex-shrink: 0;
      }
      .user-chip-meta {
        flex: 1;
        min-width: 0;
      }
      .user-chip-name {
        font-size: 0.84rem;
        font-weight: 700;
        color: #1e293b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.2;
        margin-bottom: 3px;
      }
      .role-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 0.68rem;
        font-weight: 700;
        padding: 1px 8px;
        border-radius: 9999px;
        text-transform: uppercase;
        letter-spacing: 0.03em;
      }
      .role-pill-admin {
        background: #ffffff;
        color: #c2410c;
        border: 1px solid #fdba74;
      }
      .role-pill-user {
        background: #ffffff;
        color: #ea580c;
        border: 1px solid #fdba74;
      }
      .role-dot {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        display: inline-block;
      }
      .dot-admin { background: #c2410c; }
      .dot-user { background: #f97316; }

      /* Nav Scroll Area */
      .axion-sidebar-scroll {
        flex: 1 1 auto;
        overflow-y: auto;
        overflow-x: hidden;
        padding-bottom: 12px;
      }
      .axion-sidebar-scroll::-webkit-scrollbar {
        width: 4px;
      }
      .axion-sidebar-scroll::-webkit-scrollbar-thumb {
        background: #fed7aa;
        border-radius: 4px;
      }

      /* Section Headers */
      .axion-nav-header {
        list-style: none;
        font-size: 0.66rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #9a3412;
        opacity: 0.75;
        padding: 14px 18px 4px;
      }

      /* Sidebar Menu & Navigation Links (Edge-to-Edge & Sharp/Lancip) */
      .sidebar-menu {
        padding-left: 0 !important;
        padding-right: 0 !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
        width: 100% !important;
      }
      .sidebar-menu .nav-item {
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
      }

      /* Navigation Links */
      .axion-nav-link {
        display: flex !important;
        align-items: center !important;
        padding: 10px 18px !important;
        margin: 0 !important;
        border-radius: 0 !important;
        width: 100% !important;
        color: #475569 !important;
        font-size: 0.86rem !important;
        font-weight: 600 !important;
        text-decoration: none !important;
        transition: background 0.15s ease, color 0.15s ease !important;
        border: none !important;
        background: transparent !important;
      }
      .axion-nav-link:hover {
        background: #fff7ed !important;
        color: #ea580c !important;
        border-radius: 0 !important;
        transform: none !important;
      }
      .axion-nav-link.active {
        background: linear-gradient(135deg, #f97316 0%, #ea580c 100%) !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        border-radius: 0 !important;
        box-shadow: none !important;
      }
      .axion-nav-link.parent-active {
        color: #ea580c !important;
        background: #fff7ed !important;
        border-radius: 0 !important;
      }

      /* Nav Icons */
      .nav-icon-box {
        width: 28px;
        height: 28px;
        border-radius: 0 !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        margin-right: 10px;
        color: #ea580c;
        background: #fff7ed;
        transition: all 0.2s ease;
        flex-shrink: 0;
      }
      .axion-nav-link:hover .nav-icon-box {
        color: #c2410c;
        background: #ffedd5;
        border-radius: 0 !important;
      }
      .axion-nav-link.active .nav-icon-box {
        color: #ffffff !important;
        background: rgba(255, 255, 255, 0.22);
        border-radius: 0 !important;
      }

      .nav-label {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
      }

      /* Unified Orange & White Badges */
      .axion-badge {
        font-size: 0.66rem;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 9999px;
      }
      .badge-amber,
      .badge-blue,
      .badge-teal,
      .badge-rose {
        background: #fff7ed;
        color: #ea580c;
        border: 1px solid #fdba74;
      }
      .axion-nav-link.active .axion-badge {
        background: #ffffff;
        color: #ea580c;
        border-color: #ffffff;
      }

      /* Treeview & Submenu */
      .kandang-submenu {
        list-style: none;
        padding-left: 18px !important;
        margin: 4px 10px 6px 24px !important;
        border-left: 2px solid #fed7aa !important;
      }
      .axion-sub-link {
        padding: 6px 10px !important;
        font-size: 0.82rem !important;
        color: #64748b !important;
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
        border-radius: 0 !important;
        text-decoration: none !important;
        transition: all 0.2s ease !important;
        background: transparent !important;
      }
      .axion-sub-link:hover {
        color: #ea580c !important;
        background: #fff7ed !important;
      }
      .axion-sub-link.active {
        color: #ea580c !important;
        font-weight: 700 !important;
        background: #ffedd5 !important;
      }
      .sub-link-dot {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: #cbd5e1;
        display: inline-block;
        transition: all 0.2s ease;
      }
      .axion-sub-link.active .sub-link-dot {
        background: #ea580c;
        box-shadow: 0 0 6px #f97316;
      }
      .nav-arrow {
        font-size: 0.75rem;
        transition: transform 0.25s ease;
        color: #94a3b8;
      }
      .menu-open > .kandang-menu-toggle .nav-arrow {
        transform: rotate(90deg);
        color: #ea580c;
      }

      /* Bottom Quick Panel */
      .sidebar-bottom-panel {
        flex-shrink: 0;
        padding: 12px 14px;
        border-top: 1px solid #ffedd5;
        background: #fffaf5;
        display: flex;
        gap: 8px;
      }
      .bottom-action-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 8px 10px;
        border-radius: 10px;
        font-size: 0.8rem;
        font-weight: 700;
        text-decoration: none;
        color: #c2410c;
        background: #fff7ed;
        border: 1px solid #fed7aa;
        transition: all 0.2s ease;
        flex: 1;
        cursor: pointer;
      }
      .bottom-action-btn:hover,
      .btn-logout:hover {
        background: linear-gradient(135deg, #f97316 0%, #ea580c 100%) !important;
        color: #ffffff !important;
        border-color: #ea580c !important;
        box-shadow: 0 4px 12px rgba(234, 88, 12, 0.25);
      }

      /* Global Uniform Page Header & Component Styling (Orange & White) */
      .kandang-kicker {
        font-size: 0.74rem !important;
        letter-spacing: 0.12em !important;
        color: #ea580c !important;
        font-weight: 800 !important;
        text-transform: uppercase !important;
      }
      .kandang-hero-title,
      .app-content-header h3 {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        font-size: 2rem !important;
        font-weight: 800 !important;
        color: #1e293b !important;
        letter-spacing: -0.02em !important;
        line-height: 1.2 !important;
      }
      .kandang-hero-subtitle {
        font-size: 0.88rem !important;
        color: #64748b !important;
      }

      /* Global Cards, Buttons, Tables & Badges Consistency */
      .card {
        background-color: #ffffff;
        border: 1px solid #ffedd5 !important;
        border-radius: 18px !important;
        box-shadow: 0 4px 18px rgba(234, 88, 12, 0.05) !important;
      }
      .btn-primary,
      .btn-tambah-kandang,
      .btn-success {
        background: linear-gradient(135deg, #f97316 0%, #ea580c 100%) !important;
        border-color: #ea580c !important;
        color: #ffffff !important;
        font-weight: 600 !important;
        box-shadow: 0 4px 14px rgba(234, 88, 12, 0.25) !important;
        transition: all 0.2s ease !important;
      }
      .btn-primary:hover,
      .btn-tambah-kandang:hover,
      .btn-success:hover {
        background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%) !important;
        border-color: #c2410c !important;
        color: #ffffff !important;
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(234, 88, 12, 0.35) !important;
      }
      .btn-outline-primary,
      .btn-outline-secondary {
        border-color: #fdba74 !important;
        color: #c2410c !important;
        background-color: #ffffff !important;
        font-weight: 600 !important;
      }
      .btn-outline-primary:hover,
      .btn-outline-secondary:hover {
        background-color: #fff7ed !important;
        border-color: #ea580c !important;
        color: #ea580c !important;
      }
      .table thead.table-light th,
      .table thead th {
        background-color: #fff7ed !important;
        color: #9a3412 !important;
        border-bottom: 1.5px solid #fed7aa !important;
        font-weight: 700 !important;
      }
      .form-control:focus,
      .form-select:focus {
        border-color: #ea580c !important;
        box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.18) !important;
      }
      .app-footer {
        background-color: #ffffff !important;
        border-top: 1px solid #ffedd5 !important;
      }
      .app-content {
        padding-top: 1.5rem !important;
        padding-bottom: 2rem !important;
      }
    </style>
    <!--end::Custom Modern Orange & White Theme Styling-->

    @stack('styles')
  </head>
  <!--end::Head-->

  <!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      @include('layouts.partials.navbar')

      @include('layouts.partials.sidebar')

      <!--begin::App Main-->
      <main class="app-main">
        @unless (View::hasSection('hide_header'))
        <!--begin::App Content Header-->
        <div class="app-content-header py-3 border-bottom mb-3">
          <div class="container-fluid">
            <div class="row align-items-center">
              <div class="col-sm-6">
                <h3 class="mb-0 fw-bold">@yield('page_title', 'Dashboard')</h3>
                @hasSection('page_subtitle')
                  <p class="text-secondary mb-0 fs-7">@yield('page_subtitle')</p>
                @endif
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end mb-0">
                  @section('breadcrumbs')
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Ikhtisar</li>
                  @show
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!--end::App Content Header-->
        @endunless

        <!--begin::App Content-->
        <div class="app-content">
          <div class="container-fluid">
            @yield('content')
          </div>
        </div>
        <!--end::App Content-->
      </main>
      <!--end::App Main-->
    </div>
    <!--end::App Wrapper-->

    <!--begin::Script-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script
      src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
      crossorigin="anonymous"
    ></script>
    <!--end::Third Party Plugin(OverlayScrollbars)-->

    <!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)-->

    <!--begin::Required Plugin(Bootstrap 5)-->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"
      crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(Bootstrap 5)-->

    <!--begin::Required Plugin(AdminLTE)-->
    <script src="{{ asset('adminlte/js/adminlte.min.js') }}"></script>
    <!--end::Required Plugin(AdminLTE)-->

    <!--begin::OverlayScrollbars Configure-->
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
        const isMobile = window.innerWidth <= 992;

        if (sidebarWrapper && typeof OverlayScrollbarsGlobal !== 'undefined' && !isMobile) {
          OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
            scrollbars: {
              theme: 'os-theme-light',
              autoHide: 'leave',
              clickScroll: true,
            },
          });
        }
      });
    </script>
    <!--end::OverlayScrollbars Configure-->

    @stack('scripts')
  </body>
  <!--end::Body-->
</html>
