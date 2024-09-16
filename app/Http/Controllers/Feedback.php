<?php

namespace App\Http\Controllers;

use App\Http\Requests\Feedback as RequestsFeedback;
use App\Mail\NewFeedback;
use App\Models\Feedback as ModelsFeedback;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class Feedback extends Controller
{
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
        $feedback = $user->feedbacks()->create($data);
        try {
            $moder = User::where('email', 'jjnn95@yandex.ru')->firstOrfail();
            Mail::to($moder)->send(new NewFeedback($feedback));
        } catch (\Throwable $th) {
            Log::error('Отправить письмо модератору не удалось ' . $th->getMessage());
        }
        return response()->json(['success' => true], 200);
    }
}
