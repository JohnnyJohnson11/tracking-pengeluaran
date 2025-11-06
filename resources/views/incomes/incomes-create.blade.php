@extends('layouts.app')

@section('content')
<h2 class="mb-4">Tambah Pemasukan</h2>
<div class="card p-4 bg-white">
  <form>
    <div class="mb-3">
      <label class="form-label">Sumber Pemasukan</label>
      <input type="text" class="form-control" placeholder="Misal: Gaji, Hadiah">
    </div>
    <div class="mb-3">
      <label class="form-label">Jumlah</label>
      <input type="number" class="form-control" placeholder="Rp">
    </div>
    <div class="mb-3">
      <label class="form-label">Tanggal</label>
      <input type="date" class="form-control">
    </div>
    <button class="btn btn-primary">Simpan</button>
  </form>
</div>
@endsection
