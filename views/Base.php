<!doctype html>
<html lang='fr'>
<html lang="fr" xml:lang="fr" xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title><?= htmlspecialchars($title ?? 'Default title') ?></title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="./public/css/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <script src="./public/js/profile.js" defer="defer"></script>
  <script src="./public/js/article.js" defer="defer"></script>
  <script src="./public/js/search.js" defer="defer"></script>
  <script src="./public/js/home.js" defer="defer"></script>
</head>

<body>
  <div id="myModal" class="modal">
    <div class="modal-content">
      <span class="close-btn">&times;</span>
      <h2 id="modalTitle"></h2>
      <p>Sign in or Sign up to access many more features !</p>
      <button id="closeModal">Close</button>
    </div>
  </div>
  <header>
    <nav class="navbar">
      <button class="toggle-sidebar-btn" onclick="toggleSidebar()">
        <img src="<?= htmlspecialchars(BASE_URL) ?>/public/images/Bouton_Menu.png" alt="Menu">
      </button>
      <div onclick="location.href='<?= htmlspecialchars(BASE_URL) ?>'" class="logo"><img class="site-logo"
          src="<?= htmlspecialchars(BASE_URL) ?>/public/images/LOGO.png"></div>
      <div class="search-container">
        <input id="searchbar" type="text" placeholder="Search...">
        <i class="fas fa-search search-icon"></i>
        <div id="search-results"></div>
      </div>
      <div class="nav-buttons">
        <?php if (isset($_SESSION['user_id'])): ?>
          <button
            onclick="location.href='<?= htmlspecialchars(BASE_URL) ?>/?route=logout'"><?= htmlspecialchars($signOut ?? "error") ?></button>
          <button
            onclick="location.href='<?= htmlspecialchars(BASE_URL) ?>/?route=profile'"><?= htmlspecialchars($profile ?? "error") ?></button>
        <?php else: ?>
          <button
            onclick="location.href='<?= htmlspecialchars(BASE_URL) ?>/?route=signin'"><?= htmlspecialchars($signIn ?? "error") ?></button>
          <button
            onclick="location.href='<?= htmlspecialchars(BASE_URL) ?>/?route=signup'"><?= htmlspecialchars($signUp ?? "error") ?></button>
        <?php endif; ?>

        <form method="GET">
          <select id="language-select" name="lang" onchange="this.form.submit()">
            <option value="en" <?= $_SESSION['lang'] === 'en' ? 'selected' : '' ?>>English</option>
            <option value="fr" <?= $_SESSION['lang'] === 'fr' ? 'selected' : '' ?>>Français</option>
            <option value="vi" <?= $_SESSION['lang'] === 'vi' ? 'selected' : '' ?>>Tiếng Việt</option>
          </select>
        </form>

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
        <a href="<?= htmlspecialchars(BASE_URL) ?>/?route=category&id=2">
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
    <div class="footer-border">
      <div class="border-segment" style="background-color: #FFE009;"></div>
      <div class="border-segment" style="background-color: #31FF6E;"></div>
      <div class="border-segment" style="background-color: #FF9AF0;"></div>
      <div class="border-segment" style="background-color: #3C74FF;"></div>
    </div>

    <div class="flex-container">

      <div class="footer-item" id="footer-socials">
        <img src="./public/images/logo_footer.png" id="footer-logo" alt="footer_logo" />
        <div id="socials">
          <img src="./public/images/instagram.png" alt="instagram" />
          <img src="./public/images/tiktok.png" alt="tiktok" />
          <img src="./public/images/facebook.png" alt="facebook" />
          <img src="./public/images/youtube.png" alt="youtube" />
        </div>
      </div>

      <div class="footer-item" id="footer-newsletter">
        <p class="footer-title"><?= $subscribe ?></p>
        <div class="subscribe">
          <input placeholder="E-mail" /> <button>Subscribe</button>
        </div>
        <p class="tinytext"><?= $explanation_newsletter ?></p>
      </div>

      <div class="footer-item" id="footer-infos">
        <p class="footer-title">MediaHive</p>
        <ul id="useful-links">
          <li><a href="?route=faq"><?= $faq ?></a></li>
          <li><a href="?route=about"><?= $about ?></a></li>
          <li><a href="?route=about"><?= $legalinfo ?></a></li>
          <li><a href="?route=about"><?= $useragree ?></a></li>
        </ul>
      </div>
    </div>

    <p>&copy; <?= date('Y') ?> - MediaHive</p>
  </footer>
</body>

</html>