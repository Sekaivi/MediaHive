<?php if (isset($signUp)) {
    $title = $signUp;
} ?>


<h2><?= htmlspecialchars($title ?? 'Error while rendering') ?></h2>

<?php if (isset($_SESSION['error'])): ?>
    <p class="error"><?php echo htmlspecialchars($registerError);
    unset($_SESSION['error']); ?></p>
<?php endif; ?>



<form method="post" action="<?= BASE_URL ?>/?route=signup">
    <img class="site-logo" src="public/images/LOGO.png">

    <label for="username"><?= htmlspecialchars($username ?? 'error') ?></label>
    <input type="text" name="username" id="username" required>

    <label for="email"><?= htmlspecialchars($email ?? 'error') ?></label>
    <input type="email" name="email" id="email" required>

    <label for="password"><?= htmlspecialchars($password ?? 'error') ?></label>
    <input type="password" name="password" id="password" required>

    <label for="confirm_password"><?= htmlspecialchars($confirmPassword ?? 'error') ?></label>
    <input type="password" name="confirm_password" id="confirm_password" required>

    <button type="submit"><?= htmlspecialchars($signUp ?? 'error') ?></button>
</form>

<p><?= htmlspecialchars($registeredQ ?? 'error') ?>
    <a href="<?= BASE_URL ?>/signup"><?= htmlspecialchars($signIn ?? 'error') ?></a>.
</p>