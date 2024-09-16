<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\ChangedRole;
use App\Models\Role as ModelsRole;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class Role extends Controller
{
    /**
     *
     * @param ChangedRole $request
     * @param User $user
     * @return JsonResponse
     */
    public function updateRole(ChangedRole $request, User $user): JsonResponse
    {
        $user->roles()->sync($request['roles']);
        return response()->json(['OK'], 200);
    }

    /**
     *
     * @param User $user
     * @return JsonResponse
     */
    public function getRoles(User $user): JsonResponse
    {
        $AllRoles = ModelsRole::get()->toArray();
        $userRoles = $user->roles->pluck('id');
        return response()->json(compact('userRoles', 'AllRoles'), 200);
    }
}
