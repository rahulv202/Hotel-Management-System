<?php

namespace App\Utils;

use Firebase\JWT\JWT;
use Firebase\JWT\key;


class JWTUtil
{
    private $secret;
    private $algorithm;
    private $expiry;
    public function __construct()
    {
        $this->secret = jwt_secret;
        $this->algorithm = algorithm;
        $this->expiry = expiry;
    }

    public function generateToken($payload)
    {
        $payload['iat'] = time();
        $payload['exp'] = time() + $this->expiry;
        $payload['jti'] = bin2hex(random_bytes(16));  // Generate a unique token ID

        return JWT::encode($payload, $this->secret, $this->algorithm);
    }

    public function verify($token, $data)
    {
        $decoded = JWT::decode($token, new Key($this->secret, $this->algorithm));
        if ($data != null && $data[0]['expires_at'] != null) {
            throw new \Exception('Token invalid due to Delete');
        }
        return $decoded;
    }
}
