<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('created_at','desc')->get();
        return view('services.index', compact('services'));
    }

    public function store(Request $r)
    {
        $r->validate([
            'name' => 'required|string',
            'price_per_kg' => 'required|numeric|min:0'
        ]);

        Service::create($r->only('name','price_per_kg'));
        return back()->with('success','Layanan berhasil ditambahkan.');
    }

    public function update(Request $r, Service $service)
    {
        $r->validate([
            'name' => 'required|string',
            'price_per_kg' => 'required|numeric|min:0'
        ]);

        $service->update($r->only('name','price_per_kg'));
        return back()->with('success','Layanan diperbarui.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return back()->with('success','Layanan dihapus.');
    }
}
