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
  <script src="public/js/home.js" defer="defer"></script>
</head>

<body>

  <!-- Écran de chargement -->
  <div id="loading-screen">
    <div class="spinner"></div>
    <p>Chargement...</p>
  </div>

<header>
  <nav class="navbar">
    <!-- Bouton de menu et autres éléments du header -->
    <button class="toggle-sidebar-btn" onclick="toggleSidebar()">
      <img src="public/images/Bouton_Menu.png" alt="Menu">
    </button>
    <div class="logo">
      <img class="site-logo" src="public/images/LOGO.png" alt="Logo">
    </div>
    <div class="search-container">
      <input type="text" placeholder="Rechercher des actualités...">
    </div>
    <div class="nav-buttons">
      <?php if(isset($_SESSION['user_id'])): ?>
        <a href='<?= BASE_URL ?>/logout'"><?= htmlspecialchars($signOut ?? "error") ?></a>
        <button onclick="location.href='<?= BASE_URL ?>/profile'"><?= htmlspecialchars($profile ?? "error") ?></button>
      <?php else: ?>
        <a href='<?= BASE_URL ?>/signin'"><?= htmlspecialchars($signIn ?? "error") ?></a>
        <a href='<?= BASE_URL ?>/signup'"><?= htmlspecialchars($signUp ?? "error") ?></a>
      <?php endif; ?>
      <button>Langue</button>
    </div>
  </nav>
  <!-- Bordure sous le header composée de 4 segments -->
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
        <img src="public/images/Picto_TV.png" alt="TV Shows">
        <span>TV Shows</span>
      </a>
    </li>
    <li>
      <a href="<?= BASE_URL ?>/category/2">
        <img src="public/images/Picto_Music.png" alt="Music">
        <span>Music</span>
      </a>
    </li>
    <li>
      <a href="<?= BASE_URL ?>/category/3">
        <img src="public/images/Picto_Cinema.png" alt="Cinéma">
        <span>Cinéma</span>
      </a>
    </li>
    <li>
      <a href="<?= BASE_URL ?>/category/4">
        <img src="public/images/Picto_Gaming.png" alt="Video Games">
        <span>Video Games</span>
      </a>
    </li>
    <li>
      <a href="<?= BASE_URL ?>/category/5">
        <img src="public/images/Picto_Books.png" alt="Books & Comics">
        <span>Books & Comics</span>
      </a>
    </li>
    <li>
      <a href="<?= BASE_URL ?>/category/6">
        <img src="public/images/Picto_Anime.png" alt="Manga & Anime">
        <span>Manga & Anime</span>
      </a>
    </li>
    <li>
      <a href="<?= BASE_URL ?>/category/7">
        <img src="public/images/Picto_Internet.png" alt="Internet Culture">
        <span>Internet Culture</span>
      </a>
    </li>
    <li>
      <a href="<?= BASE_URL ?>/category/8">
        <img src="public/images/art.png" alt="Art">
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
