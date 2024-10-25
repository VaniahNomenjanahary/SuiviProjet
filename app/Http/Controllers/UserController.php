<?php 

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller 
{
    public function index(){
        $utilisateur = User::all();
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

            return response()->json(['message'=> 'Utilisateur crée avec succes'], 201);
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

    public function show($id){
        return User::find($id);
    }

    public function update(Request $request, $id){
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

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'exists:utilisateur,id',
        ]);

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try {
            DB::beginTransaction();

            foreach($request->input('ids') as $id) {
                $utilisateur = User::find($id);
                $utilisateur->delete();
            }
            DB::commit();
            return response()->json(['message' => 'Utilisateur supprimé avec succès']);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());

            return response()->json(['message' => 'Erreur de suppression. Erreur: ' . $e->getMessage()], 500);
        }
    }

    public function associeruser($iduser, $idtache)
    {
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