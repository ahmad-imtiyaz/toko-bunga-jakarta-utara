<?php
// $location sudah di-set oleh router
require_once __DIR__ . '/../includes/config.php';

$meta_title    = $location['meta_title']       ?: 'Toko Bunga ' . $location['name'] . ' Jakarta Utara';
$meta_desc     = $location['meta_description'] ?: '';
$meta_keywords = 'toko bunga ' . strtolower($location['name']) . ', florist ' . strtolower($location['name']) . ', bunga jakarta utara';

$categories = db()->query("SELECT * FROM categories WHERE status='active' ORDER BY id")->fetchAll();
$products   = db()->query("SELECT p.*, c.name as cat_name FROM products p LEFT JOIN categories c ON p.category_id=c.id WHERE p.status='active' ORDER BY RAND() LIMIT 6")->fetchAll();
$locations  = db()->query("SELECT * FROM locations WHERE status='active' ORDER BY id")->fetchAll();
$faqs       = db()->query("SELECT * FROM faqs WHERE status='active' ORDER BY urutan LIMIT 5")->fetchAll();
$wa_url     = setting('whatsapp_url');

// ── Slider kalkulasi (harus di sini, sebelum header) ──
$slider_per_page    = 10;
$slider_total       = count($locations);
$slider_pages       = (int)ceil($slider_total / $slider_per_page);
$slider_active_idx  = array_search($location['id'], array_column($locations, 'id'));
$slider_active_page = ($slider_active_idx !== false) ? (int)floor($slider_active_idx / $slider_per_page) : 0;

