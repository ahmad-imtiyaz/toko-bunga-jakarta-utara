<?php
require_once __DIR__ . '/../includes/config.php';

$meta_title    = 'Blog - ' . setting('site_name');
$meta_desc     = 'Artikel, tips, dan inspirasi seputar bunga dari ' . setting('site_name') . '.';
$meta_keywords = 'blog bunga, tips bunga, inspirasi rangkaian, florist jakarta utara';

$filter_cat = isset($_GET['kategori']) ? trim($_GET['kategori']) : '';
$search     = isset($_GET['q'])        ? trim($_GET['q'])        : '';

$per_page    = 9;
$page        = max(1, (int)($_GET['page'] ?? 1));
$offset      = ($page - 1) * $per_page;

$where  = ["b.status = 'active'"];
$params = [];
if ($filter_cat) { $where[] = 'bc.slug = ?'; $params[] = $filter_cat; }
if ($search)     { $where[] = '(b.title LIKE ? OR b.excerpt LIKE ?)'; $params[] = "%$search%"; $params[] = "%$search%"; }
$where_sql = implode(' AND ', $where);

$count_stmt = db()->prepare("SELECT COUNT(*) FROM blogs b LEFT JOIN blog_categories bc ON b.blog_category_id = bc.id WHERE $where_sql");
$count_stmt->execute($params);
$total      = (int)$count_stmt->fetchColumn();
$total_page = (int)ceil($total / $per_page);

