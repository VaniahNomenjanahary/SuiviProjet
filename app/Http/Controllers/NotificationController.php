<?php 

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class NotificationController extends Controller 
{
  public function index() {
    $notification = Notification::all();
    return response()->json(['notification' => $notification]);
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