require __DIR__ . '/../includes/header.php';
?>
<style>
.loc-content h1 { font-family:'Georgia',serif; font-size:1.9rem; font-weight:800; color:#1a2e4a; margin-bottom:1rem; margin-top:1.5rem; line-height:1.2; }
.loc-content h2 { font-family:'Georgia',serif; font-size:1.45rem; font-weight:700; color:#1a2e4a; margin-bottom:0.75rem; margin-top:1.25rem; line-height:1.3; }
.loc-content h3 { font-family:'Georgia',serif; font-size:1.15rem; font-weight:700; color:#4a7c6b; margin-bottom:0.5rem; margin-top:1rem; }
.loc-content p  { margin-bottom:0.75rem; }
.loc-content ul { list-style:disc; padding-left:1.5rem; margin-bottom:0.75rem; }
.loc-content ol { list-style:decimal; padding-left:1.5rem; margin-bottom:0.75rem; }
.loc-content li { margin-bottom:0.25rem; }
.loc-content strong { color:#1a2e4a; font-weight:700; }
.loc-content em { color:#4a7c6b; font-style:italic; }
.loc-content a  { color:#4a7c6b; text-decoration:underline; transition:color .2s ease; }
.loc-content a:hover { color:#2d5c4a; }
</style>

<!-- Breadcrumb -->
<div class="bg-white border-b border-cream-dark">
  <div class="max-w-7xl mx-auto px-4 py-3">
    <nav class="text-sm text-gray-500 flex items-center gap-2">
      <a href="<?= BASE_URL ?>/" class="hover:text-sage transition">Beranda</a>
      <span>›</span>
      <a href="<?= BASE_URL ?>/#area" class="hover:text-sage transition">Area Pengiriman</a>
      <span>›</span>
      <span class="text-navy font-medium"><?= e($location['name']) ?></span>
    </nav>
  </div>
</div>

<!-- Hero -->
<section class="bg-cream py-14 md:py-20 relative overflow-hidden">
  <div class="absolute top-0 right-0 w-64 h-64 bg-sky/10 rounded-full translate-x-1/2 -translate-y-1/2"></div>
  <div class="max-w-7xl mx-auto px-4">
    <div class="max-w-2xl">
      <div class="inline-flex items-center gap-2 bg-sage/10 border border-sage/30 rounded-full px-4 py-1.5 text-sage text-sm font-medium mb-5">
        📍 <?= e($location['name']) ?>, Jakarta Utara
      </div>
      <h1 class="font-serif text-3xl md:text-5xl font-bold text-navy mb-4">
        Toko Bunga <?= e($location['name']) ?> Jakarta Utara
      </h1>
      <p class="text-gray-600 text-lg mb-6">
        Florist <?= e($location['name']) ?> terpercaya melayani karangan bunga papan, hand bouquet, bunga duka cita, wedding, dan semua kebutuhan bunga Anda. Pengiriman cepat 2-4 jam ke seluruh <?= e($location['name']) ?>.
      </p>
      <div class="flex flex-col sm:flex-row gap-3">
        <a href="<?= e($wa_url) ?>?text=<?= urlencode('Halo, saya ingin memesan bunga di ' . $location['name'] . ', Jakarta Utara.') ?>" target="_blank"
           class="inline-flex items-center justify-center gap-2 bg-sage hover:bg-sage-dark text-white font-bold px-7 py-3.5 rounded-full transition shadow">
          💬 Pesan via WhatsApp
        </a>
        <a href="tel:<?= e(setting('whatsapp_number')) ?>"
           class="inline-flex items-center justify-center gap-2 bg-white border-2 border-sage text-sage font-bold px-7 py-3.5 rounded-full transition hover:bg-cream">
          📞 <?= e(setting('phone_display')) ?>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- Main Content -->
<section class="py-14 bg-white">
  <div class="max-w-7xl mx-auto px-4">
    <div class="grid lg:grid-cols-4 gap-10">

      <!-- Main -->
      <div class="lg:col-span-3 space-y-12">

        <!-- Layanan di area ini -->
        <div>
          <h2 class="font-serif text-2xl font-bold text-navy mb-6">
            Layanan Bunga di <?= e($location['name']) ?>
          </h2>
          <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <?php foreach ($categories as $i => $cat):
              $fallback_colors = ['#FFF0F3','#F0FFF4','#F0F8FF','#FFFBF0','#F8F0FF','#F0FFFC','#FFF8F0','#F5F0FF'];
              $has_img = !empty($cat['image']);
              $img_url = $has_img ? e(imgUrl($cat['image'], 'category')) : '';
            ?>
            <a href="<?= BASE_URL ?>/<?= e($cat['slug']) ?>/"
               class="group relative rounded-xl overflow-hidden border border-gray-100 hover:border-sage/40 hover:shadow-md transition-all duration-300 text-center"
               style="<?= !$has_img ? 'background:' . $fallback_colors[$i % count($fallback_colors)] : '' ?>; min-height: 120px;">
              <?php if ($has_img): ?>
              <div class="absolute inset-0 overflow-hidden rounded-xl">
                <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-110"
                     style="background-image: url('<?= $img_url ?>')"></div>
                <div class="absolute inset-0 bg-navy/40 group-hover:bg-navy/50 transition-all duration-300"></div>
              </div>
              <?php endif; ?>
              <div class="relative z-10 p-4 flex flex-col items-center justify-center h-full" style="min-height:120px">
                <?php if (!empty($cat['icon'])): ?>
                <div class="text-2xl mb-1"><?= e($cat['icon']) ?></div>
                <?php endif; ?>
                <h3 class="font-serif font-semibold text-xs leading-tight
                           <?= $has_img ? 'text-white bg-black/40 px-2 py-1 rounded-lg backdrop-blur-sm' : 'text-navy group-hover:text-sage transition' ?>">
                  <?= e($cat['name']) ?>
                </h3>
                <div class="mt-2 text-xs font-medium opacity-0 group-hover:opacity-100 transition
                            <?= $has_img ? 'text-white/90' : 'text-sage' ?>">
                  Lihat →
                </div>
              </div>
            </a>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Produk -->
        <div>
          <h2 class="font-serif text-2xl font-bold text-navy mb-6">
            Produk Bunga Populer di <?= e($location['name']) ?>
          </h2>
          <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <?php foreach ($products as $prod): ?>
            <?php $wa_prod = urlencode("Halo, saya tertarik memesan *{$prod['name']}* untuk dikirim ke {$location['name']}. Mohon info lebih lanjut."); ?>
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition border border-gray-100 group">
              <div class="aspect-[4/3] overflow-hidden bg-cream">
                <img src="<?= e(imgUrl($prod['image'], 'product')) ?>"
                     alt="<?= e($prod['name']) ?> <?= e($location['name']) ?>"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
              </div>
              <div class="p-3">
                <h3 class="font-semibold text-navy text-xs leading-tight mb-1"><?= e($prod['name']) ?></h3>
                <div class="flex items-center justify-between mt-2">
                  <span class="font-bold text-sage text-xs"><?= rupiah($prod['price']) ?></span>
                  <a href="<?= e($wa_url) ?>?text=<?= $wa_prod ?>" target="_blank"
                     class="bg-sage text-white text-xs px-2.5 py-1 rounded-full hover:bg-sage-dark transition">Pesan</a>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Long form SEO content -->
        <div class="prose max-w-none text-gray-600 loc-content">
          <h2 class="font-serif text-2xl font-bold text-navy mb-4">
            Toko Bunga <?= e($location['name']) ?> Terpercaya & Berpengalaman
          </h2>
          <?= $location['content'] ?>
          <p>Sebagai <strong>toko bunga <?= e(strtolower($location['name'])) ?></strong> yang telah melayani pelanggan selama lebih dari 10 tahun, kami memahami bahwa setiap momen memerlukan rangkaian bunga yang tepat. Tim florist profesional kami siap membantu Anda memilih dan merancang bunga terbaik untuk setiap kebutuhan.</p>

          <h3 class="font-serif text-xl font-bold text-navy mt-8 mb-3">Layanan Florist <?= e($location['name']) ?></h3>
          <p>Kami menyediakan berbagai layanan bunga di <?= e($location['name']) ?>, Jakarta Utara:</p>
          <ul class="space-y-2">
            <?php foreach ($categories as $cat): ?>
            <li>✅ <a href="<?= BASE_URL ?>/<?= e($cat['slug']) ?>/" class="text-sage hover:underline"><?= e($cat['name']) ?></a> di <?= e($location['name']) ?></li>
            <?php endforeach; ?>
          </ul>

          <h3 class="font-serif text-xl font-bold text-navy mt-8 mb-3">Area Lain yang Kami Layani</h3>
          <p>Selain <?= e($location['name']) ?>, kami juga melayani pengiriman ke kecamatan lain di Jakarta Utara:</p>
          <ul class="space-y-1">
            <?php foreach ($locations as $l): ?>
            <?php if ($l['id'] != $location['id']): ?>
            <li>📍 <a href="<?= BASE_URL ?>/<?= e($l['slug']) ?>/" class="text-sage hover:underline">Toko Bunga <?= e($l['name']) ?></a></li>
            <?php endif; ?>
            <?php endforeach; ?>
          </ul>
        </div>

        <!-- FAQ -->
        <?php if (!empty($faqs)): ?>
        <div>
          <h2 class="font-serif text-2xl font-bold text-navy mb-6">FAQ - <?= e($location['name']) ?></h2>
          <div class="space-y-3">
            <?php foreach ($faqs as $faq): ?>
            <div class="border border-gray-100 rounded-xl overflow-hidden bg-cream/50">
              <button onclick="toggleFaq(this)"
                      class="w-full flex items-center justify-between px-5 py-4 text-left font-semibold text-navy hover:text-sage transition text-sm">
                <?= e($faq['question']) ?>
                <svg class="w-4 h-4 flex-shrink-0 faq-icon text-sage transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
              </button>
              <div class="faq-answer hidden px-5 pb-4 text-gray-600 text-sm border-t border-gray-100 pt-3">
                <?= e($faq['answer']) ?>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>

        <!-- CTA -->
        <div class="bg-sage rounded-2xl p-8 text-white text-center">
          <h3 class="font-serif text-2xl font-bold mb-2">Pesan Bunga di <?= e($location['name']) ?> Sekarang!</h3>
          <p class="text-white/80 mb-6">Pengiriman cepat 2-4 jam ke <?= e($location['name']) ?> dan seluruh Jakarta Utara.</p>
          <a href="<?= e($wa_url) ?>?text=<?= urlencode('Halo, saya ingin memesan bunga untuk dikirim ke ' . $location['name'] . ', Jakarta Utara.') ?>" target="_blank"
             class="inline-flex items-center gap-2 bg-white text-sage font-bold px-8 py-3.5 rounded-full transition hover:bg-cream shadow">
            💬 Chat WhatsApp Sekarang
          </a>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="lg:col-span-1 space-y-5">

        <!-- Area Lainnya (Slider) -->
        <div class="bg-cream rounded-2xl p-5 border border-cream-dark">
          <h3 class="font-serif font-bold text-navy mb-3">Area Lainnya</h3>

          <!-- Render semua halaman, hidden kecuali halaman aktif -->
          <?php for ($p = 0; $p < $slider_pages; $p++): ?>
          <ul id="areaPage<?= $p ?>"
              <?= $p !== $slider_active_page ? 'style="display:none"' : '' ?>
              style="min-height:220px; <?= $p !== $slider_active_page ? 'display:none;' : '' ?> list-style:none; margin:0; padding:0;">
            <?php
            $slice = array_slice($locations, $p * $slider_per_page, $slider_per_page);
            foreach ($slice as $l):
            ?>
            <li>
              <a href="<?= BASE_URL ?>/<?= e($l['slug']) ?>/"
                 style="display:flex; align-items:center; gap:8px; font-size:14px; padding:6px 0;
                        border-bottom:1px solid #e5e7eb; text-decoration:none;
                        color:<?= $l['id'] == $location['id'] ? '#4a7c6b' : '#4b5563' ?>;
                        font-weight:<?= $l['id'] == $location['id'] ? '600' : '400' ?>;">
                <span style="font-size:11px;">📍</span><?= e($l['name']) ?>
              </a>
            </li>
            <?php endforeach; ?>
          </ul>
          <?php endfor; ?>

          <!-- Navigasi -->
          <?php if ($slider_pages > 1): ?>
          <div style="display:flex; align-items:center; justify-content:space-between; margin-top:12px;">
            <button id="areaPrev" onclick="areaSlider(-1)"
                    style="font-size:12px; padding:5px 12px; border-radius:8px;
                           border:1px solid #d1d5db; background:#fff; color:#6b7280; cursor:pointer;">
              ‹ Prev
            </button>

            <div id="areaDots" style="display:flex; gap:5px; align-items:center;">
              <?php for ($p = 0; $p < $slider_pages; $p++): ?>
              <span onclick="areaGoPage(<?= $p ?>)"
                    id="areaDot<?= $p ?>"
                    style="display:inline-block; width:<?= $p === $slider_active_page ? '16px' : '6px' ?>;
                           height:6px; border-radius:3px; cursor:pointer; transition:all .2s;
                           background:<?= $p === $slider_active_page ? '#4a7c6b' : '#d1d5db' ?>;"></span>
              <?php endfor; ?>
            </div>

            <button id="areaNext" onclick="areaSlider(1)"
                    style="font-size:12px; padding:5px 12px; border-radius:8px;
                           border:1px solid #d1d5db; background:#fff; color:#6b7280; cursor:pointer;">
              Next ›
            </button>
          </div>

          <p id="areaPageInfo" style="text-align:center; font-size:11px; color:#9ca3af; margin-top:6px;"></p>
          <?php endif; ?>
        </div>

        <!-- Layanan -->
        <div class="bg-navy rounded-2xl p-5 text-white">
          <h3 class="font-serif font-bold mb-4 text-sky">Layanan Kami</h3>
          <ul class="space-y-2">
            <?php foreach ($categories as $c): ?>
            <li>
              <a href="<?= BASE_URL ?>/<?= e($c['slug']) ?>/"
                 class="text-sm text-gray-300 hover:text-sky transition flex items-center gap-1.5">
                <span class="text-sage text-xs">›</span> <?= e($c['name']) ?>
              </a>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <!-- Info -->
        <div class="bg-cream rounded-2xl p-5 border border-cream-dark">
          <h3 class="font-serif font-bold text-navy mb-4">Info Toko</h3>
          <ul class="space-y-3 text-sm text-gray-600">
            <li class="flex gap-2"><span class="text-sage">📞</span> <a href="tel:<?= e(setting('whatsapp_number')) ?>" class="hover:text-sage"><?= e(setting('phone_display')) ?></a></li>
            <li class="flex gap-2"><span class="text-sage">⏰</span> <?= e(setting('jam_buka')) ?></li>
            <li class="flex gap-2"><span class="text-sage">📍</span> <?= e(setting('address')) ?></li>
          </ul>
        </div>
      </div>

    </div>
  </div>
</section>

<?php require __DIR__ . '/../includes/footer.php'; ?>

<script>
function toggleFaq(btn) {
  const answer = btn.nextElementSibling;
  const icon   = btn.querySelector('.faq-icon');
  answer.classList.toggle('hidden');
  icon.style.transform = answer.classList.contains('hidden') ? '' : 'rotate(180deg)';
}

(function() {
  var perPage   = <?= $slider_per_page ?>;
  var total     = <?= $slider_total ?>;
  var pages     = <?= $slider_pages ?>;
  var cur       = <?= $slider_active_page ?>;

  function update() {
    // Tampilkan/sembunyikan halaman
    for (var i = 0; i < pages; i++) {
      var el = document.getElementById('areaPage' + i);
      if (el) el.style.display = (i === cur) ? '' : 'none';
    }

    // Update dots
    for (var i = 0; i < pages; i++) {
      var dot = document.getElementById('areaDot' + i);
      if (!dot) continue;
      dot.style.width      = (i === cur) ? '16px' : '6px';
      dot.style.background = (i === cur) ? '#4a7c6b' : '#d1d5db';
    }

    // Update tombol prev/next
    var prev = document.getElementById('areaPrev');
    var next = document.getElementById('areaNext');
    if (prev) {
      prev.disabled      = (cur === 0);
      prev.style.opacity = (cur === 0) ? '0.35' : '1';
      prev.style.cursor  = (cur === 0) ? 'not-allowed' : 'pointer';
    }
    if (next) {
      next.disabled      = (cur === pages - 1);
      next.style.opacity = (cur === pages - 1) ? '0.35' : '1';
      next.style.cursor  = (cur === pages - 1) ? 'not-allowed' : 'pointer';
    }

    // Hover effect tombol
    [prev, next].forEach(function(btn) {
      if (!btn) return;
      btn.onmouseenter = function() {
        if (!btn.disabled) {
          btn.style.background   = '#4a7c6b';
          btn.style.color        = '#fff';
          btn.style.borderColor  = '#4a7c6b';
        }
      };
      btn.onmouseleave = function() {
        btn.style.background  = '#fff';
        btn.style.color       = '#6b7280';
        btn.style.borderColor = '#d1d5db';
      };
    });

    // Info halaman
    var info = document.getElementById('areaPageInfo');
    if (info) {
      var start = cur * perPage + 1;
      var end   = Math.min((cur + 1) * perPage, total);
      info.textContent = start + '–' + end + ' dari ' + total + ' area';
    }
  }

  window.areaSlider = function(dir) {
    cur = Math.max(0, Math.min(pages - 1, cur + dir));
    update();
  };

  window.areaGoPage = function(p) {
    cur = p;
    update();
  };

  update();
})();
</script>