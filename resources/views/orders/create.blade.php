@extends('layout')

@section('content')
<div class="max-w-2xl mx-auto">
  <div class="bg-white rounded-2xl shadow p-6">
    <h2 class="text-lg font-semibold mb-1">Tambah Pesanan Baru</h2>
    <p class="text-sm text-slate-500 mb-5">Input data pesanan laundry pelanggan</p>

    <form action="{{ route('orders.store') }}" method="POST" class="space-y-4">
      @csrf

      <!-- Nama -->
      <div>
        <label class="block text-sm font-medium">Nama Pelanggan</label>
        <input
          name="customer_name"
          value="{{ old('customer_name') }}"
          required
          class="mt-1 block w-full rounded-lg bg-slate-100 border-0 px-3 py-2 focus:ring-indigo-500"
        >
        @error('customer_name')
          <div class="text-red-600 text-sm">{{ $message }}</div>
        @enderror
      </div>

      <!-- Telepon -->
      <div>
        <label class="block text-sm font-medium">Nomor Telepon (Opsional)</label>
        <input
          name="phone"
          value="{{ old('phone') }}"
          class="mt-1 block w-full rounded-lg bg-slate-100 border-0 px-3 py-2"
        >
      </div>

      <!-- Jenis Layanan -->
      <div>
        <label class="block text-sm font-medium">Jenis Layanan</label>
        <select
          name="service_id"
          id="service"
          required
          class="mt-1 block w-full rounded-lg bg-slate-100 border-0 px-3 py-2"
        >
          <option value="">Pilih jenis layanan</option>
          @foreach($services as $s)
            <option
              value="{{ $s->id }}"
              data-price="{{ $s->price_per_kg }}"
            >
              {{ $s->name }} - Rp {{ number_format($s->price_per_kg,0,',','.') }}/kg
            </option>
          @endforeach
        </select>
        @error('service_id')
          <div class="text-red-600 text-sm">{{ $message }}</div>
        @enderror
      </div>

      <!-- Berat -->
      <div>
        <label class="block text-sm font-medium">Berat (kg)</label>
        <input
          type="number"
          step="1"
          min="1"
          id="weight"
          name="weight"
          value="{{ old('weight') }}"
          required
          class="mt-1 block w-full rounded-lg bg-slate-100 border-0 px-3 py-2"
        >
        @error('weight')
          <div class="text-red-600 text-sm">{{ $message }}</div>
        @enderror
      </div>

      <!-- Status Pembayaran -->
      <div>
        <label class="block text-sm font-medium">Status Pembayaran</label>
        <select
          name="payment_status"
          class="mt-1 block w-full rounded-lg bg-slate-100 border-0 px-3 py-2"
        >
          <option value="Belum Lunas">Belum Lunas</option>
          <option value="Lunas">Lunas</option>
        </select>
      </div>

      <!-- Estimasi Harga -->
      <div class="bg-indigo-50 rounded-xl p-4 text-indigo-700">
        <p class="text-sm">Estimasi Total Harga:</p>
        <p id="totalPrice" class="text-lg font-semibold">Rp 0</p>
      </div>

      <!-- Button -->
      <div>
        <button
          type="submit"
          class="w-full py-3 rounded-xl font-semibold text-white
                 bg-gradient-to-r from-black to-slate-800"
        >
          + Tambah Pesanan
        </button>
      </div>
    </form>
  </div>
</div>

<!-- SCRIPT HITUNG HARGA -->
<script>
  const service = document.getElementById('service');
  const weight = document.getElementById('weight');
  const totalPrice = document.getElementById('totalPrice');

  function hitungTotal() {
    const selected = service.options[service.selectedIndex];
    const price = selected?.dataset.price ?? 0;
    const kg = weight.value ?? 0;
    const total = price * kg;

    totalPrice.innerText = 'Rp ' + Number(total).toLocaleString('id-ID');
  }

  service.addEventListener('change', hitungTotal);
  weight.addEventListener('input', hitungTotal);
</script>
@endsection
