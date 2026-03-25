<?php
// blog-detail.php
require_once __DIR__ . '/../includes/config.php';

if (empty($blog)) {
    http_response_code(404);
    require __DIR__ . '/404.php';
    exit;
}

$meta_title    = !empty($blog['meta_title'])    ? $blog['meta_title']    : $blog['title'] . ' - ' . setting('site_name');
$meta_desc     = !empty($blog['meta_desc'])     ? $blog['meta_desc']     : ($blog['excerpt'] ?? '');
$meta_keywords = !empty($blog['meta_keywords']) ? $blog['meta_keywords'] : $blog['title'];

$related = [];
if (!empty($blog['blog_category_id'])) {
    $stmt = db()->prepare("
        SELECT b.id, b.title, b.slug, b.thumbnail, b.excerpt, b.created_at,
               bc.name AS cat_name, bc.slug AS cat_slug
        FROM blogs b
        LEFT JOIN blog_categories bc ON b.blog_category_id = bc.id
        WHERE b.blog_category_id = ? AND b.id != ? AND b.status = 'active'
        ORDER BY b.created_at DESC LIMIT 3
    ");
    $stmt->execute([$blog['blog_category_id'], $blog['id']]);
    $related = $stmt->fetchAll();
}

$blog_cats = db()->query("
    SELECT bc.*, COUNT(b.id) AS total
    FROM blog_categories bc
    LEFT JOIN blogs b ON b.blog_category_id = bc.id AND b.status = 'active'
    WHERE bc.status = 'active'
    GROUP BY bc.id ORDER BY bc.urutan ASC
")->fetchAll();

$sidebar_products = db()->query("
    SELECT id, name, price, image FROM products
    WHERE status = 'active' ORDER BY id DESC LIMIT 20
")->fetchAll();

$locations = db()->query("SELECT * FROM locations WHERE status='active' ORDER BY id")->fetchAll();
$wa_url    = setting('whatsapp_url');
$filter_cat = $blog['cat_slug'] ?? '';

$thumb_url = !empty($blog['thumbnail']) && file_exists(UPLOAD_DIR . $blog['thumbnail'])
             ? UPLOAD_URL . $blog['thumbnail']
             : 'https://images.unsplash.com/photo-1487530811015-780780dde0e4?w=1200&h=630&fit=crop';

require __DIR__ . '/../includes/header.php';
?>

<!-- FIX OVERFLOW GLOBAL -->
<style>
html, body { overflow-x: hidden !important; }
* { box-sizing: border-box; }

/* ── Blog content: semua elemen tidak boleh overflow ── */
.blog-content { word-break: break-word; overflow-wrap: break-word; max-width: 100%; overflow: hidden; }
.blog-content * { box-sizing: border-box; }
.blog-content img { max-width: 100%; height: auto; border-radius: 12px; margin: 1rem auto; display: block; box-shadow: 0 4px 16px rgba(0,0,0,.1); }
.blog-content iframe, .blog-content video, .blog-content embed, .blog-content object { max-width: 100% !important; }
.blog-content table { display: block; width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; border-collapse: collapse; margin: 1.25rem 0; font-size: 0.82rem; }

.blog-content h1 { font-family: 'Playfair Display', serif; font-size: clamp(1.25rem, 5vw, 1.875rem); font-weight: 700; color: #2C3E6B; margin: 1.5rem 0 0.75rem; line-height: 1.3; }
.blog-content h2 { font-family: 'Playfair Display', serif; font-size: clamp(1.1rem, 4vw, 1.5rem); font-weight: 700; color: #2C3E6B; margin: 1.5rem 0 0.75rem; border-bottom: 2px solid #f0f7f1; padding-bottom: 0.5rem; line-height: 1.3; }
.blog-content h3 { font-family: 'Playfair Display', serif; font-size: clamp(1rem, 3.5vw, 1.25rem); font-weight: 600; color: #2C3E6B; margin: 1.25rem 0 0.5rem; line-height: 1.4; }
.blog-content h4, .blog-content h5, .blog-content h6 { font-family: 'Playfair Display', serif; font-weight: 600; color: #374151; margin: 1rem 0 0.5rem; }
.blog-content p  { margin: 0.75rem 0; line-height: 1.8; font-size: clamp(0.875rem, 2.5vw, 1rem); }
.blog-content ul, .blog-content ol { margin: 0.75rem 0 0.75rem 1.25rem; }
.blog-content ul { list-style: disc; }
.blog-content ol { list-style: decimal; }
.blog-content li { margin: 0.35rem 0; line-height: 1.7; font-size: clamp(0.875rem, 2.5vw, 1rem); }
.blog-content strong { color: #2C3E6B; font-weight: 700; }
.blog-content em { color: #5C7C60; }
.blog-content a  { color: #7A9E7E; text-decoration: underline; word-break: break-all; }
.blog-content a:hover { color: #5C7C60; }
.blog-content blockquote { border-left: 4px solid #7A9E7E; background: #f0f7f1; padding: 0.75rem 1rem; margin: 1rem 0; border-radius: 0 12px 12px 0; font-style: italic; color: #374151; font-size: 0.9rem; }
.blog-content th { background: #2C3E6B; color: white; padding: 8px 10px; text-align: left; white-space: nowrap; }
.blog-content td { border: 1px solid #e5e7eb; padding: 7px 10px; }
.blog-content tr:nth-child(even) td { background: #f8fafc; }
.blog-content pre  { background: #1e2d52; color: #e2e8f0; padding: 1rem; border-radius: 12px; overflow-x: auto; font-size: 0.8rem; margin: 1.25rem 0; -webkit-overflow-scrolling: touch; max-width: 100%; }
.blog-content code { background: #f0f7f1; color: #5C7C60; padding: 2px 5px; border-radius: 4px; font-size: 0.82em; word-break: break-all; }
.blog-content pre code { background: none; color: inherit; padding: 0; word-break: normal; }
.blog-content hr { border: none; border-top: 2px solid #f0f7f1; margin: 1.5rem 0; }

@media (max-width: 640px) {
  .blog-content blockquote { padding: 0.6rem 0.75rem; }
  .blog-content ul, .blog-content ol { margin-left: 1rem; }
}
</style>

<!-- FIX: wrapper utama -->
<div style="overflow-x:hidden; width:100%; max-width:100vw;">

<!-- Breadcrumb -->
<div class="bg-white border-b border-cream-dark">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3">
    <nav class="text-xs sm:text-sm text-gray-500 flex items-center gap-1 sm:gap-2 flex-wrap">
      <a href="<?= BASE_URL ?>/" class="hover:text-sage transition" style="flex-shrink:0;">Beranda</a>
      <span style="flex-shrink:0;">›</span>
      <a href="<?= BASE_URL ?>/blog/" class="hover:text-sage transition" style="flex-shrink:0;">Blog</a>
      <?php if (!empty($blog['cat_name'])): ?>
      <span style="flex-shrink:0;">›</span>
      <a href="<?= BASE_URL ?>/blog/?kategori=<?= e($blog['cat_slug']) ?>" class="hover:text-sage transition" style="flex-shrink:0;">
        <?= e($blog['cat_name']) ?>
      </a>
      <?php endif; ?>
      <span style="flex-shrink:0;">›</span>
      <span class="text-navy font-medium" style="overflow:hidden; text-overflow:ellipsis; white-space:nowrap; min-width:0; max-width:150px;"><?= e($blog['title']) ?></span>
    </nav>
  </div>
</div>

<!-- Main Content -->
<section class="py-6 sm:py-10 md:py-12 bg-cream">
  <div class="max-w-7xl mx-auto px-4 sm:px-6">
    <div class="grid lg:grid-cols-4 gap-6 lg:gap-10">

      <!-- ══ ARTIKEL ══ -->
      <article class="lg:col-span-3" style="min-width:0; max-width:100%;">

        <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 mb-5 sm:mb-6">

          <!-- Thumbnail -->
          <div style="width:100%; overflow:hidden; aspect-ratio:16/7; max-height:400px;">
            <img src="<?= e($thumb_url) ?>"
                 alt="<?= e($blog['title']) ?>"
                 style="width:100%; height:100%; object-fit:cover; display:block;">
          </div>

          <div class="p-4 sm:p-6 md:p-8">

            <!-- Kategori + tanggal -->
            <div class="flex items-center flex-wrap gap-2 sm:gap-3 mb-3 sm:mb-4">
              <?php if (!empty($blog['cat_name'])): ?>
              <a href="<?= BASE_URL ?>/blog/?kategori=<?= e($blog['cat_slug']) ?>"
                 class="text-xs font-semibold bg-sage/10 text-sage px-3 py-1 rounded-full hover:bg-sage/20 transition">
                <?= e($blog['cat_name']) ?>
              </a>
              <?php endif; ?>
              <span class="text-xs text-gray-400 flex items-center gap-1">
                <svg class="w-3.5 h-3.5" style="flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <?= date('d F Y', strtotime($blog['created_at'])) ?>
              </span>
            </div>

            <!-- Judul -->
            <h1 class="font-serif font-bold text-navy leading-snug mb-3 sm:mb-4"
                style="font-size: clamp(1.2rem, 5vw, 1.875rem);">
              <?= e($blog['title']) ?>
            </h1>

            <!-- Excerpt -->
            <?php if (!empty($blog['excerpt'])): ?>
            <p class="text-gray-500 leading-relaxed border-l-4 border-sage pl-3 sm:pl-4 mb-4 sm:mb-6 italic"
               style="font-size: clamp(0.875rem, 2.5vw, 1rem);">
              <?= e($blog['excerpt']) ?>
            </p>
            <?php endif; ?>

    

            <!-- Konten Artikel -->
            <div class="blog-content">
              <?= $blog['content'] ?>
            </div>

          </div>
        </div>

        <!-- CTA -->
        <div class="bg-gradient-to-r from-sage to-sage-dark rounded-2xl p-5 sm:p-6 text-center text-white mb-6 sm:mb-8">
          <p class="font-serif text-lg sm:text-xl font-bold mb-1 sm:mb-2">Butuh rangkaian bunga spesial?</p>
          <p class="text-white/80 text-xs sm:text-sm mb-3 sm:mb-4">Konsultasi gratis dengan florist kami via WhatsApp</p>
          <a href="<?= e($wa_url) ?>" target="_blank"
             class="inline-flex items-center gap-2 bg-white text-sage font-bold px-5 sm:px-7 py-2.5 sm:py-3 rounded-full hover:bg-cream transition shadow text-sm">
            💬 Pesan Sekarang
          </a>
        </div>

        <!-- Artikel Terkait -->
        <?php if (!empty($related)): ?>
        <div class="mb-6">
          <h2 class="font-serif text-lg sm:text-xl font-bold text-navy mb-4">Artikel Terkait</h2>
          <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <?php foreach ($related as $rel):
              $rel_thumb = !empty($rel['thumbnail']) && file_exists(UPLOAD_DIR . $rel['thumbnail'])
                           ? UPLOAD_URL . $rel['thumbnail']
                           : 'https://images.unsplash.com/photo-1487530811015-780780dde0e4?w=400&h=250&fit=crop';
            ?>
            <a href="<?= BASE_URL ?>/blog/<?= e($rel['slug']) ?>/"
               class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition border border-gray-100 group block">
              <div class="flex sm:block" style="min-width:0;">
                <div style="width:112px; flex-shrink:0; aspect-ratio:16/9; overflow:hidden;" class="sm:w-full">
                  <img src="<?= e($rel_thumb) ?>" alt="<?= e($rel['title']) ?>"
                       class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                </div>
                <div class="p-3 sm:p-4" style="min-width:0;">
                  <?php if ($rel['cat_name']): ?>
                  <span class="text-xs text-sage font-semibold"><?= e($rel['cat_name']) ?></span>
                  <?php endif; ?>
                  <h3 class="font-serif font-bold text-navy text-xs sm:text-sm mt-0.5 line-clamp-2 group-hover:text-sage transition">
                    <?= e($rel['title']) ?>
                  </h3>
                  <p class="text-xs text-gray-400 mt-1"><?= date('d M Y', strtotime($rel['created_at'])) ?></p>
                </div>
              </div>
            </a>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>

      </article>

      <!-- Sidebar desktop -->
      <div class="hidden lg:block lg:col-span-1">
        <?php include __DIR__ . '/sections/blog-sidebar.php'; ?>
      </div>

    </div>
  </div>
</section>

<!-- Sidebar mobile -->
<section class="lg:hidden py-8 bg-white border-t border-cream-dark">
  <div class="max-w-7xl mx-auto px-4 sm:px-6">
    <?php include __DIR__ . '/sections/blog-sidebar-mobile.php'; ?>
  </div>
</section>

</div><!-- end overflow wrapper -->

<?php require __DIR__ . '/../includes/footer.php'; ?>