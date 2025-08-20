<?php

use App\Kernel;

if (file_exists(dirname(__DIR__).'/.env')) {
    (new Symfony\Component\Dotenv\Dotenv())->loadEnv(dirname(__DIR__).'/.env');
}

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    $env = $context['APP_ENV'] ?? getenv('APP_ENV') ?: 'prod';
    $debug = isset($context['APP_DEBUG']) ? (bool) $context['APP_DEBUG'] : (bool) getenv('APP_DEBUG');

    return new Kernel($env, $debug);
};
