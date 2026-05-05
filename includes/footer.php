<?php
$wa_url  = setting('whatsapp_url');
$wa_msg  = urlencode('Halo, saya ingin memesan bunga dari Toko Bunga Jakarta Utara. Mohon info lebih lanjut.');
$wa_full = $wa_url . '?text=' . $wa_msg;
$cats    = db()->query("SELECT name, slug FROM categories WHERE status='active' ORDER BY id LIMIT 10")->fetchAll();
$locs    = db()->query("SELECT name, slug FROM locations WHERE status='active' ORDER BY id")->fetchAll();
?>

<!-- FOOTER -->
<footer class="bg-navy text-white pt-16 pb-8 mt-0">
  <div class="max-w-7xl mx-auto px-4">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">

      <!-- Brand -->
      <div class="lg:col-span-1">
        <div class="flex items-center gap-3 mb-4 group">
          <div class="w-10 h-10 rounded-full bg-sage flex items-center justify-center shadow overflow-hidden transition duration-300 group-hover:scale-110 group-hover:shadow-lg">
            <img src="<?= BASE_URL ?>/assets/images/icon.png"
                 alt="Logo"
                 class="w-full h-full object-cover transition duration-500 group-hover:rotate-6">
          </div>
          <div class="font-serif font-bold text-lg leading-tight transition duration-300 group-hover:scale-105">
            <?= e(setting('site_name')) ?>
          </div>
        </div>
        <p class="text-gray-300 text-sm leading-relaxed mb-4">
          <?= e(setting('footer_text')) ?>
        </p>
    <!-- ── Marketplace ── -->
        <p class="footer-markets-label">Temukan Kami di</p>
        <div class="footer-markets">
          <a href="https://id.shp.ee/R1iEKrTg"
             target="_blank" rel="noopener"
             class="footer-market-btn" aria-label="Shopee">
            <img src="<?= BASE_URL ?>/assets/svg/shopee.svg" alt="Shopee" width="15" height="15">
            Shopee
          </a>
          <a href="https://www.tiktok.com/@companyflorist?_r=1&_t=ZS-963MFQW40e2"
             target="_blank" rel="noopener"
             class="footer-market-btn" aria-label="TikTok Shop">
            <img src="<?= BASE_URL ?>/assets/svg/tiktok.svg" alt="TikTok Shop" width="15" height="15">
            TikTok Shop
          </a>
          <a href="https://tk.tokopedia.com/ZS999mNA8/"
             target="_blank" rel="noopener"
             class="footer-market-btn" aria-label="Tokopedia">
            <img src="<?= BASE_URL ?>/assets/svg/tokopedia.svg" alt="Tokopedia" width="15" height="15">
            Tokopedia
          </a>
        </div>

       <div class="flex gap-3 mt-4">
          <a href="<?= e($wa_full) ?>" target="_blank"
             class="w-9 h-9 bg-green-500 rounded-full flex items-center justify-center hover:bg-green-400 transition text-sm">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
              <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
              <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/>
            </svg>
          </a>
        </div>
      </div>



      <!-- Layanan -->
      <div>
        <h3 class="font-serif font-semibold text-base mb-4 text-sky-light border-b border-white/10 pb-2">Layanan Kami</h3>
        <ul class="space-y-2">
          <?php foreach ($cats as $cat): ?>
          <li>
            <a href="<?= BASE_URL ?>/<?= e($cat['slug']) ?>/" class="text-gray-300 hover:text-sky text-sm transition flex items-center gap-1.5">
              <span class="text-sage text-xs">›</span> <?= e($cat['name']) ?>
            </a>
          </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <!-- ============================================================
           AREA PENGIRIMAN — SLIDER
           ============================================================ -->
      <div>
        <div class="flex items-center justify-between border-b border-white/10 pb-2 mb-4">
          <h3 class="font-serif font-semibold text-base text-sky-light">Area Pengiriman</h3>
          <span class="fas-badge"><?= count($locs) ?> kota</span>
        </div>

        <!--
          fas-viewport  : overflow:hidden — konten tidak tembus
          fas-track     : flex-row, lebar 100%, JS geser translateX
          fas-item      : data source (display:none), JS baca dan render ulang ke fas-slide
        -->
        <div class="fas-viewport">
          <div class="fas-track" id="fasTrack">
            <?php foreach ($locs as $loc): ?>
            <span class="fas-item"
                  data-name="<?= e($loc['name']) ?>"
                  data-href="<?= BASE_URL ?>/<?= e($loc['slug']) ?>/"></span>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Kontrol navigasi -->
        <div class="fas-controls">
          <div class="fas-dots" id="fasDots"></div>
          <div class="fas-nav">
            <span class="fas-page-lbl" id="fasLbl"></span>
            <button class="fas-btn" id="fasPrev" aria-label="Sebelumnya" disabled>
              <svg width="12" height="12" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M8 2L4 6l4 4"/></svg>
            </button>
            <button class="fas-btn" id="fasNext" aria-label="Berikutnya">
              <svg width="12" height="12" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 2l4 4-4 4"/></svg>
            </button>
          </div>
        </div>
        <p class="fas-hint">Geser untuk lihat area lainnya</p>
      </div>
      <!-- ============================================================ -->

      <!-- Kontak -->
      <div>
        <h3 class="font-serif font-semibold text-base mb-4 text-sky-light border-b border-white/10 pb-2">Hubungi Kami</h3>
        <ul class="space-y-3 text-sm text-gray-300">
          <li class="flex gap-2.5">
            <span class="text-sage mt-0.5">📍</span>
            <span><?= e(setting('address')) ?></span>
          </li>
          <li class="flex gap-2.5">
            <span class="text-sage">📞</span>
            <a href="tel:<?= e(setting('whatsapp_number')) ?>" class="hover:text-white transition"><?= e(setting('phone_display')) ?></a>
          </li>
          <li class="flex gap-2.5">
            <span class="text-sage">✉️</span>
            <a href="mailto:<?= e(setting('email')) ?>" class="hover:text-white transition"><?= e(setting('email')) ?></a>
          </li>
          <li class="flex gap-2.5">
            <span class="text-sage">⏰</span>
            <span><?= e(setting('jam_buka')) ?></span>
          </li>
        </ul>
        <a href="<?= e($wa_full) ?>" target="_blank"
           class="mt-5 inline-flex items-center gap-2 bg-green-500 hover:bg-green-400 text-white text-sm font-semibold px-5 py-2.5 rounded-full transition">
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
            <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/>
          </svg>
          Chat WhatsApp
        </a>
      </div>

    </div>

    <!-- Bottom bar -->
    <div class="border-t border-white/10 pt-6 flex flex-col md:flex-row justify-between items-center gap-3 text-xs text-gray-400">
      <p>© <?= date('Y') ?> <?= e(setting('site_name')) ?>. Hak cipta dilindungi.</p>
      <p>Website Florist Jakarta Utara Terpercaya | Pengiriman 24 Jam</p>
    </div>
  </div>
