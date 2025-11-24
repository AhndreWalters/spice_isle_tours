// Corrected gallery selector and lightbox logic
const gallery = document.getElementById('gallery');
const lightbox = document.getElementById('lightbox');
const lightboxImg = document.getElementById('lightbox-img');
const closeBtn = document.querySelector('.close');

// Open lightbox on image click
gallery.addEventListener('click', (e) => {
  if (e.target.tagName.toLowerCase() === 'img') {
    lightbox.style.display = 'block';
    lightboxImg.src = e.target.src;
    document.body.style.overflow = 'hidden'; // prevent background scroll
  }
});

// Close lightbox
closeBtn.addEventListener('click', () => {
  lightbox.style.display = 'none';
  document.body.style.overflow = 'auto';
});

// Close when clicking outside the image
lightbox.addEventListener('click', (e) => {
  if (e.target === lightbox) {
    lightbox.style.display = 'none';
    document.body.style.overflow = 'auto';
  }
});
