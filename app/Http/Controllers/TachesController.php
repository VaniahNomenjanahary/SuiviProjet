<?php 

namespace App\Http\Controllers; 

use Illuminate\Http\Request;
use App\Models\Taches;
use Carbon\Carbon;

class TachesController extends Controller 
{
    public function index(){
        $taches = Taches::with('projet', 'statut')->get();
       /* $tachesAutorisees = $taches->filter(function ($tache) {
            return $this->authorize('view', $tache);
        });*/
        return response()->json(['taches' => $taches]);
    }

    public function store(Request $request)
    {
        $tache = new Taches();
        $tache->idprojet = $request->idprojet;
        $tache->tache = $request->tache;
        $tache->datedebut = $request->datedebut;
        $tache->datefin = $request->datefin;
        $tache->idstatut = $request->idstatut;
        $tache->descriptions = $request->descriptions;
        $tache->priorite = $request->priorite;
        $tache->created_at = Carbon::now();
        $tache->save();

        return response()->json(['message' => 'Tache crée avec succès', 'tache'=>$tache]);
    }
    
    public function update(Request $request, $id)
    {
        $tache = Taches::find($id);
        $tache->idstatut = $request->idstatut;
        $tache->updated_at = Carbon::now();
        $tache->save();

        return response()->json(['message' => 'Tache modifié avec succès', 'tache' => $tache]);
    }

    public function destroy($id)
    {
        $tache = Taches::find($id);
        if(!$tache) {
            return response()->json(['message' => 'Tache Introuvable'], 404);
        }
        $tache->attente = true;
        $tache->save();

        return response()->json(['message' => 'Suppression en attente']);
    }

    public function validationdelete($id){
        $tache = Taches::withTrashed()->find($id);
        if(!$tache) {
            return response()->json(['message' => 'Tache introuvable']);
        }

        if($tache->attente) {
            $tache->forceDelete();

            return response()->json(['message' => 'Tache supprimé']);
        }

        return response()->json(['message' => 'Cette tache ne peut pas etre supprimé'], 400);
    }

    public function restaurerdelete($id){
        $tache = Taches::withTrashed()->find($id);
        if(!$tache) {
            return response()->json(['message' => 'Tache introuvable']);
        }

        if($tache->attente) {
            $tache->restore();

            return response()->json(['message' => 'Tache supprimé']);
        }
    }

    public function show($id)
    {
        $tache = Taches::find($id);
        if(!$tache)
        {
            \Log::info('Tâche non trouvée', ['tache_id' => $id]);
            return response()->json(['message' => 'Tache non trouvé'], 404);
        }       
        return response()->json($tache);
    }

    
}

?>