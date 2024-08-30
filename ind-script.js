
        const hamburger = document.querySelector('.hamburger');
        const navLinks = document.querySelector('.nav-links');

        hamburger.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });
// Back to Top button functionality
const backToTopButton = document.getElementById("backToTop");

window.onscroll = function() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        backToTopButton.style.display = "block";
    } else {
        backToTopButton.style.display = "none";
    }
};

backToTopButton.onclick = function(e) {
    e.preventDefault();
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
};

document.addEventListener('scroll', () => {
    const section = document.querySelector('.seva-cards');
    const bounding = section.getBoundingClientRect();
  
    if (bounding.top <= 0 && bounding.bottom > window.innerHeight) {
      section.classList.add('sticky');
    } else {
      section.classList.remove('sticky');
    }
  });
  