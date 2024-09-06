
        const hamburger = document.querySelector('.hamburger');
        const navLinks = document.querySelector('.nav-links');

        hamburger.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });


        //backtoTop Visibility on scroll [function]
        window.addEventListener('scroll', function() {
            const backToTopButton = document.getElementById('backToTop');
            if (window.scrollY > 300) { 
                backToTopButton.style.display = 'block';
                backToTopButton.classList.add('visible');
            } else {
                backToTopButton.style.display = 'none';
                backToTopButton.classList.remove('visible');
            }
        });
        
        // Scroll to the top when the button is clicked
        document.getElementById('backToTop').addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

document.addEventListener('scroll', () => {
    const section = document.querySelector('.seva-cards');
    const bounding = section.getBoundingClientRect();
  
    if (bounding.top <= 0 && bounding.bottom > window.innerHeight) {
      section.classList.add('sticky');
    } else {
      section.classList.remove('sticky');
    }
  });
  

  document.addEventListener("scroll", function() {
    const cards = document.querySelectorAll(".card");
    const windowHeight = window.innerHeight;

    cards.forEach(card => {
        const cardTop = card.getBoundingClientRect().top;
        const cardBottom = card.getBoundingClientRect().bottom;

        if (cardTop >= 0 && cardBottom <= windowHeight) {
            card.classList.add("visible");
        } else {
            card.classList.remove("visible");
        }
    });
});
