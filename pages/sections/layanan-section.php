
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

    <?php
    // Ambil hanya kategori INDUK (parent_id IS NULL atau 0)
    $parent_cats = array_filter($categories, fn($c) => empty($c['parent_id']) || $c['parent_id'] == 0);
    $parent_cats = array_values($parent_cats);

    // Ambil sub-kategori dan kelompokkan per parent_id
    $sub_cats = db()->query("
        SELECT * FROM categories
        WHERE parent_id IS NOT NULL AND parent_id != 0 AND status = 'active'
        ORDER BY urutan ASC, id ASC
    ")->fetchAll();

    $subs_by_parent = [];
    foreach ($sub_cats as $sc) {
        $subs_by_parent[$sc['parent_id']][] = $sc;
    }
    ?>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
      <?php
      $fallback_colors = ['#FFF0F3','#F0FFF4','#F0F8FF','#FFFBF0','#F8F0FF','#F0FFFC','#FFF8F0','#F5F0FF'];
      foreach ($parent_cats as $i => $cat):
        $has_img   = !empty($cat['image']);
        $img_url   = $has_img ? e(imgUrl($cat['image'], 'category')) : '';
        $children  = $subs_by_parent[$cat['id']] ?? [];
        $has_subs  = !empty($children);
      ?>

      <div class="group relative rounded-2xl overflow-visible border border-gray-100 hover:border-sage/40 hover:shadow-lg transition-all duration-300 text-center layanan-card"
           style="<?= !$has_img ? 'background:' . $fallback_colors[$i % count($fallback_colors)] : '' ?>; min-height: 160px;">

        <?php if ($has_img): ?>
        <div class="absolute inset-0 overflow-hidden rounded-2xl">
          <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-110"
               style="background-image: url('<?= $img_url ?>')"></div>
          <div class="absolute inset-0 bg-navy/40 group-hover:bg-navy/50 transition-all duration-300 rounded-2xl"></div>
        </div>
        <?php endif; ?>

        <!-- Content utama -->
        <div class="relative z-10 p-6 flex flex-col items-center justify-center h-full cursor-pointer"
             style="min-height:160px"
             <?= $has_subs ? 'onclick="toggleLayananSub(this)"' : '' ?>>

          <?php if (!empty($cat['icon'])): ?>
          <div class="text-3xl mb-3"><?= e($cat['icon']) ?></div>
          <?php endif; ?>

          <h3 class="font-serif font-semibold text-base md:text-lg <?= $has_img ? 'text-white bg-black/40' : 'text-navy' ?> px-3 py-1 rounded-lg <?= $has_img ? 'backdrop-blur-sm' : '' ?>">
            <?= e($cat['name']) ?>
          </h3>

          <?php if ($has_subs): ?>
          <!-- Tombol expand — ada sub kategori -->
          <div class="mt-3 flex items-center gap-1 text-xs font-medium transition opacity-0 group-hover:opacity-100 <?= $has_img ? 'text-white/90' : 'text-sage' ?>">
            Lihat kategori
            <svg class="w-3.5 h-3.5 sub-arrow transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </div>
          <?php else: ?>
          <!-- Langsung link — tidak ada sub kategori -->
          <a href="<?= BASE_URL ?>/<?= e($cat['slug']) ?>/"
             class="mt-3 text-xs font-medium transition opacity-0 group-hover:opacity-100 <?= $has_img ? 'text-white/90' : 'text-sage' ?>"
             onclick="event.stopPropagation()">
            Lihat selengkapnya →
          </a>
          <?php endif; ?>
        </div>

        <?php if ($has_subs): ?>
        <!-- ── Sub-kategori dropdown panel ── -->
        <div class="layanan-sub hidden absolute left-0 right-0 top-full mt-2 bg-white border border-gray-100 rounded-2xl shadow-xl z-50 p-3 text-left"
             onclick="event.stopPropagation()">
          <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider px-2 mb-2">
            Pilih kategori <?= e($cat['name']) ?>
          </p>
          <?php foreach ($children as $ch): ?>
          <a href="<?= BASE_URL ?>/<?= e($ch['slug']) ?>/"
             class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-sage/10 hover:text-sage transition text-sm font-medium text-gray-700">
            <span class="w-1.5 h-1.5 rounded-full bg-sage/40 flex-shrink-0"></span>
            <?= e($ch['name']) ?>
          </a>
          <?php endforeach; ?>
          <!-- Link ke halaman induk juga -->
          <div class="border-t border-gray-100 mt-2 pt-2">
            <a href="<?= BASE_URL ?>/<?= e($cat['slug']) ?>/"
               class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-navy/5 text-xs font-semibold text-navy/50 hover:text-navy transition">
              Lihat semua <?= e($cat['name']) ?> →
            </a>
          </div>
        </div>
        <?php endif; ?>

      </div><!-- /layanan-card -->
      <?php endforeach; ?>
    </div>
  </div>
</section>

<style>
/* Pastikan card bisa overflow untuk dropdown */
#layanan .grid { overflow: visible; }
.layanan-card  { position: relative; }
.layanan-sub   { min-width: 220px; }

/* Animasi dropdown */
.layanan-sub.show {
  display: block !important;
  animation: subDropIn .18s ease;
}
@keyframes subDropIn {
  from { opacity:0; transform:translateY(-6px); }
  to   { opacity:1; transform:translateY(0); }
}
</style>

<script>
// Toggle sub-kategori panel
function toggleLayananSub(trigger) {
  const card = trigger.closest('.layanan-card');
  const sub  = card.querySelector('.layanan-sub');
  if (!sub) return;

  const isOpen = sub.classList.contains('show');

  // Tutup semua panel lain dulu
  document.querySelectorAll('.layanan-sub.show').forEach(el => el.classList.remove('show'));
  document.querySelectorAll('.sub-arrow.rotate-180').forEach(el => el.classList.remove('rotate-180'));

  if (!isOpen) {
    sub.classList.add('show');
    trigger.querySelector('.sub-arrow')?.classList.add('rotate-180');
  }
}

// Tutup panel saat klik di luar
document.addEventListener('click', function(e) {
  if (!e.target.closest('.layanan-card')) {
    document.querySelectorAll('.layanan-sub.show').forEach(el => el.classList.remove('show'));
    document.querySelectorAll('.sub-arrow.rotate-180').forEach(el => el.classList.remove('rotate-180'));
  }
});
</script>