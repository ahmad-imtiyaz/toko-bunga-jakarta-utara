<?php
require_once __DIR__ . '/../includes/config.php';

// SEO Meta
$meta_title    = setting('meta_title_home');
$meta_desc     = setting('meta_desc_home');
$meta_keywords = setting('meta_keywords_home');

// Data
$categories = db()->query("SELECT * FROM categories WHERE status='active' ORDER BY id")->fetchAll();
$products   = db()->query("SELECT p.*, c.name as cat_name FROM products p LEFT JOIN categories c ON p.category_id=c.id WHERE p.status='active' ORDER BY p.id LIMIT 8")->fetchAll();
$locations  = db()->query("SELECT * FROM locations WHERE status='active' ORDER BY id")->fetchAll();
$testimonials = db()->query("SELECT * FROM testimonials WHERE status='active' ORDER BY urutan LIMIT 6")->fetchAll();
$faqs       = db()->query("SELECT * FROM faqs WHERE status='active' ORDER BY urutan LIMIT 8")->fetchAll();
$wa_url     = setting('whatsapp_url');
$wa_msg     = urlencode('Halo, saya ingin memesan bunga. Mohon info produk dan harga yang tersedia.');

// Category icons mapping
$cat_icons = ['🌸','🕊️','💍','💐','🌿','🎊','🎁','🌼'];

require __DIR__ . '/../includes/header.php';
?>
<!-- ============================================================
     HERO SECTION — Bento Grid
============================================================ -->
<section class="bg-cream min-h-screen flex items-center py-12 md:py-16 relative overflow-hidden">

  <!-- Decorative background blobs -->
  <div class="absolute top-0 left-0 w-96 h-96 bg-sage/10 rounded-full -translate-x-1/2 -translate-y-1/2 blur-3xl pointer-events-none"></div>
  <div class="absolute bottom-0 right-0 w-80 h-80 bg-pink-100/60 rounded-full translate-x-1/3 translate-y-1/3 blur-3xl pointer-events-none"></div>

  <div class="max-w-7xl mx-auto px-4 w-full">
    <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-center">

      <!-- ─── KIRI: Teks ─── -->
      <div class="order-2 lg:order-1">

        <!-- Badge -->
        <div class="inline-flex items-center gap-2 bg-sage/10 border border-sage/30 rounded-full px-4 py-1.5 text-sage text-sm font-medium mb-6">
          <span class="w-2 h-2 bg-sage rounded-full animate-pulse"></span>
          Florist Terpercaya Jakarta Utara
        </div>

        <!-- H1 -->
        <h1 class="font-serif text-4xl md:text-5xl lg:text-6xl font-bold text-navy leading-[1.1] mb-5">
          <?= e(setting('hero_title')) ?>
        </h1>

        <p class="text-gray-600 text-base md:text-lg leading-relaxed mb-7 max-w-lg">
          <?= e(setting('hero_subtitle')) ?>
        </p>

        <!-- USP Badges -->
      <div class="flex flex-wrap gap-3 mb-8">
  <span class="bg-sage/10 text-sage px-4 py-2 rounded-full text-sm font-medium">
    Pengiriman 24 jam
  </span>
  <span class="bg-sage/10 text-sage px-4 py-2 rounded-full text-sm font-medium">
    Bunga segar premium
  </span>
  <span class="bg-sage/10 text-sage px-4 py-2 rounded-full text-sm font-medium">
    Mulai Rp300.000
  </span>
  <span class="bg-sage/10 text-sage px-4 py-2 rounded-full text-sm font-medium">
    Custom design
  </span>
