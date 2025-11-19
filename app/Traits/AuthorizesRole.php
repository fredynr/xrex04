<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait AuthorizesRole
{
    public function authorizeRole(array $allowedRoles)
    {
        $user = Auth::user();

        if (!$user || !in_array($user->role, $allowedRoles)) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }
    }
}
