<?php

namespace App\Http\Controllers;

use App\Http\Requests\MainInfoCreate;
use App\Http\Requests\MainInfoEdit;
use App\Models\MainInfoTeacher;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class Main extends Controller
{
    /**
     * Сформировать главный view spa.
     *
     * @param Request $request
     * @return View
     */
    public function showSpa(Request $request): View
    {
        $user = $request->user()?->load('roles', 'avatar');
        $img = $user?->avatar?->url;
        $roles = $user?->roles?->pluck('name')->toArray();
        $user = $user?->toArray();
        $filtredUser = [
            'id' => $user['id'] ?? null,
            'first_name' => $user['first_name'] ?? null,
            'email_verified_at' => $user['email_verified_at'] ?? null,
            'img' => $img,
            'roles' => $roles
        ];
        $routes = [ 
            'auth' => '/auth/login', 
            'logout' => '/auth/logout', 
            'register' => '/auth/register',
            'verifyEMail' => '/email/verification-notification'
        ];
        $context = ['user' => $filtredUser, 'routes' => $routes];
        return view('spa', compact('context'));
    }
    
    /**
     * Получить активную анкету.
     *
     * @return JsonResponse
     */
    public function getMainInfo(): JsonResponse
    {
        $info = MainInfoTeacher::with(['image:id,imageable_id,imageable_type,url'])
            ->where('active', true)
            ->first();
        return ($info !== null) ? response()->json(['info' => $info->toArray()], 200) : response()->json(['info' => []], 404);
    }

    /**
     * Создать новую анкету.
     *
     * @param MainInfoCreate $request
     * @return JsonResponse
     */
    public function createMainInfo(MainInfoCreate $request): JsonResponse
    {
        $data = $request->validated();
        $user = $request->user();
        $active = MainInfoTeacher::count() === 0;
        MainInfoTeacher::create($data + ['user_id' => $user->id, 'active' => $active]);
        return response()->json(['success' => true], 200);
    }

    /**
     * Обновить анкету.
     *
     * @param MainInfoEdit $request
     * @param MainInfoTeacher $mainInfo
     * @return JsonResponse
     */
    public function updateMainInfo(MainInfoEdit $request, MainInfoTeacher $mainInfo): JsonResponse
    {
        $data = $request->validated();
        $mainInfo->update($data);
        return response()->json(['success' => true], 200);
    }

    /**
     * Получить все анкеты.
     *
     * @return JsonResponse
     */
    public function allInfo(): JsonResponse
    {
        return response()->json(['data' => MainInfoTeacher::get()->toArray()], 200);
    }

    /**
     * Изменить активную анкету.
     *
     * @param Request $request
     * @param MainInfoTeacher $mainInfoTeacher
     * @return JsonResponse
     */
    public function changeActive(Request $request, MainInfoTeacher $mainInfoTeacher): JsonResponse
    {
        $data = $request->all();
        if ($data['check']) {
           MainInfoTeacher::whereNot('id', $mainInfoTeacher->id)->update(['active' => false]);
        }
        $mainInfoTeacher->update(['active' => $data['check']]);
        return response()->json(['success' => true], 200);
    }

    /**
     * Удалить анкету.
     *
     * @param MainInfoTeacher $mainInfoTeacher
     * @return JsonResponse
     */
    public function deleteMainInfo(MainInfoTeacher $mainInfoTeacher): JsonResponse
    {
        $mainInfoTeacher->delete();
        return response()->json(['success' => true], 200);
    }

    /**
     * Получить анкету.
     *
     * @param MainInfoTeacher $mainInfoTeacher
     * @return JsonResponse
     */
    public function oneInfo(MainInfoTeacher $mainInfoTeacher): JsonResponse
    {
        $mainInfoTeacher = $mainInfoTeacher->load(['image:id,imageable_id,imageable_type,url'])->toArray();
        return response()->json(['success' => true, 'data' => $mainInfoTeacher], 200);
    }

    /**
     * Test route for dev.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function test(Request $request): JsonResponse
    {
        return response()->json(['OK'], 200);
    }
}
