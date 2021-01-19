<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Local;
use App\User;
use App\Sector;

class LocalController extends Controller
{
    public function index(){
        $local = Local::
        from('local AS loc')
        ->join('sector AS sec', 'sec.sector_id', '=', 'loc.sector_id')
        ->join('users AS pro', 'pro.user_id', '=', 'loc.propietario_id')
        ->join('users AS inq', 'inq.user_id', '=', 'loc.inquilino_id')
        ->select('loc.*', 'sec.name AS sector', 'inq.first_name AS inquilino', 'pro.first_name AS propietario' )
        ->get();
        return response()->json(['status' => 'OK', 'message' => 'Datos cargados', 'data' => $local], 200);
    }

    public function show($local_id){
        $local = Local::where('local_id', '=', $local_id)->first();
        return response()->json(['status' => 'OK', 'message' => 'Datos cargados', 'data' => $local], 200);
    }

    public function showLocalInquilino($inquilino_id){
        $local = Local::where('inquilino_id', '=', $inquilino_id)->get();
        return response()->json(['status' => 'OK', 'message' => 'Datos cargados', 'data' => $local], 200);
    }

    public function showLocalPropietario($propietario_id){
        $local = Local::where('propietario_id', '=', $propietario_id)->get();
        return response()->json(['status' => 'OK', 'message' => 'Datos cargados', 'data' => $local], 200);
    }
    
    public function store(Request $request){

        $name = ( isset($request->name)) ? $request->name : null;
        $description = ( isset($request->description)) ? $request->description : null;
        $status = ( isset($request->status)) ? $request->status : null;
        $sector_id = ( isset($request->sector_id)) ? $request->sector_id : null;
        $inquilino_id = ( isset($request->inquilino_id)) ? $request->inquilino_id : null;
        $propietario_id = ( isset($request->propietario_id)) ? $request->propietario_id : null;


        if( !is_null($description) && !is_null($name) && !is_null($status) && !is_null($sector_id) && !is_null($inquilino_id) && !is_null($propietario_id) ){

            $sector = Sector::where('sector_id', '=', $sector_id)->first();
            $inquilino = User::where('user_id', '=', $inquilino_id)->first();
            $propietario = User::where('user_id', '=', $propietario_id)->first();

            if( !is_null($sector) && !is_null($inquilino) && !is_null($propietario)){
                //crea el local
                $local = new Local();
                $local->name = $name;
                $local->description = $description;
                $local->status = $status;
                $local->sector_id = $sector_id;
                $local->inquilino_id = $inquilino_id;
                $local->propietario_id = $propietario_id;

                $local->save();
                return $data = array('status' => 'OK','code' => 200,'message' => 'Local registrado correctamente'  );     

            }else{
                return $data = array('status' => 'error','code' => 200,'message' => 'Verifique que todos los campos existan'  );    
            }
              
        }else{
            return $data = array('status' => 'error','code' => 400,'message' => 'Local no creado');
        }

    }

    public function update(Request $request, $local_id)
    {
        $sector = Sector::where('sector_id', '=', $request->sector_id)->first();
        $inquilino = User::where('user_id', '=', $request->inquilino_id)->first();
        $propietario = User::where('user_id', '=', $request->propietario_id)->first();

        if( !is_null($sector) && !is_null($inquilino) && !is_null($propietario) ){
            $data = $request->toArray();
            $local = Local::where('local_id', '=', $local_id)->update($data);
            return response()->json(['status' => 'OK', 'message' => 'Datos del local actualizados'], 202);

        }else{
            return $data = array('status' => 'error','code' => 200,'message' => 'Verifique que todos los campos esten registrados'  );    
        }  
      
    }

    public function localFilter( $sector_id ) {

        $locales = Local::
        from('local')
        ->join('sector', 'sector.sector_id', '=', 'local.sector_id')
        ->join('users AS inq', 'inq.user_id', '=', 'local.inquilino_id')
        ->join('users AS pro', 'pro.user_id', '=', 'local.propietario_id')
        ->select('local.*', 'sector.name AS sector', 'inq.first_name AS inquilino', 'pro.first_name AS propietario')
        ->when( $sector_id > 0 , function($sql) use($sector_id){
         return $sql->where('local.sector_id', '=', $sector_id);
        })
         ->get();
        return response()->json(['status' => 'OK', 'message' => 'Datos cargados', 'data' => $locales], 200);

    }


    public function destroy(Request $request, $local_id){
        $local = Local::find($local_id);
        $local->delete();
        return response()->json(['status' => 'OK', 'message' => 'Datos eliminados'], 400);
    }
}
