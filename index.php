<?php 
// Përfshijmë header-in dhe lidhjen me DB
include 'includes/header.php'; 
include 'includes/db.php';
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<style>
  :root {
    --side-padding: 80px; 
  }

  body { 
    background: #fdfcf9; 
    margin: 0;
    font-family: 'DM Sans', sans-serif;
  }

  /* MAIN WRAPPER - PA NDËRYSHIME */
  .main-wrapper {
    max-width: 1200px;
    margin: 0 auto;
    padding: 140px var(--side-padding) 80px var(--side-padding);
  }

  .hero-grid {
    display: grid;
    grid-template-columns: 1fr 0.9fr;
    gap: 60px;
    align-items: center;
  }

  /* LEFT SIDE - PA NDËRYSHIME */
  .hero-left {
    display: flex;
    flex-direction: column;
  }

  .hero-tagline {
    color: var(--accent);
    font-weight: 700;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .hero-tagline::before {
    content: '';
    width: 30px;
    height: 2px;
    background: var(--accent);
    display: inline-block;
  }

  .hero-left h1 {
    font-family: 'Syne', sans-serif;
    font-weight: 800;
    font-size: 3.5rem;
    line-height: 0.95;
    letter-spacing: -0.04em;
    color: #0d0d0d;
    margin-bottom: 20px;
  }

  .hero-left h1 span { 
    color: var(--accent); 
    display: block; 
  }

  .hero-left p {
    font-size: 1rem;
    color: #555;
    line-height: 1.6;
    max-width: 480px;
    margin-bottom: 35px;
  }

  .hero-btns-container {
    display: flex;
    align-items: center;
    gap: 25px;
    margin-bottom: 50px;
  }

  .btn-shiko {
    background: #0d0d0d;
    color: #fff;
    padding: 14px 30px;
    font-weight: 700;
    text-decoration: none;
    font-size: 0.8rem;
    letter-spacing: 1px;
    border-radius: 4px;
    text-transform: uppercase;
    transition: 0.3s;
  }

  .btn-shiko:hover {
    background: var(--accent);
    transform: translateY(-3px);
  }

  .btn-rreth {
    color: #222;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.8rem;
    letter-spacing: 1px;
    display: flex;
    align-items: center;
    gap: 8px;
    text-transform: uppercase;
    transition: 0.3s;
  }

  .hero-divider {
    width: 100%;
    height: 1px;
    background: #e5e5e5;
    margin-bottom: 40px;
  }

  .stats-container {
    display: flex;
    gap: 60px;
  }

  .stat-item h2 {
    font-family: 'Syne', sans-serif;
    font-size: 2.2rem;
    font-weight: 800;
    margin: 0;
    line-height: 1;
    color: #0d0d0d;
    display: flex;
    align-items: center;
    gap: 5px;
  }

  .stat-item h2::after {
    content: '+';
    color: var(--accent);
    font-size: 1.5rem;
  }

  .stat-item p {
    font-size: 0.65rem;
    font-weight: 700;
    color: #999;
    margin-top: 10px;
    letter-spacing: 1px;
    text-transform: uppercase;
    line-height: 1.2;
  }

  /* 🔥 SLIDERI MINI-CONTENT */
  .hero-right {
    background: #000;
    position: relative;
    overflow: hidden;
    height: 650px;
    box-shadow: 0 25px 50px rgba(0,0,0,0.15);
    border-radius: 16px;
  }

  /* HEADER MINI */
  .slider-header {
    position: absolute;
    top: 20px;
    left: 20px;
    z-index: 20;
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(20px);
    padding: 8px 16px;
    border-radius: 20px;
    border: 1px solid rgba(255,255,255,0.3);
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
  }

  .slider-header h3 {
    font-family: 'Syne', sans-serif;
    font-size: 0.65rem;
    text-transform: uppercase;
    letter-spacing: 0.15em;
    color: #000;
    margin: 0;
    font-weight: 700;
  }

  /* FOTOJA E PLOTË */
  .post-slide {
    background-size: cover !important;
    background-position: center !important;
    background-repeat: no-repeat !important;
    position: relative;
    height: 100%;
    width: 100%;
  }

  .post-slide::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 60px;
    background: linear-gradient(to bottom, rgba(0,0,0,0.25), transparent);
    z-index: 1;
  }

  /* 🔥 CONTENT MINI - PA BACKGROUND */
  .slide-content {
    position: absolute;
    bottom: 30px;
    left: 30px;
    z-index: 10;
    max-width: 300px;
    width: 300px;
    padding: 0;
    background: none;
    border: none;
    box-shadow: none;
  }

  /* ✅ DATA MINI - MË E VOGËL */
  .post-meta {
    font-size: 0.65rem; /* ← 10.4px - më e vogël */
    color: var(--accent, #ff6b35) !important;
    font-weight: 700;
    margin-bottom: 8px; /* ← Më pak hapësirë */
    text-transform: uppercase;
    letter-spacing: 0.06em;
    padding: 4px 10px; /* ← Më e vogël */
    background: rgba(255,255,255,0.1);
    border-radius: 10px;
    display: inline-block;
    border: 1px solid rgba(255,255,255,0.2);
  }

  /* ✅ TITULL MË I VOGËL - 22px */
  .post-title {
    font-family: 'Syne', sans-serif;
    font-size: 1.375rem; /* ← 22px (nga 26px) */
    font-weight: 800;
    line-height: 1.2;
    color: #fff !important;
    margin: 0 0 12px 0; /* ← Më pak margin */
    text-shadow: none;
    letter-spacing: -0.015em;
  }

  /* ✅ BUTTON PA BACKGROUND - MË I VOGËL */
  .btn-read {
    display: inline-flex;
    align-items: center;
    gap: 8px; /* ← Më pak gap */
    color: #fff;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.75rem; /* ← 12px - më e vogël */
    text-transform: uppercase;
    letter-spacing: 0.6px;
    padding: 8px 14px 8px 12px; /* ← Shumë më i vogël */
    background: none !important; /* ← PA BACKGROUND */
    backdrop-filter: none;
    border: none !important; /* ← PA BORDER */
    border-radius: 0;
    transition: all 0.3s ease;
    position: relative;
    overflow: visible;
    text-shadow: 0 1px 2px rgba(0,0,0,0.5);
  }

  .btn-read::before {
    content: none; /* ← Heq efektin e background */
  }

  .btn-read:hover {
    color: var(--accent, #ff6b35) !important;
    transform: translateX(4px);
    text-shadow: 0 1px 2px rgba(0,0,0,0.7);
  }

  .btn-read .circle-icon {
    width: 28px; /* ← Më i vogël */
    height: 28px;
    background: var(--accent, #ff6b35);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    flex-shrink: 0;
  }

  .btn-read:hover .circle-icon {
    transform: translateX(4px) scale(1.1);
    background: #fff;
  }

  .btn-read svg {
    width: 12px; /* ← Më i vogël */
    height: 12px;
    stroke: #fff;
    stroke-width: 2;
    flex-shrink: 0;
  }

  .btn-read:hover svg {
    stroke: var(--accent, #ff6b35);
  }

  /* PAGINATION */
  .swiper-pagination {
    bottom: 20px !important;
  }

  .swiper-pagination-bullet {
    background: rgba(255,255,255,0.7);
    width: 10px;
    height: 10px;
  }

  .swiper-pagination-bullet-active {
    background: var(--accent, #ff6b35) !important;
    transform: scale(1.3);
  }

  /* ─── MARQUEE STYLES ─── */
  .marquee-band {
    background: var(--ink);
    color: white;
    padding: 14px 0;
    overflow: hidden;
    width: 100%;
    margin-top: -60px; /* Hapësirë nga hero section */
  }

  .marquee-track {
    display: flex;
    width: max-content;
    animation: marquee-scroll 30s linear infinite;
    white-space: nowrap;
  }

  .marquee-item {
    font-family: 'Syne', sans-serif;
    font-size: 0.78rem;
    font-weight: 600;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    padding: 0 48px;
    color: rgba(255, 255, 255, 0.6);
    display: flex;
    align-items: center;
    gap: 48px;
  }

  .marquee-item::after {
    content: '✦';
    color: var(--accent);
  }

  @keyframes marquee-scroll {
    from { transform: translateX(0); }
    to { transform: translateX(-50%); }
  }

/**lajmet */
.news-section {
    max-width: 1200px;
    margin: 100px auto;
    padding: 0 var(--side-padding);
  }

  .news-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 50px;
  }

  .news-header h2 {
    font-family: 'Syne', sans-serif;
    font-size: 2.8rem;
    letter-spacing: -1px;
    margin: 10px 0 0 0;
    color: var(--ink);
  }

  .news-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 40px;
  }

  .news-card {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
    border: 1px solid #eee;
  }

  .news-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 30px 60px rgba(0,0,0,0.08);
    border-color: var(--accent);
  }

  .card-image-box {
    position: relative;
    height: 240px;
    overflow: hidden;
  }

  .card-image-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: 0.5s;
  }

  .news-card:hover .card-image-box img {
    transform: scale(1.1);
  }

  /* Overlay i zi i lehtë mbi imazh */
  .card-image-box::after {
    content: '';
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    background: linear-gradient(to bottom, transparent 60%, rgba(0,0,0,0.2));
  }

  .card-badge {
    position: absolute;
    top: 20px; left: 20px;
    z-index: 2;
    background: var(--accent);
    color: #fff;
    font-size: 0.7rem;
    font-weight: 800;
    padding: 6px 14px;
    border-radius: 50px;
    text-transform: uppercase;
    letter-spacing: 1px;
  }

  .card-content {
    padding: 30px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
  }

  .card-meta {
    font-size: 0.8rem;
    font-weight: 700;
    color: var(--accent);
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .card-content h3 {
    font-family: 'Syne', sans-serif;
    font-size: 1.3rem;
    margin: 0 0 15px 0;
    line-height: 1.3;
    color: var(--ink);
  }

  .card-excerpt {
    font-size: 0.95rem;
    color: #666;
    line-height: 1.6;
    margin-bottom: 25px;
    display: -webkit-box;
    -webkit-line-clamp: 3; /* Shfaq vetëm 3 rreshta tekst */
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .btn-link {
    margin-top: auto;
    font-weight: 800;
    font-size: 0.85rem;
    color: var(--ink);
    text-transform: uppercase;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: 0.3s;
  }

  .news-card:hover .btn-link {
    color: var(--accent);
  }
/* Ngjyra specifike sipas tekstit brenda badge-it */
.card-badge { background: #666; } /* Ngjyra default */

.card-badge:contains('Aktivitet') { background: #ff6b35; }
.card-badge:contains('Konkurs') { background: #e74c3c; }
.card-badge:contains('Trajnim') { background: #3498db; }

/* TICKER ANIMATION */
.ticker-wrapper {
    background: #000;
    padding: 15px 0;
    overflow: hidden;
    border-bottom: 1px solid #333;
}
.ticker-content {
    display: flex;
    white-space: nowrap;
    animation: ticker 30s linear infinite;
}
.ticker-content span {
    color: #fff;
    font-family: 'Syne', sans-serif;
    font-weight: 700;
    font-size: 14px;
    padding: 0 40px;
    letter-spacing: 1px;
}
.ticker-content i { color: #ff6b35; margin-left: 10px; font-style: normal; }
@keyframes ticker {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}

/* ABOUT SECTION */
.about-section {
    background: #0d0d0d;
    padding: 100px 80px;
    color: #fff;
}
.about-container {
    max-width: 1300px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1.2fr 1fr;
    gap: 80px;
}
.about-eyebrow {
    color: #ff6b35;
    font-weight: 700;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .about-eyebrow::before {
    content: '';
    width: 30px;
    height: 2px;
    background: #ff6b35;
    display: inline-block;
  }
.about-title { font-family: 'Syne', sans-serif; font-size: 3.5rem; line-height: 1.1; margin-bottom: 30px; }
.about-title em { color: #ff6b35; font-style: normal; }
.about-text { font-family: 'Syne', sans-serif; color: #999; font-size: 1.1rem; line-height: 1.6; margin-bottom: 20px; max-width: 500px; }
.about-link { color: #ff6b35; text-decoration: none; font-weight: 800; display: flex; align-items: center; gap: 10px; margin-top: 30px; }

/* PILLAR GRID */
.pillar-grid { display: grid; grid-template-columns: 1fr 1fr; border: 1px solid #222; }
.pillar { padding: 40px; border: 1px solid #222; transition: background 0.3s; }
.pillar:hover { background: #151515; }
.pillar-icon { font-size: 24px; display: block; margin-bottom: 15px; }
.pillar-name { font-family: 'Syne', sans-serif; font-weight: 800; margin-bottom: 10px; }
.pillar-desc { color: #666; font-size: 0.9rem; line-height: 1.4; }
/* RESPONSIVE RREGULLIMI PËR ABOUT SECTION */

@media (max-width: 1024px) {
    .about-section {
        padding: 80px 40px;
    }
    .about-container {
        gap: 50px;
        grid-template-columns: 1fr; /* Kthehet në një kolonë për tablet */
    }
    .about-text {
        max-width: 100%;
    }
}

@media (max-width: 768px) {
    .about-section {
        padding: 60px 20px;
    }
    
    .about-title {
        font-size: 2.5rem; /* Titulli bëhet pak më i vogël në telefon */
    }

    .pillar-grid {
        grid-template-columns: 1fr; /* Katrorët e shtyllave bëhen njëri pas tjetrit */
    }

    .pillar {
        padding: 30px; /* Reduktohet padding brenda katrorëve */
    }
    
    .about-container {
        gap: 40px;
    }
}

@media (max-width: 480px) {
    .about-title {
        font-size: 2.2rem;
    }
    
    .about-eyebrow {
        font-size: 0.7rem;
    }
}
/* SPONSORS */
.sponsors-section { background: #0d0d0d; padding: 60px 80px; }
.sponsors-top { display: flex; align-items: center; gap: 20px; margin-bottom: 40px; }
.sponsors-label { color: #444; font-size: 11px; text-transform: uppercase; font-weight: 800; white-space: nowrap; }
.sponsors-line { width: 100%; height: 1px; background: #222; }
.sponsors-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 40px; }
.sponsor-item { text-decoration: none; text-align: center; opacity: 0.6; transition: 0.3s; }
.sponsor-item:hover { opacity: 1; transform: translateY(-5px); }
.sponsor-logo-box svg { height: 40px; width: auto; margin-bottom: 15px; }
.sponsor-info { color: #444; font-size: 10px; text-transform: uppercase; letter-spacing: 1px; display: block; }
  @media (max-width: 1024px) {
    .sponsors-section { 
        padding: 50px 40px; /* Reduktojmë padding në tablet */
    }
    .sponsors-grid { 
        gap: 30px; 
    }
}

@media (max-width: 768px) {
    .sponsors-grid { 
        grid-template-columns: repeat(2, 1fr); /* 2 kolona për telefonat e mëdhenj */
        gap: 25px;
    }
    .sponsors-section { 
        padding: 40px 20px; 
    }
    .sponsor-logo-box svg { 
        height: 35px; /* Logot pak më të vogla në mobile */
    }
}

@media (max-width: 480px) {
    .sponsors-grid { 
        grid-template-columns: 1fr; /* 1 kolonë për telefonat e vegjël */
        gap: 35px;
    }
    .sponsors-top {
        gap: 10px; /* Më pak hapësirë te vija lart */
    }
    .sponsors-label {
        font-size: 9px;
    }
}
/* programet */
.programs-section {
    background-color: #f8f7f2; /* Ngjyra krem si në foto */
    padding: 100px 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.programs-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.programs-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 20px;
}

.sub-label {
    color: #e63946;
    font-size: 14px;
    font-weight: 700;
    letter-spacing: 2px;
}

.main-title {
  font-family: 'Syne', sans-serif;
    font-size: 48px;
    font-weight: 900;
    color: #000;
    margin-top: 10px;
    
}

.view-all {
    text-decoration: none;
    color: #888;
    font-size: 14px;
    font-weight: 600;
    letter-spacing: 1px;
    transition: 0.3s;
}

.view-all:hover {
    color: #000;
}

/* GRID DHE KARTELAT */
.programs-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
}

.program-card {
    background: #fff;
    padding: 40px;
    border: 1px solid #eee;
    position: relative;
    transition: 0.3s ease;
    min-height: 20px;
}

.program-number {
    font-size: 60px;
    font-weight: 900;
    color: #f0f0f0; /* Ngjyra e zbehtë e numrit */
    display: block;
    margin-bottom: 20px;
}
.program-card {
    background: #fff;
    padding: 40px;
    border: 1px solid #eee;
    position: relative; /* E rëndësishme për pozicionimin e vijës */
    transition: 0.3s ease;
    min-height: 250px;
    cursor: pointer;
}

/* Krijimi i vijës së kuqe (e fshehur fillimisht) */
.program-card::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background-color: #e63946; /* Ngjyra e kuqe */
    transform: scaleX(0); /* Vija fillon me gjatësi zero */
    transition: transform 0.3s ease; /* Efekt animacioni */
}

/* Efekti kur kalon mausi */
.program-card:hover {
    transform: translateY(-10px); /* Ngritje e lehtë */
    box-shadow: 0 15px 30px rgba(0,0,0,0.08);
}

.program-card:hover::after {
    transform: scaleX(1); /* Vija hapet plotësisht */
}

/* Stilimi i numrave gjatë hover */
.program-card:hover .program-number {
    color: #ffe5e5;
}

/* Galeria */
.modern-gallery {
    padding: 100px 0;
    background: #fdfdfb;
    overflow: hidden; /* Ky siguron që scroll-i të mos dalë jashtë faqes */
}

.gallery-wrapper {
    display: flex;
    align-items: center;
    gap: 30px;
    padding-left: 80px;
}

.gallery-info {
    flex: 0 0 300px;
}

.eyebrow { 
  color: #e63946; 
  font-weight: 700; 
  letter-spacing: 2px; 
  text-transform: uppercase; 
  font-size: 13px; }
.title { 
  font-family: 'Syne', sans-serif;
  font-size: 30px; 
  font-weight: 800; 
  line-height: 1.1; 
  margin: 20px 0; 
  color: #1a1a1a; }

.btn-more {
    display: inline-block;
    padding: 12px 25px;
    border: 1px solid #ddd;
    text-decoration: none;
    color: #333;
    font-weight: 600;
    border-radius: 50px;
    transition: 0.3s;
}

.btn-more:hover { background: #e63946; 
color: #fff; 
border-color: #575555; }

/* SCROLL CONTAINER */
.scroll-container {
    overflow-x: auto;
    overflow-y: hidden;
    cursor: grab;
    padding: 40px 0;
    -webkit-overflow-scrolling: touch; /* Për lëvizje të butë në iPhone */
}

.scroll-container::-webkit-scrollbar {
    height: 6px;
}
.scroll-container::-webkit-scrollbar-thumb {
    background: #e2e2e2;
    border-radius: 10px;
}

.scroll-content {
    display: flex;
    gap: 10px;
    padding-right: 80px; /* Hapësira në fund të scroll-it */
}

/* CARDS */
.gallery-item-wrap {
    flex: 0 0 320px;
    transition: transform 0.4s ease;
}

.translate-down {
    transform: translateY(40px); /* I zbret fotot çift pak më poshtë */
}

.modern-card {
    position: relative;
    height: 300px;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(0,0,0,0.08);
}

.modern-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: 0.6s cubic-bezier(0.2, 1, 0.3, 1);
}

.modern-card:hover img {
    transform: scale(1.1);
}

/* Mobile responsive */
@media (max-width: 991px) {
    .gallery-wrapper { 
        /* Heqim column që të mbetet horizontal */
        flex-direction: row; 
        padding-left: 20px; 
        align-items: center;
        
        /* Mundësojmë scroll-in horizontal */
        overflow-x: auto; 
        overflow-y: hidden;
        
        /* Përmirësojmë ndjesinë e scroll-it në telefon */
        -webkit-overflow-scrolling: touch; 
        scroll-snap-type: x mandatory;
        
        /* Sigurohemi që wrapper-i të mos e kufizojë gjerësinë */
        width: 100%;
        display: flex;
    }

    .scroll-content { 
        display: flex;
        flex-direction: row;
        padding-right: 20px; 
        /* Mos i lejo elementet të mblidhen (shrink) */
        flex-wrap: nowrap; 
    }

    /* Fshehim scrollbar-in që duket shëmtuar (opsionale) */
    .gallery-wrapper::-webkit-scrollbar {
        display: none;
    }
}

/* bashkohu me ne */
.join-section { padding: 30px 80px; background: #fff; }
.join-top { text-align: center; margin-bottom: 30px; }
.cta-title { font-family: 'Syne', sans-serif; font-size: 45px; font-weight: 900; line-height: 1.1; }
.cta-title span { color: #e63946; }
.join-body { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; }

/* MAP */
.join-map { border-radius: 20px; overflow: hidden; height: 550px; position: relative; }
.join-map iframe { width: 100%; height: 100%; border: 0; }

/* FORM */
.join-form-wrap { background: #f8f7f2; padding: 40px; border-radius: 20px; }
.form-title { font-size: 24px; font-weight: 800; margin-bottom: 25px; }
.form-row { display: flex; gap: 15px; }
.form-field { margin-bottom: 20px; display: flex; flex-direction: column; }
.half { flex: 1; }
.form-label { font-size: 13px; font-weight: 700; margin-bottom: 8px; color: #555; }
.form-input { 
    padding: 12px 15px; 
    border: 1px solid #ddd; 
    border-radius: 8px; 
    font-size: 15px;
    transition: 0.3s;
}
.form-input:focus { border-color: #e63946; outline: none; box-shadow: 0 0 0 3px rgba(230, 57, 70, 0.1); }
.form-textarea { height: 100px; resize: none; }
.form-submit { 
    background: #e63946; 
    color: #fff; 
    padding: 15px; 
    border: none; 
    border-radius: 8px; 
    font-weight: 700; 
    cursor: pointer; 
    width: 100%; 
    transition: 0.3s;
}
.form-submit:hover { background: #1a1a1a; }

.form-success { text-align: center; padding: 40px 0; }
.form-success-icon { font-size: 50px; margin-bottom: 15px; }
/* --- JOIN SECTION RESPONSIVE --- */

@media (max-width: 1024px) {
    .join-section {
        padding: 40px 30px; /* Reduktojmë hapësirën anësore */
    }

    .join-body {
        grid-template-columns: 1fr; /* Kthehet në një kolonë të vetme */
        gap: 30px;
    }

    .join-map {
        height: 400px; /* Zvogëlojmë lartësinë e hartës në tablet */
    }
}

@media (max-width: 768px) {
    .join-section {
        padding: 30px 20px;
    }

    .cta-title {
        font-size: 32px; /* Titulli bëhet më i përshtatshëm për telefon */
    }

    .join-form-wrap {
        padding: 25px; /* Më pak padding brenda formës */
    }

    .form-row {
        flex-direction: column; /* Emri dhe Mbiemri dalin njëri nën tjetrin */
        gap: 0;
    }

    .join-map {
        height: 300px; /* Harta bëhet më kompakte në telefon */
    }
}

/* Nëse dëshiron që harta të dalë detyrimisht e para lart në mobile 
   pavarësisht radhës në HTML, shto këtë: */
@media (max-width: 1024px) {
    .join-body {
        display: flex;
        flex-direction: column;
    }
    
    .join-map {
        order: 1; /* Harta e para */
    }
    
    .join-form-wrap {
        order: 2; /* Forma e dyta */
    }
}
/* news letter */
.newsletter-wrap {
    position: relative;
    padding: 80px 20px;
    background: #fcf9f8; /* Ngjyrë e hapur që të dallohet nga pjesët tjera */
    overflow: hidden;
    display: flex;
    justify-content: center;
}

.news-bg-decoration {
    position: absolute;
    top: -50px;
    right: -50px;
    width: 200px;
    height: 200px;
    background: rgba(235, 37, 37, 0.05); /* Bluja e Liza-R shumë e zbehtë */
    border-radius: 50%;
}

.news-inner {
    position: relative;
    max-width: 1100px;
    width: 100%;
    background: #ffffff;
    padding: 50px;
    border-radius: 24px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.04);
    display: grid;
    grid-template-columns: 1fr 1fr;
    align-items: center;
    gap: 40px;
}

.news-icon {
    display: inline-flex;
    padding: 12px;
    background: #eff6ff;
    color: #eb2525;
    border-radius: 12px;
    margin-bottom: 20px;
}

.news-content h2 {
    font-size: 32px;
    color: #0b0808;
    margin-bottom: 15px;
    font-weight: 800;
    font-family: 'Syne', sans-serif;
}

.news-content p {
    color: #251f1f;
    font-size: 16px;
    line-height: 1.6;
}

.input-group {
    display: flex;
    background: #f1f5f9;
    padding: 8px;
    border-radius: 16px;
    transition: 0.3s;
    border: 2px solid transparent;
}

.input-group:focus-within {
    border-color: #eb2f25;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
}

.input-group input {
    flex: 1;
    border: none;
    background: transparent;
    padding: 12px 20px;
    outline: none;
    font-size: 15px;
    color: #3b1e1e;
}

.input-group button {
    background: #9d1e1e;
    color: #fff;
    border: none;
    padding: 12px 25px;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: 0.3s;
}

.input-group button:hover {
    background: #0e0a09;
    transform: translateY(-2px);
}

.news-status {
    margin-top: 15px;
    font-size: 14px;
    font-weight: 600;
    min-height: 20px;
}

@media (max-width: 900px) {
    .news-inner {
        grid-template-columns: 1fr;
        padding: 30px;
        text-align: center;
    }
    .news-icon { justify-content: center; }
    .input-group { flex-direction: column; background: transparent; padding: 0; gap: 10px; }
    .input-group input { background: #f1f5f9; border-radius: 12px; }
    .input-group button { justify-content: center; width: 100%; }
}

@media (max-width: 600px) {
    .news-form { flex-direction: column; }
}

@media (max-width: 1024px) {
    .news-grid { grid-template-columns: repeat(2, 1fr); }
  }
  @media (max-width: 768px) {
    .news-grid { grid-template-columns: 1fr; }
    .news-header h2 { font-size: 2rem; }
  }

  @media (max-width: 1024px) {
    .main-wrapper { padding: 100px 30px; }
    .hero-grid { grid-template-columns: 1fr; gap: 40px; }
    .hero-right { height: 500px; }
    .hero-left h1 { font-size: 2.8rem; }
    .slide-content { 
      max-width: 280px !important;
      width: 280px !important;
      bottom: 25px; 
      left: 25px; 
      padding: 20px 18px;
    }
    .post-title { font-size: 1.25rem; } /* ← 20px në tablet */
  }

  @media (max-width: 768px) {
    .hero-right { height: 420px; }
    .slide-content { 
      max-width: 260px !important;
      width: 260px !important;
      bottom: 20px; 
      left: 20px; 
      padding: 18px 16px;
    }
    .post-title { font-size: 1.125rem; } /* ← 18px në mobile */
    .btn-read { 
      font-size: 0.7rem; 
      padding: 6px 12px 6px 10px; 
      gap: 6px;
    }
    .btn-read .circle-icon { width: 24px; height: 24px; }
    .post-meta { font-size: 0.6rem; padding: 3px 8px; }
  }
</style>

<main class="main-wrapper">
  <div class="hero-grid">
    <!-- LEFT SIDE PA NDËRYSHIME -->
    <div class="hero-left">
      <div class="hero-tagline">OJQ KOSOVO — THEMELUAR 2006</div>
      <h1>Fuqizojmë <br><span>Rininë</span> e Kosovës</h1>
      <p>LIZA-R është organizatë joqeveritare që ndërton kapacitete, ofron trajtime dhe krijon mundësi për të rinjtë përmes programeve të zhvillimit.</p>
      
      <div class="hero-btns-container">
        <a href="kontakti.php" class="btn-shiko">Kontaktoni</a>
        <a href="rreth-nesh.php" class="btn-rreth">RRETH NESH <span>→</span></a>
      </div>

      <div class="hero-divider"></div>

      <div class="stats-container">
        <div class="stat-item"><h2>10</h2><p>VITE<br>EKSPERIENCË</p></div>
        <div class="stat-item"><h2>500</h2><p>TË RINJ TË<br>TRAJNUAR</p></div>
        <div class="stat-item"><h2>5</h2><p>PARTNERË<br>STRATEGJIKË</p></div>
      </div>
    </div>

    <!-- SLIDER MINI-CONTENT -->
    <div class="hero-right">
      <div class="slider-header">
        <h3>Lajmi i Fundit</h3>
      </div>

      <div class="swiper mySwiper" style="height: 100%;">
        <div class="swiper-wrapper">
          <?php
          if (isset($conn)) {
              $query = "SELECT id, titulli, foto, data_aktivitetit FROM posts ORDER BY data_aktivitetit DESC LIMIT 3";
              $result = mysqli_query($conn, $query);

              if ($result && mysqli_num_rows($result) > 0) {
                  while($row = mysqli_fetch_assoc($result)) {
                      $foto_path = !empty($row['foto']) ? 'uploads/' . $row['foto'] : 'assets/img/default.jpg';
                      $data_formatuar = ($row['data_aktivitetit']) ? date('F Y', strtotime($row['data_aktivitetit'])) : 'Pa datë';
                      ?>
                      <div class="swiper-slide post-slide" style="background-image: url('<?php echo $foto_path; ?>');">
                        <div class="slide-content">
                          <div class="post-meta"><?php echo $data_formatuar; ?></div>
                          <h2 class="post-title"><?php echo htmlspecialchars($row['titulli']); ?></h2>
                          <a href="lajmi-detaje.php?id=<?php echo $row['id']; ?>" class="btn-read">
                            <span>Lexo më shumë</span>
                            <div class="circle-icon">
                              <svg viewBox="0 0 24 24">
                                <path d="M5 12h14M12 5l7 7-7 7" />
                              </svg>
                            </div>
                          </a>
                        </div>
                      </div>
                      <?php
                  }
              } else {
                  ?>
                  <div class="swiper-slide post-slide" style="background-image: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="slide-content">
                      <div class="post-meta">Sot</div>
                      <h2 class="post-title">Nuk ka lajme të reja</h2>
                      <a href="aktivitetet.php" class="btn-read">
                        <span>Shiko Aktivitetet</span>
                        <div class="circle-icon">
                          <svg viewBox="0 0 24 24">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                          </svg>
                        </div>
                      </a>
                    </div>
                  </div>
                  <?php
              }
          }
          ?>
        </div>
        <div class="swiper-pagination"></div>
      </div>
    </div>
  </div>
</main>

    <!-- slider marquee -->
<div class="marquee-band">
  <div class="marquee-track">
    <span class="marquee-item">Trajnime Profesionale</span>
    <span class="marquee-item">Lidership &amp; Menaxhim</span>
    <span class="marquee-item">Bashkëpunim Ndërkombëtar</span>
    <span class="marquee-item">Fuqizimi i Rinisë</span>
    <span class="marquee-item">Sport &amp; Kulturë</span>
    <span class="marquee-item">Trashëgimi Kulturore</span>
    <span class="marquee-item">Sport &amp; Kulturë</span>
    <span class="marquee-item">Trajnime Profesionale</span>
    <span class="marquee-item">Lidership &amp; Menaxhim</span>
    <span class="marquee-item">Bashkëpunim Ndërkombëtar</span>
    <span class="marquee-item">Fuqizimi i Rinisë</span>
  </div>
</div>

 <section class="news-section">
  <div class="news-header">
    <div>
      <span style="color: var(--accent);
    font-weight: 700;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;">— Eksploro</span>
      <h2>Lajmet e Fundit</h2>
    </div>
    <a href="lajmet.php" style="text-decoration:none; color: var(--ink); font-weight:700; font-size:0.9rem; border-bottom: 2px solid var(--accent); padding-bottom: 5px;">
      SHIKO TË GJITHA
    </a>
  </div>

  <div class="news-grid">
    <?php
    if (isset($conn)) {
        // Shtojmë 'kategoria' në query dhe vendosim LIMIT 3
        $q_news = "SELECT id, titulli, foto, data_aktivitetit, data, pershkrimi, kategoria FROM posts ORDER BY COALESCE(data_aktivitetit, data) DESC LIMIT 3";
        $r_news = mysqli_query($conn, $q_news);

        if ($r_news && mysqli_num_rows($r_news) > 0) {
            while($n = mysqli_fetch_assoc($r_news)) {
                
                // --- RREGULLIMI I FOTOS (Sipas kategorisë) ---
                $kategorite_kurseve = ['rrobaqepesi', 'it-dizajn', 'serra-bujqesi', 'makina-qepjeje', 'bursa-ekselence'];
                $folder = (in_array($n['kategoria'], $kategorite_kurseve)) ? 'uploads/posts/' : 'uploads/';
                $n_foto = !empty($n['foto']) ? $folder . $n['foto'] : 'assets/img/default.jpg';
                
                // --- RREGULLIMI I DATËS ---
                $data_vlere = !empty($n['data_aktivitetit']) ? $n['data_aktivitetit'] : $n['data'];
                $n_data = date('d M, Y', strtotime($data_vlere));
                
                $kategoria_shfaqur = !empty($n['kategoria']) ? $n['kategoria'] : "Lajm";
                
                // Përgatitja e përshkrimit
                $shkurtesa = !empty($n['pershkrimi']) ? strip_tags($n['pershkrimi']) : "Klikoni për të lexuar më shumë...";
                if (mb_strlen($shkurtesa) > 100) $shkurtesa = mb_substr($shkurtesa, 0, 100) . "...";
                ?>
                <a href="lajmi-detaje.php?id=<?php echo $n['id']; ?>" class="news-card">
                  <div class="card-image-box">
                    <img src="<?php echo $n_foto; ?>" alt="<?php echo htmlspecialchars($n['titulli']); ?>">
                    <span class="card-badge"><?php echo htmlspecialchars($kategoria_shfaqur); ?></span>
                  </div>
                  <div class="card-content">
                    <div class="card-meta">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                      <?php echo $n_data; ?>
                    </div>
                    <h3><?php echo htmlspecialchars($n['titulli']); ?></h3>
                    <p class="card-excerpt"><?php echo $shkurtesa; ?></p>
                    <div class="btn-link">Lexo më shumë <span>→</span></div>
                  </div>
                </a>
                <?php
            }
        } else {
            echo "<p>Nuk u gjet asnjë lajm.</p>";
        }
    }
    ?>
  </div>
</section>


<div class="ticker-wrapper">
    <div class="ticker-content">
        <span>LIDERSHIP & MENAXHIM <i>+</i></span>
        <span>BASHKËPUNIM NDËRKOMBËTAR <i>+</i></span>
        <span>FUQIZIMI I RINISË <i>+</i></span>
        <span>SPORT & KULTURË <i>+</i></span>
        <span>TRASHËGIMI KULTURORE <i>+</i></span>
        <span>LIDERSHIP & MENAXHIM <i>+</i></span>
        <span>BASHKËPUNIM NDËRKOMBËTAR <i>+</i></span>
        <span>FUQIZIMI I RINISË <i>+</i></span>
    </div>
</div>
    <!-- rreth nesh -->
<section class="about-section">
    <div class="about-container">
        <div class="about-left">
            <div class="about-eyebrow">Rreth LIZA-R</div>
            <h2 class="about-title">Investojmë në<br><em>të ardhmen</em><br>e rinisë</h2>
            <p class="about-text">
                LIZA-R — Lidhja me Interes Zhvillimor për të Ardhmen e Rinisë — është një organizatë joqeveritare e themeluar në Gjilan, Kosovë. Misioni ynë është fuqizimi i të rinjve nëpërmjet edukimit, trajnimeve profesionale dhe bashkëpunimit ndërkombëtar.
            </p>
            <p class="about-text">
                Punojmë ngushtë me institucione vendore dhe ndërkombëtare si IOM, UNICEF, dhe Bashkimi Europian për të krijuar programe gjithëpërfshirëse dhe ndikuese.
            </p>
              <a href="rreth-nesh.php" class="about-link">
                  Mëso më shumë
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                      <path d="M5 12h14M12 5l7 7-7 7" />
                  </svg>
              </a>
        </div>
        
        <div class="about-right">
            <div class="pillar-grid">
                <div class="pillar">
                    <span class="pillar-icon">🎓</span>
                    <div class="pillar-name">Trajnime</div>
                    <p class="pillar-desc">Programe profesionale për lidership, menaxhim dhe sipërmarrje</p>
                </div>
                <div class="pillar">
                    <span class="pillar-icon">🌍</span>
                    <div class="pillar-name">Internacionale</div>
                    <p class="pillar-desc">Vizita studimore dhe shkëmbime në Europë dhe botë</p>
                </div>
                <div class="pillar">
                    <span class="pillar-icon">🌱</span>
                    <div class="pillar-name">Rinia</div>
                    <p class="pillar-desc">Fuqizimi i të rinjve nëpërmjet pjesëmarres aktive</p>
                </div>
                <div class="pillar">
                    <span class="pillar-icon">🏛️</span>
                    <div class="pillar-name">Kulturë</div>
                    <p class="pillar-desc">Ruajtja e trashëgimisë kulturore dhe promovimi artistik</p>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- partneret -->
<div class="sponsors-section">
    <div class="sponsors-top">
        <span class="sponsors-label">Mbështetur nga</span>
        <div class="sponsors-line"></div>
    </div>
    
    <div class="sponsors-grid">
        <?php
        // Marrja e të dhënave nga tabela sponsors
        $q = "SELECT * FROM sponsors ORDER BY renditja ASC";
        $res = mysqli_query($conn, $q);
        
        while($s = mysqli_fetch_assoc($res)): ?>
            <a href="<?= htmlspecialchars($s['linku']) ?>" target="_blank" class="sponsor-item">
                <div class="sponsor-logo-box">
                    <?php if(!empty($s['foto'])): ?>
                        <img src="uploads/<?= htmlspecialchars($s['foto']) ?>" 
                             alt="<?= htmlspecialchars($s['emri']) ?>" 
                             style="max-height: 55px; width: auto; filter: brightness(0) invert(1); opacity: 0.8;">
                    <?php else: ?>
                        <span style="color: #444;"><?= htmlspecialchars($s['emri']) ?></span>
                    <?php endif; ?>
                </div>
                <span class="sponsor-info"><?= htmlspecialchars($s['pershkrimi']) ?></span>
            </a>
        <?php endwhile; ?>
    </div>
</div>
    <!-- programet -->
<section class="programs-section">
    <div class="programs-container">
        
        <div class="programs-header">
            <div class="header-left">
                <span class="sub-label">— ÇFARË OFROJMË</span>
                <h2 class="main-title">Programet tona</h2>
                    </div>
        </div>

      <div class="programs-grid">
    <div class="program-card">
        <span class="program-number">01</span>
        <h3 class="program-title">Rrobaqepësi</h3>
        <p class="program-desc">Mëso artin e qepjes dhe dizajnit të rrobave me teknika moderne dhe tradicionale.</p>
    </div>

    <div class="program-card">
        <span class="program-number">02</span>
        <h3 class="program-title">Teknologji Informative</h3>
        <p class="program-desc">Zhvillo aftësi digjitale dhe teknologjike për tregun modern të punës.</p>
    </div>

    <div class="program-card">
        <span class="program-number">03</span>
        <h3 class="program-title">Dizajn Grafik</h3>
        <p class="program-desc">Mëso parimet e dizajnit vizual dhe mjeteve profesionale për krijim kreativ.</p>
    </div>

    <div class="program-card">
        <span class="program-number">04</span>
        <h3 class="program-title">Ndërmarrësi</h3>
        <p class="program-desc">Ndërto mentalitetin sipërmarrës dhe fillo biznesin tënd me baza të forta.</p>
    </div>
</div>

    </div>
</section>

  <!-- Galeria -->
<section class="modern-gallery">
    <div class="gallery-wrapper">
        <div class="gallery-info">
            <span class="eyebrow">— Galeria</span>
            <h2 class="title">Momente të<br>veçanta</h2>
            <a href="galeria.php" class="btn-more">Shiko të gjitha</a>
        </div>

        <div class="scroll-container" id="scrollContainer">
            <div class="scroll-content">
                <?php
                $res = $conn->query("SELECT image_path FROM galeria ORDER BY id DESC");
                $i = 0;
                while($row = $res->fetch_assoc()): 
                    $i++;
                    // Klasa 'offset' i jep efektin lart-poshtë çdo të dytës foto
                    $offset_class = ($i % 2 == 0) ? 'translate-down' : '';
                ?>
                    <div class="gallery-item-wrap <?= $offset_class ?>">
                        <div class="modern-card">
                            <img src="uploads/galeria/<?= htmlspecialchars($row['image_path']) ?>" alt="Moment">
                            <div class="card-overlay"></div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</section>

  <!-- Bashkohu me ne -->
<div class="join-section" id="regjistrohu">
    <div class="join-top">
        <h2 class="cta-title">Dëshironi të bashkoheni<br><span>me misionin tonë?</span></h2>
        <p class="join-subtitle">Na gjeni në Gjilan ose plotësoni formularin — dhe ne do t'ju kontaktojmë.</p>
    </div>

    <div class="join-body">
        <div class="join-map">
         <iframe src="https://www.google.com/maps/embed?pb=!1m13!1m8!1m3!1d5327.117613403724!2d21.472472!3d42.463306!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zNDLCsDI3JzQ3LjkiTiAyMcKwMjgnMjAuOSJF!5e1!3m2!1sen!2sus!4v1777058624262!5m2!1sen!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

        <div class="join-form-wrap">
            <form id="regForm" method="POST">
                <div class="form-title">Regjistrohu Tani</div>
                <div class="form-row">
                    <div class="form-field half">
                        <label class="form-label">Emri</label>
                        <input type="text" name="emri" class="form-input" placeholder="Emri juaj" required>
                    </div>
                    <div class="form-field half">
                        <label class="form-label">Mbiemri</label>
                        <input type="text" name="mbiemri" class="form-input" placeholder="Mbiemri juaj" required>
                    </div>
                </div>
                <div class="form-field">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-input" placeholder="email@shembull.com" required>
                </div>
                <div class="form-field">
                    <label class="form-label">Numri i Telefonit</label>
                    <input type="tel" name="telefoni" class="form-input" placeholder="+383 44 000 000" required>
                </div>
                <div class="form-field">
                    <label class="form-label">Programi i Interesit</label>
                    <select name="programi" class="form-select form-input" required>
                        <option value="" disabled selected>Zgjidhni programin…</option>
                        <option>Teknologji Informative</option>
                        <option>Dizajn Grafik</option>
                        <option>Rrobaqepësi</option>
                        <option>Ndërmarrësi</option>
                    </select>
                </div>
                <div class="form-field">
                    <label class="form-label">Mesazh (Opsional)</label>
                    <textarea name="mesazhi" class="form-textarea form-input" placeholder="Shkruani pyetjen tuaj..."></textarea>
                </div>
                <button type="submit" class="form-submit">Dërgo Kërkesën →</button>
            </form>

            <div id="formSuccess" style="display:none;" class="form-success">
                <div class="form-success-icon">✅</div>
                <div class="form-success-title">Faleminderit!</div>
                <p>Kërkesa juaj u dërgua me sukses.</p>
            </div>
        </div>
    </div>
</div>
  <!-- newsletter -->
<section class="newsletter-wrap">
    <div class="news-bg-decoration"></div>
    <div class="news-inner">
        <div class="news-content">
            <div class="news-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
            </div>
            <h2>Qëndroni të informuar</h2>
            <p>Regjistrohuni për të marrë njoftimet e fundit rreth kurseve dhe aktiviteteve tona në Gjilan.</p>
        </div>
        
        <div class="news-action">
            <form id="newsForm" class="modern-form">
                <div class="input-group">
                    <input type="email" name="email" placeholder="Adresa juaj email..." required>
                    <button type="submit" id="newsBtn">
                        <span>Regjistrohu</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </button>
                </div>
                <div id="newsMsg" class="news-status"></div>
            </form>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
  var swiper = new Swiper(".mySwiper", {
    effect: "fade",
    fadeEffect: { crossFade: true },
    loop: true,
    speed: 1000,
    autoplay: { 
      delay: 5000, 
      disableOnInteraction: false,
      pauseOnMouseEnter: true
    },
    pagination: { 
      el: ".swiper-pagination", 
      clickable: true
    },
  });
//slider

  const slider = document.querySelector('.scroll-container');
let isDown = false;
let startX;
let scrollLeft;

slider.addEventListener('mousedown', (e) => {
    isDown = true;
    slider.classList.add('active');
    startX = e.pageX - slider.offsetLeft;
    scrollLeft = slider.scrollLeft;
});
slider.addEventListener('mouseleave', () => {
    isDown = false;
});
slider.addEventListener('mouseup', () => {
    isDown = false;
});
slider.addEventListener('mousemove', (e) => {
    if(!isDown) return;
    e.preventDefault();
    const x = e.pageX - slider.offsetLeft;
    const walk = (x - startX) * 2; // Shpejtësia e lëvizjes
    slider.scrollLeft = scrollLeft - walk;
});
 // regjistrimi
document.getElementById('regForm').onsubmit = function(e) {
    e.preventDefault(); // Ndalon rifreskimin e faqes

    let formData = new FormData(this);

    fetch('admin/process_join.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if (data.trim() === "success") {
            // Fsheh formularin dhe shfaq mesazhin e suksesit
            document.getElementById('regForm').style.display = 'none';
            document.getElementById('formSuccess').style.display = 'block';
        } else {
            // Shfaq gabimin specifik në console që ta gjejmë ku çalon
            console.error("Gabim nga PHP:", data);
            alert("Ndodhi një gabim: " + data);
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("Lidhja dështoi!");
    });
};
//newsletter
document.getElementById('newsForm').onsubmit = function(e) {
    e.preventDefault();
    let msgDiv = document.getElementById('newsMsg');
    let formData = new FormData(this);

    fetch('admin/process_newsletter.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        msgDiv.style.display = "block";
        if(data.trim() === "success") {
            msgDiv.innerHTML = "<span class='msg-success'>✅ Faleminderit! U regjistruat me sukses.</span>";
            this.reset();
        } else if(data.trim() === "exists") {
            msgDiv.innerHTML = "<span class='msg-error'>ℹ️ Ky email është i regjistruar paraprakisht.</span>";
        } else {
            msgDiv.innerHTML = "<span class='msg-error'>⚠️ Ka ndodhur një gabim. Provoni përsëri.</span>";
        }
    });
};

</script>

<?php include 'includes/footer.php'; ?>