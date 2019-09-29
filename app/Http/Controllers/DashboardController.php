<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Bill;
use Carbon\Carbon;
class DashboardController extends Controller
{
    public function index()
    {
        $customer=Customer::count();
        $bill=Bill::count();
        $pending_bill=Bill::where('status',0)
        ->count();
        $create=false;
        $date = Carbon::now(); 
        $bills=Bill::where('enddate',date_format($date,"y-m-m"))
        ->get();
        if(count($bills))
        {
            $create=true;      
    
        }
        $obj = (object) [
            'customer' => $customer,
            'bill' => $bill,
            'pending_bill' => $pending_bill,
            'create'=> $create
        ];
        
        $myJSON=json_encode($obj);
        return $myJSON;
    }
}
