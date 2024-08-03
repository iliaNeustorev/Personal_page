<?php

namespace App\Http\Controllers;

use App\Http\Requests\Feedback as RequestsFeedback;
use App\Models\Feedback as ModelsFeedback;
use Illuminate\Http\JsonResponse;

class Feedback extends Controller
{
    /**
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(['data' => ModelsFeedback::get()->toArray()], 200);
    }

    /**
     *
     * @param RequestsFeedback $request
     * @return JsonResponse
     */
    public function store(RequestsFeedback $request): JsonResponse
    {
        $data = $request->validated();
        ModelsFeedback::create($data);
        return response()->json(['success' => true], 200);
    }
}
