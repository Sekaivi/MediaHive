<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if(empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        $message = "Tous les champs sont obligatoires.";
    } elseif ($password !== $confirmPassword) {
        $message = "Les mots de passe ne correspondent pas.";
    } else {
        // Vérifier si l'email est déjà utilisé
        $stmt = $pdo->prepare("SELECT * FROM Users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $message = "Cet email est déjà utilisé.";
        } else {
            // Insérer le nouvel utilisateur
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO Users (username, email, password) VALUES (?, ?, ?)");
            if ($stmt->execute([$username, $email, $hashedPassword])) {
                header("Location: login.php");
                exit;
            } else {
                $message = "Erreur lors de l'inscription. Réessayez plus tard.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Inscription</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 50px;
      text-align: center;
      background-color: #f4f4f4;
    }
    form {
      display: inline-block;
      text-align: left;
      background: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    input {
      margin: 5px 0;
      padding: 8px;
      width: 100%;
      box-sizing: border-box;
    }
    button {
      padding: 10px 20px;
      margin-top: 10px;
      cursor: pointer;
      width: 100%;
    }
    .message {
      color: red;
    }
.navbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      background-color: #333;
      padding: 10px 20px;
      color: #fff;
    }
    .navbar .logo {
      font-size: 1.5em;
      font-weight: bold;
    }
    .navbar .search-container {
      flex: 1;
      margin: 0 20px;
    }
    .navbar .search-container input[type="text"] {
      width: 100%;
      padding: 8px;
      border: none;
      border-radius: 3px;
    }
    .navbar .nav-buttons {
      display: flex;
      align-items: center;
    }
    .navbar .nav-buttons button {
      background-color: #555;
      color: #fff;
      border: none;
      padding: 8px 12px;
      margin-left: 10px;
      border-radius: 3px;
      cursor: pointer;
    }
    .navbar .nav-buttons button:hover {
      background-color: #777;
    }
  </style>
</head>
<body>
  <?php include 'header.php'; ?>
  <h2>Créer un compte</h2>
  <?php if($message): ?>
    <p class="message"><?php echo htmlspecialchars($message); ?></p>
  <?php endif; ?>
  <form method="post" action="register.php">
    <label for="username">Nom d'utilisateur :</label>
    <input type="text" name="username" id="username" required>

    <label for="email">Email :</label>
    <input type="email" name="email" id="email" required>

    <label for="password">Mot de passe :</label>
    <input type="password" name="password" id="password" required>

    <label for="confirm_password">Confirmez le mot de passe :</label>
    <input type="password" name="confirm_password" id="confirm_password" required>

    <button type="submit">S'inscrire</button>
  </form>
  <p>Déjà inscrit ? <a href="login.php">Connectez-vous ici</a>.</p>
</body>
</html>

