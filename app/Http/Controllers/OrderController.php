<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Service;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('service')->orderBy('created_at','desc')->get();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $services = Service::all();
        return view('orders.create', compact('services'));
    }

    public function store(Request $r)
    {
        $r->validate([
            'customer_name' => 'required|string',
            'weight' => 'required|numeric|min:0',
            'service_id' => 'required|exists:services,id',
            'phone' => 'nullable|string'
        ]);

        Order::create($r->only('customer_name','phone','service_id','weight'));
        return redirect()->route('orders.index')->with('success','Pesanan ditambahkan.');
    }

    public function updateStatus(Request $r, Order $order)
    {
        $r->validate([
            'status' => 'required|in:proses,selesai',
            'payment_status' => 'required|in:belum_lunas,lunas'
        ]);

        $order->update([
            'status' => $r->status,
            'payment_status' => $r->payment_status,
        ]);

        return back()->with('success','Status berhasil diperbarui.');
    }


        public function destroy(Order $order)
        {
            $order->delete();
            return back()->with('success','Pesanan dihapus.');
        }
    }
