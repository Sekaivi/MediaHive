<?php $title = $profile ?>

<div id="profile-info">
    <img id="profilePicture" src="<?= $user['profilePicture'] ?? '' ?>"
        alt="profile picture of <?= htmlspecialchars($_SESSION['username']) ?>" />
    <div class="flex-container">
        <div class="flex-container">
            <h1 id="username"><?= htmlspecialchars($user['username']) ?></h1>
            <button id="edit-profile"><?= $editProfile ?></button>
        </div>

        <p id="bio"><?= htmlspecialchars($user['bio']) ?></p>
    </div>
</div>

<p><?= $preferences ?></p>
<form id="feed-form">
    <label for="feed-search">Search Feed</label>
    <input type="text" id="feed-search" placeholder="Search feeds..." autocomplete="off">

    <label for="feed-list">Feed list</label>
    <select id="feed-list" name="feed-list">
        <?php foreach ($rssFeeds as $feed): ?>
            <option value="<?= htmlspecialchars($feed['feedID']) ?>" data-name="<?= htmlspecialchars($feed['feedName']) ?>">
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

<?php var_dump($currentBookmarks) ?>

<p><?= $bookmarks ?></p>

<?php if (empty($currentBookmarks)): ?>
    <p><?= htmlspecialchars($noBookmarks) ?></p>
<?php else: ?>
    <?php foreach ($currentBookmarks as $article): ?>
        <div id="<?= htmlspecialchars($article['articleID']) ?>" class="article-card">
            <!-- Image centrée -->
            <img class="article-image" src="<?= $article['image'] ?>" alt="<?= htmlspecialchars($article['title']) ?>"
                onerror="this.remove();">

            <p class="source"><?= htmlspecialchars($article['feedName']) ?></p>

            <!-- Section mots clés -->
            <div class="keywords-section">
                <button class="add-keywords-btn">Ajouter des mots clés (max3)</button>
            </div>

            <!-- Contenu de l'article -->
            <div class="article-content">
                <h2 class="article-title"><?= htmlspecialchars($article['title']) ?></h2>
                <p class="article-description"><?= $article['description'] ?></p>
            </div>

            <!-- Boutons d'action -->
            <div class="action-buttons">
                <!-- Bouton Like -->
                <button class="action-btn like-btn" title="Like">
                    <img src="public/images/like1.png" alt="Like" class="btn-icon" data-hover="public/images/like2.png"
                        data-clicked="public/images/like3.png">
                </button>

                <!-- Bouton Partager -->
                <button class="action-btn share-btn" title="Partager">
                    <img src="public/images/share1.png" alt="Partager" class="btn-icon" data-hover="public/images/share2.png"
                        data-clicked="public/images/share3.png">
                </button>

                <!-- Bouton Voir l'article -->
                <button class="action-btn view-btn" title="Voir l'article" data-link="<?= htmlspecialchars($article['URL']) ?>">
                    <img src="public/images/link1.png" alt="Voir l'article" class="view-img"
                        data-hover="public/images/link2.png" data-clicked="public/images/link3.png">
                </button>


                <!-- Bouton Favoris -->
                <button class="action-btn fav-btn" title="Favoris">
                    <img src="public/images/fav1.png" alt="Favoris" class="btn-icon" data-hover="public/images/fav2.png"
                        data-clicked="public/images/fav3.png">
                </button>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>




<form id="profile-form" style="display:none;">
    <input type="text" name="profilePicture" id="input-profilePicture"
        value="<?= htmlspecialchars($user['profilePicture']) ?>">
    <input type="text" name="username" id="input-username" value="<?= htmlspecialchars($user['username']) ?>" required>
    <input type="email" name="email" id="input-email" value="<?= htmlspecialchars($user['email']) ?>" required>
    <textarea name="bio" id="input-bio"><?= htmlspecialchars($user['bio']) ?></textarea>
    <button type="submit">Save</button>
</form>

<p id="message"></p>