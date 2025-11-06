@extends('layouts.app')

@section('content')
<h2 class="mb-4">Laporan & Grafik</h2>
<div class="card p-4 bg-white text-center">
  <p class="text-muted">Belum ada data laporan untuk ditampilkan.</p>
  <div class="mt-3">
    <button class="btn btn-primary">Ekspor ke PDF</button>
    <button class="btn btn-success ms-2">Ekspor ke CSV</button>
  </div>
</div>
@endsection
