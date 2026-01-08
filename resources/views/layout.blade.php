<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Sistem Pendapatan Laundry Express</title>

  <!-- Tailwind CDN (cepat untuk demo) -->
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    /* sedikit custom agar mirip desain */
    .top-header {
      background: linear-gradient(180deg,#edf2ff, #e6eefc);
    }
    .nav-pill { background:#f0f4f8; padding:8px 18px; border-radius:9999px; }
    .active-pill { background:white; box-shadow:0 2px 0 rgba(0,0,0,0.06); }
  </style>
</head>
<body class="bg-gradient-to-b from-slate-100 to-slate-200 min-h-screen">

  <header class="top-header py-8">
    <div class="container mx-auto px-4">
      <div class="text-center">
        <div class="inline-flex items-center gap-3 bg-white/0 rounded-md p-2">
          <div class="bg-white rounded-full p-3 shadow">
            <!-- icon -->
            <svg width="34" height="34" viewBox="0 0 24 24" fill="none" class="text-indigo-600">
              <path d="M12 2l2 4h4l-2 3 2 8H6l2-8-2-3h4l2-4z" stroke="#5b21b6" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
            </svg>
          </div>
          <div>
            <h1 class="text-indigo-600 font-semibold text-xl">Sistem Pendapatan Laundry Express</h1>
            <p class="text-slate-500 text-sm">Kelola pesanan dan laporan pendapatan laundry Express</p>
          </div>
        </div>
      </div>

      <!-- nav -->
      <nav class="mt-6 flex justify-center gap-6 text-sm">
          <a href="{{ route('orders.index') }}" class="nav-pill {{ request()->routeIs('orders.index') ? 'active-pill' : '' }}">Pesanan</a>
          <a href="{{ route('orders.create') }}" class="nav-pill {{ request()->routeIs('orders.create') ? 'active-pill' : '' }}">Pesanan Baru</a>
          <a href="{{ url('/services') }}" class="nav-pill {{ request()->is('services*') ? 'active-pill' : '' }}">Jenis Layanan</a>
          <a href="{{ route('reports.index') }}" class="nav-pill {{ request()->is('reports*') ? 'active-pill' : '' }}">Laporan Pendapatan</a>
      </nav>
    </div>
  </header>

  <main class="container mx-auto px-4 py-8">
    @if(session('success'))
      <div class="mb-4 p-3 rounded bg-green-50 border border-green-200 text-green-700">
        {{ session('success') }}
      </div>
    @endif

    @yield('content')
  </main>

  <footer class="text-center py-6 text-slate-500 text-sm">
    &copy; {{ date('Y') }} Laundry Express
  </footer>

</body>
</html>
