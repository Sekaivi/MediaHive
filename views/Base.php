<!doctype html>
<html lang='fr'>
<html lang="fr" xml:lang="fr" xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title><?= htmlspecialchars($title ?? 'Default title') ?></title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="public/css/style.css" />
</head>

<body>
  <header>
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
  </header>

  <main>
      <?= $content ?? 'Default content' ?>
  </main>
  <footer>
      <p>&copy; <?= date('Y') ?> - MediaHive</p>
  </footer>
</body>

</html>