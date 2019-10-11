<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use Auth;

use Illuminate\Support\Facades\Validator;
class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data=Customer::orderBy('id', 'DESC')
        ->with('area')
        ->with('package')
        ->with('bill') ;
        if(isset($request->area) && !empty($request->area))
        {
            $data->where('area_id',$request->area);

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
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => ['required', 'max:255', 'unique:customers'],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'msg' => $validator->errors(),
                'status' => false
           ],200);
        }
        $auth_id=Auth::id();
        $request->request->add(['admin_id' => $auth_id]);
        $create=Customer::create($request->all());
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
    public function customerwitharea($id)
    {
        $data=Customer::where('area_id',$id)
        ->with('bill') 
        ->where('status',1)
        ->get();
        return $data;
    }
    public function show($id)
    {
        $data=Customer::find($id);
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
        $update=Customer::where('id',$id)->update($request->all());
        return $update;
    }
    public function updateData(Request $request)
    {
        $update=Customer::where('id',$request->id)->update($request->all());
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
        $data = Customer::where('id','=',$id)
          ->first();
        $data->delete();
        return $data;
    }
}