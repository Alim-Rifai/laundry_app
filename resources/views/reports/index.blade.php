@extends('layout')

@section('content')
<div class="max-w-5xl mx-auto">

  <div class="bg-white rounded-xl shadow p-6 mb-6">
    <h3 class="font-semibold text-lg">Laporan Pendapatan</h3>
    <p class="text-sm text-slate-500">Analisis pendapatan dan statistik laundry</p>

    <div class="mt-4 grid grid-cols-1 md:grid-cols-4 gap-4">
      <div class="bg-white border rounded p-4">
        <div class="text-sm text-slate-500">Pendapatan (Lunas)</div>
        <div class="text-green-600 font-semibold text-lg mt-2">Rp {{ number_format($income_paid,0,',','.') }}</div>
      </div>
      <div class="bg-white border rounded p-4">
        <div class="text-sm text-slate-500">Belum Lunas</div>
        <div class="text-amber-600 font-semibold text-lg mt-2">Rp {{ number_format($income_unpaid,0,',','.') }}</div>
      </div>
      <div class="bg-white border rounded p-4">
        <div class="text-sm text-slate-500">Total Pesanan</div>
        <div class="text-sky-600 font-semibold text-lg mt-2">{{ $total_orders }}</div>
      </div>
      <div class="bg-white border rounded p-4">
        <div class="text-sm text-slate-500">—</div>
        <div class="text-slate-600 font-semibold text-lg mt-2">&nbsp;</div>
      </div>
    </div>
  </div>

  <div class="bg-white rounded-xl shadow p-6">
    <h4 class="font-semibold">Rincian Pesanan</h4>
    <div class="mt-4 overflow-x-auto">
      <table class="min-w-full divide-y">
        <thead>
          <tr class="text-left text-sm text-slate-500">
            <th class="py-2">Pelanggan</th>
            <th>Layanan</th>
            <th>Berat</th>
            <th>Status</th>
            <th>Pembayaran</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          @foreach($orders as $o)
            <tr class="border-t">
              <td class="py-3">{{ $o->customer_name }}</td>
              <td>{{ $o->service->name }}</td>
              <td>{{ $o->weight }} kg</td>
              <td>{{ ucfirst($o->status) }}</td>
              <td>{{ $o->payment_status == 'lunas' ? 'Lunas' : 'Belum Lunas' }}</td>
              <td>Rp {{ number_format($o->total_price,0,',','.') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

</div>
@endsection
