<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Cliente;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.cliente.index');
    }

    public function get_clientes(Request $request){
        //$objectCliente = Cliente::where('status',1)->orderBy('id','DESC')->get();
        $objectCliente = DB::table('cliente')
        ->join('users','cliente.agente_id','=','users.id')            
        ->where('cliente.status',1)        
        ->select(
          'cliente.*',
          'users.name'         
      )
        ->orderBy('cliente.id','DESC')
        ->get();
        echo json_encode(array(
            'status'=>true,
            'objectCliente'=>$objectCliente
        ));
    }

    public function form_add_cliente(Request $request){
        $objectCliente = new Cliente($request->all());
        $objectCliente->save();

        if (!file_exists('images/documentos/client_'.$objectCliente->id)) {
            mkdir('images/documentos/client_'.$objectCliente->id, 0777, true);
        }


        if ($request->hasFile('constancia_fiscal')) {
            $file = $request->file('constancia_fiscal');
            $name = 'constancia_fiscal_'.$objectCliente->id.'.'.$file->getClientOriginalExtension();
            $file->move('images/documentos/client_'.$objectCliente->id,$name);
            $objectCliente->constancia_fiscal = $name;
            $objectCliente->save();
        }

        if ($request->hasFile('ine_front')) {
            $file = $request->file('ine_front');
            $name = 'ine_front_'.$objectCliente->id.'.'.$file->getClientOriginalExtension();
            $file->move('images/documentos/client_'.$objectCliente->id,$name);
            $objectCliente->ine_front = $name;
            $objectCliente->save();
        }

        if ($request->hasFile('ine_back')) {
            $file = $request->file('ine_back');
            $name = 'ine_back_'.$objectCliente->id.'.'.$file->getClientOriginalExtension();
            $file->move('images/documentos/client_'.$objectCliente->id,$name);
            $objectCliente->ine_back = $name;
            $objectCliente->save();
        }

        if ($request->hasFile('comprobante_domicilio')) {
            $file = $request->file('comprobante_domicilio');
            $name = 'comporbante_domicilio_'.$objectCliente->id.'.'.$file->getClientOriginalExtension();
            $file->move('images/documentos/client_'.$objectCliente->id,$name);
            $objectCliente->comprobante_domicilio = $name;
            $objectCliente->save();
        }   

        echo json_encode(array(
            'status'=>true,
            'responseCliente'=>$objectCliente
        ));
    }

    public function form_edit_cliente(Request $request){
        $objectCliente = Cliente::find($request->clienteID);
        $objectCliente->nombre_completo = $request->nombre_completo;
        $objectCliente->empresa = $request->empresa;
        $objectCliente->celular1 = $request->celular1;
        $objectCliente->celular2 = $request->celular2;
        $objectCliente->correo_electronico = $request->correo_electronico;
        $objectCliente->tipo_cliente = $request->tipo_cliente;
        $objectCliente->rfc = $request->rfc;
        $objectCliente->cp = $request->cp;
        $objectCliente->descuento = $request->descuento;
        $objectCliente->forma_pago_autorizada = $request->forma_pago_autorizada;
        $objectCliente->agente_id = $request->agente_id;        
        $objectCliente->save();

        if (!file_exists('images/documentos/client_'.$objectCliente->id)) {
            mkdir('images/documentos/client_'.$objectCliente->id, 0777, true);
        }


        if ($request->hasFile('constancia_fiscal')) {
            $file = $request->file('constancia_fiscal');
            $name = 'constancia_fiscal_'.$objectCliente->id.'.'.$file->getClientOriginalExtension();
            $file->move('images/documentos/client_'.$objectCliente->id,$name);
            $objectCliente->constancia_fiscal = $name;
            $objectCliente->save();
        }

        if ($request->hasFile('ine_front')) {
            $file = $request->file('ine_front');
            $name = 'ine_front_'.$objectCliente->id.'.'.$file->getClientOriginalExtension();
            $file->move('images/documentos/client_'.$objectCliente->id,$name);
            $objectCliente->ine_front = $name;
            $objectCliente->save();
        }

        if ($request->hasFile('ine_back')) {
            $file = $request->file('ine_back');
            $name = 'ine_back_'.$objectCliente->id.'.'.$file->getClientOriginalExtension();
            $file->move('images/documentos/client_'.$objectCliente->id,$name);
            $objectCliente->ine_back = $name;
            $objectCliente->save();
        }

        if ($request->hasFile('comporbante_domicilio')) {
            $file = $request->file('comporbante_domicilio');
            $name = 'comporbante_domicilio_'.$objectCliente->id.'.'.$file->getClientOriginalExtension();
            $file->move('images/documentos/client_'.$objectCliente->id,$name);
            $objectCliente->comporbante_domicilio = $name;
            $objectCliente->save();
        }

        echo json_encode(array(
            'status'=>true,
            'responseCliente'=>$objectCliente
        ));
    }

    public function delete_cliente(Request $request){
        $objectCliente = Cliente::find($request->clienteID);
        $objectCliente->status = 0;        
        $objectCliente->save();

        echo json_encode(array(
            'status'=>true,
            'responseCliente'=>$objectCliente
        ));
    }

    public function get_history_events(Request $request){

        $objectEvento = DB::table('evento')
        ->join('cliente','cliente.id','=','evento.cliente_id')
        ->join('users','users.id','=','evento.agente_id')
        ->join('tipo_evento','tipo_evento.id','=','evento.tipo_evento')
        ->where('evento.cliente_id',$request->clienteID)
        ->select(
          'evento.*',
          'cliente.nombre_completo AS cliente',
          'cliente.celular1',
          'cliente.correo_electronico',
          'cliente.empresa',
          'users.name AS agente',
          'tipo_evento.evento AS evento')
        //->orderBy('evento.id', 'DESC')
        ->get();

        foreach ($objectEvento as $key => $object) {
            // code...
            $objectProductAutorizado = DB::table('producto_autorizado')            
            ->where('evento_id', $object->id)
            ->select(
              'producto_autorizado.*')
            ->get();

            if(count($objectProductAutorizado) > 0){
                $object->status_sobrevendido = true;
            }else{
                $object->status_sobrevendido = false;
            }
        }

        //dd($objectEvento);

        echo json_encode(array(
            'status'=>true,
            'objectEvento'=>$objectEvento            
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
