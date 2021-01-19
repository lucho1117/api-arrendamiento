<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserModule;
use App\User;
use App\Module;

class UserModuleController extends Controller
{
    public function index(){
        $user_module = UserModule::get();
        return response()->json(['status' => 'OK', 'message' => 'Datos cargados', 'data' => $user_module], 200);
    }

    public function show($user_module_id){
        $user_module = UserModule::where('user_module_id', '=', $user_module_id)->first();
        return response()->json(['status' => 'OK', 'message' => 'Datos cargados', 'data' => $user_module], 200);
    }
    
    public function store(Request $request){

        $user_id = ( isset($request->user_id)) ? $request->user_id : null;
        $module_id = ( isset($request->module_id)) ? $request->module_id : null;
        $description = ( isset($request->description)) ? $request->description : null;

        if( !is_null($description) && !is_null($user_id) && !is_null($module_id) ){

            $user = User::where('user_id', '=', $user_id)->first();
            $module = Module::where('module_id', '=', $module_id)->first();

            if( !is_null($user) && !is_null($module)){
                //crea el user_module
                $user_module = new UserModule();
                $user_module->user_id = $user_id;
                $user_module->module_id = $module_id;
                $user_module->description = $description;

                $user_module->save();
                return $data = array('status' => 'sucess','code' => 200,'message' => 'UserModule registrado correctamente'  );     

            }else{
                return $data = array('status' => 'error','code' => 200,'message' => 'Usuario o modulo no existen'  );    
            }
              
        }else{
            return $data = array('status' => 'error','code' => 400,'message' => 'UserModule no creado');
        }

    }

    public function update(Request $request, $user_module_id)
    {
        $user = User::where('user_id', '=', $request->user_id)->first();
        $module = Module::where('module_id', '=', $request->module_id)->first();

        if( !is_null($user) && !is_null($module)){
            $data = $request->toArray();
            $user_module = UserModule::where('user_module_id', '=', $user_module_id)->update($data);
            return response()->json(['status' => 'OK', 'message' => 'Datos actualizados'], 202);

        }else{
            return $data = array('status' => 'error','code' => 200,'message' => 'Usuario o modulo no existen'  );    
        }  
      
    }

    public function destroy(Request $request, $user_module_id){
        $user_module = UserModule::find($user_module_id);
        $user_module->delete();
        return response()->json(['status' => 'OK', 'message' => 'Datos eliminados'], 400);
    }
}
