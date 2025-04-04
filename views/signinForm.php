<?php if (isset($signIn)) {
    $title = $signIn;
} ?>

<div class="formPage">

    <img src="<?=BASE_URL?>/public/images/shape_1.png" alt="background shape" id="shape1" />
    <img src="<?=BASE_URL?>/public/images/shape_2.png" alt="background shape" id="shape2" />
    <img src="<?=BASE_URL?>/public/images/shape_3.png" alt="background shape" id="shape3" />
    <img src="<?=BASE_URL?>/public/images/shape_4.png" alt="background shape" id="shape4" />

    <div id="signIn">

        <?php if (isset($_SESSION['error'])): ?>
            <p class="error"><?php echo htmlspecialchars($formError);
            unset($_SESSION['error']); ?></p>
        <?php endif; ?>

        <form method="post" action="<?= BASE_URL ?>/?route=signin">

            <img id="form-logo" src="public/images/LOGO.png">
            <input type="email" name="email" id="email" placeholder="e-mail" required>

            <input type="password" name="password" placeholder="password" id="password" required>

            <p><?= $forgotQ ?></p>

            <button type="submit"><?= htmlspecialchars($signIn ?? 'error') ?></button>
        </form>
            <p id="or">OR</p>
        <p><?= htmlspecialchars($notRegisteredQ ?? 'error') ?>
            <a href="<?= BASE_URL ?>/signup"><?= htmlspecialchars($signUp ?? 'error') ?></a>.
        </p>
    </div>

</div>