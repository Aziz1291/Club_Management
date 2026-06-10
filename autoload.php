<?php

// This function runs automatically when PHP sees a class that is not loaded yet
spl_autoload_register(function($class) {

    // Path to the classes folder
    $file = __DIR__ . "/classes/" . $class . ".php";

    // Check if the file exists
    if (file_exists($file)) {
        require_once $file;
    } else {
        // Optional: show error for debugging
        echo "Autoloader: Class file not found for '$class' at $file";
    }
});
