<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Pop Culture News</title>
  <link rel="stylesheet" href="public/css/style.css">

  <style>
    /* Styles spécifiques à la barre de navigation */
    .navbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      background-color: #3C74FF;
      padding: 30px 20px;
      color: #fff;
    }
    .navbar .search-container {
      flex: 1;
      margin: 0 20px;
    }
    .navbar .search-container input[type="text"] {
      width: 100%;
      padding: 8px;
      border: none;
      border-radius: 3px;
    }
    .navbar .nav-buttons {
      display: flex;
      align-items: center;
    }
    .navbar .nav-buttons button {
      background-color: #FFE009;
      color: #000000;
      border: none;
      padding: 8px 12px;
      margin-left: 10px;
      border-radius: 14px;
      cursor: pointer;
    }
    .navbar .nav-buttons button:hover {
      background-color: #777;
    }
  </style>
</head>
<body>
  <nav class="navbar">
    <div class="logo"><img class="site-logo" src="public/images/LOGO.png"></div>
    <div class="search-container">
      <input type="text" placeholder="Rechercher des actualités...">
    </div>
    <div class="nav-buttons">
      <?php if(isset($_SESSION['user_id'])): ?>
        <span>Bonjour, <?= htmlspecialchars($_SESSION['username']) ?></span>
        <button onclick="location.href='index.php?page=logout'">Déconnexion</button>
      <?php else: ?>
        <button onclick="location.href='index.php?page=login'">Connexion</button>
        <button onclick="location.href='index.php?page=register'">Inscription</button>
      <?php endif; ?>
      <button>Langue</button>
    </div>
  </nav>

