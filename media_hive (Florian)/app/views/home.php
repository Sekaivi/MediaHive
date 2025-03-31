<?php include 'header.php'; ?>
<div id="newsContainer" style="display:flex; flex-wrap:wrap; gap:20px; padding:20px;">
  <?php foreach($articles as $index => $article): ?>
    <div class="article-card">
      <!-- Image centrée -->
      <img class="article-image" src="<?= $article['image'] ?>" alt="<?= htmlspecialchars($article['title']) ?>">
      
      <!-- Section mots clés -->
      <div class="keywords-section">
        <button class="add-keywords-btn" onclick="toggleKeywordOptions(<?= $index ?>)">Ajouter des mots clés (max 3)</button>
        <div class="available-keywords" id="keyword-options-<?= $index ?>">
          <?php 
            $availableKeywords = ["Culture", "Cinéma", "Anime", "Gaming", "Comics", "Musique", "Séries"];
            foreach($availableKeywords as $keyword): ?>
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
        <img 
          src="public/images/like1.png" 
          alt="Like" 
          class="btn-icon" 
          data-hover="public/images/like2.png" 
          data-clicked="public/images/like3.png"
        >
      </button>
      
      <!-- Bouton Partager -->
      <button class="action-btn share-btn" title="Partager">
        <img 
          src="public/images/share1.png" 
          alt="Partager" 
          class="btn-icon" 
          data-hover="public/images/share2.png" 
          data-clicked="public/images/share3.png"
        >
      </button>

      <!-- Bouton Voir l'article -->
      <button class="action-btn view-btn" title="Voir l'article" onclick="window.open('<?= $article['link'] ?>', '_blank')">
        <img 
          src="public/images/link1.png" 
          alt="Voir l'article" 
          class="view-btn" 
          data-hover="public/images/link2.png" 
          data-clicked="public/images/link3.png"
        >
      </button>

      <!-- Bouton Favoris -->
      <button class="action-btn fav-btn" title="Favoris">
        <img 
          src="public/images/fav1.png" 
          alt="Favoris" 
          class="btn-icon" 
          data-hover="public/images/fav2.png" 
          data-clicked="public/images/fav3.png"
        >
      </button>
    </div>
    </div>
  <?php endforeach; ?>
</div>

<script>
  // Gestion de l'affichage/masquage des options de mots clés
  function toggleKeywordOptions(index) {
    var optionsDiv = document.getElementById('keyword-options-' + index);
    optionsDiv.style.display = (optionsDiv.style.display === 'flex') ? 'none' : 'flex';
  }

  // Ajout d'un mot clé à la carte (limite 3)
  function addKeywordToArticle(index, keyword) {
    var selectedDiv = document.getElementById('selected-keywords-' + index);
    // Vérifie si le mot clé existe déjà
    var exists = Array.from(selectedDiv.children).some(span => span.textContent === keyword);
    if (exists) return;
    if (selectedDiv.children.length < 3) {
      var span = document.createElement('span');
      span.textContent = keyword;
      selectedDiv.appendChild(span);
    } else {
      alert("Vous avez atteint la limite de 3 mots clés.");
    }
  }

  // Fonction générique pour basculer l'état "active" d'un bouton et afficher un message
  function toggleActive(btn, message) {
    btn.classList.toggle("active");
    if(message) alert(message);
  }

document.addEventListener('DOMContentLoaded', () => {
  // Sélection de tous les boutons ayant la classe .action-btn
  const actionButtons = document.querySelectorAll('.action-btn');

  actionButtons.forEach(button => { 
    const img = button.querySelector('img.btn-icon');
    if (!img) return;

    // État initial
    let isClicked = false;
    const normalSrc = img.getAttribute('src');
    const hoverSrc = img.getAttribute('data-hover');
    const clickedSrc = img.getAttribute('data-clicked');

    // Gestion du survol (hover)
    button.addEventListener('mouseover', () => {
      if (!isClicked && hoverSrc) {
        img.src = hoverSrc;
      }
    });
    button.addEventListener('mouseout', () => {
      if (!isClicked) {
        img.src = normalSrc;
      }
    });

    // Gestion du clic
    button.addEventListener('click', () => {
      // Basculer l'état cliqué
      isClicked = !isClicked;
      if (isClicked && clickedSrc) {
        img.src = clickedSrc;
      } else {
        img.src = normalSrc;
      }
    });
  });
});

</script>
</body>
</html>

