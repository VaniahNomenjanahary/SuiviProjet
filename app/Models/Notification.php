<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model 
{
    
    use HasFactory;
    protected $table = 'notifications';

    protected $fillable = [
        'contenu',
        'id_utilisateur',
        'type'
    ];
}