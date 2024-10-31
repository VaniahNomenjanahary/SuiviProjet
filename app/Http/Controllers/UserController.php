<?php 

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;


class UserController extends Controller 
{
    public function index(Request $request){
        $utilisateur = User::all();
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json(['errors' => 'invalid token'], 401);
        }
        $token = str_replace('Bearer ', '', $token);
        $payload = JWTAuth::setToken($token)->getPayload();
        $role = $payload['role'];
        if($role != 'admin') {
            return response()->json(['errors' => 'user unhautorized'], 403);
        }

        return response()->json(['user' => $utilisateur]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required',
            'prenom' => 'required',
            'password' => 'required',
            'mail' => 'required|email|unique:utilisateur',
            'datenaiss' => 'required',
            'photo' => 'nullable|image',
            'fonction' => 'required',
            'role' => 'required',
        ]);
        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 404);
        }

        try{
            $imageName = null;
            if ($request->hasFile('photo')) {
                $imageName = Str::random().'.'.$request->photo->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('utilisateur/image', $request->photo, $imageName);
            }

            $utilisateur = new User();
            $utilisateur->nom = $request->input('nom');
            $utilisateur->prenom = $request->input('prenom');
            $utilisateur->password = bcrypt($request->input('password'));
            $utilisateur->mail = $request->input('mail');
            $utilisateur->datenaiss = $request->input('datenaiss');
            $utilisateur->photo = $imageName;
            $utilisateur->fonction = $request->input('fonction');
            $utilisateur->role = $request->input('role');
            $utilisateur->save();
            $token = JWTAuth::fromUser($utilisateur);

            return response()->json(['user'=> $utilisateur, 'token' => $token], 201);
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1]; 
            if ($errorCode == 1062) {
                return response()->json(['message' => 'Cet utilisateur existe déjà'], 400);
            } elseif ($errorCode == 1452) {
                return response()->json(['message' => 'Données invalides'], 400);
            } else {
                return response()->json(['message' => 'Une erreur SQL est survenue. Error: ' . $e->getMessage()], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Une erreur est survenue. Error: ' . $e->getMessage()], 500);
        }
    }

    public function show(Request $request, $id){
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json(['errors' => 'invalid token'], 401);
        }
        $token = str_replace('Bearer ', '', $token);
        $payload = JWTAuth::setToken($token)->getPayload();
        $role = $payload['role'];
        $user_id = $payload['id'];
        if($role != 'admin') {
            if($id != $user_id) {
                return response()->json(['errors' => 'user unhautorizedd'()], 403);
            }
        }

        return User::find($id);
    }

    public function update(Request $request, $id){
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json(['errors' => 'invalid token'], 401);
        }
        $token = str_replace('Bearer ', '', $token);
        $payload = JWTAuth::setToken($token)->getPayload();
        $role = $payload['role'];
        $user_id = $payload['id'];

        if($role != 'admin') {
            if($id != $user_id) {
                return response()->json(['errors' => 'unauthorized'], 403);
            }
        }

        $utilisateur = User::find($id);
        $utilisateur->nom = $request->input('nom');
        $utilisateur->prenom = $request->input('prenom');
        $utilisateur->password = bcrypt($request->input('password'));
        $utilisateur->mail = $request->input('mail');
        $utilisateur->datenaiss = $request->input('datenaiss');
        $utilisateur->photo = $imageName;
        $utilisateur->fonction = $request->input('fonction');
        $utilisateur->role = $request->input('role');

        if($request->hasFile('photo')){
            if($utilisateur->photo) {
                Storage::disk('public')->delete("utilisateur/image/{$utilisateur->photo}");
            }

            $nouvphoto = Str::random() . '.' . $request->photo->getClientOriginalExtension();
            $request->photo->storeAs('utilisateur/image', $nouvphoto, 'public');
            $utilisateur->photo = $nouvphoto;
        }
        $utilisateur->save(); 

        return response()->json(['message' => 'Utilisateur modifié'], 200);

    }

    public function destroy(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'confirmPass' => 'required',
        ]);

        $password = $request->input('password');
        $confirm = $request->input('confirmPass');

        if($validator->fails() || $password != $confirm) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json(['errors' => 'invalid token'], 401);
        }
        $token = str_replace('Bearer ', '', $token);
        $payload = JWTAuth::setToken($token)->getPayload();
        $role = $payload['role'];
        $user_id = $payload['id'];

        if($role != 'admin') {
            if($id != $user_id) {
                return response()->json(['errors' => 'unauthorized'], 401);
            }
        }

        try {
            // DB::beginTransaction();
            $utilisateur = User::find($id);
            $utilisateur->delete();
            // foreach($request->input('ids') as $id) {
            // }
            // DB::commit();
            
            return response()->json(['message' => 'Utilisateur supprimé avec succès']);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());

            return response()->json(['message' => 'Erreur de suppression. Erreur: ' . $e->getMessage()], 500);
        }
    }

    public function associeruser($iduser, $idtache, Request $request)
    {
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json(['errors' => 'invalid token'], 401);
        }
        $token = str_replace('Bearer ', '', $token);
        $payload = JWTAuth::setToken($token)->getPayload();
        $role = $payload['role'];
        $user_id = $payload['id'];

        if($role != 'admin') {
            if($iduser != $user_id) {
                return response()->json(['errors' => 'unauthorized'], 403);
            }
        }

        $utilisateur = User::find($iduser);
        $utilisateur->taches()->attach($idtache);

        return response()->json(['message'=> 'Tache affecté'], 201);
    }

    public function detacheruser($iduser, $idtache)
    {
        $utilisateur = User::find($iduser);
        $utilisateur->taches()->detach($idtache);

        return response()->json(['message'=> 'Tache détaché'], 201);
    }
}

?>