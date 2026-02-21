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

require __DIR__ . '/../includes/header.php';
?>

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
<section class="bg-cream py-14 md:py-20 relative overflow-hidden">
  <div class="absolute top-0 right-0 w-64 h-64 bg-sage/10 rounded-full translate-x-1/2 -translate-y-1/2"></div>
  <div class="max-w-7xl mx-auto px-4">
    <div class="max-w-2xl">
      <h1 class="font-serif text-3xl md:text-5xl font-bold text-navy mb-4"><?= e($category['name']) ?> Jakarta Utara</h1>
      <p class="text-gray-600 text-lg mb-6">Toko bunga Jakarta Utara menyediakan <?= e(strtolower($category['name'])) ?> berkualitas tinggi dengan bunga segar pilihan. Pesan sekarang, kirim cepat ke seluruh Jakarta Utara.</p>
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

        <!-- Long content for SEO -->
        <div class="prose max-w-none text-gray-600">
          <h2 class="font-serif text-2xl font-bold text-navy mb-4"><?= e($category['name']) ?> Terbaik di Jakarta Utara</h2>
          <?= $category['content'] ?>
          <p>Kami sebagai <strong>florist Jakarta Utara</strong> terpercaya menyediakan <?= e(strtolower($category['name'])) ?> berkualitas tinggi dengan harga terjangkau. Setiap rangkaian bunga dibuat oleh tim florist profesional kami menggunakan bunga segar yang dipilih setiap hari.</p>
          <h3 class="font-serif text-xl font-bold text-navy mt-6 mb-3">Mengapa Memilih Kami untuk <?= e($category['name']) ?> di Jakarta Utara?</h3>
          <ul class="space-y-2">
            <li>✅ Bunga 100% segar berkualitas premium</li>
            <li>✅ Pengiriman cepat 2-4 jam ke seluruh Jakarta Utara</li>
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
          <ul class="space-y-2">
            <?php foreach ($locations as $l): ?>
            <li>
              <a href="<?= BASE_URL ?>/<?= e($l['slug']) ?>/"
                 class="flex items-center gap-2 text-sm text-gray-300 hover:text-sky transition py-0.5">
                <span class="text-sage text-xs">📍</span> <?= e($l['name']) ?>
              </a>
            </li>
            <?php endforeach; ?>
          </ul>
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

<?php require __DIR__ . '/../includes/footer.php'; ?>
