<!doctype html>
<html lang='fr'>
<html lang="fr" xml:lang="fr" xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title><?= htmlspecialchars($title ?? 'Default title') ?></title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="./public/css/style.css" />
  <script src="./public/js/profile.js" defer="defer"></script>
  <script src="./public/js/article.js" defer="defer"></script>
  <script src="./public/js/search.js" defer="defer"></script>
  <script src="./public/js/home.js" defer="defer"></script>
</head>

<body>
  
  <header>
    <nav class="navbar">
      <button class="toggle-sidebar-btn" onclick="toggleSidebar()">
        <img src="<?= htmlspecialchars(BASE_URL) ?>/public/images/Bouton_Menu.png" alt="Menu">
      </button>
      <div class="logo"><img class="site-logo" src="<?= htmlspecialchars(BASE_URL) ?>/public/images/LOGO.png"></div>
      <div class="search-container">
        <input id="searchbar" type="text" placeholder="Rechercher des actualités...">
        <div id="search-results"></div>
      </div>
      <div class="nav-buttons">
        <?php if (isset($_SESSION['user_id'])): ?>
          <button onclick="location.href='<?= htmlspecialchars(BASE_URL) ?>/?route=logout'"><?= htmlspecialchars($signOut ?? "error") ?></button>
          <button onclick="location.href='<?= htmlspecialchars(BASE_URL) ?>/?route=profile'"><?= htmlspecialchars($profile ?? "error") ?></button>
        <?php else: ?>
          <button onclick="location.href='<?= htmlspecialchars(BASE_URL) ?>/?route=signin'"><?= htmlspecialchars($signIn ?? "error") ?></button>
          <button onclick="location.href='<?= htmlspecialchars(BASE_URL) ?>/?route=signup'"><?= htmlspecialchars($signUp ?? "error") ?></button>
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
        <a href="<?= htmlspecialchars(BASE_URL) ?>/?route=category&id=1">
          <img src="<?= htmlspecialchars(BASE_URL) ?>/public/images/Picto_TV.png" alt="TV Shows">
          <span>TV Shows</span>
        </a>
      </li>
      <li>
        <a href="<?= htmlspecialchars(BASE_URL) ?>/?route=category&id=/2">
          <img src="<?= htmlspecialchars(BASE_URL) ?>/public/images/Picto_Music.png" alt="Music">
          <span>Music</span>
        </a>
      </li>
      <li>
        <a href="<?= htmlspecialchars(BASE_URL) ?>/?route=category&id=3">
          <img src="<?= htmlspecialchars(BASE_URL) ?>/public/images/Picto_Cinema.png" alt="Cinéma">
          <span>Cinéma</span>
        </a>
      </li>
      <li>
        <a href="<?= htmlspecialchars(BASE_URL) ?>/?route=category&id=4">
          <img src="<?= htmlspecialchars(BASE_URL) ?>/public/images/Picto_Gaming.png" alt="Video Games">
          <span>Video Games</span>
        </a>
      </li>
      <li>
        <a href="<?= htmlspecialchars(BASE_URL) ?>/?route=category&id=5">
          <img src="<?= htmlspecialchars(BASE_URL) ?>/public/images/Picto_Books.png" alt="Books & Comics">
          <span>Books & Comics</span>
        </a>
      </li>
      <li>
        <a href="<?= htmlspecialchars(BASE_URL) ?>/?route=category&id=6">
          <img src="<?= htmlspecialchars(BASE_URL) ?>/public/images/Picto_Anime.png" alt="Manga & Anime">
          <span>Manga & Anime</span>
        </a>
      </li>
      <li>
        <a href="<?= htmlspecialchars(BASE_URL) ?>/?route=category&id=7">
          <img src="<?= htmlspecialchars(BASE_URL) ?>/public/images/Picto_Internet.png" alt="Internet Culture">
          <span>Internet Culture</span>
        </a>
      </li>
      <li>
        <a href="<?= htmlspecialchars(BASE_URL) ?>/?route=category&id=8">
          <img src="<?= htmlspecialchars(BASE_URL) ?>/public/images/art.png" alt="Art">
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