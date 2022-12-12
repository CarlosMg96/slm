<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Lugar;

class LugarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.lugar.index');
    }

    public function get_lugar(Request $request){

        $object_lugar = Lugar::where('status', 1)->get();

        if(count($object_lugar) > 0){

            echo json_encode(array(
                'status'=>true,
                'response_object'=>$object_lugar,
                'response_message'=>'Total de Resultados'.count($object_lugar)
            ));

        }else{

            echo json_encode(array(
                'status'=>false,
                'response_message'=>'No se encontraron resultados'
            ));

        }
    }

    public function form_add_lugar(Request $request){

        $object_lugar = new Lugar($request->all());        
        $object_lugar->save();

        if(!empty($object_lugar)){
            /*if($request->hasFile('imagen')){
                $archivo = $request->file('imagen');
                if ($archivo) {
                    $nombre = $object_lugar->id.'.'.$archivo->getClientOriginalExtension();
                    $archivo->move('images/profile_security/',$nombre);
    
                    $object_lugar->foto = $nombre;
                    $object_lugar->save();
                }
            }*/

            echo json_encode(array(
                'status'=>true,
                'response_object'=>$object_lugar,
                'response_message'=>'lugar Registrado Correctamente'
            ));
        }else{
            echo json_encode(array(
                'status'=>false,
                'response_message'=>'Ocurrio un Error'
            ));
        }

    }

    public function form_edit_lugar(Request $request){

        $object_lugar = Lugar::find($request->lugarID);
        $object_lugar->nombre = $request->nombre;
        $object_lugar->direccion = $request->direccion;            
        $object_lugar->save();


        if(!empty($object_lugar)){
            echo json_encode(array(
                'status'=>true,
                'response_object'=>$object_lugar,
                'response_message'=>'Lugar Editado Correctamente'
            ));
        }else{
            echo json_encode(array(
                'status'=>false,
                'response_message'=>'Ocurrio un Error'
            ));
        }


    }


    public function delete_lugar(Request $request){
        $objectLugar = Lugar::find($request->lugarID);
        $objectLugar->status = 0;        
        $objectLugar->save();

        echo json_encode(array(
            'status'=>true,
            'responseLugar'=>$objectLugar
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
