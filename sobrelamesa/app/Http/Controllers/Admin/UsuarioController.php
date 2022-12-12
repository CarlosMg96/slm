<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.users.index');
    }

    public function get_personales(Request $request){
        $objectPersonal = User::where('status',1)->orderBy('id','DESC')->get();
        echo json_encode(array(
            'status'=>true,
            'objectPersonal'=>$objectPersonal
        ));
    }

    public function get_personales_type(Request $request){
        $objectPersonal = User::where('tipo_usuario',3)->orderBy('id','DESC')->get();
        echo json_encode(array(
            'status'=>true,
            'objectPersonal'=>$objectPersonal
        ));
    }

    public function form_add_personal(Request $request){
        $objectPersonal = new User($request->all());
        $objectPersonal->password = bcrypt($request->pwd);
        $objectPersonal->save();    
        echo json_encode(array(
            'status'=>true,
            'objectPersonal'=>$objectPersonal
        ));
    }

    public function form_edit_personal(Request $request){
        $objectPersonal = User::find($request->personalID);
        $objectPersonal->name = $request->name;
        $objectPersonal->email = $request->email;
        $objectPersonal->pwd = $request->pwd;
        $objectPersonal->password = bcrypt($request->pwd);
        $objectPersonal->tipo_usuario = $request->tipo_usuario;
        $objectPersonal->pwds = $request->pwds;
        $objectPersonal->save();

        echo json_encode(array(
            'status'=>true,
            'responsePersonal'=>$objectPersonal
        ));
    }

    public function delete_personal(Request $request){
        $objectPersonal = User::find($request->personalID);
        $objectPersonal->status = 0;        
        $objectPersonal->save();

        echo json_encode(array(
            'status'=>true,
            'responsePersonal'=>$objectPersonal
        ));
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
        //
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
