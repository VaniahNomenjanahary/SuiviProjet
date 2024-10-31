<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;

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
        return $this->belongsTo(User::class, 'idutilisateur');
    }

    /**
     * Retourne l'identifiant JWT de l'utilisateur.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey(); // Cela retourne l'identifiant de l'utilisateur
    }

    /**
     * Retourne les revendications personnalisées du JWT.
     *
     * @param array $extraClaims
     * @return array
     */
    public function getJWTCustomClaims(array $extraClaims = [])
    {
        return [
            'role' => $this->role,
            'id' => $this->id,
            'fonction' => $this->fonction,
        ]; // Vous pouvez ajouter des revendications personnalisées ici si nécessaire
    }
}

?>