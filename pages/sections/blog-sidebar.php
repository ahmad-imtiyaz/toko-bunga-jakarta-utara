<?php
// blog-sidebar.php
// Variabel yang harus tersedia: $blog_cats, $sidebar_products, $locations, $wa_url, $filter_cat
// Tambahan: $sidebar_categories (dari tabel categories produk)

// Ambil kategori produk untuk slider
$sidebar_categories = db()->query("
    SELECT * FROM categories
    WHERE status = 'active' AND (parent_id IS NULL OR parent_id = 0)
    ORDER BY urutan ASC, id ASC
")->fetchAll();
?>
<aside class="lg:col-span-1 space-y-6">

  <!-- ── Kategori Blog ──────────────────────────────── -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="px-5 py-4 border-b border-cream-dark">
      <h3 class="font-serif font-bold text-navy text-base">Kategori Artikel</h3>
    </div>
    <div class="p-3 max-h-56 overflow-y-auto custom-scrollbar space-y-1">
      <a href="<?= BASE_URL ?>/blog/"
         class="flex items-center justify-between px-3 py-2 rounded-xl hover:bg-sage/10 transition group
                <?= !isset($filter_cat) || !$filter_cat ? 'bg-sage/10 text-sage font-semibold' : 'text-gray-700' ?>">
        <span class="text-sm group-hover:text-sage transition">Semua Artikel</span>
        <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">
          <?= array_sum(array_column($blog_cats, 'total')) ?>
        </span>
      </a>
      <?php foreach ($blog_cats as $bc): ?>
      <a href="<?= BASE_URL ?>/blog/?kategori=<?= e($bc['slug']) ?>"
         class="flex items-center justify-between px-3 py-2 rounded-xl hover:bg-sage/10 transition group
                <?= (isset($filter_cat) && $filter_cat === $bc['slug']) ? 'bg-sage/10 text-sage font-semibold' : 'text-gray-700' ?>">
        <span class="text-sm group-hover:text-sage transition"><?= e($bc['name']) ?></span>
        <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full"><?= $bc['total'] ?></span>
      </a>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- ── Slider Kategori Produk ────────────────────── -->
  <?php if (!empty($sidebar_categories)): ?>
  <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="px-5 py-4 border-b border-cream-dark flex items-center justify-between">
      <h3 class="font-serif font-bold text-navy text-base">Kategori Bunga</h3>
      <div class="flex gap-1">
        <button onclick="slideCatDesktop(-1)"
                class="w-7 h-7 rounded-full bg-sage/10 hover:bg-sage hover:text-white text-sage flex items-center justify-center transition text-sm font-bold">‹</button>
        <button onclick="slideCatDesktop(1)"
                class="w-7 h-7 rounded-full bg-sage/10 hover:bg-sage hover:text-white text-sage flex items-center justify-center transition text-sm font-bold">›</button>
      </div>
    </div>
    <div class="p-3">
      <div id="cat-slider-track-desktop" class="overflow-hidden">
        <div id="cat-slider-inner-desktop" class="flex gap-2 transition-transform duration-300">
          <?php foreach ($sidebar_categories as $sc):
            $cat_img = !empty($sc['image']) && file_exists(UPLOAD_DIR . $sc['image'])
                       ? UPLOAD_URL . $sc['image']
                       : 'https://images.unsplash.com/photo-1490750967868-88df5691cc69?w=120&h=120&fit=crop';
          ?>
          <a href="<?= BASE_URL ?>/<?= e($sc['slug']) ?>/"
             class="flex-shrink-0 w-[calc(50%-4px)] group text-center">
            <div class="aspect-square rounded-xl overflow-hidden mb-2 border border-gray-100 group-hover:border-sage/40 transition">
              <img src="<?= e($cat_img) ?>" alt="<?= e($sc['name']) ?>"
                   class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
            </div>
            <p class="text-xs font-semibold text-navy group-hover:text-sage transition line-clamp-2 leading-tight px-1">
              <?= e($sc['name']) ?>
            </p>
          </a>
          <?php endforeach; ?>
        </div>
      </div>
      <!-- Dots -->
      <div id="cat-dots-desktop" class="flex justify-center gap-1.5 mt-3"></div>
    </div>
  </div>
  <?php endif; ?>

  <!-- ── Produk (Searchable) ────────────────────────── -->
  <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="px-5 py-4 border-b border-cream-dark">
      <h3 class="font-serif font-bold text-navy text-base">Produk Kami</h3>
    </div>
    <div class="px-4 pt-3">
      <input type="text" id="sidebar-product-search-desktop" placeholder="Cari produk..."
             class="w-full px-4 py-2 text-sm border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-sage/30 focus:border-sage transition">
    </div>
    <div class="p-3 max-h-72 overflow-y-auto custom-scrollbar" id="sidebar-product-list-desktop">
      <?php foreach ($sidebar_products as $prod):
        $thumb = !empty($prod['image']) && file_exists(UPLOAD_DIR . $prod['image'])
                 ? UPLOAD_URL . $prod['image']
                 : 'https://images.unsplash.com/photo-1487530811015-780780dde0e4?w=80&h=80&fit=crop';
        $wa_prod = urlencode("Halo, saya tertarik memesan *{$prod['name']}*. Apakah masih tersedia?");
      ?>
      <a href="<?= e($wa_url) ?>?text=<?= $wa_prod ?>" target="_blank" rel="noopener"
         class="sidebar-product-item-desktop flex items-center gap-3 px-2 py-2.5 rounded-xl hover:bg-cream transition group"
         data-name="<?= strtolower(e($prod['name'])) ?>">
        <img src="<?= e($thumb) ?>" alt="<?= e($prod['name']) ?>"
             class="w-12 h-12 rounded-lg object-cover flex-shrink-0">
        <div class="flex-1 min-w-0">
          <p class="text-xs font-semibold text-navy leading-tight line-clamp-2 group-hover:text-sage transition">
            <?= e($prod['name']) ?>
          </p>
          <p class="text-sage text-xs font-bold mt-0.5"><?= rupiah($prod['price']) ?></p>
        </div>
        <svg class="w-4 h-4 text-green-500 flex-shrink-0 opacity-60 group-hover:opacity-100" fill="currentColor" viewBox="0 0 24 24">
          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
          <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/>
        </svg>
      </a>
      <?php endforeach; ?>
      <p id="sidebar-no-product-desktop" class="hidden text-center text-xs text-gray-400 py-4">Produk tidak ditemukan</p>
    </div>
  </div>

  <!-- ── WhatsApp CTA ───────────────────────────────── -->
  <div class="bg-gradient-to-br from-sage to-sage-dark rounded-2xl p-5 text-center text-white">
    <div class="text-3xl mb-2">💬</div>
    <p class="font-serif font-bold text-lg mb-1">Mau Pesan Bunga?</p>
    <p class="text-white/80 text-xs mb-4">Konsultasi gratis via WhatsApp. Kami siap 24 jam!</p>
    <a href="<?= e($wa_url) ?>" target="_blank" rel="noopener"
       class="block bg-white text-sage text-sm font-bold py-2.5 rounded-full hover:bg-cream transition shadow">
      Chat WhatsApp Sekarang
    </a>
  </div>

  <!-- ── Area Pengiriman ────────────────────────────── -->
  <div class="bg-navy rounded-2xl p-5 text-white">
    <h3 class="font-serif font-bold mb-4 text-sky text-base">Area Pengiriman</h3>
    <ul class="space-y-1.5">
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

</aside>

<!-- Scripts sidebar desktop -->
<script>
// ── Product search (desktop) ──────────────────────────────
(function() {
  const input = document.getElementById('sidebar-product-search-desktop');
  const items = document.querySelectorAll('.sidebar-product-item-desktop');
  const noRes = document.getElementById('sidebar-no-product-desktop');
  if (!input) return;
  input.addEventListener('input', function() {
    const q = this.value.toLowerCase().trim();
    let visible = 0;
    items.forEach(item => {
      const show = !q || item.dataset.name.includes(q);
      item.style.display = show ? '' : 'none';
      if (show) visible++;
    });
    noRes.classList.toggle('hidden', visible > 0);
  });
})();

// ── Category slider (desktop) ─────────────────────────────
(function() {
  const inner  = document.getElementById('cat-slider-inner-desktop');
  const dotsEl = document.getElementById('cat-dots-desktop');
  if (!inner) return;

  const items   = inner.querySelectorAll('a');
  const perPage = 2;
  const total   = items.length;
  const pages   = Math.ceil(total / perPage);
  let current   = 0;

  // Build dots
  for (let i = 0; i < pages; i++) {
    const d = document.createElement('button');
    d.className = 'w-2 h-2 rounded-full transition-all ' + (i === 0 ? 'bg-sage w-4' : 'bg-gray-200');
    d.onclick = () => goTo(i);
    dotsEl.appendChild(d);
  }

  function goTo(idx) {
    current = Math.max(0, Math.min(idx, pages - 1));
    const itemW = inner.parentElement.offsetWidth / perPage;
    inner.style.transform = `translateX(-${current * (itemW * perPage + 8)}px)`;
    dotsEl.querySelectorAll('button').forEach((d, i) => {
      d.className = 'w-2 h-2 rounded-full transition-all ' + (i === current ? 'bg-sage !w-4' : 'bg-gray-200');
    });
  }

  window.slideCatDesktop = function(dir) { goTo(current + dir); };
})();
</script>

<style>
.custom-scrollbar::-webkit-scrollbar { width: 4px; }
.custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 4px; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #7A9E7E; border-radius: 4px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #5C7C60; }
#cat-slider-inner-desktop { will-change: transform; }
</style>