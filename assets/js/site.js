// ============================================================
// SCROLL ANIMATIONS (AOS-style)
// ============================================================
(function() {
  const observerOptions = {
    root: null,
    rootMargin: '0px',
    threshold: 0.1
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('aos-animate');
        
        // Handle counter animation
        const counter = entry.target.querySelector('.stat-number');
        if (counter && counter.dataset.animate === 'counter') {
          animateCounter(counter);
        }
      }
    });
  }, observerOptions);

  document.querySelectorAll('[data-aos]').forEach(el => {
    observer.observe(el);
  });

  // Counter animation function
  function animateCounter(el) {
    const target = parseInt(el.dataset.target) || 0;
    const duration = 2000;
    const start = 0;
    const startTime = performance.now();

    function update(currentTime) {
      const elapsed = currentTime - startTime;
      const progress = Math.min(elapsed / duration, 1);
      const easeOut = 1 - Math.pow(1 - progress, 3);
      const current = Math.floor(start + (target - start) * easeOut);
      
      el.textContent = current + (el.dataset.suffix || '+');
      
      if (progress < 1) {
        requestAnimationFrame(update);
      }
    }

    requestAnimationFrame(update);
  }
})();

// ============================================================
// NAVBAR SCROLL EFFECT
// ============================================================
(function() {
  const navbar = document.querySelector('.site-header, .navbar');
  if (!navbar) return;

  window.addEventListener('scroll', function() {
    if (window.scrollY > 50) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  });

  // Trigger on page load
  if (window.scrollY > 50) {
    navbar.classList.add('scrolled');
  }
})();

// ============================================================
// SMOOTH SCROLL FOR ANCHOR LINKS
// ============================================================
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function(e) {
    const targetId = this.getAttribute('href');
    if (targetId === '#') return;
    
    const target = document.querySelector(targetId);
    if (target) {
      e.preventDefault();
      target.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
      });
    }
  });
});

// ============================================================
// SCROLL-TO-TOP BUTTON
// ============================================================
const scrollBtn = document.getElementById('scrollTopBtn');
if (scrollBtn) {
  window.addEventListener('scroll', function(){
    scrollBtn.style.display = window.scrollY > 300 ? 'flex' : 'none';
  });
  scrollBtn.addEventListener('click', function(){ window.scrollTo({top:0,behavior:'smooth'}); });
}

// Active nav link highlight
(function(){
  const links = document.querySelectorAll('.nav-links a');
  if (links.length === 0) return;
  
  function setActive(){
    let scrollPos = window.scrollY + 100;
    links.forEach(link => {
      const href = link.getAttribute('href');
      if(!href || !href.includes('#')) return;
      const id = href.split('#')[1];
      const el = document.getElementById(id);
      if(el){
        const top = el.offsetTop;
        const bottom = top + el.offsetHeight;
        link.classList.toggle('active', scrollPos >= top && scrollPos < bottom);
      }
    });
  }
  window.addEventListener('scroll', setActive);
  setActive();
})();
