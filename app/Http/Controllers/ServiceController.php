<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;

class ServiceController extends Controller
{
    public function index(){
        $services = Service::get();
        return response()->json(['status' => 'OK', 'message' => 'Datos cargados', 'data' => $services], 200);
    }

    public function show($service_id){
        $service = Service::where('service_id', '=', $service_id)->first();
        return response()->json(['status' => 'OK', 'message' => 'Datos cargados', 'data' => $service], 200);
    }
    
    public function store(Request $request){

        $name = ( isset($request->name)) ? $request->name : null;
        $description = ( isset($request->description)) ? $request->description : null;
        $status = ( isset($request->status)) ? $request->status : null;

        if( !is_null($name) && !is_null($description) && !is_null($status) ){
            //crea el service
            $service = new Service();
            $service->name = $name;
            $service->description = $description;
            $service->status = $status;

            $service->save();
            return $data = array('status' => 'OK','code' => 200,'message' => 'Servicio registrado correctamente'  );       
     
        }else{
            $data = array('status' => 'error','code' => 400,'message' => 'Servicio no creado');
        }

    }

    public function update(Request $request, $service_id)
    {
        $data = $request->toArray();
        $service = Service::where('service_id', '=', $service_id)->update($data);
        return response()->json(['status' => 'OK', 'message' => 'Datos de servicio actualizados'], 202);
      
    }

    public function destroy(Request $request, $service_id){
        $service = Service::find($service_id);
        $service->delete();
        return response()->json(['status' => 'OK', 'message' => 'Datos eliminados'], 400);
    }
}
