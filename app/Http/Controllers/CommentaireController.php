<?php 

namespace App\Http\Controllers; 

use Illuminate\Http\Request;
use App\Models\Commentaire;
use Carbon\Carbon;

class CommentaireController extends Controller{

    public function index(){
        $commentaire = Commentaire::with('tache', 'utilisateur')->get();
        return response()->json(['commentaire' => $commentaire]);
    }

    public function store(Request $request){
        $commentaire = new Commentaire();
        $commentaire->idtache = $request->idtache;
        $commentaire->idutilisateur = $request->idutilisateur;
        $commentaire->contenu = $request->contenu;
        $commentaire->created_at = Carbon::now();
        $commentaire->save();

        return response()->json(['message' => 'Commentaire', 'commentaire'=> $commentaire]);
    }

    public function update(Request $request, $id) {
        $commentaire = Commentaire::find($id);
        $commentaire->contenu = $request->contenu;
        $commentaire->updated_at = Carbon::now();
        $commentaire->save();

        return response()->json(['message' => 'Commentaire modifié', 'commentaire' => $commentaire]);
    }

    public function destroy($id)
    {
        $commentaire = Commentaire::find($id);
        if(!$commentaire) {
            return response()->json(['message' => 'Commentaire Introuvable'], 404);
        }
        $commentaire->delete();

        return response()->json(['message' => 'Commentaire supprimé']);
    }

    public function show($id)
    {
        $commentaire = Commentaire::find($id);
        if(!$commentaire) {
            return response()->json(['message' => 'Commentaire introuvable'], 404);
        }
        return response()->json(['commentaire' => $commentaire]);
    }
}
?>