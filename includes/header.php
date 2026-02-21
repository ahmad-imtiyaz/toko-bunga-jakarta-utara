<?php
// $meta_title, $meta_desc, $meta_keywords should be set before including this file
$meta_title    = $meta_title    ?? setting('meta_title_home');
$meta_desc     = $meta_desc     ?? setting('meta_desc_home');
$meta_keywords = $meta_keywords ?? setting('meta_keywords_home');
$wa_url        = setting('whatsapp_url');
$site_name     = setting('site_name');
$phone         = setting('phone_display');
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($meta_title) ?></title>
<meta name="description" content="<?= e($meta_desc) ?>">
<meta name="keywords" content="<?= e($meta_keywords) ?>">
<meta name="robots" content="index, follow">
<link rel="canonical" href="<?= e(BASE_URL . '/' . trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/')) ?>">

<!-- Open Graph -->
<meta property="og:title"       content="<?= e($meta_title) ?>">
<meta property="og:description" content="<?= e($meta_desc) ?>">
<meta property="og:type"        content="website">
<meta property="og:url"         content="<?= e(BASE_URL) ?>">

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

<!-- Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
  theme: {
    extend: {
      colors: {
        cream:  { DEFAULT: '#FDF8F0', dark: '#F5EDD8' },
        sage:   { DEFAULT: '#7A9E7E', dark: '#5C7C60', light: '#A8C5AC' },
        blush:  { DEFAULT: '#E8C4B8', dark: '#D4A090' },
        gold:   { DEFAULT: '#C9A96E', dark: '#A8843E' },
        navy:   { DEFAULT: '#2C3E6B', dark: '#1E2D52' },
        sky:    { DEFAULT: '#B8D4E8', dark: '#8FB8D4' },
      },
      fontFamily: {
        serif: ['"Playfair Display"', 'Georgia', 'serif'],
        sans:  ['"DM Sans"', 'sans-serif'],
      },
    }
  }
}
</script>

<!-- Local CSS -->
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">

<!-- LocalBusiness Schema -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "LocalBusiness",
  "name": "<?= e($site_name) ?>",
  "description": "<?= e($meta_desc) ?>",
  "url": "<?= BASE_URL ?>",
  "telephone": "<?= e(setting('phone_display')) ?>",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "<?= e(setting('address')) ?>",
    "addressLocality": "Jakarta Utara",
    "addressRegion": "DKI Jakarta",
    "addressCountry": "ID"
  },
  "openingHours": "Mo-Su 07:00-21:00",
  "areaServed": ["Penjaringan","Pademangan","Tanjung Priok","Koja","Cilincing","Kelapa Gading"],
  "priceRange": "Rp300.000 - Rp1.500.000"
}
</script>
</head>
<body class="font-sans bg-cream text-gray-800 antialiased">

<!-- TOP BAR -->
<div class="bg-navy text-white text-xs py-2 hidden md:block">
  <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
    <span>📍 <?= e(setting('address')) ?></span>
    <span>⏰ <?= e(setting('jam_buka')) ?> &nbsp;|&nbsp; 📞 <a href="tel:<?= e(setting('whatsapp_number')) ?>" class="hover:text-sky transition"><?= e($phone) ?></a></span>
  </div>
</div>

<!-- NAVBAR -->
<nav class="bg-white shadow-sm sticky top-0 z-50 border-b border-cream-dark" id="navbar">
  <div class="max-w-7xl mx-auto px-4">
    <div class="flex items-center justify-between h-16 md:h-20">

<!-- Logo -->
<a href="<?= BASE_URL ?>/" class="brand group flex items-center gap-3">
  <div class="logo-wrapper w-10 h-10 rounded-full bg-sage flex items-center justify-center shadow overflow-hidden">
    <img src="<?= BASE_URL ?>/assets/images/icon.png"
         alt="Logo"
         class="logo-img w-full h-full object-cover">
  </div>
  <div>
    <div class="font-serif font-bold text-navy text-base leading-tight"><?= e($site_name) ?></div>
    <div class="text-xs text-sage hidden sm:block"><?= e(setting('site_tagline')) ?></div>
  </div>
</a>
      <!-- Desktop Nav -->
      <div class="hidden md:flex items-center gap-7 text-sm font-medium text-gray-700">
        <a href="<?= BASE_URL ?>/#layanan"   class="hover:text-sage transition">Layanan</a>
        <a href="<?= BASE_URL ?>/#produk"    class="hover:text-sage transition">Produk</a>
        <a href="<?= BASE_URL ?>/#area"      class="hover:text-sage transition">Area Kirim</a>
        <a href="<?= BASE_URL ?>/#tentang"   class="hover:text-sage transition">Tentang</a>
        <a href="<?= BASE_URL ?>/#faq"       class="hover:text-sage transition">FAQ</a>
      </div>

      <!-- CTA -->
      <a href="<?= e($wa_url) ?>" target="_blank" rel="noopener"
         class="hidden md:flex items-center gap-2 bg-sage hover:bg-sage-dark text-white text-sm font-semibold px-5 py-2.5 rounded-full transition shadow-sm">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/></svg>
        Pesan Sekarang
      </a>

      <!-- Mobile hamburger -->
      <button id="menu-btn" class="md:hidden p-2 rounded-lg text-gray-600 hover:bg-cream transition" aria-label="Menu">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden hidden pb-4 border-t border-cream-dark mt-2">
      <div class="flex flex-col gap-1 pt-3">
        <a href="<?= BASE_URL ?>/#layanan" class="px-3 py-2 rounded-lg hover:bg-cream text-sm font-medium text-gray-700">Layanan</a>
        <a href="<?= BASE_URL ?>/#produk"  class="px-3 py-2 rounded-lg hover:bg-cream text-sm font-medium text-gray-700">Produk</a>
        <a href="<?= BASE_URL ?>/#area"    class="px-3 py-2 rounded-lg hover:bg-cream text-sm font-medium text-gray-700">Area Kirim</a>
        <a href="<?= BASE_URL ?>/#tentang" class="px-3 py-2 rounded-lg hover:bg-cream text-sm font-medium text-gray-700">Tentang</a>
        <a href="<?= BASE_URL ?>/#faq"     class="px-3 py-2 rounded-lg hover:bg-cream text-sm font-medium text-gray-700">FAQ</a>
        <a href="<?= e($wa_url) ?>" target="_blank" class="mt-2 mx-3 flex items-center justify-center gap-2 bg-sage text-white text-sm font-semibold py-3 rounded-full">
          🌿 Pesan via WhatsApp
        </a>
      </div>
    </div>
  </div>
</nav>

<script>
document.getElementById('menu-btn').addEventListener('click', () => {
  document.getElementById('mobile-menu').classList.toggle('hidden');
});
</script>
