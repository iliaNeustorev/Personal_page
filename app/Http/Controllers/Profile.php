<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\Image\SaveAvatar as SaveAvatarRequest;
use App\Http\Requests\Profile\Edit as ProfileEditRequest;
use App\Http\Requests\Profile\ChangePassword as ChangePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Profile extends Controller
{
    /**
     *
     * @param ProfileEditRequest $request
     * @return JsonResponse
     */
    public function edit(ProfileEditRequest $request): JsonResponse
    {
        $user = $request->user();
        $data = $request->validated();
        $user->update($data);
        return response()->json(['OK'], 200);
    }

    /**
     *
     * @param ChangePasswordRequest $request
     * @return JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $request->user()->forceFill([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60)
        ])->save();
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        session()->flash('notification', 'password.change');
        return response()->json(['OK'], 200);
    }
    
    /**
     *
     * @param SaveAvatarRequest $request
     * @return JsonResponse
     */
    public function changeAvatar(SaveAvatarRequest $request): JsonResponse
    {
        $user = $request->user();
        $data = $request->validated();
        $currentPictureName = $user->avatar;
        if ($currentPictureName != null) {
            Storage::delete("public/img/avatars/{$currentPictureName->name}");
        }
        $file = $data['picture'];
        $ext = $file->extension();
        $fileName = time(). mt_rand(1000, 9999) . '.' . $ext;
        Storage::putFileAs('public/img/avatars/', $file, $fileName);
        $user->avatar()->updateOrCreate([
            'imageable_id' => $user->id, 
            'imageable_type' => 'avatar'
        ], [
            'name' => $fileName, 
            'url' => '/storage/img/avatars/' . $fileName
        ]);
        return response()->json(['OK'], 200);
    }

    /**
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteAvatar(Request $request): JsonResponse
    {
        $user = $request->user();
        $avatar = $user->avatar;
        if ($avatar == null) {
            return response()->json(['error_text' => 'Аватар не найден'], 204);
        }
        Storage::delete("public/img/avatars/{$avatar->name}");
        $avatar->delete();
        return response()->json(['OK'], 200);
    }

    /**
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $user = User::findOrfail($id);
        $avatar = $user->avatar;
        Storage::delete("public/img/avatars/{$avatar->name}");
        $avatar->delete();
        $user->delete();
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        session()->flash('notification', 'profile.delete');
        return response()->json(['OK'], 200);
    }
}
