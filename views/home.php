<?php $title = $home ?>

<!-- Section de présentation (vidéo) et bannière de séparation restent inchangées -->
<div class="video-container">
  <video id="my-video" controls muted loop preload="metadata"
    poster="<?= BASE_URL ?>/public/images/poster_presentation.png" class="video">
    <source src="<?= BASE_URL ?>/public/videos/presentation.mp4" type="video/mp4">
    <?= $novideoSupport ?>
  </video>
  <div class="play-button" onclick="playVideo()">
    <p>▶</p>
  </div>
</div>

<div class="banner">
  <img src="<?= BASE_URL ?>/public/images/Banniere.png" alt="Bannière de séparation">
</div>

<!-- Sélecteur Public / For You -->
<div class="toggle-view">
  <button onclick="display_mediahive_reco()" id="public-btn" class="active">Public</button>
  <div class="separator">|</div>
  <button id="foryou-btn" <?= !isset($_SESSION['logged_in']) ? 'onclick="displayModal(\'' . $connexionRequired . '\')"' : 'onclick="display_user_reco()"' ?>>
    For You
  </button>

</div>

<?php if (isset($_SESSION['logged_in'])): ?>
  <section style="display: none;" id="userReco" class="carousel-section">
    <img class="section_title" src="<?= BASE_URL ?>/public/images/user_recommendations.png" alt="For you <3">
    <div class="carousel-container">
      <button class="carousel-btn prev" onclick="prevSlide('carousel-userPref')">&#10094;</button>
      <div class="carousel" id="carousel-userPref" data-current-index="0">
        <?php foreach ($preferences as $article): ?>
          <div id="<?= htmlspecialchars($article['articleID']) ?>" class="article-card">
            <!-- Image centrée -->
            <img class="article-image" src="<?= $article['image'] ?>" alt="<?= htmlspecialchars($article['title']) ?>"
              onerror="this.remove();">

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
                data-default="<?= BASE_URL ?>/public/images/fav1.png"/>
            </button>
          </div>
          </div>
        <?php endforeach; ?>
      </div>
      <button class="carousel-btn next" onclick="nextSlide('carousel-userPref')">&#10095;</button>
    </div>
    <!-- Barre de scroll personnalisée, draggable -->
    <div class="custom-scrollbar" id="scrollbar-carousel-userPref">
      <div class="scrollbar-thumb"></div>
    </div>
  </section>
<?php endif; ?>

<section id="mediahiveReco" class="carousel-section">
  <img class="section_title" src="<?= BASE_URL ?>/public/images/recommendations_mediahive.png"
    alt="Recommendations by MediaHive">
  <div class="carousel-container">
    <button class="carousel-btn prev" onclick="prevSlide('carousel-mediahive')">&#10094;</button>
    <div class="carousel" id="carousel-mediahive" data-current-index="0">
      <?php foreach ($MediaHiveReco as $article): ?>
        <div id="<?= htmlspecialchars($article['articleID']) ?>" class="article-card">
          <!-- Image centrée -->
          <img class="article-image" src="<?= $article['image'] ?>" alt="<?= htmlspecialchars($article['title']) ?>"
            onerror="this.remove();">

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
            <p class="article-description"><?= $article['review'] ?></p>
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
                data-default="<?= BASE_URL ?>/public/images/fav1.png"/>
            </button>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <button class="carousel-btn next" onclick="nextSlide('carousel-mediahive')">&#10095;</button>
  </div>
  <!-- Barre de scroll personnalisée, draggable -->
  <div class="custom-scrollbar" id="scrollbar-carousel-mediahive">
    <div class="scrollbar-thumb"></div>
  </div>
</section>

<section id="latest-news" class="carousel-section">
  <img class="section_title" src="<?= BASE_URL ?>/public/images/latest.png" alt="Recommendations by MediaHive">
  <div class="carousel-container">
    <button class="carousel-btn prev" onclick="prevSlide('carousel-latest')">&#10094;</button>
    <div class="carousel" id="carousel-latest" data-current-index="0">
      <?php foreach ($articles as $article): ?>
        <div id="<?= htmlspecialchars($article['articleID']) ?>" class="article-card">
          <!-- Image centrée -->
          <img class="article-image" src="<?= $article['image'] ?>" alt="<?= htmlspecialchars($article['title']) ?>"
            onerror="this.remove();">

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
                data-default="<?= BASE_URL ?>/public/images/fav1.png"/>
            </button>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <button class="carousel-btn next" onclick="nextSlide('carousel-latest')">&#10095;</button>
  </div>
  <!-- Barre de scroll personnalisée, draggable -->
  <div class="custom-scrollbar" id="scrollbar-carousel-latest">
    <div class="scrollbar-thumb"></div>
  </div>
</section>

<section id="popular-articles" class="carousel-section">
  <img class="section_title" src="<?= BASE_URL ?>/public/images/trending.png" alt="Recommendations by MediaHive">
  <div class="carousel-container">
    <button class="carousel-btn prev" onclick="prevSlide('carousel-popular')">&#10094;</button>
    <div class="carousel" id="carousel-popular" data-current-index="0">
      <?php foreach ($trendingArticles as $index => $article): ?>
        <div id="<?= htmlspecialchars($article['articleID']) ?>" class="article-card">
          <!-- Image centrée -->
          <img class="article-image" src="<?= $article['image'] ?>" alt="<?= htmlspecialchars($article['title']) ?>"
            onerror="this.remove();">

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
          
          <div class="action-buttons">
          <?php if (isset($_SESSION['logged_in'])): ?>
            <!-- Bouton Like -->
            <button class="action-btn like-btn" title="Like">
              <img src="<?= BASE_URL ?>/public/images/like1.png" alt="Like" class="btn-icon"
                data-hover="<?= BASE_URL ?>/public/images/like2.png" 
                data-clicked="<?= BASE_URL ?>/public/images/like3.png"
                data-default="<?= BASE_URL ?>/public/images/like1.png">
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
                data-default="<?= BASE_URL ?>/public/images/fav1.png"/>
            </button>
            <?php endif ?>
            <!-- Bouton Partager -->
            <button class="action-btn share-btn" title="Partager">
              <img src="<?= BASE_URL ?>/public/images/share1.png" alt="Partager" class="btn-icon"
                data-hover="<?= BASE_URL ?>/public/images/share2.png" 
                data-clicked="<?= BASE_URL ?>/public/images/share3.png"
                data-default="<?= BASE_URL ?>/public/images/share1.png">
            </button>
          </div>

        </div>
      <?php endforeach; ?>
    </div>
    <button class="carousel-btn next" onclick="nextSlide('carousel-popular')">&#10095;</button>
  </div>
  <!-- Barre de scroll personnalisée, draggable -->
  <div class="custom-scrollbar" id="scrollbar-carousel-popular">
    <div class="scrollbar-thumb"></div>
  </div>
</section>