<?php

define('DB_HOST', 'localhost');    // Database server address
define('DB_NAME', 'pop_culture_db'); // Name of the database
define('DB_USER', 'sekai');  // Database username
define('DB_PASSWORD', 'flap2004');  // Database password
define("DB_DSN" , 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4') ;
define('PDO_OPTIONS', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,  // Enable error mode
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,  // Set default fetch mode to associative arrays
    PDO::ATTR_EMULATE_PREPARES => false,  // Disable emulated prepared statements for security
]);

?>