<!doctype html>
<html lang='fr'>
<html lang="fr" xml:lang="fr" xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title><?= htmlspecialchars($title ?? 'Default title') ?></title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/public/css/style.css" />
  <script src="<?= BASE_URL ?>/public/js/profile.js" defer="defer"></script>
  <script src="<?= BASE_URL ?>/public/js/article.js" defer="defer"></script>
  <script src="<?= BASE_URL ?>/public/js/search.js" defer="defer"></script>
  <script src="<?= BASE_URL ?>/public/js/home.js" defer="defer"></script>
</head>

<body>

  <!-- Écran de chargement -->
  <div id="loading-screen">
    <div class="spinner"></div>
    <p>Chargement...</p>
  </div>

  <header>
    <nav class="navbar">
      <button class="toggle-sidebar-btn" onclick="toggleSidebar()">
        <img src="<?= BASE_URL ?>/public/images/Bouton_Menu.png" alt="Menu">
      </button>
      <div class="logo"><img class="site-logo" src="<?= BASE_URL ?>/public/images/LOGO.png"></div>
      <div class="search-container">
        <input id="searchbar" type="text" placeholder="Rechercher des actualités...">
        <div id="search-results"></div>
      </div>
      <div class="nav-buttons">
        <?php if (isset($_SESSION['user_id'])): ?>
          <button onclick="location.href='<?= BASE_URL ?>/logout'"><?= htmlspecialchars($signOut ?? "error") ?></button>
          <button onclick="location.href='<?= BASE_URL ?>/profile'"><?= htmlspecialchars($profile ?? "error") ?></button>
        <?php else: ?>
          <button onclick="location.href='<?= BASE_URL ?>/signin'"><?= htmlspecialchars($signIn ?? "error") ?></button>
          <button onclick="location.href='<?= BASE_URL ?>/signup'"><?= htmlspecialchars($signUp ?? "error") ?></button>
        <?php endif; ?>
        <button>Langue</button>
      </div>
    </nav>
      <div class="header-border">
        <div class="border-segment" style="background-color: #FFE009;"></div>
        <div class="border-segment" style="background-color: #31FF6E;"></div>
        <div class="border-segment" style="background-color: #FF9AF0;"></div>
        <div class="border-segment" style="background-color: #3C74FF;"></div>
      </div>
  </header>


  <aside id="sidebar">
    <ul>
      <li>
        <a href="<?= BASE_URL ?>/category/1">
          <img src="<?= BASE_URL ?>/public/images/Picto_TV.png" alt="TV Shows">
          <span>TV Shows</span>
        </a>
      </li>
      <li>
        <a href="<?= BASE_URL ?>/category/2">
          <img src="<?= BASE_URL ?>/public/images/Picto_Music.png" alt="Music">
          <span>Music</span>
        </a>
      </li>
      <li>
        <a href="<?= BASE_URL ?>/category/3">
          <img src="<?= BASE_URL ?>/public/images/Picto_Cinema.png" alt="Cinéma">
          <span>Cinéma</span>
        </a>
      </li>
      <li>
        <a href="<?= BASE_URL ?>/category/4">
          <img src="<?= BASE_URL ?>/public/images/Picto_Gaming.png" alt="Video Games">
          <span>Video Games</span>
        </a>
      </li>
      <li>
        <a href="<?= BASE_URL ?>/category/5">
          <img src="<?= BASE_URL ?>/public/images/Picto_Books.png" alt="Books & Comics">
          <span>Books & Comics</span>
        </a>
      </li>
      <li>
        <a href="<?= BASE_URL ?>/category/6">
          <img src="<?= BASE_URL ?>/public/images/Picto_Anime.png" alt="Manga & Anime">
          <span>Manga & Anime</span>
        </a>
      </li>
      <li>
        <a href="<?= BASE_URL ?>/category/7">
          <img src="<?= BASE_URL ?>/public/images/Picto_Internet.png" alt="Internet Culture">
          <span>Internet Culture</span>
        </a>
      </li>
      <li>
        <a href="<?= BASE_URL ?>/category/8">
          <img src="<?= BASE_URL ?>/public/images/art.png" alt="Art">
          <span>Internet Culture</span>
        </a>
      </li>
    </ul>
  </aside>

  <main>
    <?= $content ?? 'Default content' ?>
  </main>
  <footer>
    <p>&copy; <?= date('Y') ?> - MediaHive</p>
  </footer>
</body>

</html>