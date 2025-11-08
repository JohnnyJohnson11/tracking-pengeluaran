@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Laporan & Grafik</h2>
    <form action="{{ route('reports') }}" method="GET" class="d-flex">
        <select name="month" class="form-select me-2" style="width: auto;">
            @for ($m = 1; $m <= 12; $m++)
                <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                </option>
            @endfor
        </select>
        <select name="year" class="form-select me-2" style="width: auto;">
            @for ($y = \Carbon\Carbon::now()->year - 5; $y <= \Carbon\Carbon::now()->year + 5; $y++)
                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
        </select>
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>
</div>


@if($totalIncome > 0 || $totalExpense > 0)
    <div class="card p-4 bg-white">
        <h5 class="text-center mb-3">
            Perbandingan Pemasukan & Pengeluaran ({{ \Carbon\Carbon::create()->month($month)->format('F') }} {{ $year }})
        </h5>
        
        <div style="width: 100%; max-width: 450px; margin: 0 auto;">
            <canvas id="pieChart"></canvas>
        </div>
        
        <div class="mt-4 text-center">
            <button class="btn btn-primary">Ekspor ke PDF</button>
            <button class="btn btn-success ms-2">Ekspor ke CSV</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('pieChart').getContext('2d');

        const totalIncome = {{ $totalIncome ?? 0 }};
        const totalExpense = {{ $totalExpense ?? 0 }};

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Total Pemasukan', 'Total Pengeluaran'],
                datasets: [{
                    label: 'Jumlah',
                    data: [totalIncome, totalExpense],
                    backgroundColor: [
                        'rgba(0, 128, 0, 0.7)',
                        'rgba(255, 0, 0, 0.7)'
                    ],
                    borderColor: [
                        'rgba(0, 128, 0, 1)',
                        'rgba(255, 0, 0, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.parsed;
                                if (label) {
                                    label += ': ';
                                }
                                return label + 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    </script>

@else
    <div class="card p-4 bg-white text-center">
      <p class="text-muted">
        Belum ada data Pemasukan/Pengeluaran untuk 
        bulan {{ \Carbon\Carbon::create()->month($month)->format('F') }} {{ $year }}.
      </p>
    </div>
@endif


<div class="row g-3 mt-4">
  <div class="col-md-4">
    <div class="card p-3 text-center bg-white shadow-sm">
      <h5>Saldo (Total Keseluruhan)</h5>
      <p class="fs-4 text-success fw-bold">Rp {{ number_format($balance, 0, ',', '.') }}</p>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card p-3 text-center bg-white shadow-sm">
      <h5>Total Pemasukan (Bulan Ini)</h5>
      <p class="fs-5 text-success">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card p-3 text-center bg-white shadow-sm">
      <h5>Total Pengeluaran (Bulan Ini)</h5>
      <p class="fs-5 text-danger">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
    </div>
  </div>
</div>
@endsection