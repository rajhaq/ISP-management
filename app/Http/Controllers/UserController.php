<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=User::select('email','id','name','userType','area_id')
        ->get();
        return $data;
    }
    public function auth()
    {
        $data=Auth::user();
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
        $user=new User;
        $user->name=$request->input('name');
        $user->email=$request->input('email');
        $user->userType=$request->input('userType');
        $user->area_id=$request->input('area_id');
        $user->password=bcrypt($request->input('password'));
        $user->save();
        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    }
    public function updatepassword($id)
    {
         $update=User::where('id',$id)->update(
            [
                'password'=>bcrypt('password'),
            ]
         );
        return $update;
    }
    public function profile()
    {
        $data=Auth::user();
        return $data;
    }
    public function updateUser(Request $request)
    {
        $update=User::where('id',$request->id)->update($request->all());
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
        $group = User::where('id','=',$id)
          ->first();
        $group->delete();
        return $group;
    }
    public function changePass(Request $request)
    {
        

        $request->validate([
            'newPassword' => ['required'],
            'confirmPassword' => ['same:newPassword'],
        ]);
        if(!Hash::check($request->oldPassword,Auth::user()->password))
        {
            return response()->json(
                [
                    'status'=> false,
                    'message'=> 'Current Password dose not matched'
                ], 200);
        }
        else
        {                     
            $update=User::find(auth()->user()->id)->update(['password'=> Hash::make($request->newPassword)]);  
            if($update)   
            {
                return response()->json(
                    [
                        'status'=> true,
                        'message'=> 'Successfuly Changed'
                    ], 200);
            } 
            else
            {
                return response()->json(
                    [
                        'status'=> false,
                        'message'=> 'Failed, Try again'
                    ], 200);
            }

        }
    }
}
