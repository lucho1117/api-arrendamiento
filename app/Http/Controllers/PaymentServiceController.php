<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PaymentService;
use App\LocalService;
use App\CardType;

class PaymentServiceController extends Controller
{
    public function index(){
        $payment_service = PaymentService::get();
        return response()->json(['status' => 'OK', 'message' => 'Datos cargados', 'data' => $payment_service], 200);
    }

    public function show($payment_service_id){
        $payment_service = PaymentService::where('payment_service_id', '=', $payment_service_id)->first();
        return response()->json(['status' => 'OK', 'message' => 'Datos cargados', 'data' => $payment_service], 200);
    }
    
    public function store(Request $request){
       
        $card_number = ( isset($request->card_number)) ? $request->card_number : null;
        $expiration = ( isset($request->expiration)) ? $request->expiration : null;
        $postal_code = ( isset($request->postal_code)) ? $request->postal_code : null;
        $local_service_id = ( isset($request->local_service_id)) ? $request->local_service_id : null;
        $card_type_id = ( isset($request->card_type_id)) ? $request->card_type_id : null;

        if( !is_null($card_number) && !is_null($local_service_id) && !is_null($card_type_id) ){

            $local_service = LocalService::where('local_service_id', '=', $local_service_id)->first();
            $card_type = CardType::where('card_type_id', '=', $card_type_id)->first();

            if( !is_null($local_service) && !is_null($card_type)){
                //crea el payment_service
                $payment_service = new PaymentService();
                $payment_service->card_number = $card_number;
                $payment_service->expiration = $expiration;
                $payment_service->postal_code = $postal_code;
                $payment_service->local_service_id = $local_service_id;
                $payment_service->card_type_id = $card_type_id;

                $payment_service->save();
                return $data = array('status' => 'sucess','code' => 200,'message' => 'Transacción exitosa!'  );     

            }else{
                return $data = array('status' => 'error','code' => 200,'message' => 'Verifique que todos los campos existan'  );    
            }
              
        }else{
            return $data = array('status' => 'error','code' => 400,'message' => 'Error en la transacción');
        }

    }

    public function update(Request $request, $payment_service_id)
    {
        $local_service = LocalService::where('local_service_id', '=', $request->local_service_id)->first();
        $card_type = CardType::where('card_type_id', '=', $request->card_type_id)->first();

        if( !is_null($local_service) && !is_null($card_type)){
            $data = $request->toArray();
            $payment_service = PaymentService::where('payment_service_id', '=', $payment_service_id)->update($data);
            return response()->json(['status' => 'OK', 'message' => 'Datos actualizados'], 202);

        }else{
            return $data = array('status' => 'error','code' => 200,'message' => 'Verifique que todos los campos existan'  );    
        }  
      
    }

    public function destroy(Request $request, $payment_service_id){
        $payment_service = PaymentService::find($payment_service_id);
        $payment_service->delete();
        return response()->json(['status' => 'OK', 'message' => 'Datos eliminados'], 400);
    }
}
