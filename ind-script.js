// Hamburger Menu Toggle
const hamburger = document.querySelector('.hamburger');
const navLinks = document.querySelector('.nav-links');

if (hamburger && navLinks) {
    hamburger.addEventListener('click', () => {
        navLinks.classList.toggle('active');
    });
}

// Back-to-Top Button Visibility
window.addEventListener('scroll', function() {
    const backToTopButton = document.getElementById('backToTop');
    if (backToTopButton) {
        if (window.scrollY > 200) { 
            backToTopButton.style.display = 'block';
            backToTopButton.classList.add('visible');
        } else {
            backToTopButton.style.display = 'none';
            backToTopButton.classList.remove('visible');
        }
    }
});

// Scroll to the Top
const backToTopButton = document.getElementById('backToTop');
if (backToTopButton) {
    backToTopButton.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

// Carousel Functionality
const slides = document.querySelectorAll('.slide');
const prevButton = document.querySelector('.prev');
const nextButton = document.querySelector('.next');
let currentSlide = 0; 

// Function to show a specific slide based on index
function showSlide(index) {
    
    if (index >= 0 && index < slides.length) {
     
        slides[currentSlide].classList.remove('active');
       
        currentSlide = index;
        
      
        slides[currentSlide].classList.add('active');
    }
}


function nextSlide() {
    let nextIndex = (currentSlide + 1) % slides.length; 
    showSlide(nextIndex); 
}

// Previous slide function
function prevSlide() {
    let prevIndex = (currentSlide - 1 + slides.length) % slides.length; 
    showSlide(prevIndex); 
}

// Auto-scrolling function (carousel autoplay)
function startAutoScroll() {
    autoScrollInterval = setInterval(nextSlide, 3800);
}


function pauseAutoScroll() {
    clearInterval(autoScrollInterval); 
    setTimeout(startAutoScroll, PAUSE_DURATION); 
}


nextButton.addEventListener('click', () => {
    nextSlide();
    pauseAutoScroll(); 
});

prevButton.addEventListener('click', () => {
    prevSlide();
    pauseAutoScroll(); 
});

// Initial auto-scroll start
startAutoScroll();