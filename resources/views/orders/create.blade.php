@extends('layout')

@section('content')
<div class="max-w-2xl mx-auto">
  <div class="bg-white rounded-xl shadow p-6">
    <h2 class="text-lg font-semibold mb-2">Tambah Pesanan Baru</h2>
    <p class="text-sm text-slate-500 mb-4">Input data pesanan laundry pelanggan</p>

    <form action="{{ route('orders.store') }}" method="POST" class="space-y-4">
      @csrf

      <div>
        <label class="block text-sm font-medium">Nama Pelanggan</label>
        <input name="customer_name" value="{{ old('customer_name') }}" required class="mt-1 block w-full rounded-md border px-3 py-2" placeholder="Masukkan nama pelanggan">
        @error('customer_name') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
      </div>

      <div>
        <label class="block text-sm font-medium">Nomor Telepon (Opsional)</label>
        <input name="phone" value="{{ old('phone') }}" class="mt-1 block w-full rounded-md border px-3 py-2" placeholder="08xxxxxxxxxx">
      </div>

      <div>
        <label class="block text-sm font-medium">Jenis Layanan</label>
        <select name="service_id" required class="mt-1 block w-full rounded-md border px-3 py-2">
          <option value="">Pilih jenis layanan</option>
          @foreach($services as $s)
            <option value="{{ $s->id }}">{{ $s->name }} - Rp {{ number_format($s->price_per_kg,0,',','.') }}/kg</option>
          @endforeach
        </select>
        @error('service_id') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
      </div>

      <div>
        <label class="block text-sm font-medium">Berat (kg)</label>
        <input type="number" step="0.1" name="weight" value="{{ old('weight', 0) }}" required class="mt-1 block w-full rounded-md border px-3 py-2">
        @error('weight') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
      </div>

      <div>
        <button class="w-full bg-indigo-900 text-white py-3 rounded-lg font-semibold">+ Tambah Pesanan</button>
      </div>
    </form>
  </div>
</div>
@endsection
