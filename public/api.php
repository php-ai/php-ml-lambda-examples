<?php

declare(strict_types=1);

namespace PhpmlLambda;

use Phpml\ModelManager;

require_once __DIR__.'/../vendor/autoload.php';

switch (true) {
    case match('iris'):
        echo 'iris';
        break;
    case match('housing'):
        $model = (new ModelManager())->restoreFromFile(__DIR__.'/../model/housing.phpml');
        echo json_encode(['price' => round($model->predict([[
            $_POST['life_sq'],
            $_POST['full_sq'],
            $_POST['floor'],
            $_POST['build_year'],
        ]])[0])]);
        break;
    default:
        echo 'bad request';
}

function match(string $path): bool
{
    return strpos($_SERVER['PATH_INFO'], $path) !== false;
}