</div>

        <!-- CTA -->
        <div class="flex flex-col sm:flex-row gap-3 mb-10">
          <a href="<?= e($wa_url) ?>?text=<?= $wa_msg ?>" target="_blank"
             class="inline-flex items-center justify-center gap-2 bg-sage hover:bg-sage-dark text-white font-bold px-8 py-4 rounded-full text-base transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/></svg>
            Pesan via WhatsApp
          </a>
          <a href="#produk"
             class="inline-flex items-center justify-center gap-2 bg-white border-2 border-sage text-sage font-bold px-8 py-4 rounded-full text-base transition-all hover:bg-sage hover:text-white duration-300">
            Lihat Produk ↓
          </a>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-4 gap-4 bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
          <div class="text-center"><div class="font-serif font-bold text-navy text-xl md:text-2xl">500+</div><div class="text-xs text-gray-400 mt-0.5">Pelanggan</div></div>
          <div class="text-center"><div class="font-serif font-bold text-navy text-xl md:text-2xl">10+</div><div class="text-xs text-gray-400 mt-0.5">Tahun</div></div>
          <div class="text-center"><div class="font-serif font-bold text-navy text-xl md:text-2xl">24H</div><div class="text-xs text-gray-400 mt-0.5">Pengiriman</div></div>
          <div class="text-center"><div class="font-serif font-bold text-navy text-xl md:text-2xl">6</div><div class="text-xs text-gray-400 mt-0.5">Kecamatan</div></div>
        </div>

      </div>

      <!-- ─── KANAN: Bento Grid Foto ─── -->
      <div class="order-1 lg:order-2">
        <div class="grid grid-cols-2 grid-rows-3 gap-3 h-[520px] lg:h-[600px]">

          <!-- Cell 1: Besar kiri atas — span 2 baris -->
          <div class="row-span-2 relative overflow-hidden rounded-3xl shadow-lg group">
            <img src="<?= BASE_URL ?>/assets/images/1a.jpg"
                 alt="Buket Bunga Jakarta Utara"
                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
            <div class="absolute inset-0 bg-gradient-to-t from-navy/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <!-- floating label -->
            <div class="absolute bottom-3 left-3 bg-white/90 backdrop-blur-sm rounded-xl px-3 py-1.5 text-xs font-semibold text-navy shadow">
              🌸 Hand Bouquet
            </div>
          </div>

          <!-- Cell 2: Kanan atas kecil -->
          <div class="relative overflow-hidden rounded-3xl shadow-lg group">
            <img src="<?= BASE_URL ?>/assets/images/2a.jpg"
                 alt="Karangan Bunga Papan Jakarta Utara"
                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
            <div class="absolute inset-0 bg-gradient-to-t from-navy/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="absolute bottom-3 left-3 bg-white/90 backdrop-blur-sm rounded-xl px-3 py-1.5 text-xs font-semibold text-navy shadow">
              📋 Bunga Papan
            </div>
          </div>

          <!-- Cell 3: Kanan tengah kecil -->
          <div class="relative overflow-hidden rounded-3xl shadow-lg group">
            <img src="<?= BASE_URL ?>/assets/images/3a.jpg"
                 alt="Bunga Meja Jakarta Utara"
                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
            <div class="absolute inset-0 bg-gradient-to-t from-navy/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="absolute bottom-3 left-3 bg-white/90 backdrop-blur-sm rounded-xl px-3 py-1.5 text-xs font-semibold text-navy shadow">
              🌼 Bunga Meja
            </div>
          </div>

          <!-- Cell 4: Bawah kiri -->
          <div class="relative overflow-hidden rounded-3xl shadow-lg group">
            <img src="<?= BASE_URL ?>/assets/images/4a.jpg"
                 alt="Bunga Duka Cita Jakarta Utara"
                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
            <div class="absolute inset-0 bg-gradient-to-t from-navy/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="absolute bottom-3 left-3 bg-white/90 backdrop-blur-sm rounded-xl px-3 py-1.5 text-xs font-semibold text-navy shadow">
              🕊️ Duka Cita
            </div>
          </div>

          <!-- Cell 5: Bawah kanan — card rating/CTA -->
          <div class="relative overflow-hidden rounded-3xl shadow-lg group">
            <img src="<?= BASE_URL ?>/assets/images/5a.jpg"
                 alt="Bunga Wedding Jakarta Utara"
                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
            <div class="absolute inset-0 bg-gradient-to-t from-navy/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="absolute bottom-3 left-3 bg-white/90 backdrop-blur-sm rounded-xl px-3 py-1.5 text-xs font-semibold text-navy shadow">
              💍 Wedding
            </div>
          </div>

        </div>

        <!-- Floating badge bawah grid -->
        <div class="flex justify-center mt-4">
          <div class="inline-flex items-center gap-3 bg-white border border-gray-100 rounded-2xl px-5 py-3 shadow-md">
            <div class="flex -space-x-2">
              <div class="w-8 h-8 rounded-full bg-pink-200 border-2 border-white flex items-center justify-center text-xs">👩</div>
              <div class="w-8 h-8 rounded-full bg-sage/30 border-2 border-white flex items-center justify-center text-xs">👨</div>
              <div class="w-8 h-8 rounded-full bg-yellow-100 border-2 border-white flex items-center justify-center text-xs">👩</div>
            </div>
            <div>
              <div class="text-xs font-bold text-navy">500+ Pelanggan Puas</div>
              <div class="flex gap-0.5 mt-0.5">
                <span class="text-yellow-400 text-xs">★★★★★</span>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>