$stmt = db()->prepare("
    SELECT b.*, bc.name AS cat_name, bc.slug AS cat_slug
    FROM blogs b
    LEFT JOIN blog_categories bc ON b.blog_category_id = bc.id
    WHERE $where_sql
    ORDER BY b.urutan ASC, b.created_at DESC
    LIMIT $per_page OFFSET $offset
");
$stmt->execute($params);
$blogs = $stmt->fetchAll();

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

require __DIR__ . '/../includes/header.php';
?>

<!-- FIX OVERFLOW: root wrapper -->
<div style="overflow-x:hidden; width:100%;">

<!-- Breadcrumb -->
<div class="bg-white border-b border-cream-dark">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3">
    <nav class="text-sm text-gray-500 flex items-center gap-2 flex-wrap">
      <a href="<?= BASE_URL ?>/" class="hover:text-sage transition">Beranda</a>
      <span>›</span>
      <span class="text-navy font-medium">Blog</span>
      <?php if ($filter_cat): ?>
        <span>›</span>
        <span class="text-navy font-medium capitalize"><?= e($filter_cat) ?></span>
      <?php endif; ?>
    </nav>
  </div>
</div>
<section style="background:#f5efe6; position:relative; overflow:hidden; padding:72px 24px 68px; text-align:center;">

  <!-- Dekorasi SVG natural -->
  <svg style="position:absolute;inset:0;width:100%;height:100%;pointer-events:none;" viewBox="0 0 800 380" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
    <ellipse cx="70" cy="70" rx="64" ry="34" fill="none" stroke="#8aaa78" stroke-width="1.2" opacity="0.45"/>
    <path d="M40 70 Q70 34 100 70" fill="none" stroke="#8aaa78" stroke-width="1" opacity="0.35"/>
    <line x1="70" y1="70" x2="70" y2="104" stroke="#8aaa78" stroke-width="1.2" opacity="0.4"/>
    <ellipse cx="70" cy="46" rx="22" ry="12" fill="#c8d8b8" opacity="0.5"/>
    <ellipse cx="48" cy="63" rx="18" ry="9" fill="#c8d8b8" opacity="0.4" transform="rotate(-28 48 63)"/>
    <ellipse cx="92" cy="63" rx="18" ry="9" fill="#c8d8b8" opacity="0.4" transform="rotate(28 92 63)"/>
    <ellipse cx="740" cy="320" rx="70" ry="38" fill="none" stroke="#8aaa78" stroke-width="1.2" opacity="0.4"/>
    <path d="M708 320 Q740 282 772 320" fill="none" stroke="#8aaa78" stroke-width="1" opacity="0.3"/>
    <line x1="740" y1="320" x2="740" y2="358" stroke="#8aaa78" stroke-width="1.2" opacity="0.35"/>
    <ellipse cx="740" cy="294" rx="26" ry="14" fill="#c8d8b8" opacity="0.45"/>
    <ellipse cx="716" cy="312" rx="20" ry="10" fill="#c8d8b8" opacity="0.35" transform="rotate(-24 716 312)"/>
    <ellipse cx="764" cy="312" rx="20" ry="10" fill="#c8d8b8" opacity="0.35" transform="rotate(24 764 312)"/>
    <ellipse cx="770" cy="55" rx="38" ry="20" fill="none" stroke="#8aaa78" stroke-width="0.9" opacity="0.35"/>
    <ellipse cx="770" cy="40" rx="14" ry="7" fill="#c8d8b8" opacity="0.4"/>
    <line x1="770" y1="55" x2="770" y2="78" stroke="#8aaa78" stroke-width="0.9" opacity="0.3"/>
    <ellipse cx="35" cy="340" rx="32" ry="17" fill="none" stroke="#8aaa78" stroke-width="0.9" opacity="0.35"/>
    <ellipse cx="35" cy="326" rx="12" ry="6" fill="#c8d8b8" opacity="0.4"/>
    <line x1="35" y1="340" x2="35" y2="357" stroke="#8aaa78" stroke-width="0.9" opacity="0.3"/>
    <path d="M-10 230 Q50 200 90 225 Q130 250 180 215" fill="none" stroke="#9ab88a" stroke-width="1.4" opacity="0.25"/>
    <path d="M650 -10 Q680 50 668 110 Q656 170 700 195" fill="none" stroke="#9ab88a" stroke-width="1.4" opacity="0.25"/>
    <path d="M155 340 C175 295 220 318 198 272 C176 226 218 204 206 168" fill="none" stroke="#9ab88a" stroke-width="1.1" opacity="0.2" stroke-dasharray="5 7"/>
    <path d="M628 28 C606 72 648 96 616 142 C584 188 628 212 606 248" fill="none" stroke="#9ab88a" stroke-width="1.1" opacity="0.2" stroke-dasharray="5 7"/>
    <circle cx="210" cy="35" r="4" fill="#8aaa78" opacity="0.35"/>
    <circle cx="590" cy="345" r="4" fill="#8aaa78" opacity="0.35"/>
    <circle cx="320" cy="22" r="3" fill="#8aaa78" opacity="0.2"/>
    <circle cx="480" cy="358" r="3" fill="#8aaa78" opacity="0.2"/>
    <circle cx="400" cy="190" r="260" fill="none" stroke="#9ab88a" stroke-width="0.6" opacity="0.1"/>
    <circle cx="400" cy="190" r="360" fill="none" stroke="#9ab88a" stroke-width="0.6" opacity="0.07"/>
    <circle cx="400" cy="190" r="160" fill="none" stroke="#9ab88a" stroke-width="0.6" opacity="0.08"/>
  </svg>

  <div style="position:relative; z-index:2; max-width:640px; margin:0 auto;">

    <!-- Label pill -->
    <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(90,110,70,0.1);border:1px solid rgba(90,110,70,0.25);border-radius:20px;padding:6px 16px;margin-bottom:20px;">
      <span style="width:7px;height:7px;border-radius:50%;background:#7A9E7E;display:inline-block;"></span>
      <span style="font-size:11px;font-weight:600;letter-spacing:0.12em;text-transform:uppercase;color:#5a6e46;">Artikel &amp; Inspirasi</span>
    </div>

    <!-- Judul -->
    <h1 style="font-family:'Playfair Display',Georgia,serif;font-size:clamp(36px,7vw,60px);font-weight:700;color:#2a3820;line-height:1.15;margin-bottom:14px;letter-spacing:-1px;">
      Blog <span style="color:#7A9E7E;">Bunga</span>
    </h1>

    <!-- Deskripsi -->
    <p style="font-size:15px;color:#6b7c5a;line-height:1.75;margin-bottom:32px;max-width:460px;margin-left:auto;margin-right:auto;">
      Tips merawat bunga, inspirasi rangkaian, dan informasi seputar dunia florist dari <?= e(setting('site_name')) ?>.
    </p>

    <!-- Search -->
    <form method="GET" action="<?= BASE_URL ?>/blog/" style="display:flex;max-width:480px;margin:0 auto;border-radius:14px;overflow:hidden;border:1.5px solid rgba(90,110,70,0.3);background:#fff;">
      <input type="text" name="q" value="<?= e($search) ?>" placeholder="Cari artikel, tips, inspirasi..."
             style="flex:1;padding:14px 20px;font-size:14px;background:transparent;color:#2a3820;border:none;outline:none;min-width:0;">
      <button type="submit" style="padding:14px 24px;background:#5a7a50;color:#f5efe6;font-size:13px;font-weight:600;border:none;cursor:pointer;white-space:nowrap;letter-spacing:0.03em;">
        Cari
      </button>
    </form>

    <!-- Stats -->
    <div style="display:flex;justify-content:center;gap:32px;margin-top:28px;align-items:center;">
      <div style="text-align:center;">
        <div style="font-size:20px;font-weight:700;color:#4a6840;font-family:Georgia,serif;"><?= $total ?></div>
        <div style="font-size:11px;color:#9aaa88;margin-top:3px;letter-spacing:0.06em;">Artikel</div>
      </div>
      <div style="width:1px;background:rgba(90,110,70,0.2);height:36px;"></div>
      <div style="text-align:center;">
        <div style="font-size:20px;font-weight:700;color:#4a6840;font-family:Georgia,serif;"><?= count($blog_cats) ?></div>
        <div style="font-size:11px;color:#9aaa88;margin-top:3px;letter-spacing:0.06em;">Kategori</div>
      </div>
      <div style="width:1px;background:rgba(90,110,70,0.2);height:36px;"></div>
      <div style="text-align:center;">
        <div style="font-size:20px;font-weight:700;color:#4a6840;font-family:Georgia,serif;">Gratis</div>
        <div style="font-size:11px;color:#9aaa88;margin-top:3px;letter-spacing:0.06em;">Untuk semua</div>
      </div>
    </div>

  </div>
</section>

<!-- Main Content -->
<section class="py-8 sm:py-12 md:py-14 bg-cream">
  <div class="max-w-7xl mx-auto px-4 sm:px-6">
    <div class="grid lg:grid-cols-4 gap-6 lg:gap-10">

      <!-- Articles -->
      <div class="lg:col-span-3 min-w-0">

        <!-- Filter kategori — scroll horizontal di mobile, wrap di desktop -->
        <div class="mb-6 sm:mb-8">
          <div class="flex gap-2 overflow-x-auto pb-2 sm:flex-wrap sm:overflow-visible"
               style="-ms-overflow-style:none; scrollbar-width:none;">
            <a href="<?= BASE_URL ?>/blog/"
               class="flex-shrink-0 px-3 sm:px-4 py-1.5 rounded-full text-xs sm:text-sm font-medium transition border <?= !$filter_cat ? 'bg-sage text-white border-sage' : 'bg-white text-gray-600 border-gray-200 hover:border-sage hover:text-sage' ?>">
              Semua
            </a>
            <?php foreach ($blog_cats as $bc): ?>
            <a href="<?= BASE_URL ?>/blog/?kategori=<?= e($bc['slug']) ?>"
               class="flex-shrink-0 px-3 sm:px-4 py-1.5 rounded-full text-xs sm:text-sm font-medium transition border <?= $filter_cat === $bc['slug'] ? 'bg-sage text-white border-sage' : 'bg-white text-gray-600 border-gray-200 hover:border-sage hover:text-sage' ?>">
              <?= e($bc['name']) ?> <span class="opacity-70">(<?= $bc['total'] ?>)</span>
            </a>
            <?php endforeach; ?>
          </div>
        </div>

        <?php if ($search): ?>
        <p class="text-sm text-gray-500 mb-5">
          Hasil pencarian: <strong class="text-navy">"<?= e($search) ?>"</strong> — <?= $total ?> artikel.
          <a href="<?= BASE_URL ?>/blog/" class="text-sage hover:underline ml-2">Reset</a>
        </p>
        <?php endif; ?>

        <?php if (empty($blogs)): ?>
        <div class="text-center py-16 sm:py-20 text-gray-400">
          <div class="text-5xl mb-4">📝</div>
          <p class="font-medium">Belum ada artikel ditemukan.</p>
        </div>
        <?php else: ?>

        <div class="flex flex-col divide-y divide-gray-100">
  <?php foreach ($blogs as $blog):
    $thumb = !empty($blog['thumbnail']) && file_exists(UPLOAD_DIR . $blog['thumbnail'])
             ? UPLOAD_URL . $blog['thumbnail']
             : 'https://images.unsplash.com/photo-1487530811015-780780dde0e4?w=400&h=280&fit=crop';

    $updated = $blog['updated_at'] ?? $blog['created_at'];
    $date_label = date('d M Y', strtotime($updated));

    $content_text = strip_tags($blog['content'] ?? '');
    $char_count = mb_strlen($content_text);
    $char_label = $char_count >= 1000
                  ? round($char_count / 1000, 1) . 'k karakter'
                  : $char_count . ' karakter';

    $read_min = max(1, ceil(mb_strlen($content_text) / 1000));

    $cat_colors = [
      'informasi'  => 'background:#E6F1FB;color:#0C447C;',
      'tips'       => 'background:#EAF3DE;color:#27500A;',
      'pernikahan' => 'background:#FBEAF0;color:#72243E;',
      'dekorasi'   => 'background:#FAEEDA;color:#633806;',
      'perawatan'  => 'background:#E1F5EE;color:#085041;',
    ];
    $cat_key   = strtolower($blog['cat_slug'] ?? '');
    $cat_style = $cat_colors[$cat_key] ?? 'background:#EEEDFE;color:#3C3489;';
  ?>
  <article style="display:flex;flex-direction:row;gap:0;padding:20px 0;align-items:stretch;">

    <!-- Thumbnail kiri -->
    <a href="<?= BASE_URL ?>/blog/<?= e($blog['slug']) ?>/"
       style="flex-shrink:0;width:200px;height:140px;border-radius:12px;overflow:hidden;position:relative;display:block;background:var(--color-bg-secondary);">
      <img src="<?= e($thumb) ?>" alt="<?= e($blog['title']) ?>"
           style="width:100%;height:100%;object-fit:cover;" loading="lazy">
      <span style="position:absolute;bottom:8px;right:8px;background:rgba(0,0,0,0.62);color:#fff;font-size:11px;padding:2px 8px;border-radius:20px;font-weight:500;">
        <?= $read_min ?> mnt baca
      </span>
    </a>

    <!-- Konten kanan -->
    <div style="flex:1;padding-left:20px;display:flex;flex-direction:column;justify-content:space-between;min-width:0;">
      <div style="display:flex;flex-direction:column;gap:8px;">

        <!-- Badge & char count -->
        <div style="display:flex;gap:6px;align-items:center;flex-wrap:wrap;">
          <?php if ($blog['cat_name']): ?>
          <a href="<?= BASE_URL ?>/blog/?kategori=<?= e($blog['cat_slug']) ?>"
             style="font-size:11px;font-weight:500;padding:3px 10px;border-radius:20px;letter-spacing:0.03em;text-transform:uppercase;text-decoration:none;<?= $cat_style ?>">
            <?= e($blog['cat_name']) ?>
          </a>
          <?php endif; ?>
          <span style="font-size:11px;background:var(--color-bg-secondary,#f5f5f3);color:#888;padding:2px 8px;border-radius:20px;border:0.5px solid #e0e0e0;">
            <?= $char_label ?>
          </span>
        </div>

        <!-- Judul -->
        <h2 style="font-size:16px;font-weight:500;line-height:1.4;margin:0;">
          <a href="<?= BASE_URL ?>/blog/<?= e($blog['slug']) ?>/"
   style="
     color:inherit;
     text-decoration:none;
     display:-webkit-box;
     -webkit-line-clamp:2;
     line-clamp:2;
     -webkit-box-orient:vertical;
     overflow:hidden;
     text-overflow:ellipsis;
     word-break:break-word;
   ">
  <?= e($blog['title']) ?>
</a>
        </h2>

        <!-- Excerpt -->
        <?php if ($blog['excerpt']): ?>
        <p style="
  font-size:13px;
  color:#888;
  line-height:1.6;
  margin:0;
  display:-webkit-box;
  -webkit-line-clamp:2;
  line-clamp:2;
  -webkit-box-orient:vertical;
  overflow:hidden;
  text-overflow:ellipsis;
  word-break:break-word;
">
  <?= e($blog['excerpt']) ?>
</p>
        <?php endif; ?>
      </div>

      <!-- Meta bawah -->
      <div style="display:flex;align-items:center;gap:12px;margin-top:10px;flex-wrap:wrap;">
        <span style="font-size:12px;color:#aaa;">Diperbarui <?= $date_label ?></span>
        <span style="width:3px;height:3px;border-radius:50%;background:#ddd;"></span>
        <a href="<?= BASE_URL ?>/blog/<?= e($blog['slug']) ?>/"
           style="font-size:12px;font-weight:500;color:#185FA5;text-decoration:none;">
          Baca selengkapnya →
        </a>
      </div>
    </div>

  </article>
  <?php endforeach; ?>
</div>

        <!-- Pagination -->
        <?php if ($total_page > 1): ?>
        <div class="flex justify-center gap-1.5 sm:gap-2 mt-8 flex-wrap">
          <?php for ($p = 1; $p <= $total_page; $p++):
            $query = array_filter(['kategori' => $filter_cat, 'q' => $search, 'page' => $p > 1 ? $p : null]);
            $qs    = $query ? '?' . http_build_query($query) : '';
          ?>
          <a href="<?= BASE_URL ?>/blog/<?= $qs ?>"
             class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center rounded-full text-xs sm:text-sm font-medium transition
                    <?= $p === $page ? 'bg-sage text-white shadow' : 'bg-white text-gray-600 border border-gray-200 hover:border-sage hover:text-sage' ?>">
            <?= $p ?>
          </a>
          <?php endfor; ?>
        </div>
        <?php endif; ?>
        <?php endif; ?>
      </div>

      <!-- Sidebar desktop -->
      <div class="hidden lg:block lg:col-span-1">
        <?php include __DIR__ . '/sections/blog-sidebar.php'; ?>
      </div>

    </div>
  </div>
</section>

<!-- Sidebar mobile (di bawah konten) -->
<section class="lg:hidden py-8 bg-white border-t border-cream-dark">
  <div class="max-w-7xl mx-auto px-4 sm:px-6">
    <?php include __DIR__ . '/sections/blog-sidebar-mobile.php'; ?>
  </div>
</section>

</div><!-- end overflow-x:hidden wrapper -->

<?php require __DIR__ . '/../includes/footer.php'; ?>