@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Dashboard Utama</h2>
    <form action="{{ route('dashboard') }}" method="GET" class="d-flex">
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

<div class="row g-3">
  <div class="col-md-4">
    <div class="card p-3 text-center bg-white shadow-sm">
      <h5>Saldo</h5>
      <p class="fs-4 text-success fw-bold">Rp {{ number_format($balance, 0, ',', '.') }}</p>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card p-3 text-center bg-white shadow-sm">
      <h5>Total Pemasukan</h5>
      <p class="fs-5 text-success">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card p-3 text-center bg-white shadow-sm">
      <h5>Total Pengeluaran</h5>
      <p class="fs-5 text-danger">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
    </div>
  </div>
</div>

<div class="row mt-4">
  <div class="col-md-12">
    <div class="card p-3 bg-white shadow-sm">
      <h5 class="mb-3">Grafik Bulanan (6 Bulan Terakhir)</h5>
      <canvas id="monthlyChart" height="120"></canvas>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const chartData = @json($chartData);

    const labels = chartData.map(item => item.month);
    const incomeData = chartData.map(item => item.income);
    const expenseData = chartData.map(item => item.expense);

    const ctx = document.getElementById('monthlyChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Pemasukan',
                    data: incomeData,
                    backgroundColor: 'rgba(0, 128, 0, 0.7)',
                    borderColor: 'rgba(0, 128, 0, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Pengeluaran',
                    data: expenseData,
                    backgroundColor: 'rgba(255, 0, 0, 0.7)',
                    borderColor: 'rgba(255, 0, 0, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
