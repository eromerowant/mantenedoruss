<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\User;
use Mail;

class UserController extends Controller
{
    public function index( Request $request )
    {
        $validator = Validator::make($request->all(), [
            'paginate' => 'nullable|integer|gte:1' // greater than or equal to 1.
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $campos = ['id', 'nombre', 'cargo', 'email'];
        $peticion = User::select($campos);

        // Con o sin paginación
        if ( $request->get('paginate') ) {
            $response = $peticion->paginate( $request->get('paginate') )->toArray();
        } else {
            $response['data'] = $peticion->get();
        }

        return response()->json($response);
    }

    public function store( Request $request )
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'cargo'  => 'required|string',
            'email'  => 'required|email|unique:users,email',
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }
        $user = new User();
        $user->nombre = $request->nombre;
        $user->cargo = $request->cargo;
        $user->email = $request->email;
        $user->password = Hash::make( Str::random(10) );
        $user->save();

        $response['data'] = $user;

        return response()->json($response);

    }

    public function show( Request $request )
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists_soft:users,id',
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $response['data'] = User::where('id', $request->get('user_id'))->first();

        return response()->json($response);
    }

    public function update( Request $request )
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists_soft:users,id',
            'nombre'  => 'nullable|string',
            'cargo'   => 'nullable|string',
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $user = User::where('id', $request->get('user_id'))->first();
        if ( $request->get('nombre') ) {
            $user->nombre = $request->get('nombre');
        }
        if ( $request->get('cargo') ) {
            $user->cargo = $request->get('cargo');
        }
        $user->update();

        $response['data'] = $user;
        return response()->json($response);
    }

    public function delete( Request $request )
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists_soft:users,id',
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $user = User::where('id', $request->get('user_id'))->first();
        $user->delete();

        return response()->json([
            'message' => "El usuario con id: ".$request->get('user_id')." fue borrado exitosamente.",
        ]);
    }

    public function recover_password( Request $request )
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists_soft:users,email',
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }
        $new_password = Str::random(10);

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make( $new_password );
        $user->update();

        $email_enviado = $this->send_email_with_new_password( $new_password, $user );
        if ( !$email_enviado ) {
            return response()->json([
                'status' => 'error',
                'message' => 'El email no pudo ser enviado al usuario'
            ], 500);
        }

        return response()->json([
            'status' => 'ok',
            'message' => "Se ha enviado un email con una nueva contraseña.",
        ]);

    }

    public function send_email_with_new_password( $new_password, $destinatario )
    {
        $email_enviado = false;
        if ( $new_password && $destinatario ) {
            $email   = $destinatario->email;
            $name    = $destinatario->nombre;
            $subject = "Recuperación de Contraseña";

            Mail::send('email_templates.recover_password', ['new_password' => $new_password, "destinatario" => $destinatario],
                function($mail) use ($email, $name, $subject){
                    $mail->from( 'mantenedor@uss.com', 'mantenedor_uss' );
                    $mail->to($email, $name);
                    $mail->subject($subject);
            });
            $email_enviado = true;
        }
        return $email_enviado;
    }

    public function change_user_status( Request $request )
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists_soft:users,id',
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
            ], 400);
        }

        $user = User::where('id', $request->get('user_id'))->first();
        
        if ( $user->status === 1 ) { 
            $user->status = 2; // Deshabilitar
            $message = "El usuario con id: ".$request->get('user_id')." fue DESHABILITADO.";
        } else {
            $user->status = 1; // Habilitar
            $message = "El usuario con id: ".$request->get('user_id')." fue HABILITADO.";
        }
        $user->update();

        return response()->json([
            'message' => $message,
        ]);
    }
}
