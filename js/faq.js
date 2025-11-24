  document.addEventListener('DOMContentLoaded', function() {
    const faqItems = document.querySelectorAll('.faq-item');
    
    faqItems.forEach(item => {
      item.addEventListener('click', function() {
        // Toggle active class on clicked item
        this.classList.toggle('active');
        
        // Close other items (optional - remove if you want multiple open)
        faqItems.forEach(otherItem => {
          if (otherItem !== this) {
            otherItem.classList.remove('active');
          }
        });
      });
    });
  });