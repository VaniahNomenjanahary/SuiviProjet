<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Projet extends Model 
{
    use HasFactory;

    protected $table = 'projet';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'idutilisateur','intitule', 'descriptions', 'datedebut', 'datefin'
    ];

    public function taches(){
        return $this->hasMany(Tache::class);
    }

    public function utilisateur(){
        return $this->belongsToMany(User::class, 'projet_user');
    }
}

?>