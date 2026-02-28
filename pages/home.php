<?php
require_once __DIR__ . '/../includes/config.php';

// SEO Meta
$meta_title    = setting('meta_title_home');
$meta_desc     = setting('meta_desc_home');
$meta_keywords = setting('meta_keywords_home');

// Data
$categories = db()->query("SELECT * FROM categories WHERE status='active' ORDER BY id")->fetchAll();
$products   = db()->query("SELECT p.*, c.name as cat_name FROM products p LEFT JOIN categories c ON p.category_id=c.id WHERE p.status='active' ORDER BY p.id LIMIT 8")->fetchAll();
$locations  = db()->query("SELECT * FROM locations WHERE status='active' ORDER BY id")->fetchAll();
$testimonials = db()->query("SELECT * FROM testimonials WHERE status='active' ORDER BY urutan LIMIT 6")->fetchAll();
$faqs = db()->query("SELECT * FROM faqs WHERE status = 'active' ORDER BY urutan ASC")->fetchAll();
$wa_url     = setting('whatsapp_url');
$wa_msg     = urlencode('Halo, saya ingin memesan bunga. Mohon info produk dan harga yang tersedia.');

// Category icons mapping
$cat_icons = ['🌸','🕊️','💍','💐','🌿','🎊','🎁','🌼'];

require __DIR__ . '/../includes/header.php';

require __DIR__ . '/sections/hero-section.php';
require __DIR__ . '/sections/layanan-section.php';
require __DIR__ . '/sections/produk-section.php';
require __DIR__ . '/sections/keunggulan-section.php';
require __DIR__ . '/sections/area-section.php';
require __DIR__ . '/sections/testimoni-section.php';
require __DIR__ . '/sections/faq-section.php';
require __DIR__ . '/sections/cta-section.php';

require __DIR__ . '/../includes/footer.php';
?>


<script>
  // Slider Hero
let index = 0;
const slider = document.getElementById('heroSlider');
const totalSlides = slider.children.length;

setInterval(() => {
  index = (index + 1) % totalSlides;
  slider.style.transform = `translateX(-${index * 100}%)`;
}, 5000);

// lain
function toggleFaq(btn) {
  const answer = btn.nextElementSibling;
  const icon   = btn.querySelector('.faq-icon');
  answer.classList.toggle('hidden');
  icon.style.transform = answer.classList.contains('hidden') ? '' : 'rotate(180deg)';
}
</script>