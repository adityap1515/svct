
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


                //cAROUSEL  function
                const slides = document.querySelectorAll('.slide');
                const prevButton = document.querySelector('.prev');
                const nextButton = document.querySelector('.next');
                let currentSlide = 0;

                function showSlide(index) {
                    slides[currentSlide].classList.remove('active');
                    slides[index].classList.add('active');
                    currentSlide = index;
                }
                const interval = setInterval(nextSlide, 2500);
                setTimeout(() => {
                clearInterval(interval);
                }, 16000);

                function nextSlide() {
                    let index = (currentSlide + 1) % slides.length;
                    showSlide(index);
                }

                function prevSlide() {
                    let index = (currentSlide - 1 + slides.length) % slides.length;
                    showSlide(index);
                }

                nextButton.addEventListener('click', nextSlide);
                prevButton.addEventListener('click', prevSlide);

               



document.addEventListener('scroll', () => {
    const section = document.querySelector('.seva-cards');
    const bounding = section.getBoundingClientRect();
  
    if (bounding.top <= 0 && bounding.bottom > window.innerHeight) {
      section.classList.add('sticky');
    } else {
      section.classList.remove('sticky');
    }
  });
  
