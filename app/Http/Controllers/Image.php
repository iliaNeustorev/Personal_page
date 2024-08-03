<?php

namespace App\Http\Controllers;

use App\Http\Requests\Image\SaveMainImage;
use App\Models\MainInfoTeacher;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class Image extends Controller
{
    /**
     *
     * @param SaveMainImage $request
     * @return JsonResponse
     */
    public function saveImageMain(SaveMainImage $request): JsonResponse
    {
        $data = $request->validated();
        $mainInfo = MainInfoTeacher::findOrfail($data['id']);
        $checkImage = $mainInfo->image;
        if ($checkImage != null) {
            Storage::disk('public')->delete('/img/mainInfo/' . $checkImage->name);
        }
        $file = $data['picture'];
        $ext = $file->extension();
        $fileName = time(). mt_rand(1000, 9999) . '.' . $ext;
        Storage::putFileAs('public/img/mainInfo/', $file, $fileName);
        $mainInfo->image()->updateOrCreate(['imageable_id' => $mainInfo->id, 'imageable_type' => 'main'], ['name' => $fileName, 'url' => '/storage/img/mainInfo/' . $fileName]);
        return response()->json(['success' => true], 200);
    }

    /**
     *
     * @param MainInfoTeacher $mainInfoTeacher
     * @return JsonResponse
     */
    public function deleteImageMain(MainInfoTeacher $mainInfoTeacher): JsonResponse
    {
        $imageName = $mainInfoTeacher->image->name;
        Storage::disk('public')->delete('/img/mainInfo/' . $imageName);
        $mainInfoTeacher->image()->delete();
        return response()->json(['success' => true], 200);
    }
}
