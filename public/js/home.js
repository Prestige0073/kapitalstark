/* ============================================================
   KAPITALSTARK — Home Page JS
   ============================================================ */

document.addEventListener('DOMContentLoaded', () => {

  /* ── Simulateur rapide ────────────────────────────────────── */
  const sliderAmount   = document.getElementById('sim-amount');
  const sliderDuration = document.getElementById('sim-duration');
  const sliderApport   = document.getElementById('sim-apport');

  const elAmountVal   = document.getElementById('sim-amount-val');
  const elDurationVal = document.getElementById('sim-duration-val');
  const elApportVal   = document.getElementById('sim-apport-val');
  const elMonthly     = document.getElementById('sim-monthly');
  const elTotal       = document.getElementById('sim-total');
  const elRate        = document.getElementById('sim-rate');
  const elCapital     = document.getElementById('sim-capital');

  // Taux par type (TAEG annuel indicatif)
  const rates = { immo: 0.019, auto: 0.025, perso: 0.032, pro: 0.028 };
  let currentType = 'immo';

  function fmt(n) {
    if (n >= 1000000) return (n / 1000000).toFixed(1).replace('.', ',') + ' M€';
    if (n >= 1000)    return Math.round(n).toLocaleString('fr-FR') + ' €';
    return Math.round(n) + ' €';
  }

  function calcMonthly(capital, annualRate, months) {
    if (months <= 0 || capital <= 0) return 0;
    const r = annualRate / 12;
    if (r === 0) return capital / months;
    return capital * r * Math.pow(1 + r, months) / (Math.pow(1 + r, months) - 1);
  }

  function updateSim() {
    const amount   = parseInt(sliderAmount.value);
    const years    = parseInt(sliderDuration.value);
    const apport   = parseInt(sliderApport.value);
    const rate     = rates[currentType];
    const capital  = Math.max(amount - apport, 0);
    const months   = years * 12;
    const monthly  = calcMonthly(capital, rate, months);
    const total    = monthly * months;

    elAmountVal.textContent   = fmt(amount);
    elDurationVal.textContent = years === 1 ? '1 an' : years + ' ans';
    elApportVal.textContent   = fmt(apport);

    elMonthly.textContent  = Math.round(monthly).toLocaleString('fr-FR') + ' €';
    elTotal.textContent    = fmt(total);
    elRate.textContent     = (rate * 100).toFixed(1) + '%';
    elCapital.textContent  = fmt(capital);

    // Slider apport max = montant
    sliderApport.max = amount;
    if (apport > amount) {
      sliderApport.value = amount;
      elApportVal.textContent = fmt(amount);
    }

    // Gradient sur les sliders
    [sliderAmount, sliderDuration, sliderApport].forEach(s => {
      const pct = ((s.value - s.min) / (s.max - s.min) * 100).toFixed(1);
      s.style.background = `linear-gradient(to right, var(--blue) ${pct}%, rgba(255,255,255,0.1) ${pct}%)`;
    });
  }

  if (sliderAmount) {
    [sliderAmount, sliderDuration, sliderApport].forEach(s => {
      s.addEventListener('input', updateSim);
    });
    updateSim();
  }

  // Onglets type de prêt
  document.querySelectorAll('.sim-tab').forEach(tab => {
    tab.addEventListener('click', () => {
      document.querySelectorAll('.sim-tab').forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
      currentType = tab.dataset.type;
      updateSim();
    });
  });

  /* ── Carousel témoignages ────────────────────────────────── */
  const track    = document.getElementById('testimonials-track');
  const dotsWrap = document.getElementById('testimonials-dots');
  const btnPrev  = document.getElementById('prev-testimonial');
  const btnNext  = document.getElementById('next-testimonial');

  if (track) {
    const cards = track.querySelectorAll('.testimonial-card');
    let current = 0;
    let perView = getPerView();
    let total   = Math.ceil(cards.length / perView);
    let autoTimer;

    function getPerView() {
      return window.innerWidth >= 1024 ? 3 : window.innerWidth >= 640 ? 2 : 1;
    }

    function buildDots() {
      if (!dotsWrap) return;
      dotsWrap.innerHTML = '';
      for (let i = 0; i < total; i++) {
        const d = document.createElement('button');
        d.className = 'testimonials__dot' + (i === 0 ? ' active' : '');
        d.setAttribute('aria-label', `Aller à la page ${i + 1}`);
        d.addEventListener('click', () => { goTo(i); startAuto(); });
        dotsWrap.appendChild(d);
      }
    }

    function getDots() {
      return dotsWrap ? dotsWrap.querySelectorAll('.testimonials__dot') : [];
    }

    function goTo(index) {
      current = ((index % total) + total) % total;
      const cardWidth = cards[0].offsetWidth + 24; // gap
      track.style.transform = `translateX(-${current * cardWidth * perView}px)`;
      getDots().forEach((d, i) => d.classList.toggle('active', i === current));
    }

    function startAuto() {
      clearInterval(autoTimer);
      autoTimer = setInterval(() => goTo(current + 1), 5000);
    }

    buildDots();

    if (btnPrev) btnPrev.addEventListener('click', () => { goTo(current - 1); startAuto(); });
    if (btnNext) btnNext.addEventListener('click', () => { goTo(current + 1); startAuto(); });

    // Pause on hover
    track.addEventListener('mouseenter', () => clearInterval(autoTimer));
    track.addEventListener('mouseleave', () => startAuto());

    window.addEventListener('resize', () => {
      const newPer = getPerView();
      if (newPer !== perView) {
        perView = newPer;
        total = Math.ceil(cards.length / perView);
        current = 0;
        buildDots();
        goTo(0);
      }
    });

    // Touch swipe
    let touchStartX = 0;
    track.addEventListener('touchstart', e => { touchStartX = e.touches[0].clientX; }, { passive: true });
    track.addEventListener('touchend', e => {
      const diff = touchStartX - e.changedTouches[0].clientX;
      if (Math.abs(diff) > 50) goTo(diff > 0 ? current + 1 : current - 1);
      startAuto();
    });

    startAuto();
  }

  /* ── Newsletter ───────────────────────────────────────────── */
  document.querySelectorAll('.newsletter__form, form[data-newsletter]').forEach(form => {
    form.addEventListener('submit', e => {
      e.preventDefault();
      const input  = form.querySelector('input[type="email"]');
      const btn    = form.querySelector('button[type="submit"]');
      const source = form.dataset.source || 'home';
      if (!input || !input.value || !input.validity.valid) {
        input && input.focus();
        return;
      }
      if (btn) btn.disabled = true;
      const csrfToken = document.querySelector('meta[name="csrf-token"]')
        ? document.querySelector('meta[name="csrf-token"]').content
        : '';
      fetch('/newsletter', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({ email: input.value, source }),
      })
        .then(r => r.json())
        .then(() => {
          btn.textContent = '✓ Inscrit !';
          btn.style.background = 'var(--success)';
          input.value = '';
        })
        .catch(() => {
          btn.textContent = '✓ Inscrit !';
          btn.style.background = 'var(--success)';
          btn.disabled = true;
          input.value = '';
        });
    });
  });

});
