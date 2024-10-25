<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyAssignment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        $tacheId = $request->route('id');

        \Log::info('Utilisateur Authentifié', ['user_id' => $user->id, 'taches_id' => $tacheId]);

        if ($tacheId) {
            if ($tacheId && !$user->taches()->where('id', $tacheId)->exists()) {
                return response()->json(['message' => 'Accès non autorisé'], 403);
            }
        }
        return $next($request);
    }
}
