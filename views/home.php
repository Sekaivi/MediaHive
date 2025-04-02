<?php $title = $home ?>

<h1><?= $trending ?></h1>

<div id="trendingArticles" style="display:flex; flex-wrap:wrap; gap:20px; padding:20px;">
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
          <img src="public/images/link1.png" alt="Voir l'article" class="view-img" data-hover="public/images/link2.png"
            data-clicked="public/images/link3.png">
        </button>


        <!-- Bouton Favoris -->
        <button class="action-btn fav-btn" title="Favoris">
          <img src="public/images/fav1.png" alt="Favoris" class="btn-icon" data-hover="public/images/fav2.png"
            data-clicked="public/images/fav3.png">
        </button>
      </div>
    </div>
  <?php endforeach; ?>









  <div id="newsContainer" style="display:flex; flex-wrap:wrap; gap:20px; padding:20px;">
    <?php foreach ($articles as $index => $article): ?>
      <div id="<?= htmlspecialchars($article['articleID']) ?>" class="article-card">
        <!-- Image centrée -->
        <img class="article-image" src="<?= $article['image'] ?>" alt="<?= htmlspecialchars($article['title']) ?>">
        <p class="source"><?= htmlspecialchars($article['feedName']) ?></p>

        <!-- Section mots clés -->
        <div class="keywords-section">
          <button class="add-keywords-btn" onclick="toggleKeywordOptions(<?= $index ?>)">Ajouter des mots clés (max
            3)</button>
          <div class="available-keywords" id="keyword-options-<?= $index ?>">
            <?php
            $availableKeywords = ["Culture", "Cinéma", "Anime", "Gaming", "Comics", "Musique", "Séries"];
            foreach ($availableKeywords as $keyword): ?>
              <span onclick="addKeywordToArticle(<?= $index ?>, '<?= $keyword ?>')"><?= $keyword ?></span>
            <?php endforeach; ?>
          </div>
          <div class="keywords-list" id="selected-keywords-<?= $index ?>"></div>
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
            <img src="public/images/link1.png" alt="Voir l'article" class="view-img" data-hover="public/images/link2.png"
              data-clicked="public/images/link3.png">
          </button>


          <!-- Bouton Favoris -->
          <button class="action-btn fav-btn" title="Favoris">
            <img src="public/images/fav1.png" alt="Favoris" class="btn-icon" data-hover="public/images/fav2.png"
              data-clicked="public/images/fav3.png">
          </button>
        </div>
      </div>
    <?php endforeach; ?>
  </div>