<?php $title = $profile ?>


<div id="profile-info">

    <img src="<?= $source ?? '' ?>" alt="profile picture of <?= htmlspecialchars($_SESSION['username']) ?>" />

    <h1 id="username"><?= htmlspecialchars($user['username']) ?></h1>

    <p><?= htmlspecialchars($user['bio']) ?></p>

    <p>Feed list</p>
    <ul>
        <?php foreach ($rssFeeds as $feed): ?>
            <li><?= htmlspecialchars($feed['feedName']) ?></li>
        <?php endforeach; ?>
    </ul>

    <p><?= $preferences ?></p>
    <ul>
        <?php if (empty($setPrefs)): ?>
            <p><?= htmlspecialchars($noPreferences) ?></p>
        <?php else: ?>
            <?php foreach ($setPrefs as $feed): ?>
                <li><?= htmlspecialchars($feed['feedName']) ?></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>

    <p><?= $bookmarks ?></p>

    <?php if (empty($currentBookmarks)): ?>
        <p><?= htmlspecialchars($noBookmarks) ?></p>
    <?php else: ?>
        <?php foreach ($currentBookmarks as $article): ?>
            <li><?= var_dump($article) ?></li>
        <?php endforeach; ?>
    <?php endif; ?>

    <button id="edit-profile">Edit</button>

</div>


<form id="profile-form" style="display:none;">
    <input type="text" name="profilePicture" id="input-profilePicture" value="<?= htmlspecialchars($user['profilePicture']) ?>">
    <input type="text" name="username" id="input-username" value="<?= htmlspecialchars($user['username']) ?>" required>
    <input type="email" name="email" id="input-email" value="<?= htmlspecialchars($user['email']) ?>" required>
    <textarea name="bio" id="input-bio"><?= htmlspecialchars($user['bio']) ?></textarea>
    <button type="submit">Save</button>
</form>

<p id="message"></p>