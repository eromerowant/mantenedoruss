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
}
