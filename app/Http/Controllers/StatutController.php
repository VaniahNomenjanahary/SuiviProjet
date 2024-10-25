<?php 

namespace App\Http\Controllers;

use App\Models\Statut;
use Illuminate\Http\Request;

class StatutController extends Controller 
{
    public function index()
    {
        $statut = Statut::all();
        return response()->json(['statut' => $statut]);
    }

    public function store(Request $request)
    {
        $statut = new Statut();
        $statut->statut = $request->statut;
        $statut->save();

        return response()->json(['message'=> 'Statut crée avec succès', 'statut' => $statut]);
    }

    public function update(Request $request,$id)
    {
        $statut = Statut::find($id);
        $statut->save();

        return response()->json(['message' => 'Statut modifié', 'statut' => $statut]);
    }

    public function destroy($id)
    {
        $statut = Statut::find($id);
        if (!$statut) {
            return response()->json(['message' => 'Statut introuvable'], 404);
        }
        $statut->delete();

        return response()->json(['message' => 'Statut supprimé']);
    }

    public function show($id) {
        $statut = Statut::find($id);
        if(!$statut) {
            return response()->json(['message' => 'Statut introuvable'], 404);
        }
        return response()->json(['statut' => $statut]);
    }

}


?>