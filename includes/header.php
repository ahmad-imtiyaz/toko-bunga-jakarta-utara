<?php
// $meta_title, $meta_desc, $meta_keywords should be set before including this file
$meta_title    = $meta_title    ?? setting('meta_title_home');
$meta_desc     = $meta_desc     ?? setting('meta_desc_home');
$meta_keywords = $meta_keywords ?? setting('meta_keywords_home');
$wa_url        = setting('whatsapp_url');
$site_name     = setting('site_name');
$phone         = setting('phone_display');

// ── Ambil kategori & subkategori untuk mega menu ──────────────────────────
// Struktur yang diharapkan:
//   categories.parent_id = NULL  → kategori utama (Bunga Papan, Hand Bouquet, dll)
//   categories.parent_id = <id>  → sub-kategori (Happy Wedding, dll)
//
// Kalau tabel belum punya kolom parent_id, query kedua akan kosong — tidak error.

$nav_categories = db()->query("
    SELECT * FROM categories
    WHERE status = 'active'
    ORDER BY urutan ASC, id ASC
")->fetchAll();

// Pisahkan menjadi parent & children
$nav_parents  = [];
$nav_children = []; // [parent_id => [...]]

foreach ($nav_categories as $nc) {
    $pid = $nc['parent_id'] ?? null;
    if ($pid === null || $pid == 0) {
        $nav_parents[] = $nc;
    } else {
        $nav_children[$pid][] = $nc;
    }
}

// ── Helper: apakah slug aktif? ─────────────────────────────────────────────
$current_slug = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$base_path    = trim(parse_url(BASE_URL, PHP_URL_PATH), '/');
if ($base_path && str_starts_with($current_slug, $base_path)) {
    $current_slug = trim(substr($current_slug, strlen($base_path)), '/');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($meta_title) ?></title>
<meta name="description" content="<?= e($meta_desc) ?>">
<meta name="keywords"    content="<?= e($meta_keywords) ?>">
<meta name="robots"      content="index, follow">
<link rel="icon"         href="<?= BASE_URL ?>/assets/images/icon.png">
<link rel="canonical"    href="<?= e(BASE_URL . '/' . trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/')) ?>">

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

<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">

<!-- Dropdown & Navbar Custom CSS -->
<style>
/* ── Dropdown ─────────────────────────────────── */
.nav-dropdown         { position: relative; }
.nav-dropdown-menu    {
  display: none;
  position: absolute;
  top: calc(100% + 4px);
  left: 0;
  min-width: 220px;
  background: #fff;
  border: 1px solid #e5e7eb;
  border-radius: 14px;
  box-shadow: 0 12px 32px rgba(44,62,107,.10);
  z-index: 999;
  padding: 6px;
  animation: dropIn .18s ease;
}
@keyframes dropIn {
  from { opacity:0; transform:translateY(-6px); }
  to   { opacity:1; transform:translateY(0);    }
}
.nav-dropdown:hover .nav-dropdown-menu,
.nav-dropdown:focus-within .nav-dropdown-menu { display: block; }

/* ── Nested submenu ───────────────────────────── */
.nav-sub-dropdown      { position: relative; }
.nav-sub-dropdown-menu {
  display: none;
  position: absolute;
  top: -6px;
  left: calc(100% + 4px);
  min-width: 210px;
  background: #fff;
  border: 1px solid #e5e7eb;
  border-radius: 14px;
  box-shadow: 0 12px 32px rgba(44,62,107,.10);
  z-index: 1000;
  padding: 6px;
  animation: dropIn .18s ease;
}
/* fallback ke kiri kalau kepotong layar */
@media (max-width: 1100px) {
  .nav-sub-dropdown-menu { left: auto; right: calc(100% + 4px); }
}
.nav-sub-dropdown:hover .nav-sub-dropdown-menu,
.nav-sub-dropdown:focus-within .nav-sub-dropdown-menu { display: block; }

/* ── Menu item base ───────────────────────────── */
.dd-item {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 9px 13px;
  border-radius: 10px;
  font-size: .84rem;
  font-weight: 500;
  color: #374151;
  white-space: nowrap;
  transition: background .15s, color .15s;
  cursor: pointer;
}
.dd-item:hover { background: #f0f7f1; color: #7A9E7E; }
.dd-item.has-sub { justify-content: space-between; }
.dd-item .chevron-right { opacity: .4; transition: opacity .15s; }
.dd-item.has-sub:hover .chevron-right { opacity: 1; }

/* ── Mobile accordion ─────────────────────────── */
.mob-acc-content { max-height: 0; overflow: hidden; transition: max-height .3s ease; }
.mob-acc-content.open { max-height: 800px; }
.mob-acc-btn .acc-arrow { transition: transform .25s; }
.mob-acc-btn.open .acc-arrow { transform: rotate(180deg); }

/* ── Active nav link ──────────────────────────── */
.nav-link.active { color: #7A9E7E; font-weight: 600; }
</style>

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

<!-- ══════════════════════════════════════════════
     TOP BAR
══════════════════════════════════════════════ -->
<div class="bg-navy text-white text-xs py-2 hidden md:block">
  <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
    <span>📍 <?= e(setting('address')) ?></span>
    <span>
      ⏰ <?= e(setting('jam_buka')) ?> &nbsp;|&nbsp;
      📞 <a href="tel:<?= e(setting('whatsapp_number')) ?>" class="hover:text-sky transition"><?= e($phone) ?></a>
    </span>
  </div>
</div>

<!-- ══════════════════════════════════════════════
     NAVBAR
══════════════════════════════════════════════ -->
<nav class="bg-white shadow-sm sticky top-0 z-50 border-b border-cream-dark" id="navbar">
  <div class="max-w-7xl mx-auto px-4">
    <div class="flex items-center justify-between h-16 md:h-20">

      <!-- ── Logo ─────────────────────────────── -->
      <a href="<?= BASE_URL ?>/" class="brand group flex items-center gap-3 flex-shrink-0">
        <div class="w-10 h-10 rounded-full bg-sage flex items-center justify-center shadow overflow-hidden">
          <img src="<?= BASE_URL ?>/assets/images/icon.png" alt="Logo" class="w-full h-full object-cover">
        </div>
        <div>
          <div class="font-serif font-bold text-navy text-base leading-tight"><?= e($site_name) ?></div>
          <div class="text-xs text-sage hidden sm:block"><?= e(setting('site_tagline')) ?></div>
        </div>
      </a>

      <!-- ══════════════════════════════════════
           DESKTOP MENU
      ══════════════════════════════════════ -->
      <div class="hidden md:flex items-center gap-1 text-sm font-medium text-gray-700">

        <!-- Home -->
        <a href="<?= BASE_URL ?>/"
           class="nav-link px-3 py-2 rounded-lg hover:bg-cream hover:text-sage transition <?= $current_slug === '' ? 'active' : '' ?>">
          Home
        </a>

        <!-- Tentang -->
        <a href="<?= BASE_URL ?>/#tentang"
           class="nav-link px-3 py-2 rounded-lg hover:bg-cream hover:text-sage transition">
          Tentang
        </a>

        <!-- Layanan -->
        <a href="<?= BASE_URL ?>/#layanan"
           class="nav-link px-3 py-2 rounded-lg hover:bg-cream hover:text-sage transition">
          Layanan
        </a>

        <!-- ── Produk (mega-dropdown) ──────── -->
        <div class="nav-dropdown">
          <button class="nav-link flex items-center gap-1 px-3 py-2 rounded-lg hover:bg-cream hover:text-sage transition focus:outline-none">
            Produk
            <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>

          <div class="nav-dropdown-menu">
            <?php
            // ── Tentukan tree yang dipakai: DB atau hardcoded fallback ──
            $desktop_tree = [];
            if (!empty($nav_parents)) {
              // DINAMIS dari database
              foreach ($nav_parents as $par) {
                $desktop_tree[] = [
                  'name'     => $par['name'],
                  'slug'     => $par['slug'],
                  'children' => $nav_children[$par['id']] ?? [],
                ];
              }
            } else {
              // FALLBACK hardcoded (slug sesuai INSERT SQL)
              $desktop_tree = [
                ['name'=>'Bunga Papan','slug'=>'bunga-papan-jakarta-utara','children'=>[
                  ['name'=>'Bunga Papan Happy Wedding',    'slug'=>'bunga-papan-happy-wedding-jakarta-utara'],
                  ['name'=>'Bunga Papan Duka Cita',        'slug'=>'bunga-papan-duka-cita-jakarta-utara'],
                  ['name'=>'Bunga Papan Selamat & Sukses', 'slug'=>'bunga-papan-selamat-sukses-jakarta-utara'],
                  ['name'=>'Bunga Papan Congratulations',  'slug'=>'bunga-papan-congratulations-jakarta-utara'],
                  ['name'=>'Bunga Papan Printing',         'slug'=>'bunga-papan-printing-jakarta-utara'],
                  ['name'=>'Bunga Papan Kertas',           'slug'=>'bunga-papan-kertas-jakarta-utara'],
                ]],
                ['name'=>'Hand Bouquet','slug'=>'hand-bouquet-jakarta-utara','children'=>[
                  ['name'=>'Hand Bouquet Anniversary',   'slug'=>'hand-bouquet-anniversary-jakarta-utara'],
                  ['name'=>'Hand Bouquet Birthday',      'slug'=>'hand-bouquet-birthday-jakarta-utara'],
                  ['name'=>'Hand Bouquet Graduation',    'slug'=>'hand-bouquet-graduation-jakarta-utara'],
                  ['name'=>'Hand Bouquet Wedding',       'slug'=>'hand-bouquet-wedding-jakarta-utara'],
                  ['name'=>'Hand Bouquet Get Well Soon', 'slug'=>'hand-bouquet-get-well-soon-jakarta-utara'],
                ]],
                ['name'=>'Bunga Meja',       'slug'=>'bunga-meja-jakarta-utara',       'children'=>[]],
                ['name'=>'Standing Flowers', 'slug'=>'standing-flowers-jakarta-utara', 'children'=>[]],
              ];
            }

            foreach ($desktop_tree as $node):
              $has_kids = !empty($node['children']);
            ?>
              <?php if ($has_kids): ?>
              <!-- Kategori dengan sub-menu -->
              <div class="nav-sub-dropdown">
                <div class="dd-item has-sub">
                  <a href="<?= BASE_URL ?>/<?= e($node['slug']) ?>/" class="flex-1 min-w-0 <?= $current_slug === $node['slug'] ? 'text-sage font-semibold' : '' ?>">
                    <?= e($node['name']) ?>
                  </a>
                  <svg class="chevron-right w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                  </svg>
                </div>
                <div class="nav-sub-dropdown-menu">
                  <?php foreach ($node['children'] as $ch): ?>
                  <a href="<?= BASE_URL ?>/<?= e($ch['slug']) ?>/"
                     class="dd-item <?= $current_slug === $ch['slug'] ? 'text-sage font-semibold' : '' ?>">
                    <?= e($ch['name']) ?>
                  </a>
                  <?php endforeach; ?>
                </div>
              </div>
              <?php else: ?>
              <!-- Kategori tanpa sub-menu -->
              <a href="<?= BASE_URL ?>/<?= e($node['slug']) ?>/"
                 class="dd-item <?= $current_slug === $node['slug'] ? 'text-sage font-semibold' : '' ?>">
                <?= e($node['name']) ?>
              </a>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>
        </div><!-- /nav-dropdown Produk -->

        <!-- Area Kirim -->
        <a href="<?= BASE_URL ?>/#area"
           class="nav-link px-3 py-2 rounded-lg hover:bg-cream hover:text-sage transition">
          Area Kirim
        </a>

        <!-- Testimoni -->
        <a href="<?= BASE_URL ?>/#testimoni"
           class="nav-link px-3 py-2 rounded-lg hover:bg-cream hover:text-sage transition">
          Testimoni
        </a>

        <!-- FAQ -->
        <a href="<?= BASE_URL ?>/#faq"
           class="nav-link px-3 py-2 rounded-lg hover:bg-cream hover:text-sage transition">
          FAQ
        </a>

      </div><!-- /desktop menu -->

      <!-- ── CTA Desktop ───────────────────── -->
      <a href="<?= e($wa_url) ?>" target="_blank" rel="noopener"
         class="hidden md:flex items-center gap-2 bg-sage hover:bg-sage-dark text-white text-sm font-semibold px-5 py-2.5 rounded-full transition shadow-sm flex-shrink-0">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
          <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/>
        </svg>
        Pesan Sekarang
      </a>

      <!-- ── Hamburger Mobile ───────────────── -->
      <button id="menu-btn" class="md:hidden p-2 rounded-lg text-gray-600 hover:bg-cream transition" aria-label="Menu">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>
    </div><!-- /flex row -->


    <!-- ══════════════════════════════════════
         MOBILE MENU
    ══════════════════════════════════════ -->
    <div id="mobile-menu" class="md:hidden hidden pb-4 border-t border-cream-dark mt-2">
      <div class="flex flex-col gap-0.5 pt-2">

        <!-- Home -->
        <a href="<?= BASE_URL ?>/" class="px-4 py-2.5 rounded-xl hover:bg-cream text-sm font-medium text-gray-700 hover:text-sage transition">
          🏠 Home
        </a>

        <!-- Tentang -->
        <a href="<?= BASE_URL ?>/#tentang" class="px-4 py-2.5 rounded-xl hover:bg-cream text-sm font-medium text-gray-700 hover:text-sage transition mob-close">
          💬 Tentang
        </a>

        <!-- Layanan -->
        <a href="<?= BASE_URL ?>/#layanan" class="px-4 py-2.5 rounded-xl hover:bg-cream text-sm font-medium text-gray-700 hover:text-sage transition mob-close">
          🌸 Layanan
        </a>

        <!-- ── Produk accordion ────────────── -->
        <div>
          <button class="mob-acc-btn w-full flex items-center justify-between px-4 py-2.5 rounded-xl hover:bg-cream text-sm font-medium text-gray-700 hover:text-sage transition"
                  onclick="toggleMobAcc(this)">
            <span>🛍️ Produk</span>
            <svg class="acc-arrow w-4 h-4 text-sage opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>
          <div class="mob-acc-content pl-4">

            <?php
            // ── Helper render mobile tree ──
            // Pakai array yang sama: hardcoded kalau DB kosong, dinamis kalau ada

            // Mobile tree pakai $desktop_tree yang sudah dihitung di atas (DB atau fallback)
            $mob_tree = $desktop_tree;

            foreach ($mob_tree as $node):
              $has_kids = !empty($node['children']);
            ?>
              <?php if ($has_kids): ?>
              <!-- sub-accordion -->
              <div class="mt-0.5">
                <button class="mob-acc-btn w-full flex items-center justify-between px-3 py-2 rounded-lg hover:bg-sage/10 text-sm font-medium text-gray-700 hover:text-sage transition"
                        onclick="toggleMobAcc(this)">
                  <span><?= e($node['name']) ?></span>
                  <svg class="acc-arrow w-3.5 h-3.5 text-sage opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                  </svg>
                </button>
                <div class="mob-acc-content pl-3 border-l-2 border-sage/20 ml-3">
                  <!-- Link ke halaman induk -->
                  <a href="<?= BASE_URL ?>/<?= e($node['slug']) ?>/"
                     class="block px-3 py-1.5 text-xs font-semibold text-sage hover:underline mob-close">
                    Lihat semua <?= e($node['name']) ?> →
                  </a>
                  <?php foreach ($node['children'] as $ch): ?>
                  <a href="<?= BASE_URL ?>/<?= e($ch['slug']) ?>/"
                     class="block px-3 py-1.5 text-sm text-gray-600 hover:text-sage transition mob-close">
                    <?= e($ch['name']) ?>
                  </a>
                  <?php endforeach; ?>
                </div>
              </div>
              <?php else: ?>
              <a href="<?= BASE_URL ?>/<?= e($node['slug']) ?>/"
                 class="block px-3 py-2 mt-0.5 rounded-lg hover:bg-sage/10 text-sm font-medium text-gray-700 hover:text-sage transition mob-close">
                <?= e($node['name']) ?>
              </a>
              <?php endif; ?>
            <?php endforeach; ?>

          </div>
        </div><!-- /produk accordion -->

        <!-- Area Kirim -->
        <a href="<?= BASE_URL ?>/#area" class="px-4 py-2.5 rounded-xl hover:bg-cream text-sm font-medium text-gray-700 hover:text-sage transition mob-close">
          📍 Area Kirim
        </a>

        <!-- Testimoni -->
        <a href="<?= BASE_URL ?>/#testimoni" class="px-4 py-2.5 rounded-xl hover:bg-cream text-sm font-medium text-gray-700 hover:text-sage transition mob-close">
          ⭐ Testimoni
        </a>

        <!-- FAQ -->
        <a href="<?= BASE_URL ?>/#faq" class="px-4 py-2.5 rounded-xl hover:bg-cream text-sm font-medium text-gray-700 hover:text-sage transition mob-close">
          ❓ FAQ
        </a>

        <!-- CTA WA -->
        <a href="<?= e($wa_url) ?>" target="_blank"
           class="mt-3 mx-1 flex items-center justify-center gap-2 bg-sage text-white text-sm font-semibold py-3 rounded-full shadow hover:bg-sage-dark transition">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
            <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/>
          </svg>
          Pesan via WhatsApp
        </a>

      </div>
    </div><!-- /mobile-menu -->

  </div>
</nav>

<script>
// ── Hamburger toggle ─────────────────────────────────
const menuBtn  = document.getElementById('menu-btn');
const mobileMenu = document.getElementById('mobile-menu');
menuBtn.addEventListener('click', () => mobileMenu.classList.toggle('hidden'));

// Tutup mobile menu saat klik item anchor
document.querySelectorAll('.mob-close').forEach(el => {
  el.addEventListener('click', () => mobileMenu.classList.add('hidden'));
});

// ── Mobile accordion ─────────────────────────────────
function toggleMobAcc(btn) {
  const content = btn.nextElementSibling;
  const isOpen  = content.classList.contains('open');

  // Tutup semua sibling accordion di level yang sama
  const parent = btn.parentElement.parentElement;
  parent.querySelectorAll(':scope > div > .mob-acc-btn').forEach(b => {
    b.classList.remove('open');
    const c = b.nextElementSibling;
    if (c) c.classList.remove('open');
  });

  if (!isOpen) {
    btn.classList.add('open');
    content.classList.add('open');
  }
}
</script>