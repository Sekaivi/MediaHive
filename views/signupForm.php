<?php if (isset($signUp)) {
    $title = $signUp;
} ?>



<?php if (isset($_SESSION['error'])): ?>
    <p class="error"><?php echo htmlspecialchars($registerError);
    unset($_SESSION['error']); ?></p>
<?php endif; ?>

<div class="formPage">

    <img src="<?=BASE_URL?>/public/images/shape_1.png" alt="background shape" id="shape1" />
    <img src="<?=BASE_URL?>/public/images/shape_2.png" alt="background shape" id="shape2" />
    <img src="<?=BASE_URL?>/public/images/shape_3.png" alt="background shape" id="shape3" />
    <img src="<?=BASE_URL?>/public/images/shape_4.png" alt="background shape" id="shape4" />

    <div id="signUp">

<form method="post" action="<?= BASE_URL ?>/?route=signup">
    <img class="form-logo" src="public/images/LOGO.png">

    <input type="text" name="username" id="username" placeholder="username" required>

    <input type="email" name="email" id="email" placeholder="email" required>

    <input type="password" name="password" id="password" placeholder="password" required>

    <input type="password" name="confirm_password" placeholder="confirm password" id="confirm_password" required>

    <button type="submit"><?= htmlspecialchars($signUp ?? 'error') ?></button>
</form>
<p id="or">OR</p>
<p><?= htmlspecialchars($registeredQ ?? 'error') ?>
    <a href="<?= BASE_URL ?>/signup"><?= htmlspecialchars($signIn ?? 'error') ?></a>
</p>
</div>

</div>