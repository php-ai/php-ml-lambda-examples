<?php

declare(strict_types=1);

switch (true) {
    case match('iris'):
        echo 'iris';
        break;
    default:
        echo 'bad request';
}

function match(string $path): bool
{
    return strpos($_SERVER['PATH_INFO'], $path) !== false;
}
