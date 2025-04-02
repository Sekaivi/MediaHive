<!doctype html>
<html lang='fr'>
<html lang="fr" xml:lang="fr" xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title><?= htmlspecialchars($title ?? 'Default title') ?></title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="public/css/style.css" />
  <script src="public/js/script.js" defer="defer"></script>
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


<!-- Sidebar pour la navigation par catégorie -->
  <aside id="sidebar">
    <ul>
      <li>
        <!-- Exemple d'icône pour la catégorie News (remplacez par votre image) -->
        <img src="public/images/Picto_News.png" alt="News">
        <span>News</span>
      </li>
      <li>
        <img src="public/images/Picto_Cinema.png" alt="Cinéma">
        <span>Cinéma</span>
      </li>
      <li>
        <img src="public/images/Picto_Gaming.png" alt="Gaming">
        <span>Gaming</span>
      </li>
      <li>
        <img src="public/images/Picto_Anime.png" alt="Anime">
        <span>Anime</span>
      </li>
      <!-- Ajoutez d'autres catégories selon vos besoins -->
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
