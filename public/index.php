<?php

use App\Kernel;

// S'assurer que les variables d’environnement sont prises en compte
if (!isset($_SERVER['APP_ENV'])) {
    $_SERVER['APP_ENV'] = getenv('APP_ENV') ?: 'prod';
}
if (!isset($_SERVER['APP_DEBUG'])) {
    $_SERVER['APP_DEBUG'] = (bool) getenv('APP_DEBUG');
}

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
