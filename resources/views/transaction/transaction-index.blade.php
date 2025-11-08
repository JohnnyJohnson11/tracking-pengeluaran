@extends('layouts.app')

@section('content')
<h2 class="mb-4">Daftar Transaksi</h2>
<div class="card p-3 bg-white">
  
  <div class="d-flex mb-3 justify-content-end">
    <a href="{{ route('incomes.create') }}" class="btn btn-success me-2">
        + Tambah Pemasukan
    </a>
    <a href="{{ route('expenses.create') }}" class="btn btn-danger">
        + Tambah Pengeluaran
    </a>
  </div>

  <table class="table table-bordered align-middle">
    <thead class="table-success">
      <tr>
        <th>Tanggal</th>
        <th>Kategori</th>
        <th>Jenis</th>
        <th>Jumlah</th>
        <th class="text-center">Aksi</th> 
      </tr>
    </thead>
    <tbody>
      @if($transactions->isEmpty())
        <tr>
          <td colspan="5" class="text-center text-muted">Belum ada transaksi</td>
        </tr>
      @else
        @foreach($transactions as $transaction)
          <tr>
            <td>{{ \Carbon\Carbon::parse($transaction->tanggal)->format('d M Y') }}</td>
            
            <td>{{ $transaction->kategori }}</td> 
            
            <td>{{ $transaction->jenis }}</td> 
            
            <td class="text-end">
              @if($transaction->jenis == 'Pemasukan')
                <span class="text-success">+ Rp {{ number_format($transaction->jumlah, 0, ',', '.') }}</span>
              @else
                <span class="text-danger">- Rp {{ number_format($transaction->jumlah, 0, ',', '.') }}</span>
              @endif
            </td>

            <td class="text-center">
              @if ($transaction instanceof \App\Models\Income)
                <a href="{{ route('incomes.edit', $transaction->id) }}" class="btn btn-sm btn-warning me-1" style="width: 60px;">Edit</a>
                <form action="{{ route('incomes.destroy', $transaction->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger" style="width: 60px;">Hapus</button>
                </form>

              @elseif ($transaction instanceof \App\Models\Expense)
                <a href="{{ route('expenses.edit', $transaction->id) }}" class="btn btn-sm btn-warning me-1" style="width: 60px;">Edit</a>
                <form action="{{ route('expenses.destroy', $transaction->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger" style="width: 60px;">Hapus</button>
                </form>
              @endif
            </td>

          </tr>
        @endforeach
      @endif
    </tbody>
  </table>
</div>
@endsection