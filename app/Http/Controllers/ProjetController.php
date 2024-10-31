<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Projet;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProjetController extends Controller 
{
    public function index(Request $request)
    {
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json(['errors' => 'invalid token'], 401);
        }
        $token = str_replace('Bearer ', '', $token);
        $payload = JWTAuth::setToken($token)->getPayload();
        $role = $payload['role'];
        $fonc= $payload['fonction'];
        if($role != 'admin') {
            return response()->json(['errors' => 'user unhautorizedd'()], 403);
        }

        $projet = Projet::all();
        return response()->json(['projet'=>$projet]);
    }

    public function store(Request $request)
    {
        $projet = new Projet();
        $pprojet->idutilisateur = $request->idutilisateur;
        $projet->intitule = $request->intitule;
        $projet->descriptions = $request->descriptions;
        $projet->datedebut = $request->datedebut;
        $projet->datefin = $request->datefin;
        $projet->created_at = Carbon::now();
        $projet->save();

        return response()->json(['message' => 'Projet crée avec succès', 'projet'=>$projet]);
    }
    
    public function update(Request $request, $id)
    {
        $projet = Projet::find($id);
        $projet->update_at = Carbon::now();
        $projet->save();

        return response()->json(['message'=>'Projet modifié', 'projet'=> $projet]);
    }

    public function destroy($id){
        $projet = Projet::find($id);
        if(!$projet) {
            return response()->json(['message'=>'Projet not found'], 404);
        } 
        $projet->delete();
        return response()->json(['message'=>'Projet supprimé']);
    }


    public function show($id)
    {
        $projet = Projet::find($id);
        if (!$projet) {
            return response()->json(['message' => 'Projet not found'], 404);
        }
        return response()->json(['projet' => $projet]);
    }

   
  
}


?>