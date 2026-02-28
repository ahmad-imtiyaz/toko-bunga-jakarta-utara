

<!-- ============================================================
     TESTIMONIAL SECTION
============================================================ -->
<section id="testimoni" class="py-20 bg-cream">
  <div class="max-w-7xl mx-auto px-4">
    <div class="text-center mb-14">
      <span class="text-sage text-sm font-semibold uppercase tracking-widest">Apa Kata Mereka</span>
      <h2 class="font-serif text-3xl md:text-4xl font-bold text-navy mt-2 mb-4">Testimoni Pelanggan</h2>
      <p class="text-gray-500 max-w-xl mx-auto">Kepercayaan pelanggan adalah motivasi terbesar kami untuk terus memberikan yang terbaik.</p>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php foreach ($testimonials as $t): ?>
      <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition border border-gray-100 relative">
        <!-- Quote mark -->
        <div class="absolute top-4 right-5 text-5xl text-sage/10 font-serif leading-none">"</div>
        <!-- Stars -->
        <div class="flex gap-0.5 mb-4">
          <?php for ($s = 0; $s < (int)$t['rating']; $s++): ?>
          <span class="text-gold text-sm">★</span>
          <?php endfor; ?>
        </div>
        <p class="text-gray-600 text-sm leading-relaxed mb-5">"<?= e($t['content']) ?>"</p>
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-full bg-sage/20 flex items-center justify-center font-serif font-bold text-sage">
            <?= strtoupper(substr($t['name'], 0, 1)) ?>
          </div>
          <div>
            <div class="font-semibold text-navy text-sm"><?= e($t['name']) ?></div>
            <div class="text-gray-400 text-xs"><?= e($t['location']) ?></div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>