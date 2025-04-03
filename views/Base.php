<!doctype html>
<html lang='fr'>
<html lang="fr" xml:lang="fr" xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title><?= htmlspecialchars($title ?? 'Default title') ?></title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="public/css/style.css" />
  <script src="public/js/profile.js" defer="defer"></script>
  <script src="public/js/article.js" defer="defer"></script>
  <script src="public/js/search.js" defer="defer"></script>
</head>

<body>

  <header>
  <nav class="navbar">
    <button class="toggle-sidebar-btn" onclick="toggleSidebar()">
      <img src="public/images/Bouton_Menu.png" alt="Menu">
    </button>
    <div class="logo"><img class="site-logo" src="public/images/LOGO.png"></div>
    <div class="search-container">
      <input id="searchbar" type="text" placeholder="Rechercher des actualités...">
      <div id="search-results"></div>
    </div>
    <div class="nav-buttons">
      <?php if(isset($_SESSION['user_id'])): ?>
        <button onclick="location.href='<?= BASE_URL ?>/logout'"><?= htmlspecialchars($signOut ?? "error") ?></button>
        <button onclick="location.href='<?= BASE_URL ?>/profile'"><?= htmlspecialchars($profile ?? "error") ?></button>
      <?php else: ?>
        <button onclick="location.href='<?= BASE_URL ?>/signin'"><?= htmlspecialchars($signIn ?? "error") ?></button>
        <button onclick="location.href='<?= BASE_URL ?>/signup'"><?= htmlspecialchars($signUp ?? "error") ?></button>
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
