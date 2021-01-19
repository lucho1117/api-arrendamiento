<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\JwtAuth;
use App\Http\Requests;
use Illuminate\support\Facades\DB;
use App\User;

class UserController extends Controller
{
    public function register(Request $request){
      
        $dpi = ( isset($request->dpi)) ? $request->dpi : null;
        $email = ( isset($request->email)) ? $request->email : null;
        $first_name = ( isset($request->first_name)) ? $request->first_name : null;
        $second_name = ( isset($request->second_name)) ? $request->second_name : null;
        $address = ( isset($request->address)) ? $request->address : null;
        $birth_date = ( isset($request->birth_date)) ? $request->birth_date : null;
        $telephone = ( isset($request->telephone)) ? $request->telephone : null;
        $status = ( isset($request->status)) ? $request->status : null;
        $rol_id = ( isset($request->rol_id)) ? $request->rol_id : null;
        $password = ( isset($request->password)) ? $request->password : null;


        if( !is_null($dpi) && !is_null($email) && !is_null($first_name) && !is_null($second_name) && !is_null($password) && !is_null($rol_id) ){
            //crea el usuario
            $user = new User();

            $user->dpi = $dpi;
            $user->email = $email;
            $user->first_name = $first_name;
            $user->second_name = $second_name;
            $user->address = $address;
            $user->birth_date = $birth_date;
            $user->telephone = $telephone;
            $user->status = $status;
            $user->rol_id = $rol_id;

            $pwq = hash('sha256', $password);
            $user->password = $pwq;
   
            
            //comprobar si hay un usuario duplicado
           $isset_user = User::where('email','=', $email)->first();

            if( is_null($isset_user) ){
                //Guardar el usuario
                $user->save();

                return $data = array(
                    'status' => 'OK',
                    'code' => 200,
                    'message' => 'Usuario registrado correctamente'
                );

            }else{
                //No guardarlo por que ya existe
                return $data = array(
                    'status' => 'ERROR',
                    'code' => 400,
                    'message' => 'Usuario duplicado, no puede registrarse'
                );

            }
        }else{

            return $data = array(
                'status' => 'ERROR',
                'code' => 400,
                'message' => 'Usuario no creado'
            );

        }

    }

    

    public function login(Request $request){
       
        $email = ( isset($request->email)) ? $request->email : null;
        $password = ( isset($request->password)) ? $request->password : null;
        //cigrar la password
        $pwd = hash('sha256', $password);

        if( !is_null($email) && !is_null($password) ){
           
           $user = User::where('email', '=', $request['email'])->where('password', '=', $pwd)->first();
          
            if( !is_null($user) ){
                return response()->json(['status' => 'OK', 'message' => 'Bienvenido al sistema', 'data' => $user], 200);
            }else{   
                return response()->json(['status' => 'ERROR', 'code' => 400, 'message' => 'Email y password invalidos']);
            }
         
        }else{
            return response()->json(['status' => 'ERROR', 'code' => 400, 'message' => 'Faltan campos']);
        }
    }



    public function index(){
        $users = User::
        from('users AS us')
        ->join('rol AS ro', 'ro.rol_id', '=', 'us.rol_id')
        ->select('us.*', 'ro.name AS rol')
        ->get();
        return response()->json(['status' => 'OK', 'message' => 'Datos cargados', 'data' => $users], 200);
    }



    public function show($user_id){
        $rol = User::where('user_id', '=', $user_id)->first();
        return response()->json(['status' => 'OK', 'message' => 'Datos cargados', 'data' => $rol], 200);
    }

     public function showUserByRol($rol_id){
        $rol = User::
        from('users AS us')
        ->join('rol AS ro', 'ro.rol_id', '=', 'us.rol_id')
        ->select('us.*', 'ro.name AS rol')
        ->when( $rol_id > 0 , function($sql) use($rol_id){
         return $sql->where('us.rol_id', '=', $rol_id);
        })
        ->get();
        return response()->json(['status' => 'OK', 'message' => 'Datos cargados', 'data' => $rol], 200);
    }

    public function update(Request $request, $user_id)
    {
        $data = $request->toArray();
        $rol = User::where('user_id', '=', $user_id)->update($data);
        return response()->json(['status' => 'OK', 'message' => 'Datos actualizados'], 202);
      
    }

    public function updatePassword( Request $request, $user_id ) {
        $new_password = hash('sha256', $request->new_password );
        $old_password = hash('sha256', $request->old_password ); 

        $oldPasswordExist = User::where( 'user_id', '=', $user_id )->where('password', '=', $old_password )->first();

        if( !is_null($oldPasswordExist)) {
              $user = User::where('user_id', '=', $user_id)->update(['password' =>  $new_password ]);
              return response()->json(['status' => 'OK', 'message' => 'Contraseña actualizada'], 202);
        } else {
              return response()->json(['status' => 'ERROR', 'message' => 'Actual contraseña incorrecta'], 500);
        }
      
    }

    public function destroy($user_id){
        $user = User::find($user_id);
        $user->delete();
        return response()->json(['status' => 'OK', 'message' => 'Datos eliminados'], 400);
    }
}
