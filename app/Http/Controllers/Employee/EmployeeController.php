<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('employee.dashboard', [
            'ordersCount' => Order::count(),

            'latestOrders' => Order::latest()
                ->take(10)
                ->get(),
        ]);
    }
}
