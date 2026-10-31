<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>AXION - Sistem Pakar & Monitoring Suhu Kandang Ayam Broiler</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
    rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <style>
    :root {
      --primary: #ea580c;
      --primary-dark: #c2410c;
      --primary-light: #fb923c;
      --accent-orange: #ff7828;
      --accent-slate: #0f172a;
      --accent-green: #10b981;
      --accent-green-dark: #047857;
      --accent-red: #ef4444;
      --bg-light: #f8fafc;
      --text-main: #0f172a;
      --text-muted: #64748b;
      --card-bg: #ffffff;
      --border-color: rgba(226, 232, 240, 0.8);
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: var(--bg-light);
      color: var(--text-main);
      overflow-x: hidden;
      line-height: 1.6;
    }

    h1,
    h2,
    h3,
    h4,
    .font-heading {
      font-family: 'Outfit', sans-serif;
    }

    /* Container */
    .container {
      width: 100%;
      max-width: 1240px;
      margin: 0 auto;
      padding: 0 1.5rem;
    }

    /* Navbar */
    .landing-header {
      position: sticky;
      top: 0;
      z-index: 100;
      background: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border-bottom: 1px solid rgba(226, 232, 240, 0.8);
      transition: all 0.3s ease;
    }

    .nav-inner {
      display: flex;
      align-items: center;
      justify-content: space-between;
      height: 74px;
    }

    .brand-logo {
      display: flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
      color: var(--text-main);
    }

    .brand-icon-box {
      width: 42px;
      height: 42px;
      border-radius: 12px;
      background: linear-gradient(135deg, #0f4c81, #0284c7);
      display: flex;
      align-items: center;
      justify-content: center;
      color: #ffffff;
      font-size: 1.25rem;
      box-shadow: 0 4px 12px rgba(15, 76, 129, 0.25);
    }

    .brand-title {
      font-size: 1.35rem;
      font-weight: 800;
      letter-spacing: -0.02em;
      color: #0b3c61;
    }

    .brand-badge {
      background: rgba(16, 185, 129, 0.12);
      color: #047857;
      border: 1px solid rgba(16, 185, 129, 0.25);
      font-size: 0.7rem;
      font-weight: 700;
      padding: 2px 8px;
      border-radius: 9999px;
      margin-left: 4px;
    }

    .nav-menu {
      display: flex;
      align-items: center;
      gap: 24px;
      list-style: none;
    }

    .nav-link {
      text-decoration: none;
      color: var(--text-muted);
      font-size: 0.92rem;
      font-weight: 500;
      transition: color 0.2s ease;
    }

    .nav-link:hover {
      color: var(--primary);
    }

    .nav-actions {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    /* Buttons */
    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      padding: 9px 20px;
      border-radius: 9999px;
      font-size: 0.92rem;
      font-weight: 600;
      text-decoration: none;
      cursor: pointer;
      transition: all 0.25s ease;
      font-family: inherit;
    }

    .btn-outline {
      background: transparent;
      border: 1.5px solid #cbd5e1;
      color: #334155;
    }

    .btn-outline:hover {
      border-color: var(--primary);
      color: var(--primary);
      background: rgba(15, 76, 129, 0.04);
    }

    .btn-primary {
      background: linear-gradient(135deg, #f97316, #ea580c);
      border: none;
      color: #ffffff;
      box-shadow: 0 4px 14px rgba(234, 88, 12, 0.28);
    }

    .btn-primary:hover {
      background: linear-gradient(135deg, #ea580c, #c2410c);
      transform: translateY(-1px);
      box-shadow: 0 6px 18px rgba(234, 88, 12, 0.38);
    }

    .btn-accent {
      background: linear-gradient(135deg, #10b981, #059669);
      border: none;
      color: #ffffff;
      box-shadow: 0 4px 14px rgba(16, 185, 129, 0.25);
    }

    .btn-accent:hover {
      background: linear-gradient(135deg, #059669, #047857);
      transform: translateY(-1px);
    }

    .btn-lg {
      padding: 13px 28px;
      font-size: 1.02rem;
    }

    /* Hero Section */
    .hero-section {
      position: relative;
      padding: 80px 0 90px;
      background: radial-gradient(circle at 10% 20%, rgba(249, 115, 22, 0.1) 0%, transparent 40%),
        radial-gradient(circle at 90% 80%, rgba(15, 23, 42, 0.08) 0%, transparent 45%),
        #ffffff;
      border-bottom: 1px solid rgba(226, 232, 240, 0.8);
      overflow: hidden;
    }

    .hero-grid {
      display: grid;
      grid-template-columns: 1.15fr 0.85fr;
      gap: 48px;
      align-items: center;
    }

    .hero-pill-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 6px 16px;
      border-radius: 9999px;
      background: rgba(249, 115, 22, 0.08);
      border: 1px solid rgba(249, 115, 22, 0.25);
      color: #ea580c;
      font-size: 0.82rem;
      font-weight: 700;
      letter-spacing: 0.03em;
      text-transform: uppercase;
      margin-bottom: 20px;
    }

    .hero-title {
      font-size: 3.2rem;
      font-weight: 800;
      line-height: 1.15;
      color: #0b2f4c;
      letter-spacing: -0.03em;
      margin-bottom: 20px;
    }

    .hero-title-highlight {
      background: linear-gradient(135deg, #ea580c 0%, #f97316 50%, #fbbf24 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .hero-subtitle {
      font-size: 1.12rem;
      color: #475569;
      line-height: 1.7;
      margin-bottom: 32px;
      max-width: 580px;
    }

    .hero-cta-group {
      display: flex;
      gap: 14px;
      flex-wrap: wrap;
      margin-bottom: 40px;
    }

    .hero-stats-row {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      padding-top: 24px;
      border-top: 1px solid #e2e8f0;
    }

    .stat-number {
      font-size: 1.75rem;
      font-weight: 800;
      color: #0b3a63;
      line-height: 1.2;
    }

    .stat-label {
      font-size: 0.82rem;
      color: #64748b;
      font-weight: 500;
    }

    /* Live Preview Card (Hero Right) */
    .hero-card-preview {
      background: #ffffff;
      border-radius: 28px;
      border: 1px solid rgba(203, 213, 225, 0.8);
      box-shadow: 0 25px 60px -15px rgba(15, 76, 129, 0.18),
        0 0 0 1px rgba(255, 255, 255, 0.8) inset;
      padding: 28px;
      position: relative;
    }

    .card-pulse-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-size: 0.75rem;
      font-weight: 700;
      color: #047857;
      background: #ecfdf5;
      padding: 4px 10px;
      border-radius: 9999px;
      border: 1px solid #a7f3d0;
    }

    .pulse-dot {
      width: 7px;
      height: 7px;
      background: #10b981;
      border-radius: 50%;
      box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.25);
      animation: pulse 2s infinite;
    }

    @keyframes pulse {
      0% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
      }

      70% {
        transform: scale(1);
        box-shadow: 0 0 0 6px rgba(16, 185, 129, 0);
      }

      100% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
      }
    }

    .preview-sensor-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
      margin: 18px 0;
    }

    .sensor-mini-card {
      background: #f8fafc;
      border-radius: 16px;
      padding: 16px;
      border: 1px solid #e2e8f0;
      transition: all 0.2s ease;
    }

    .sensor-mini-card:hover {
      background: #f1f5f9;
      transform: translateY(-2px);
    }

    .sensor-val {
      font-size: 1.8rem;
      font-weight: 800;
      color: #0f172a;
      line-height: 1.1;
    }

    .inference-banner-preview {
      background: #eff6ff;
      border: 1px solid #bfdbfe;
      border-radius: 16px;
      padding: 16px;
      margin-top: 16px;
    }

    /* Section Styles */
    .section {
      padding: 90px 0;
      position: relative;
    }

    .section-light {
      background-color: #ffffff;
    }

    .section-muted {
      background-color: #f8fafc;
    }

    .section-header {
      text-align: center;
      max-width: 720px;
      margin: 0 auto 56px;
    }

    .section-tag {
      display: inline-block;
      font-size: 0.78rem;
      font-weight: 700;
      color: var(--primary);
      text-transform: uppercase;
      letter-spacing: 0.08em;
      margin-bottom: 10px;
      background: rgba(15, 76, 129, 0.08);
      padding: 4px 12px;
      border-radius: 9999px;
    }

    .section-title {
      font-size: 2.3rem;
      font-weight: 800;
      color: #0b2f4c;
      letter-spacing: -0.02em;
      line-height: 1.25;
      margin-bottom: 14px;
    }

    .section-desc {
      font-size: 1.05rem;
      color: #64748b;
    }

    /* Advantage Cards Grid */
    .advantages-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 28px;
    }

    .adv-card {
      background: #ffffff;
      border-radius: 24px;
      padding: 32px;
      border: 1px solid #e2e8f0;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
      transition: all 0.3s ease;
      display: flex;
      flex-direction: column;
      cursor: pointer;
    }

    .adv-card:hover {
      transform: translateY(-6px);
      background: linear-gradient(135deg, #dc894dff 0%, #f88040ff 100%);
      border-color: #ea580c;
      box-shadow: 0 20px 40px rgba(234, 88, 12, 0.28);
    }

    .adv-card:hover .adv-title {
      color: #ffffff;
    }

    .adv-card:hover .adv-desc {
      color: rgba(255, 255, 255, 0.92);
    }

    .adv-card:hover .adv-icon-box {
      background: #ffffff;
      color: #ea580c !important;
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
      transform: scale(1.05);
    }

    .adv-icon-box {
      width: 54px;
      height: 54px;
      border-radius: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      margin-bottom: 20px;
      transition: all 0.3s ease;
    }

    .adv-icon-blue {
      background: #e0f2fe;
      color: #0284c7;
    }

    .adv-icon-green {
      background: #dcfce7;
      color: #16a34a;
    }

    .adv-icon-amber {
      background: #fef3c7;
      color: #d97706;
    }

    .adv-icon-purple {
      background: #f3e8ff;
      color: #9333ea;
    }

    .adv-icon-red {
      background: #fee2e2;
      color: #dc2626;
    }

    .adv-icon-teal {
      background: #ccfbf1;
      color: #0d9488;
    }

    .adv-title {
      font-size: 1.25rem;
      font-weight: 700;
      color: #0f2742;
      margin-bottom: 12px;
      transition: color 0.3s ease;
    }

    .adv-desc {
      font-size: 0.94rem;
      color: #64748b;
      line-height: 1.6;
      transition: color 0.3s ease;
    }

    /* Rules Showcase Deck */
    .rules-filters {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-bottom: 36px;
      flex-wrap: wrap;
    }

    .rule-filter-btn {
      padding: 8px 18px;
      border-radius: 9999px;
      font-size: 0.88rem;
      font-weight: 600;
      background: #ffffff;
      border: 1.5px solid #cbd5e1;
      color: #475569;
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .rule-filter-btn:hover,
    .rule-filter-btn.active {
      background: var(--primary);
      border-color: var(--primary);
      color: #ffffff;
      box-shadow: 0 4px 12px rgba(234, 88, 12, 0.25);
    }

    .rules-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 24px;
    }

    .rule-card {
      background: #ffffff;
      border-radius: 20px;
      padding: 24px;
      border: 1px solid #e2e8f0;
      box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04);
      transition: all 0.25s ease;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .rule-card:hover {
      border-color: #fdba74;
      box-shadow: 0 10px 28px rgba(234, 88, 12, 0.09);
      transform: translateY(-2px);
    }

    .rule-badge-kritis {
      background: #fee2e2;
      color: #b91c1c;
      border: 1px solid #fca5a5;
    }

    .rule-badge-tinggi {
      background: #ffedd5;
      color: #c2410c;
      border: 1px solid #fed7aa;
    }

    .rule-badge-sedang {
      background: #fef9c3;
      color: #a16207;
      border: 1px solid #fde047;
    }

    .rule-badge-rendah {
      background: #e0f2fe;
      color: #0369a1;
      border: 1px solid #bae6fd;
    }

    .rule-condition-box {
      background: #f8fafc;
      border-radius: 12px;
      padding: 12px 14px;
      font-size: 0.84rem;
      margin: 12px 0;
      border-left: 3px solid var(--primary);
    }

    /* Interactive Simulator */
    .sim-container {
      background: #ffffff;
      border-radius: 28px;
      border: 1px solid #e2e8f0;
      box-shadow: 0 20px 45px -10px rgba(15, 23, 42, 0.08);
      padding: 36px;
      max-width: 1040px;
      margin: 0 auto;
    }

    .sim-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 36px;
    }

    .sim-input-group {
      margin-bottom: 20px;
    }

    .sim-label {
      display: flex;
      justify-content: space-between;
      font-size: 0.88rem;
      font-weight: 600;
      color: #1e293b;
      margin-bottom: 8px;
    }

    .sim-range {
      width: 100%;
      accent-color: var(--primary);
    }

    .sim-select {
      width: 100%;
      height: 44px;
      border-radius: 10px;
      border: 1.5px solid #cbd5e1;
      padding: 0 14px;
      font-size: 0.92rem;
      color: #1e293b;
      outline: none;
      background: #fafbfa;
      transition: all 0.2s ease;
    }

    .sim-select:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(234, 88, 12, 0.2);
      background: #ffffff;
    }

    .sim-result-box {
      background: #f8fafc;
      border-radius: 20px;
      border: 1px solid #e2e8f0;
      padding: 24px;
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    /* Workflow Pipeline */
    .flow-steps {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
      position: relative;
    }

    .flow-step-card {
      background: #ffffff;
      border-radius: 20px;
      padding: 24px;
      border: 1px solid #e2e8f0;
      position: relative;
      text-align: center;
      transition: all 0.25s ease;
    }

    .flow-step-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
    }

    .step-number-bubble {
      width: 38px;
      height: 38px;
      border-radius: 50%;
      background: linear-gradient(135deg, #f97316, #ea580c);
      color: #ffffff;
      font-weight: 700;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 16px;
      box-shadow: 0 4px 12px rgba(234, 88, 12, 0.3);
    }

    /* CTA Banner (Midnight Slate with Sunset Orange Ambient Glow) */
    .cta-banner {
      background: radial-gradient(circle at 15% 20%, rgba(249, 115, 22, 0.25) 0%, transparent 45%),
        radial-gradient(circle at 85% 80%, rgba(234, 88, 12, 0.2) 0%, transparent 50%),
        linear-gradient(135deg, #070b12 0%, #0f172a 50%, #1e293b 100%);
      border: 1.5px solid rgba(249, 115, 22, 0.35);
      border-radius: 32px;
      padding: 64px 48px;
      text-align: center;
      color: #ffffff;
      box-shadow: 0 25px 60px rgba(0, 0, 0, 0.45);
    }

    .cta-title {
      font-size: 2.5rem;
      font-weight: 800;
      margin-bottom: 16px;
    }

    .cta-desc {
      font-size: 1.1rem;
      color: rgba(255, 255, 255, 0.85);
      max-width: 620px;
      margin: 0 auto 32px;
    }

    /* Footer (Midnight Charcoal) */
    .landing-footer {
      background: #070c14;
      color: #94a3b8;
      padding: 60px 0 30px;
      border-top: 1px solid rgba(255, 255, 255, 0.08);
      font-size: 0.9rem;
    }

    .footer-grid {
      display: grid;
      grid-template-columns: 2fr 1fr 1fr 1fr;
      gap: 40px;
      margin-bottom: 40px;
    }

    .footer-links {
      list-style: none;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .footer-link {
      color: #94a3b8;
      text-decoration: none;
      transition: color 0.2s ease;
    }

    .footer-link:hover {
      color: #ffffff;
    }

    .footer-bottom {
      border-top: 1px solid rgba(255, 255, 255, 0.08);
      padding-top: 24px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 14px;
    }

    /* Responsive */
    @media (max-width: 992px) {
      .hero-grid {
        grid-template-columns: 1fr;
      }

      .advantages-grid {
        grid-template-columns: repeat(2, 1fr);
      }

      .rules-grid {
        grid-template-columns: 1fr;
      }

      .sim-grid {
        grid-template-columns: 1fr;
      }

      .flow-steps {
        grid-template-columns: repeat(2, 1fr);
      }

      .footer-grid {
        grid-template-columns: 1fr 1fr;
      }

      .hero-title {
        font-size: 2.5rem;
      }
    }

    @media (max-width: 640px) {
      .nav-menu {
        display: none;
      }

      .advantages-grid {
        grid-template-columns: 1fr;
      }

      .flow-steps {
        grid-template-columns: 1fr;
      }

      .footer-grid {
        grid-template-columns: 1fr;
      }

      .hero-title {
        font-size: 2.1rem;
      }

      .cta-title {
        font-size: 1.8rem;
      }
    }
  </style>
</head>

<body>

  <!-- ==================== HEADER / NAVBAR ==================== -->
  <header class="landing-header">
    <div class="container">
      <div class="nav-inner">
        <!-- Logo -->
        <a href="{{ route('landing') }}" class="brand-logo" title="AXION" style="display: flex; align-items: center; gap: 10px; text-decoration: none;">
          <img src="{{ asset('images/axion.jpeg') }}" alt="AXION Logo"
            style="height: 48px; width: auto; object-fit: contain; border-radius: 10px;">
          <span style="font-size: 1.45rem; font-weight: 800; letter-spacing: -0.02em; color: #0b3c61;">AXION</span>
        </a>

        <!-- Desktop Menu -->
        <ul class="nav-menu">
          <li><a href="#fitur" class="nav-link">Keunggulan</a></li>
          <li><a href="#simulasi" class="nav-link">Simulasi</a></li>
          <li><a href="#alur-kerja" class="nav-link">Alur Kerja</a></li>
        </ul>

        <!-- Actions -->
        <div class="nav-actions">
          <a href="{{ route('login') }}" class="btn btn-outline">
            <i class="bi bi-box-arrow-in-right"></i>
            <span>Masuk</span>
          </a>
          <a href="{{ route('register') }}" class="btn btn-primary">
            <i class="bi bi-person-plus"></i>
            <span>Daftar</span>
          </a>
        </div>
      </div>
    </div>
  </header>

  <!-- ==================== HERO SECTION ==================== -->
  <section class="hero-section">
    <div class="container">
      <div class="hero-grid">
        <!-- Left: Headline & Pitch -->
        <div>
          <div class="hero-pill-badge">
            <span class="pulse-dot"></span>
            <span>Sistem Pakar & Monitoring Kandang</span>
          </div>

          <h1 class="hero-title">
            Monitoring Suhu & <span class="hero-title-highlight">Sistem Pakar</span> Ayam Broiler
          </h1>

          <p class="hero-subtitle">
            Pantau suhu dan kelembapan kandang secara real-time. Deteksi dini risiko heat stress, gas amonia, dan penyakit ayam broiler secara otomatis.
          </p>

          <div class="hero-cta-group">
            <a href="#simulasi" class="btn btn-primary btn-lg">
              <i class="bi bi-lightning-charge-fill"></i>
              <span>Coba Simulasi</span>
            </a>
            <a href="#fitur" class="btn btn-outline btn-lg">
              <i class="bi bi-stars"></i>
              <span>Keunggulan</span>
            </a>
          </div>

          <!-- Real Database Metrics -->
          <div class="hero-stats-row">
            <div>
              <div class="stat-number">{{ number_format($totalAyam ?: 8770) }}<span
                  style="font-size: 1rem; font-weight: 500; color: #64748b;"> ekor</span></div>
              <div class="stat-label">Ayam Terpantau</div>
            </div>
            <div>
              <div class="stat-number">{{ $rulesCount ?: 8 }}<span
                  style="font-size: 1rem; font-weight: 500; color: #64748b;"> Rules</span></div>
              <div class="stat-label">Aturan Pakar</div>
            </div>
            <div>
              <div class="stat-number">90%<span style="font-size: 1rem; font-weight: 500; color: #64748b;"> CF Max</span></div>
              <div class="stat-label">Tingkat Kepastian</div>
            </div>
          </div>
        </div>

        <!-- Right: Live Preview Widget -->
        <div>
          <div class="hero-card-preview">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
              <div>
                <span
                  style="font-size: 0.78rem; text-transform: uppercase; color: #64748b; font-weight: 700; letter-spacing: 0.05em;">TELEMETRI KANDANG</span>
                <h4 style="font-size: 1.15rem; color: #0b3a63; font-weight: 700; margin: 2px 0 0;">Blok A - Closed House</h4>
              </div>
              <div class="card-pulse-badge">
                <span class="pulse-dot"></span>
                <span>Online</span>
              </div>
            </div>

            <!-- Sensor Telemetry Mini-Cards -->
            <div class="preview-sensor-grid">
              <div class="sensor-mini-card">
                <div
                  style="display: flex; justify-content: space-between; color: #b45309; font-size: 0.82rem; font-weight: 600; margin-bottom: 4px;">
                  <span>Suhu Kandang</span>
                  <i class="bi bi-thermometer-half"></i>
                </div>
                <div class="sensor-val" style="color: #d97706;">
                  {{ number_format($suhu, 1) }} <span style="font-size: 1rem; font-weight: 600;">°C</span>
                </div>
                <span style="font-size: 0.76rem; color: #d97706; font-weight: 600;">
                  @if($suhu > 32)
                    <i class="bi bi-exclamation-triangle"></i> Suhu Panas (>32°C)
                  @else
                    <i class="bi bi-check-circle"></i> Suhu Normal
                  @endif
                </span>
              </div>

              <div class="sensor-mini-card">
                <div
                  style="display: flex; justify-content: space-between; color: #0369a1; font-size: 0.82rem; font-weight: 600; margin-bottom: 4px;">
                  <span>Kelembapan Udara</span>
                  <i class="bi bi-droplet-half"></i>
                </div>
                <div class="sensor-val" style="color: #0284c7;">
                  {{ number_format($kelembapan, 1) }} <span style="font-size: 1rem; font-weight: 600;">%</span>
                </div>
                <span style="font-size: 0.76rem; color: #0284c7; font-weight: 600;">
                  @if($kelembapan > 75)
                    <i class="bi bi-cloud-rain"></i> Lembap Tinggi (>75%)
                  @else
                    <i class="bi bi-check-circle"></i> Normal (Ideal)
                  @endif
                </span>
              </div>
            </div>

            <!-- Inference Live Match Banner -->
            <div class="inference-banner-preview">
              <div style="display: flex; align-items: flex-start; gap: 10px;">
                <div
                  style="background: #0284c7; color: white; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; flex-shrink: 0;">
                  <i class="bi bi-gear-wide-connected"></i>
                </div>
                <div style="flex: 1;">
                  <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 0.82rem; font-weight: 700; color: #0369a1;">STATUS INFERENSI</span>
                    <span
                      style="font-size: 0.72rem; background: #dbeafe; color: #1e40af; font-weight: 700; padding: 2px 8px; border-radius: 6px;">R01 Match</span>
                  </div>
                  <p style="font-size: 0.84rem; color: #1e3a8a; margin: 4px 0 0; line-height: 1.4;">
                    <strong>Risiko Heat Stress:</strong> Suhu & kelembapan tinggi. Nyalakan blower dan siapkan air minum dingin.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ==================== CORE ADVANTAGES SECTION ==================== -->
  <section class="section section-light" id="fitur">
    <div class="container">
      <div class="section-header">
        <span class="section-tag">Keunggulan</span>
        <h2 class="section-title">Fitur Utama Sistem AXION</h2>
        <p class="section-desc">
          Otomasi monitoring mikroklimat dan diagnosa kesehatan ayam broiler dalam satu platform.
        </p>
      </div>

      <div class="advantages-grid">
        <!-- Card 1 -->
        <div class="adv-card">
          <div class="adv-icon-box adv-icon-blue">
            <i class="bi bi-broadcast"></i>
          </div>
          <h3 class="adv-title">Monitoring IoT Real-Time</h3>
          <p class="adv-desc">
            Pantau suhu dan kelembapan tiap blok kandang secara langsung tanpa henti.
          </p>
        </div>

        <!-- Card 2 -->
        <div class="adv-card">
          <div class="adv-icon-box adv-icon-green">
            <i class="bi bi-diagram-3-fill"></i>
          </div>
          <h3 class="adv-title">Forward Chaining</h3>
          <p class="adv-desc">
            Analisis otomatis kondisi mikroklimat dan gejala fisik ayam untuk diagnosa cepat.
          </p>
        </div>

        <!-- Card 3 -->
        <div class="adv-card">
          <div class="adv-icon-box adv-icon-amber">
            <i class="bi bi-patch-check-fill"></i>
          </div>
          <h3 class="adv-title">Certainty Factor (CF)</h3>
          <p class="adv-desc">
            Tingkat kepastian diagnosa terukur hingga 90% berbasis aturan pakar ternak.
          </p>
        </div>

        <!-- Card 4 -->
        <div class="adv-card">
          <div class="adv-icon-box adv-icon-red">
            <i class="bi bi-heart-pulse-fill"></i>
          </div>
          <h3 class="adv-title">Skor Kesehatan Kandang</h3>
          <p class="adv-desc">
            Klasifikasi kondisi kandang secara otomatis: Prima (90-100), Siaga, atau Kritis.
          </p>
        </div>

        <!-- Card 5 -->
        <div class="adv-card">
          <div class="adv-icon-box adv-icon-teal">
            <i class="bi bi-check2-all"></i>
          </div>
          <h3 class="adv-title">Rekomendasi Cepat</h3>
          <p class="adv-desc">
            Panduan penanganan terprioritas: blower kipas, alas sekam, hingga tindakan medis.
          </p>
        </div>

        <!-- Card 6 -->
        <div class="adv-card">
          <div class="adv-icon-box adv-icon-purple">
            <i class="bi bi-collection-fill"></i>
          </div>
          <h3 class="adv-title">Multi-Kandang & Flok</h3>
          <p class="adv-desc">
            Kelola data populasi, strain bibit ayam, umur harian, dan pencatatan mortalitas.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- ==================== INTERACTIVE SYMPTOM & INFERENCE SIMULATOR ==================== -->
  <section class="section section-muted" id="simulasi">
    <div class="container">
      <div class="section-header">
        <span class="section-tag">Simulasi</span>
        <h2 class="section-title">Simulator Sistem Pakar</h2>
        <p class="section-desc">
          Ubah parameter suhu atau pilih gejala ayam untuk melihat hasil diagnosa otomatis.
        </p>
      </div>

      <div class="sim-container">
        <div class="sim-grid">
          <!-- Inputs Column -->
          <div>
            <h3 style="font-size: 1.25rem; font-weight: 700; color: #0b3a63; margin-bottom: 20px;">
              <i class="bi bi-sliders me-1"></i> Input Kondisi Kandang:
            </h3>

            <!-- Suhu -->
            <div class="sim-input-group">
              <div class="sim-label">
                <span><i class="bi bi-thermometer-half text-danger"></i> Suhu Kandang (°C)</span>
                <span id="labelSuhu" style="font-weight: 700; color: #0f4c81;">33.5 °C</span>
              </div>
              <input type="range" min="18" max="40" step="0.5" value="33.5" class="sim-range" id="simSuhu"
                oninput="runLiveSimulation()">
            </div>

            <!-- Kelembapan -->
            <div class="sim-input-group">
              <div class="sim-label">
                <span><i class="bi bi-droplet-half text-primary"></i> Kelembapan Udara (% RH)</span>
                <span id="labelKelembapan" style="font-weight: 700; color: #0f4c81;">82 %</span>
              </div>
              <input type="range" min="30" max="95" step="1" value="82" class="sim-range" id="simKelembapan"
                oninput="runLiveSimulation()">
            </div>

            <!-- Kondisi Ventilasi -->
            <div class="sim-input-group">
              <label class="sim-label" for="simVentilasi">Sirkulasi & Ventilasi Kipas</label>
              <select class="sim-select" id="simVentilasi" onchange="runLiveSimulation()">
                <option value="kurang" selected>Kurang (Sirkulasi Lambat)</option>
                <option value="cukup">Cukup (Normal)</option>
                <option value="baik">Baik (Optimal)</option>
              </select>
            </div>

            <!-- Kondisi Litter -->
            <div class="sim-input-group">
              <label class="sim-label" for="simLitter">Kondisi Alas Sekam (Litter)</label>
              <select class="sim-select" id="simLitter" onchange="runLiveSimulation()">
                <option value="kering">Kering & Bersih</option>
                <option value="lembap">Lembap Sekitar Minum</option>
                <option value="basah">Basah & Menggumpal</option>
              </select>
            </div>

            <!-- Gejala Ayam -->
            <div class="sim-input-group">
              <label class="sim-label" for="simGejala">Gejala Fisik & Feses Ayam</label>
              <select class="sim-select" id="simGejala" onchange="runLiveSimulation()">
                <option value="normal">Normal (Ayam Sehat & Aktif)</option>
                <option value="batuk">Batuk / Nafsu Makan Turun</option>
                <option value="feses_darah">Kotoran / Feses Berdarah</option>
              </select>
            </div>
          </div>

          <!-- Output / Inference Engine Result Column -->
          <div>
            <div class="sim-result-box" id="resultCard">
              <div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                  <span style="font-size: 0.78rem; text-transform: uppercase; font-weight: 700; color: #64748b;">
                    HASIL DIAGNOSA
                  </span>
                  <span id="resBadge" class="rule-badge-tinggi"
                    style="font-size: 0.76rem; font-weight: 700; padding: 4px 12px; border-radius: 9999px;">
                    RISIKO TINGGI
                  </span>
                </div>

                <div style="display: flex; align-items: baseline; gap: 10px; margin-bottom: 12px;">
                  <span style="font-size: 2.2rem; font-weight: 800; color: #0b3a63;" id="resScore">75</span>
                  <span style="font-size: 0.9rem; color: #64748b;">/ 100 Skor Kesehatan</span>
                </div>

                <h4 style="font-size: 1.25rem; font-weight: 700; color: #0f172a; margin-bottom: 8px;"
                  id="resKesimpulan">
                  R01: Terindikasi Risiko Heat Stress
                </h4>

                <p style="font-size: 0.88rem; color: #475569; line-height: 1.5; margin-bottom: 16px;"
                  id="resPenjelasan">
                  Suhu 33.5°C (>32°C) dan kelembapan 82% (>80%) menyebabkan ayam kesulitan membuang panas tubuh.
                </p>

                <div
                  style="background: #ffffff; border-radius: 14px; padding: 14px; border: 1px solid #e2e8f0; margin-bottom: 16px;">
                  <span
                    style="font-size: 0.78rem; font-weight: 700; color: #0b3a63; text-transform: uppercase; display: block; margin-bottom: 6px;">
                    <i class="bi bi-shield-check text-success"></i> Rekomendasi Tindakan:
                  </span>
                  <ul id="resTindakan"
                    style="margin: 0; padding-left: 20px; font-size: 0.84rem; color: #334155; line-height: 1.6;">
                    <li>Aktifkan kipas blower / cooling pad segera.</li>
                    <li>Sediakan air minum dingin dan tambahkan elektrolit anti-stress.</li>
                    <li>Cek kembali kondisi kandang dalam 1 jam.</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ==================== FORWARD CHAINING PIPELINE ==================== -->
  <section class="section section-light" id="alur-kerja">
    <div class="container">
      <div class="section-header">
        <span class="section-tag">Alur Kerja</span>
        <h2 class="section-title">Cara Kerja Sistem</h2>
        <p class="section-desc">
          Proses otomatis dari pembacaan sensor hingga rekomendasi penanganan.
        </p>
      </div>

      <div class="flow-steps">
        <!-- Step 1 -->
        <div class="flow-step-card">
          <div class="step-number-bubble">1</div>
          <h4 style="font-size: 1.15rem; font-weight: 700; color: #0f172a; margin-bottom: 8px;">Baca Sensor</h4>
          <p style="font-size: 0.86rem; color: #64748b;">
            Sensor IoT memantau suhu dan kelembapan kandang secara kontinu.
          </p>
        </div>

        <!-- Step 2 -->
        <div class="flow-step-card">
          <div class="step-number-bubble">2</div>
          <h4 style="font-size: 1.15rem; font-weight: 700; color: #0f172a; margin-bottom: 8px;">Cocokkan Aturan</h4>
          <p style="font-size: 0.86rem; color: #64748b;">
            Mesin inferensi mencocokkan data lapangan dengan basis aturan pakar.
          </p>
        </div>

        <!-- Step 3 -->
        <div class="flow-step-card">
          <div class="step-number-bubble">3</div>
          <h4 style="font-size: 1.15rem; font-weight: 700; color: #0f172a; margin-bottom: 8px;">Hitung CF & Skor</h4>
          <p style="font-size: 0.86rem; color: #64748b;">
            Menghitung nilai kepastian (CF) dan skor kesehatan kandang.
          </p>
        </div>

        <!-- Step 4 -->
        <div class="flow-step-card">
          <div class="step-number-bubble">4</div>
          <h4 style="font-size: 1.15rem; font-weight: 700; color: #0f172a; margin-bottom: 8px;">Solusi Penanganan</h4>
          <p style="font-size: 0.86rem; color: #64748b;">
            Menampilkan panduan tindakan cepat sesuai prioritas risiko.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- ==================== CTA SECTION ==================== -->
  <section class="section section-muted">
    <div class="container">
      <div class="cta-banner">
        <h2 class="cta-title">Optimalkan Kandang Broiler Anda</h2>
        <p class="cta-desc">
          Pantau mikroklimat kandang, deteksi risiko penyakit dini, dan jaga produktivitas ayam Anda.
        </p>
        <div style="display: flex; justify-content: center; gap: 16px; flex-wrap: wrap;">
          <a href="{{ route('login') }}" class="btn btn-accent btn-lg"
            style="background: linear-gradient(135deg, #f97316, #ea580c); color: #ffffff; box-shadow: 0 8px 24px rgba(234, 88, 12, 0.4); border: none;">
            <i class="bi bi-box-arrow-in-right"></i>
            <span>Masuk</span>
          </a>
          <a href="{{ route('register') }}" class="btn btn-outline btn-lg"
            style="border-color: rgba(255,255,255,0.25); color: #ffffff; background: rgba(255,255,255,0.06);">
            <i class="bi bi-person-plus"></i>
            <span>Daftar</span>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- ==================== FOOTER ==================== -->
  <footer class="landing-footer">
    <div class="container">
      <div class="footer-grid">
        <!-- Col 1 -->
        <div>
          <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 14px;">
            <div
              style="width: 48px; height: 48px; border-radius: 12px; background: #ffffff; padding: 4px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 14px rgba(249, 115, 22, 0.25); border: 1.5px solid rgba(249, 115, 22, 0.4);">
              <img src="{{ asset('images/axion.jpeg') }}" alt="AXION Logo"
                style="width: 100%; height: 100%; object-fit: contain; border-radius: 8px;">
            </div>
            <div>
              <span style="font-size: 1.35rem; font-weight: 800; color: #ffffff; letter-spacing: -0.01em;">AXION</span>
            </div>
          </div>
          <p style="font-size: 0.88rem; line-height: 1.6; color: #94a3b8; max-width: 320px;">
            Sistem Pakar & Monitoring Suhu Kandang Ayam Broiler. Arunika Poultry Farm.
          </p>
        </div>

        <!-- Col 2 -->
        <div>
          <h5 style="color: #ffffff; font-size: 0.95rem; font-weight: 700; margin-bottom: 14px;">Navigasi</h5>
          <ul class="footer-links">
            <li><a href="#fitur" class="footer-link">Keunggulan</a></li>
            <li><a href="#simulasi" class="footer-link">Simulator Pakar</a></li>
            <li><a href="#alur-kerja" class="footer-link">Alur Kerja</a></li>
          </ul>
        </div>

        <!-- Col 3 -->
        <div>
          <h5 style="color: #ffffff; font-size: 0.95rem; font-weight: 700; margin-bottom: 14px;">Akses Akun</h5>
          <ul class="footer-links">
            <li><a href="{{ route('login') }}" class="footer-link">Halaman Login</a></li>
            <li><a href="{{ route('register') }}" class="footer-link">Daftar Akun Baru</a></li>
            <li><a href="{{ route('dashboard') }}" class="footer-link">Dashboard</a></li>
          </ul>
        </div>

        <!-- Col 4 -->
        <div>
          <h5 style="color: #ffffff; font-size: 0.95rem; font-weight: 700; margin-bottom: 14px;">Spesifikasi
          </h5>
          <p style="font-size: 0.84rem; color: #94a3b8; line-height: 1.6;">
            Laravel 11 &middot; PHP 8.3 &middot; Forward Chaining &middot; Certainty Factor &middot; IoT Sensor
          </p>
        </div>
      </div>

      <div class="footer-bottom">
        <div>
          &copy; {{ date('Y') }} <strong>AXION Arunika Farm</strong>. Hak Cipta Dilindungi.
        </div>
        <div style="font-size: 0.84rem; color: #64748b;">
          Smart Poultry Farming System
        </div>
      </div>
    </div>
  </footer>

  <!-- ==================== JAVASCRIPT ==================== -->
  <script>
    // Live Simulator Forward Chaining Logic
    function runLiveSimulation() {
      const suhu = parseFloat(document.getElementById('simSuhu').value);
      const kelembapan = parseFloat(document.getElementById('simKelembapan').value);
      const ventilasi = document.getElementById('simVentilasi').value;
      const litter = document.getElementById('simLitter').value;
      const gejala = document.getElementById('simGejala').value;

      document.getElementById('labelSuhu').textContent = suhu.toFixed(1) + ' °C';
      document.getElementById('labelKelembapan').textContent = kelembapan.toFixed(0) + ' %';

      let score = 100;
      let triggeredRules = [];
      let levelRisiko = 'rendah';
      let badgeClass = 'rule-badge-rendah';

      // Rule Check: Feses Berdarah (R07)
      if (gejala === 'feses_darah') {
        triggeredRules.push({
          kode: 'R07',
          nama: 'Kotoran Berdarah (Koksidiosis)',
          cf: '90%',
          penalty: 35,
          tindakan: ['Segera hubungi dokter hewan.', 'Isolasi ayam sakit dan bersihkan sekam basah.']
        });
        score -= 35;
        levelRisiko = 'kritis';
        badgeClass = 'rule-badge-kritis';
      }

      // Rule Check: Gangguan Pernapasan (R06)
      if (gejala === 'batuk') {
        triggeredRules.push({
          kode: 'R06',
          nama: 'Gangguan Pernapasan (CRD / Snot)',
          cf: '80%',
          penalty: 25,
          tindakan: ['Pisahkan ayam sakit dan perbaiki ventilasi udara.', 'Berikan vitamin atau obat sesuai petunjuk dokter hewan.']
        });
        score -= 25;
        if (levelRisiko !== 'kritis') {
          levelRisiko = 'tinggi';
          badgeClass = 'rule-badge-tinggi';
        }
      }

      // Rule Check: Heat Stress (R01)
      if (suhu > 32 && kelembapan > 80) {
        triggeredRules.push({
          kode: 'R01',
          nama: 'Risiko Heat Stress Parah',
          cf: '85%',
          penalty: 25,
          tindakan: ['Nyalakan exhaust blower dan cooling pad segera.', 'Sediakan air minum dingin dan elektrolit anti-stress.']
        });
        score -= 25;
        if (levelRisiko !== 'kritis') {
          levelRisiko = 'tinggi';
          badgeClass = 'rule-badge-tinggi';
        }
      }
      // Rule Check: Suhu Hangat Ventilasi Kurang (R02)
      else if (suhu >= 32 && ventilasi === 'kurang') {
        triggeredRules.push({
          kode: 'R02',
          nama: 'Suhu Hangat & Ventilasi Kurang',
          cf: '70%',
          penalty: 15,
          tindakan: ['Buka tirai samping 10-15 cm segera.', 'Periksa kinerja kipas dan aliran sirkulasi udara.']
        });
        score -= 15;
        if (levelRisiko === 'rendah') {
          levelRisiko = 'sedang';
          badgeClass = 'rule-badge-sedang';
        }
      }

      // Rule Check: Suhu Terlalu Rendah / Chilling (R03)
      if (suhu < 24) {
        triggeredRules.push({
          kode: 'R03',
          nama: 'Suhu Rendah (Chilling)',
          cf: '70%',
          penalty: 15,
          tindakan: ['Nyalakan pemanas (brooder) dan tutup sebagian tirai.', 'Pastikan ayam menyebar merata, tidak menumpuk.']
        });
        score -= 15;
        if (levelRisiko === 'rendah') {
          levelRisiko = 'sedang';
          badgeClass = 'rule-badge-sedang';
        }
      }

      // Rule Check: Amonia Tinggi (R04)
      if (litter === 'basah' && ventilasi === 'kurang') {
        triggeredRules.push({
          kode: 'R04',
          nama: 'Risiko Gas Amonia Tinggi',
          cf: '80%',
          penalty: 20,
          tindakan: ['Ganti atau balik sekam litter yang basah.', 'Tingkatkan ventilasi untuk membuang gas amonia.']
        });
        score -= 20;
        if (levelRisiko !== 'kritis') {
          levelRisiko = 'tinggi';
          badgeClass = 'rule-badge-tinggi';
        }
      }
      // Rule Check: Litter Lembap (R05)
      else if (litter === 'lembap' && kelembapan > 75) {
        triggeredRules.push({
          kode: 'R05',
          nama: 'Litter Lembap',
          cf: '50%',
          penalty: 5,
          tindakan: ['Keringkan litter di sekitar area minum.', 'Pantau kelembapan kandang berkala.']
        });
        score -= 5;
      }

      score = Math.max(20, Math.min(100, score));

      // Render Output
      const resBadge = document.getElementById('resBadge');
      resBadge.className = badgeClass;
      resBadge.textContent = 'RISIKO ' + levelRisiko.toUpperCase();

      document.getElementById('resScore').textContent = score;

      const kesimpulanEl = document.getElementById('resKesimpulan');
      const penjelasanEl = document.getElementById('resPenjelasan');
      const tindakanEl = document.getElementById('resTindakan');

      if (triggeredRules.length === 0) {
        kesimpulanEl.textContent = 'Kondisi Kandang & Ayam Prima';
        penjelasanEl.textContent = 'Parameter mikroklimat normal dan tidak ditemukan gejala sakit. Ayam dalam kondisi optimal.';
        tindakanEl.innerHTML = '<li>Pertahankan sirkulasi udara dan ketersediaan pakan.</li><li>Lanjutkan monitoring telemetri rutin.</li>';
      } else {
        kesimpulanEl.textContent = triggeredRules.map(r => r.kode + ': ' + r.nama).join(' | ');
        penjelasanEl.textContent = 'Terdeteksi ' + triggeredRules.length + ' risiko (Kepastian ' + triggeredRules[0].cf + '). Penalti skor: -' + (100 - score) + ' poin.';

        let allActions = [];
        triggeredRules.forEach(r => {
          allActions = allActions.concat(r.tindakan);
        });
        allActions = [...new Set(allActions)];
        tindakanEl.innerHTML = allActions.map(a => '<li>' + a + '</li>').join('');
      }
    }
  </script>

</body>

</html>