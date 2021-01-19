<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Module;

class ModuleController extends Controller
{
    public function index(){
        $modules = Module::get();
        return response()->json(['status' => 'OK', 'message' => 'Datos cargados', 'data' => $modules], 200);
    }

    public function show($module_id){
        $module = Module::where('module_id', '=', $module_id)->first();
        return response()->json(['status' => 'OK', 'message' => 'Datos cargados', 'data' => $module], 200);
    }
    
    public function store(Request $request){

        $name = ( isset($request->name)) ? $request->name : null;
        $description = ( isset($request->description)) ? $request->description : null;

        if( !is_null($name) && !is_null($description) ){
            //crea el module
            $module = new Module();
            $module->name = $name;
            $module->description = $description;

            $module->save();
            return $data = array('status' => 'sucess','code' => 200,'message' => 'Module registrado correctamente'  );       
     
        }else{
            $data = array('status' => 'error','code' => 400,'message' => 'Module no creado');
        }

    }

    public function update(Request $request, $module_id)
    {
        $data = $request->toArray();
        $module = Module::where('module_id', '=', $module_id)->update($data);
        return response()->json(['status' => 'OK', 'message' => 'Datos actualizados'], 202);
      
    }

    public function destroy(Request $request, $module_id){
        $module = Module::find($module_id);
        $module->delete();
        return response()->json(['status' => 'OK', 'message' => 'Datos eliminados'], 400);
    }
}