<!-- ============================================================
     LAYANAN SECTION
============================================================ -->
<section id="layanan" class="py-20 bg-white">
  <div class="max-w-7xl mx-auto px-4">
    <div class="text-center mb-14">
      <span class="text-sage text-sm font-semibold uppercase tracking-widest">Apa yang Kami Tawarkan</span>
      <h2 class="font-serif text-3xl md:text-4xl font-bold text-navy mt-2 mb-4">Layanan Kami</h2>
      <p class="text-gray-500 max-w-xl mx-auto">Kami menyediakan berbagai jenis rangkaian bunga segar berkualitas tinggi untuk setiap momen spesial Anda di Jakarta Utara.</p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
      <?php foreach ($categories as $i => $cat): ?>
      <?php
        $fallback_colors = ['#FFF0F3','#F0FFF4','#F0F8FF','#FFFBF0','#F8F0FF','#F0FFFC','#FFF8F0','#F5F0FF'];
        $has_img = !empty($cat['image']);
        $img_url = $has_img ? e(imgUrl($cat['image'], 'category')) : '';
      ?>
      <a href="<?= BASE_URL ?>/<?= e($cat['slug']) ?>/"
         class="group relative rounded-2xl overflow-hidden border border-gray-100 hover:border-sage/40 hover:shadow-lg transition-all duration-300 text-center"
         style="<?= !$has_img ? 'background:' . $fallback_colors[$i % count($fallback_colors)] : '' ?>; min-height: 160px;">

        <?php if ($has_img): ?>
        <!-- Background image with zoom on hover -->
        <div class="absolute inset-0 overflow-hidden rounded-2xl">
          <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-110"
               style="background-image: url('<?= $img_url ?>')"></div>
          <!-- Overlay gelap samar -->
          <div class="absolute inset-0 bg-navy/40 group-hover:bg-navy/50 transition-all duration-300"></div>
        </div>
        <?php endif; ?>

        <!-- Content -->
        <div class="relative z-10 p-6 flex flex-col items-center justify-center h-full" style="min-height:160px">
          <!-- icon kalau mau pake tinggal nambah fieeld -->
          <?php if (!empty($cat['icon'])): ?>
          <div class="text-3xl mb-3"><?= e($cat['icon']) ?></div>
          <?php endif; ?>
       <h3 class="font-serif font-semibold text-base md:text-lg text-white bg-black/40 px-3 py-1 rounded-lg backdrop-blur-sm">
  <?= e($cat['name']) ?>
</h3>
          <div class="mt-3 text-xs font-medium transition opacity-0 group-hover:opacity-100
                      <?= $has_img ? 'text-white/90' : 'text-sage' ?>">
            Lihat selengkapnya →
          </div>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

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

<!-- ============================================================
     FAQ SECTION
