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
            <label for="category" class="form-label">Kategori</label>
            <input type="text" name="category" id="category" class="form-control" placeholder="Misal: Listrik, Wifi, Makan" required>
        </div>

        <div class="mb-3">
            <label for="amount" class="form-label">Jumlah (Rp)</label>
            <input type="number" name="amount" id="amount" class="form-control" placeholder="Masukkan jumlah" required>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Tanggal</label>
            <input type="date" name="date" id="date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Keterangan (Opsional)</label>
            <textarea name="description" id="description" class="form-control" rows="2" placeholder="Keterangan tambahan..."></textarea>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ url('/') }}" class="btn btn-secondary">Batal</a>
    </form>

</div>
@endsection