</footer>

<!-- STICKY WA BUTTON -->
<a href="<?= e($wa_full) ?>" target="_blank" rel="noopener"
   class="fixed bottom-5 right-5 z-50 flex items-center gap-2.5 bg-green-500 hover:bg-green-400 text-white font-semibold text-sm px-4 py-3 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 group"
   aria-label="Chat WhatsApp">
  <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
    <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.861L0 24l6.305-1.508A11.954 11.954 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 01-5.002-1.374l-.36-.214-3.735.893.944-3.639-.234-.374A9.818 9.818 0 1112 21.818z"/>
  </svg>
  <span class="whitespace-nowrap">Pesan Sekarang</span>
  <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full animate-ping"></span>
  <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full"></span>
</a>

<!-- ================================================================
     FOOTER AREA SLIDER — CSS
     Taruh di main.css atau biarkan inline di sini
     ================================================================ -->
<style>
/* Badge jumlah kota */
.fas-badge {
  font-size: 11px;
  background: rgba(110,231,183,.12);
  color: #6ee7b7;
  border: 0.5px solid rgba(110,231,183,.25);
  border-radius: 20px;
  padding: 2px 10px;
  white-space: nowrap;
}

/*
  KUNCI ANTI-TEMBUS:
  fas-viewport  = overflow:hidden, lebar 100%, TIDAK flex
  fas-track     = flex-row, lebar 100% viewport, JS geser translateX
  fas-slide     = flex-direction:column (item turun ke bawah), min-width:100%, flex-shrink:0
*/
.fas-viewport {
  width: 100%;
  overflow: hidden;     /* <-- clip semua yang di luar */
}

