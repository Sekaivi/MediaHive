<!-- header.php -->
<nav class="navbar">
  <div class="logo">Pop Culture News</div>
  <div class="search-container">
    <input type="text" placeholder="Rechercher des actualités...">
  </div>
  <div class="nav-buttons">
    <?php if(isset($_SESSION['user_id'])): ?>
      <span>Bonjour, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
      <button onclick="location.href='logout.php'">Déconnexion</button>
    <?php else: ?>
      <button onclick="location.href='login.php'">Connexion</button>
      <button onclick="location.href='register.php'">Inscription</button>
    <?php endif; ?>
    <button>Langue</button>
  </div>
</nav>

