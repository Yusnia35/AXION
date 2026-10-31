<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Login - AXION Monitoring</title>

  <!-- Google Fonts: Outfit & Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <style>
    :root {
      --coop-primary: #c2410c;
      --coop-deep: #9a3412;
      --coop-bright: #ea580c;
      --coop-amber: #f59e0b;
      --coop-cream: #fffaf5;
      --coop-peach: #ffedd5;
      --text-dark: #1e293b;
      --text-muted: #64748b;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 1.5rem;
      background: linear-gradient(135deg, #f5ebe1 0%, #fae5d3 50%, #f3d5b5 100%);
      color: var(--text-dark);
      position: relative;
      overflow-x: hidden;
    }

    /* Decorative Background Ribbons (like reference outer canvas) */
    body::before,
    body::after {
      content: '';
      position: fixed;
      z-index: 0;
      pointer-events: none;
      background: rgba(234, 88, 12, 0.08);
      border-radius: 24px;
    }

    body::before {
      width: 140px;
      height: 120vh;
      top: -10vh;
      left: 18%;
      transform: rotate(-12deg);
    }

    body::after {
      width: 180px;
      height: 120vh;
      top: -10vh;
      right: 12%;
      transform: rotate(28deg);
    }

    /* Main Widescreen Card Container */
    .auth-showcase-wrapper {
      position: relative;
      z-index: 2;
      width: 100%;
      max-width: 1060px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .auth-showcase-card {
      position: relative;
      width: 100%;
      min-height: 610px;
      background: #fffaf5;
      border-radius: 22px;
      box-shadow: 0 30px 70px -15px rgba(124, 45, 18, 0.25),
                  0 10px 30px -10px rgba(0, 0, 0, 0.08),
                  0 0 0 1px rgba(254, 215, 170, 0.8);
      overflow: hidden;
      display: flex;
    }

    /* ============================================================
       LEFT UNDERLAY: LOGIN FORM PANEL (Revealed when wave slides right)
    ============================================================ */
    .login-form-panel {
      position: absolute;
      top: 0;
      left: 0;
      width: 50%;
      height: 100%;
      z-index: 5;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 30px 42px;
      background: linear-gradient(180deg, #ffffff 0%, #fffaf5 100%);
      opacity: 0;
      visibility: hidden;
      transform: translateX(-50px);
      transition: opacity 0.65s cubic-bezier(0.77, 0, 0.175, 1),
                  transform 0.75s cubic-bezier(0.77, 0, 0.175, 1),
                  visibility 0.65s;
      overflow-y: auto;
    }

    .auth-showcase-card.is-signin-active .login-form-panel {
      opacity: 1;
      visibility: visible;
      transform: translateX(0);
      transition-delay: 0.12s;
    }

    .form-inner-box {
      width: 100%;
      max-width: 370px;
      text-align: center;
    }

    .login-heading {
      font-family: 'Outfit', sans-serif;
      font-size: 2rem;
      font-weight: 800;
      color: #0f172a;
      letter-spacing: -0.02em;
      margin-bottom: 22px;
    }

    /* Form Controls */
    .login-form {
      display: flex;
      flex-direction: column;
      gap: 14px;
    }

    .form-group-item {
      display: flex;
      flex-direction: column;
      gap: 6px;
      text-align: left;
      width: 100%;
    }

    .input-label {
      display: block;
      font-size: 0.82rem;
      font-weight: 700;
      color: #334155;
      padding-left: 18px;
      letter-spacing: 0.01em;
      margin-bottom: 0;
      text-align: left;
      cursor: pointer;
    }

    .input-field-wrap {
      position: relative;
      width: 100%;
    }

    .input-icon-left {
      position: absolute;
      left: 18px;
      top: 50%;
      transform: translateY(-50%);
      color: #ea580c;
      font-size: 1.05rem;
      pointer-events: none;
    }

    .pill-input {
      width: 100%;
      height: 48px;
      border: 1.5px solid #fed7aa;
      outline: none;
      border-radius: 9999px;
      background: #ffffff;
      padding: 0 44px 0 46px;
      font-size: 0.92rem;
      color: #0f172a;
      font-family: inherit;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
      transition: all 0.25s ease;
    }

    .pill-input::placeholder {
      color: #94a3b8;
    }

    .pill-input:focus {
      border-color: #ea580c;
      box-shadow: 0 0 0 3.5px rgba(249, 115, 22, 0.2),
                  0 4px 14px rgba(234, 88, 12, 0.1);
    }

    .toggle-pass-btn {
      position: absolute;
      right: 16px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #94a3b8;
      cursor: pointer;
      font-size: 1.1rem;
      padding: 4px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: color 0.2s ease;
    }

    .toggle-pass-btn:hover {
      color: #ea580c;
    }

    .form-meta-row {
      display: flex;
      align-items: center;
      justify-content: flex-end;
      margin-top: 2px;
      margin-bottom: 6px;
      padding: 0 4px;
    }

    .slide-back-link {
      font-size: 0.8rem;
      color: #64748b;
      background: none;
      border: none;
      cursor: pointer;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 4px;
      transition: color 0.2s ease;
    }

    .slide-back-link:hover {
      color: #ea580c;
    }

    .forgot-link {
      font-size: 0.82rem;
      color: #ea580c;
      background: none;
      border: none;
      font-weight: 700;
      cursor: pointer;
      transition: color 0.2s ease;
    }

    .forgot-link:hover {
      color: #9a3412;
      text-decoration: underline;
    }

    .btn-login-submit {
      width: 100%;
      height: 48px;
      border-radius: 9999px;
      background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%);
      color: #ffffff;
      border: none;
      font-size: 0.96rem;
      font-weight: 700;
      letter-spacing: 0.04em;
      text-transform: uppercase;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      box-shadow: 0 8px 22px rgba(194, 65, 12, 0.35);
      transition: all 0.25s ease;
      font-family: 'Outfit', sans-serif;
    }

    .btn-login-submit:hover {
      background: linear-gradient(135deg, #c2410c 0%, #9a3412 100%);
      transform: translateY(-2px);
      box-shadow: 0 12px 28px rgba(194, 65, 12, 0.45);
    }

    /* Alerts */
    .glass-alert {
      border-radius: 14px;
      padding: 10px 14px;
      font-size: 0.82rem;
      margin-bottom: 14px;
      text-align: left;
    }

    .glass-alert-danger {
      background: #fef2f2;
      color: #991b1b;
      border: 1px solid #fecaca;
      border-left: 4px solid #ef4444;
    }

    .glass-alert-info {
      background: #fff7ed;
      color: #9a3412;
      border: 1px solid #fed7aa;
      border-left: 4px solid #f97316;
    }

    /* ============================================================
       RIGHT UNDERLAY: AXION LOGO SHOWCASE STAGE
    ============================================================ */
    .illustration-stage {
      position: relative;
      margin-left: auto;
      width: 55%;
      min-height: 610px;
      background: #ffffff;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 40px 40px 40px 70px;
      overflow: hidden;
      z-index: 2;
      transition: transform 0.85s cubic-bezier(0.77, 0, 0.175, 1),
                  opacity 0.65s ease;
      user-select: none;
      pointer-events: none;
    }

    .auth-showcase-card.is-signin-active .illustration-stage {
      transform: translateX(-8%);
    }

    .axion-hero-logo-wrap {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      position: relative;
      z-index: 2;
    }

    .axion-hero-logo-img {
      width: 320px;
      max-width: 100%;
      height: auto;
      object-fit: contain;
      display: block;
      margin-bottom: 6px;
    }

    .axion-hero-logo-title {
      font-family: 'Outfit', sans-serif;
      font-size: 2.6rem;
      font-weight: 800;
      letter-spacing: 0.08em;
      color: #1e293b;
      line-height: 1.1;
      margin-bottom: 6px;
    }

    .axion-hero-logo-subtitle {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 0.82rem;
      font-weight: 700;
      letter-spacing: 0.22em;
      text-transform: uppercase;
      color: #ea580c;
    }

    /* ============================================================
       SLIDING WAVE OVERLAY PANEL (Starts Left, Slides Right on Sign In)
    ============================================================ */
    .wave-overlay-panel {
      position: absolute;
      top: 0;
      left: 0;
      width: 50%;
      height: 100%;
      z-index: 10;
      background: linear-gradient(145deg, #d9460f 0%, #b83209 52%, #8f2406 100%);
      color: #ffffff;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 42px 48px;
      transition: transform 0.88s cubic-bezier(0.77, 0, 0.175, 1),
                  background 0.88s ease;
    }

    /* Slide to the Right when Sign In is active! */
    .auth-showcase-card.is-signin-active .wave-overlay-panel {
      transform: translateX(100%);
    }

    /* Organic Wavy Edge on Right Side of Panel (Initial State) */
    .wave-edge-right {
      position: absolute;
      top: 0;
      right: -108px;
      width: 110px;
      height: 100%;
      pointer-events: none;
      z-index: 11;
      transition: opacity 0.45s ease, transform 0.88s cubic-bezier(0.77, 0, 0.175, 1);
    }

    /* Organic Wavy Edge on Left Side of Panel (When Slid to Right) */
    .wave-edge-left {
      position: absolute;
      top: 0;
      left: -108px;
      width: 110px;
      height: 100%;
      pointer-events: none;
      z-index: 11;
      opacity: 0;
      transform: scaleX(-1);
      transition: opacity 0.45s ease, transform 0.88s cubic-bezier(0.77, 0, 0.175, 1);
    }

    .auth-showcase-card.is-signin-active .wave-edge-right {
      opacity: 0;
    }

    .auth-showcase-card.is-signin-active .wave-edge-left {
      opacity: 1;
    }

    /* Decorative Geometric Shapes Inside Wave Panel (matching reference) */
    .geo-shapes-layer {
      position: absolute;
      inset: 0;
      overflow: hidden;
      pointer-events: none;
      z-index: 1;
    }

    .geo-ring-top {
      position: absolute;
      width: 220px;
      height: 220px;
      border-radius: 50%;
      border: 30px solid rgba(90, 18, 4, 0.25);
      top: -115px;
      left: 26%;
    }

    .geo-ring-bottom {
      position: absolute;
      width: 310px;
      height: 310px;
      border-radius: 50%;
      border: 42px solid rgba(90, 18, 4, 0.25);
      bottom: -110px;
      left: -95px;
    }

    .geo-square-left {
      position: absolute;
      width: 130px;
      height: 130px;
      border-radius: 26px;
      border: 22px solid rgba(90, 18, 4, 0.22);
      top: 18%;
      left: -55px;
      transform: rotate(-18deg);
    }

    .geo-diamond-small {
      position: absolute;
      width: 52px;
      height: 52px;
      border-radius: 12px;
      border: 10px solid rgba(90, 18, 4, 0.26);
      top: 22%;
      right: 16%;
      transform: rotate(22deg);
    }

    .geo-circle-mid {
      position: absolute;
      width: 68px;
      height: 68px;
      border-radius: 50%;
      border: 14px solid rgba(90, 18, 4, 0.28);
      top: 49%;
      right: 4%;
    }

    /* Wave Panel Content States */
    .wave-content-welcome,
    .wave-content-active {
      position: relative;
      z-index: 15;
      text-align: center;
      max-width: 340px;
      transition: opacity 0.45s ease, transform 0.55s ease;
    }

    .wave-content-welcome {
      opacity: 1;
      transform: translateX(0);
    }

    .wave-content-active {
      position: absolute;
      opacity: 0;
      pointer-events: none;
      transform: translateX(40px);
    }

    .auth-showcase-card.is-signin-active .wave-content-welcome {
      opacity: 0;
      pointer-events: none;
      transform: translateX(-40px);
    }

    .auth-showcase-card.is-signin-active .wave-content-active {
      opacity: 1;
      pointer-events: auto;
      transform: translateX(0);
      transition-delay: 0.25s;
    }

    .welcome-title {
      font-family: 'Outfit', sans-serif;
      font-size: 2.55rem;
      font-weight: 800;
      letter-spacing: -0.01em;
      margin-bottom: 16px;
      color: #ffffff;
      text-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
    }

    .welcome-desc {
      font-size: 0.98rem;
      line-height: 1.65;
      color: rgba(255, 255, 255, 0.9);
      font-weight: 500;
      margin-bottom: 34px;
    }

    /* Pill Outline SIGN IN Button (Matches Reference Image) */
    .btn-wave-outline {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      min-width: 215px;
      height: 52px;
      padding: 0 36px;
      border-radius: 9999px;
      border: 2px solid #ffffff;
      background: rgba(255, 255, 255, 0.08);
      color: #ffffff;
      font-family: 'Outfit', sans-serif;
      font-size: 0.95rem;
      font-weight: 700;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      cursor: pointer;
      transition: all 0.3s ease;
      backdrop-filter: blur(4px);
    }

    .btn-wave-outline:hover {
      background: #ffffff;
      color: #b83209;
      transform: translateY(-2px) scale(1.03);
      box-shadow: 0 12px 28px rgba(0, 0, 0, 0.22);
    }

    .btn-wave-outline:active {
      transform: translateY(0) scale(0.99);
    }

    /* Content inside Wave Panel when Slid to the Right */
    .coop-feature-badges {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
      justify-content: center;
      margin-bottom: 24px;
    }

    .coop-pill-tag {
      background: rgba(255, 255, 255, 0.14);
      border: 1px solid rgba(255, 255, 255, 0.28);
      color: #ffffff;
      padding: 6px 14px;
      border-radius: 9999px;
      font-size: 0.78rem;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }

    /* Bottom Back Navigation */
    .bottom-nav {
      margin-top: 18px;
      text-align: center;
    }

    .landing-back-link {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      color: #9a3412;
      font-size: 0.85rem;
      font-weight: 700;
      text-decoration: none;
      padding: 9px 22px;
      border-radius: 9999px;
      background: rgba(255, 255, 255, 0.88);
      backdrop-filter: blur(8px);
      border: 1.5px solid rgba(254, 215, 170, 0.95);
      box-shadow: 0 4px 14px rgba(194, 65, 12, 0.12);
      transition: all 0.2s ease;
    }

    .landing-back-link:hover {
      background: #ffffff;
      color: #ea580c;
      border-color: #f97316;
      transform: translateY(-1px);
    }

    /* Modal for Forgot Password */
    .custom-modal {
      display: none;
      position: fixed;
      inset: 0;
      z-index: 999;
      background: rgba(15, 23, 42, 0.45);
      backdrop-filter: blur(8px);
      align-items: center;
      justify-content: center;
      padding: 1rem;
    }

    .custom-modal.show {
      display: flex;
    }

    .modal-box {
      background: #ffffff;
      border: 1.5px solid #fed7aa;
      border-radius: 28px;
      max-width: 420px;
      width: 100%;
      padding: 32px 28px;
      text-align: center;
      box-shadow: 0 25px 60px rgba(234, 88, 12, 0.2);
      animation: modalPop 0.25s ease-out;
      color: #0f172a;
    }

    @keyframes modalPop {
      from { opacity: 0; transform: scale(0.92); }
      to { opacity: 1; transform: scale(1); }
    }

    /* Responsive adjustments */
    @media (max-width: 900px) {
      .auth-showcase-card {
        flex-direction: column;
        min-height: 640px;
      }

      .wave-overlay-panel {
        width: 100%;
        height: 100%;
      }

      .auth-showcase-card.is-signin-active .wave-overlay-panel {
        transform: translateX(105%);
      }

      .login-form-panel {
        width: 100%;
        padding: 28px 24px;
      }

      .illustration-stage {
        display: none;
      }

      .wave-edge-right,
      .wave-edge-left {
        display: none;
      }
    }
  </style>
</head>

<body>

  <div class="auth-showcase-wrapper">

    <!-- Main Sliding Showcase Card -->
    @php
      $isRegisterMode = (($initialMode ?? 'login') === 'register') || old('nama') !== null;
      $shouldOpenPanel = $isRegisterMode || $errors->any() || session('error') || session('info') || old('email');
    @endphp
    <div
      class="auth-showcase-card {{ $shouldOpenPanel ? 'is-signin-active' : '' }}"
      id="authShowcaseCard"
    >

      <!-- ========================================================
           1. LEFT PANEL: LOGIN / REGISTER FORM (Revealed when wave slides right)
      ======================================================== -->
      <div class="login-form-panel">
        <div class="form-inner-box">

          <h1 class="login-heading" id="authFormTitle">
            {{ $isRegisterMode ? 'Daftar' : 'Login' }}
          </h1>

          <!-- Feedback Alerts -->
          @if (session('error'))
            <div class="glass-alert glass-alert-danger">
              <i class="bi bi-exclamation-circle-fill me-1"></i> {{ session('error') }}
            </div>
          @endif

          @if (session('info'))
            <div class="glass-alert glass-alert-info">
              <i class="bi bi-info-circle-fill me-1"></i> {{ session('info') }}
            </div>
          @endif

          @if ($errors->any())
            <div class="glass-alert glass-alert-danger">
              <i class="bi bi-shield-exclamation me-1"></i> {{ $errors->first() }}
            </div>
          @endif

          <!-- Login Form -->
          <form
            action="{{ route('login') }}"
            method="POST"
            class="login-form"
            id="loginForm"
            style="{{ $isRegisterMode ? 'display: none;' : '' }}"
          >
            @csrf

            <div class="form-group-item">
              <label for="email" class="input-label">Username / Email</label>
              <div class="input-field-wrap">
                <i class="bi bi-person-badge-fill input-icon-left"></i>
                <input
                  type="text"
                  name="email"
                  id="email"
                  class="pill-input"
                  placeholder="Username / Email Peternak"
                  value="{{ old('email') }}"
                  required
                  autocomplete="username"
                >
              </div>
            </div>

            <div class="form-group-item">
              <label for="password" class="input-label">Password</label>
              <div class="input-field-wrap">
                <i class="bi bi-shield-lock-fill input-icon-left"></i>
                <input
                  type="password"
                  name="password"
                  id="password"
                  class="pill-input"
                  placeholder="Password"
                  required
                  autocomplete="current-password"
                >
                <button
                  type="button"
                  class="toggle-pass-btn"
                  id="togglePasswordBtn"
                  onclick="togglePassword()"
                  title="Lihat / Sembunyikan Password"
                  aria-label="Lihat Password"
                >
                  <i class="bi bi-eye" id="eyeIcon"></i>
                </button>
              </div>
            </div>

            <div class="form-meta-row" style="justify-content: flex-end;">
              <button type="button" class="forgot-link" onclick="openForgotModal()">
                Lupa Password?
              </button>
            </div>

            <button type="submit" class="btn-login-submit" id="submitBtn">
              <span>Masuk Sekarang</span>
              <i class="bi bi-box-arrow-in-right" style="font-size: 1.15rem;"></i>
            </button>

            <div class="form-meta-row" style="justify-content: center; margin-top: 14px;">
              <button type="button" class="forgot-link" onclick="switchAuthMode('register')" style="color: #64748b; font-weight: 600;">
                Belum punya akun? <span style="color: #ea580c; font-weight: 700;">Daftar</span>
              </button>
            </div>
          </form>

          <!-- Register Form -->
          <form
            action="{{ route('register.submit') }}"
            method="POST"
            class="login-form"
            id="registerForm"
            style="{{ $isRegisterMode ? '' : 'display: none;' }}"
          >
            @csrf

            <div class="form-group-item">
              <label for="reg_nama" class="input-label">Nama Lengkap</label>
              <div class="input-field-wrap">
                <i class="bi bi-person-fill input-icon-left"></i>
                <input
                  type="text"
                  name="nama"
                  id="reg_nama"
                  class="pill-input"
                  placeholder="Nama Lengkap Peternak"
                  value="{{ old('nama') }}"
                  required
                  autocomplete="name"
                >
              </div>
            </div>

            <div class="form-group-item">
              <label for="reg_email" class="input-label">Email</label>
              <div class="input-field-wrap">
                <i class="bi bi-envelope-fill input-icon-left"></i>
                <input
                  type="email"
                  name="email"
                  id="reg_email"
                  class="pill-input"
                  placeholder="Alamat Email"
                  value="{{ old('email') }}"
                  required
                  autocomplete="email"
                >
              </div>
            </div>

            <div class="form-group-item">
              <label for="reg_password" class="input-label">Password</label>
              <div class="input-field-wrap">
                <i class="bi bi-shield-lock-fill input-icon-left"></i>
                <input
                  type="password"
                  name="password"
                  id="reg_password"
                  class="pill-input"
                  placeholder="Password (Min. 6 Karakter)"
                  required
                  autocomplete="new-password"
                >
              </div>
            </div>

            <div class="form-group-item">
              <label for="reg_password_confirmation" class="input-label">Konfirmasi Password</label>
              <div class="input-field-wrap">
                <i class="bi bi-check2-circle input-icon-left"></i>
                <input
                  type="password"
                  name="password_confirmation"
                  id="reg_password_confirmation"
                  class="pill-input"
                  placeholder="Konfirmasi Password"
                  required
                  autocomplete="new-password"
                >
              </div>
            </div>

            <button type="submit" class="btn-login-submit">
              <span>Daftar Sekarang</span>
              <i class="bi bi-person-plus-fill" style="font-size: 1.1rem;"></i>
            </button>

            <div class="form-meta-row" style="justify-content: center; margin-top: 14px;">
              <button type="button" class="forgot-link" onclick="switchAuthMode('login')" style="color: #64748b; font-weight: 600;">
                Sudah punya akun? <span style="color: #ea580c; font-weight: 700;">Masuk di sini</span>
              </button>
            </div>
          </form>

        </div>
      </div>

      <!-- ========================================================
           2. RIGHT STAGE: OFFICIAL AXION LOGO
      ======================================================== -->
      <div class="illustration-stage">
        <div class="axion-hero-logo-wrap">
          <img
            src="{{ asset('images/axion.jpeg') }}"
            alt="Logo AXION"
            class="axion-hero-logo-img"
          >
          <div class="axion-hero-logo-title">AXION</div>
          
        </div>
      </div>

      <!-- ========================================================
           3. SLIDING WAVE OVERLAY PANEL
           (Starts on Left covering Form; Slides to Right when SIGN IN is clicked!)
      ======================================================== -->
      <div class="wave-overlay-panel" id="waveOverlayPanel">

        <!-- Decorative Geometric Shapes Inside Panel (Matches Reference Image) -->
        <div class="geo-shapes-layer">
          <div class="geo-ring-top"></div>
          <div class="geo-ring-bottom"></div>
          <div class="geo-square-left"></div>
          <div class="geo-diamond-small"></div>
          <div class="geo-circle-mid"></div>
        </div>

        <!-- Organic Double-Layered Wavy Right Border (Visible in Initial State) -->
        <svg class="wave-edge-right" viewBox="0 0 120 600" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
          <!-- Outer Translucent Wave Layer -->
          <path
            d="M0,0 L42,0 C74,48 32,105 64,162 C94,218 52,258 108,302 C62,350 92,415 54,468 C22,514 64,558 26,600 L0,600 Z"
            fill="#C2410C"
            opacity="0.38"
          />
          <!-- Inner Solid Wave Layer -->
          <path
            d="M0,0 L24,0 C56,52 16,108 46,165 C76,220 38,262 92,304 C44,348 74,412 38,466 C10,512 46,556 12,600 L0,600 Z"
            fill="#9A3412"
          />
        </svg>

        <!-- Organic Double-Layered Wavy Left Border (Visible when Panel Slides Right) -->
        <svg class="wave-edge-left" viewBox="0 0 120 600" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
          <path
            d="M0,0 L42,0 C74,48 32,105 64,162 C94,218 52,258 108,302 C62,350 92,415 54,468 C22,514 64,558 26,600 L0,600 Z"
            fill="#C2410C"
            opacity="0.38"
          />
          <path
            d="M0,0 L24,0 C56,52 16,108 46,165 C76,220 38,262 92,304 C44,348 74,412 38,466 C10,512 46,556 12,600 L0,600 Z"
            fill="#B83209"
          />
        </svg>

        <!-- INITIAL STATE CONTENT: "Welcome Back" + "SIGN IN" Button -->
        <div class="wave-content-welcome">
          <h2 class="welcome-title">Welcome Back</h2>
          <p class="welcome-desc">
            Untuk tetap terhubung dengan sistem monitoring suhu & pakar kandang ayam broiler kami, silakan masuk dengan akun Anda
          </p>
          <button type="button" class="btn-wave-outline" id="triggerSignInBtn" onclick="slideToSignIn()">
            <span>SIGN IN</span>
          </button>
        </div>

        <!-- SLID-RIGHT STATE CONTENT: Kandang Ayam Smart Monitoring Info -->
        <div class="wave-content-active">
          <h2 class="welcome-title" style="font-size: 2.15rem;">Smart Broiler Coop</h2>
          <p class="welcome-desc" style="margin-bottom: 20px;">
            Pantau suhu, kelembaban, dan diagnosa gejala penyakit ayam broiler secara real-time dengan metode Forward Chaining.
          </p>

          <div class="coop-feature-badges">
            <span class="coop-pill-tag"><i class="bi bi-thermometer-sun"></i> Suhu Ideal 28°C–30°C</span>
            <span class="coop-pill-tag"><i class="bi bi-droplet-half"></i> RH 60%–70%</span>
            <span class="coop-pill-tag"><i class="bi bi-cpu-fill"></i> IoT ESP32 Node</span>
            <span class="coop-pill-tag"><i class="bi bi-shield-check"></i> 8 Rules Pakar</span>
          </div>

          <button type="button" class="btn-wave-outline" onclick="slideToWelcome()">
            <i class="bi bi-arrow-left"></i>
            <span>KEMBALI</span>
          </button>
        </div>

      </div>

    </div>

    <!-- Bottom Link Back to Public Landing Page -->
    <div class="bottom-nav">
      <a href="{{ route('landing') }}" class="landing-back-link">
        <i class="bi bi-arrow-left"></i> Kembali ke Beranda Publik AXION
      </a>
    </div>

  </div>

  <!-- Forgot Password Helper Modal -->
  <div class="custom-modal" id="forgotModal" onclick="if(event.target === this) closeForgotModal()">
    <div class="modal-box">
      <div style="font-size: 2.5rem; color: #f97316; margin-bottom: 12px;">
        <i class="bi bi-key-fill"></i>
      </div>
      <h3 style="font-size: 1.35rem; color: #0f172a; margin-bottom: 8px; font-weight: 700; font-family: 'Outfit', sans-serif;">Lupa Password?</h3>
      <p style="font-size: 0.88rem; color: #64748b; line-height: 1.5; margin-bottom: 20px;">
        Sistem AXION menggunakan akun terverifikasi. Untuk keperluan simulasi dan demo peternakan ini, gunakan kredensial berikut:
      </p>

      <div style="background: #fff7ed; border: 1px solid #fed7aa; border-radius: 16px; padding: 14px 18px; text-align: left; font-size: 0.85rem; margin-bottom: 22px;">
        <div style="margin-bottom: 8px; display: flex; justify-content: space-between;">
          <span style="color: #475569;">Admin:</span>
          <code style="color: #c2410c; background: #ffedd5; padding: 2px 6px; border-radius: 6px;">admin@axion.test</code>
        </div>
        <div style="margin-bottom: 8px; display: flex; justify-content: space-between;">
          <span style="color: #475569;">Peternak:</span>
          <code style="color: #c2410c; background: #ffedd5; padding: 2px 6px; border-radius: 6px;">user@axion.test</code>
        </div>
        <div style="display: flex; justify-content: space-between;">
          <span style="color: #475569;">Password:</span>
          <code style="color: #c2410c; background: #ffedd5; padding: 2px 6px; border-radius: 6px;">password</code>
        </div>
      </div>

      <button type="button" class="btn-login-submit" onclick="closeForgotModal()" style="height: 44px; font-size: 0.9rem;">
        Saya Mengerti
      </button>
    </div>
  </div>

  <script>
    function slideToSignIn() {
      const card = document.getElementById('authShowcaseCard');
      card.classList.add('is-signin-active');
      setTimeout(() => {
        const emailInput = document.getElementById('email');
        if (emailInput) {
          emailInput.focus();
        }
      }, 650);
    }

    function slideToWelcome() {
      const card = document.getElementById('authShowcaseCard');
      card.classList.remove('is-signin-active');
    }

    function switchAuthMode(mode) {
      const loginForm = document.getElementById('loginForm');
      const registerForm = document.getElementById('registerForm');
      const title = document.getElementById('authFormTitle');

      if (mode === 'register') {
        loginForm.style.display = 'none';
        registerForm.style.display = 'flex';
        title.textContent = 'Daftar';
      } else {
        registerForm.style.display = 'none';
        loginForm.style.display = 'flex';
        title.textContent = 'Login';
      }
    }

    function togglePassword() {
      const input = document.getElementById('password');
      const icon = document.getElementById('eyeIcon');
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
      }
    }

    function openForgotModal() {
      document.getElementById('forgotModal').classList.add('show');
    }

    function closeForgotModal() {
      document.getElementById('forgotModal').classList.remove('show');
    }
  </script>

</body>

</html>
