<?php

spl_autoload_register(function ($class) {
    $base_dir = __DIR__ . '/backend/';
    $file = $base_dir . str_replace('\\', '/', $class) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

// spl_autoload_register(function ($class) {
//     $base_dir = __DIR__ . '/';

//     // Substituir o namespace separador por diretórios
//     $file = $base_dir . str_replace('\\', '/', $class) . '.php';

//     // Se o arquivo existir, inclua-o
//     if (file_exists($file)) {
//         require_once $file;
//     }
// });
