
<!-- ============================================================
     PRODUK SECTION
============================================================ -->
<section id="produk" class="py-20 bg-cream">
  <div class="max-w-7xl mx-auto px-4">
    <div class="text-center mb-14">
      <span class="text-sage text-sm font-semibold uppercase tracking-widest">Koleksi Terbaik Kami</span>
      <h2 class="font-serif text-3xl md:text-4xl font-bold text-navy mt-2 mb-4">Produk Unggulan</h2>
      <p class="text-gray-500 max-w-xl mx-auto">Setiap rangkaian bunga dibuat dengan penuh cinta menggunakan bunga segar pilihan terbaik.</p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
      <?php foreach ($products as $prod): ?>
      <?php
        $img = imgUrl($prod['image'], 'product');
        $wa_prod = urlencode("Halo, saya tertarik memesan *{$prod['name']}* seharga " . rupiah($prod['price']) . ". Apakah masih tersedia?");
      ?>
      <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 group border border-gray-100 hover:border-sage/30">
        <!-- Image -->
        <div class="relative overflow-hidden aspect-[4/3]">
          <img src="<?= e($img) ?>"
               alt="<?= e($prod['name']) ?> Jakarta Utara"
               class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
               loading="lazy">
          <?php if ($prod['cat_name']): ?>
          <span class="absolute top-2 left-2 bg-white/90 backdrop-blur-sm text-sage text-xs font-semibold px-2.5 py-1 rounded-full">
            <?= e($prod['cat_name']) ?>
          </span>
          <?php endif; ?>
        </div>
        <!-- Content -->
        <div class="p-4">
          <h3 class="font-serif font-semibold text-navy text-sm leading-tight mb-1 line-clamp-2">
            <?= e($prod['name']) ?>
          </h3>
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

    <!-- CTA -->
    <div class="text-center mt-10">
      <a href="<?= e($wa_url) ?>?text=<?= urlencode('Halo, saya ingin melihat katalog bunga lengkap Toko Bunga Jakarta Utara.') ?>" target="_blank"
         class="inline-flex items-center gap-2 bg-navy hover:bg-navy-dark text-white font-semibold px-8 py-3.5 rounded-full transition shadow">
        Lihat Semua Produk via WA →
      </a>
    </div>
  </div>
</section>