/* ============================================================
   KAPITALSTARK — Full Simulator JS
   ============================================================ */

document.addEventListener('DOMContentLoaded', () => {

  const rates = { immo:0.019, auto:0.025, perso:0.032, pro:0.028, agri:0.023 };
  let currentRate = rates.immo;

  const $ = id => document.getElementById(id);

  const slAmount   = $('fs-amount');
  const slDuration = $('fs-duration');
  const slApport   = $('fs-apport');
  const slIns      = $('fs-insurance');

  function fmt(n) {
    if (n >= 1000000) return (n/1000000).toFixed(2).replace('.',',') + ' M€';
    return Math.round(n).toLocaleString('fr-FR') + ' €';
  }

  function calcMonthly(capital, annualRate, months) {
    if (months <= 0 || capital <= 0) return 0;
    const r = annualRate / 12;
    if (r === 0) return capital / months;
    return capital * r * Math.pow(1+r, months) / (Math.pow(1+r, months) - 1);
  }

  function updateSliderStyle(slider) {
    const pct = ((slider.value - slider.min) / (slider.max - slider.min) * 100).toFixed(1);
    slider.style.background = `linear-gradient(to right, var(--blue) ${pct}%, rgba(38,123,241,0.15) ${pct}%)`;
  }

  function updateAll() {
    const amount   = parseInt(slAmount.value);
    const years    = parseInt(slDuration.value);
    const apport   = Math.min(parseInt(slApport.value), amount);
    const insRate  = parseInt(slIns.value) / 10000; // centièmes → décimal
    const capital  = Math.max(amount - apport, 0);
    const months   = years * 12;

    const monthly      = calcMonthly(capital, currentRate, months);
    const insMonthly   = capital * insRate / 12;
    const total        = (monthly + insMonthly) * months;
    const totalIns     = insMonthly * months;
    const totalInter   = monthly * months - capital;

    // Labels
    $('fs-amount-val').textContent   = fmt(amount);
    $('fs-dur-val').textContent      = years === 1 ? '1 an' : years + ' ans';
    $('fs-apport-val').textContent   = fmt(apport);
    $('fs-ins-val').textContent      = (insRate * 100).toFixed(2) + '%';
    $('fs-rate-display').textContent = (currentRate * 100).toFixed(2) + '%';

    // Résultats
    $('fs-monthly').textContent   = Math.round(monthly + insMonthly).toLocaleString('fr-FR') + ' €';
    $('fs-ins-monthly').textContent = Math.round(insMonthly).toLocaleString('fr-FR') + ' €';
    $('fs-capital').textContent   = fmt(capital);
    $('fs-total').textContent     = fmt(total);
    $('fs-interests').textContent = fmt(Math.max(totalInter, 0));
    $('fs-ins-total').textContent = fmt(totalIns);

    // Donut SVG
    updateDonut(capital, Math.max(totalInter, 0), totalIns, total);

    // Gradient sliders
    [slAmount, slDuration, slApport, slIns].forEach(updateSliderStyle);

    // Tableau amortissement (si ouvert)
    if ($('amort-content').classList.contains('open')) {
      buildAmortTable(capital, currentRate, months, insMonthly);
    }
  }

  function updateDonut(capital, interests, insurance, total) {
    if (total <= 0) return;
    const circ = 2 * Math.PI * 70; // ≈ 439.8
    const capFrac  = capital   / total;
    const intFrac  = interests / total;
    const insFrac  = insurance / total;

    const capArc = circ * capFrac;
    const intArc = circ * intFrac;
    const insArc = circ * insFrac;

    const capOffset  = 0;
    const intOffset  = -(circ - capArc);
    const insOffset  = -(circ - capArc - intArc);

    const capCirc  = document.querySelector('.sim-donut__capital');
    const intCirc  = document.querySelector('.sim-donut__interests');
    const insCirc  = document.querySelector('.sim-donut__insurance');

    if (capCirc) {
      capCirc.setAttribute('stroke-dasharray', `${capArc} ${circ - capArc}`);
      capCirc.setAttribute('stroke-dashoffset', String(capOffset));
    }
    if (intCirc) {
      intCirc.setAttribute('stroke-dasharray', `${intArc} ${circ - intArc}`);
      intCirc.setAttribute('stroke-dashoffset', String(intOffset));
    }
    if (insCirc) {
      insCirc.setAttribute('stroke-dasharray', `${insArc} ${circ - insArc}`);
      insCirc.setAttribute('stroke-dashoffset', String(insOffset));
    }
  }

  function buildAmortTable(capital, annualRate, months, insMonthly) {
    const tbody = $('amort-tbody');
    if (!tbody) return;
    tbody.innerHTML = '';
    const r = annualRate / 12;
    let remaining = capital;
    const monthlyP = calcMonthly(capital, annualRate, months);

    for (let m = 1; m <= months; m++) {
      const interest = remaining * r;
      const principal = monthlyP - interest;
      remaining = Math.max(remaining - principal, 0);

      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${m}</td>
        <td class="font-mono">${Math.round(monthlyP + insMonthly).toLocaleString('fr-FR')} €</td>
        <td class="font-mono" style="color:var(--blue);">${Math.round(principal).toLocaleString('fr-FR')} €</td>
        <td class="font-mono" style="color:var(--gold);">${Math.round(interest).toLocaleString('fr-FR')} €</td>
        <td class="font-mono">${Math.round(remaining).toLocaleString('fr-FR')} €</td>
      `;
      tbody.appendChild(tr);
    }
  }

  // Événements sliders
  if (slAmount) {
    [slAmount, slDuration, slApport, slIns].forEach(s => s.addEventListener('input', updateAll));
    updateAll();
  }

  // Onglets
  document.querySelectorAll('.sim-type-tab').forEach(tab => {
    tab.addEventListener('click', () => {
      document.querySelectorAll('.sim-type-tab').forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
      currentRate = rates[tab.dataset.type] ?? rates.immo;
      updateAll();
    });
  });

  // Toggle tableau amortissement
  const amortToggle  = $('amort-toggle');
  const amortContent = $('amort-content');
  if (amortToggle) {
    amortToggle.addEventListener('click', () => {
      const isOpen = amortContent.classList.toggle('open');
      amortToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      if (isOpen) {
        const capital = Math.max(parseInt(slAmount.value) - parseInt(slApport.value), 0);
        const insMonthly = capital * (parseInt(slIns.value) / 10000) / 12;
        buildAmortTable(capital, currentRate, parseInt(slDuration.value) * 12, insMonthly);
      }
    });
  }

});
