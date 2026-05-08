<!-- ============================================================
     AREA PENGIRIMAN SECTION
============================================================ -->
<style>
  .area-page-btn {
    width: 36px; height: 36px;
    border-radius: 8px;
    border: 1px solid rgba(255,255,255,.15);
    background: rgba(255,255,255,.07);
    color: rgba(255,255,255,.6);
    font-size: 13px; font-weight: bold;
    cursor: pointer;
    transition: all .2s;
    display: inline-flex; align-items: center; justify-content: center;
  }
  .area-page-btn:hover {
    border-color: #7dd3fc;
    color: #7dd3fc;
    background: rgba(125,211,252,.1);
  }
  .area-page-btn.is-active {
    background: #7dd3fc;
    border-color: #7dd3fc;
    color: #0a1628;
    cursor: default;
  }
  .area-page-btn:disabled {
    opacity: .3; cursor: not-allowed; pointer-events: none;
  }
  .area-page-dots { color: rgba(255,255,255,.3); font-size: 13px; padding: 0 2px; }
  .area-page-info  { text-align: center; margin-top: 8px; font-size: 11px; color: rgba(255,255,255,.3); }
  @keyframes fadeInCard {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  .area-card-anim { animation: fadeInCard .3s ease both; }
</style>

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

    <!-- Grid diisi JS -->
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4" id="area-cards-grid"></div>

    <!-- Pagination -->
    <div style="display:flex;align-items:center;justify-content:center;gap:6px;margin-top:28px;flex-wrap:wrap;" id="area-pagination"></div>
    <p class="area-page-info" id="area-page-info"></p>

    <div class="text-center mt-10">
      <p class="text-gray-300 text-sm">
        Tidak menemukan area Anda?
        <a href="<?= e($wa_url) ?>?text=<?= urlencode('Halo, apakah ada layanan pengiriman ke area saya?') ?>"
           target="_blank" class="text-sky underline hover:text-white transition">Hubungi kami via WhatsApp</a>
      </p>
    </div>
  </div>
</section>

<script>
(function () {
  const PER_PAGE = 9;
  let current = 1;

  const locations = <?= json_encode(array_values(array_map(function($loc) {
    return [
      'name'    => $loc['name'],
      'address' => $loc['address'] ?? '',
      'slug'    => $loc['slug'] ?? '',
    ];
  }, $locations))) ?>;

  const BASE_URL  = '<?= BASE_URL ?>';
  const totalPages = Math.ceil(locations.length / PER_PAGE);

  function renderCards(page) {
    const grid  = document.getElementById('area-cards-grid');
    const start = (page - 1) * PER_PAGE;
    const slice = locations.slice(start, start + PER_PAGE);

    grid.innerHTML = slice.map(function(loc, i) {
      const href = loc.slug ? (BASE_URL + '/' + loc.slug + '/') : '#';
      return '<a href="' + href + '" class="area-card-anim group bg-white/10 hover:bg-white/20 border border-white/10 hover:border-sky/40 rounded-2xl p-5 transition-all duration-300" style="animation-delay:' + (i * 0.04) + 's">' +
        '<div class="flex items-center gap-3 mb-2">' +
          '<div class="w-8 h-8 bg-sage/30 rounded-full flex items-center justify-center text-sm">📍</div>' +
          '<div class="font-serif font-semibold text-white">' + loc.name + '</div>' +
        '</div>' +
        '<p class="text-gray-300 text-xs leading-relaxed line-clamp-2">' + loc.address + '</p>' +
        '<div class="mt-3 text-sky text-xs font-medium group-hover:underline">Lihat layanan di ' + loc.name + ' →</div>' +
      '</a>';
    }).join('');
  }

  function renderPagination(page) {
    const pg   = document.getElementById('area-pagination');
    const info = document.getElementById('area-page-info');
    let html   = '';

    html += '<button class="area-page-btn" ' + (page === 1 ? 'disabled' : 'onclick="areaGoPage(' + (page-1) + ')"') + '>' +
      '<svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>' +
    '</button>';

    for (let i = 1; i <= totalPages; i++) {
      if (i === 1 || i === totalPages || Math.abs(i - page) <= 1) {
        html += '<button class="area-page-btn' + (i === page ? ' is-active' : '') + '"' +
          (i === page ? '' : ' onclick="areaGoPage(' + i + ')"') + '>' + i + '</button>';
      } else if (Math.abs(i - page) === 2) {
        html += '<span class="area-page-dots">…</span>';
      }
    }

    html += '<button class="area-page-btn" ' + (page === totalPages ? 'disabled' : 'onclick="areaGoPage(' + (page+1) + ')"') + '>' +
      '<svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>' +
    '</button>';

    pg.innerHTML = html;
    const s = (page-1)*PER_PAGE + 1, e = Math.min(page*PER_PAGE, locations.length);
    info.textContent = 'Menampilkan ' + s + '–' + e + ' dari ' + locations.length + ' area';
  }

  window.areaGoPage = function(page) {
    if (page < 1 || page > totalPages) return;
    current = page;
    renderCards(current);
    renderPagination(current);
    document.getElementById('area').scrollIntoView({ behavior: 'smooth', block: 'start' });
  };

  renderCards(current);
  renderPagination(current);
})();
</script>