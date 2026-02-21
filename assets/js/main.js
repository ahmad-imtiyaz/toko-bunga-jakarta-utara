// TOKOBUNGAJAKARTAUTARA - Main JS

// Navbar scroll shadow
window.addEventListener('scroll', () => {
  const nav = document.getElementById('navbar');
  if (nav) {
    nav.classList.toggle('scrolled', window.scrollY > 10);
  }
});

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(a => {
  a.addEventListener('click', e => {
    const target = document.querySelector(a.getAttribute('href'));
    if (target) {
      e.preventDefault();
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  });
});

// Lazy image fallback
document.querySelectorAll('img').forEach(img => {
  img.addEventListener('error', () => {
    img.src = 'https://images.unsplash.com/photo-1487530811015-780780dde0e4?w=400&h=300&fit=crop';
  });
});
