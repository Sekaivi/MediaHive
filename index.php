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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset(($_POST['routeAjax']))) {
  $action = $_POST['routeAjax'];
  switch ($action) {

    case 'updateProfile':
      $controller = new ProfileController($cnxDB);
      $controller->update_profile();
      break;

    case 'updatePreferences':
      $controller = new ProfileController($cnxDB);
      $controller->update_preferences();
      break;

    case 'removePref':
      $controller = new ProfileController($cnxDB);
      $controller->remove_preference();
      break;

    case 'likeArticle':
      $controller = new ArticleController($cnxDB);
      $controller->handleLike() ;
      break;

    case 'bookmarkArticle':
      $controller = new ArticleController($cnxDB);
      $controller->handleBookmark() ;
      break;
    case 'updateKeywords':
      $controller = new ArticleController($cnxDB);
      $controller->updateKeywords() ;
      break;

    case 'listPopKeywords':
      $controller = new SearchController($cnxDB) ;
      $controller->popular_keywords_list() ;
      break ;
    
    case 'updateSearchSuggestions':
      $controller = new SearchController($cnxDB) ;
      $controller->search_suggestions_list() ;
      break ;

    default:
      echo json_encode([
        'success' => false,
        'message' => 'undefined AJAX route'.$_POST['routeAjax ']
      ]);

  }

} else {
  $router->addRoute('GET', "/", 'ArticleController@index');

  $router->addRoute('GET', "/signin", 'SignInController@signin_form');
  $router->addRoute('POST', "/signin", 'SignInController@handleConnexion');

  $router->addRoute('GET', "/signup", 'SignUpController@signup_form');
  $router->addRoute('POST', "/signup", 'SignUpController@handleSignup');

  $router->addRoute('GET', "/logout", 'SignOutController@handle_signout');

  $router->addRoute('GET', "/profile", 'ProfileController@display_profile');
  $router->addRoute('POST', "/profile/update", 'ProfileController@update_profile');

  $router->addRoute('GET', '/{category}', 'SearchController@get_articles_category') ;

  $router->resolve();
}


?>