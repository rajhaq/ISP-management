<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Directory;
use App\DirectoryContact;
use Illuminate\Support\Facades\DB;

class DirectoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return Directory::get(); 
        $data=Directory::with(array('contact' => function($q)
        {
            $q->selectRaw('id, directory_id, contact,contact_type');
        }))
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
        $user_id=1;
        $directory=new Directory;
        $directory->name=$request->input('name');
        $directory->admin_id=$user_id;
        $directory->position=$request->input('position');
        $directory->account_permission=implode(',',$request->input('permissionValue'));
        $directory->gender=$request->input('gender');
        $directory->nickname=$request->input('nickname');
        $directory->routine=$request->input('routine');
        $directory->notes=$request->input('notes');
        $directory->call_eligible=$request->input('call_eligible');
        $directory->emergency=$request->input('emergency');
        $directory->oncall=$request->input('oncall');
        $directory->general=$request->input('general');
        $directory->message_handling=$request->input('message_handling');
        $directory->save();
        foreach($request->input('phone') as $phone)
        {
            $directorycontact=new DirectoryContact;
            $directorycontact->admin_id=$user_id;
            $directorycontact->directory_id=$directory->id;
            $directorycontact->contact=$phone;
            $directorycontact->contact_type='phone';
            $directorycontact->save();
   
        }
        foreach($request->speedial as $speedial)
        {
            $directorycontact=new DirectoryContact;
            $directorycontact->admin_id=$user_id;
            $directorycontact->directory_id=$directory->id;
            $directorycontact->contact=$speedial;
            $directorycontact->contact_type='speedial';
            $directorycontact->save();

        }
        foreach($request->email as $email)
        {
            $directorycontact=new DirectoryContact;
            $directorycontact->admin_id=$user_id;
            $directorycontact->directory_id=$directory->id;
            $directorycontact->contact=$email;
            $directorycontact->contact_type='email';
            $directorycontact->save();

   
        }
        return $directory;
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
