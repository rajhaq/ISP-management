<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Area;
use Auth;
class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Area::orderBy('id', 'DESC')
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
        $create=Area::create($request->all());
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
    public function show($id)
    {
        $data=Area::find($id);
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
        $update=Area::where('id',$id)->update($request->all());
        return $update;
    }
    public function updateData(Request $request)
    {
        $update=Area::where('id',$request->id)->update($request->all());
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
        $data = Area::where('id','=',$id)
          ->first();
        $data->delete();
        return $data;
    }
}
