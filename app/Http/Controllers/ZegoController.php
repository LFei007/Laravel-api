<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ZegoTokenService;

class ZegoController extends Controller
{
    protected $zegoTokenService;

    // inject the service into the controller
    public function __construct(ZegoTokenService $zegoTokenService)
    {
        $this->zegoTokenService = $zegoTokenService;
    }

    public function getToken(Request $request)
    {
        $request->validate([
            'user_id' => 'required|string',
            'room_id' => 'required|string',
        ]);

        $userId = $request->input('user_id');
        $roomId = $request->input('room_id');

        // call service to generate token
        $token = $this->zegoTokenService->generateToken($userId, $roomId);

        return response()->json([
            'token' => $token,
            'user_id' => $userId,
            'room_id' => $roomId,
        ]);
    }
}
