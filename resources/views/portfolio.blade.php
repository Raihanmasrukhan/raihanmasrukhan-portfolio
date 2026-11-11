<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $profile->full_name }} — {{ $profile->headline }}</title>
  
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
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
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
        <div class="location-badge">
          @if($profile->is_available)
            <span class="status-dot"></span>
          @endif
          <span>{{ $profile->location }}</span>
        </div>
      </div>

      <div class="header-center">
        <span class="time-pulse">●</span>
        <span id="live-time">19:30:00 WIB</span>
      </div>

      <div class="header-right flex items-center gap-3">
        @auth
          <a href="{{ route('admin.dashboard') }}" class="text-[11px] font-mono text-[#ff5500] hover:text-white uppercase tracking-wider px-3 py-1.5 rounded-full border border-[#ff5500]/40 bg-[#ff5500]/10 transition-colors hidden sm:inline-block">
            Dashboard Admin ➔
          </a>
        @else
          <a href="{{ route('login') }}" class="text-[11px] font-mono text-gray-400 hover:text-white uppercase tracking-wider px-3 py-1.5 rounded-full border border-gray-800 bg-gray-900/60 transition-colors hidden sm:inline-block">
            Admin Login
          </a>
        @endauth

        <button class="btn-menu-toggle" id="menu-toggle" aria-label="Toggle navigation menu" aria-expanded="false">
          <span>MENU</span>
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
      <div class="nav-overlay-label">NAVIGATION INDEX</div>
      <nav class="nav-links-list">
        <div class="nav-link-item"><a href="#about"><span class="nav-num">01</span><span class="nav-text">ABOUT ME</span><span class="nav-arrow">→</span></a></div>
        <div class="nav-link-item"><a href="#services"><span class="nav-num">02</span><span class="nav-text">WHAT I OFFER</span><span class="nav-arrow">→</span></a></div>
        <div class="nav-link-item"><a href="#process"><span class="nav-num">03</span><span class="nav-text">HOW I WORK</span><span class="nav-arrow">→</span></a></div>
        <div class="nav-link-item"><a href="#experience"><span class="nav-num">04</span><span class="nav-text">EXPERIENCE</span><span class="nav-arrow">→</span></a></div>
        <div class="nav-link-item"><a href="#projects"><span class="nav-num">05</span><span class="nav-text">SELECTED WORKS</span><span class="nav-arrow">→</span></a></div>
        <div class="nav-link-item"><a href="#milestones"><span class="nav-num">06</span><span class="nav-text">MILESTONES</span><span class="nav-arrow">→</span></a></div>
        <div class="nav-link-item"><a href="#stack-education"><span class="nav-num">07</span><span class="nav-text">STACK &amp; EDU</span><span class="nav-arrow">→</span></a></div>
        <div class="nav-link-item"><a href="#testimonials"><span class="nav-num">08</span><span class="nav-text">TESTIMONIALS</span><span class="nav-arrow">→</span></a></div>
        <div class="nav-link-item nav-link-cta"><a href="#contact"><span class="nav-num">09</span><span class="nav-text">START A PROJECT</span><span class="nav-arrow">➔</span></a></div>
        @auth
          <div class="nav-link-item nav-link-admin"><a href="{{ route('admin.dashboard') }}"><span class="nav-num">10</span><span class="nav-text">ADMIN DASHBOARD</span><span class="nav-arrow">⚙</span></a></div>
        @else
          <div class="nav-link-item nav-link-admin"><a href="{{ route('login') }}"><span class="nav-num">10</span><span class="nav-text">ADMIN LOGIN</span><span class="nav-arrow">→</span></a></div>
        @endauth
      </nav>
      <div class="nav-overlay-footer">
        @if($profile->github_url)
          <a href="{{ $profile->github_url }}" target="_blank" rel="noopener">GitHub</a>
        @endif
        @if($profile->linkedin_url)
          <a href="{{ $profile->linkedin_url }}" target="_blank" rel="noopener">LinkedIn</a>
        @endif
        @if($profile->whatsapp_number)
          <a href="https://wa.me/{{ $profile->whatsapp_number }}" target="_blank" rel="noopener">WhatsApp</a>
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
            <div class="hero-badge-pill">
              <span class="hero-badge-dot"></span>
              <span>{{ $profile->availability_status ?? 'Available for Projects' }}</span>
            </div>
            <h1 class="hero-name">
              <span class="hero-name-top">{{ $profile->hero_title_line1 }}</span>
              <span class="hero-name-sub"><span class="outline-text">{{ $profile->hero_title_prefix }}</span><span class="solid-text">{{ $profile->hero_title_suffix }}</span></span>
            </h1>
          </div>

          <div class="hero-description">
            @php
              $headlineStr = $profile->headline;
              $subStr = $profile->sub_headline ?? '';
              $cleanedBody = trim(str_ireplace($headlineStr . '.', '', $subStr));
              if (empty($cleanedBody)) {
                $cleanedBody = $subStr;
              }
            @endphp
            @if(!empty($headlineStr))
              <span class="hero-description-lead">{{ $headlineStr }}</span>
            @endif
            <span class="hero-description-body">{{ $cleanedBody }}</span>
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

              <a href="mailto:{{ $profile->email }}" class="social-btn" aria-label="Send Email">
                <svg viewBox="0 0 24 24"><path d="M0 3v18h24v-18h-24zm21.518 2l-9.518 7.713-9.518-7.713h19.036zm-19.518 14v-11.817l9.518 7.682 9.518-7.682v11.817h-19.036z"/></svg>
              </a>
            </div>

            <a href="#contact" class="btn-primary-orange">
              <span>START A PROJECT</span>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </a>
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
              <div class="services-tag-header">Specialties</div>
              <ul class="services-tag-list">
                @foreach($profile->hero_specialties as $specialty)
                  <li>{{ $specialty }}</li>
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
            <span>[ ABOUT ME ]</span>
          </div>
          <div>
            <div class="about-statement">
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
                <span>{{ $miniProject->badge ?? $miniProject->category }}</span>
                <span class="pill">VIEW ➔</span>
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
            <h2 class="section-title-large">WHAT I OFFER</h2>
          </div>
          <div>
            <a href="#contact" class="btn-view-all">
              <span>DISCUSS A PROJECT</span>
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
                <p class="service-card-desc">{{ $service->description }}</p>
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
            <div class="section-tag">WORK PROCESS</div>
            <h2 class="section-title-large">HOW I WORK</h2>
          </div>
          <p class="process-subtitle">
            A simple, disciplined engineering process designed to turn complex business ideas into high-impact digital products, from concept to production.
          </p>
        </div>

        <div class="process-grid">
          @foreach($processes as $process)
            <div class="process-card {{ $process->is_featured ? 'featured-orange' : '' }} reveal">
              <div class="process-card-num">{{ $process->step_number }}</div>
              <div>
                <h3 class="process-card-title">{{ $process->title }}</h3>
                <p class="process-card-desc">{{ $process->description }}</p>
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
          <div class="experience-badge">My Experience</div>
          <h2 class="experience-title">
            Turning Ideas into <span class="highlight-orange">High-Performance</span> Systems
          </h2>
        </div>

        <div class="experience-floating-card reveal">
          <div class="timeline-list">
            @foreach($experiences as $exp)
              <div class="timeline-item">
                <div class="timeline-role-info">
                  <h4>{{ $exp->role }}</h4>
                  <div class="company-name">{{ $exp->company }}</div>
                  <div class="date-span">{{ $exp->date_span }}</div>
                </div>
                <div class="timeline-indicator">
                  <span class="timeline-dot"></span>
                </div>
                <div class="timeline-desc-info">
                  <p>{{ $exp->description }}</p>
                  @if(is_array($exp->badges))
                    <div class="timeline-badges">
                      @foreach($exp->badges as $b)
                        <span class="timeline-badge">{{ $b }}</span>
                      @endforeach
                    </div>
                  @endif
                </div>
              </div>
            @endforeach
          </div>

          <div class="experience-cta-wrap">
            <a href="#contact" class="btn-floating-cta">
              <span>Let's Work Together</span>
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
            <div class="section-tag">PORTFOLIO SHOWCASE</div>
            <h2 class="section-title-large">SELECTED WORKS</h2>
          </div>

          <div class="filter-buttons">
            <button class="filter-btn active" data-filter="all">All Projects</button>
            <button class="filter-btn" data-filter="saas">SaaS Platforms</button>
            <button class="filter-btn" data-filter="enterprise">Management Systems</button>
            <button class="filter-btn" data-filter="landing">Landing & CMS</button>
          </div>
        </div>

        <div class="projects-grid">
          @foreach($projects as $project)
            <div class="project-card reveal" data-category="{{ $project->category }}">
              <div class="project-thumb-wrap">
                <img src="{{ asset($project->image) }}" alt="{{ $project->title }}" class="project-thumb-img" loading="lazy">
                <div class="project-badge-tag">{{ $project->badge ?? $project->category }}</div>
              </div>
              <div class="project-body">
                <div class="project-client-name">{{ $project->client ?? 'Independent Project' }}</div>
                <h3 class="project-title">{{ $project->title }}</h3>
                <p class="project-desc">{{ $project->overview }}</p>
                @if(is_array($project->tech_stack))
                  <div class="project-tech-pills">
                    @foreach($project->tech_stack as $tech)
                      <span class="project-tech-pill">{{ $tech }}</span>
                    @endforeach
                  </div>
                @endif
                <div class="project-actions">
                  <button class="btn-project-detail" data-project-trigger="{{ $project->slug }}">
                    <span>Explore Case Study</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                  </button>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </section>

    <!-- Milestones & Track Record Table -->
    <section class="milestones-section" id="milestones">
      <div class="container">
        <div class="milestones-header reveal">
          <div>
            <div class="section-tag">PROVEN TRACK RECORD</div>
            <h2 class="milestones-title">
              PROVEN
              <span class="sub-line">MILESTONES</span>
            </h2>
          </div>
          <div>
            @if($profile->github_url)
              <a href="{{ $profile->github_url }}" target="_blank" rel="noopener" class="btn-awards-cta">
                <span>VIEW GITHUB REPOS</span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="14" y1="5" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
              </a>
            @endif
          </div>
        </div>

        <div class="milestones-table-wrap reveal">
          <table class="milestones-table">
            <thead>
              <tr>
                <th>ORGANIZATION / CLIENT</th>
                <th>PROJECT & DELIVERABLE</th>
                <th>PRIMARY TECH</th>
                <th>PERIOD / STATUS</th>
              </tr>
            </thead>
            <tbody>
              @foreach($milestones as $milestone)
                <tr>
                  <td class="strong-col">{{ $milestone->organization }}</td>
                  <td>{{ $milestone->project_name }}</td>
                  <td class="badge-col">{{ $milestone->tech_stack }}</td>
                  <td>{{ $milestone->period }}</td>
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
          <div class="section-tag">CORE COMPETENCIES</div>
          <h2 class="section-title-large" style="margin-bottom: 2rem;">TECH STACK</h2>

          @if(isset($skillsByCategory['web_app']))
            <div class="skills-category">
              <div class="skills-cat-title">// Web & App Development</div>
              <div class="skills-tag-cloud">
                @foreach($skillsByCategory['web_app'] as $skill)
                  <span class="skill-pill">{{ $skill->name }}</span>
                @endforeach
              </div>
            </div>
          @endif

          @if(isset($skillsByCategory['database_arch']))
            <div class="skills-category">
              <div class="skills-cat-title">// Database & Architecture</div>
              <div class="skills-tag-cloud">
                @foreach($skillsByCategory['database_arch'] as $skill)
                  <span class="skill-pill">{{ $skill->name }}</span>
                @endforeach
              </div>
            </div>
          @endif

          @if(isset($skillsByCategory['tools_cloud']))
            <div class="skills-category">
              <div class="skills-cat-title">// Tools, Cloud & Creative</div>
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
          <div class="section-tag">EDUCATION</div>
          <h2 class="section-title-large" style="margin-bottom: 2rem;">ACADEMIC</h2>

          @foreach($educations as $education)
            <div class="edu-card">
              <div class="edu-year">{{ $education->period }}</div>
              <h3 class="edu-school">{{ $education->school }}</h3>
              <div class="edu-degree">{{ $education->degree }}</div>
              @if($education->notes)
                <p class="edu-note">{{ $education->notes }}</p>
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
            <div class="section-tag">CLIENT ENDORSEMENTS</div>
            <h2 class="section-title-large">TESTIMONIALS</h2>
          </div>
          <p class="text-xs font-mono text-gray-400 max-w-md leading-relaxed">
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
                    <span class="px-2.5 py-1 text-[10px] font-mono uppercase tracking-wider rounded bg-gray-800 text-gray-300 font-semibold">
                      Verified Partner
                    </span>
                  @endif

                  <div class="star-rating" aria-label="{{ $item->rating }} out of 5 stars">
                    {{ str_repeat('★', $item->rating ?? 5) }}
                  </div>
                </div>

                <blockquote class="text-sm text-gray-200 leading-relaxed font-sans relative z-10">
                  "{{ $item->message }}"
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
                      <span class="text-[9px] font-mono bg-[#ff5500] text-black font-black px-1.5 py-0.5 rounded uppercase">Featured</span>
                    @endif
                  </div>
                  <div class="text-[11px] font-mono text-gray-400 truncate mt-0.5">
                    {{ collect([$item->role_title, $item->company])->filter()->implode(' • ') ?: 'Client Partner' }}
                  </div>
                </div>
              </div>
            </article>
          @empty
            <div class="col-span-full p-12 text-center rounded-2xl bg-[#121218] border border-gray-800 text-gray-500 font-mono text-xs">
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
            <div class="section-tag">GET IN TOUCH</div>
            <h2 class="contact-title">
              LET'S BUILD SOMETHING <span>IMPACTFUL</span>
            </h2>
            <p class="contact-desc">
              Siap berkolaborasi dalam perancangan aplikasi web berskala produksi, platform SaaS kustom, sistem manajemen internal, maupun landing page berkonversi tinggi.
            </p>

            <div class="contact-info-list">
              <!-- WhatsApp / Phone -->
              <div class="contact-item">
                <div class="contact-item-icon" aria-hidden="true">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                </div>
                <div class="contact-item-text">
                  <span class="label">WhatsApp & Phone</span>
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
                  <span class="label">Email Address</span>
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
                  <span class="label">Location</span>
                  <div class="value" style="color:var(--text-secondary);">{{ $profile->location }}</div>
                </div>
              </div>
            </div>
          </div>

          <!-- Right Interactive Direct Form -->
          <div class="contact-form-wrap reveal">
            <form id="contact-form" action="{{ route('contact.submit') }}" method="POST">
              @csrf
              <div class="form-group">
                <label for="sender-name" class="form-label">Your Name / Company</label>
                <input type="text" id="sender-name" name="name" class="form-input" placeholder="e.g. Budi Santoso / PT. Inovasi Digital" required>
              </div>

              <div class="form-group">
                <label for="sender-email" class="form-label">Your Email or WhatsApp</label>
                <input type="text" id="sender-email" name="email_or_phone" class="form-input" placeholder="e.g. budi@example.com or 08123456789" required>
              </div>

              <div class="form-group">
                <label for="project-type" class="form-label">Interested Service / Project Type</label>
                <select id="project-type" name="project_type" class="form-select">
                  <option value="SaaS & Custom Web Application">SaaS & Custom Web Application</option>
                  <option value="Enterprise Management System">Enterprise Management System</option>
                  <option value="Full-Stack Web Development (Laravel/React)">Full-Stack Web Development (Laravel/React)</option>
                  <option value="High-Converting Landing Page & Profile">High-Converting Landing Page & Profile</option>
                  <option value="UI/UX Design & Consulting">UI/UX Design & Consulting</option>
                </select>
              </div>

              <div class="form-group">
                <label for="sender-message" class="form-label">Project Details & Requirements</label>
                <textarea id="sender-message" name="message" class="form-textarea" placeholder="Ceritakan ide, kebutuhan sistem, atau jadwal pengerjaan proyek Anda..." required></textarea>
              </div>

              <button type="submit" class="btn-submit-form">
                <span>SEND DIRECT VIA WHATSAPP</span>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
              </button>
            </form>
          </div>
        </div>

        <!-- Site Footer -->
        <footer class="site-footer">
          <div class="footer-left">
            <span>© {{ date('Y') }} {{ strtoupper($profile->full_name) }}. ALL RIGHTS RESERVED. POWERED BY LARAVEL & TAILWIND.</span>
          </div>

          <div>
            <a href="#hero" class="btn-scroll-top" id="scroll-top-btn">
              <span>BACK TO TOP</span>
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
            <span class="meta-label">Client / Org</span>
            <div class="meta-val" id="modal-client">Client Name</div>
          </div>
          <div class="modal-meta-item">
            <span class="meta-label">Role</span>
            <div class="meta-val" id="modal-role">Full-Stack Developer</div>
          </div>
          <div class="modal-meta-item">
            <span class="meta-label">Timeline</span>
            <div class="meta-val" id="modal-timeline">Nov 2024 – Present</div>
          </div>
        </div>

        <p class="modal-desc" id="modal-desc">Project comprehensive overview...</p>

        <h4 style="font-family:var(--font-mono);font-size:0.82rem;color:var(--accent-orange);margin-bottom:0.75rem;text-transform:uppercase;letter-spacing:0.08em;">Key Deliverables & Impact</h4>
        <ul id="modal-highlights" style="margin-bottom:1.5rem;font-size:0.9rem;color:var(--text-secondary);line-height:1.6;">
        </ul>

        <h4 style="font-family:var(--font-mono);font-size:0.82rem;color:var(--text-muted);margin-bottom:0.75rem;text-transform:uppercase;letter-spacing:0.08em;">Technologies Used</h4>
        <div id="modal-stack" style="display:flex;flex-wrap:wrap;gap:0.5rem;">
        </div>
      </div>
    </div>
  </div>

  <!-- Toast Notification -->
  <div class="toast-notice" id="toast" role="status" aria-live="polite"></div>

  <!-- Dynamic Database Projects Injected into JavaScript -->
  <script>
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
          stack: @json($p->tech_stack ?? [])
        },
      @endforeach
    };

    window.TARGET_WHATSAPP_NUMBER = @json($profile->whatsapp_number);
  </script>

  <!-- Interactive Scripts -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

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

