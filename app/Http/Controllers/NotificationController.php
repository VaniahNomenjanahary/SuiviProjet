<?php 

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;



class NotificationController extends Controller 
{
  public function index() {
    $notification = Notification::all();
    $response = [];
    for($i = 0; $i < count($notification); $i++) {
      $utilisateur = User::find($notification[$i]->senderID);
      $notif = new Notification;
      $notif->contenu = $notification[$i]->contenu;
      $notif->id_utilisateur = $notification[$i]->id_utilisateur;
      $notif->type = $notification[$i]->type;
      $notif->sender = $utilisateur->nom;
      array_push($response, $notif);
    }
    return response()->json(['notification' => $response]);
  }

  public function store(Request $request) {
    $validator = Validator::make($request->all(), [
      'contenu' => 'required',
    ]);
    
    if ($validator->fails()){
      return response()->json(['errors' => $validator->errors()], 403);
    }

    $notification = new Notification();
    $notification->contenu = $request->input('contenu');
    $notification->id_utilisateur = $request->input('id_utilisateur');
    $notification->type = $request->input('type');
    $notification->senderID = $request->input('senderID');
    $notification->projet_id = $request->input('projet_id');
    $notification->save();

    return response()->json(['notification'=> $notification], 201);
  }

  public function destroy($id) {
    $notification = Notification::find($id);
    $notification->delete();

    return response()->json(['message' => 'notification succefuly deleted'], 204);
  }

}

?>