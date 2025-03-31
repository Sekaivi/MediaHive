<<<<<<< HEAD
<?php

if (!defined("CHARGE_AUTOLOAD")) { 
    die("Autoload not allowed");
}

function set_autoload() {
    function my_autoloader($classname) {
        $paths = [
            __DIR__ . '/../models/', 
            __DIR__ . '/../controllers/',
            __DIR__ . '/../config/',
            __DIR__ . '/../views/',
        ];

        foreach ($paths as $path) {
            $file = $path . $classname . '.php';
            if (file_exists($file)) {
                include_once($file);
                return;
            }
        }
        die("Error: Unknown class - " . $classname);
    }

    spl_autoload_register('my_autoloader');
}

set_autoload();
?>
=======
<?php

if (!defined("CHARGE_AUTOLOAD")) { 
    die("Autoload not allowed");
}

function set_autoload() {
    function my_autoloader($classname) {
        $paths = [
            __DIR__ . '/../models/', 
            __DIR__ . '/../controllers/',
            __DIR__ . '/../config/',
            __DIR__ . '/../views/',
        ];

        foreach ($paths as $path) {
            $file = $path . $classname . '.php';
            if (file_exists($file)) {
                include_once($file);
                return;
            }
        }
        die("Error: Unknown class - " . $classname);
    }

    spl_autoload_register('my_autoloader');
}

set_autoload();
?>
>>>>>>> 38c97c2a7c21885c6f0ca7ab019c19a977e8285c
