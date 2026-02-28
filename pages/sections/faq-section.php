

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