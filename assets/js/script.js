let currentIndex = 0;
let images = document.querySelectorAll('.slider-container img');
let indicators = document.querySelectorAll('.indicator');
let autoSlide = true;
let interval = setInterval(nextSlide, 3000);

function showSlide(index) {
  images.forEach((img, i) => {
    img.classList.toggle('active', i === index);
    indicators[i].classList.toggle('active-indicator', i === index);
  });
  currentIndex = index;
}

function nextSlide() {
  showSlide((currentIndex + 1) % images.length);
}

function prevSlide() {
  showSlide((currentIndex - 1 + images.length) % images.length);
}

function goToSlide(index) {
  showSlide(index);
}

function toggleSlider() {
  autoSlide = !autoSlide;
  document.getElementById('pausePlayBtn').className = autoSlide ? 'fas fa-pause' : 'fas fa-play';
  if (autoSlide) {
    interval = setInterval(nextSlide, 3000);
  } else {
    clearInterval(interval);
  }
}