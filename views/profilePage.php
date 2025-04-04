<?php $title = $profile ?>

<div id="profile">
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

    <div class="toggle-view">
        <button onclick="display_preferences()" id="preferences-btn" class="active"><?= $preferences ?></button>
        <div class="separator">|</div>
        <button onclick="display_bookmarks()" id="bookmarks-btn">Bookmarks</button>
    </div>
    <p id="message" class="error"></p>

    <section id="preferences-section">
        <?= $infoPref ?>
        <form id="feed-form">
            <div class="flex-container">
                <input type="text" id="feed-search" placeholder="Search feeds..." autocomplete="off">
                <button type="submit">Save</button>
            </div>
            <select id="feed-list" name="feed-list">
                <?php foreach ($rssFeeds as $feed): ?>
                    <option value="<?= htmlspecialchars($feed['feedID']) ?>"
                        data-name="<?= htmlspecialchars($feed['feedName']) ?>">
                        <?= htmlspecialchars($feed['feedName']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>

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
    </section>

    <section id="bookmarks-section" style="display: none" class="carousel-section">
        <?php if (empty($currentBookmarks)): ?>
            <p><?= htmlspecialchars($noBookmarks) ?></p>
        <?php else: ?>
            <div class="carousel-container">
                <button class="carousel-btn prev" onclick="prevSlide('carousel-latest')">&#10094;</button>
                <div class="carousel" id="carousel-latest" data-current-index="0">
                <?php foreach ($currentBookmarks as $article): ?>
                    <div id="<?= htmlspecialchars($article['articleID']) ?>" class="article-card">
                        <!-- Image centrée -->
                        <img class="article-image" src="<?= $article['image'] ?>"
                            alt="<?= htmlspecialchars($article['title']) ?>" onerror="this.remove();">

                        <p class="source"><?= htmlspecialchars($article['feedName']) ?></p>

                        <!-- Section mots clés -->
                        <div class="keywords-section">
                            <form class="keywords-form">
                                <div class="article-keywords">
                                    <?php foreach ($article['keywords'] as $keyword): ?>
                                        <button data-id="<?= htmlspecialchars($keyword['keywordID']) ?>" type="submit"
                                            class="keywords-btn">
                                            <?= htmlspecialchars($keyword['keywordName']) ?>
                                        </button>
                                    <?php endforeach; ?>
                                </div>

                                <div class="addKeywordList" <?php if (count($article['keywords']) >= 3): ?> style="display: none"
                                    <?php endif; ?>>
                                    <select class="keyword-list" name="keyword-list">
                                        <?php foreach ($keyword_list as $keyword): ?>
                                            <option value="<?= htmlspecialchars($keyword['keywordID']) ?>"
                                                data-name="<?= htmlspecialchars($keyword['keywordName']) ?>">
                                                <?= htmlspecialchars($keyword['keywordName']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="submit" class="keywords-btn"><?= htmlspecialchars($addKeywords) ?></button>
                                </div>
                            </form>
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
                                <img src="<?= BASE_URL ?>/public/images/like1.png" alt="Like" class="btn-icon"
                                    data-hover="<?= BASE_URL ?>/public/images/like2.png"
                                    data-clicked="<?= BASE_URL ?>/public/images/like3.png"
                                    data-default="<?= BASE_URL ?>/public/images/like1.png">
                            </button>

                            <!-- Bouton Partager -->
                            <button class="action-btn share-btn" title="Partager">
                                <img src="<?= BASE_URL ?>/public/images/share1.png" alt="Partager" class="btn-icon"
                                    data-hover="<?= BASE_URL ?>/public/images/share2.png"
                                    data-clicked="<?= BASE_URL ?>/public/images/share3.png"
                                    data-default="<?= BASE_URL ?>/public/images/share1.png">
                            </button>

                            <!-- Bouton Voir l'article -->
                            <button class="action-btn view-btn" title="Voir l'article"
                                data-link="<?= htmlspecialchars($article['URL']) ?>">
                                <img src="<?= BASE_URL ?>/public/images/link1.png" alt="Voir l'article" class="view-img"
                                    data-hover="<?= BASE_URL ?>/public/images/link2.png"
                                    data-clicked="<?= BASE_URL ?>/public/images/link3.png"
                                    data-default="<?= BASE_URL ?>/public/images/link1.png">
                            </button>

                            <!-- Bouton Favoris -->
                            <button class="action-btn fav-btn" title="Favoris">
                                <img src="<?= BASE_URL ?>/public/images/fav1.png" alt="Favoris" class="btn-icon"
                                    data-hover="<?= BASE_URL ?>/public/images/fav2.png"
                                    data-clicked="<?= BASE_URL ?>/public/images/fav3.png"
                                    data-default="<?= BASE_URL ?>/public/images/fav1.png" />
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button class="carousel-btn next" onclick="nextSlide('carousel-latest')">&#10095;</button>
            <!-- Barre de scroll personnalisée, draggable -->
            <div class="custom-scrollbar" id="scrollbar-carousel-latest">
                <div class="scrollbar-thumb"></div>
            </div>
        <?php endif; ?>
    </section>



    <form id="profile-form" style="display:none;">
        <input type="text" name="profilePicture" id="input-profilePicture"
            value="<?= htmlspecialchars($user['profilePicture']) ?>">
        <input type="text" name="username" id="input-username" value="<?= htmlspecialchars($user['username']) ?>"
            required>
        <input type="email" name="email" id="input-email" value="<?= htmlspecialchars($user['email']) ?>" required>
        <textarea name="bio" id="input-bio"><?= htmlspecialchars($user['bio']) ?></textarea>
        <button type="submit">Save</button>
    </form>

    <p id="message"></p>