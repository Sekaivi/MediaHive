<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

define('LOCATION', '/MediaHive');
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/' . ltrim(LOCATION, '/'));

define("CHARGE_AUTOLOAD", true);
require_once "config/autoloader.php";

require_once("config/db.php"); // loading database
try {
  $cnxDB = new PDO(DB_DSN, DB_USER, DB_PASSWORD, PDO_OPTIONS);
} catch (PDOException $e) {
  throw new PDOException($e->getMessage(), (int) $e->getCode()); // for debug, otherwise use: die("Database connection failed. Please try again later.");
}

$lang = $_GET['lang'] ?? $_POST['lang'] ?? $_SESSION['lang'] ?? 'en';
$supportedLanguages = ['en', 'fr', 'vi'];
if (!in_array($lang, $supportedLanguages)) {
  $lang = 'en'; // default to english
}

// Set the language in Translation
$t = Translation::getInstance();
$t->setLanguage($lang);
$_SESSION['lang'] = $lang;

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
      $controller->handleLike();
      break;

    case 'bookmarkArticle':
      $controller = new ArticleController($cnxDB);
      $controller->handleBookmark();
      break;
    case 'updateKeywords':
      $controller = new ArticleController($cnxDB);
      $controller->updateKeywords();
      break;

    case 'listPopKeywords':
      $controller = new SearchController($cnxDB);
      $controller->popular_keywords_list();
      break;

    case 'updateSearchSuggestions':
      $controller = new SearchController($cnxDB);
      $controller->search_suggestions_list();
      break;

    default:
      echo json_encode([
        'success' => false,
        'message' => 'undefined AJAX route' . $_POST['routeAjax ']
      ]);

  }

} else {

  // tout ce qui se fait en GET
  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $route = $_GET['route'] ?? 'home';

    switch ($route) {
      case '':
      case 'home':
        $controller = new ArticleController($cnxDB);
        $controller->index();
        break;

      case 'signin':
        $controller = new SignInController($cnxDB);
        $controller->signin_form();
        break;

      case 'signup':
        $controller = new SignUpController($cnxDB);
        $controller->signup_form();
        break;

      case 'profile':
        $controller = new ProfileController($cnxDB);
        $controller->display_profile();
        break;

      case 'logout':
        $controller = new SignOutController();
        $controller->handle_signout();
        break;

      case 'category':
        $controller = new SearchController($cnxDB);
        $controller->get_articles_category($_GET['id']);
      default:
        echo 'error 404';
    }
  } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $route = $_GET['route'] ?? 'home';

    switch ($route) {

      case 'signin':
        $controller = new SignInController($cnxDB);
        $controller->handleConnexion();
        break;

      case 'signup':
        $controller = new SignUpController($cnxDB);
        $controller->handleSignup();
        break;

      case 'category':
        $controller = new SearchController($cnxDB);
        $controller->update_articles_category($_GET['id']);
      default:
        echo 'error 404';
    }
  }
  

}

?>