<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Local;
use App\Service;
use App\LocalService;
use Illuminate\Support\Facades\DB;

class LocalServiceController extends Controller
{
    public function index(){
       
        $local_service = LocalService::
        from('local_service AS los')
        ->join('local AS loc', 'loc.local_id', '=', 'los.local_id')
        ->join('service AS ser', 'ser.service_id', '=', 'los.service_id')
        ->select('los.*', 'loc.name AS local', 'ser.name AS service' )
        ->get();
        return response()->json(['status' => 'OK', 'message' => 'Datos cargados', 'data' => $local_service], 200);
    }



    public function show($local_service_id) {
        $local_service = LocalService::where('local_service_id', '=', $local_service_id)->first();
        return response()->json(['status' => 'OK', 'message' => 'Datos cargados', 'data' => $local_service], 200);
    }

    public function showInquilino( $inquilino_id ) {
        $local_service = LocalService::
        from('local_service AS los')
        ->join('local AS lo', 'lo.local_id', '=', 'los.local_id')
        ->join('service AS ser', 'ser.service_id', '=', 'los.service_id')
        ->where('lo.inquilino_id', '=', $inquilino_id)
        ->select('los.*', 'lo.name AS local', 'ser.name AS service')
        ->get();
         return response()->json(['status' => 'OK', 'message' => 'Datos cargados', 'data' => $local_service], 200);
    }

     public function showPropietario( $propietario_id ) {
        $local_service = LocalService::
        from('local_service AS los')
        ->join('local AS lo', 'lo.local_id', '=', 'los.local_id')
        ->join('service AS ser', 'ser.service_id', '=', 'los.service_id')
        ->where('lo.propietario_id', '=', $propietario_id)
        ->where('los.service_id', '=', 1)
        ->select('los.*', 'lo.name AS local', 'ser.name AS service')
        ->get();
         return response()->json(['status' => 'OK', 'message' => 'Datos cargados', 'data' => $local_service], 200);
    }
    
    public function store(Request $request){

        $payment = ( isset($request->payment)) ? $request->payment : null;
        $file = ( isset($request->file)) ? $request->file : null;
        $month = ( isset($request->month)) ? $request->month : null;
        $status = ( isset($request->status)) ? $request->status : null;
        $local_id = ( isset($request->local_id)) ? $request->local_id : null;
        $service_id = ( isset($request->service_id)) ? $request->service_id : null;
        $year = ( isset($request->year)) ? $request->year : null;

        if( !is_null($payment) && !is_null($status) && !is_null($local_id) && !is_null($service_id) ){

            $local = Local::where('local_id', '=', $local_id)->first();
            $service = Service::where('service_id', '=', $service_id)->first();

            //Verificando que el local y el servicio existan
            if( !is_null($local) && !is_null($service)){

                //Verificando que no exista un servicio con los mismos campos seleccionados
                $existLocalService = LocalService::
                from('local_service AS los')
                ->where('los.local_id', '=', $local_id)
                ->where('los.service_id', '=', $service_id)
                ->where('los.month', '=', $month)
                ->where('los.year', '=', $year)
                ->first();

                if( is_null($existLocalService) ) {
                    //crea el local_service
                    $local_service = new LocalService();
                    $local_service->payment = $payment;
                    $local_service->file = $file;
                    $local_service->month = $month;
                    $local_service->status = $status;
                    $local_service->year = $year;
                    $local_service->local_id = $local_id;
                    $local_service->service_id = $service_id;

                    $local_service->save();
                    return $data = array('status' => 'OK','code' => 200,'message' => 'Servicio de local registrado correctamente'  );
                } else {
                    return $data = array('status' => 'error','code' => 400,'message' => 'Ya existe un registro con los mismos datos'  );
                }     

            }else{
                return $data = array('status' => 'error','code' => 200,'message' => 'Verifique que todos los campos existan'  );    
            }
              
        }else{
            return $data = array('status' => 'error','code' => 400,'message' => 'Servicio de local no creado');
        }

    }

    public function update(Request $request, $local_service_id) {
        $local = Local::where('local_id', '=', $request->local_id)->first();
        $service = Service::where('service_id', '=', $request->service_id)->first();

        if( !is_null($local) && !is_null($service)){
            $data = $request->toArray();
            $local_service = LocalService::where('local_service_id', '=', $local_service_id)->update($data);
            return response()->json(['status' => 'OK', 'message' => 'Datos de servicio de local actualizados'], 202);

        }else{
            return $data = array('status' => 'error','code' => 200,'message' => 'Verifique que todos los campos existan'  );    
        }  
      
    }

     public function updateStatus(Request $request, $local_service_id) {
        
            $data = $request->toArray();
            $local_service = LocalService::where('local_service_id', '=', $local_service_id)->update($data);
            return response()->json(['status' => 'OK', 'message' => 'Datos actualizados'], 202);
    }

     public function localServicefilter( $local_id, $service_id, $year, $status, $month ) {

        $local_service = LocalService::
        from('local_service AS los')
        ->join('local AS loc', 'loc.local_id', '=', 'los.local_id')
        ->join('service AS ser', 'ser.service_id', '=', 'los.service_id')
        ->select('los.*', 'loc.name AS local', 'ser.name AS service' )
         ->when( $local_id > 0 , function($sql) use($local_id){
         return $sql->where('los.local_id', '=', $local_id);
        })
        ->when($service_id > 0 , function($sql) use($service_id){
            return $sql->where('los.service_id', '=', $service_id);
        })
        ->when($month != 'Todos' , function($sql) use($month){
            return $sql->where('los.month', '=', $month);
        })
        ->when( $year > 0 , function($sql) use($year){
         return $sql->where('los.year', '=', $year);
        })
        ->when( $status < 2 , function($sql) use($status){
         return $sql->where('los.status', '=', $status);
        })
        ->get();
        return response()->json(['status' => 'OK', 'message' => 'Datos cargados', 'data' => $local_service], 200);
    }

     public function getServicesSlopes() {
      $local_service = DB::table('local_service as loser')
      ->join('local as lo', 'lo.local_id', '=', 'loser.local_id')
      ->select('loser.local_id', 'lo.name as local', DB::raw('count(loser.service_id) as services'))
      ->where('loser.status', '=', 1)
      ->groupBy('loser.local_id', 'lo.name')
      ->get();
    return response()->json(['status' => 'OK', 'message' => 'Datos cargados', 'data' => $local_service], 200); 

    }

    public function getServicesSlopesArrendamiento() {
      $local_service = DB::table('local_service as loser')
      ->join('local as lo', 'lo.local_id', '=', 'loser.local_id')
      ->join('service as ser', 'ser.service_id', 'loser.service_id')
      ->select('loser.local_id', 'lo.name as local','ser.name as service', DB::raw('count(loser.service_id) as services'))
      ->where('loser.status', '=', 1)
      ->where('loser.service_id', '=', 1)
      ->groupBy('loser.local_id', 'lo.name', 'ser.name')
      ->get();
    return response()->json(['status' => 'OK', 'message' => 'Datos cargados', 'data' => $local_service], 200); 

    }


    public function destroy(Request $request, $local_service_id) {
        $local_service = LocalService::find($local_service_id);
        $local_service->delete();
        return response()->json(['status' => 'OK', 'message' => 'Datos eliminados'], 400);
    }
}
