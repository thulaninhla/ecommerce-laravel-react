<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;


class OrderController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Unauthorized');
        }

        $query = \App\Models\Order::query();

        // Search logic
    if ($request->filled('search')) {
        $searchTerm = $request->input('search');
        $query->where('name', 'like', "%{$searchTerm}%")
              ->orWhere('email', 'like', "%{$searchTerm}%");

    }
        $orders = $query->latest()->paginate(5); // 5 per page

        return view('admin.orders', compact('orders'));
    }
}
