<!-- ============================================================
     LAYANAN SECTION — Separated cards layout
============================================================ -->
<section id="layanan" class="py-20 bg-white">
  <div class="max-w-7xl mx-auto px-4">
    <div class="text-center mb-14">
      <span class="text-sage text-sm font-semibold uppercase tracking-widest">Apa yang Kami Tawarkan</span>
      <h2 class="font-serif text-3xl md:text-4xl font-bold text-navy mt-2 mb-4">Layanan Kami</h2>
      <p class="text-gray-500 max-w-xl mx-auto">Kami menyediakan berbagai jenis rangkaian bunga segar berkualitas tinggi untuk setiap momen spesial Anda di Jakarta Utara.</p>
    </div>

    <?php
    $parent_cats = array_filter($categories, fn($c) => empty($c['parent_id']) || $c['parent_id'] == 0);
    $parent_cats = array_values($parent_cats);

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
      <?php foreach ($parent_cats as $i => $cat):
        $has_img  = !empty($cat['image']);
        $img_url  = $has_img ? e(imgUrl($cat['image'], 'category')) : '';
        $children = $subs_by_parent[$cat['id']] ?? [];
        $has_subs = !empty($children);
        $uid      = 'layanan-' . $cat['id'];
      ?>

      <div class="layanan-col flex flex-col gap-2" id="col-<?= $uid ?>">

        <!-- ── BAGIAN 1: GAMBAR ── -->
        <a href="<?= BASE_URL ?>/<?= e($cat['slug']) ?>/"
           class="block relative rounded-2xl overflow-hidden border border-gray-100 group"
           style="aspect-ratio: 16/9;">

          <?php if ($has_img): ?>
          <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-105"
               style="background-image: url('<?= $img_url ?>')"></div>
          <?php else: ?>
          <div class="absolute inset-0 flex items-center justify-center text-5xl bg-gradient-to-br from-pink-100 to-purple-200">
            <?= !empty($cat['icon']) ? e($cat['icon']) : '🌸' ?>
          </div>
          <?php endif; ?>

        </a>

        <!-- ── BAGIAN 2 & 3: BARIS BAWAH ── -->
        <div class="flex gap-2">

          <!-- Judul — card sendiri -->
          <div class="flex items-center rounded-2xl border border-gray-100 bg-white px-4 py-3"
               style="width: 42%; flex-shrink: 0;">
            <h3 class="font-serif font-semibold text-navy text-sm leading-snug">
              <?= e($cat['name']) ?>
            </h3>
          </div>

          <?php if ($has_subs): ?>
          <!-- Tombol lihat kategori — card sendiri -->
          <button onclick="toggleLayanan('<?= $uid ?>', this)"
                  class="layanan-btn flex-1 flex items-center justify-center gap-1.5
                         rounded-2xl border border-gray-100 bg-white
                         text-sage text-xs font-medium px-3 py-3
                         hover:bg-sage/5 hover:border-sage/30 transition-all duration-200">
            Lihat kategori
            <svg class="layanan-arrow w-3.5 h-3.5 transition-transform duration-200"
                 fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
              <path d="M19 9l-7 7-7-7"/>
            </svg>
          </button>

          <?php else: ?>
          <!-- Langsung link jika tidak ada sub -->
          <a href="<?= BASE_URL ?>/<?= e($cat['slug']) ?>/"
             class="flex-1 flex items-center justify-center
                    rounded-2xl border border-gray-100 bg-white
                    text-sage text-xs font-medium px-3 py-3
                    hover:bg-sage/5 hover:border-sage/30 transition-all duration-200">
            Lihat selengkapnya →
          </a>
          <?php endif; ?>

        </div>

        <?php if ($has_subs): ?>
        <!-- ── BAGIAN 4: SUB-KATEGORI (expand) — card sendiri ── -->
        <div id="sub-<?= $uid ?>"
             class="layanan-sub rounded-2xl border border-gray-100 bg-gray-50 overflow-hidden"
             style="max-height:0; opacity:0; transition: max-height .3s ease, opacity .2s ease;">
          <div class="p-3">
            <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider px-1 mb-2">
              Pilih kategori <?= e($cat['name']) ?>
            </p>
            <?php foreach ($children as $ch): ?>
            <a href="<?= BASE_URL ?>/<?= e($ch['slug']) ?>/"
               class="flex items-center gap-2 px-3 py-2 rounded-xl
                      hover:bg-sage/10 hover:text-sage transition text-sm text-gray-700">
              <span class="w-1.5 h-1.5 rounded-full bg-sage/40 flex-shrink-0"></span>
              <?= e($ch['name']) ?>
            </a>
            <?php endforeach; ?>
            <div class="border-t border-gray-200 mt-2 pt-2">
              <a href="<?= BASE_URL ?>/<?= e($cat['slug']) ?>/"
                 class="flex items-center justify-end px-2 py-1
                        text-xs font-semibold text-sage hover:underline transition">
                Lihat semua <?= e($cat['name']) ?> →
              </a>
            </div>
          </div>
        </div>
        <?php endif; ?>

      </div><!-- /layanan-col -->
      <?php endforeach; ?>
    </div>

  </div>
</section>

<style>
.layanan-sub.open {
  max-height: 500px !important;
  opacity: 1 !important;
}
.layanan-btn.open .layanan-arrow {
  transform: rotate(180deg);
}
</style>

<script>
function toggleLayanan(uid, btn) {
  const sub    = document.getElementById('sub-' + uid);
  const isOpen = sub.classList.contains('open');

  // Tutup semua
  document.querySelectorAll('.layanan-sub.open').forEach(el => el.classList.remove('open'));
  document.querySelectorAll('.layanan-btn.open').forEach(el => el.classList.remove('open'));

  // Buka yang diklik jika belum open
  if (!isOpen) {
    sub.classList.add('open');
    btn.classList.add('open');
  }
}

// Tutup jika klik di luar
document.addEventListener('click', function(e) {
  if (!e.target.closest('.layanan-col')) {
    document.querySelectorAll('.layanan-sub.open').forEach(el => el.classList.remove('open'));
    document.querySelectorAll('.layanan-btn.open').forEach(el => el.classList.remove('open'));
  }
});
</script>