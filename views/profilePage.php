<?php $title = $profile ?>


<div id="profile-info">

    <img id="profilePicture" src="<?= $source ?? '' ?>"
        alt="profile picture of <?= htmlspecialchars($_SESSION['username']) ?>" />

    <h1 id="username"><?= htmlspecialchars($user['username']) ?></h1>

    <p id="bio"><?= htmlspecialchars($user['bio']) ?></p>

    <button id="edit-profile"><?= $editProfile ?></button>

    <p><?= $preferences ?></p>
    <form id="feed-form">
        <label for="feed-search">Search Feed</label>
        <input type="text" id="feed-search" placeholder="Search feeds..." autocomplete="off">

        <label for="feed-list">Feed list</label>
        <select id="feed-list" name="feed-list">
            <?php foreach ($rssFeeds as $feed): ?>
                <option value="<?= htmlspecialchars($feed['feedID']) ?>"
                    data-name="<?= htmlspecialchars($feed['feedName']) ?>">
                    <?= htmlspecialchars($feed['feedName']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Save</button>
    </form>

    <p id="message" class="error"></p>

    <ul id="preferences-list">
        <?php if (empty($setPrefs)): ?>
            <p id="noPref"><?= htmlspecialchars($noPreferences) ?></p>
        <?php else: ?>
            <?php foreach ($setPrefs as $feed): ?>

                <form id="<?= htmlspecialchars($feed['id']) ?>" class="delete-pref">
                    <li> <?= htmlspecialchars($feed['feedName']) ?></li>
                    <button type="submit">Delete</button>
                </form>

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

</div>


<form id="profile-form" style="display:none;">
    <input type="text" name="profilePicture" id="input-profilePicture"
        value="<?= htmlspecialchars($user['profilePicture']) ?>">
    <input type="text" name="username" id="input-username" value="<?= htmlspecialchars($user['username']) ?>" required>
    <input type="email" name="email" id="input-email" value="<?= htmlspecialchars($user['email']) ?>" required>
    <textarea name="bio" id="input-bio"><?= htmlspecialchars($user['bio']) ?></textarea>
    <button type="submit">Save</button>
</form>

<p id="message"></p>