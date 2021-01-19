<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\User;

class QuestionController extends Controller
{
    public function index(){
        $question = Question::
        from('question AS qu')
        ->join('users AS us', 'us.user_id', '=', 'qu.user_id')
        ->join('rol AS ro', 'ro.rol_id', '=', 'us.rol_id')
        ->select('qu.*', 'us.first_name AS user', 'ro.name AS rol')
        ->get();
        return response()->json(['status' => 'OK', 'message' => 'Datos cargados', 'data' => $question], 200);
    }

    public function show($question_id){
        $question = Question::where('question_id', '=', $question_id)->first();
        return response()->json(['status' => 'OK', 'message' => 'Datos cargados', 'data' => $question], 200);
    }

    public function showByUser($user_id){
        $question = Question::where('user_id', '=', $user_id)->get();
        return response()->json(['status' => 'OK', 'message' => 'Datos cargados', 'data' => $question], 200);
    }
    
    public function store(Request $request){

        $user_id = ( isset($request->user_id)) ? $request->user_id : null;
        $subject = ( isset($request->subject)) ? $request->subject : null;
        $message = ( isset($request->message)) ? $request->message : null;
        $email = ( isset($request->email)) ? $request->email : null;
        $telephone = ( isset($request->telephone)) ? $request->telephone : null;
        $status = ( isset($request->status)) ? $request->status : null;

        if( !is_null($subject) && !is_null($user_id) && !is_null($message) && !is_null($email) && !is_null($status) ){

            $user = User::where('user_id', '=', $user_id)->first();

            if( !is_null($user) ){
                //crea el question
                $question = new Question();
                $question->user_id = $user_id;
                $question->subject = $subject;
                $question->message = $message;
                $question->email = $email;
                $question->telephone = $telephone;
                $question->status = $status;

                $question->save();
                return $data = array('status' => 'OK','code' => 200,'message' => 'Solicitud registrada correctamente'  );     

            }else{
                return $data = array('status' => 'error','code' => 200,'message' => 'Usuario no existen'  );    
            }
              
        }else{
            return $data = array('status' => 'error','code' => 400,'message' => 'Solicitud no creada');
        }

    }

    public function update(Request $request, $question_id)
    {
        $user = User::where('user_id', '=', $request->user_id)->first();

        if( !is_null($user) ){
            $data = $request->toArray();
            $question = Question::where('question_id', '=', $question_id)->update($data);
            return response()->json(['status' => 'OK', 'message' => 'Datos de solicitud actualizados'], 202);

        }else{
            return $data = array('status' => 'error','code' => 200,'message' => 'Usuario no existen'  );    
        }  
      
    }
    
    public function questionFilter( $status, $rol_id){
        $question = Question::
        from('question AS qu')
        ->join('users AS us', 'us.user_id', '=', 'qu.user_id')
        ->join('rol AS ro', 'ro.rol_id', '=', 'us.rol_id')
        ->select('qu.*', 'us.first_name AS user', 'ro.name AS rol')
        ->when( $status < 4 , function($sql) use($status){
         return $sql->where('qu.status', '=', $status);
        })
        ->when($rol_id > 0 , function($sql) use($rol_id){
            return $sql->where('us.rol_id', '=', $rol_id);
        })

        ->get();
        return response()->json(['status' => 'OK', 'message' => 'Datos cargados', 'data' => $question], 200);
    }



    public function destroy(Request $request, $question_id){
        $question = Question::find($question_id);
        $question->delete();
        return response()->json(['status' => 'OK', 'message' => 'Datos eliminados'], 400);
    }


}
