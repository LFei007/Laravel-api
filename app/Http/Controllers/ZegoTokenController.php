<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// If you installed via Composer (recommended):
use ZEGO\ZegoServerAssistant;
use ZEGO\ZegoErrorCodes;

// If you pulled the GitHub repo manually, also include its loader:
// require_once base_path('zego/auto_loader.php');

class ZegoTokenController extends Controller
{
    public function issue(Request $req)
    {
        $userID = (string) $req->query('userID', '');
        if ($userID === '') {
            return response()->json(['error' => 'userID required'], 400);
        }

        // (Optional) verify your own app auth here:
        // $auth = $req->header('Authorization');
        // if (!$auth) return response()->json(['error' => 'unauthorized'], 401);

        $appId        = (int) env('ZEGO_APP_ID', 0);
        $serverSecret = (string) env('ZEGO_SERVER_SECRET', '');
        if (!$appId || !$serverSecret) {
            return response()->json(['error' => 'server_not_configured'], 500);
        }

        $expire  = 3600;  // 1 hour
        $payload = '';    // keep empty unless you use privilege control

        $res = ZegoServerAssistant::generateToken04($appId, $userID, $serverSecret, $expire, $payload);
        if ($res->code !== ZegoErrorCodes::success) {
            return response()->json(['error' => 'token_generation_failed', 'code' => $res->code], 500);
        }

        return response()->json(['token' => $res->token, 'expires_in' => $expire]);
    }
}