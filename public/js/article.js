// pour les interactions

// tout ce qui est ajax

like-btn

share-btn

fav-btn

add-keywords-btn

// RECUPERER LA SOURCE
article-image

// recuperer le titre
article-title

// recuperer la desc
article-description

// recuperer le lien
document.querySelectorAll('.view-btn').forEach(button => {
    button.addEventListener('click', function () {
        let link = this.getAttribute('data-link');
        console.log("Button opens link:", link);
    });
});