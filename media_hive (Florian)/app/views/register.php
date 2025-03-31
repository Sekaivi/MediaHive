<?php include 'header.php'; ?>
<div style="padding: 50px; text-align:center;">
  <h2>Inscription</h2>
  <form method="post" action="process_register.php">
    <label for="username">Nom d'utilisateur :</label>
    <input type="text" name="username" id="username" required><br><br>
    <label for="email">Email :</label>
    <input type="email" name="email" id="email" required><br><br>
    <label for="password">Mot de passe :</label>
    <input type="password" name="password" id="password" required><br><br>
    <label for="confirm_password">Confirmez le mot de passe :</label>
    <input type="password" name="confirm_password" id="confirm_password" required><br><br>
    <button type="submit">S'inscrire</button>
  </form>
  <p>Déjà inscrit ? <a href="index.php?page=login">Connectez-vous ici</a>.</p>
</div>
</body>
</html>

