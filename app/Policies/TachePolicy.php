<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TachePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
  /*  public function __construct()
    {
        //
    }*/
    public function view(User $user, Tache $tache)
    {
        return $user->taches()->where('taches_id', $tache->id)->exists();
    }
}
