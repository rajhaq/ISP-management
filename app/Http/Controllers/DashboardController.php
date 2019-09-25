<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Bill;
class DashboardController extends Controller
{
    public function index()
    {
        $customer=Customer::count();
    }
}
