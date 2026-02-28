


<!-- ============================================================
     AREA PENGIRIMAN SECTION
============================================================ -->
<section id="area" class="py-20 bg-navy text-white relative overflow-hidden">
  <div class="absolute inset-0 opacity-5">
    <div class="absolute top-10 left-10 text-9xl">🌸</div>
    <div class="absolute bottom-10 right-10 text-9xl">🌺</div>
  </div>
  <div class="relative max-w-7xl mx-auto px-4">
    <div class="text-center mb-14">
      <span class="text-sky text-sm font-semibold uppercase tracking-widest">Jangkauan Layanan</span>
      <h2 class="font-serif text-3xl md:text-4xl font-bold text-white mt-2 mb-4">Area Pengiriman Jakarta Utara</h2>
      <p class="text-gray-300 max-w-xl mx-auto">Kami melayani pengiriman bunga ke seluruh kecamatan di Jakarta Utara dengan cepat dan terpercaya.</p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
      <?php foreach ($locations as $loc): ?>
      <a href="<?= BASE_URL ?>/<?= e($loc['slug']) ?>/"
         class="group bg-white/10 hover:bg-white/20 border border-white/10 hover:border-sky/40 rounded-2xl p-5 transition-all duration-300">
        <div class="flex items-center gap-3 mb-2">
          <div class="w-8 h-8 bg-sage/30 rounded-full flex items-center justify-center text-sm">📍</div>
          <div class="font-serif font-semibold text-white"><?= e($loc['name']) ?></div>
        </div>
        <p class="text-gray-300 text-xs leading-relaxed line-clamp-2"><?= e($loc['address']) ?></p>
        <div class="mt-3 text-sky text-xs font-medium group-hover:underline">
          Lihat layanan di <?= e($loc['name']) ?> →
        </div>
      </a>
      <?php endforeach; ?>
    </div>

    <div class="text-center mt-10">
      <p class="text-gray-300 text-sm">Tidak menemukan area Anda? <a href="<?= e($wa_url) ?>?text=<?= urlencode('Halo, apakah ada layanan pengiriman ke area saya?') ?>" target="_blank" class="text-sky underline hover:text-white transition">Hubungi kami via WhatsApp</a></p>
    </div>
  </div>
</section>