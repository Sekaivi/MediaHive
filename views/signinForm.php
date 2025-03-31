<?php if (isset($signIn)) {
    $title = $signIn;
} ?>


<h2><?= htmlspecialchars($title ?? 'Error while rendering') ?></h2>

<?php if (isset($_SESSION['error'])): ?>
    <p class="error"><?php echo htmlspecialchars($formError);
    unset($_SESSION['error']); ?></p>
<?php endif; ?>

<form method="post" action="<?= BASE_URL ?>/signin">

    <img class="site-logo" src="public/images/LOGO.png">
    <label for="email"><?= htmlspecialchars($email ?? 'error') ?></label>
    <input type="email" name="email" id="email" required>

    <label for="password"><?= htmlspecialchars($password ?? 'error') ?></label>
    <input type="password" name="password" id="password" required>

    <button type="submit"><?= htmlspecialchars($signIn ?? 'error') ?></button>
</form>

<p><?= htmlspecialchars($notRegisteredQ ?? 'error') ?>
    <a href="<?= BASE_URL ?>/signup"><?= htmlspecialchars($signUp ?? 'error') ?></a>.
</p>