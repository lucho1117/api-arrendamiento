<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CardType;

class CardTypeController extends Controller
{
    public function index(){
        $card_type = CardType::get();
        return response()->json(['status' => 'OK', 'message' => 'Datos cargados', 'data' => $card_type], 200);
    }

    public function show($card_type_id){
        $card_type = CardType::where('card_type_id', '=', $card_type_id)->first();
        return response()->json(['status' => 'OK', 'message' => 'Datos cargados', 'data' => $card_type], 200);
    }
    
    public function store(Request $request){

        $name = ( isset($request->name)) ? $request->name : null;
        $description = ( isset($request->description)) ? $request->description : null;
        $status = ( isset($request->status)) ? $request->status : null;

        if( !is_null($name) && !is_null($description) && !is_null($status) ){
            //crea el card$card_type
            $card_type = new CardType();
            $card_type->name = $name;
            $card_type->description = $description;
            $card_type->status = $status;

            $card_type->save();
            return $data = array('status' => 'OK','code' => 200,'message' => 'Tipo de tarjeta registrada correctamente'  );       
     
        }else{
            $data = array('status' => 'error','code' => 400,'message' => 'Tipo de tarjeta no creado');
        }

    }

    public function update(Request $request, $card_type_id)
    {
        $data = $request->toArray();
        $card_type = CardType::where('card_type_id', '=', $card_type_id)->update($data);
        return response()->json(['status' => 'OK', 'message' => 'Datos de tipo de tarjeta actualizados'], 202);
      
    }

    public function destroy(Request $request, $card_type_id){
        $card_type = CardType::find($card_type_id);
        $card_type->delete();
        return response()->json(['status' => 'OK', 'message' => 'Datos eliminados'], 400);
    }
}
