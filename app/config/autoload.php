<?php
spl_autoload_register(function ($class) {
    // Define the base directories to look for classes
    $directories = [
        '../app/controllers/',
        '../app/models/',
        '../app/core/'
    ];

    // Loop through directories
    foreach ($directories as $directory) {
        $file = $directory . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
}); 