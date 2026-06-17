@extends('layout')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">

  {{-- ================= HEADER ================= --}}
  <div class="bg-white rounded-xl shadow p-5">
    <h3 class="font-semibold text-lg">Daftar Pesanan</h3>
    <p class="text-sm text-slate-500 mb-6"></p>

    <form method="GET" class="flex gap-6 items-end">
      <div class="w-1/2">
        <label class="text-sm text-slate-600 mb-1 block">Status Pesanan</label>
        <select name="status"
                onchange="this.form.submit()"
                class="w-full rounded-lg px-3 py-2 border border-slate-300">
          <option value="">Semua</option>
          <option value="proses" {{ request('status')=='proses' ? 'selected' : '' }}>Proses</option>
          <option value="selesai" {{ request('status')=='selesai' ? 'selected' : '' }}>Selesai</option>
        </select>
      </div>

      <div class="w-1/2">
        <label class="text-sm text-slate-600 mb-1 block">Status Pembayaran</label>
        <select name="payment_status"
                onchange="this.form.submit()"
                class="w-full rounded-lg px-3 py-2 border border-slate-300">
          <option value="">Semua</option>
          <option value="belum_lunas" {{ request('payment_status')=='belum_lunas' ? 'selected' : '' }}>
            Belum Lunas
          </option>
          <option value="lunas" {{ request('payment_status')=='lunas' ? 'selected' : '' }}>
            Lunas
          </option>
        </select>
      </div>
    </form>
  </div>

  {{-- ================= FILTER PESANAN ================= --}}
  <div class="bg-white rounded-xl shadow p-5">
    <p class="text-sm text-slate-500">
      Total {{ $orders->count() }} pesanan
    </p>
  </div>

  {{-- ================= DAFTAR PESANAN ================= --}}
  @foreach($orders as $order)
  <div class="bg-white rounded-xl shadow p-5 flex flex-col md:flex-row md:justify-between gap-4">

    {{-- INFO PESANAN --}}
    <div>
      <div class="flex items-center gap-3">
        <h4 class="font-medium text-lg">{{ $order->customer_name }}</h4>

        {{-- TANGGAL PESANAN --}}
        <span class="text-xs bg-slate-100 text-slate-600 px-3 py-1 rounded-full">
          {{ $order->created_at->timezone('Asia/Jakarta')->translatedFormat('d F Y') }}
          • {{ $order->created_at->timezone('Asia/Jakarta')->format('H:i') }} WIB
        </span>
      </div>

      @if($order->phone)
        <p class="text-slate-500 text-sm mt-1">📞 {{ $order->phone }}</p>
      @endif

      <p class="mt-3">
        <span class="font-semibold">Layanan:</span>
        {{ $order->service->name }}
      </p>

      <p>
        <span class="font-semibold">Berat:</span>
        {{ $order->weight }} kg
      </p>

      <p class="mt-1 text-slate-600">
        <span class="font-semibold">Total Harga:</span>
        Rp {{ number_format($order->total_price, 0, ',', '.') }}
      </p>
    </div>

    {{-- STATUS & AKSI --}}
    <div class="space-y-3 w-full md:w-64">
      <form action="{{ route('orders.updateStatus', $order) }}" method="POST" class="space-y-2">
        @csrf
        @method('PUT')

        <label class="text-sm">Status Pesanan</label>
        <select name="status" class="block w-full rounded px-3 py-2 border">
          <option value="proses" {{ $order->status=='proses' ? 'selected' : '' }}>Proses</option>
          <option value="selesai" {{ $order->status=='selesai' ? 'selected' : '' }}>Selesai</option>
        </select>

        <label class="text-sm">Status Pembayaran</label>
        <select name="payment_status" class="block w-full rounded px-3 py-2 border">
          <option value="belum_lunas" {{ $order->payment_status=='belum_lunas' ? 'selected' : '' }}>
            Belum Lunas
          </option>
          <option value="lunas" {{ $order->payment_status=='lunas' ? 'selected' : '' }}>
            Lunas
          </option>
        </select>

        <div class="flex gap-2">
          <button type="submit" class="flex-1 bg-indigo-900 text-white py-2 rounded">
            Update Status
          </button>

          {{-- ✅ LOGIKA BARU: Ditambahkan normalisasi angka 0 menjadi 62 --}}
          @if($order->phone)
            @php
              // 1. Hilangkan semua karakter selain angka (spasi, strip, plus)
              $phone = preg_replace('/[^0-9]/', '', $order->phone);
              
              // 2. JIKA DIAWALI ANGKA 0, UBAH JADI 62
              if (substr($phone, 0, 1) === '0') {
                  $phone = '62' . substr($phone, 1);
              }

              $total = number_format($order->total_price, 0, ',', '.');
              
              if ($order->status === 'proses') {
                  // JIKA STATUS MASIH PROSES
                  if ($order->payment_status === 'lunas') {
                      $message = "Halo Kak {$order->customer_name}, pakaian Anda saat ini sedang kami proses ya. Terima kasih banyak, pembayaran telah kami terima (Lunas). Total: Rp {$total}. Kami akan kabari kembali jika pakaian sudah selesai dan siap diambil. - Laundry Express";
                  } else {
                      $message = "Halo Kak {$order->customer_name}, pakaian Anda saat ini sedang kami proses ya. Total biayanya sebesar Rp {$total} (Belum Lunas). Pembayaran bisa dilakukan nanti saat pengambilan pakaian. Kami akan kabari kembali jika sudah selesai. Terima kasih! - Laundry Express";
                  }
              } else {
                  // JIKA STATUS SUDAH SELESAI
                  if ($order->payment_status === 'lunas') {
                      $message = "Halo Kak {$order->customer_name}, pakaian Anda sudah selesai diproses dan siap diambil di kios ya. Terima kasih banyak, pembayaran telah kami terima (Lunas). Total: Rp {$total}. - Laundry Express";
                  } else {
                      $message = "Halo Kak {$order->customer_name}, pakaian Anda sudah selesai diproses dan siap diambil di kios ya. Total biayanya Rp {$total} (Belum Lunas). Pembayaran bisa dilakukan langsung saat pengambilan pakaian nanti. Terima kasih! - Laundry Express";
                  }
              }
            @endphp
            
            <a href="https://wa.me/{{ $phone }}?text={{ urlencode($message) }}"
               target="_blank"
               class="bg-green-600 text-white px-4 py-2 rounded flex items-center justify-center">
              Kirim WA
            </a>
            
          @endif
        </div>
      </form>

      <form action="{{ route('orders.destroy', $order) }}" method="POST"
            onsubmit="return confirm('Hapus pesanan?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="w-full bg-red-600 text-white py-2 rounded">
          Hapus
        </button>
      </form>
    </div>
  </div>
  @endforeach

</div>
@endsection