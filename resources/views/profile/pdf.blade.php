<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 40px;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ccc;
        }
        th {
            background-color: #f5f5f5;
        }
        .footer {
            text-align: right;
            margin-top: 40px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <h1>Data Profil Pengguna</h1>

    <table>
        <tr>
            <th>Nama</th>
            <td>{{ $user->name }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $user->email }}</td>
        </tr>
    </table>

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
                <span class="text-success" style="color: #198754">+ Rp {{ number_format($transaction->jumlah, 0, ',', '.') }}</span>
              @else
                <span class="text-danger" style="color: #dc3545">- Rp {{ number_format($transaction->jumlah, 0, ',', '.') }}</span>
              @endif
            </td>
          </tr>
        @endforeach
      @endif
    </tbody>
  </table>

    <div class="footer">
        <p>Exported on: {{ now()->format('d M Y H:i') }}</p>
        <p>Tracking Pengeluaran App</p>
    </div>
</body>
</html>