.fas-track {
  display: flex;
  flex-direction: row;  /* slide berjajar ke kanan */
  width: 100%;
  transition: transform .38s cubic-bezier(.4,0,.2,1);
  will-change: transform;
}

/* Setiap halaman = 100% lebar viewport, item susun ke bawah */
.fas-slide {
  min-width: 100%;      /* <-- pastikan satu slide = satu lebar penuh */
  width: 100%;
  flex-shrink: 0;
  display: flex;
  flex-direction: column; /* item MENURUN */
  gap: 5px;
  box-sizing: border-box;
}

/* Data source (hidden, untuk SEO) */
.fas-item { display: none !important; }

/* Item kota yang di-render JS */
.fas-link {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 7px 10px;
  background: rgba(255,255,255,.05);
  border: 0.5px solid rgba(255,255,255,.1);
  border-radius: 7px;
  text-decoration: none;
  transition: background .18s, border-color .18s;
  width: 100%;
  box-sizing: border-box;
}
.fas-link:hover,
.fas-link:active {
  background: rgba(255,255,255,.1);
  border-color: rgba(110,231,183,.35);
}
.fas-dot-sage {
  width: 7px;
  height: 7px;
  min-width: 7px;
  border-radius: 50%;
  background: #6ee7b7;
}
.fas-link-name {
  font-size: 12px;
  color: #d1d5db;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

/* Baris kontrol */
.fas-controls {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-top: 12px;
}
.fas-dots { display: flex; gap: 5px; align-items: center; flex-wrap: wrap; }
.fas-dot-btn {
  width: 6px;
  height: 6px;
  min-width: 6px;
  border-radius: 3px;
  background: rgba(255,255,255,.2);
  cursor: pointer;
  transition: background .2s, width .25s;
  border: none;
  padding: 0;
}
.fas-dot-btn.active {
  width: 18px;
  background: #6ee7b7;
}
.fas-nav { display: flex; align-items: center; gap: 6px; }
.fas-page-lbl {
  font-size: 11px;
  color: rgba(255,255,255,.35);
  min-width: 30px;
  text-align: center;
}
.fas-btn {
  width: 28px;
  height: 28px;
  border-radius: 50%;
  border: 0.5px solid rgba(255,255,255,.18);
  background: rgba(255,255,255,.05);
  color: #d1d5db;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background .18s;
  padding: 0;
  flex-shrink: 0;
}
.fas-btn:hover  { background: rgba(255,255,255,.12); }
.fas-btn:disabled { opacity: .25; cursor: default; }

/* Swipe hint — mobile only */
.fas-hint {
  display: none;
  font-size: 10px;
  color: rgba(255,255,255,.25);
  text-align: center;
  margin-top: 6px;
}
/* ─── MARKETPLACE LINKS (navy theme) ─── */
.footer-markets-label {
  font-size: 10.5px;
  font-weight: 600;
  letter-spacing: .14em;
  text-transform: uppercase;
  color: rgba(255,255,255,.28);
  margin-bottom: 9px;
  margin-top: 18px;
}
.footer-markets {
  display: flex;
  gap: 7px;
  flex-wrap: wrap;
}
.footer-market-btn {
  display: flex;
  align-items: center;
  gap: 6px;
  padding: 7px 13px;
  background: rgba(255,255,255,.06);
  border: 1px solid rgba(255,255,255,.1);
  border-radius: 8px;
  text-decoration: none;
  color: rgba(255,255,255,.55);
  font-size: 12px;
  font-weight: 600;
  white-space: nowrap;
  transition: background .22s, border-color .22s, color .22s, transform .22s;
}
.footer-market-btn:hover {
  background: rgba(110,231,183,.1);
  border-color: rgba(110,231,183,.35);
  color: #6ee7b7;
  transform: translateY(-2px);
}
.footer-market-btn img {
  width: 15px;
  height: 15px;
  object-fit: contain;
  opacity: .8;
  flex-shrink: 0;
  transition: opacity .22s, transform .22s;
}
.footer-market-btn:hover img {
  opacity: 1;
  transform: scale(1.12);
}
/* ---- RESPONSIVE ---- */
@media (max-width: 767px) {
  .fas-btn  { width: 34px; height: 34px; }
  .fas-hint { display: block; }
}

</style>

<!-- ================================================================
     FOOTER AREA SLIDER — JS
     ================================================================ -->
<script>
(function () {
  var track  = document.getElementById('fasTrack');
  var dotsEl = document.getElementById('fasDots');
  var lbl    = document.getElementById('fasLbl');
  var btnPrev = document.getElementById('fasPrev');
  var btnNext = document.getElementById('fasNext');
  if (!track) return;

  /* Ambil data dari DOM (PHP render, SEO tetap aman) */
  var cities = Array.from(track.querySelectorAll('.fas-item')).map(function (el) {
    return { name: el.dataset.name, href: el.dataset.href };
  });

  var cur     = 0;
  var perPage = 0; /* 0 = paksa rebuild pertama kali */

  function isMobile() { return window.innerWidth < 768; }

  function chunk(arr, n) {
    var r = [];
    for (var i = 0; i < arr.length; i += n) r.push(arr.slice(i, i + n));
    return r;
  }

  function rebuild() {
    var pp = isMobile() ? 4 : 5;
    if (pp === perPage && track.querySelectorAll('.fas-slide').length > 0) return;
    perPage = pp;

    var pages = chunk(cities, perPage);

    /* Hapus slide lama */
    Array.from(track.querySelectorAll('.fas-slide')).forEach(function (s) { track.removeChild(s); });

    /* Reset posisi tanpa animasi */
    track.style.transition = 'none';
    track.style.transform  = 'translateX(0)';

    /* Buat slide baru */
    pages.forEach(function (page) {
      var slide = document.createElement('div');
      slide.className = 'fas-slide';
      page.forEach(function (city) {
        var a = document.createElement('a');
        a.className = 'fas-link';
        a.href = city.href;
        a.innerHTML =
          '<span class="fas-dot-sage"></span>' +
          '<span class="fas-link-name">' + city.name + '</span>';
        slide.appendChild(a);
      });
      track.appendChild(slide);
    });

    /* Rebuild dots */
    dotsEl.innerHTML = '';
    pages.forEach(function (_, i) {
      var d = document.createElement('button');
      d.className = 'fas-dot-btn';
      d.setAttribute('aria-label', 'Halaman ' + (i + 1));
      (function (idx) {
        d.addEventListener('click', function () { goTo(idx); });
      })(i);
      dotsEl.appendChild(d);
    });

    if (cur >= pages.length) cur = pages.length - 1;
    goTo(cur, true);
  }

  function goTo(n, instant) {
    var total = track.querySelectorAll('.fas-slide').length;
    cur = Math.max(0, Math.min(n, total - 1));

    if (instant) {
      track.style.transition = 'none';
    } else {
      track.style.transition = 'transform .38s cubic-bezier(.4,0,.2,1)';
    }
    track.style.transform = 'translateX(-' + (cur * 100) + '%)';

    Array.from(dotsEl.children).forEach(function (d, i) {
      d.classList.toggle('active', i === cur);
    });
    lbl.textContent    = (cur + 1) + ' / ' + total;
    btnPrev.disabled   = cur === 0;
    btnNext.disabled   = cur === total - 1;
  }

  btnPrev.addEventListener('click', function () { goTo(cur - 1); });
  btnNext.addEventListener('click', function () { goTo(cur + 1); });

  /* Touch swipe */
  var tx0 = null;
  track.addEventListener('touchstart', function (e) {
    tx0 = e.touches[0].clientX;
  }, { passive: true });
  track.addEventListener('touchend', function (e) {
    if (tx0 === null) return;
    var dx = e.changedTouches[0].clientX - tx0;
    if (Math.abs(dx) > 40) goTo(cur + (dx < 0 ? 1 : -1));
    tx0 = null;
  }, { passive: true });

  /* Resize — rebuild hanya kalau breakpoint berubah */
  var lastMobile = isMobile();
  var rTimer;
  window.addEventListener('resize', function () {
    clearTimeout(rTimer);
    rTimer = setTimeout(function () {
      var nowMobile = isMobile();
      if (nowMobile !== lastMobile) {
        lastMobile = nowMobile;
        perPage    = 0;
        rebuild();
      }
    }, 150);
  });

  rebuild();
})();
</script>

<script src="<?= BASE_URL ?>/assets/js/main.js"></script>
</body>
</html>