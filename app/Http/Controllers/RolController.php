<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rol;


class RolController extends Controller
{
    public function index(){
        $rols = Rol::get();
        return response()->json(['status' => 'OK', 'message' => 'Datos cargados', 'data' => $rols], 200);
    }

    public function show($rol_id){
        $rol = Rol::where('rol_id', '=', $rol_id)->first();
        return response()->json(['status' => 'OK', 'message' => 'Datos cargados', 'data' => $rol], 200);
    }
    
    public function store(Request $request){

        $name = ( isset($request->name)) ? $request->name : null;
        $description = ( isset($request->description)) ? $request->description : null;
        $status = ( isset($request->status)) ? $request->status : null;

        if( !is_null($name) && !is_null($description) && !is_null($status) ){
            //crea el rol
            $rol = new Rol();

            $rol->name = $name;
            $rol->description = $description;
            $rol->status = $status;

            $rol->save();

            return $data = array(
                    'status' => 'sucess',
                    'code' => 200,
                    'message' => 'Rol registrado correctamente'
                );       
     
        }else{

            $data = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Rol no creado'
            );

        }

    }

    public function update(Request $request, $rol_id)
    {
        $data = $request->toArray();
        $rol = Rol::where('rol_id', '=', $rol_id)->update($data);
        return response()->json(['status' => 'OK', 'message' => 'Datos actualizados'], 202);
      
    }

    public function destroy(Request $request, $rol_id){
        $rol = Rol::find($rol_id);
        $rol->delete();
        return response()->json(['status' => 'OK', 'message' => 'Datos eliminados'], 400);
    }
}
