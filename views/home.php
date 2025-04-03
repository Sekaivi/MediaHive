<?php $title = $home ?>

<!-- Section de présentation (vidéo) et bannière de séparation restent inchangées -->
<div class="presentation">
  <video controls autoplay muted loop class="presentation-video">
    <source src="<?= BASE_URL ?>/public/videos/presentation.mp4" type="video/mp4">
    Votre navigateur ne supporte pas la vidéo HTML5.
  </video>
</div>

<div class="banner">
  <img src="<?= BASE_URL ?>/public/images/Banniere.png" alt="Bannière de séparation">
</div>

<!-- Sélecteur Public / For You -->
<div class="toggle-view">
  <button id="public-btn" class="active" onclick="showArticles('public')">Public</button>
  <button id="foryou-btn" onclick="showArticles('foryou')">For You</button>
</div>


<!-- Section pour les Articles Populaires (Public) -->
<section class="carousel-section">
  <h2>Articles Populaires</h2>
  <div class="carousel-container">
    <button class="carousel-btn prev" onclick="prevSlide('popular')">&#10094;</button>
    <div class="carousel" id="carousel-popular" data-current-index="0">
      <?php foreach ($trendingArticles as $index => $article): ?>
        <div id="<?= htmlspecialchars($article['articleID']) ?>" class="article-card">
          <!-- Image centrée -->
          <img class="article-image" src="<?= $article['image'] ?>" alt="<?= htmlspecialchars($article['title']) ?>">
          <p class="source"><?= htmlspecialchars($article['feedName']) ?></p>

          <!-- Section mots clés -->
          <div class="keywords-section">
            <form class="keywords-form">

              <div class="article-keywords">
                <?php foreach ($article['keywords'] as $keyword): ?>
                  <button data-id="<?= htmlspecialchars($keyword['keywordID']) ?>" type="submit" class="keywords-btn">
                    <?= htmlspecialchars($keyword['keywordName']) ?>
                  </button>
                <?php endforeach; ?>
              </div>

              <div class="addKeywordList" <?php if (count($article['keywords']) >= 3): ?> style="display: none" <?php endif; ?>>
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
              <img src="<?= BASE_URL ?>/public/images/like1.png" alt="Like" class="btn-icon" data-hover="public/images/like2.png"
                data-clicked="public/images/like3.png">
            </button>

            <!-- Bouton Partager -->
            <button class="action-btn share-btn" title="Partager">
              <img src="<?= BASE_URL ?>/public/images/share1.png" alt="Partager" class="btn-icon" data-hover="public/images/share2.png"
                data-clicked="public/images/share3.png">
            </button>

            <!-- Bouton Voir l'article -->
            <button class="action-btn view-btn" title="Voir l'article"
              data-link="<?= htmlspecialchars($article['URL']) ?>">
              <img src="<?= BASE_URL ?>/public/images/link1.png" alt="Voir l'article" class="view-img"
                data-hover="public/images/link2.png" data-clicked="public/images/link3.png">
            </button>


            <!-- Bouton Favoris -->
            <button class="action-btn fav-btn" title="Favoris">
              <img src="<?= BASE_URL ?>/public/images/fav1.png" alt="Favoris" class="btn-icon" data-hover="public/images/fav2.png"
                data-clicked="public/images/fav3.png">
            </button>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <button class="carousel-btn next" onclick="nextSlide('popular')">&#10095;</button>
  </div>
  <!-- Barre de scroll personnalisée, draggable -->
  <div class="custom-scrollbar" id="scrollbar-popular">
    <div class="scrollbar-thumb"></div>
  </div>