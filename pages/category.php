<?php
// $category sudah di-set oleh router
require_once __DIR__ . '/../includes/config.php';

$meta_title    = $category['meta_title']    ?: 'Toko Bunga Jakarta Utara - ' . $category['name'];
$meta_desc     = $category['meta_description'] ?: '';
$meta_keywords = $category['name'] . ', toko bunga jakarta utara, florist jakarta utara';

// Products in this category
$stmt = db()->prepare("SELECT * FROM products WHERE category_id = ? AND status='active' ORDER BY id");
$stmt->execute([$category['id']]);
$products = $stmt->fetchAll();

// All categories for sidebar
$all_cats = db()->query("SELECT * FROM categories WHERE status='active' ORDER BY id")->fetchAll();
$locations = db()->query("SELECT * FROM locations WHERE status='active' ORDER BY id")->fetchAll();
$wa_url    = setting('whatsapp_url');

$locations = db()->query("SELECT * FROM locations WHERE status='active' ORDER BY id")->fetchAll();
$wa_url    = setting('whatsapp_url');

// ── Slider kalkulasi ──
$slider_per_page    = 10;
$slider_total       = count($locations);
$slider_pages       = (int)ceil($slider_total / $slider_per_page);
$slider_active_page = 0; // kategori tidak punya lokasi aktif, mulai dari halaman 1

