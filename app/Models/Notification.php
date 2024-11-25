<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model 
{
    
    use HasFactory;
    protected $table = 'notifications';

    public $timestamps = false;
    protected $fillable = [
        'contenu',
        'id_utilisateur',
        'type',
        'senderID',
        'projet_id'
    ];
}