(function() {
  const toastContainer = document.getElementById('toastContainer');
  const showToast = (message, type = 'success') => {
    if (!toastContainer || !message) return;
    const toast = document.createElement('div');
    toast.className = `site-toast site-toast-${type}`;
    toast.setAttribute('role', 'status');
    toast.textContent = message;
    toastContainer.appendChild(toast);
    requestAnimationFrame(() => {
      toast.classList.add('is-visible');
    });
    window.setTimeout(() => {
      toast.classList.remove('is-visible');
      window.setTimeout(() => {
        toast.remove();
      }, 220);
    }, 3400);
  };

  document.addEventListener('click', (e) => {
    const a = e.target && e.target.closest ? e.target.closest('[data-set-theme]') : null;
    if (!a) return;
    e.preventDefault();
    const theme = a.getAttribute('data-set-theme') || '';
    if (!theme) return;
    document.documentElement.setAttribute('data-theme', theme);
    try {
      localStorage.setItem('sawa_theme', theme);
    } catch (err) {
    }
  });

  const scrollTopBtn = document.getElementById('scrollTop');
  if (scrollTopBtn) {
    const syncScrollBtn = () => {
      if (window.scrollY > 300) {
        scrollTopBtn.classList.add('is-visible');
      } else {
        scrollTopBtn.classList.remove('is-visible');
      }
    };

    syncScrollBtn();
    window.addEventListener('scroll', syncScrollBtn, { passive: true });
    scrollTopBtn.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  const modal = document.getElementById('bookingModal');
  if (modal) {
    modal.addEventListener('show.bs.modal', (event) => {
      const button = event.relatedTarget;
      if (!button) return;

      const carId = button.getAttribute('data-car-id') || '';
      const offerId = button.getAttribute('data-offer-id') || '';
      const carName = button.getAttribute('data-car-name') || '';

      const carIdInput = modal.querySelector('input[name="car_id"]');
      if (carIdInput) carIdInput.value = carId;

      const offerIdInput = modal.querySelector('input[name="offer_id"]');
      if (offerIdInput) offerIdInput.value = offerId;

      const title = modal.querySelector('[data-booking-title]');
      if (title) title.textContent = carName;
    });
  }

  const forms = document.querySelectorAll('form[data-ajax-booking="1"]');
let priceCache = {};
document.querySelectorAll('select[name=\"car_id\"], input[name=\"start_date\"], input[name=\"end_date\"]').forEach(el => {
  el.addEventListener('change', calcPrice);
  el.addEventListener('input', calcPrice);
});

function calcPrice() {
  const carSelect = document.querySelector('select[name=\"car_id\"]');
  const startInput = document.querySelector('input[name=\"start_date\"]');
  const endInput = document.querySelector('input[name=\"end_date\"]');
  
  if (!carSelect || !startInput || !endInput) return;
  
  const carId = parseInt(carSelect.value);
  const start = startInput.value;
  const end = endInput.value;
  
  if (carId <= 0 || !start || !end) {
    document.getElementById('price-total')?.remove();
    return;
  }
  
  const days = Math.ceil((new Date(end) - new Date(start)) / (1000 * 60 * 60 * 24));
  if (days <= 0) return;
  
  fetch(`/api/cars.php?id=${carId}`, {cache: 'force-cache'})
    .then(r => r.json())
    .then(car => {
      if (!car || !car.daily_price) return;
      const monthly = car.monthly_price || 0;
      const total = days >= 30 && monthly > 0 ? monthly : car.daily_price * days;
      const totalEl = document.getElementById('price-total') || createPriceEl(total);
      totalEl.textContent = `${total.toLocaleString()} ₪`;
      document.querySelector('.booking-form-card').appendChild(totalEl);
    })
    .catch(() => {});
}

function createPriceEl(total) {
  const el = document.createElement('div');
  el.id = 'price-total';
  el.style.cssText = 'font-weight:900;font-size:28px;color:var(--primary);text-align:center;margin:24px 0 16px;padding:16px;background:rgba(var(--accent-rgb),.12);border-radius:16px;border:2px solid rgba(var(--accent-rgb),.3);';
  return el;
  forms.forEach((form) => {
    form.addEventListener('submit', async (e) => {
// Date validation
document.querySelectorAll('input[type=\"date\"]').forEach(input => {
  input.addEventListener('change', validateDates);
});

function validateDates() {
  const start = document.querySelector('input[name=\"start_date\"]').value;
  const end = document.querySelector('input[name=\"end_date\"]').value;
  if (start && end && new Date(end) <= new Date(start)) {
    showToast('تاريخ النهاية يجب أن يكون بعد تاريخ البداية', 'error');
    document.querySelector('input[name=\"end_date\"]').value = '';
  }
}

  const forms = document.querySelectorAll('form[data-ajax-booking="1"]');\n  forms.forEach((form) => {\n    form.addEventListener('submit', async (e) => {\n      e.preventDefault();\n\n      const action = form.getAttribute('action') || '';\n      if (!action) return;\n\n      const submitBtn = form.querySelector('button[type=\"submit"], input[type=\"submit\"]');\n      const oldBtnHtml = submitBtn && submitBtn.tagName === 'BUTTON' ? submitBtn.innerHTML : null;\n      const oldDisabled = submitBtn ? submitBtn.disabled : null;\n\n      try {\n        if (submitBtn) {\n          submitBtn.disabled = true;\n          if (submitBtn.tagName === 'BUTTON') {\n            submitBtn.innerHTML = submitBtn.getAttribute('data-loading-text') || submitBtn.innerHTML;\n          }\n        }\n\n        const fd = new FormData(form);\n        const res = await fetch(action, {\n          method: 'POST',\n          body: fd,\n          headers: {\n            'Accept': 'application/json',\n            'X-Requested-With': 'XMLHttpRequest'\n          }\n        });\n\n        let data = null;\n        try {\n          data = await res.json();\n        } catch (err) {\n          data = null;\n        }\n\n        if (!res.ok || !data || !data.ok) {\n          const msg = (data && data.message) ? data.message : 'Request failed.';\n          showToast(msg, 'error');\n          return;\n        }\n\n        showToast(data.message || 'Done.', 'success');\n        form.reset();\n\n        if (modal && modal.classList.contains('show')) {\n          try {\n            const instance = window.bootstrap ? window.bootstrap.Modal.getInstance(modal) : null;\n            if (instance) instance.hide();\n          } catch (err) {\n          }\n        }\n      } catch (err) {\n        showToast('Network error. Please try again.', 'error');\n      } finally {\n        if (submitBtn) {\n          submitBtn.disabled = oldDisabled === null ? false : oldDisabled;\n          if (submitBtn.tagName === 'BUTTON' && oldBtnHtml !== null) {\n            submitBtn.innerHTML = oldBtnHtml;\n          }\n        }\n      }\n    });\n  });\n})();
      e.preventDefault();

      const action = form.getAttribute('action') || '';
      if (!action) return;

      const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
      const oldBtnHtml = submitBtn && submitBtn.tagName === 'BUTTON' ? submitBtn.innerHTML : null;
      const oldDisabled = submitBtn ? submitBtn.disabled : null;

      try {
        if (submitBtn) {
          submitBtn.disabled = true;
          if (submitBtn.tagName === 'BUTTON') {
            submitBtn.innerHTML = submitBtn.getAttribute('data-loading-text') || submitBtn.innerHTML;
          }
        }

        const fd = new FormData(form);
        const res = await fetch(action, {
          method: 'POST',
          body: fd,
          headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          }
        });

        let data = null;
        try {
          data = await res.json();
        } catch (err) {
          data = null;
        }

        if (!res.ok || !data || !data.ok) {
          const msg = (data && data.message) ? data.message : 'Request failed.';
          showToast(msg, 'error');
          return;
        }

        showToast(data.message || 'Done.', 'success');
        form.reset();

        if (modal && modal.classList.contains('show')) {
          try {
            const instance = window.bootstrap ? window.bootstrap.Modal.getInstance(modal) : null;
            if (instance) instance.hide();
          } catch (err) {
          }
        }
      } catch (err) {
        showToast('Network error. Please try again.', 'error');
      } finally {
        if (submitBtn) {
          submitBtn.disabled = oldDisabled === null ? false : oldDisabled;
          if (submitBtn.tagName === 'BUTTON' && oldBtnHtml !== null) {
            submitBtn.innerHTML = oldBtnHtml;
          }
        }
      }
    });
  });
})();
