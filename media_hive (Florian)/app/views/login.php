<?php include 'header.php'; ?>
<div style="padding: 50px; text-align:center;">
  <form method="post" action="process_login.php">
    <img class="site-logo" src="public/images/LOGO.png">
    <label for="email">Email :</label>
    <input type="email" name="email" id="email" required><br><br>
    <label for="password">Mot de passe :</label>
    <input type="password" name="password" id="password" required><br><br>
    <button type="submit">Se connecter</button>
  </form>
  <p>Pas encore inscrit ? <a href="index.php?page=register">Créez un compte</a>.</p>
</div>
</body>
</html>

