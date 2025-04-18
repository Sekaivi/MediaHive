const searchbar = document.getElementById('searchbar');
const searchContainer = document.querySelector('.search-container');
const searchResults = document.getElementById('search-results');
// Example: Sort articles in descending order on page load

searchbar.addEventListener('focus', () => {
    keywords_suggestions();
});

searchbar.addEventListener('focusout', () => {
    searchResults.innerHTML = '';
})

searchbar.addEventListener('input', () => {
    const query = searchbar.value.trim(); // Get input value

    if (query.length < 2) {
        searchResults.innerHTML = ""; // Clear results if query is too short
        return;
    }

    let formData = new FormData();
    formData.append("routeAjax", "updateSearchSuggestions");
    formData.append("query", query);

    fetch("index.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            console.log("Response:", data);
            searchResults.innerHTML = "";
            if (data.success) {
                data.articles.forEach(article => {
                    const search_suggestion = document.createElement('div');
                    search_suggestion.classList.add('search-suggestion');
                    search_suggestion.textContent = article.title.length > 20 ? article.title.substring(0, 50) + "..." : article.title;
                    searchResults.appendChild(search_suggestion);
                    search_suggestion.addEventListener('click',()=>{
                        searchbar.value = search_suggestion.textContent ;
                    })
                });
            }
        })
        .catch(error => console.error("Error:", error));
});

function keywords_suggestions() {
    let formData = new FormData();
    formData.append("routeAjax", "listPopKeywords");
    fetch("index.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.text())
        .then(text => {
            console.log("Response:", text);
            return JSON.parse(text);
        })
        .then(data => {
            if (data.success) {
                const keywords = data.keywords;
                keywords.forEach(keyword => {
                    const search_suggestion = document.createElement('div'); // add an event listener that redirects to a specific category ?
                    search_suggestion.classList.add('search-suggestion');
                    search_suggestion.textContent = keyword.keywordName;
                    searchResults.appendChild(search_suggestion);
                });
            }
            else {
                console.log(data);
            }
        })
        .catch(error => console.error("Error:", error));
}


function sortArticles(ascending) {
    const container = document.querySelector('#category-container');
    const articles = Array.from(container.querySelectorAll('.article-card'));
    articles.reverse();

    // Clear the container and re-append the reversed articles
    container.innerHTML = '';

    articles.forEach(article => {
        container.appendChild(article);
    });
}
