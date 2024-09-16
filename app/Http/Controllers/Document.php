<?php

namespace App\Http\Controllers;

use App\Http\Requests\Document\Save as SaveRequest;
use App\Models\Document as ModelsDocument;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class Document extends Controller
{
    /**
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $documents = ModelsDocument::get()->toArray();
        return response()->json(['success' => true, 'documents' => $documents], 200);
    }

    /**
     *
     * @param SaveRequest $request
     * @return JsonResponse
     */
    public function store(SaveRequest $request): JsonResponse
    {
        $data = $request->validated();
        $file = $data['file'];
        $ext = $file->extension();
        $fileName = time(). mt_rand(1000, 9999) . '.' . $ext;
        Storage::putFileAs('public/documents/', $file, $fileName);
        ModelsDocument::create([
            'name' => $data['name'],
            'path' => '/storage/documents/' . $fileName,
            'category_id' => $categoryId ?? null
        ]);
        return response()->json(['success' => true], 200);
    }

    /**
     *
     * @param ModelsDocument $document
     * @return JsonResponse
     */
    public function destroy(ModelsDocument $document): JsonResponse
    {
        $fileName = pathinfo($document->path, PATHINFO_BASENAME);
        Storage::disk('public')->delete('/documents/' . $fileName);
        $document->delete();
        return response()->json(['success' => true], 200);
    }
}
