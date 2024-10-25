<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Taches extends Model 
{
    use SoftDeletes;

    protected $table= 'taches';

    protected $dates = ['deleted_at'];

    protected $fillable = [
    'idprojet',
    'tache',
    'datedebut',
    'datefin',
    'idstatut',
    'descriptions',
    'priorite',
    'attente'
    ];

    public function projet(){
        return $this->belongsTo(Projet::class, 'idprojet');
    }

    public function statut(){
        return $this->belongsTo(Statut::class, 'idstatut');
    }

    public function utilisateurs(){
        return $this->belongsToMany(User::class, 'taches_user');
    }
}