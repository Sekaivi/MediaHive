let profileForm = document.getElementById('profile-form');
let profileInfo = document.getElementById("profile-info");


document.getElementById("edit-profile").addEventListener("click", function () {
    profileInfo.style.display = "none";
    profileForm.style.display = "block";
});

profileForm.addEventListener("submit", function (evt) {
    evt.preventDefault();
    let formData = new FormData(profileForm); // Use the correct form reference
    formData.append("routeAjax", "updateProfile");
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
                let user = data['user'];
                document.getElementById("username").textContent = user.username;
                document.getElementById("profilePicture").src = user.profilePicture;
                document.getElementById("bio").textContent = user.bio;
                document.getElementById("message").textContent = "Profile updated successfully!";
                profileInfo.style.display = "block";
                profileForm.style.display = "none";
            } else {
                document.getElementById("message").textContent = "Error while updating the profile";
            }
        })
        .catch(error => console.error("Error:", error));
});


let feedForm = document.getElementById("feed-form");
let searchInput = document.getElementById("feed-search");
let feedList = document.getElementById("feed-list");

// ajax to update preferences
feedForm.addEventListener("submit", function (evt) {
    evt.preventDefault();
    let formData = new FormData(feedForm);
    formData.append("routeAjax", "updatePreferences");
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
                console.log('success !');
            } else {
                document.getElementById("message").textContent = "Error while updating preferences";
            }
        })
        .catch(error => console.error("Error:", error));
});

searchInput.addEventListener("input", function () {
    let searchValue = this.value.toLowerCase();
    let options = feedList.options;
    let firstMatch = null;
    let matchCount = 0;

    for (let option of options) {
        let text = option.text.toLowerCase();
        if (text.includes(searchValue)) {
            option.style.display = "block";
            if (!firstMatch) firstMatch = option;
            matchCount++;
        } else {
            option.style.display = "none";
        }
    }

    // Open the dropdown by increasing size
    feedList.size = matchCount > 0 ? Math.min(matchCount, 6) : 1; // Limit size to 6 max

    if (firstMatch) {
        feedList.value = firstMatch.value;
    }
});

document.addEventListener("click", function (event) {
    if (!searchInput.contains(event.target) && !feedList.contains(event.target)) {
        feedList.size = 1;
    }
});

searchInput.addEventListener("focus", function () {
    let visibleOptions = [...feedList.options].filter(opt => opt.style.display !== "none");
    feedList.size = visibleOptions.length > 0 ? Math.min(visibleOptions.length, 6) : 1;
});

    // Fonction pour basculer la sidebar entre agrandi et réduit
    function toggleSidebar() {
      var sidebar = document.getElementById('sidebar');
      sidebar.classList.toggle('expanded');
      // La marge de <main> est gérée via le sélecteur CSS adjacent (avec ~)
    }


// Mise à jour des indicateurs (optionnel)
function updateIndicators(carouselId) {
  const carousel = document.getElementById("carousel-" + carouselId);
  const indicators = document.querySelectorAll("#indicators-" + carouselId + " .indicator");
  let currentIndex = parseInt(carousel.dataset.currentIndex) || 0;
  indicators.forEach((indicator, index) => {
    indicator.classList.toggle("active", index === currentIndex);
  });
}

// Mise à jour de la position de la scrollbar thumb
function updateScrollBar(carouselId) {
  const carousel = document.getElementById("carousel-" + carouselId);
  const currentIndex = parseInt(carousel.dataset.currentIndex) || 0;
  const slides = carousel.children;
  const slideCount = slides.length;
  const scrollbar = document.getElementById("scrollbar-" + carouselId);
  if (!scrollbar) return;
  const thumb = scrollbar.querySelector(".scrollbar-thumb");
  const trackWidth = scrollbar.offsetWidth;
  // Définir la plage de déplacement pour le thumb
  const maxThumbLeft = trackWidth - thumb.offsetWidth;
  const leftPercent = currentIndex / (slideCount - 1);
  const thumbLeft = leftPercent * maxThumbLeft;
  thumb.style.left = thumbLeft + "px";
}

function nextSlide(carouselId) {
  const carousel = document.getElementById("carousel-" + carouselId);
  let currentIndex = parseInt(carousel.dataset.currentIndex) || 0;
  const slides = carousel.children;
  const slideCount = slides.length;
  currentIndex = (currentIndex + 1) % slideCount;
  carousel.dataset.currentIndex = currentIndex;
  carousel.style.transform = "translateX(" + (-currentIndex * 320) + "px)";
  updateIndicators(carouselId);
  updateScrollBar(carouselId);
}

function prevSlide(carouselId) {
  const carousel = document.getElementById("carousel-" + carouselId);
  let currentIndex = parseInt(carousel.dataset.currentIndex) || 0;
  const slides = carousel.children;
  const slideCount = slides.length;
  currentIndex = (currentIndex - 1 + slideCount) % slideCount;
  carousel.dataset.currentIndex = currentIndex;
  carousel.style.transform = "translateX(" + (-currentIndex * 320) + "px)";
  updateIndicators(carouselId);
  updateScrollBar(carouselId);
}

function goToSlide(carouselId, index) {
  const carousel = document.getElementById("carousel-" + carouselId);
  carousel.dataset.currentIndex = index;
  carousel.style.transform = "translateX(" + (-index * 320) + "px)";
  updateIndicators(carouselId);
  updateScrollBar(carouselId);
}

// Initialisation du drag pour la scrollbar thumb
function initScrollBarDrag(carouselId) {
  const scrollbar = document.getElementById("scrollbar-" + carouselId);
  if (!scrollbar) return;
  const thumb = scrollbar.querySelector(".scrollbar-thumb");
  const carousel = document.getElementById("carousel-" + carouselId);
  let dragging = false, startX, startThumbLeft;

  thumb.addEventListener("mousedown", function(e) {
    dragging = true;
    startX = e.clientX;
    startThumbLeft = thumb.offsetLeft;
    document.body.style.userSelect = "none";
  });

  document.addEventListener("mousemove", function(e) {
    if (!dragging) return;
    const dx = e.clientX - startX;
    let newThumbLeft = startThumbLeft + dx;
    const trackWidth = scrollbar.offsetWidth;
    const maxThumbLeft = trackWidth - thumb.offsetWidth;
    if (newThumbLeft < 0) newThumbLeft = 0;
    if (newThumbLeft > maxThumbLeft) newThumbLeft = maxThumbLeft;
    thumb.style.left = newThumbLeft + "px";
    // Calculer l'index correspondant
    const slides = carousel.children;
    const slideCount = slides.length;
    const ratio = newThumbLeft / maxThumbLeft;
    const newIndex = Math.round(ratio * (slideCount - 1));
    carousel.dataset.currentIndex = newIndex;
    carousel.style.transform = "translateX(" + (-newIndex * 320) + "px)";
    updateIndicators(carouselId);
  });

  document.addEventListener("mouseup", function() {
    if (dragging) {
      dragging = false;
      document.body.style.userSelect = "";
    }
  });
}

// Appeler l'initialisation du drag pour chaque carrousel après chargement du DOM
document.addEventListener("DOMContentLoaded", function() {
  initScrollBarDrag("popular");
  initScrollBarDrag("latest");
});

