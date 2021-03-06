<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Bill;
use App\Customer;
use Carbon\Carbon;

class BillController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {  
        
        $data=Bill::orderBy('id', 'DESC')
        ->with('customer')
        ->with('package_data');
        if(isset($request->customer) && !empty($request->customer))
        {
            $data->where('customer_id',$request->customer);

        }
        if(isset($request->month) && !empty($request->month))
        {
            $data->where('month',$request->month);

        }
        if(isset($request->year) && !empty($request->year))
        {
            $data->where('year',$request->year);

        }
        
        $data=$data->where('status',1)
        ->get();
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $auth_id=Auth::id();
        $request->request->add(['admin_id' => $auth_id]);
        $create=Bill::create($request->all());
        if($create)
        {
            $data=Bill::with('customer')
            ->with('package_data')
            ->find($create->id);
            return response()->json([
                'msg' => 'Inserted',
                'status' => $data
           ],200);
        }
        else
        {
            return response()->json([
                'msg' => 'Inserted',
                'status' => false
           ],200);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data=Bill::find($id);
        return $data;
    }
    public function customerBill($id)
    {
        $data=Bill::with('customer')
        ->with('package_data')
        ->where('customer_id',$id)
        ->where('status',1)
        ->orderBy('id', 'DESC')
        ->get();
        return $data;
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $update=Bill::where('id',$id)->update($request->all());
        return $update;
    }
    public function updateData(Request $request)
    {
        $update=Bill::where('id',$request->id)->update($request->all());
        return $update;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Bill::where('id','=',$id)
          ->first();
        $data->delete();
        return $data;
    }
    public function generate()
    {
        $auth_id=Auth::id();
        $users=Customer::where('status',1)
        ->with('package')
        ->get();
        $date = Carbon::now(); 
        $month=date_format($date,"m");
        $year=date_format($date,"Y");
        $bills=Bill::where('enddate',date_format($date,"y-m-m"))
        ->delete();

       foreach($users as $user)
            {
                Bill::create(
                    [
                        'admin_id' => $auth_id,
                        'customer_id' => $user->id,
                        'package' => $user->package_id,
                        'price' => $user->package->price,
                        'startdate' => date_format($date,"y-m-m"),
                        'enddate' => date_format($date,"y-m-m"),
                        'month' => $month,
                        'year' => $year,
                    ]
                    );
            }
            return response()->json([
                'msg' => 'Inserted',
                'status' => $users,
                'month' => $month,
                'year' => $year,
           ],200);
    }
    public function generate_bill(Request $request)
    {
        $users=Customer::where('status',1)
        ->with('package')
        ->get();
        $date = Carbon::now(); 
        $month=$request->month;
        $year=$request->year;
        $search_format=$year.'-'.$month.'-'.$month;
        $bills=Bill::where('enddate',date_format($date,$search_format))
        ->delete();

       foreach($users as $user)
            {
                Bill::create(
                    [
                        'admin_id' => 1,
                        'customer_id' => $user->id,
                        'package' => $user->package_id,
                        'price' => $user->package->price,
                        'startdate' => $search_format,
                        'enddate' => $search_format,
                        'month' => $month,
                        'year' => $year,
                    ]
                    );
            }
            return response()->json([
                'msg' => 'Inserted',
                'status' => $users,
                'month' => $month,
                'year' => $year,
           ],200);
    }
}
