document.addEventListener('DOMContentLoaded', (event) => {
    // Configuration object with section classes and their corresponding thresholds
    const sectionConfig = {
        '.section': 0.5,     
        '.sectionsmain': 0.33, 
        '.feature-section': 0.1, 
        
    };

    // Function to create IntersectionObserver for each class and threshold
    const createObserver = (sectionClass, threshold) => {
        const sections = document.querySelectorAll(sectionClass);

        // IntersectionObserver setup with dynamic threshold
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, {
            threshold: threshold,
            rootMargin: '0px' 
        });

        
        sections.forEach(section => {
            observer.observe(section);
        });
    };

    
    for (const sectionClass in sectionConfig) {
        if (sectionConfig.hasOwnProperty(sectionClass)) {
            createObserver(sectionClass, sectionConfig[sectionClass]);
        }
    }
});
