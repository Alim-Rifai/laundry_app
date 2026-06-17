<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Sistem Pendapatan Dan Pesanan Laundry Express</title>

  <!-- Tailwind CDN (cepat untuk demo) -->
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    /* sedikit custom agar mirip desain */
    .top-header {
      background: linear-gradient(180deg,#edf2ff, #e6eefc);
    }
    /* Menghapus padding & background bawaan agar utility class Tailwind (px-8 py-3) bisa bekerja maksimal */
    .nav-pill { background:#f0f4f8; transition: all 0.2s; }
    .active-pill { background:white !important; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); }
  </style>
</head>
<body class="bg-gradient-to-b from-slate-100 to-slate-200 min-h-screen">

  <!-- Menambahkan 'sticky top-0 z-50 shadow-md' agar header tidak ikut naik saat di-scroll -->
  <header class="top-header py-6 sticky top-0 z-50 shadow-md border-b border-indigo-100/50">
    <!-- Mengubah 'container' menjadi 'max-w-7xl' agar panjangnya sama persis dengan box konten -->
    <div class="max-w-7xl mx-auto px-4">
      <div class="text-center">
        <div class="inline-flex items-center gap-4 bg-white/0 rounded-md p-2">
          <div class="bg-white rounded-full p-3 shadow-sm">
            <!-- icon -->
            <svg width="34" height="34" viewBox="0 0 24 24" fill="none" class="text-indigo-600">
              <path d="M12 2l2 4h4l-2 3 2 8H6l2-8-2-3h4l2-4z" stroke="#5b21b6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
            </svg>
          </div>
          <div class="text-left">
            <h1 class="text-indigo-700 font-bold text-xl md:text-2xl">Sistem Pendapatan Dan Pesanan Laundry Express</h1>
            <p class="text-slate-600 text-sm md:text-base font-medium">Kelola Pendapatan Dan Pesanan Laundry Express</p>
          </div>
        </div>
      </div>

      <!-- nav: Tombol diperbesar dengan padding ekstra (px-8 py-3) agar makin terlihat bagus -->
      <nav class="mt-6 flex justify-center gap-4 text-sm md:text-base">
          <a href="{{ route('orders.index') }}" class="nav-pill px-8 py-3 rounded-full font-bold transition-all {{ request()->routeIs('orders.index') ? 'active-pill' : '' }}">Daftar Pesanan</a>
          <a href="{{ route('orders.create') }}" class="nav-pill px-8 py-3 rounded-full font-bold transition-all {{ request()->routeIs('orders.create') ? 'active-pill' : '' }}">Pesanan Baru</a>
          <a href="{{ url('/services') }}" class="nav-pill px-8 py-3 rounded-full font-bold transition-all {{ request()->is('services*') ? 'active-pill' : '' }}">Jenis Layanan</a>
          <a href="{{ route('reports.index') }}" class="nav-pill px-8 py-3 rounded-full font-bold transition-all {{ request()->is('reports*') ? 'active-pill' : '' }}">Laporan Pendapatan</a>
      </nav>
    </div>
  </header>

  <!-- Mengubah 'container' menjadi 'max-w-7xl' agar panjang konten di bawahnya juga sama rata dengan header -->
  <main class="max-w-7xl mx-auto px-4 py-8">
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