require __DIR__ . '/../includes/header.php';
?>
<style>
/* ── Konten dari database ── */
.prose-db h1 {
  font-family: serif;
  font-size: 26px !important;
  font-weight: 800 !important;
  color: #1e3a5f !important;
  margin-top: 28px;
  margin-bottom: 12px;
  line-height: 1.2;
}
.prose-db h2 {
  font-family: serif;
  font-size: 22px !important;
  font-weight: 700 !important;
  color: #1e3a5f !important;
  margin-top: 28px;
  margin-bottom: 10px;
  line-height: 1.3;
}
.prose-db h3 {
  font-family: serif;
  font-size: 18px !important;
  font-weight: 700 !important;
  color: #1e3a5f !important;
  margin-top: 28px;
  margin-bottom: 10px;
  line-height: 1.3;
}
.prose-db h4 {
  font-family: serif;
  font-size: 15px !important;
  font-weight: 700 !important;
  color: #1e3a5f !important;
  margin-top: 20px;
  margin-bottom: 8px;
  line-height: 1.3;
}
.prose-db p {
  font-size: 15px;
  line-height: 1.85;
  color: #4b5563;
  margin-bottom: 14px;
}
.prose-db ul {
  list-style: none;
  padding: 0;
  margin: 0 0 16px 0;
}
.prose-db ul li {
  display: flex;
  align-items: flex-start;
  gap: 8px;
  font-size: 14px;
  color: #4b5563;
  line-height: 1.85;
  margin-bottom: 6px;
}
.prose-db ul li::before {
  content: '✅';
  font-size: 12px;
  flex-shrink: 0;
  margin-top: 3px;
}
.prose-db ol {
  list-style: decimal;
  padding-left: 20px;
  margin-bottom: 16px;
}
.prose-db ol li {
  font-size: 14px;
  color: #4b5563;
  line-height: 1.85;
  margin-bottom: 6px;
}
.prose-db strong, .prose-db b { color: #1e3a5f; font-weight: 700; }
.prose-db em, .prose-db i    { font-style: italic; color: #6b7280; }
.prose-db a {
  color: #4a7c6b;
  text-decoration: underline;
  text-underline-offset: 3px;
}
.prose-db a:hover { opacity: .75; }
.prose-db blockquote {
  border-left: 3px solid #4a7c6b;
  margin: 20px 0;
  padding: 10px 16px;
  background: #f5f0e8;
  border-radius: 0 8px 8px 0;
  font-style: italic;
  color: #6b7280;
}
.prose-db table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
  font-size: 13.5px;
}
.prose-db table th {
  background: #1e3a5f;
  color: #fff;
  padding: 9px 13px;
  text-align: left;
  font-weight: 600;
}
.prose-db table td {
  padding: 8px 13px;
  border-bottom: 1px solid #e5e7eb;
  color: #4b5563;
}
.prose-db table tr:nth-child(even) td { background: #f9fafb; }
</style>

<!-- Breadcrumb -->
<div class="bg-white border-b border-cream-dark">
  <div class="max-w-7xl mx-auto px-4 py-3">
    <nav class="text-sm text-gray-500 flex items-center gap-2">
      <a href="<?= BASE_URL ?>/" class="hover:text-sage transition">Beranda</a>
      <span>›</span>
      <span class="text-navy font-medium"><?= e($category['name']) ?></span>
    </nav>
  </div>
</div>

<!-- Hero -->
<section class="relative py-14 md:py-24 overflow-hidden">
  <!-- Background image dari category -->
  <?php if (!empty($category['image'])): ?>
  <div class="absolute inset-0">
    <div class="absolute inset-0 bg-cover bg-center"
         style="background-image: url('<?= e(imgUrl($category['image'], 'category')) ?>')"></div>
    <div class="absolute inset-0 bg-navy/65"></div>
  </div>
  <?php else: ?>
  <div class="absolute inset-0 bg-cream">
    <div class="absolute top-0 right-0 w-64 h-64 bg-sage/10 rounded-full translate-x-1/2 -translate-y-1/2"></div>
  </div>
  <?php endif; ?>

  <div class="relative z-10 max-w-7xl mx-auto px-4">
    <div class="max-w-2xl">
      <h1 class="font-serif text-3xl md:text-5xl font-bold mb-4
                 <?= !empty($category['image']) ? 'text-white' : 'text-navy' ?>">
        <?= e($category['name']) ?> Jakarta Utara
      </h1>
      <p class="text-lg mb-6 <?= !empty($category['image']) ? 'text-white/85' : 'text-gray-600' ?>">
        Toko bunga Jakarta Utara menyediakan <?= e(strtolower($category['name'])) ?> berkualitas tinggi dengan bunga segar pilihan. Pesan sekarang, kirim cepat ke seluruh Jakarta Utara.
      </p>
      <a href="<?= e($wa_url) ?>?text=<?= urlencode('Halo, saya ingin memesan ' . $category['name'] . ' di Jakarta Utara.') ?>" target="_blank"
         class="inline-flex items-center gap-2 bg-sage hover:bg-sage-dark text-white font-bold px-7 py-3.5 rounded-full transition shadow">
        💬 Pesan via WhatsApp
      </a>
    </div>
  </div>
</section>

<!-- Content -->
<section class="py-14 bg-white">
  <div class="max-w-7xl mx-auto px-4">
    <div class="grid lg:grid-cols-4 gap-10">

      <!-- Main content -->
      <div class="lg:col-span-3">
        <!-- Products -->
        <?php if (!empty($products)): ?>
        <h2 class="font-serif text-2xl font-bold text-navy mb-6">Produk <?= e($category['name']) ?></h2>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-5 mb-12">
          <?php foreach ($products as $prod): ?>
          <?php $wa_prod = urlencode("Halo, saya tertarik memesan *{$prod['name']}* seharga " . rupiah($prod['price']) . ". Mohon info selengkapnya."); ?>
          <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition border border-gray-100 group">
            <div class="aspect-[4/3] overflow-hidden bg-cream">
              <img src="<?= e(imgUrl($prod['image'], 'product')) ?>"
                   alt="<?= e($prod['name']) ?> Jakarta Utara"
                   class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
            </div>
            <div class="p-4">
              <h3 class="font-serif font-semibold text-navy text-sm leading-tight mb-1"><?= e($prod['name']) ?></h3>
              <p class="text-gray-400 text-xs mb-3 line-clamp-2"><?= e($prod['description']) ?></p>
              <div class="flex items-center justify-between">
                <span class="font-bold text-sage text-sm"><?= rupiah($prod['price']) ?></span>
                <a href="<?= e($wa_url) ?>?text=<?= $wa_prod ?>" target="_blank"
                   class="bg-sage hover:bg-sage-dark text-white text-xs font-semibold px-3 py-1.5 rounded-full transition">
                  Pesan
                </a>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <div class="max-w-none">
  <h2 class="font-serif text-2xl font-bold text-navy mb-4">
    <?= e($category['name']) ?> Terbaik di Jakarta Utara
  </h2>

  <div class="prose-db">
    <?= $category['content'] ?>
  </div>

  <!-- konten statis di luar prose-db, pakai styling manual -->
  <p class="text-gray-600 text-[15px] leading-relaxed mb-4">
    Kami sebagai <strong class="text-navy font-bold">florist Jakarta Utara</strong> ...
  </p>

  <h3 class="font-serif text-xl font-bold text-navy mt-6 mb-3">
    Mengapa Memilih Kami?
  </h3>
  <ul class="space-y-2">
    <li>✅ Bunga 100% segar berkualitas premium</li>
    <li>✅ Pengiriman cepat 2-4 jam</li>
    <li>✅ Harga transparan mulai Rp 300.000</li>
    <li>✅ Desain custom sesuai keinginan Anda</li>
    <li>✅ Melayani pesanan mendadak 24 jam</li>
  </ul>
          <h3 class="font-serif text-xl font-bold text-navy mt-6 mb-3">Area Pengiriman <?= e($category['name']) ?></h3>
          <p>Kami melayani pengiriman <?= e(strtolower($category['name'])) ?> ke seluruh kecamatan di Jakarta Utara, termasuk:
            <a href="<?= BASE_URL ?>/toko-bunga-penjaringan/" class="text-sage hover:underline">Penjaringan</a>,
            <a href="<?= BASE_URL ?>/toko-bunga-pademangan/" class="text-sage hover:underline">Pademangan</a>,
            <a href="<?= BASE_URL ?>/toko-bunga-tanjung-priok/" class="text-sage hover:underline">Tanjung Priok</a>,
            <a href="<?= BASE_URL ?>/toko-bunga-koja/" class="text-sage hover:underline">Koja</a>,
            <a href="<?= BASE_URL ?>/toko-bunga-cilincing/" class="text-sage hover:underline">Cilincing</a>, dan
            <a href="<?= BASE_URL ?>/toko-bunga-kelapa-gading/" class="text-sage hover:underline">Kelapa Gading</a>.
          </p>
          <h3 class="font-serif text-xl font-bold text-navy mt-6 mb-3">Cara Memesan <?= e($category['name']) ?></h3>
          <p>Pemesanan sangat mudah! Cukup hubungi kami via WhatsApp di <strong><?= e(setting('phone_display')) ?></strong> dengan menginformasikan jenis bunga, alamat pengiriman, tanggal & jam pengiriman, dan pesan yang ingin dituliskan. Tim kami akan segera merespons dalam hitungan menit.</p>
        </div>

        <!-- CTA -->
        <div class="mt-10 bg-cream rounded-2xl p-6 text-center border border-sage/20">
          <p class="font-serif text-xl font-semibold text-navy mb-2">Siap memesan <?= e($category['name']) ?>?</p>
          <p class="text-gray-500 text-sm mb-5">Hubungi kami sekarang dan dapatkan penawaran terbaik!</p>
          <a href="<?= e($wa_url) ?>?text=<?= urlencode('Halo, saya ingin memesan ' . $category['name'] . ' di Jakarta Utara. Mohon info harga dan ketersediaannya.') ?>" target="_blank"
             class="inline-flex items-center gap-2 bg-sage hover:bg-sage-dark text-white font-bold px-8 py-3.5 rounded-full transition shadow">
            💬 Hubungi via WhatsApp Sekarang
          </a>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="lg:col-span-1 space-y-6">
        <!-- Kategori lain -->
        <div class="bg-cream rounded-2xl p-5 border border-cream-dark">
          <h3 class="font-serif font-bold text-navy mb-4">Layanan Lainnya</h3>
          <ul class="space-y-2">
            <?php foreach ($all_cats as $c): ?>
            <li>
              <a href="<?= BASE_URL ?>/<?= e($c['slug']) ?>/"
                 class="flex items-center gap-2 text-sm text-gray-600 hover:text-sage transition py-1 <?= $c['id'] == $category['id'] ? 'font-semibold text-sage' : '' ?>">
                <span class="text-sage text-xs">›</span> <?= e($c['name']) ?>
              </a>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <!-- Area -->
<div class="bg-navy rounded-2xl p-5 text-white">
  <h3 class="font-serif font-bold mb-4 text-sky">Area Pengiriman</h3>

  <?php for ($p = 0; $p < $slider_pages; $p++): ?>
  <ul id="catAreaPage<?= $p ?>"
      style="list-style:none; margin:0; padding:0; min-height:220px;
             <?= $p !== $slider_active_page ? 'display:none;' : '' ?>">
    <?php
    $slice = array_slice($locations, $p * $slider_per_page, $slider_per_page);
    foreach ($slice as $l):
    ?>
    <li>
      <a href="<?= BASE_URL ?>/<?= e($l['slug']) ?>/"
         style="display:flex; align-items:center; gap:8px; font-size:13px; padding:5px 0;
                border-bottom:1px solid rgba(255,255,255,.07); text-decoration:none;
                color:rgba(209,213,219,1);"
         onmouseenter="this.style.color='#7dd3fc'"
         onmouseleave="this.style.color='rgba(209,213,219,1)'">
        <span style="font-size:11px; color:#4a7c6b;">📍</span><?= e($l['name']) ?>
      </a>
    </li>
    <?php endforeach; ?>
  </ul>
  <?php endfor; ?>

  <?php if ($slider_pages > 1): ?>
  <div style="display:flex; align-items:center; justify-content:space-between; margin-top:12px;">
    <button id="catAreaPrev" onclick="catAreaSlider(-1)"
            style="font-size:11px; padding:4px 10px; border-radius:7px;
                   border:1px solid rgba(255,255,255,.15); background:rgba(255,255,255,.07);
                   color:rgba(255,255,255,.5); cursor:pointer;">
      ‹ Prev
    </button>

    <div style="display:flex; gap:4px; align-items:center;">
      <?php for ($p = 0; $p < $slider_pages; $p++): ?>
      <span id="catAreaDot<?= $p ?>" onclick="catAreaGoPage(<?= $p ?>)"
            style="display:inline-block; height:5px; border-radius:3px; cursor:pointer; transition:all .2s;
                   width:<?= $p === $slider_active_page ? '14px' : '5px' ?>;
                   background:<?= $p === $slider_active_page ? '#7dd3fc' : 'rgba(255,255,255,.2)' ?>;"></span>
      <?php endfor; ?>
    </div>

    <button id="catAreaNext" onclick="catAreaSlider(1)"
            style="font-size:11px; padding:4px 10px; border-radius:7px;
                   border:1px solid rgba(255,255,255,.15); background:rgba(255,255,255,.07);
                   color:rgba(255,255,255,.5); cursor:pointer;">
      Next ›
    </button>
  </div>
  <p id="catAreaInfo" style="text-align:center; font-size:11px; color:rgba(255,255,255,.25); margin-top:5px;"></p>
  <?php endif; ?>
</div>

        <!-- WA Card -->
        <div class="bg-green-50 border border-green-200 rounded-2xl p-5 text-center">
          <div class="text-3xl mb-2">💬</div>
          <p class="font-semibold text-gray-800 text-sm mb-1">Butuh bantuan?</p>
          <p class="text-gray-500 text-xs mb-4">Kami siap membantu 24 jam</p>
          <a href="<?= e($wa_url) ?>" target="_blank"
             class="block bg-green-500 hover:bg-green-600 text-white text-sm font-bold py-2.5 rounded-full transition">
            Chat WhatsApp
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
(function() {
  var perPage = <?= $slider_per_page ?>;
  var total   = <?= $slider_total ?>;
  var pages   = <?= $slider_pages ?>;
  var cur     = <?= $slider_active_page ?>;

  function update() {
    for (var i = 0; i < pages; i++) {
      var el = document.getElementById('catAreaPage' + i);
      if (el) el.style.display = (i === cur) ? '' : 'none';
    }
    for (var i = 0; i < pages; i++) {
      var dot = document.getElementById('catAreaDot' + i);
      if (!dot) continue;
      dot.style.width      = (i === cur) ? '14px' : '5px';
      dot.style.background = (i === cur) ? '#7dd3fc' : 'rgba(255,255,255,.2)';
    }
    var prev = document.getElementById('catAreaPrev');
    var next = document.getElementById('catAreaNext');
    if (prev) {
      prev.disabled      = (cur === 0);
      prev.style.opacity = (cur === 0) ? '0.3' : '1';
      prev.style.cursor  = (cur === 0) ? 'not-allowed' : 'pointer';
      prev.onmouseenter  = function() { if (!prev.disabled) { prev.style.background='rgba(255,255,255,.15)'; prev.style.color='#fff'; }};
      prev.onmouseleave  = function() { prev.style.background='rgba(255,255,255,.07)'; prev.style.color='rgba(255,255,255,.5)'; };
    }
    if (next) {
      next.disabled      = (cur === pages - 1);
      next.style.opacity = (cur === pages - 1) ? '0.3' : '1';
      next.style.cursor  = (cur === pages - 1) ? 'not-allowed' : 'pointer';
      next.onmouseenter  = function() { if (!next.disabled) { next.style.background='rgba(255,255,255,.15)'; next.style.color='#fff'; }};
      next.onmouseleave  = function() { next.style.background='rgba(255,255,255,.07)'; next.style.color='rgba(255,255,255,.5)'; };
    }
    var info = document.getElementById('catAreaInfo');
    if (info) {
      var start = cur * perPage + 1;
      var end   = Math.min((cur + 1) * perPage, total);
      info.textContent = start + '–' + end + ' dari ' + total + ' area';
    }
  }

  window.catAreaSlider  = function(dir) { cur = Math.max(0, Math.min(pages - 1, cur + dir)); update(); };
  window.catAreaGoPage  = function(p)   { cur = p; update(); };

  update();
})();
</script>

<?php require __DIR__ . '/../includes/footer.php'; ?>
