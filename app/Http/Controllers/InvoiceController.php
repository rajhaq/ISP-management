<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invoice;
use App\InvoiceBill;
use App\Setting;
use Auth;
class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Invoice::orderBy('id', 'DESC')
        ->with('customer')
        ->with('bill')
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
        //
    }
}
