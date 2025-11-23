<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Service;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $r)
    {
        // filter periode (today, this_month, all)
        $q = Order::with('service')->orderBy('created_at','desc');

        if ($r->periode === 'today') {
            $q->whereDate('created_at', Carbon::today());
        } elseif ($r->periode === 'this_month') {
            $q->whereMonth('created_at', Carbon::now()->month)
              ->whereYear('created_at', Carbon::now()->year);
        }

        if ($r->status) {
            $q->where('status', $r->status);
        }

        $orders = $q->get();

        $income_paid = $orders->where('payment_status', 'lunas')->sum('total_price');
        $income_unpaid = $orders->where('payment_status', 'belum_lunas')->sum('total_price');
        $total_orders = $orders->count();

        // statistik per layanan
        $perService = Service::withCount(['orders as orders_count' => function($q){
            // nothing
        }])->get();

        return view('reports.index', compact('orders','income_paid','income_unpaid','total_orders','perService'));
    }
}
