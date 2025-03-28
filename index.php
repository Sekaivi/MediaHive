<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Accueil - Pop Culture News</title>
  <style>
    /* Vos styles pour la page et la navbar */
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
    }
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
    }
    .article-card {
      background: #fff;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      overflow: hidden;
      width: 300px;
      cursor: pointer;
      transition: transform 0.2s;
    }
    .article-card:hover {
      transform: translateY(-5px);
    }
    .article-card img {
      width: 100%;
      height: auto;
      display: block;
    }
    .article-title {
      padding: 10px;
      font-size: 1.1em;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <?php include 'header.php'; ?>

  <div id="newsContainer">
    <!-- Les articles issus des flux RSS seront affichés ici -->
  </div>

  <script>
  const RSS_URLS = {
    "cinema": "https://www.allocine.fr/rss/news.xml",
    "jeux-video": "https://www.jeuxvideo.com/rss/rss.xml",
    "anime": "https://rss.app/feeds/PZfo1iTprhuhhLii.xml",
    "comics": "https://www.comicbookmovie.com/rss/",
  };

  async function fetchRSS(category = "all") {
    let proxyUrl = "https://api.allorigins.win/get?url=";
    let urls = category === "all" ? Object.values(RSS_URLS) : [RSS_URLS[category]];
    let articles = [];

    for (let url of urls) {
      try {
        let response = await fetch(proxyUrl + url);
        let data = await response.json();
        let parser = new DOMParser();
        let xml = parser.parseFromString(data.contents, "text/xml");

        let items = xml.querySelectorAll("item");
        items.forEach(item => {
          // Essai de récupérer l'image depuis <enclosure>
          let image = item.querySelector("enclosure")?.getAttribute("url");
          // Si non trouvé, essayer de récupérer depuis <media:content>
          if (!image) {
            // Utilisation de l'échappement pour le namespace media:
            image = item.querySelector("media\\:content")?.getAttribute("url");
          }
          // Valeur par défaut si aucune image trouvée
          if (!image) {
            image = "https://via.placeholder.com/300";
          }

          articles.push({
            title: item.querySelector("title")?.textContent || "Titre indisponible",
            link: item.querySelector("link")?.textContent || "#",
            description: item.querySelector("description")?.textContent || "",
            image: image,
          });
        });
      } catch (error) {
        console.error("Erreur lors du chargement RSS :", error);
      }
    }
    displayArticles(articles);
  }

  function displayArticles(articles) {
    const newsContainer = document.getElementById("newsContainer");
    newsContainer.innerHTML = "";
    articles.forEach(article => {
      const articleCard = document.createElement("div");
      articleCard.className = "article-card";
      articleCard.innerHTML = `
        <img src="${article.image}" alt="${article.title}">
        <div class="article-title">${article.title}</div>
      `;
      articleCard.addEventListener("click", () => {
        window.open(article.link, '_blank');
      });
      newsContainer.appendChild(articleCard);
    });
  }

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

