/**
 * RAIHAN ADIB MASRUKHAN — PORTFOLIO JAVASCRIPT
 * Interactive features: Custom Cursor, Project Modal, Filter System, Theme & Language Switcher, WhatsApp Direct Form, Toast
 */

document.addEventListener('DOMContentLoaded', () => {
  // 1. Custom Cursor
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
    const interactiveElements = document.querySelectorAll('a, button, input, textarea, select, .project-card, .process-card, .testimonial-card');
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
  const modalLinks = document.getElementById('modal-links');

  function isSafeExternalUrl(rawUrl) {
    if (!rawUrl) return false;
    try {
      const parsed = new URL(rawUrl, window.location.origin);
      return parsed.protocol === 'http:' || parsed.protocol === 'https:';
    } catch (e) {
      return false;
    }
  }

  function openProjectModal(projectId) {
    const data = projectsData[projectId];
    if (!data || !modalBackdrop) return;

    const translateText = window.__translatePortfolioContent || ((val) => val);
    const activeDict = (window.I18N_DICTIONARY || {})[localStorage.getItem('portfolio_locale') || window.ACTIVE_LOCALE || 'id'] || {};
    const modalDict = activeDict.modal || {};

    if (modalImage) modalImage.src = data.image;
    if (modalTag) modalTag.textContent = translateText(data.badge);
    if (modalTitle) modalTitle.textContent = translateText(data.title);
    if (modalClient) modalClient.textContent = translateText(data.client);
    if (modalRole) modalRole.textContent = translateText(data.role);
    if (modalTimeline) modalTimeline.textContent = translateText(data.timeline);
    if (modalDesc) modalDesc.textContent = translateText(data.overview);

    if (modalHighlights) {
      const highlights = Array.isArray(data.highlights) ? data.highlights : [];
      modalHighlights.innerHTML = highlights
        .map(h => `<li style="margin-bottom:0.5rem;position:relative;padding-left:1.2rem;"><span style="position:absolute;left:0;color:var(--accent-orange);">▹</span>${translateText(h)}</li>`)
        .join('');
    }

    if (modalStack) {
      const stack = Array.isArray(data.stack) ? data.stack : [];
      modalStack.innerHTML = stack
        .map(tech => `<span class="tech-tag" style="background:rgba(255,85,0,0.12);border-color:var(--border-accent);color:#fff;">${tech}</span>`)
        .join('');
    }

    if (modalLinks) {
      modalLinks.innerHTML = '';
      const hasLive = isSafeExternalUrl(data.liveUrl);
      const hasGithub = isSafeExternalUrl(data.githubUrl);

      if (hasLive) {
        const liveAnchor = document.createElement('a');
        liveAnchor.href = data.liveUrl;
        liveAnchor.target = '_blank';
        liveAnchor.rel = 'noopener noreferrer';
        liveAnchor.className = 'modal-link-btn modal-link-live';
        liveAnchor.innerHTML = `<span data-i18n="modal.visit_live">${modalDict.visit_live || 'Visit Live Demo'}</span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>`;
        modalLinks.appendChild(liveAnchor);
      }

      if (hasGithub) {
        const ghAnchor = document.createElement('a');
        ghAnchor.href = data.githubUrl;
        ghAnchor.target = '_blank';
        ghAnchor.rel = 'noopener noreferrer';
        ghAnchor.className = 'modal-link-btn modal-link-github';
        ghAnchor.innerHTML = `<svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/></svg><span data-i18n="modal.view_github">${modalDict.view_github || 'GitHub Repository'}</span>`;
        modalLinks.appendChild(ghAnchor);
      }

      modalLinks.style.display = (hasLive || hasGithub) ? 'flex' : 'none';
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

  // Attach trigger to buttons and project cards
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
  const projectsEmptyState = document.getElementById('projects-empty-state');

  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      filterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      const filter = btn.getAttribute('data-filter');
      let visibleCount = 0;

      projectCards.forEach(card => {
        if (card._filterTimer) {
          clearTimeout(card._filterTimer);
        }
        const category = card.getAttribute('data-category');
        if (filter === 'all' || category === filter) {
          visibleCount++;
          card.style.display = 'flex';
          card._filterTimer = setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
          }, 20);
        } else {
          card.style.opacity = '0';
          card.style.transform = 'translateY(15px)';
          card._filterTimer = setTimeout(() => {
            card.style.display = 'none';
          }, 200);
        }
      });

      if (projectsEmptyState) {
        projectsEmptyState.style.display = visibleCount === 0 ? 'block' : 'none';
      }
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
    document.getElementById('theme-toggle')
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
      const isEn = (localStorage.getItem('portfolio_locale') || window.ACTIVE_LOCALE || 'id') === 'en';
      showToast(
        active === 'light'
          ? (isEn ? 'Light Mode enabled' : 'Mode Terang diaktifkan')
          : (isEn ? 'Dark Mode enabled' : 'Mode Gelap diaktifkan')
      );
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
  const contentPairs = Array.isArray(window.I18N_CONTENT_PAIRS) ? window.I18N_CONTENT_PAIRS : [];
  let currentLocale = localStorage.getItem('portfolio_locale') || window.ACTIVE_LOCALE || 'id';
  if (!i18nDictionary[currentLocale]) {
    currentLocale = 'id';
  }

  function normalizeI18nText(str) {
    return String(str || '').replace(/\r\n/g, '\n').replace(/[ \t]+/g, ' ').replace(/\n+/g, '\n').trim();
  }

  const idToEnMap = new Map();
  const enToIdMap = new Map();
  contentPairs.forEach(pair => {
    if (!pair || !pair.id || !pair.en) return;
    idToEnMap.set(normalizeI18nText(pair.id), pair.en);
    enToIdMap.set(normalizeI18nText(pair.en), pair.id);
  });

  // Preserve exact database-rendered values once so custom Admin inputs are never lost
  const dbElements = Array.from(document.querySelectorAll('[data-i18n-db]'));
  dbElements.forEach(el => {
    if (el.dataset.dbOrigHtml === undefined) {
      el.dataset.dbOrigHtml = el.innerHTML;
      el.dataset.dbOrigText = el.textContent;
    }
  });

  function applyCommonPhraseFallback(text, targetLocale) {
    if (!text) return text;
    if (targetLocale === 'en') {
      return text
        .replace(/\bOkt\b/g, 'Oct')
        .replace(/\bMei\b/g, 'May')
        .replace(/\bAgu\b/g, 'Aug')
        .replace(/\bDes\b/g, 'Dec')
        .replace(/\bSekarang\b/g, 'Present');
    }
    return text;
  }

  function translateContentString(rawText, targetLocale) {
    const locale = targetLocale || currentLocale;
    const key = normalizeI18nText(rawText);
    if (!key) return rawText;

    if (locale === 'en' && idToEnMap.has(key)) {
      return idToEnMap.get(key);
    }
    if (locale === 'id' && enToIdMap.has(key)) {
      return enToIdMap.get(key);
    }
    return applyCommonPhraseFallback(rawText, locale);
  }

  window.__translatePortfolioContent = (val) => translateContentString(val, currentLocale);

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

    // 1. Update static UI text / html
    document.querySelectorAll('[data-i18n]').forEach(el => {
      const key = el.getAttribute('data-i18n');
      const translation = getNestedTranslation(dict, key);
      if (typeof translation === 'string') {
        if (translation.includes('<') && translation.includes('>')) {
          el.innerHTML = translation;
        } else {
          el.textContent = translation;
        }
      }
    });

    // 2. Update DB-driven content cleanly without losing custom Admin edits
    dbElements.forEach(el => {
      const mode = el.getAttribute('data-i18n-db') || 'text';
      const origHtml = el.dataset.dbOrigHtml ?? el.innerHTML;
      const origText = el.dataset.dbOrigText ?? el.textContent;
      const lookupRaw = mode === 'html' ? origHtml : origText;
      const normalized = normalizeI18nText(lookupRaw);

      if (locale === 'en') {
        if (idToEnMap.has(normalized)) {
          const translated = idToEnMap.get(normalized);
          if (mode === 'html') {
            el.innerHTML = translated;
          } else {
            el.textContent = translated;
          }
        } else {
          if (mode === 'html') {
            el.innerHTML = origHtml;
          } else {
            el.textContent = applyCommonPhraseFallback(origText, 'en');
          }
        }
      } else {
        if (enToIdMap.has(normalized)) {
          const translated = enToIdMap.get(normalized);
          if (mode === 'html') {
            el.innerHTML = translated;
          } else {
            el.textContent = translated;
          }
        } else {
          el.innerHTML = origHtml;
        }
      }
    });

    // 3. Update attributes (placeholder, title, aria-label)
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

    // Update menu toggle label if nav overlay is currently open
    if (menuToggle && navOverlay?.classList.contains('active')) {
      const labels = getMenuLabels();
      menuToggle.innerHTML = `${labels.close} <span style="font-size:1.1rem;margin-left:4px;">✕</span>`;
    }

    // 4. Keep Laravel session in sync in background
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

  // Delegate clicks across desktop & mobile language switchers
  document.addEventListener('click', (e) => {
    const btn = e.target.closest('.lang-btn');
    if (!btn) return;
    e.preventDefault();
    const selected = btn.getAttribute('data-lang');
    if (selected && selected !== currentLocale) {
      applyLocale(selected, true);
    }
  });

  // Apply default/saved locale on load
  applyLocale(currentLocale, false);
});
