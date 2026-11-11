/**
 * RAIHAN ADIB MASRUKHAN — PORTFOLIO JAVASCRIPT
 * Interactive features: Live Clock, Custom Cursor, Project Modal, Filter System, WhatsApp Direct Form, Toast
 */

document.addEventListener('DOMContentLoaded', () => {
  // 1. Live Time Counter (WIB - Western Indonesian Time / Jakarta GMT+7)
  const clockElement = document.getElementById('live-time');
  function updateLiveClock() {
    if (!clockElement) return;
    const now = new Date();
    const options = {
      timeZone: 'Asia/Jakarta',
      hour12: true,
      hour: '2-digit',
      minute: '2-digit',
      second: '2-digit'
    };
    const timeString = new Intl.DateTimeFormat('en-US', options).format(now);
    clockElement.textContent = `${timeString} WIB`;
  }
  updateLiveClock();
  setInterval(updateLiveClock, 1000);

  // 2. Custom Cursor
  const cursor = document.querySelector('.custom-cursor');
  const follower = document.querySelector('.custom-cursor-follower');
  
  if (cursor && follower && window.matchMedia('(pointer: fine)').matches) {
    let mouseX = 0, mouseY = 0;
    let followerX = 0, followerY = 0;

    window.addEventListener('mousemove', (e) => {
      mouseX = e.clientX;
      mouseY = e.clientY;
      cursor.style.left = `${mouseX}px`;
      cursor.style.top = `${mouseY}px`;
    });

    function animateFollower() {
      followerX += (mouseX - followerX) * 0.18;
      followerY += (mouseY - followerY) * 0.18;
      follower.style.left = `${followerX}px`;
      follower.style.top = `${followerY}px`;
      requestAnimationFrame(animateFollower);
    }
    requestAnimationFrame(animateFollower);

    // Interactive Hover States
    const interactiveElements = document.querySelectorAll('a, button, input, textarea, select, .gallery-card, .project-card, .process-card, .testimonial-card');
    interactiveElements.forEach((el) => {
      el.addEventListener('mouseenter', () => document.body.classList.add('cursor-hover'));
      el.addEventListener('mouseleave', () => document.body.classList.remove('cursor-hover'));
    });
  }

  // 3. Header Scrolled State
  const siteHeader = document.querySelector('.site-header');
  window.addEventListener('scroll', () => {
    if (window.scrollY > 40) {
      siteHeader?.classList.add('scrolled');
    } else {
      siteHeader?.classList.remove('scrolled');
    }
  });

  // 4. Navigation Overlay Toggle
  const menuToggle = document.getElementById('menu-toggle');
  const navOverlay = document.getElementById('nav-overlay');
  const navLinks = document.querySelectorAll('.nav-link-item a');

  function getMenuLabels() {
    const isId = (localStorage.getItem('portfolio_locale') || 'id') === 'id';
    return {
      close: isId ? 'TUTUP' : 'CLOSE',
      open: 'MENU'
    };
  }

  function toggleMenu() {
    navOverlay?.classList.toggle('active');
    const isActive = navOverlay?.classList.contains('active');
    if (isActive && navOverlay) {
      navOverlay.scrollTop = 0;
    }
    document.body.style.overflow = isActive ? 'hidden' : '';
    if (menuToggle) {
      const labels = getMenuLabels();
      menuToggle.setAttribute('aria-expanded', isActive ? 'true' : 'false');
      menuToggle.innerHTML = isActive 
        ? `${labels.close} <span style="font-size:1.1rem;margin-left:4px;">✕</span>` 
        : `${labels.open} <div class="menu-icon-bars"><span></span><span></span></div>`;
    }
  }

  menuToggle?.addEventListener('click', toggleMenu);
  navLinks.forEach((link) => {
    link.addEventListener('click', () => {
      navOverlay?.classList.remove('active');
      document.body.style.overflow = '';
      if (menuToggle) {
        const labels = getMenuLabels();
        menuToggle.setAttribute('aria-expanded', 'false');
        menuToggle.innerHTML = `${labels.open} <div class="menu-icon-bars"><span></span><span></span></div>`;
      }
    });
  });

  // Close menu on Escape key
  window.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && navOverlay?.classList.contains('active')) {
      toggleMenu();
    }
  });

  // 5. Scroll Reveal with Intersection Observer
  const revealElements = document.querySelectorAll('.reveal');
  const revealObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add('active');
        observer.unobserve(entry.target);
      }
    });
  }, {
    threshold: 0.12,
    rootMargin: '0px 0px -50px 0px'
  });

  revealElements.forEach((el) => revealObserver.observe(el));

  // 6. Project Database & Modal Lightbox (Integrated with Laravel Dynamic Database)
  const defaultProjectsData = {
    'saas-progress': {
      title: 'Digital Progress Management & Geofencing SaaS',
      client: 'PT. BantuGrow Revolusi Digital',
      category: 'saas',
      role: 'Web Developer & UI/UX Designer',
      timeline: 'Nov 2024 – Present',
      badge: 'SaaS Platform',
      image: '/images/project-saas.jpg',
      overview: 'An end-to-end multi-tenant Software-as-a-Service (SaaS) and progress management system. Engineered for high-accuracy workforce tracking with live geofencing polygon boundaries, offline Progressive Web App (PWA) sync, dynamic multi-role authorization, and automated daily PDF reporting engine.',
      highlights: [
        'Real-time GPS geofencing radius validation for field task attendance',
        'Offline-first Progressive Web App (PWA) with background sync',
        'Automated executive PDF report generator & analytics charts',
        'Streamlined multi-company tenant architecture and role-based permissions'
      ],
      stack: ['PHP Laravel', 'JavaScript / React', 'MySQL', 'PWA', 'Tailwind CSS', 'Geofencing API']
    }
  };

  const projectsData = window.DYNAMIC_PROJECTS || defaultProjectsData;

  const modalBackdrop = document.getElementById('project-modal');
  const modalCloseBtn = document.getElementById('modal-close');
  const modalImage = document.getElementById('modal-image');
  const modalTag = document.getElementById('modal-tag');
  const modalTitle = document.getElementById('modal-title');
  const modalClient = document.getElementById('modal-client');
  const modalRole = document.getElementById('modal-role');
  const modalTimeline = document.getElementById('modal-timeline');
  const modalDesc = document.getElementById('modal-desc');
  const modalHighlights = document.getElementById('modal-highlights');
  const modalStack = document.getElementById('modal-stack');

  function openProjectModal(projectId) {
    const data = projectsData[projectId];
    if (!data || !modalBackdrop) return;

    if (modalImage) modalImage.src = data.image;
    if (modalTag) modalTag.textContent = data.badge;
    if (modalTitle) modalTitle.textContent = data.title;
    if (modalClient) modalClient.textContent = data.client;
    if (modalRole) modalRole.textContent = data.role;
    if (modalTimeline) modalTimeline.textContent = data.timeline;
    if (modalDesc) modalDesc.textContent = data.overview;

    if (modalHighlights) {
      const highlights = Array.isArray(data.highlights) ? data.highlights : [];
      modalHighlights.innerHTML = highlights
        .map(h => `<li style="margin-bottom:0.5rem;position:relative;padding-left:1.2rem;"><span style="position:absolute;left:0;color:var(--accent-orange);">▹</span>${h}</li>`)
        .join('');
    }

    if (modalStack) {
      const stack = Array.isArray(data.stack) ? data.stack : [];
      modalStack.innerHTML = stack
        .map(tech => `<span class="tech-tag" style="background:rgba(255,85,0,0.12);border-color:var(--border-accent);color:#fff;">${tech}</span>`)
        .join('');
    }

    modalBackdrop.classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function closeProjectModal() {
    modalBackdrop?.classList.remove('active');
    document.body.style.overflow = '';
  }

  modalCloseBtn?.addEventListener('click', closeProjectModal);
  modalBackdrop?.addEventListener('click', (e) => {
    if (e.target === modalBackdrop) closeProjectModal();
  });
  window.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && modalBackdrop?.classList.contains('active')) {
      closeProjectModal();
    }
  });

  // Attach trigger to buttons and gallery items
  document.querySelectorAll('[data-project-trigger]').forEach((trigger) => {
    trigger.addEventListener('click', (e) => {
      e.preventDefault();
      const id = trigger.getAttribute('data-project-trigger');
      if (id) openProjectModal(id);
    });
  });

  // 7. Project Category Filter
  const filterBtns = document.querySelectorAll('.filter-btn');
  const projectCards = document.querySelectorAll('.project-card');

  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      filterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      const filter = btn.getAttribute('data-filter');

      projectCards.forEach(card => {
        const category = card.getAttribute('data-category');
        if (filter === 'all' || category === filter) {
          card.style.display = 'flex';
          setTimeout(() => { card.style.opacity = '1'; card.style.transform = 'translateY(0)'; }, 20);
        } else {
          card.style.opacity = '0';
          card.style.transform = 'translateY(15px)';
          setTimeout(() => { card.style.display = 'none'; }, 200);
        }
      });
    });
  });

  // 8. Toast Notification Utility
  const toast = document.getElementById('toast');
  function showToast(message) {
    if (!toast) return;
    toast.textContent = message;
    toast.classList.add('active');
    setTimeout(() => {
      toast.classList.remove('active');
    }, 3800);
  }

  // 9. Quick Copy to Clipboard
  document.querySelectorAll('[data-copy]').forEach(button => {
    button.addEventListener('click', () => {
      const textToCopy = button.getAttribute('data-copy');
      if (!textToCopy) return;

      navigator.clipboard.writeText(textToCopy).then(() => {
        showToast(`Tersalin ke papan klip: "${textToCopy}"`);
      }).catch(() => {
        showToast(`Tersalin: ${textToCopy}`);
      });
    });
  });

  // 10. Contact Form Submission (Saves to Laravel Database & Opens WhatsApp)
  const contactForm = document.getElementById('contact-form');
  contactForm?.addEventListener('submit', function(e) {
    e.preventDefault();

    const name = document.getElementById('sender-name')?.value.trim();
    const email = document.getElementById('sender-email')?.value.trim();
    const service = document.getElementById('project-type')?.value;
    const message = document.getElementById('sender-message')?.value.trim();

    if (!name || !message) {
      showToast('Mohon lengkapi nama dan pesan proyek Anda.');
      return;
    }

    // Save to Database in background via AJAX
    const formData = new FormData(contactForm);
    fetch('/contact', {
      method: 'POST',
      body: formData,
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json'
      }
    }).catch(err => console.log('Form background sync:', err));

    const whatsappNumber = window.TARGET_WHATSAPP_NUMBER || '6285864459552';
    const whatsappMessage = encodeURIComponent(
      `Halo Raihan, saya *${name}* (${email || 'No email'}).\n\n*Tertarik dengan:* ${service || 'General Inquiry'}\n\n*Pesan:* \n${message}`
    );

    const waUrl = `https://wa.me/${whatsappNumber}?text=${whatsappMessage}`;
    showToast('Pesan tersimpan ke inbox! Mengarahkan ke WhatsApp...');
    
    setTimeout(() => {
      window.open(waUrl, '_blank');
      contactForm.reset();
    }, 600);
  });

  // 11. Scroll to top button
  const scrollTopBtn = document.getElementById('scroll-top-btn');
  scrollTopBtn?.addEventListener('click', (e) => {
    e.preventDefault();
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });

  // 12. Theme Switcher (Light / Dark Mode)
  const themeToggles = [
    document.getElementById('theme-toggle'),
    document.getElementById('mobile-theme-toggle')
  ].filter(Boolean);

  function getPreferredTheme() {
    const saved = localStorage.getItem('portfolio_theme');
    if (saved === 'light' || saved === 'dark') return saved;
    return (window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches) ? 'light' : 'dark';
  }

  function applyTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    document.documentElement.classList.toggle('light-mode', theme === 'light');
    document.body.classList.toggle('light-mode', theme === 'light');
    localStorage.setItem('portfolio_theme', theme);
  }

  const currentTheme = getPreferredTheme();
  applyTheme(currentTheme);

  themeToggles.forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      const active = document.documentElement.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
      applyTheme(active);
      showToast(active === 'light' ? 'Mode Terang diaktifkan' : 'Mode Gelap diaktifkan');
    });
  });

  if (window.matchMedia) {
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
      if (!localStorage.getItem('portfolio_theme')) {
        applyTheme(e.matches ? 'dark' : 'light');
      }
    });
  }

  // 13. Multi-language Translation Engine (ID / EN)
  const i18nDictionary = window.I18N_DICTIONARY || {};
  let currentLocale = localStorage.getItem('portfolio_locale') || window.ACTIVE_LOCALE || 'id';

  function getNestedTranslation(obj, path) {
    if (!obj || !path) return undefined;
    return path.split('.').reduce((acc, part) => (acc && acc[part] !== undefined) ? acc[part] : undefined, obj);
  }

  function applyLocale(locale, showNotice = false) {
    if (!i18nDictionary[locale]) return;
    currentLocale = locale;
    localStorage.setItem('portfolio_locale', locale);
    document.documentElement.setAttribute('lang', locale);

    // Update active button state in all language switchers
    document.querySelectorAll('.lang-btn').forEach(btn => {
      const btnLang = btn.getAttribute('data-lang');
      btn.classList.toggle('active', btnLang === locale);
    });

    const dict = i18nDictionary[locale];

    // 1. Update text / html
    document.querySelectorAll('[data-i18n]').forEach(el => {
      const key = el.getAttribute('data-i18n');
      const translation = getNestedTranslation(dict, key);
      if (translation !== undefined) {
        if (translation.includes('<') && translation.includes('>')) {
          el.innerHTML = translation;
        } else {
          el.textContent = translation;
        }
      }
    });

    // 2. Update attributes (placeholder, title, aria-label)
    document.querySelectorAll('[data-i18n-attr]').forEach(el => {
      const attrData = el.getAttribute('data-i18n-attr');
      const pairs = attrData.split(',');
      pairs.forEach(pair => {
        const [attrName, key] = pair.split(':');
        if (attrName && key) {
          const translation = getNestedTranslation(dict, key.trim());
          if (translation !== undefined) {
            el.setAttribute(attrName.trim(), translation);
          }
        }
      });
    });

    // 3. Keep Laravel session in sync in background
    fetch('/lang/' + locale, {
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json'
      }
    }).catch(() => {});

    if (showNotice) {
      showToast(locale === 'id' ? 'Bahasa Indonesia diaktifkan' : 'Switched to English');
    }
  }

  // Bind language buttons
  document.querySelectorAll('.lang-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      const selected = btn.getAttribute('data-lang');
      if (selected && selected !== currentLocale) {
        applyLocale(selected, true);
      }
    });
  });

  // Apply default/saved locale on load
  applyLocale(currentLocale, false);
});
