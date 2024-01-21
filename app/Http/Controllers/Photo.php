<?php

namespace App\Http\Controllers;

use App\Http\Requests\Image\SavePhoto;
use App\Models\Photo as ModelsPhoto;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class Photo extends Controller
{
    /**
     * Получить все фотографии
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $photos = ModelsPhoto::with(['image'])->get()->toArray();
        return response()->json(['success' => true, 'photos' => $photos], 200);
    }

    /**
     * Сохранить новую фотографию.
     *
     * @param SavePhoto $request
     * @return JsonResponse
     */
    public function store(SavePhoto $request): JsonResponse
    {
        $data = $request->validated();
        $file = $data['picture'];
        $ext = $file->extension();
        $fileName = time(). mt_rand(1000, 9999) . '.' . $ext;
        Storage::putFileAs('public/img/photos/', $file, $fileName);
        ModelsPhoto::create([
                'caption' => $data['caption'] ?? null
            ])
            ->image()
            ->create([
                'name' => $fileName,
                'url' => '/storage/img/photos/' . $fileName
            ]);
        return response()->json(['success' => true], 200);
    }

    /**
     * Удалить фотографию.
     *
     * @param ModelsPhoto $photo
     * @return JsonResponse
     */
    public function delete(ModelsPhoto $photo): JsonResponse
    {
        Storage::disk('public')->delete('/img/photos/' . $photo->image->name);
        $photo->image()->delete();
        $photo->delete();
        return response()->json(['success' => true], 200);
    }
}
