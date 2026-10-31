@extends('layouts.adminlte')

@section('title', 'AXION - Tambah Data Kandang')
@section('topbar_page', 'Tambah Kandang')
@section('hide_header', 'true')

@section('content')
<div class="kandang-page-container pb-5">
  <div class="row justify-content-center">
    <div class="col-12 col-xl-11">

      <!-- Breadcrumbs & Back link -->
      <div class="mb-3 pt-2">
        <a href="{{ route('kandang.index') }}" class="text-decoration-none text-secondary fs-7 fw-medium d-inline-flex align-items-center gap-1.5">
          <i class="bi bi-arrow-left"></i>
          <span>Kembali ke Daftar Kandang</span>
        </a>
      </div>

      <!-- Card Tambah Data Kandang (Matching Exact User Screenshot) -->
      <div class="card border-0 shadow-sm rounded-4 bg-body p-4 p-md-5">
        <div class="d-flex justify-content-between align-items-start mb-2">
          <div class="kandang-kicker text-uppercase fw-semibold" style="font-size: 0.74rem; letter-spacing: 0.12em; color: #728174;">
            KANDANG BARU
          </div>
          <a href="{{ route('kandang.index') }}" class="btn-close text-secondary" aria-label="Close" title="Kembali ke Daftar Kandang"></a>
        </div>

        <h2 class="mb-4 fw-bold" style="font-family: 'Newsreader', 'Playfair Display', Georgia, serif; font-size: 1.85rem; color: #16241b;">
          Tambah Data Kandang
        </h2>

        @if ($errors->any())
        <div class="alert alert-danger border-0 rounded-3 mb-4 fs-7">
          <div class="fw-bold mb-1">Tolong periksa kesalahan input berikut:</div>
          <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        <form action="{{ route('kandang.store') }}" method="POST">
          @csrf
          <div class="row g-3 g-md-4 mb-3">
            <div class="col-12 col-md-4">
              <label class="form-label fs-7 text-secondary fw-medium mb-1">Nama Kandang</label>
              <input type="text" name="nama" class="form-control rounded-3 py-2 px-3 border" placeholder="Kandang C" value="{{ old('nama') }}" required maxlength="50" style="border-color: #e2e8e2 !important; background-color: #fafbfa;">
            </div>
            <div class="col-12 col-md-4">
              <label class="form-label fs-7 text-secondary fw-medium mb-1">Lokasi</label>
              <input type="text" name="lokasi" class="form-control rounded-3 py-2 px-3 border" placeholder="Blok Timur" value="{{ old('lokasi') }}" maxlength="100" style="border-color: #e2e8e2 !important; background-color: #fafbfa;">
            </div>
            <div class="col-12 col-md-4">
              <label class="form-label fs-7 text-secondary fw-medium mb-1">Kapasitas</label>
              <input type="number" name="kapasitas" class="form-control rounded-3 py-2 px-3 border" placeholder="500" value="{{ old('kapasitas') }}" min="1" required style="border-color: #16241b !important; background-color: #ffffff;">
            </div>
          </div>

          <div class="row g-3 g-md-4 mb-4">
            <div class="col-12 col-md-4">
              <label class="form-label fs-7 text-secondary fw-medium mb-1">Jumlah Ayam</label>
              <input type="number" name="jumlah_ayam" class="form-control rounded-3 py-2 px-3 border" placeholder="450" value="{{ old('jumlah_ayam') }}" min="0" style="border-color: #e2e8e2 !important; background-color: #fafbfa;">
            </div>
            <div class="col-12 col-md-4">
              <label class="form-label fs-7 text-secondary fw-medium mb-1">Jenis Kandang</label>
              <select name="jenis_kandang" class="form-select rounded-3 py-2 px-3 border" required style="border-color: #e2e8e2 !important; background-color: #ffffff;">
                <option value="Broiler|open_house" {{ old('jenis_kandang') === 'Broiler|open_house' ? 'selected' : '' }}>Broiler &middot; Open house</option>
                <option value="Broiler|closed_house" {{ old('jenis_kandang') === 'Broiler|closed_house' ? 'selected' : '' }}>Broiler &middot; Closed house</option>
                <option value="Layer|open_house" {{ old('jenis_kandang') === 'Layer|open_house' ? 'selected' : '' }}>Layer &middot; Open house</option>
                <option value="Layer|closed_house" {{ old('jenis_kandang') === 'Layer|closed_house' ? 'selected' : '' }}>Layer &middot; Closed house</option>
                <option value="Kampung|open_house" {{ old('jenis_kandang') === 'Kampung|open_house' ? 'selected' : '' }}>Kampung &middot; Open house</option>
                <option value="Kampung|closed_house" {{ old('jenis_kandang') === 'Kampung|closed_house' ? 'selected' : '' }}>Kampung &middot; Closed house</option>
              </select>
            </div>
          </div>

          <div class="d-flex align-items-center gap-2">
            <button type="submit" class="btn d-inline-flex align-items-center gap-2 shadow-sm px-4 py-2" style="background: linear-gradient(135deg, #2563eb, #1d4ed8) !important; border-color: #1d4ed8 !important; color: #ffffff !important; border-radius: 10px; font-weight: 600;">
              <span>Simpan Kandang</span>
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <polyline points="9 12 11.5 14.5 16 9"></polyline>
              </svg>
            </button>
            <a href="{{ route('kandang.index') }}" class="btn rounded-3 px-4 py-2" style="background-color: #64748b !important; border-color: #64748b !important; color: #ffffff !important; font-weight: 600; border-radius: 10px; text-decoration: none;">
              Batal
            </a>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>
@endsection
