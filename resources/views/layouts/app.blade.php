<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aplikasi Keuangan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8fff8;
    }
    .navbar {
      background-color: #2e7d32;
    }
    .navbar a, .navbar-brand {
      color: white !important;
    }
    .card {
      border: none;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .btn-primary {
      background-color: #2e7d32;
      border-color: #2e7d32;
    }
    .btn-primary:hover {
      background-color: #256628;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg px-3">
    <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">KeuanganKu</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-3">
        <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="/transactions">Transaksi</a></li>
        <li class="nav-item"><a class="nav-link" href="/reports">Laporan</a></li>
        <li class="nav-item"><a class="nav-link" href="/profile">Profil</a></li>
        <li class="nav-item">
          <a href="#" class="nav-link" 
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
          </a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </li>
      </ul>
    </div>
  </nav>

  <div class="container py-4">
    @yield('content')
  </div>
</body>
</html>
