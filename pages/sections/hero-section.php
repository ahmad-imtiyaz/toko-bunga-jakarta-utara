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