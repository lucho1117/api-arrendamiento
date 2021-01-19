<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sector;

class SectorController extends Controller
{
    public function index(){
        $sectors = Sector::get();
        return response()->json(['status' => 'OK', 'message' => 'Datos cargados', 'data' => $sectors], 200);
    }

    public function show($sector_id){
        $sector = Sector::where('sector_id', '=', $sector_id)->first();
        return response()->json(['status' => 'OK', 'message' => 'Datos cargados', 'data' => $sector], 200);
    }
    
    public function store(Request $request){

        $name = ( isset($request->name)) ? $request->name : null;
        $description = ( isset($request->description)) ? $request->description : null;
        $status = ( isset($request->status)) ? $request->status : null;

        if( !is_null($name) && !is_null($description) && !is_null($status) ){
            //crea el sector
            $sector = new Sector();
            $sector->name = $name;
            $sector->description = $description;
            $sector->status = $status;

            $sector->save();
            return $data = array('status' => 'OK','code' => 200,'message' => 'Sector registrado correctamente'  );       
     
        }else{
            $data = array('status' => 'error','code' => 400,'message' => 'Sector no creado');
        }

    }

    public function update(Request $request, $sector_id)
    {
        $data = $request->toArray();
        $sector = Sector::where('sector_id', '=', $sector_id)->update($data);
        return response()->json(['status' => 'OK', 'message' => 'Datos actualizados'], 202);
      
    }

    public function destroy(Request $request, $sector_id){
        $sector = Sector::find($sector_id);
        $sector->delete();
        return response()->json(['status' => 'OK', 'message' => 'Datos eliminados'], 400);
    }
}
