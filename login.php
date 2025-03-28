<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if(empty($email) || empty($password)) {
        $message = "Tous les champs sont obligatoires.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM Users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Connexion réussie
            $_SESSION['user_id'] = $user['userID'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header("Location: index.php");
            exit;
        } else {
            $message = "Email ou mot de passe incorrect.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion</title>
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
  <h2>Connexion</h2>
  <?php if($message): ?>
    <p class="message"><?php echo htmlspecialchars($message); ?></p>
  <?php endif; ?>
  <form method="post" action="login.php">
    <label for="email">Email :</label>
    <input type="email" name="email" id="email" required>

    <label for="password">Mot de passe :</label>
    <input type="password" name="password" id="password" required>

    <button type="submit">Se connecter</button>
  </form>
  <p>Pas encore inscrit ? <a href="register.php">Créez un compte</a>.</p>
</body>
</html>

