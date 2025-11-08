@extends('layouts.app')

@section('content')
<h2 class="mb-4">Edit Pengeluaran</h2>

<div class="card p-4 bg-white">

    <form action="{{ route('expenses.update', $expense->id) }}" method="POST">
        @csrf
        @method('PUT') 

        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <input type="text" class="form-control" id="kategori" name="kategori" 
                   placeholder="Misal: Listrik, Belanja, Transportasi" 
                   value="{{ old('kategori', $expense->kategori) }}" required>
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah (Rp)</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" 
                   placeholder="Masukkan jumlah" 
                   value="{{ old('jumlah', $expense->jumlah) }}" required>
        </div>

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" 
                   value="{{ old('tanggal', $expense->tanggal) }}" required>
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
            <textarea class="form-control" id="keterangan" name="keterangan" rows="3" 
                      placeholder="Keterangan tambahan...">{{ old('keterangan', $expense->keterangan) }}</textarea>
        </div>

        <div class="d-flex">
            <button type="submit" class="btn btn-success me-2">Update</button>
            <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection