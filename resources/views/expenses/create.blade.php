@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Tambah Pengeluaran</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/expenses" method="POST">
    @csrf
        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <input type="text" name="kategori" id="kategori" class="form-control" placeholder="Misal: Listrik, Wifi, Makan" required>
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah (Rp)</label>
            <input type="number" name="jumlah" id="jumlah" class="form-control" placeholder="Masukkan jumlah" required>
        </div>

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
            <textarea name="keterangan" id="keterangan" class="form-control" rows="2" placeholder="Keterangan tambahan..."></textarea>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Batal</a>
    </form>

</div>
@endsection
