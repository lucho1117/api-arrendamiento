<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Response;
use App\Question;

class ResponseController extends Controller
{
    public function index(){
        $response = Response::get();
        return response()->json(['status' => 'OK', 'message' => 'Datos cargados', 'data' => $response], 200);
    }

    public function show( $response_id ){
        $response = Response::where('response_id', '=', $response_id)->first();
        return response()->json(['status' => 'OK', 'message' => 'Datos cargados', 'data' => $response], 200);
    }
    
    public function showByQuestion( $question_id ){
        $response = Response::where('question_id', '=', $question_id)->get();
        return response()->json(['status' => 'OK', 'message' => 'Datos cargados', 'data' => $response], 200);

    }

    public function store(Request $request){

        $question_id = ( isset($request->question_id)) ? $request->question_id : null;
        $subject = ( isset($request->subject)) ? $request->subject : null;
        $message = ( isset($request->message)) ? $request->message : null;
        $file = ( isset($request->file)) ? $request->file : null;
        $status = ( isset($request->status)) ? $request->status : null;

        if( !is_null($subject) && !is_null($question_id) && !is_null($message) && !is_null($status) ){

            $question = Question::where('question_id', '=', $question_id)->first();

            if( !is_null($question) ){
                //crea el response
                $response = new Response();
                $response->question_id = $question_id;
                $response->subject = $subject;
                $response->message = $message;
                $response->file = $file;
                $response->status = $status;

                $response->save();
                return $data = array('status' => 'OK','code' => 200,'message' => 'Respuesta registrada correctamente'  );     

            }else{
                return $data = array('status' => 'error','code' => 200,'message' => 'Solicitud no existen'  );    
            }
              
        }else{
            return $data = array('status' => 'error','code' => 400,'message' => 'Respuesta no creada');
        }

    }

    public function update(Request $request, $response_id)
    {
        $question = Question::where('question_id', '=', $request->question_id)->first();

        if( !is_null($question) ){
            $data = $request->toArray();
            $response = Response::where('response_id', '=', $response_id)->update($data);
            return response()->json(['status' => 'OK', 'message' => 'Datos de respuesta actualizados'], 202);

        }else{
            return $data = array('status' => 'error','code' => 200,'message' => 'Solicitud no existen'  );    
        }  
      
    }

    public function destroy(Request $request, $response_id){
        $response = Response::find($response_id);
        $response->delete();
        return response()->json(['status' => 'OK', 'message' => 'Datos eliminados'], 400);
    }
}
