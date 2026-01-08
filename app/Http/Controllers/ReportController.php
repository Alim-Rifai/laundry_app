<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $r)
    {
        $start = $r->start_date;
        $end   = $r->end_date;

        $q = Order::with('service')
            ->orderBy('created_at', 'desc');

        // ================= FILTER PERIODE (WIB) =================
        if ($start && $end) {
            $q->whereBetween('created_at', [
                Carbon::parse($start, 'Asia/Jakarta')->startOfDay(),
                Carbon::parse($end, 'Asia/Jakarta')->endOfDay()
            ]);
        }

        $orders = $q->get();

        // ================= RINGKASAN =================
        $income_paid = $orders
            ->where('payment_status', 'lunas')
            ->sum('total_price');

        $income_unpaid = $orders
            ->where('payment_status', 'belum_lunas')
            ->sum('total_price');

        return view('reports.index', compact(
            'orders',
            'income_paid',
            'income_unpaid',
            'start',
            'end'
        ));
    }
}
