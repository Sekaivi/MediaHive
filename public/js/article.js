const like_btns = document.querySelectorAll('.like-btn');
const fav_btns = document.querySelectorAll('.fav-btn');
const keyword_btns = document.querySelectorAll('.keywords-btn');
const share_btns = document.querySelectorAll('.share-btn');
const view_btns = document.querySelectorAll('.view-btn');
const keyword_forms = document.querySelectorAll('.keywords-section');

[...like_btns, ...fav_btns].forEach(btn => {
    btn.addEventListener('click', handleButtonClick);
});

view_btns.forEach(button => {
    button.addEventListener('click', function () {
        let link = this.getAttribute('data-link');
        window.open(link, '_blank');
    });
});

keyword_forms.forEach(form => {
    form.addEventListener("submit", function (evt) {
        update_keyword(evt, form);
    });
});

function update_keyword(evt, form) {
    evt.preventDefault(); // Prevent default form submission

    const article = evt.target.closest('.article-card');
    const articleID = article.id;

    let keywordID, keywordName;

    // Check if the clicked element was a keyword button
    const clickedButton = evt.submitter; // `submitter` gives the button that triggered the submit event
    if (clickedButton.classList.contains("keywords-btn") && clickedButton.hasAttribute("data-id")) {
        keywordID = clickedButton.getAttribute("data-id");
        keywordName = clickedButton.textContent.trim();
    } else {
        // Otherwise, use the selected option from the <select>
        const selectElement = form.querySelector('.keyword-list');
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        keywordID = selectedOption.value;
        keywordName = selectedOption.dataset.name;
    }
    let formData = new FormData();
    formData.append("keywordID", keywordID);
    formData.append("articleID", articleID);
    formData.append("routeAjax", "updateKeywords");
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
            // penser a ajouter l'event listener aux nouveaux boutons keywords, qu'on puisse les retirer au clique.
            if (data.success && data.action === 'INSERT') {
                button = document.createElement('button');
                button.type = 'submit';
                button.setAttribute("data-id", keywordID);
                button.textContent = keywordName;
                button.classList.add('keywords-btn');
                const keywordsContainer = form.querySelector('.article-keywords');
                if (keywordsContainer) {
                    keywordsContainer.appendChild(button);
                }
                checkKeywordLimit(form)
            } else if (data.success && data.action === 'DELETE') {
                const keywordButton = form.querySelector(`.keywords-btn[data-id='${keywordID}']`);
                if (keywordButton) {
                    keywordButton.remove();
                    checkKeywordLimit(form);
                } else {
                    console.log('couldnt find button snif');
                }
                // si 2 ou moins mots clés, montrer le add keywords + selection
            }
            else {
                console.log(data);
            }
        })
        .catch(error => console.error("Error:", error));
}


function handleButtonClick(event) {

    const article = event.target.closest('.article-card');
    if (!article) return;
    const articleID = article.id;
    const button = event.currentTarget;
    // Determine action based on the button class
    if (button.classList.contains('like-btn')) {
        article_action(articleID, "likeArticle");
    } else if (button.classList.contains('fav-btn')) {
        article_action(articleID, "bookmarkArticle");
    }
}

function article_action(articleID, action) {
    let formData = new FormData();
    formData.append("articleID", articleID);
    formData.append("routeAjax", action);
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
                console.log(data);
            } else {
                console.log(data);
            }
        })
        .catch(error => console.error("Error:", error));
}

function checkKeywordLimit(form) {
    const keywordsContainer = form.querySelector('.article-keywords');
    const keywordButtons = keywordsContainer.querySelectorAll('.keywords-btn');
    const addKeywordList = form.querySelector('.addKeywordList');

    if (keywordButtons.length >= 3) {
        if (addKeywordList) addKeywordList.style.display = 'none';
    } else {
        if (addKeywordList) addKeywordList.style.display = 'block';
    }
}