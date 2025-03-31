<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

define('BASE_URL', rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'));

define("CHARGE_AUTOLOAD", true);
require_once "config/autoloader.php";


require_once("config/db.php"); // loading database
try {
  $cnxDB = new PDO(DB_DSN, DB_USER, DB_PASSWORD, PDO_OPTIONS);
} catch (PDOException $e) {
  throw new PDOException($e->getMessage(), (int) $e->getCode()); // for debug, otherwise use: die("Database connection failed. Please try again later.");
}

$router = new Router($cnxDB);


$lang = $_GET['lang'] ?? $_SESSION['lang'] ?? 'en';
$supportedLanguages = ['en', 'fr'];
if (!in_array($lang, $supportedLanguages)) {
  $lang = 'en'; // default to english
}

// Set the language in Translation
$t = Translation::getInstance();
$t->setLanguage($lang);

$router->addRoute('GET', "/", 'ArticleController@index');

$router->addRoute('GET', "/signin", 'SignInController@signin_form');
$router->addRoute('POST', "/signin", 'SignInController@handleConnexion');

  $router->addRoute('GET', "/signup", 'SignUpController@signup_form');
  $router->addRoute('POST', "/signup", 'SignUpController@handleSignup');

$router->addRoute('GET', "/profile", 'ProfileController@display_profile');

$router->resolve();

?>