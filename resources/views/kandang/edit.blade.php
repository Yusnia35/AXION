@extends('layouts.adminlte')

@section('title', 'AXION - Edit ' . $kandang->nama)
@section('topbar_page', 'Edit ' . $kandang->nama)
@section('hide_header', 'true')

@section('content')
<div class="kandang-page-container pb-5">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-8 col-xl-7">

      <div class="mb-3 pt-2">
        <a href="{{ route('kandang.index') }}" class="text-decoration-none text-secondary fs-7 fw-medium d-inline-flex align-items-center gap-1.5">
          <i class="bi bi-arrow-left"></i>
          <span>Kembali ke Daftar Kandang</span>
        </a>
      </div>

      <div class="card border-0 shadow-sm rounded-4 bg-body p-3 p-md-4">
        <div class="card-body">
          <div class="kandang-kicker text-uppercase fw-semibold mb-1">
            MANAJEMEN KANDANG &middot; PERBARUI DATA
          </div>
          <h2 class="kandang-hero-title mb-2" style="font-size: 2rem;">
            Edit Data {{ $kandang->nama }}
          </h2>
          <p class="text-secondary fs-7 mb-4">
            Perbarui spesifikasi nama, kapasitas, dan lokasi kandang.
          </p>

          @if ($errors->any())
          <div class="alert alert-danger border-0 rounded-3 mb-4 fs-7">
            <ul class="mb-0 ps-3">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif

          <form action="{{ route('kandang.update', $kandang) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
              <label class="form-label fs-7 fw-bold text-body">
                Nama Kandang <span class="text-danger">*</span>
              </label>
              <input type="text" name="nama" class="form-control rounded-3 py-2.5 px-3" value="{{ old('nama', $kandang->nama) }}" required maxlength="50">
            </div>

            <div class="row g-3 mb-3">
              <div class="col-12 col-md-6">
                <label class="form-label fs-7 fw-bold text-body">
                  Jenis Ayam <span class="text-danger">*</span>
                </label>
                <select name="jenis_ayam" class="form-select rounded-3 py-2.5 px-3" required>
                  <option value="Broiler" {{ old('jenis_ayam', $kandang->jenis_ayam) === 'Broiler' ? 'selected' : '' }}>Broiler (Ayam Pedaging)</option>
                  <option value="Layer" {{ old('jenis_ayam', $kandang->jenis_ayam) === 'Layer' ? 'selected' : '' }}>Layer (Ayam Petelur)</option>
                  <option value="Kampung" {{ old('jenis_ayam', $kandang->jenis_ayam) === 'Kampung' ? 'selected' : '' }}>Ayam Kampung</option>
                  <option value="Pejantan" {{ old('jenis_ayam', $kandang->jenis_ayam) === 'Pejantan' ? 'selected' : '' }}>Ayam Pejantan</option>
                </select>
              </div>

              <div class="col-12 col-md-6">
                <label class="form-label fs-7 fw-bold text-body">
                  Lokasi / Blok Kandang
                </label>
                <input type="text" name="lokasi" class="form-control rounded-3 py-2.5 px-3" value="{{ old('lokasi', $kandang->lokasi) }}" maxlength="100">
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label fs-7 fw-bold text-body d-block mb-2">
                Tipe Konstruksi Kandang <span class="text-danger">*</span>
              </label>
              <div class="row g-3">
                <div class="col-12 col-sm-6">
                  <input type="radio" class="btn-check" name="tipe_kandang" id="radio_edit_open" value="open_house" autocomplete="off" {{ old('tipe_kandang', $kandang->tipe_kandang) === 'open_house' ? 'checked' : '' }} required>
                  <label class="btn btn-outline-custom-type w-100 p-3 text-start rounded-3 h-100" for="radio_edit_open">
                    <div class="d-flex align-items-center gap-2 mb-1">
                      <i class="bi bi-wind text-success fs-5"></i>
                      <strong class="fs-7 text-body">Open House</strong>
                    </div>
                    <small class="text-secondary d-block fs-8">Ventilasi alami / terbuka dengan tirai.</small>
                  </label>
                </div>
                <div class="col-12 col-sm-6">
                  <input type="radio" class="btn-check" name="tipe_kandang" id="radio_edit_closed" value="closed_house" autocomplete="off" {{ old('tipe_kandang', $kandang->tipe_kandang) === 'closed_house' ? 'checked' : '' }} required>
                  <label class="btn btn-outline-custom-type w-100 p-3 text-start rounded-3 h-100" for="radio_edit_closed">
                    <div class="d-flex align-items-center gap-2 mb-1">
                      <i class="bi bi-fan text-primary fs-5"></i>
                      <strong class="fs-7 text-body">Closed House</strong>
                    </div>
                    <small class="text-secondary d-block fs-8">Kandang tertutup modern dengan blower.</small>
                  </label>
                </div>
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label fs-7 fw-bold text-body">
                Kapasitas Maksimal (ekor) <span class="text-danger">*</span>
              </label>
              <div class="input-group">
                <input type="number" name="kapasitas" class="form-control rounded-start-3 py-2.5 px-3" value="{{ old('kapasitas', $kandang->kapasitas) }}" min="1" required>
                <span class="input-group-text rounded-end-3 bg-light text-secondary fs-7">ekor ayam</span>
              </div>
            </div>

            <div class="d-flex align-items-center justify-content-between pt-3 border-top">
              <a href="{{ route('kandang.index') }}" class="btn btn-light rounded-3 px-3 py-2 fs-7 text-secondary">
                Batal
              </a>
              <button type="submit" class="btn btn-tambah-kandang px-4 py-2.5 fs-7 d-inline-flex align-items-center gap-2">
                <i class="bi bi-check2 fs-6"></i>
                <span>Simpan Perubahan</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
