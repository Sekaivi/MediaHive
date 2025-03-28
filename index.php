<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Accueil - Pop Culture News</title>
  <style>
    /* Styles généraux pour la page */
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
    }
    /* Barre de navigation */
    .navbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      background-color: #333;
      padding: 10px 20px;
      color: #fff;
    }
    .navbar .logo {
      font-size: 1.5em;
      font-weight: bold;
    }
    .navbar .search-container {
      flex: 1;
      margin: 0 20px;
    }
    .navbar .search-container input[type="text"] {
      width: 100%;
      padding: 8px;
      border: none;
      border-radius: 3px;
    }
    .navbar .nav-buttons {
      display: flex;
      align-items: center;
    }
    .navbar .nav-buttons button {
      background-color: #555;
      color: #fff;
      border: none;
      padding: 8px 12px;
      margin-left: 10px;
      border-radius: 3px;
      cursor: pointer;
    }
    .navbar .nav-buttons button:hover {
      background-color: #777;
    }
    /* Conteneur d'articles */
    #newsContainer {
      padding: 20px;
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
    }
    /* Modèle de la carte d'article */
    .article-card {
      width: 320px;
      background: #fff;
      border: 1px solid #ddd;
      border-radius: 5px;
      overflow: hidden;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      font-family: Arial, sans-serif;
      display: flex;
      flex-direction: column;
    }
    .article-card img.article-image {
      margin: 10px auto 0;
      width: 90%;
      height: auto;
      display: block;
      border-radius:5px;
    }
    .keywords-section {
      padding: 10px;
      border-bottom: 1px solid #eee;
      display: flex;
      flex-direction: column;
      gap: 5px;
    }
    .add-keywords-btn {
      background-color: #007BFF;
      color: #fff;
      border: none;
      padding: 6px 10px;
      border-radius: 4px;
      cursor: pointer;
      font-size: 0.9em;
    }
    .keywords-list {
      display: flex;
      flex-wrap: wrap;
      gap: 5px;
    }
    .keyword {
      background: #f1f1f1;
      padding: 3px 6px;
      border-radius: 3px;
      font-size: 0.8em;
    }
    .article-content {
      padding: 10px;
      flex: 1;
    }
    .article-title {
      font-size: 1.2em;
      margin: 0 0 8px;
    }
    .article-description {
      font-size: 0.95em;
      color: #555;
      margin: 0 0 10px;
    }
    .action-buttons {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 8px 10px;
      border-top: 1px solid #eee;
    }
    .action-buttons button {
      background: none;
      border: none;
      cursor: pointer;
      padding: 5px;
      display: flex;
      align-items: center;
      gap: 4px;
      font-size: 0.9em;
      color: #333;
    }
    .action-buttons button:hover {
      color: #007BFF;
    }
    /* Styles des icônes (exemple SVG) */
    .icon {
      width: 18px;
      height: 18px;
      fill: #333;
    }
  </style>
