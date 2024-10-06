<?php

namespace App\Http\Controllers;

use App\Mail\NewFeedback;
use App\Models\Feedback;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class Admin extends Controller
{
     /**
     * Test route for dev.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function test(Request $request): JsonResponse
    {
        $feedback = Feedback::find(1);
        $moder = User::where('email', UserService::MODER_EMAIL_SEND)->firstOrfail();
        Mail::to($moder)->send(new NewFeedback($feedback));
        return response()->json([], 200);
    }

    /**
     *
     * @return JsonResponse
     */
    public function getUsers(): JsonResponse
    {
        $users = User::with('roles:id,name,description')->paginate(10);
        return response()->json(compact('users'), 200);
    }

    /**
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function blockedUser(Request $request, User $user): JsonResponse
    {
        $data = $request->validate([
            'check' => 'required|boolean',
        ]);
        $user->update(['block' => $data['check']]);
        return response()->json(['OK'], 200);
    }   
}
