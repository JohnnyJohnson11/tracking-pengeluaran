@extends('layouts.app')

@section('content')
<div class="container mt-4">
  <h2 class="mb-4">Profil & Pengaturan Akun</h2>

  {{-- ✅ Pesan sukses atau error --}}
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="row">
    {{-- ✏️ Form Update Profil --}}
    <div class="col-md-6 mb-4">
      <div class="card p-4 bg-white shadow-sm">
        <h5 class="mb-3 text-primary">Ubah Profil</h5>
        <form action="{{ route('profile.update') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" placeholder="Nama Anda" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" placeholder="Email Anda" required>
          </div>
          <button class="btn btn-primary w-100">Simpan Perubahan</button>
        </form>
      </div>
    </div>

    {{-- 🔐 Form Ganti Password --}}
    <div class="col-md-6 mb-4">
      <div class="card p-4 bg-white shadow-sm">
        <h5 class="mb-3 text-warning">Ganti Kata Sandi</h5>
        <form action="{{ route('profile.update.password') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label class="form-label">Kata Sandi Lama</label>
            <input type="password" name="current_password" class="form-control" placeholder="Masukkan kata sandi lama" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Kata Sandi Baru</label>
            <input type="password" name="new_password" class="form-control" placeholder="Kata sandi baru" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Konfirmasi Kata Sandi Baru</label>
            <input type="password" name="new_password_confirmation" class="form-control" placeholder="Ulangi kata sandi baru" required>
          </div>
          <button class="btn btn-warning w-100 text-dark">Perbarui Kata Sandi</button>
        </form>
      </div>
    </div>
  </div>

  {{-- 📤 Tombol Ekspor Data --}}
  <div class="card p-4 bg-white shadow-sm">
    <h5 class="mb-3 text-success">Ekspor Data Transaksi</h5>
    <p class="text-muted">Kamu dapat mengekspor seluruh data transaksi dalam format CSV atau PDF.</p>
    <div class="d-flex gap-2">
      <a href="{{ route('profile.export.csv') }}" class="btn btn-outline-success flex-fill">
        <i class="bi bi-filetype-csv"></i> Ekspor ke CSV
      </a>
      <a href="{{ route('profile.export.pdf') }}" class="btn btn-outline-danger flex-fill">
        <i class="bi bi-filetype-pdf"></i> Ekspor ke PDF
      </a>
    </div>
  </div>
</div>
@endsection
