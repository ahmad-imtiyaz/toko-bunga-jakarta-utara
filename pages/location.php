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

require __DIR__ . '/../includes/header.php';
?>

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
        <div class="prose max-w-none text-gray-600">
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

          <h3 class="font-serif text-xl font-bold text-navy mt-8 mb-3">Harga Bunga di <?= e($location['name']) ?></h3>
          <p>Kami menawarkan harga yang terjangkau dan transparan untuk semua jenis bunga di <?= e($location['name']) ?>:</p>
          <ul class="space-y-1">
            <li>💐 <strong>Hand Bouquet</strong>: Mulai Rp 300.000</li>
            <li>🌸 <strong>Karangan Bunga Papan</strong>: Mulai Rp 350.000</li>
            <li>🌿 <strong>Standing Flower</strong>: Mulai Rp 500.000</li>
            <li>💍 <strong>Dekorasi Wedding</strong>: Mulai Rp 1.000.000</li>
            <li>🕊️ <strong>Bunga Duka Cita</strong>: Mulai Rp 350.000</li>
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
        <!-- Area lain -->
        <div class="bg-cream rounded-2xl p-5 border border-cream-dark">
          <h3 class="font-serif font-bold text-navy mb-4">Area Lainnya</h3>
          <ul class="space-y-2">
            <?php foreach ($locations as $l): ?>
            <li>
              <a href="<?= BASE_URL ?>/<?= e($l['slug']) ?>/"
                 class="flex items-center gap-2 text-sm py-1 transition <?= $l['id'] == $location['id'] ? 'text-sage font-semibold' : 'text-gray-600 hover:text-sage' ?>">
                <span class="text-xs">📍</span> <?= e($l['name']) ?>
              </a>
            </li>
            <?php endforeach; ?>
          </ul>
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
</script>
