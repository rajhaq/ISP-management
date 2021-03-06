<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invoice;
use App\InvoiceBill;
use App\Setting;
use App\Bill;
use Auth;
class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data=Invoice::orderBy('id', 'DESC')
        ->with('customer')
        ->with('bill');
        if(isset($request->customer) && !empty($request->customer))
        {
            $data->where('customer_id',$request->customer);

        }
        $data=$data->get();
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $create=Invoice::create(
            [
                'admin_id' => $auth_id,
                'customer_id'=>$request->customer_id,
                'total_amount'=>$request->total_amount,
                'total_bill'=>$request->total_bill,
            ]
        );
        foreach($request->bills as $bill)
        {
            InvoiceBill::create(
                [
                    'invoice_id' => $create->id,
                    'bill_id'=>$bill['id'],
                ]
                );
                Bill::where('id',$bill['id'])
                ->update(
                    [
                        
                        'status'=>0,
                    ]
                    );
        }

        if($create)
        {
            
            return response()->json([
                'msg' => 'Inserted',
                'status' => $create
           ],200);
        }
        else
        {
            return response()->json([
                'msg' => 'Error',
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
        $data=Invoice::with('customer')
        ->with('bill')
        ->with('admin')
        ->where('id',$id)
        ->first();
        $setting=Setting::first();
        // return $data;
        return view('invoice')->with(['data'=>$data, 'setting'=>$setting]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data=Invoice::where('id', $id)
        ->with('bill')
        ->first();
        foreach($data->bill as $bill)
        {

                Bill::where('id',$bill['bill_id'])
                ->update(
                    [
                        
                        'status'=>1,
                    ]
                    );
        }
        InvoiceBill::where('invoice_id',$id)
        ->delete();
        $data->delete();
        return $data;
        
    }
}
