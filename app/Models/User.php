<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject // Ajout de l'interface JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'utilisateur';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'password',
        'mail',
        'datenaiss',
        'photo',
        'fonction',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'pivot',
        'token'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function taches()
    {
        return $this->belongsToMany(Taches::class, 'taches_user', 'user_id', 'taches_id');
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
