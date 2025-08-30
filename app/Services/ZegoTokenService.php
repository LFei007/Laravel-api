<?php

namespace App\Services;

use Zego\ServerAssistant\TokenServerAssistant;

class ZegoTokenService
{
    public function generateToken($userId, $roomId)
    {
        $appId = env('ZEGO_APP_ID');
        $serverSecret = env('ZEGO_SERVER_SECRET');

        $expireTime = 3600; // 1 hour

        // call Zego SDK
        return TokenServerAssistant::generateToken04($appId, $userId, $serverSecret, $expireTime, $roomId);
    }
}