============================================================ -->
<section id="faq" class="py-20 bg-white">
  <!-- FAQ Schema -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
      <?php foreach ($faqs as $i => $faq): ?>
      {
        "@type": "Question",
        "name": "<?= addslashes($faq['question']) ?>",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "<?= addslashes($faq['answer']) ?>"
        }
      }<?= $i < count($faqs)-1 ? ',' : '' ?>
      <?php endforeach; ?>
    ]
  }
  </script>

  <div class="max-w-4xl mx-auto px-4">
    <div class="text-center mb-14">
      <span class="text-sage text-sm font-semibold uppercase tracking-widest">Ada Pertanyaan?</span>
      <h2 class="font-serif text-3xl md:text-4xl font-bold text-navy mt-2 mb-4">FAQ</h2>
      <p class="text-gray-500">Jawaban atas pertanyaan yang paling sering ditanyakan kepada kami.</p>
    </div>

    <div class="space-y-3" id="faq-list">
      <?php foreach ($faqs as $i => $faq): ?>
      <div class="border border-gray-100 rounded-xl overflow-hidden bg-cream/50" x-data="{open:false}">
        <button onclick="toggleFaq(this)"
                class="w-full flex items-center justify-between px-6 py-4 text-left font-semibold text-navy hover:text-sage transition text-sm md:text-base">
          <?= e($faq['question']) ?>
          <svg class="w-5 h-5 flex-shrink-0 transition-transform faq-icon text-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
        <div class="faq-answer hidden px-6 pb-5 text-gray-600 text-sm leading-relaxed border-t border-gray-100 pt-4">
          <?= e($faq['answer']) ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <div class="text-center mt-10">
      <p class="text-gray-500 text-sm mb-4">Masih ada pertanyaan lain?</p>
      <a href="<?= e($wa_url) ?>?text=<?= urlencode('Halo, saya punya pertanyaan tentang Toko Bunga Jakarta Utara.') ?>" target="_blank"
         class="inline-flex items-center gap-2 bg-sage hover:bg-sage-dark text-white font-semibold px-7 py-3.5 rounded-full transition shadow">
        💬 Tanya via WhatsApp
      </a>
    </div>
  </div>
</section>

<!-- ============================================================
     CTA BANNER SECTION
============================================================ -->
<section class="py-16 bg-gradient-to-r from-sage to-sage-dark text-white relative overflow-hidden">
  <div class="absolute inset-0 opacity-10">
    <div class="absolute top-0 left-0 text-8xl">🌸</div>
    <div class="absolute bottom-0 right-10 text-8xl">💐</div>
    <div class="absolute top-5 right-1/3 text-6xl">🌺</div>
  </div>
  <div class="relative max-w-4xl mx-auto px-4 text-center">
    <h2 class="font-serif text-3xl md:text-4xl font-bold mb-4">Siap Memesan Bunga?</h2>
    <p class="text-white/80 text-lg mb-8 max-w-xl mx-auto">Hubungi kami sekarang dan dapatkan bunga segar terbaik dengan pengiriman cepat ke seluruh Jakarta Utara.</p>
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
      <a href="<?= e($wa_url) ?>?text=<?= urlencode('Halo, saya ingin memesan bunga dari Toko Bunga Jakarta Utara!') ?>" target="_blank"
         class="inline-flex items-center justify-center gap-3 bg-white text-sage font-bold px-8 py-4 rounded-full text-base hover:bg-cream transition shadow-lg">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/></svg>
        Pesan Sekarang via WhatsApp
      </a>
      <a href="tel:<?= e(setting('whatsapp_number')) ?>"
         class="inline-flex items-center justify-center gap-2 bg-white/20 hover:bg-white/30 text-white border border-white/40 font-semibold px-8 py-4 rounded-full text-base transition">
        📞 Telepon Langsung
      </a>
    </div>
  </div>
</section>

<?php require __DIR__ . '/../includes/footer.php'; ?>

<script>
  // Slider Hero
let index = 0;
const slider = document.getElementById('heroSlider');
const totalSlides = slider.children.length;

setInterval(() => {
  index = (index + 1) % totalSlides;
  slider.style.transform = `translateX(-${index * 100}%)`;
}, 5000);

// lain
function toggleFaq(btn) {
  const answer = btn.nextElementSibling;
  const icon   = btn.querySelector('.faq-icon');
  answer.classList.toggle('hidden');
  icon.style.transform = answer.classList.contains('hidden') ? '' : 'rotate(180deg)';
}
</script>