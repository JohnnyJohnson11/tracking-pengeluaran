@extends('layouts.app')

@section('content')
<h2 class="mb-4">Daftar Transaksi</h2>
<div class="card p-3 bg-white">
  <div class="d-flex mb-3 justify-content-between">
    </div>
  <table class="table table-bordered align-middle">
    <thead class="table-success">
      <tr>
        <th>Tanggal</th>
        <th>Kategori</th>
        <th>Jenis</th>
        <th>Jumlah</th>
      </tr>
    </thead>
    <tbody>
      @if($transactions->isEmpty())
        <tr>
          <td colspan="4" class="text-center text-muted">Belum ada transaksi</td>
        </tr>
      @else
        @foreach($transactions as $transaction)
          <tr>
            <td>{{ \Carbon\Carbon::parse($transaction->date)->format('d M Y') }}</td>
            
            <td>{{ $transaction->category }}</td> 
            
            <td>{{ $transaction->jenis }}</td> 
            
            <td class="text-end">
              @if($transaction->jenis == 'Pemasukan')
                <span class="text-success">+ Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
              @else
                <span class="text-danger">- Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
              @endif
            </td> 
          </tr>
        @endforeach
      @endif
    </tbody>
  </table>
</div>
@endsection