<?php

namespace App\Middleware;

use App\Utils\JWTUtil;
use App\Models\API_tokens;

class APIMiddleware
{

    private $jwtUtil;
    public function __construct()
    {
        $this->jwtUtil = new JWTUtil();
    }

    public function handle($requestUri, $next)
    {
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        if (strpos($authHeader, 'Bearer ') !== 0) {
            http_response_code(401);
            echo json_encode(['message' => 'Unauthorized']);
            return;
        }

        $token = substr($authHeader, 7);

        try {
            // Decode token and verify logout time
            $decoded = $this->jwtUtil->verify($token, null);
            $api_data = API_tokens::getInstance();
            $data = $api_data->getAllData("user_id={$decoded->id} AND token IS NOT NULL ORDER BY id DESC LIMIT 1"); //AND expires_at IS NULL

            $this->jwtUtil->verify($token, $data);
        } catch (\Exception $e) {
            http_response_code(401);
            echo json_encode(['message' => $e->getMessage()]);
            return;
        }

        return $next($requestUri);
    }
}
