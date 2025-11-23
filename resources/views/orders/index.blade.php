@extends('layout')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

  <div class="bg-white rounded-xl shadow p-5">
    <h3 class="font-semibold text-lg">Daftar Pesanan</h3>
    <p class="text-sm text-slate-500">Total {{ $orders->count() }} pesanan</p>
  </div>

  @foreach($orders as $order)
    <div class="bg-white rounded-xl shadow p-5 flex flex-col md:flex-row md:items-start md:justify-between gap-4">
      <div>
        <h4 class="font-medium text-lg">{{ $order->customer_name }}</h4>
        @if($order->phone)
          <p class="text-slate-500 text-sm">📞 {{ $order->phone }}</p>
        @endif

        <p class="mt-3"><span class="font-semibold">Layanan:</span> {{ $order->service->name }}</p>
        <p><span class="font-semibold">Berat:</span> {{ $order->weight }} kg</p>
        <p class="mt-1 text-slate-600"><span class="font-semibold">Total Harga:</span> Rp {{ number_format($order->total_price,0,',','.') }}</p>
        <p class="text-xs text-slate-400 mt-2">Dibuat: {{ $order->created_at->format('d M Y, H:i') }}</p>
      </div>

      <div class="space-y-3 w-full md:w-64">
        <form action="{{ route('orders.updateStatus', $order) }}" method="POST" class="space-y-2">
          @csrf
          <label class="text-sm">Status</label>
          <select name="status" class="block w-full rounded px-3 py-2 border">
            <option value="proses" {{ $order->status == 'proses' ? 'selected' : '' }}>Proses</option>
            <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
          </select>

          <label class="text-sm">Status Pembayaran</label>
          <select name="payment_status" class="block w-full rounded px-3 py-2 border">
            <option value="belum_lunas" {{ $order->payment_status == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
            <option value="lunas" {{ $order->payment_status == 'lunas' ? 'selected' : '' }}>Lunas</option>
          </select>

          <div class="flex gap-2">
            <button type="submit" class="flex-1 bg-indigo-900 text-white py-2 rounded">Update Status</button>

            <!-- WA button - hanya jika sudah selesai akan diarahkan oleh controller, tapi kita buat tombol manual juga -->
            @if($order->phone)
              @php
                $payText = $order->payment_status === 'lunas' ? '✅ LUNAS' : '⚠️ BELUM LUNAS';
                $total = number_format($order->total_price,0,',','.');
                $waMsg = urlencode("Halo {$order->customer_name}! Laundry Anda dengan layanan {$order->service->name} seberat {$order->weight}kg sudah selesai. Total: Rp {$total}. Status Pembayaran: {$payText}. Terima kasih!");
                $waLink = "https://wa.me/".preg_replace('/[^0-9]/','',$order->phone)."?text={$waMsg}";
              @endphp
              <a href="{{ $waLink }}" target="_blank" class="bg-green-600 text-white px-4 py-2 rounded flex items-center justify-center">Kirim ke WA</a>
            @endif
          </div>
        </form>

        <form action="{{ route('orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Hapus pesanan?')">
          @csrf
          @method('DELETE')
          <button type="submit" class="w-full bg-red-600 text-white py-2 rounded">Hapus</button>
        </form>

      </div>
    </div>
  @endforeach

</div>
@endsection
