<?php

namespace App\Http\Controllers;

use App\Http\Requests\Feedback as RequestsFeedback;
use App\Models\Feedback as ModelsFeedback;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class Feedback extends Controller
{   
    /**
     * Undocumented function
     *
     * @param UserService $userService
     */
    public function __construct(
        public UserService $userService
    ) {}

    /**
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $feedbacks = ModelsFeedback::with('user:id,first_name,last_name,email')
            ->latest()
            ->get()
            ->map(function(ModelsFeedback $feedback) {
                $feedback->status_text = $feedback->status->text();
                return $feedback;
            })
            ->toArray();
        return response()->json(['data' => $feedbacks], 200);
    }

    /**
     *
     * @param RequestsFeedback $request
     * @return JsonResponse
     */
    public function store(RequestsFeedback $request): JsonResponse
    {
        $data = $request->validated();
        $user = $request->user();
        $this->userService->createFeedback($user, $data);
        return response()->json(['success' => true], 200);
    }
}
