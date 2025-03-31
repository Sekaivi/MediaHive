<?php
session_start();

// Simple autoloader
spl_autoload_register(function($class){
    require_once 'app/' . str_replace('\\','/',$class) . '.php';
});

// Routage simple
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

switch($page) {
    case 'home':
        require_once 'app/controllers/ArticleController.php';
        $controller = new ArticleController();
        $controller->index();
        break;
    case 'login':
        require_once 'app/views/login.php';
        break;
    case 'register':
        require_once 'app/views/register.php';
        break;
    case 'logout':
        // Déconnexion
        session_destroy();
        header("Location: index.php?page=login");
        exit;
    default:
        echo "Page non trouvée";
        break;
}

