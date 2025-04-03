<?php $title = $home ?>
<!-- Section de présentation (vidéo) et bannière de séparation restent inchangées -->
<div class="presentation">
  <video controls autoplay muted loop class="presentation-video">
    <source src="public/videos/presentation.mp4" type="video/mp4">
    Votre navigateur ne supporte pas la vidéo HTML5.
  </video>
</div>

<div class="banner">
  <img src="public/images/Banniere.png" alt="Bannière de séparation">
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
    <button class="carousel-btn next" onclick="nextSlide('popular')">&#10095;</button>
  </div>
  <!-- Barre de scroll personnalisée, draggable -->
  <div class="custom-scrollbar" id="scrollbar-popular">
    <div class="scrollbar-thumb"></div>
  </div>


  <!-- Section pour les Articles Pour Vous (For You) -->
  <section class="carousel-section" id="foryou-section" style="display: none;">
    <h2>Articles Pour Vous</h2>
    <div class="carousel-container">
      <button class="carousel-btn prev" onclick="prevSlide('foryou')">&#10094;</button>
      <div class="carousel" id="carousel-foryou" data-current-index="0">
        <?php foreach ($popularForYou as $index => $article): ?>
          <div class="article-card">
            <img class="article-image" src="<?= $article['image'] ?>" alt="<?= htmlspecialchars($article['title']) ?>">
            <div class="article-content">
              <h2><?= htmlspecialchars($article['title']) ?></h2>
              <p><?= $article['description'] ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <button class="carousel-btn next" onclick="nextSlide('foryou')">&#10095;</button>
    </div>

    <!-- Indicateur de scroll -->
    <div class="scroll-indicator" id="scroll-indicator-popular">
      <div class="scroll-progress" id="scroll-progress-popular"></div>
    </div>
  </section>


  <!-- Section pour les Derniers Articles -->
  <section class="carousel-section">
    <h2>Derniers Articles</h2>
    <div class="carousel-container">
      <button class="carousel-btn prev" onclick="prevSlide('latest')">&#10094;</button>
      <div class="carousel" id="carousel-latest" data-current-index="0">
        <?php foreach ($articles as $index => $article): ?>
          <div class="article-card">
            <img class="article-image" src="<?= $article['image'] ?>" alt="<?= htmlspecialchars($article['title']) ?>">
            <div class="keywords-section">
              <button class="add-keywords-btn" onclick="toggleKeywordOptions(<?= $index ?>, 'public')">
                Ajouter des mots clés (max 3)
              </button>
              <div class="available-keywords" id="keyword-options-public-<?= $index ?>">
                <?php foreach ($availableKeywords as $keyword): ?>
                  <span onclick="addKeywordToArticle(<?= $index ?>, '<?= $keyword ?>', 'public')"><?= $keyword ?></span>
                <?php endforeach; ?>
              </div>
              <div class="keywords-list" id="selected-keywords-public-<?= $index ?>"></div>
            </div>
            <div class="article-content">
              <h2 class="article-title"><?= htmlspecialchars($article['title']) ?></h2>
              <p class="article-description"><?= $article['description'] ?></p>
            </div>
            <div class="action-buttons">
              <button class="action-btn like-btn" title="Like">
                <img src="public/images/like1.png" alt="Like" class="btn-icon" data-hover="public/images/like2.png"
                  data-clicked="public/images/like3.png">
              </button>
              <button class="action-btn share-btn" title="Partager">
                <img src="public/images/share1.png" alt="Partager" class="btn-icon" data-hover="public/images/share2.png"
                  data-clicked="public/images/share3.png">
              </button>
              <button class="action-btn view-btn" title="Voir l'article"
                onclick="window.open('<?= $article['link'] ?>', '_blank')">
                <img src="public/images/link1.png" alt="Voir l'article" class="btn-icon"
                  data-hover="public/images/link2.png" data-clicked="public/images/link3.png">
              </button>
              <button class="action-btn fav-btn" title="Favoris">
                <img src="public/images/fav1.png" alt="Favoris" class="btn-icon" data-hover="public/images/fav2.png"
                  data-clicked="public/images/fav3.png">
              </button>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <button class="carousel-btn next" onclick="nextSlide('latest')">&#10095;</button>
    </div>
  </section>

  <!-- Section pour les Articles Recommandés (affichés en liste) -->
  <section class="list-section">
    <h2>Articles Recommandés</h2>
    <div class="list">
      <?php foreach ($articles as $index => $article): ?>
        <div class="article-card">
          <img class="article-image" src="<?= $article['image'] ?>" alt="<?= htmlspecialchars($article['title']) ?>">
          <div class="keywords-section">
            <button class="add-keywords-btn" onclick="toggleKeywordOptions(<?= $index ?>, 'public')">
              Ajouter des mots clés (max 3)
            </button>
            <div class="available-keywords" id="keyword-options-public-<?= $index ?>">
              <?php foreach ($availableKeywords as $keyword): ?>
                <span onclick="addKeywordToArticle(<?= $index ?>, '<?= $keyword ?>', 'public')"><?= $keyword ?></span>
              <?php endforeach; ?>
            </div>
            <div class="keywords-list" id="selected-keywords-public-<?= $index ?>"></div>
          </div>
          <div class="article-content">
            <h2 class="article-title"><?= htmlspecialchars($article['title']) ?></h2>
            <p class="article-description"><?= $article['description'] ?></p>
          </div>
          <div class="action-buttons">
            <button class="action-btn like-btn" title="Like">
              <img src="public/images/like1.png" alt="Like" class="btn-icon" data-hover="public/images/like2.png"
                data-clicked="public/images/like3.png">
            </button>
            <button class="action-btn share-btn" title="Partager">
              <img src="public/images/share1.png" alt="Partager" class="btn-icon" data-hover="public/images/share2.png"
                data-clicked="public/images/share3.png">
            </button>
            <button class="action-btn view-btn" title="Voir l'article"
              onclick="window.open('<?= $article['link'] ?>', '_blank')">
              <img src="public/images/link1.png" alt="Voir l'article" class="btn-icon"
                data-hover="public/images/link2.png" data-clicked="public/images/link3.png">
            </button>
            <button class="action-btn fav-btn" title="Favoris">
              <img src="public/images/fav1.png" alt="Favoris" class="btn-icon" data-hover="public/images/fav2.png"
                data-clicked="public/images/fav3.png">
            </button>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <script>
    function showArticles(type) {
      const publicBtn = document.getElementById("public-btn");
      const forYouBtn = document.getElementById("foryou-btn");
      const publicSection = document.getElementById("popular-section");
      const forYouSection = document.getElementById("foryou-section");

      if (type === "public") {
        publicSection.style.display = "block";
        forYouSection.style.display = "none";
        publicBtn.classList.add("active");
        forYouBtn.classList.remove("active");
      } else {
        publicSection.style.display = "none";
        forYouSection.style.display = "block";
        publicBtn.classList.remove("active");
        forYouBtn.classList.add("active");
      }
    }

  </script>