</head>
<body>
  <!-- Barre de navigation -->
  <nav class="navbar">
    <div class="logo">Pop Culture News</div>
    <div class="search-container">
      <input type="text" placeholder="Rechercher des actualités...">
    </div>
    <div class="nav-buttons">
      <!-- Si l'utilisateur est connecté, on affiche son prénom et un bouton déconnexion, sinon connexion/inscription -->
      <?php
      session_start();
      if(isset($_SESSION['user_id'])):
      ?>
        <span>Bonjour, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
        <button onclick="location.href='logout.php'">Déconnexion</button>
      <?php else: ?>
        <button onclick="location.href='login.php'">Connexion</button>
        <button onclick="location.href='register.php'">Inscription</button>
      <?php endif; ?>
      <button>Langue</button>
    </div>
  </nav>

  <!-- Conteneur des articles -->
  <div id="newsContainer">
    <!-- Les articles seront insérés ici dynamiquement -->
  </div>

  <script>
    // Définition des URL RSS (exemple, à adapter)
    const RSS_URLS = {
      "cinema": "https://www.allocine.fr/rss/news.xml",
      "jeux-video": "https://www.jeuxvideo.com/rss/rss.xml",
      "anime": "https://news.google.com/rss/search?tbm=nws&q=manga&oq=manga&scoring=n&hl=fr&gl=FR&ceid=FR:fr",
      "comics": "https://www.comicbookmovie.com/rss/"
    };

    // Fonction pour récupérer et traiter les flux RSS
    async function fetchRSS(category = "all") {
      let proxyUrl = "https://api.allorigins.win/get?url=";
      let urls = category === "all" ? Object.values(RSS_URLS) : [RSS_URLS[category]];
      let articles = [];

      for (let url of urls) {
        try {
          let response = await fetch(proxyUrl + encodeURIComponent(url));
          let data = await response.json();
          let parser = new DOMParser();
          let xml = parser.parseFromString(data.contents, "text/xml");

          let items = xml.querySelectorAll("item");
          items.forEach(item => {
            // Récupération de l'image : d'abord via <enclosure>, sinon via <media:content>
            let image = item.querySelector("enclosure")?.getAttribute("url");
            if (!image) {
              image = item.querySelector("media\\:content")?.getAttribute("url");
            }
            if (!image) {
              image = "https://via.placeholder.com/320x180";
            }

            articles.push({
              title: item.querySelector("title")?.textContent || "Titre indisponible",
              link: item.querySelector("link")?.textContent || "#",
              description: item.querySelector("description")?.textContent || "",
              image: image
            });
          });
        } catch (error) {
          console.error("Erreur lors du chargement RSS :", error);
        }
      }
      displayArticles(articles);
    }

    // Fonction pour afficher les articles avec le modèle de carte personnalisé
    function displayArticles(articles) {
      const newsContainer = document.getElementById("newsContainer");
      newsContainer.innerHTML = "";
      articles.forEach(article => {
        // Création de la carte
        const card = document.createElement("div");
        card.className = "article-card";
        card.innerHTML = `
          <!-- Image de l'article -->
          <img class="article-image" src="${article.image}" alt="${article.title}">
          
          <!-- Section pour ajouter des mots clés -->
          <div class="keywords-section">
            <button class="add-keywords-btn" onclick="ajouterMotCle(this)">Ajouter des mots-clés (max 3)</button>
            <div class="keywords-list"></div>
          </div>
          
          <!-- Contenu de l'article -->
          <div class="article-content">
            <h2 class="article-title">${article.title}</h2>
            <p class="article-description">${article.description}</p>
          </div>
          
          <!-- Boutons d'action -->
          <div class="action-buttons">
            <button title="Like" onclick="likeArticle()">
              <svg class="icon" viewBox="0 0 24 24">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
              </svg>
            </button>
            <button title="Partager" onclick="partagerArticle()">
              <svg class="icon" viewBox="0 0 24 24">
                <path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7c.05-.23.09-.46.09-.7 0-.24-.04-.47-.09-.7l7.02-4.11c.53.5 1.23.81 2.07.81 1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3c0 .24.04.47.09.7L8.91 9.81C8.38 9.31 7.68 9 6.84 9 5.18 9 3.84 10.34 3.84 12s1.34 3 2.99 3c.84 0 1.54-.31 2.07-.81l7.13 4.18c-.05.21-.08.43-.08.66 0 1.66 1.34 3 3 3s3-1.34 3-3-1.34-3-3-3z"/>
              </svg>
            </button>
            <button title="Voir l'article" onclick="window.open('${article.link}','_blank')">
              Voir l'article
            </button>
            <button title="Favoris" onclick="favorisArticle()">
              <svg class="icon" viewBox="0 0 24 24">
                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
              </svg>
            </button>
          </div>
        `;
        newsContainer.appendChild(card);
      });
    }

    // Fonctions d'interaction pour chaque carte (à adapter)
    function ajouterMotCle(btn) {
      // btn est le bouton "Ajouter des mots-clés" dans la carte
      const keywordsList = btn.parentElement.querySelector(".keywords-list");
      if (keywordsList.children.length < 3) {
        const motCle = prompt("Entrez un mot clé:");
        if (motCle) {
          const span = document.createElement("span");
          span.className = "keyword";
          span.innerText = motCle;
          keywordsList.appendChild(span);
        }
      } else {
        alert("Vous avez atteint la limite de 3 mots clés.");
      }
    }
    function likeArticle() {
      alert("Article liké !");
    }
    function partagerArticle() {
      alert("Fonction de partage à implémenter.");
    }
    function favorisArticle() {
      alert("Ajouté aux favoris !");
    }

    // Gestion de la barre de recherche (fonctionnalité à étendre)
    document.querySelector('.search-container input').addEventListener('keypress', function(e) {
      if (e.key === 'Enter') {
        alert('Recherche non implémentée pour l\'instant.');
      }
    });

    // Chargement des articles dès le chargement de la page
    fetchRSS("all");
  </script>
</body>
</html>

