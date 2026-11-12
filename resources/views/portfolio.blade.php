<!DOCTYPE html>
<html lang="{{ $currentLocale ?? 'id' }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $profile->full_name }} — {{ $profile->headline }}</title>
  
  <!-- Instant Theme & Locale Initialization (prevents FOUC) -->
  <script>
    (function() {
      try {
        const savedTheme = localStorage.getItem('portfolio_theme');
        const systemPrefersLight = window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches;
        const activeTheme = savedTheme ? savedTheme : (systemPrefersLight ? 'light' : 'dark');
        document.documentElement.setAttribute('data-theme', activeTheme);
        if (activeTheme === 'light') {
          document.documentElement.classList.add('light-mode');
        }
        const savedLocale = localStorage.getItem('portfolio_locale') || '{{ $currentLocale ?? "id" }}';
        document.documentElement.setAttribute('lang', savedLocale);
      } catch(e) {}
    })();
  </script>

  <!-- SEO & Social Meta Tags -->
  <meta name="description" content="Portfolio of {{ $profile->full_name }}. {{ $profile->headline }}. {{ $profile->sub_headline }}">
  <meta name="keywords" content="{{ $profile->full_name }}, Software Engineer, Full-Stack Developer, Web Developer Indonesia, Laravel, React, Tailwind, SaaS, Geofencing, PWA">
  <meta name="author" content="{{ $profile->full_name }}">

  <!-- Open Graph / Social Sharing -->
  <meta property="og:type" content="website">
  <meta property="og:title" content="{{ $profile->full_name }} — {{ $profile->headline }}">
  <meta property="og:description" content="{{ $profile->sub_headline }}">
  <meta property="og:image" content="{{ asset($profile->avatar) }}">

  <!-- Favicon -->
  <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='20' fill='%23ff5500'/><text x='50%' y='55%' dominant-baseline='middle' text-anchor='middle' font-family='sans-serif' font-weight='900' font-size='52' fill='%23000'>RM</text></svg>">

  <!-- Google Fonts: Outfit & Sora (Display), Plus Jakarta Sans (Body), JetBrains Mono (Tech/Code) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&family=Outfit:wght@600;700;800;900&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">

  <!-- Stylesheets -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}{{ file_exists(public_path('assets/css/style.css')) ? '?v=' . filemtime(public_path('assets/css/style.css')) : '' }}">
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    /* Client Testimonials Section Styles */
    .testimonials-section {
      padding: 6.5rem 0;
      position: relative;
      background: linear-gradient(180deg, var(--bg-primary) 0%, rgba(16, 16, 22, 0.75) 50%, var(--bg-primary) 100%);
      border-top: 1px solid var(--border-subtle);
    }
    .testimonial-card {
      background: rgba(20, 20, 26, 0.85);
      border: 1px solid var(--border-subtle);
      border-radius: var(--radius-lg);
      padding: 2rem;
      transition: var(--transition-smooth);
      position: relative;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      backdrop-filter: blur(12px);
    }
    .testimonial-card:hover {
      border-color: var(--border-accent);
      transform: translateY(-4px);
      box-shadow: 0 20px 45px rgba(0, 0, 0, 0.45);
    }
    .testimonial-card.is-featured {
      border-color: rgba(255, 85, 0, 0.55);
      background: linear-gradient(145deg, rgba(28, 18, 14, 0.9) 0%, rgba(18, 18, 24, 0.95) 100%);
    }
    .testimonial-quote-mark {
      font-family: Georgia, serif;
      font-size: 3.5rem;
      line-height: 1;
      color: rgba(255, 85, 0, 0.25);
      position: absolute;
      top: 1.25rem;
      right: 1.5rem;
      pointer-events: none;
      user-select: none;
    }
    .star-rating {
      color: #ffaa00;
      font-size: 0.85rem;
      letter-spacing: 2px;
    }

    /* Light Theme Overrides for Testimonials & Components */
    [data-theme="light"] .testimonials-section,
    body.light-mode .testimonials-section {
      background: linear-gradient(180deg, var(--bg-primary) 0%, #f1f5f9 50%, var(--bg-primary) 100%);
    }
    [data-theme="light"] .testimonials-subtitle,
    body.light-mode .testimonials-subtitle {
      color: #475569 !important;
    }
    [data-theme="light"] .testimonial-verified-badge,
    body.light-mode .testimonial-verified-badge {
      background: #f1f5f9 !important;
      color: #334155 !important;
      border: 1px solid rgba(15, 23, 42, 0.08);
    }
    [data-theme="light"] .testimonial-card,
    body.light-mode .testimonial-card {
      background: #ffffff;
      border-color: rgba(15, 23, 42, 0.09);
      box-shadow: 0 6px 24px rgba(15, 23, 42, 0.05);
    }
    [data-theme="light"] .testimonial-card:hover,
    body.light-mode .testimonial-card:hover {
      border-color: rgba(255, 85, 0, 0.45);
      box-shadow: 0 20px 45px rgba(15, 23, 42, 0.09);
    }
    [data-theme="light"] .testimonial-card.is-featured,
    body.light-mode .testimonial-card.is-featured {
      background: linear-gradient(145deg, #ffffff 0%, #fff7ed 100%);
      border-color: rgba(255, 85, 0, 0.45);
      box-shadow: 0 12px 32px rgba(255, 85, 0, 0.09);
    }
    [data-theme="light"] .testimonial-quote-mark,
    body.light-mode .testimonial-quote-mark {
      color: rgba(255, 85, 0, 0.16);
    }
    [data-theme="light"] .testimonial-card blockquote,
    body.light-mode .testimonial-card blockquote {
      color: #1e293b !important;
    }
    [data-theme="light"] .testimonial-card .text-white,
    body.light-mode .testimonial-card .text-white {
      color: #0f172a !important;
    }
    [data-theme="light"] .testimonial-card .text-gray-400,
    body.light-mode .testimonial-card .text-gray-400 {
      color: #64748b !important;
    }
    [data-theme="light"] .testimonial-card .border-gray-800\/80,
    body.light-mode .testimonial-card .border-gray-800\/80 {
      border-color: rgba(15, 23, 42, 0.08) !important;
    }
    [data-theme="light"] .testimonial-empty,
    body.light-mode .testimonial-empty {
      background: #ffffff !important;
      border-color: rgba(15, 23, 42, 0.1) !important;
      color: #64748b !important;
    }
  </style>
</head>
<body>

  <!-- Custom Cursor Elements -->
  <div class="custom-cursor" aria-hidden="true"></div>
  <div class="custom-cursor-follower" aria-hidden="true"></div>

  <!-- Site Header -->
  <header class="site-header" id="site-header">
    <div class="container header-inner">
      <div class="header-left">
        <a href="#hero" class="header-brand" aria-label="{{ $profile->full_name }}">
          <span>RM</span><span class="brand-dot">.</span>
        </a>
      </div>

      <div class="header-right flex items-center gap-2.5 sm:gap-3">
        <!-- Language Switcher Pill -->
        <div class="lang-switcher-pill" id="lang-switcher" aria-label="Pilih Bahasa / Language">
          <button type="button" class="lang-btn active" data-lang="id" title="Bahasa Indonesia">ID</button>
          <span class="lang-divider">/</span>
          <button type="button" class="lang-btn" data-lang="en" title="English">EN</button>
        </div>

        <!-- Light / Dark Mode Toggle Button -->
        <button id="theme-toggle" class="btn-theme-toggle" aria-label="Toggle light or dark mode" title="Mode Terang / Gelap">
          <span class="theme-icon-dark" aria-hidden="true">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="5"></circle>
              <line x1="12" y1="1" x2="12" y2="3"></line>
              <line x1="12" y1="21" x2="12" y2="23"></line>
              <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
              <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
              <line x1="1" y1="12" x2="3" y2="12"></line>
              <line x1="21" y1="12" x2="23" y2="12"></line>
              <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
              <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
            </svg>
          </span>
          <span class="theme-icon-light" aria-hidden="true">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
            </svg>
          </span>
        </button>

        <button class="btn-menu-toggle" id="menu-toggle" aria-label="Toggle navigation menu" aria-expanded="false">
          <span id="menu-btn-text">MENU</span>
          <div class="menu-icon-bars" aria-hidden="true">
            <span></span>
            <span></span>
          </div>
        </button>
      </div>
    </div>
  </header>

  <!-- Fullscreen Navigation Overlay -->
  <div class="nav-overlay" id="nav-overlay" role="dialog" aria-modal="true" aria-label="Navigation Menu">
    <div class="nav-overlay-inner">
      <div class="nav-overlay-label" data-i18n="nav.index_label">NAVIGATION INDEX</div>
      <nav class="nav-links-list">
        <div class="nav-link-item"><a href="#about"><span class="nav-num">01</span><span class="nav-text" data-i18n="nav.about">ABOUT ME</span><span class="nav-arrow">→</span></a></div>
        <div class="nav-link-item"><a href="#services"><span class="nav-num">02</span><span class="nav-text" data-i18n="nav.services">WHAT I OFFER</span><span class="nav-arrow">→</span></a></div>
        <div class="nav-link-item"><a href="#process"><span class="nav-num">03</span><span class="nav-text" data-i18n="nav.process">HOW I WORK</span><span class="nav-arrow">→</span></a></div>
        <div class="nav-link-item"><a href="#experience"><span class="nav-num">04</span><span class="nav-text" data-i18n="nav.experience">EXPERIENCE</span><span class="nav-arrow">→</span></a></div>
        <div class="nav-link-item"><a href="#projects"><span class="nav-num">05</span><span class="nav-text" data-i18n="nav.projects">SELECTED WORKS</span><span class="nav-arrow">→</span></a></div>
        <div class="nav-link-item"><a href="#milestones"><span class="nav-num">06</span><span class="nav-text" data-i18n="nav.milestones">MILESTONES</span><span class="nav-arrow">→</span></a></div>
        <div class="nav-link-item"><a href="#stack-education"><span class="nav-num">07</span><span class="nav-text" data-i18n="nav.stack">STACK &amp; EDU</span><span class="nav-arrow">→</span></a></div>
        <div class="nav-link-item"><a href="#testimonials"><span class="nav-num">08</span><span class="nav-text" data-i18n="nav.testimonials">TESTIMONIALS</span><span class="nav-arrow">→</span></a></div>
        <div class="nav-link-item nav-link-cta"><a href="#contact"><span class="nav-num">09</span><span class="nav-text" data-i18n="nav.start_project">START A PROJECT</span><span class="nav-arrow">➔</span></a></div>
      </nav>
      @php
        $cvHref = !empty($profile->cv_url)
          ? (\Illuminate\Support\Str::startsWith($profile->cv_url, ['http://', 'https://', '/']) ? $profile->cv_url : asset($profile->cv_url))
          : null;
      @endphp
      <div class="nav-overlay-footer">
        @if($profile->github_url)
          <a href="{{ $profile->github_url }}" target="_blank" rel="noopener">GitHub</a>
        @endif
        @if($profile->linkedin_url)
          <a href="{{ $profile->linkedin_url }}" target="_blank" rel="noopener">LinkedIn</a>
        @endif
        @if($profile->instagram_url)
          <a href="{{ $profile->instagram_url }}" target="_blank" rel="noopener">Instagram</a>
        @endif
        @if($profile->whatsapp_number)
          <a href="https://wa.me/{{ $profile->whatsapp_number }}" target="_blank" rel="noopener">WhatsApp</a>
        @endif
        @if($cvHref)
          <a href="{{ $cvHref }}" target="_blank" rel="noopener">Resume / CV</a>
        @endif
        <a href="mailto:{{ $profile->email }}">Email</a>
      </div>
    </div>
  </div>

  <main id="main-content">
    
    <!-- Hero Section -->
    <section class="hero-section" id="hero">
      <div class="hero-bg-accent" aria-hidden="true"></div>
      <div class="hero-vignette" aria-hidden="true"></div>

      <div class="container hero-grid">
        <!-- Left Hero Typography & Actions -->
        <div class="hero-left">
          <div class="hero-title-wrap">
            <div class="hero-badge-row">
              <div class="hero-badge-pill">
                @if($profile->is_available)
                  <span class="hero-badge-dot"></span>
                @endif
                <span data-i18n-db="text">{{ $profile->availability_status ?? 'Available for Projects' }}</span>
              </div>
              @if(!empty($profile->location))
                <div class="hero-location-pill">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                  <span data-i18n-db="text">{{ $profile->location }}</span>
                </div>
              @endif
            </div>
            <h1 class="hero-name">
              <span class="hero-name-top">{{ $profile->hero_title_line1 }}</span>
              <span class="hero-name-sub"><span class="outline-text">{{ $profile->hero_title_prefix }}</span><span class="solid-text">{{ $profile->hero_title_suffix }}</span></span>
            </h1>
            <p class="hero-fullname">{{ $profile->full_name }}</p>
          </div>

          <div class="hero-description">
            @if(!empty($profile->headline))
              <span class="hero-description-lead" data-i18n-db="text">{{ $profile->headline }}</span>
            @endif
            @if(!empty($profile->sub_headline))
              <span class="hero-description-body" data-i18n-db="text">{{ $profile->sub_headline }}</span>
            @endif
          </div>

          <div class="hero-actions">
            <div class="social-links">
              @if($profile->github_url)
                <a href="{{ $profile->github_url }}" target="_blank" rel="noopener" class="social-btn" aria-label="GitHub Profile">
                  <svg viewBox="0 0 24 24"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/></svg>
                </a>
              @endif

              @if($profile->linkedin_url)
                <a href="{{ $profile->linkedin_url }}" target="_blank" rel="noopener" class="social-btn" aria-label="LinkedIn Profile">
                  <svg viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                </a>
              @endif

              @if($profile->whatsapp_number)
                <a href="https://wa.me/{{ $profile->whatsapp_number }}" target="_blank" rel="noopener" class="social-btn" aria-label="Direct WhatsApp">
                  <svg viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                </a>
              @endif

              @if($profile->instagram_url)
                <a href="{{ $profile->instagram_url }}" target="_blank" rel="noopener" class="social-btn" aria-label="Instagram Profile">
                  <svg viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                </a>
              @endif

              <a href="mailto:{{ $profile->email }}" class="social-btn" aria-label="Send Email">
                <svg viewBox="0 0 24 24"><path d="M0 3v18h24v-18h-24zm21.518 2l-9.518 7.713-9.518-7.713h19.036zm-19.518 14v-11.817l9.518 7.682 9.518-7.682v11.817h-19.036z"/></svg>
              </a>
            </div>

            <a href="#contact" class="btn-primary-orange">
              <span data-i18n="hero.start_project_cta">START A PROJECT</span>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </a>

            @if($cvHref)
              <a href="{{ $cvHref }}" target="_blank" rel="noopener" class="btn-secondary-cv">
                <span data-i18n="hero.cv_btn">RESUME / CV</span>
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
              </a>
            @endif
          </div>
        </div>

        <!-- Right Hero Portrait & Floating Specialties -->
        <div class="hero-right">
          <div class="portrait-wrapper">
            <img src="{{ asset($profile->avatar) }}" alt="{{ $profile->full_name }} portrait" class="portrait-img" width="520" height="520" onerror="this.onerror=null; this.src='{{ asset('images/hero.jpg') }}';">
          </div>

          <!-- Floating Services Pill -->
          @if(is_array($profile->hero_specialties) && count($profile->hero_specialties) > 0)
            <div class="hero-services-pill">
              <div class="services-tag-header" data-i18n="hero.specialties_title">Specialties</div>
              <ul class="services-tag-list">
                @foreach($profile->hero_specialties as $specialty)
                  <li data-i18n-db="text">{{ $specialty }}</li>
                @endforeach
              </ul>
            </div>
          @endif
        </div>
      </div>
    </section>

    <!-- Editorial About Section -->
    <section class="about-section" id="about">
      <div class="container">
        <div class="about-grid reveal">
          <div class="about-meta">
            <span data-i18n="about.tag">[ ABOUT ME ]</span>
            <p class="about-meta-name">{{ $profile->full_name }}</p>
            @if(!empty($profile->location))
              <p class="about-meta-location" data-i18n-db="text">{{ $profile->location }}</p>
            @endif
          </div>
          <div>
            <div class="about-statement" data-i18n-db="html">
              {!! $profile->about_statement !!}
            </div>
          </div>
        </div>

        <!-- Interactive Mini Gallery Preview Strip -->
        <div class="gallery-strip reveal">
          @foreach($projects->take(4) as $miniProject)
            <div class="gallery-card" data-project-trigger="{{ $miniProject->slug }}">
              <img src="{{ asset($miniProject->image) }}" alt="{{ $miniProject->title }} Preview" loading="lazy">
                <div class="gallery-card-badge">
                  <span data-i18n-db="text">{{ $miniProject->badge ?? $miniProject->category }}</span>
                  <span class="pill" data-i18n="about.view_btn">VIEW ➔</span>
                </div>
            </div>
          @endforeach
        </div>
      </div>
    </section>

    <!-- What I Offer Section -->
    <section class="services-section" id="services">
      <div class="container">
        <div class="services-top-bar reveal">
          <div>
            <div class="section-counter">02 <span>/ 05</span></div>
            <h2 class="section-title-large" data-i18n="services.title">WHAT I OFFER</h2>
          </div>
          <div>
            <a href="#contact" class="btn-view-all">
              <span data-i18n="services.cta">DISCUSS A PROJECT</span>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </a>
          </div>
        </div>

        <div class="services-grid">
          @foreach($services as $service)
            <div class="service-card reveal">
              <div>
                <div class="service-card-num">{{ $service->number_label }}</div>
                <h3 class="service-card-title">{{ $service->title }}</h3>
                <p class="service-card-desc" data-i18n-db="text">{{ $service->description }}</p>
              </div>
              @if(is_array($service->tags))
                <div class="service-card-tags">
                  @foreach($service->tags as $tag)
                    <span class="tech-tag">{{ $tag }}</span>
                  @endforeach
                </div>
              @endif
            </div>
          @endforeach
        </div>
      </div>
    </section>

    <!-- Work Process Section -->
    <section class="process-section" id="process">
      <div class="container">
        <div class="process-header reveal">
          <div>
            <div class="section-tag" data-i18n="process.tag">WORK PROCESS</div>
            <h2 class="section-title-large" data-i18n="process.title">HOW I WORK</h2>
          </div>
          <p class="process-subtitle" data-i18n="process.subtitle">
            A simple, disciplined engineering process designed to turn complex business ideas into high-impact digital products, from concept to production.
          </p>
        </div>

        <div class="process-grid">
          @foreach($processes as $process)
            <div class="process-card {{ $process->is_featured ? 'featured-orange' : '' }} reveal">
              <div class="process-card-num">{{ $process->step_number }}</div>
              <div>
                <h3 class="process-card-title">{{ $process->title }}</h3>
                <p class="process-card-desc" data-i18n-db="text">{{ $process->description }}</p>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </section>

    <!-- Experience Section (Floating Clean Container) -->
    <section class="experience-section" id="experience">
      <div class="container">
        <div class="experience-header-wrap reveal">
          <div class="experience-badge" data-i18n="experience.badge">My Experience</div>
          <h2 class="experience-title">
            <span data-i18n="experience.title_prefix">Turning Ideas into</span> <span class="highlight-orange" data-i18n="experience.title_highlight">High-Performance</span> <span data-i18n="experience.title_suffix">Systems</span>
          </h2>
        </div>

        <div class="experience-floating-card reveal">
          <div class="timeline-list">
            @foreach($experiences as $exp)
              <div class="timeline-item">
                <div class="timeline-role-info">
                  <h4 data-i18n-db="text">{{ $exp->role }}</h4>
                  <div class="company-name">{{ $exp->company }}</div>
                  <div class="date-span" data-i18n-db="text">{{ $exp->date_span }}</div>
                </div>
                <div class="timeline-indicator">
                  <span class="timeline-dot"></span>
                </div>
                <div class="timeline-desc-info">
                  <p data-i18n-db="text">{{ $exp->description }}</p>
                  @if(is_array($exp->badges))
                    <div class="timeline-badges">
                      @foreach($exp->badges as $b)
                        <span class="timeline-badge" data-i18n-db="text">{{ $b }}</span>
                      @endforeach
                    </div>
                  @endif
                </div>
              </div>
            @endforeach
          </div>

          <div class="experience-cta-wrap">
            <a href="#contact" class="btn-floating-cta">
              <span data-i18n="experience.cta">Let's Work Together</span>
              <span class="btn-circle-icon">➔</span>
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- Selected Works / Projects Showcase -->
    <section class="projects-section" id="projects">
      <div class="container">
        <div class="projects-top reveal">
          <div>
            <div class="section-tag" data-i18n="projects.tag">PORTFOLIO SHOWCASE</div>
            <h2 class="section-title-large" data-i18n="projects.title">SELECTED WORKS</h2>
          </div>

          <div class="filter-buttons">
            <button class="filter-btn active" data-filter="all" data-i18n="projects.filter_all">All Projects</button>
            <button class="filter-btn" data-filter="saas" data-i18n="projects.filter_saas">SaaS Platforms</button>
            <button class="filter-btn" data-filter="enterprise" data-i18n="projects.filter_enterprise">Management Systems</button>
            <button class="filter-btn" data-filter="landing" data-i18n="projects.filter_landing">Landing & CMS</button>
            <button class="filter-btn" data-filter="design" data-i18n="projects.filter_design">Design & UI/UX</button>
            <button class="filter-btn" data-filter="video-editing" data-i18n="projects.filter_video">Video Editing</button>
          </div>
        </div>

        <div class="projects-grid">
          @foreach($projects as $project)
            <div class="project-card reveal" data-category="{{ $project->category }}">
              <div class="project-thumb-wrap">
                <img src="{{ asset($project->image) }}" alt="{{ $project->title }}" class="project-thumb-img" loading="lazy">
                <div class="project-badge-tag" data-i18n-db="text">{{ $project->badge ?? $project->category }}</div>
              </div>
              <div class="project-body">
                <div class="project-client-name">{{ $project->client ?? 'Independent Project' }}</div>
                <h3 class="project-title" data-i18n-db="text">{{ $project->title }}</h3>
                <p class="project-desc" data-i18n-db="text">{{ $project->overview }}</p>
                @if(is_array($project->tech_stack))
                  <div class="project-tech-pills">
                    @foreach($project->tech_stack as $tech)
                      <span class="project-tech-pill">{{ $tech }}</span>
                    @endforeach
                  </div>
                @endif
                <div class="project-actions">
                  <button class="btn-project-detail" data-project-trigger="{{ $project->slug }}">
                    <span data-i18n="projects.explore">Explore Case Study</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                  </button>

                  @if(!empty($project->live_url) || !empty($project->github_url))
                    <div class="project-external-links">
                      @if(!empty($project->live_url))
                        <a href="{{ $project->live_url }}" target="_blank" rel="noopener noreferrer" class="btn-project-link btn-project-live" aria-label="{{ $project->title }} Live Demo">
                          <span data-i18n="projects.live_demo">Live Demo</span>
                          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                        </a>
                      @endif
                      @if(!empty($project->github_url))
                        <a href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer" class="btn-project-link btn-project-github" aria-label="{{ $project->title }} GitHub Repository">
                          <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/></svg>
                          <span data-i18n="projects.github_repo">GitHub</span>
                        </a>
                      @endif
                    </div>
                  @endif
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <div id="projects-empty-state" class="projects-empty-state" style="display:none;" data-i18n="projects.empty_category">
          Belum ada karya pada kategori ini.
        </div>
      </div>
    </section>

    <!-- Milestones & Track Record Table -->
    <section class="milestones-section" id="milestones">
      <div class="container">
        <div class="milestones-header reveal">
          <div>
            <div class="section-tag" data-i18n="milestones.tag">PROVEN TRACK RECORD</div>
            <h2 class="milestones-title">
              <span data-i18n="milestones.title_main">PROVEN</span>
              <span class="sub-line" data-i18n="milestones.title_sub">MILESTONES</span>
            </h2>
          </div>
          <div>
            @if($profile->github_url)
              <a href="{{ $profile->github_url }}" target="_blank" rel="noopener" class="btn-awards-cta">
                <span data-i18n="milestones.btn_github">VIEW GITHUB REPOS</span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="14" y1="5" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
              </a>
            @endif
          </div>
        </div>

        <div class="milestones-table-wrap reveal">
          <table class="milestones-table">
            <thead>
              <tr>
                <th data-i18n="milestones.col_org">ORGANIZATION / CLIENT</th>
                <th data-i18n="milestones.col_project">PROJECT & DELIVERABLE</th>
                <th data-i18n="milestones.col_tech">PRIMARY TECH</th>
                <th data-i18n="milestones.col_period">PERIOD / STATUS</th>
              </tr>
            </thead>
            <tbody>
              @foreach($milestones as $milestone)
                <tr>
                  <td class="strong-col">{{ $milestone->organization }}</td>
                  <td data-i18n-db="text">{{ $milestone->project_name }}</td>
                  <td class="badge-col">{{ $milestone->tech_stack }}</td>
                  <td data-i18n-db="text">{{ $milestone->period }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- Tech Stack & Education Section -->
    <section class="stack-education-section" id="stack-education">
      <div class="container split-grid-section">
        <!-- Tech Stack Matrix -->
        <div class="reveal">
          <div class="section-tag" data-i18n="stack_edu.skills_tag">CORE COMPETENCIES</div>
          <h2 class="section-title-large" style="margin-bottom: 2rem;" data-i18n="stack_edu.skills_title">TECH STACK</h2>

          @if(isset($skillsByCategory['web_app']))
            <div class="skills-category">
              <div class="skills-cat-title" data-i18n="stack_edu.cat_webapp">// Web & App Development</div>
              <div class="skills-tag-cloud">
                @foreach($skillsByCategory['web_app'] as $skill)
                  <span class="skill-pill">{{ $skill->name }}</span>
                @endforeach
              </div>
            </div>
          @endif

          @if(isset($skillsByCategory['database_arch']))
            <div class="skills-category">
              <div class="skills-cat-title" data-i18n="stack_edu.cat_database">// Database & Architecture</div>
              <div class="skills-tag-cloud">
                @foreach($skillsByCategory['database_arch'] as $skill)
                  <span class="skill-pill">{{ $skill->name }}</span>
                @endforeach
              </div>
            </div>
          @endif

          @if(isset($skillsByCategory['tools_cloud']))
            <div class="skills-category">
              <div class="skills-cat-title" data-i18n="stack_edu.cat_tools">// Tools, Cloud & Creative</div>
              <div class="skills-tag-cloud">
                @foreach($skillsByCategory['tools_cloud'] as $skill)
                  <span class="skill-pill">{{ $skill->name }}</span>
                @endforeach
              </div>
            </div>
          @endif
        </div>

        <!-- Academic Background -->
        <div class="reveal">
          <div class="section-tag" data-i18n="stack_edu.edu_tag">EDUCATION</div>
          <h2 class="section-title-large" style="margin-bottom: 2rem;" data-i18n="stack_edu.edu_title">ACADEMIC</h2>

          @foreach($educations as $education)
            <div class="edu-card">
              <div class="edu-year" data-i18n-db="text">{{ $education->period }}</div>
              <h3 class="edu-school">{{ $education->school }}</h3>
              <div class="edu-degree" data-i18n-db="text">{{ $education->degree }}</div>
              @if($education->notes)
                <p class="edu-note" data-i18n-db="text">{{ $education->notes }}</p>
              @endif
            </div>
          @endforeach
        </div>
      </div>
    </section>

    <!-- Client Endorsements & Testimonials Section -->
    <section class="testimonials-section" id="testimonials">
      <div class="container">
        <div class="services-top-bar reveal">
          <div>
            <div class="section-tag" data-i18n="testimonials.tag">CLIENT ENDORSEMENTS</div>
            <h2 class="section-title-large" data-i18n="testimonials.title">TESTIMONIALS</h2>
          </div>
          <p class="testimonials-subtitle text-xs font-mono text-gray-400 max-w-md leading-relaxed" data-i18n="testimonials.subtitle">
            Perspectives from founders, executives, and institutional partners on engineering scalable digital platforms together.
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-10">
          @forelse($testimonials as $item)
            <article class="testimonial-card {{ $item->is_pinned ? 'is-featured' : '' }} reveal">
              <span class="testimonial-quote-mark" aria-hidden="true">“</span>

              <div>
                <div class="flex items-center justify-between gap-2 mb-5">
                  @if($item->project_tag)
                    <span class="px-2.5 py-1 text-[10px] font-mono uppercase tracking-wider rounded bg-[#ff5500]/10 text-[#ff5500] border border-[#ff5500]/30 font-semibold">
                      {{ $item->project_tag }}
                    </span>
                  @else
                    <span class="testimonial-verified-badge px-2.5 py-1 text-[10px] font-mono uppercase tracking-wider rounded bg-gray-800 text-gray-300 font-semibold" data-i18n="testimonials.verified_partner">
                      Verified Partner
                    </span>
                  @endif

                  <div class="star-rating" aria-label="{{ $item->rating }} out of 5 stars">
                    {{ str_repeat('★', $item->rating ?? 5) }}
                  </div>
                </div>

                <blockquote class="text-sm text-gray-200 leading-relaxed font-sans relative z-10">
                  "<span data-i18n-db="text">{{ $item->message }}</span>"
                </blockquote>
              </div>

              <div class="flex items-center gap-3.5 pt-5 mt-6 border-t border-gray-800/80">
                <span class="w-10 h-10 rounded-full flex items-center justify-center text-xs font-black text-black flex-shrink-0 shadow-md" style="background-color: {{ $item->avatar_color ?? '#ff5500' }}">
                  {{ strtoupper(substr($item->name, 0, 1)) }}
                </span>
                <div class="min-w-0">
                  <div class="font-bold text-sm text-white truncate flex items-center gap-2">
                    <span>{{ $item->name }}</span>
                    @if($item->is_pinned)
                      <span class="text-[9px] font-mono bg-[#ff5500] text-black font-black px-1.5 py-0.5 rounded uppercase" data-i18n="testimonials.featured_badge">Featured</span>
                    @endif
                  </div>
                  <div class="text-[11px] font-mono text-gray-400 truncate mt-0.5">
                    @if($item->role_title && $item->company)
                      <span data-i18n-db="text">{{ $item->role_title }}</span> • <span>{{ $item->company }}</span>
                    @elseif($item->role_title)
                      <span data-i18n-db="text">{{ $item->role_title }}</span>
                    @elseif($item->company)
                      <span>{{ $item->company }}</span>
                    @else
                      <span>Client Partner</span>
                    @endif
                  </div>
                </div>
              </div>
            </article>
          @empty
            <div class="testimonial-empty col-span-full p-12 text-center rounded-2xl bg-[#121218] border border-gray-800 text-gray-500 font-mono text-xs" data-i18n="testimonials.empty">
              Client testimonials will appear here once published.
            </div>
          @endforelse
        </div>
      </div>
    </section>

    <!-- Contact & Direct Inquiry Section -->
    <section class="contact-section" id="contact">
      <div class="container">
        <div class="contact-grid">
          <!-- Left Contact Info -->
          <div class="reveal">
            <div class="section-tag" data-i18n="contact.tag">GET IN TOUCH</div>
            <h2 class="contact-title">
              <span data-i18n="contact.title_prefix">LET'S BUILD SOMETHING</span> <span data-i18n="contact.title_highlight">IMPACTFUL</span>
            </h2>
            <p class="contact-desc" data-i18n="contact.desc">
              Siap berkolaborasi dalam perancangan aplikasi web berskala produksi, platform SaaS kustom, sistem manajemen internal, maupun landing page berkonversi tinggi.
            </p>

            <div class="contact-info-list">
              <!-- WhatsApp / Phone -->
              <div class="contact-item">
                <div class="contact-item-icon" aria-hidden="true">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                </div>
                <div class="contact-item-text">
                  <span class="label" data-i18n="contact.label_wa">WhatsApp & Phone</span>
                  <div class="value">
                    <a href="https://wa.me/{{ $profile->whatsapp_number }}" target="_blank" rel="noopener">{{ $profile->phone }}</a>
                    <button class="btn-copy" data-copy="{{ $profile->whatsapp_number }}" title="Copy phone number">Copy</button>
                  </div>
                </div>
              </div>

              <!-- Email -->
              <div class="contact-item">
                <div class="contact-item-icon" aria-hidden="true">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                </div>
                <div class="contact-item-text">
                  <span class="label" data-i18n="contact.label_email">Email Address</span>
                  <div class="value">
                    <a href="mailto:{{ $profile->email }}">{{ $profile->email }}</a>
                    <button class="btn-copy" data-copy="{{ $profile->email }}" title="Copy email address">Copy</button>
                  </div>
                </div>
              </div>

              <!-- Location -->
              <div class="contact-item">
                <div class="contact-item-icon" aria-hidden="true">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                </div>
                <div class="contact-item-text">
                  <span class="label" data-i18n="contact.label_location">Location</span>
                  <div class="value" style="color:var(--text-secondary);">{{ $profile->location }}</div>
                </div>
              </div>

              @if($cvHref)
                <!-- Resume / CV -->
                <div class="contact-item">
                  <div class="contact-item-icon" aria-hidden="true">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                  </div>
                  <div class="contact-item-text">
                    <span class="label" data-i18n="contact.label_cv">Resume / CV</span>
                    <div class="value">
                      <a href="{{ $cvHref }}" target="_blank" rel="noopener" data-i18n="contact.view_cv">Lihat / Unduh Resume (CV) &rarr;</a>
                    </div>
                  </div>
                </div>
              @endif
            </div>
          </div>

          <!-- Right Interactive Direct Form -->
          <div class="contact-form-wrap reveal">
            <form id="contact-form" action="{{ route('contact.submit') }}" method="POST">
              @csrf
              <div class="form-group">
                <label for="sender-name" class="form-label" data-i18n="contact.form_name">Your Name / Company</label>
                <input type="text" id="sender-name" name="name" class="form-input" placeholder="e.g. Budi Santoso / PT. Inovasi Digital" data-i18n-attr="placeholder:contact.placeholder_name" required>
              </div>

              <div class="form-group">
                <label for="sender-email" class="form-label" data-i18n="contact.form_contact">Your Email or WhatsApp</label>
                <input type="text" id="sender-email" name="email_or_phone" class="form-input" placeholder="e.g. budi@example.com or 08123456789" data-i18n-attr="placeholder:contact.placeholder_contact" required>
              </div>

              <div class="form-group">
                <label for="project-type" class="form-label" data-i18n="contact.form_service">Interested Service / Project Type</label>
                <select id="project-type" name="project_type" class="form-select">
                  <option value="SaaS & Custom Web Application" data-i18n="contact.service_opt_1">SaaS & Custom Web Application</option>
                  <option value="Enterprise Management System" data-i18n="contact.service_opt_2">Enterprise Management System</option>
                  <option value="Full-Stack Web Development (Laravel/React)" data-i18n="contact.service_opt_3">Full-Stack Web Development (Laravel/React)</option>
                  <option value="High-Converting Landing Page & Profile" data-i18n="contact.service_opt_4">High-Converting Landing Page & Profile</option>
                  <option value="UI/UX Design & Consulting" data-i18n="contact.service_opt_5">UI/UX Design & Consulting</option>
                </select>
              </div>

              <div class="form-group">
                <label for="sender-message" class="form-label" data-i18n="contact.form_details">Project Details & Requirements</label>
                <textarea id="sender-message" name="message" class="form-textarea" placeholder="Ceritakan ide, kebutuhan sistem, atau jadwal pengerjaan proyek Anda..." data-i18n-attr="placeholder:contact.placeholder_details" required></textarea>
              </div>

              <button type="submit" class="btn-submit-form">
                <span data-i18n="contact.btn_submit">SEND DIRECT VIA WHATSAPP</span>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
              </button>
            </form>
          </div>
        </div>

        <!-- Site Footer -->
        <footer class="site-footer">
          <div class="footer-left">
            <span>© {{ date('Y') }} {{ strtoupper($profile->full_name) }}.</span> <span data-i18n="footer.rights">ALL RIGHTS RESERVED. POWERED BY LARAVEL & TAILWIND.</span>
          </div>

          <div>
            <a href="#hero" class="btn-scroll-top" id="scroll-top-btn">
              <span data-i18n="footer.back_to_top">BACK TO TOP</span>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg>
            </a>
          </div>
        </footer>
      </div>
    </section>
  </main>

  <!-- Project Lightbox Modal -->
  <div class="modal-backdrop" id="project-modal" role="dialog" aria-modal="true" aria-label="Project Details">
    <div class="modal-content-card">
      <button class="modal-close-btn" id="modal-close" aria-label="Close project modal">✕</button>
      
      <div class="modal-image-wrap">
        <img src="{{ asset('images/project-saas.jpg') }}" id="modal-image" alt="Project Preview">
      </div>

      <div class="modal-body">
        <div class="modal-tag" id="modal-tag">SaaS Platform</div>
        <h3 class="modal-title" id="modal-title">Project Title</h3>

        <div class="modal-meta-grid">
          <div class="modal-meta-item">
            <span class="meta-label" data-i18n="modal.client">Client / Org</span>
            <div class="meta-val" id="modal-client">Client Name</div>
          </div>
          <div class="modal-meta-item">
            <span class="meta-label" data-i18n="modal.role">Role</span>
            <div class="meta-val" id="modal-role">Full-Stack Developer</div>
          </div>
          <div class="modal-meta-item">
            <span class="meta-label" data-i18n="modal.timeline">Timeline</span>
            <div class="meta-val" id="modal-timeline">Nov 2024 – Present</div>
          </div>
        </div>

        <p class="modal-desc" id="modal-desc">Project comprehensive overview...</p>

        <h4 style="font-family:var(--font-mono);font-size:0.82rem;color:var(--accent-orange);margin-bottom:0.75rem;text-transform:uppercase;letter-spacing:0.08em;" data-i18n="modal.deliverables">Key Deliverables & Impact</h4>
        <ul id="modal-highlights" style="margin-bottom:1.5rem;font-size:0.9rem;color:var(--text-secondary);line-height:1.6;">
        </ul>

        <h4 style="font-family:var(--font-mono);font-size:0.82rem;color:var(--text-muted);margin-bottom:0.75rem;text-transform:uppercase;letter-spacing:0.08em;" data-i18n="modal.technologies">Technologies Used</h4>
        <div id="modal-stack" style="display:flex;flex-wrap:wrap;gap:0.5rem;">
        </div>

        <div id="modal-links" class="modal-project-links" style="display:none;"></div>
      </div>
    </div>
  </div>

  <!-- Toast Notification -->
  <div class="toast-notice" id="toast" role="status" aria-live="polite"></div>

  <!-- Dynamic Database Projects Injected into JavaScript -->
  <script>
    window.I18N_DICTIONARY = {
      id: @json(trans('portfolio', [], 'id')),
      en: @json(trans('portfolio', [], 'en'))
    };
    window.I18N_CONTENT_PAIRS = @json(config('portfolio_i18n.pairs', []));
    window.ACTIVE_LOCALE = @json($currentLocale ?? 'id');

    window.DYNAMIC_PROJECTS = {
      @foreach($projects as $p)
        '{{ $p->slug }}': {
          title: @json($p->title),
          client: @json($p->client ?? 'Independent Client'),
          category: @json($p->category),
          role: @json($p->role ?? 'Software Engineer'),
          timeline: @json($p->timeline ?? 'Production'),
          badge: @json($p->badge ?? $p->category),
          image: @json(asset($p->image)),
          overview: @json($p->overview),
          highlights: @json($p->highlights ?? []),
          stack: @json($p->tech_stack ?? []),
          liveUrl: @json($p->live_url),
          githubUrl: @json($p->github_url)
        },
      @endforeach
    };

    window.TARGET_WHATSAPP_NUMBER = @json($profile->whatsapp_number);
  </script>

  <!-- Interactive Scripts -->
  <script src="{{ asset('assets/js/main.js') }}{{ file_exists(public_path('assets/js/main.js')) ? '?v=' . filemtime(public_path('assets/js/main.js')) : '' }}"></script>

  <script>
    // Handle flash toast messages
    @if(session('success'))
      window.addEventListener('DOMContentLoaded', () => {
        const toast = document.getElementById('toast');
        if (toast) {
          toast.textContent = @json(session('success'));
          toast.classList.add('active');
          setTimeout(() => toast.classList.remove('active'), 5000);
        }
      });
    @endif
  </script>

</body>
</html>

