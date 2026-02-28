
<!-- ============================================================
     KEUNGGULAN SECTION
============================================================ -->
<section id="tentang" class="py-20 bg-white relative overflow-hidden">
  <div class="absolute top-0 right-0 w-80 h-80 bg-sage/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
  <div class="max-w-7xl mx-auto px-4">
    <div class="grid md:grid-cols-2 gap-16 items-center">
     <!-- Image grid aesthetic -->
<div class="grid grid-cols-2 gap-4">
  
  <div class="relative group overflow-hidden rounded-2xl shadow-lg">
    <img src="<?= BASE_URL ?>/assets/images/1d.jpg"
         class="w-full aspect-square object-cover transition duration-700 group-hover:scale-110"
         alt="Buket bunga">
    <div class="absolute inset-0 bg-gradient-to-t from-pink-200/30 to-transparent opacity-0 group-hover:opacity-100 transition"></div>
  </div>

  <div class="relative group overflow-hidden rounded-2xl shadow-lg mt-8">
    <img src="<?= BASE_URL ?>/assets/images/2d.jpg"
         class="w-full aspect-square object-cover transition duration-700 group-hover:scale-110"
         alt="Buket bunga">
    <div class="absolute inset-0 bg-gradient-to-t from-pink-200/30 to-transparent opacity-0 group-hover:opacity-100 transition"></div>
  </div>

  <div class="relative group overflow-hidden rounded-2xl shadow-lg -mt-8">
    <img src="<?= BASE_URL ?>/assets/images/3d.jpg"
         class="w-full aspect-square object-cover transition duration-700 group-hover:scale-110"
         alt="Buket bunga">
    <div class="absolute inset-0 bg-gradient-to-t from-pink-200/30 to-transparent opacity-0 group-hover:opacity-100 transition"></div>
  </div>

  <div class="relative group overflow-hidden rounded-2xl shadow-lg">
    <img src="<?= BASE_URL ?>/assets/images/4d.jpg"
         class="w-full aspect-square object-cover transition duration-700 group-hover:scale-110"
         alt="Buket bunga">
    <div class="absolute inset-0 bg-gradient-to-t from-pink-200/30 to-transparent opacity-0 group-hover:opacity-100 transition"></div>
  </div>

</div>

      <!-- Content -->
      <div>
        <span class="text-sage text-sm font-semibold uppercase tracking-widest">Kenapa Pilih Kami?</span>
        <h2 class="font-serif text-3xl md:text-4xl font-bold text-navy mt-2 mb-4">Florist Terpercaya di Jakarta Utara</h2>
        <p class="text-gray-600 leading-relaxed mb-8"><?= e(setting('about_text')) ?></p>

        <div class="space-y-5">
          <?php
          $features = [
            ['icon'=>'🌺','title'=>'Bunga 100% Segar','desc'=>'Kami hanya menggunakan bunga segar yang dipilih setiap hari dari pasar bunga terbaik.'],
            ['icon'=>'⚡','title'=>'Pengiriman Cepat 2-4 Jam','desc'=>'Armada pengiriman kami siap mengantar ke seluruh Jakarta Utara dengan cepat dan aman.'],
            ['icon'=>'✏️','title'=>'Desain Custom','desc'=>'Tim florist kami siap membuat rangkaian sesuai keinginan dan budget Anda.'],
            ['icon'=>'💰','title'=>'Harga Terjangkau','desc'=>'Harga mulai Rp 300.000 dengan kualitas premium yang tidak mengecewakan.'],
            ['icon'=>'🕐','title'=>'Layanan 24/7','desc'=>'Kami siap menerima pesanan kapan saja, termasuk malam hari dan hari libur.'],
          ];
          foreach ($features as $f): ?>
          <div class="flex gap-4">
            <div class="w-11 h-11 rounded-xl bg-cream flex items-center justify-center text-xl flex-shrink-0"><?= $f['icon'] ?></div>
            <div>
              <div class="font-semibold text-navy text-sm"><?= $f['title'] ?></div>
              <div class="text-gray-500 text-sm mt-0.5"><?= $f['desc'] ?></div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>