@extends('layout')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">

    {{-- ================= FILTER LAPORAN PENDAPATAN ================= --}}
    <div class="bg-white rounded-2xl border p-6">
        <h3 class="text-lg font-semibold">Laporan Pendapatan</h3>
        <p class="text-sm text-slate-500 mb-6">
            Analisis pendapatan berdasarkan periode
        </p>

        <form method="GET" class="flex gap-6 items-end">

            {{-- Tanggal Mulai --}}
            <div class="w-1/2">
                <label class="text-sm text-slate-600 mb-1 block">
                    Tanggal Mulai
                </label>
                <input type="date"
                    name="start_date"
                    value="{{ request('start_date') }}"
                    onchange="this.form.submit()"
                    class="w-full border rounded-lg px-3 py-2 text-sm">
            </div>

            {{-- Tanggal Akhir --}}
            <div class="w-1/2">
                <label class="text-sm text-slate-600 mb-1 block">
                    Tanggal Akhir
                </label>
                <input type="date"
                    name="end_date"
                    value="{{ request('end_date') }}"
                    onchange="this.form.submit()"
                    class="w-full border rounded-lg px-3 py-2 text-sm">
            </div>

        </form>
    </div>


    {{-- ================= RINGKASAN ================= --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        <div class="bg-white rounded-2xl border p-5 flex gap-4">
            <div class="bg-green-100 text-green-600 p-3 rounded-xl">Rp</div>
            <div>
                <p class="text-sm text-slate-500">Pendapatan Lunas</p>
                <p class="font-semibold text-green-600">
                    Rp {{ number_format($income_paid,0,',','.') }}
                </p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border p-5 flex gap-4">
            <div class="bg-orange-100 text-orange-600 p-3 rounded-xl">!</div>
            <div>
                <p class="text-sm text-slate-500">Belum Lunas</p>
                <p class="font-semibold text-orange-600">
                    Rp {{ number_format($income_unpaid,0,',','.') }}
                </p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border p-5 flex gap-4">
            <div class="bg-sky-100 text-sky-600 p-3 rounded-xl">📦</div>
            <div>
                <p class="text-sm text-slate-500">Total Pesanan</p>
                <p class="font-semibold">{{ $orders->count() }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border p-5 flex gap-4">
            <div class="bg-indigo-100 text-indigo-600 p-3 rounded-xl">✓</div>
            <div>
                <p class="text-sm text-slate-500">Selesai / Proses</p>
                <p class="font-semibold">
                    {{ $orders->where('status','selesai')->count() }}
                    /
                    {{ $orders->where('status','proses')->count() }}
                </p>
            </div>
        </div>

    </div>

    {{-- ================= DAFTAR PESANAN ================= --}}
    <div class="bg-white rounded-2xl border p-6">
        <h3 class="font-semibold mb-4">Daftar Pesanan</h3>

        <div class="space-y-4">
            @forelse($orders as $o)
            <div class="border rounded-xl p-5 flex justify-between items-center">
                <div>
                    <p class="font-semibold">{{ $o->customer_name }}</p>
                    <p class="text-sm text-slate-500">{{ $o->service->name }}</p>

                    <p class="text-sm text-slate-500">
                        {{ $o->weight }} kg ·
                        Rp {{ number_format($o->total_price,0,',','.') }}
                    </p>

                    <p class="text-xs text-slate-400 mt-1">
                        {{ $o->created_at->timezone('Asia/Jakarta')->translatedFormat('d F Y') }}
                        • {{ $o->created_at->timezone('Asia/Jakarta')->format('H:i') }} WIB
                    </p>
                </div>

                <div class="text-right space-y-2">
                    <span class="px-3 py-1 text-xs rounded-full
                        {{ $o->status=='selesai' ? 'bg-indigo-600 text-white' : 'bg-slate-200' }}">
                        {{ ucfirst($o->status) }}
                    </span>

                    <span class="block px-3 py-1 text-xs rounded-full
                        {{ $o->payment_status=='lunas' ? 'bg-green-600 text-white' : 'bg-red-500 text-white' }}">
                        {{ $o->payment_status=='lunas' ? 'Lunas' : 'Belum Lunas' }}
                    </span>
                </div>
            </div>
            @empty
                <p class="text-center text-slate-500">Tidak ada data</p>
            @endforelse
        </div>
    </div>

</div>
@endsection
