<?php
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "DB_NAME");

define("jwt_secret", "your_secret_key"); // openssl rand -base64 32
define("algorithm", "HS256");
define("expiry", time() + (7 * 24 * 60 * 60)); // Token valid for 7 days
