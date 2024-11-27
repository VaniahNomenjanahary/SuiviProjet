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
        $id = $payload['id'];

        $projet = Projet::with([
            'utilisateur',
            'taches.statut',
            'taches.utilisateurs'
        ])
            ->where(function ($query) use ($id) {
                $query->where('idutilisateur', $id)
                      ->orWhereHas('utilisateur', function ($subQuery) use ($id) {
                          $subQuery->where('id', $id);
                      });
            })
            ->get();
        
        return response()->json([
            'projet'=>$projet,
        ], 200);
    }

    public function store(Request $request)
    {
        $projet = new Projet();
        $projet->idutilisateur = $request->idutilisateur;
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

    public function invitation($userid, $projetid) {
        
        $projet = Projet::find($projetid);
        $projet->utilisateur()->attach($userid);

        return response()->json(['message'=> "invitation accepted"], 202);
    }
  
}


?>