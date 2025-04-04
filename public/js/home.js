let user_reco = document.getElementById('userReco');
let user_btn = document.getElementById('foryou-btn')
let media_reco = document.getElementById("mediahiveReco");
let media_btn = document.getElementById('public-btn');

function toggleSidebar() {
  var sidebar = document.getElementById('sidebar');
  sidebar.classList.toggle('expanded');
  // La marge de <main> est gérée via le sélecteur CSS adjacent (avec ~)
}

function display_user_reco() {
  media_reco.style.display = 'none';
  user_reco.style.display = 'flex';
  media_btn.classList.remove('active');
  user_btn.classList.add('active');
}

function display_mediahive_reco() {
  media_reco.style.display = 'flex';
  user_reco.style.display = 'none';
  media_btn.classList.add('active');
  user_btn.classList.remove('active');
}

// General function to update the position of the scrollbar thumb
function updateScrollBar(carouselId) {
  const carousel = document.querySelector(`#${carouselId}`);
  const currentIndex = parseInt(carousel.dataset.currentIndex) || 0;
  const slides = carousel.children;
  const slideCount = slides.length;
  const scrollbar = document.querySelector(`#scrollbar-${carouselId}`);
  if (!scrollbar) return;
  const thumb = scrollbar.querySelector(".scrollbar-thumb");
  const trackWidth = scrollbar.offsetWidth;
  const maxThumbLeft = trackWidth - thumb.offsetWidth;
  const leftPercent = currentIndex / (slideCount - 1);
  const thumbLeft = leftPercent * maxThumbLeft;
  thumb.style.left = thumbLeft + "px";
}

// General function to go to the next slide
function nextSlide(carouselId) {
  const carousel = document.querySelector(`#${carouselId}`);
  let currentIndex = parseInt(carousel.dataset.currentIndex) || 0;
  const slides = carousel.children;
  const slideCount = slides.length;
  currentIndex = (currentIndex + 1) % slideCount;
  carousel.dataset.currentIndex = currentIndex;
  carousel.style.transform = "translateX(" + (-currentIndex * 320) + "px)";
  updateScrollBar(carouselId);
}

// General function to go to the previous slide
function prevSlide(carouselId) {
  const carousel = document.querySelector(`#${carouselId}`);
  let currentIndex = parseInt(carousel.dataset.currentIndex) || 0;
  const slides = carousel.children;
  const slideCount = slides.length;
  currentIndex = (currentIndex - 1 + slideCount) % slideCount;
  carousel.dataset.currentIndex = currentIndex;
  carousel.style.transform = "translateX(" + (-currentIndex * 320) + "px)";
  updateScrollBar(carouselId);
}

// Function to initialize the drag for the scrollbar
function initScrollBarDrag(carouselId) {
  const scrollbar = document.querySelector(`#scrollbar-${carouselId}`);
  if (!scrollbar) return;
  const thumb = scrollbar.querySelector(".scrollbar-thumb");
  const carousel = document.querySelector(`#${carouselId}`);
  let dragging = false, startX, startThumbLeft;

  thumb.addEventListener("mousedown", function (e) {
    dragging = true;
    startX = e.clientX;
    startThumbLeft = thumb.offsetLeft;
    document.body.style.userSelect = "none";
  });

  document.addEventListener("mousemove", function (e) {
    if (!dragging) return;
    const dx = e.clientX - startX;
    let newThumbLeft = startThumbLeft + dx;
    const trackWidth = scrollbar.offsetWidth;
    const maxThumbLeft = trackWidth - thumb.offsetWidth;
    if (newThumbLeft < 0) newThumbLeft = 0;
    if (newThumbLeft > maxThumbLeft) newThumbLeft = maxThumbLeft;
    thumb.style.left = newThumbLeft + "px";
    const slides = carousel.children;
    const slideCount = slides.length;
    const ratio = newThumbLeft / maxThumbLeft;
    const newIndex = Math.round(ratio * (slideCount - 1));
    carousel.dataset.currentIndex = newIndex;
    carousel.style.transform = "translateX(" + (-newIndex * 320) + "px)";
  });

  document.addEventListener("mouseup", function () {
    if (dragging) {
      dragging = false;
      document.body.style.userSelect = "";
    }
  });
}

// Initialize drag functionality when the DOM is loaded
document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll('.carousel').forEach(carousel => {
    const carouselId = carousel.id;
    initScrollBarDrag(carouselId);
  });
});



function playVideo() {
  const video = document.getElementById('my-video');
  const playButton = document.querySelector('.play-button');

  // Play the video
  video.play();

  // Hide the play button after starting the video
  playButton.style.display = 'none';
}



const modal = document.getElementById("myModal");
const openBtn = document.getElementById("openModal");
const closeBtn = document.querySelector(".close-btn");
const closeModalBtn = document.getElementById("closeModal");


function displayModal(message) {
  modal.style.display = "flex";
  modal.querySelector('#modalTitle').textContent = message;
}

// Close modal function
function closeModal() {
  modal.style.display = "none";
}

closeBtn.addEventListener("click", closeModal);
closeModalBtn.addEventListener("click", closeModal);

// Close when clicking outside the modal
window.addEventListener("click", (event) => {
  if (event.target === modal) {
    closeModal();
  }
});

// Close on Esc key
window.addEventListener("keydown", (event) => {
  if (event.key === "Escape") {
    closeModal();
  }
});