<?php 

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class LoginController extends Controller 
{
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'mail' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $credentials = $request->only('mail', 'password');

        $customClaims = [
            'exp'=> now()->addDay()->timestamp
        ];
        $token = JWTAuth::claims($customClaims)->attempt($credentials);

        try {
            if (!$token) {
                return response()->json(['message' => 'Erreur Authentification'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['message' => 'Erreur lors de la création du token'], 500);
        }

        $utilisateur = User::where('mail', $request->mail)->first();

        return response()->json([
            'message' => 'Connecté avec succès',
            'token' => $token,
            'userID' => $utilisateur->id,
            'user' => $utilisateur
        ], 200);
    }

    public function updateRememberToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mail' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $credentials = $request->only('mail', 'password');

        if (Auth::attempt($credentials)) {
            $utilisateur = Auth::user();
            $user->remember_token = \Str::random(60);
            $utilisateur->save();

            return response()->json([
                'message' => 'Succes',
                'remember_token' => $utilisateur->remember_token,
                'userID' => $utilisateur->id
            ], 200);
        } else {
            return response()->json(['message' => 'Invalide'], 401);
        }
    }
}
?>