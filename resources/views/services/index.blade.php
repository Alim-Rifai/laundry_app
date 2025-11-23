@extends('layout')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

  {{-- FORM TAMBAH LAYANAN --}}
  <div class="bg-white rounded-xl shadow p-6">
    <h3 class="font-semibold">Tambah Layanan Baru</h3>
    <p class="text-sm text-slate-500">Buat jenis layanan laundry baru</p>

    <form action="{{ url('/services') }}" method="POST" class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-3">
      @csrf
      <input name="name" placeholder="Contoh: Cuci Kering" class="col-span-2 rounded border px-3 py-2" required>
      <input name="price_per_kg" placeholder="5000" class="rounded border px-3 py-2" required type="number" min="0">
      <div class="md:col-span-3">
        <button class="w-full bg-indigo-900 text-white py-2 rounded">+ Tambah Layanan</button>
      </div>
    </form>
  </div>

  {{-- DAFTAR LAYANAN --}}
  <div class="bg-white rounded-xl shadow p-6">
    <h3 class="font-semibold">Daftar Layanan</h3>
    <div class="mt-3 space-y-3">

      @foreach($services as $s)
      <div class="flex items-center justify-between border rounded p-3">

        <div>
          <div class="font-medium">{{ $s->name }}</div>
          <div class="text-sm text-slate-500">
            Rp {{ number_format($s->price_per_kg,0,',','.') }}/kg
          </div>
        </div>

        <div class="flex gap-2">

          {{-- TOMBOL EDIT --}}
          <button 
            onclick="openEditModal({{ $s->id }}, '{{ $s->name }}', {{ $s->price_per_kg }})"
            class="px-3 py-2 rounded border text-slate-600 bg-yellow-100 hover:bg-yellow-200">
            ✏️
          </button>

          {{-- DELETE --}}
          <form action="{{ route('services.destroy', $s) }}" method="POST" onsubmit="return confirm('Hapus layanan?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-3 py-2 rounded bg-red-500 text-white">🗑️</button>
          </form>

        </div>
      </div>
      @endforeach

    </div>
  </div>
</div>


{{-- MODAL EDIT --}}
<div id="editModal" class="fixed inset-0 bg-black/30 hidden flex items-center justify-center z-50">
  <div class="bg-white rounded-xl shadow p-6 w-80">

    <h3 class="font-semibold text-lg">Edit Layanan</h3>

    <form id="editForm" method="POST" class="mt-4 space-y-3">
      @csrf
      @method('PUT')

      <div>
        <label class="text-sm">Nama Layanan</label>
        <input id="editName" name="name" class="w-full rounded border px-3 py-2" required>
      </div>

      <div>
        <label class="text-sm">Harga per kg</label>
        <input id="editPrice" name="price_per_kg" type="number" min="0" class="w-full rounded border px-3 py-2" required>
      </div>

      <div class="flex gap-3 mt-4">
        <button type="button" onclick="closeEditModal()" class="w-1/2 bg-slate-200 py-2 rounded">
          Batal
        </button>
        <button class="w-1/2 bg-indigo-900 text-white py-2 rounded">
          Simpan
        </button>
      </div>

    </form>

  </div>
</div>


<script>
function openEditModal(id, name, price) {
  document.getElementById('editModal').classList.remove('hidden');

  // isi form
  document.getElementById('editName').value = name;
  document.getElementById('editPrice').value = price;

  // ubah route action
  document.getElementById('editForm').action = '/services/' + id;
}

function closeEditModal() {
  document.getElementById('editModal').classList.add('hidden');
}
</script>

@endsection
