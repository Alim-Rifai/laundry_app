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
    // default periode
    $periode = $r->periode ?? 'this_week';

    $q = Order::with('service')
              ->orderBy('created_at','desc');

    if ($periode === 'today') {
        $q->whereDate('created_at', Carbon::today());

    } elseif ($periode === 'this_week') {
        $q->whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ]);

    } elseif ($periode === 'this_month') {
        $q->whereMonth('created_at', Carbon::now()->month)
          ->whereYear('created_at', Carbon::now()->year);

    } elseif ($periode === 'this_year') {
        $q->whereYear('created_at', Carbon::now()->year);
    }

    $orders = $q->get();

    $income_paid = $orders->where('payment_status', 'lunas')->sum('total_price');
    $income_unpaid = $orders->where('payment_status', 'belum_lunas')->sum('total_price');
    $total_orders = $orders->count();

    return view('reports.index', compact(
        'orders',
        'income_paid',
        'income_unpaid',
        'total_orders',
        'periode'
    ));
}
}
