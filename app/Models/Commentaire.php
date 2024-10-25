<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commentaire extends Model 
{
    protected $table= 'commentaire';

    protected $fillable = [
        'idtache',
        'idutilisateur', 
        'contenu'];

    public function tache(){
        return $this->belongsTo(Taches::class, 'idtache');
    }

    public function utilisateur(){
        return $this->belongsTo(User::class, 'idutilisateur');
    }
}
?>