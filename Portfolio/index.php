<?php
// Include the database connection
include('database.php');

$stmt = $pdo->prepare('SELECT * FROM info LIMIT 1');
$stmt->execute();
$info = $stmt->fetch();

$stmt2 = $pdo->prepare('SELECT * FROM about LIMIT 1');
$stmt2->execute();
$about = $stmt2->fetch();

$stmt3 = $pdo->prepare('SELECT * FROM portinfo ORDER BY id DESC');
$stmt3->execute();
$projects = $stmt3->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($info['name'] ?? 'Sydney Jimenez') ?>Portfolio</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    /* ─── TOKENS ─────────────────────────────────────────── */
    :root {
      --bg:        #0a0a0a;
      --surface:   #111111;
      --surface2:  #181818;
      --border:    rgba(255,255,255,0.07);
      --amber:     #e8a020;
      --amber-dim: rgba(232,160,32,0.12);
      --amber-glow:rgba(232,160,32,0.25);
      --text:      #e8e8e8;
      --muted:     #888;
      --radius:    14px;
      --nav-h:     72px;
    }

    /* ─── RESET & BASE ───────────────────────────────────── */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; font-size: 16px; }

    body {
      background: var(--bg);
      color: var(--text);
      font-family: 'DM Sans', sans-serif;
      line-height: 1.7;
      overflow-x: hidden;
    }

    /* ─── NOISE TEXTURE OVERLAY ──────────────────────────── */
    body::before {
      content: '';
      position: fixed; inset: 0;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");
      pointer-events: none;
      z-index: 9999;
      opacity: 0.4;
    }

    h1, h2, h3, h4, h5 { font-family: 'Plus Jakarta Sans', sans-serif; line-height: 1.2; }
    a { color: inherit; text-decoration: none; }
    img { display: block; max-width: 100%; }

    /* ─── SCROLLBAR ──────────────────────────────────────── */
    ::-webkit-scrollbar { width: 4px; }
    ::-webkit-scrollbar-track { background: var(--bg); }
    ::-webkit-scrollbar-thumb { background: var(--amber); border-radius: 2px; }

    /* ─── NAV ─────────────────────────────────────────────── */
    .nav {
      position: fixed; top: 0; left: 0; right: 0;
      height: var(--nav-h);
      display: flex; align-items: center; justify-content: space-between;
      padding: 0 5vw;
      z-index: 1000;
      transition: background 0.4s, backdrop-filter 0.4s, border-bottom 0.4s;
    }
    .nav.scrolled {
      background: rgba(10,10,10,0.85);
      backdrop-filter: blur(18px);
      border-bottom: 1px solid var(--border);
    }
    .nav-logo {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 800;
      font-size: 1.3rem;
      letter-spacing: 0;
    }
    .nav-logo span { color: var(--amber); }
    .nav-links { display: flex; gap: 2.5rem; align-items: center; }
    .nav-links a {
      font-size: 0.82rem;
      font-weight: 600;
      letter-spacing: 0.06em;
      text-transform: uppercase;
      color: var(--muted);
      transition: color 0.2s;
      position: relative;
    }
    .nav-links a::after {
      content: '';
      position: absolute; bottom: -4px; left: 0;
      width: 0; height: 1px;
      background: var(--amber);
      transition: width 0.3s;
    }
    .nav-links a:hover { color: var(--text); }
    .nav-links a:hover::after { width: 100%; }
    .nav-cta {
      background: var(--amber);
      color: #000 !important;
      padding: 0.45rem 1.1rem;
      border-radius: 6px;
      font-weight: 700 !important;
      font-size: 0.8rem !important;
      letter-spacing: 0.04em !important;
      transition: opacity 0.2s, transform 0.2s !important;
    }
    .nav-cta:hover { opacity: 0.85; transform: translateY(-1px); }
    .nav-cta::after { display: none !important; }

    .hamburger {
      display: none;
      flex-direction: column; gap: 5px; cursor: pointer;
      background: none; border: none; padding: 4px;
    }
    .hamburger span { display: block; width: 24px; height: 2px; background: var(--text); transition: all 0.3s; border-radius: 2px; }

    @media(max-width: 768px) {
      .nav-links { display: none; }
      .hamburger { display: flex; }
      .nav-links.open {
        display: flex; flex-direction: column;
        position: fixed; top: var(--nav-h); left: 0; right: 0;
        background: rgba(10,10,10,0.97);
        backdrop-filter: blur(18px);
        padding: 2rem 5vw;
        border-bottom: 1px solid var(--border);
        gap: 1.5rem; align-items: flex-start;
      }
      .nav-links.open a { font-size: 1rem; }
    }

    /* ─── HERO ─────────────────────────────────────────────── */
    .hero {
      min-height: 100vh;
      display: grid;
      grid-template-columns: 1fr 1fr;
      align-items: center;
      padding: 0 5vw;
      padding-top: var(--nav-h);
      gap: 4rem;
      position: relative;
      overflow: hidden;
    }

    /* Ambient glow blobs */
    .hero::before {
      content: '';
      position: absolute;
      top: -20%; right: -10%;
      width: 600px; height: 600px;
      background: radial-gradient(circle, rgba(232,160,32,0.08) 0%, transparent 70%);
      pointer-events: none;
    }
    .hero::after {
      content: '';
      position: absolute;
      bottom: -10%; left: 5%;
      width: 400px; height: 400px;
      background: radial-gradient(circle, rgba(232,160,32,0.05) 0%, transparent 70%);
      pointer-events: none;
    }

    .hero-text { position: relative; z-index: 1; }
    .hero-badge {
      display: inline-flex; align-items: center; gap: 0.5rem;
      background: var(--amber-dim);
      border: 1px solid var(--amber-glow);
      color: var(--amber);
      font-size: 0.75rem;
      font-weight: 600;
      letter-spacing: 0.06em;
      text-transform: uppercase;
      padding: 0.35rem 0.9rem;
      border-radius: 100px;
      margin-bottom: 1.5rem;
      animation: fadeUp 0.6s ease both;
    }
    .hero-badge::before {
      content: '';
      width: 6px; height: 6px;
      background: var(--amber);
      border-radius: 50%;
      animation: pulse 2s infinite;
    }
    @keyframes pulse {
      0%,100% { opacity: 1; transform: scale(1); }
      50% { opacity: 0.4; transform: scale(0.7); }
    }

    .hero-name {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: clamp(2.6rem, 5vw, 4rem);
      font-weight: 800;
      letter-spacing: -0.5px;
      line-height: 1.15;
      margin-bottom: 0.6rem;
      animation: fadeUp 0.6s 0.1s ease both;
    }
    .hero-name em {
      font-style: normal;
      color: var(--amber);
      position: relative;
    }

    .hero-title {
      font-size: clamp(1rem, 1.8vw, 1.25rem);
      color: var(--muted);
      font-weight: 400;
      margin-bottom: 1.5rem;
      animation: fadeUp 0.6s 0.2s ease both;
      letter-spacing: 0;
    }
    .hero-title strong { color: var(--text); font-weight: 500; }

    .hero-desc {
      max-width: 480px;
      color: var(--muted);
      font-size: 1rem;
      margin-bottom: 2.5rem;
      animation: fadeUp 0.6s 0.3s ease both;
      line-height: 1.8;
    }

    .hero-actions {
      display: flex; gap: 1rem; flex-wrap: wrap;
      animation: fadeUp 0.6s 0.4s ease both;
    }

    .btn-primary-cta {
      background: var(--amber);
      color: #000;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 700;
      font-size: 0.9rem;
      padding: 0.85rem 2rem;
      border-radius: 8px;
      letter-spacing: 0.03em;
      transition: opacity 0.2s, transform 0.2s;
      display: inline-flex; align-items: center; gap: 0.5rem;
    }
    .btn-primary-cta:hover { opacity: 0.85; transform: translateY(-2px); }

    .btn-outline-cta {
      border: 1px solid var(--border);
      color: var(--text);
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 600;
      font-size: 0.9rem;
      padding: 0.85rem 2rem;
      border-radius: 8px;
      transition: border-color 0.2s, background 0.2s;
      display: inline-flex; align-items: center; gap: 0.5rem;
    }
    .btn-outline-cta:hover { border-color: var(--amber); background: var(--amber-dim); }

    .hero-stats {
      display: flex; gap: 2.5rem; margin-top: 3rem;
      padding-top: 2rem;
      border-top: 1px solid var(--border);
      animation: fadeUp 0.6s 0.5s ease both;
    }
    .stat-num {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 2rem;
      font-weight: 800;
      color: var(--amber);
      line-height: 1;
    }
    .stat-label {
      font-size: 0.75rem;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      color: var(--muted);
      margin-top: 0.25rem;
    }

    /* Hero image side */
    .hero-visual {
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
      animation: fadeUp 0.8s 0.2s ease both;
    }
    .hero-img-wrap {
      position: relative;
      width: 380px;
      height: 480px;
    }
    .hero-img-bg {
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, var(--amber-dim), transparent);
      border-radius: 24px;
      border: 1px solid var(--amber-glow);
    }
    .hero-img {
      position: absolute;
      bottom: 0; left: 50%;
      transform: translateX(-50%);
      width: 340px;
      height: 460px;
      object-fit: cover;
      object-position: top;
      border-radius: 20px;
    }
    /* Floating skill chips */
    .floating-chip {
      position: absolute;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 100px;
      padding: 0.5rem 1rem;
      font-size: 0.75rem;
      font-weight: 600;
      display: flex; align-items: center; gap: 0.4rem;
      white-space: nowrap;
      backdrop-filter: blur(10px);
    }
    .chip-1 { top: 8%; right: -14%; animation: float 4s ease-in-out infinite; }
    .chip-2 { top: 40%; left: -18%; animation: float 4s 1s ease-in-out infinite; }
    .chip-3 { bottom: 15%; right: -12%; animation: float 4s 2s ease-in-out infinite; }
    @keyframes float {
      0%,100% { transform: translateY(0); }
      50% { transform: translateY(-8px); }
    }
    .chip-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--amber); }

    @media(max-width: 900px) {
      .hero { grid-template-columns: 1fr; padding-top: calc(var(--nav-h) + 2rem); text-align: center; }
      .hero-desc { margin: 0 auto 2.5rem; }
      .hero-actions { justify-content: center; }
      .hero-stats { justify-content: center; }
      .hero-visual { display: none; }
    }

    /* ─── SECTION COMMONS ─────────────────────────────────── */
    .section {
      padding: 120px 5vw;
      position: relative;
    }
    .section-tag {
      display: inline-block;
      font-size: 0.72rem;
      font-weight: 700;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: var(--amber);
      margin-bottom: 0.8rem;
    }
    .section-title {
      font-size: clamp(1.9rem, 3.5vw, 2.8rem);
      font-weight: 800;
      letter-spacing: -0.3px;
      margin-bottom: 1rem;
    }
    .section-sub {
      color: var(--muted);
      max-width: 560px;
      line-height: 1.8;
    }
    .divider {
      width: 48px; height: 3px;
      background: var(--amber);
      border-radius: 2px;
      margin: 1.2rem 0 2.5rem;
    }

    /* Scroll reveal */
    .reveal {
      opacity: 0;
      transform: translateY(32px);
      transition: opacity 0.7s ease, transform 0.7s ease;
    }
    .reveal.visible { opacity: 1; transform: translateY(0); }
    .reveal-delay-1 { transition-delay: 0.1s; }
    .reveal-delay-2 { transition-delay: 0.2s; }
    .reveal-delay-3 { transition-delay: 0.3s; }
    .reveal-delay-4 { transition-delay: 0.4s; }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* ─── ABOUT ─────────────────────────────────────────────── */
    #about { background: var(--surface); }
    .about-grid {
      display: grid;
      grid-template-columns: 1fr 1.4fr;
      gap: 5rem;
      align-items: start;
      margin-top: 3rem;
    }
    @media(max-width: 900px) { .about-grid { grid-template-columns: 1fr; gap: 3rem; } }

    .about-info-block {
      background: var(--surface2);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      padding: 1.5rem;
      margin-bottom: 1rem;
      display: flex;
      gap: 1rem;
      align-items: flex-start;
      transition: border-color 0.3s;
    }
    .about-info-block:hover { border-color: var(--amber-glow); }
    .about-icon {
      width: 40px; height: 40px;
      background: var(--amber-dim);
      color: var(--amber);
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.1rem;
      flex-shrink: 0;
    }
    .about-info-label { font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--muted); margin-bottom: 0.2rem; }
    .about-info-value { font-size: 0.95rem; font-weight: 500; }

    .about-text { color: var(--muted); line-height: 1.9; margin-bottom: 1.5rem; }

    .interest-tags { display: flex; flex-wrap: wrap; gap: 0.6rem; margin-top: 1rem; }
    .interest-tag {
      background: var(--surface2);
      border: 1px solid var(--border);
      color: var(--muted);
      font-size: 0.8rem;
      padding: 0.35rem 0.9rem;
      border-radius: 100px;
    }

    /* ─── SKILLS ─────────────────────────────────────────────── */
    #skills { background: var(--bg); }
    .skills-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
      gap: 1rem;
      margin-top: 3rem;
    }
    .skill-card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      padding: 1.5rem;
      transition: border-color 0.3s, transform 0.3s;
    }
    .skill-card:hover { border-color: var(--amber-glow); transform: translateY(-4px); }
    .skill-header { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem; }
    .skill-icon-box {
      width: 42px; height: 42px;
      background: var(--amber-dim);
      color: var(--amber);
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.2rem;
    }
    .skill-name { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 1rem; }
    .skill-level-label {
      display: flex; justify-content: space-between;
      font-size: 0.75rem;
      color: var(--muted);
      margin-bottom: 0.5rem;
    }
    .skill-bar { height: 4px; background: var(--surface2); border-radius: 2px; overflow: hidden; }
    .skill-fill {
      height: 100%;
      background: linear-gradient(90deg, var(--amber), rgba(232,160,32,0.5));
      border-radius: 2px;
      width: 0;
      transition: width 1.2s ease 0.3s;
    }

    /* ─── EDUCATION ──────────────────────────────────────────── */
    #education { background: var(--surface); }
    .edu-timeline { margin-top: 3rem; position: relative; }
    .edu-timeline::before {
      content: '';
      position: absolute;
      left: 20px; top: 8px; bottom: 0;
      width: 1px;
      background: var(--border);
    }
    .edu-item {
      display: flex;
      gap: 2rem;
      margin-bottom: 2.5rem;
      padding-left: 1rem;
      position: relative;
    }
    .edu-dot {
      width: 40px; height: 40px;
      background: var(--amber-dim);
      border: 2px solid var(--amber);
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      color: var(--amber);
      font-size: 0.9rem;
      flex-shrink: 0;
      position: relative; z-index: 1;
    }
    .edu-content {
      background: var(--surface2);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      padding: 1.5rem;
      flex: 1;
      transition: border-color 0.3s;
    }
    .edu-content:hover { border-color: var(--amber-glow); }
    .edu-period {
      font-size: 0.72rem;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      color: var(--amber);
      margin-bottom: 0.4rem;
    }
    .edu-school { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 1.1rem; margin-bottom: 0.3rem; }
    .edu-degree { color: var(--muted); font-size: 0.9rem; }
    .edu-badge {
      display: inline-block;
      margin-top: 0.75rem;
      background: var(--amber-dim);
      color: var(--amber);
      font-size: 0.72rem;
      font-weight: 700;
      padding: 0.25rem 0.75rem;
      border-radius: 100px;
      letter-spacing: 0.06em;
    }

    /* ─── PROJECTS ───────────────────────────────────────────── */
    #work { background: var(--bg); }
    .projects-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
      gap: 1.5rem;
      margin-top: 3rem;
    }
    .project-card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      overflow: hidden;
      transition: border-color 0.3s, transform 0.3s;
      display: flex; flex-direction: column;
    }
    .project-card:hover { border-color: var(--amber-glow); transform: translateY(-6px); }
    .project-img {
      height: 200px;
      overflow: hidden;
      background: var(--surface2);
      position: relative;
    }
    .project-img img {
      width: 100%; height: 100%;
      object-fit: cover;
      transition: transform 0.5s, opacity 0.3s;
    }
    .project-card:hover .project-img img { transform: scale(1.06); opacity: 0.85; }
    .project-img-overlay {
      position: absolute; inset: 0;
      background: linear-gradient(to bottom, transparent 40%, rgba(0,0,0,0.7));
    }
    .project-body { padding: 1.5rem; flex: 1; display: flex; flex-direction: column; }
    .project-tag {
      display: inline-block;
      font-size: 0.7rem;
      font-weight: 700;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: var(--amber);
      margin-bottom: 0.6rem;
    }
    .project-title { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 1.1rem; margin-bottom: 0.6rem; }
    .project-desc { color: var(--muted); font-size: 0.88rem; line-height: 1.7; flex: 1; }
    .project-link {
      display: inline-flex; align-items: center; gap: 0.4rem;
      color: var(--amber);
      font-size: 0.82rem;
      font-weight: 600;
      margin-top: 1.2rem;
      transition: gap 0.2s;
    }
    .project-link:hover { gap: 0.7rem; }

    /* ─── CERTIFICATIONS ──────────────────────────────────────── */
    #certificates { background: var(--surface); }
    .certs-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 1.25rem;
      margin-top: 3rem;
    }
    .cert-card {
      background: var(--surface2);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      padding: 1.5rem;
      display: flex; flex-direction: column;
      gap: 1rem;
      transition: border-color 0.3s, transform 0.3s;
    }
    .cert-card:hover { border-color: var(--amber-glow); transform: translateY(-4px); }
    .cert-img {
      height: 150px;
      border-radius: 8px;
      overflow: hidden;
      background: var(--surface);
    }
    .cert-img img { width: 100%; height: 100%; object-fit: cover; }
    .cert-issuer {
      font-size: 0.72rem;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      color: var(--amber);
    }
    .cert-name { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 0.95rem; line-height: 1.4; }
    .cert-link {
      display: inline-flex; align-items: center; gap: 0.4rem;
      font-size: 0.8rem;
      font-weight: 600;
      color: var(--amber);
      margin-top: auto;
      transition: gap 0.2s;
    }
    .cert-link:hover { gap: 0.7rem; }

    /* ─── CONTACT ─────────────────────────────────────────────── */
    #contact { background: var(--bg); }
    .contact-grid {
      display: grid;
      grid-template-columns: 1fr 1.5fr;
      gap: 4rem;
      margin-top: 3rem;
      align-items: start;
    }
    @media(max-width: 900px) { .contact-grid { grid-template-columns: 1fr; gap: 2.5rem; } }

    .contact-channel {
      display: flex; align-items: center; gap: 1rem;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      padding: 1.2rem 1.5rem;
      margin-bottom: 1rem;
      text-decoration: none;
      color: var(--text);
      transition: border-color 0.3s, transform 0.2s;
    }
    .contact-channel:hover { border-color: var(--amber-glow); transform: translateX(4px); }
    .contact-ch-icon {
      width: 44px; height: 44px;
      background: var(--amber-dim);
      color: var(--amber);
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.1rem;
      flex-shrink: 0;
    }
    .contact-ch-label { font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--muted); }
    .contact-ch-value { font-weight: 500; font-size: 0.95rem; }

    /* Contact form */
    .contact-form {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      padding: 2rem;
    }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    @media(max-width: 600px) { .form-row { grid-template-columns: 1fr; } }
    .form-group { margin-bottom: 1.25rem; }
    .form-label {
      display: block;
      font-size: 0.75rem;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      color: var(--muted);
      margin-bottom: 0.5rem;
    }
    .form-input, .form-textarea {
      width: 100%;
      background: var(--surface2);
      border: 1px solid var(--border);
      border-radius: 8px;
      padding: 0.85rem 1rem;
      color: var(--text);
      font-family: 'DM Sans', sans-serif;
      font-size: 0.95rem;
      transition: border-color 0.2s;
    }
    .form-input:focus, .form-textarea:focus {
      outline: none;
      border-color: var(--amber);
    }
    .form-textarea { resize: vertical; min-height: 130px; }
    .form-submit {
      width: 100%;
      background: var(--amber);
      color: #000;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 700;
      font-size: 0.95rem;
      padding: 1rem;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: opacity 0.2s, transform 0.2s;
      letter-spacing: 0.03em;
    }
    .form-submit:hover { opacity: 0.85; transform: translateY(-2px); }

    /* ─── FOOTER ─────────────────────────────────────────────── */
    footer {
      background: var(--surface);
      border-top: 1px solid var(--border);
      padding: 2.5rem 5vw;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 1rem;
    }
    .footer-logo { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; font-size: 1.1rem; }
    .footer-logo span { color: var(--amber); }
    .footer-copy { color: var(--muted); font-size: 0.82rem; }
    .footer-socials { display: flex; gap: 1rem; }
    .footer-social {
      width: 36px; height: 36px;
      border: 1px solid var(--border);
      border-radius: 8px;
      display: flex; align-items: center; justify-content: center;
      color: var(--muted);
      font-size: 0.9rem;
      transition: color 0.2s, border-color 0.2s;
    }
    .footer-social:hover { color: var(--amber); border-color: var(--amber-glow); }

    /* ─── LIGHTBOX ───────────────────────────────────────────── */
    .cert-img {
      cursor: pointer;
      position: relative;
      overflow: hidden;
      border-radius: 8px;
    }
    .cert-img-overlay-btn {
      position: absolute;
      inset: 0;
      background: rgba(0,0,0,0);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      opacity: 0;
      transition: background 0.3s ease, opacity 0.3s ease;
      border-radius: 8px;
    }
    .cert-img-overlay-btn .lb-icon {
      width: 52px; height: 52px;
      background: var(--amber);
      color: #000;
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.3rem;
      transform: scale(0.7);
      transition: transform 0.3s cubic-bezier(0.34,1.56,0.64,1);
    }
    .cert-img-overlay-btn span {
      color: #fff;
      font-size: 0.75rem;
      font-weight: 700;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      font-family: 'Plus Jakarta Sans', sans-serif;
      transform: translateY(6px);
      transition: transform 0.3s ease;
    }
    .cert-img:hover .cert-img-overlay-btn {
      background: rgba(0,0,0,0.6);
      opacity: 1;
    }
    .cert-img:hover .cert-img-overlay-btn .lb-icon {
      transform: scale(1);
    }
    .cert-img:hover .cert-img-overlay-btn span {
      transform: translateY(0);
    }
    .cert-img img {
      width: 100%; height: 100%;
      object-fit: cover;
      transition: transform 0.5s ease;
      display: block;
    }
    .cert-img:hover img {
      transform: scale(1.04);
    }

    /* ─── LIGHTBOX FULLSCREEN ────────────────────────────────── */
    .lightbox {
      position: fixed;
      inset: 0;
      z-index: 99999;
      background: rgba(0, 0, 0, 0);
      backdrop-filter: blur(0px);
      -webkit-backdrop-filter: blur(0px);
      transition: background 0.3s ease, backdrop-filter 0.3s ease;
      pointer-events: none;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .lightbox.open {
      background: rgba(0, 0, 0, 0.94);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      pointer-events: all;
    }
    .lightbox-inner {
      position: relative;
      width: 92vw;
      max-width: 1100px;
      max-height: 92vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      opacity: 0;
      transform: scale(0.88) translateY(24px);
      transition: opacity 0.35s ease, transform 0.4s cubic-bezier(0.34, 1.4, 0.64, 1);
    }
    .lightbox.open .lightbox-inner {
      opacity: 1;
      transform: scale(1) translateY(0);
    }
    /* Image wrapper fills available space */
    .lightbox-img-wrap {
      width: 100%;
      max-height: 80vh;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 12px;
      overflow: hidden;
      background: rgba(255,255,255,0.03);
      border: 1px solid rgba(255,255,255,0.08);
    }
    #lbImg {
      display: block;
      max-width: 100%;
      max-height: 78vh;
      width: auto;
      height: auto;
      object-fit: contain;
      border-radius: 10px;
      user-select: none;
      -webkit-user-drag: none;
    }
    /* No-image fallback inside lightbox */
    .lightbox-no-img {
      display: none;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 1rem;
      padding: 4rem 2rem;
      color: var(--muted);
      font-size: 1rem;
      text-align: center;
    }
    .lightbox-no-img i {
      font-size: 3rem;
      color: var(--amber);
      opacity: 0.5;
    }
    /* Caption */
    .lightbox-caption {
      margin-top: 1rem;
      text-align: center;
      color: rgba(255,255,255,0.7);
      font-size: 0.88rem;
      font-family: 'Plus Jakarta Sans', sans-serif;
      line-height: 1.5;
      max-width: 700px;
      padding: 0 1rem;
    }
    .lightbox-caption strong {
      color: #fff;
      font-size: 0.95rem;
      font-weight: 700;
      display: block;
      margin-bottom: 0.2rem;
    }
    .lightbox-caption em {
      color: var(--amber);
      font-style: normal;
      font-size: 0.8rem;
    }
    /* Counter */
    .lightbox-counter {
      margin-top: 0.5rem;
      font-size: 0.75rem;
      color: rgba(255,255,255,0.3);
      font-family: 'Plus Jakarta Sans', sans-serif;
      letter-spacing: 0.1em;
    }
    /* Close button */
    .lightbox-close {
      position: fixed;
      top: 1.25rem;
      right: 1.25rem;
      width: 44px;
      height: 44px;
      background: rgba(255,255,255,0.08);
      border: 1px solid rgba(255,255,255,0.15);
      border-radius: 50%;
      color: #fff;
      font-size: 1.1rem;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: background 0.2s, transform 0.25s, border-color 0.2s;
      z-index: 100000;
    }
    .lightbox-close:hover {
      background: var(--amber);
      border-color: var(--amber);
      color: #000;
      transform: rotate(90deg) scale(1.1);
    }
    /* Nav arrows */
    .lightbox-nav {
      position: fixed;
      top: 50%;
      transform: translateY(-50%);
      width: 48px;
      height: 48px;
      background: rgba(255,255,255,0.08);
      border: 1px solid rgba(255,255,255,0.15);
      border-radius: 50%;
      color: #fff;
      font-size: 1.1rem;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: background 0.2s, transform 0.25s, border-color 0.2s;
      z-index: 100000;
    }
    .lightbox-prev { left: 1.25rem; }
    .lightbox-next { right: 1.25rem; }
    .lightbox-prev:hover {
      background: var(--amber);
      border-color: var(--amber);
      color: #000;
      transform: translateY(-50%) translateX(-3px);
    }
    .lightbox-next:hover {
      background: var(--amber);
      border-color: var(--amber);
      color: #000;
      transform: translateY(-50%) translateX(3px);
    }
    /* Hide nav if only 1 image */
    .lightbox-nav.hidden { display: none; }
    @media (max-width: 600px) {
      .lightbox-nav { width: 38px; height: 38px; font-size: 0.9rem; }
      .lightbox-prev { left: 0.5rem; }
      .lightbox-next { right: 0.5rem; }
      .lightbox-close { top: 0.75rem; right: 0.75rem; }
      #lbImg { max-height: 70vh; }
    }

    /* ─── CERT CARD VIEW BUTTON ──────────────────────────────── */
    .cert-view-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      width: 100%;
      padding: 0.75rem 1rem;
      margin-top: auto;
      background: var(--amber-dim);
      border: 1px solid var(--amber-glow);
      color: var(--amber);
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 700;
      font-size: 0.82rem;
      letter-spacing: 0.05em;
      border-radius: 8px;
      cursor: pointer;
      transition: background 0.25s ease, color 0.25s ease, transform 0.2s ease, box-shadow 0.25s ease;
    }
    .cert-view-btn:hover {
      background: var(--amber);
      color: #000;
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(232,160,32,0.3);
    }
    .cert-view-btn i {
      font-size: 0.9rem;
      transition: transform 0.2s ease;
    }
    .cert-view-btn:hover i {
      transform: scale(1.2);
    }
    .cert-no-img-box {
      height: 150px;
      border-radius: 8px;
      background: var(--amber-dim);
      border: 1px solid var(--amber-glow);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      color: var(--amber);
      font-size: 0.72rem;
      font-weight: 700;
      letter-spacing: 0.08em;
      text-transform: uppercase;
    }
    .cert-no-img-box i { font-size: 2.5rem; }
    
  </style>
</head>
<body>

<!-- ─── NAV ──────────────────────────────────────────────── -->
<nav class="nav" id="mainNav">
  <a class="nav-logo" href="#home">
    <?php $initials = strtoupper(substr($info['name'] ?? 'SJ', 0, 2)); echo $initials[0]; ?><span><?= isset($initials[1]) ? $initials[1] : '.' ?></span>
  </a>
  <div class="nav-links" id="navLinks">
    <a href="#about">About</a>
    <a href="#skills">Skills</a>
    <a href="#education">Education</a>
    <a href="#work">Projects</a>
    <a href="#certificates">Certifications</a>
    <a href="#contact" class="nav-cta">Contact Me</a>
  </div>
  <button class="hamburger" id="hamburger" aria-label="Menu">
    <span></span><span></span><span></span>
  </button>
</nav>

<!-- ─── HERO ─────────────────────────────────────────────── -->
<section id="home" class="hero">
  <div class="hero-text">
    <div class="hero-badge">
      <span>Available for opportunities</span>
    </div>
    <h1 class="hero-name">
      Sydney<br><em>D. Jimenez</em>
    </h1>
    <p class="hero-title">
      <strong>Website Developer</strong> &amp; UI Designer
    </p>
    <p class="hero-desc">
      Graduating BS Information Technology student at New Era University.Eager to bring hands-on experience in web development, database management, and UI design to a professional team.
    </p>
    <div class="hero-actions">
      <a href="#work" class="btn-primary-cta">View My Work <i class="fas fa-arrow-right"></i></a>
      <a href="#contact" class="btn-outline-cta"><i class="fas fa-envelope"></i> Let's Talk</a>
    </div>
    <div class="hero-stats">
      <div>
        <div class="stat-num">6+</div>
        <div class="stat-label">Projects Built</div>
      </div>
      <div>
        <div class="stat-num">5+</div>
        <div class="stat-label">Certifications</div>
      </div>
      <div>
        <div class="stat-num">3+</div>
        <div class="stat-label">Years of Coding</div>
      </div>
    </div>
  </div>

  <div class="hero-visual">
    <div class="hero-img-wrap">
      <div class="hero-img-bg"></div>
      <img src="img/profilepic.jpg" alt="Sydney Jimenez" class="hero-img">
      <div class="floating-chip chip-1"><div class="chip-dot"></div> PHP &amp; MySQL</div>
      <div class="floating-chip chip-2"><div class="chip-dot"></div> UI / UX Design</div>
      <div class="floating-chip chip-3"><div class="chip-dot"></div> Oracle Certified</div>
    </div>
  </div>
</section>

<!-- ─── ABOUT ─────────────────────────────────────────────── -->
<section id="about" class="section">
  <div class="section-tag reveal">About Me</div>
  <h2 class="section-title reveal">The person behind<br>the code</h2>
  <div class="divider reveal"></div>

  <div class="about-grid">
    <div>
      <div class="about-info-block reveal">
        <div class="about-icon"><i class="fas fa-user"></i></div>
        <div>
          <div class="about-info-label">Full Name</div>
          <div class="about-info-value"><?= htmlspecialchars($info['name'] ?? 'Sydney D. Jimenez') ?></div>
        </div>
      </div>
      <div class="about-info-block reveal reveal-delay-1">
        <div class="about-icon"><i class="fas fa-envelope"></i></div>
        <div>
          <div class="about-info-label">Email</div>
          <div class="about-info-value"><?= htmlspecialchars($info['email'] ?? 'sydneyjimenez0030@gmail.com') ?></div>
        </div>
      </div>
      <div class="about-info-block reveal reveal-delay-2">
        <div class="about-icon"><i class="fas fa-map-marker-alt"></i></div>
        <div>
          <div class="about-info-label">Based In</div>
          <div class="about-info-value">Philippines 🇵🇭</div>
        </div>
      </div>
      <div class="about-info-block reveal reveal-delay-3">
        <div class="about-icon"><i class="fas fa-briefcase"></i></div>
        <div>
          <div class="about-info-label">Status</div>
          <div class="about-info-value" style="color:var(--amber);font-weight:600;">Open to Work — Immediate</div>
        </div>
      </div>
      <div class="about-info-block reveal reveal-delay-4">
        <div class="about-icon"><i class="fas fa-graduation-cap"></i></div>
        <div>
          <div class="about-info-label">Course</div>
          <div class="about-info-value">BS Information Technology — New Era University <span style="color:var(--amber);font-size:0.8rem;font-weight:700;">(Graduating)</span></div>
        </div>
      </div>
    </div>

    <div class="reveal reveal-delay-1">
      <p class="about-text">
        <?= htmlspecialchars($about['about_me'] ?? 'Hi! I\'m Sydney D. Jimenez, a graduating BS Information Technology student at New Era University. Throughout my studies, I\'ve built a strong foundation in web development, database management, and UI design and I\'m now ready to bring everything I\'ve learned into a professional setting.') ?>
      </p>
      <p class="about-text">
        I specialize in full-stack web development using PHP, MySQL, HTML, CSS, and JavaScript. I take pride in writing clean, maintainable code and crafting interfaces that are both functional and visually polished. I'm dependable, detail-oriented, and someone who takes full ownership of the work I deliver.
      </p>
      <p class="about-text">
        I'm actively seeking entry-level opportunities where I can contribute from day one, grow alongside a team, and make a real impact. Outside of tech, I enjoy photography, gaming, and keeping up with industry trends, because the best developers never stop learning.
      </p>
      <div class="interest-tags">
        <span class="interest-tag">📷 Photography</span>
        <span class="interest-tag">🎮 Gaming</span>
        <span class="interest-tag">🌐 Web Dev</span>
        <span class="interest-tag">☁️ Cloud Computing</span>
        <span class="interest-tag">🎨 UI Design</span>
        <span class="interest-tag">📊 Databases</span>
      </div>

      <div style="margin-top:1.5rem;">
        <div style="font-size:0.72rem;text-transform:uppercase;letter-spacing:0.1em;color:var(--amber);font-weight:700;margin-bottom:0.75rem;">Languages</div>
        <div style="display:flex;gap:0.75rem;flex-wrap:wrap;">
          <div style="background:var(--surface2);border:1px solid var(--border);border-radius:8px;padding:0.5rem 1rem;font-size:0.85rem;">🇵🇭 Filipino <span style="color:var(--amber);font-size:0.72rem;font-weight:700;margin-left:0.4rem;">Native</span></div>
          <div style="background:var(--surface2);border:1px solid var(--border);border-radius:8px;padding:0.5rem 1rem;font-size:0.85rem;">🇺🇸 English <span style="color:var(--amber);font-size:0.72rem;font-weight:700;margin-left:0.4rem;">Proficient</span></div>
          <div style="background:var(--surface2);border:1px solid var(--border);border-radius:8px;padding:0.5rem 1rem;font-size:0.85rem;">🇯🇵 Japanese <span style="color:var(--amber);font-size:0.72rem;font-weight:700;margin-left:0.4rem;">Basic</span></div>
        </div>
      </div>
      <br>
    </div>
  </div>
</section>

<!-- ─── SKILLS ─────────────────────────────────────────────── -->
<section id="skills" class="section">
  <div class="section-tag reveal">Technical Skills</div>
  <h2 class="section-title reveal">What I bring<br>to the table</h2>
  <div class="divider reveal"></div>
  <p class="section-sub reveal">Technologies and tools I've worked with throughout my studies and personal projects.</p>

  <div class="skills-grid">
    <div class="skill-card reveal">
      <div class="skill-header">
        <div class="skill-icon-box"><i class="fab fa-html5"></i></div>
        <span class="skill-name">HTML &amp; CSS</span>
      </div>
      <div class="skill-level-label"><span>Proficiency</span><span>90%</span></div>
      <div class="skill-bar"><div class="skill-fill" data-width="90%"></div></div>
    </div>
    <div class="skill-card reveal reveal-delay-1">
      <div class="skill-header">
        <div class="skill-icon-box"><i class="fab fa-js"></i></div>
        <span class="skill-name">JavaScript</span>
      </div>
      <div class="skill-level-label"><span>Proficiency</span><span>75%</span></div>
      <div class="skill-bar"><div class="skill-fill" data-width="75%"></div></div>
    </div>
    <div class="skill-card reveal reveal-delay-2">
      <div class="skill-header">
        <div class="skill-icon-box"><i class="fab fa-php"></i></div>
        <span class="skill-name">PHP</span>
      </div>
      <div class="skill-level-label"><span>Proficiency</span><span>80%</span></div>
      <div class="skill-bar"><div class="skill-fill" data-width="80%"></div></div>
    </div>
    <div class="skill-card reveal reveal-delay-3">
      <div class="skill-header">
        <div class="skill-icon-box"><i class="fas fa-database"></i></div>
        <span class="skill-name">MySQL / SQL</span>
      </div>
      <div class="skill-level-label"><span>Proficiency</span><span>80%</span></div>
      <div class="skill-bar"><div class="skill-fill" data-width="80%"></div></div>
    </div>
    <div class="skill-card reveal">
      <div class="skill-header">
        <div class="skill-icon-box"><i class="fab fa-java"></i></div>
        <span class="skill-name">Java</span>
      </div>
      <div class="skill-level-label"><span>Proficiency</span><span>65%</span></div>
      <div class="skill-bar"><div class="skill-fill" data-width="65%"></div></div>
    </div>
    <div class="skill-card reveal reveal-delay-1">
      <div class="skill-header">
        <div class="skill-icon-box"><i class="fab fa-python"></i></div>
        <span class="skill-name">Python</span>
      </div>
      <div class="skill-level-label"><span>Proficiency</span><span>60%</span></div>
      <div class="skill-bar"><div class="skill-fill" data-width="60%"></div></div>
    </div>
    <div class="skill-card reveal reveal-delay-2">
      <div class="skill-header">
        <div class="skill-icon-box"><i class="fab fa-bootstrap"></i></div>
        <span class="skill-name">Bootstrap</span>
      </div>
      <div class="skill-level-label"><span>Proficiency</span><span>85%</span></div>
      <div class="skill-bar"><div class="skill-fill" data-width="85%"></div></div>
    </div>
    <div class="skill-card reveal reveal-delay-3">
      <div class="skill-header">
        <div class="skill-icon-box"><i class="fab fa-git-alt"></i></div>
        <span class="skill-name">Git &amp; GitHub</span>
      </div>
      <div class="skill-level-label"><span>Proficiency</span><span>70%</span></div>
      <div class="skill-bar"><div class="skill-fill" data-width="70%"></div></div>
    </div>
    <div class="skill-card reveal reveal-delay-3">
  <div class="skill-header">
    <div class="skill-icon-box"><i class="fas fa-server"></i></div>
    <span class="skill-name">Laragon</span>
  </div>
  <div class="skill-level-label"><span>Proficiency</span><span>80%</span></div>
  <div class="skill-bar"><div class="skill-fill" data-width="80%"></div></div>
</div>
   <div class="skill-card reveal reveal-delay-3">
  <div class="skill-header">
    <div class="skill-icon-box"><i class="fas fa-network-wired"></i></div>
    <span class="skill-name">Cisco Packet Tracer</span>
  </div>
  <div class="skill-level-label"><span>Proficiency</span><span>65%</span></div>
  <div class="skill-bar"><div class="skill-fill" data-width="65%"></div></div>
</div>
</section>

<!-- ─── EDUCATION ──────────────────────────────────────────── -->
<section id="education" class="section">
  <div class="section-tag reveal">Education</div>
  <h2 class="section-title reveal">Academic<br>Background</h2>
  <div class="divider reveal"></div>

  <div class="edu-timeline">
  <div class="edu-item reveal">
    <div class="edu-dot"><i class="fas fa-briefcase"></i></div>
    <div class="edu-content">
      <div class="edu-period">First Semester 2025-2026</div>
      <div class="edu-school">Social Security System (SSS) Main Branch</div>
      <div class="edu-degree">
        <strong>Data Analytics and Governance Support</strong><br>
        Underwent comprehensive training in data handling, simple analysis, and interpretation for institutional reporting. Provided vital assistance to the governance team by streamlining documentation support, organizing large datasets, and coordinating administrative tasks.
      </div>
      <span class="edu-badge">Internship Phase I</span>
    </div>
  </div>

  <div class="edu-item reveal">
    <div class="edu-dot"><i class="fas fa-code"></i></div>
    <div class="edu-content">
      <div class="edu-period">Second Semester 2026</div>
      <div class="edu-school">IT Sabado and Associates CPA</div>
      <div class="edu-degree">
        <strong>Web Development Deployment</strong><br>
        Deployed to a professional accounting firm to spearhead web development initiatives. Tasked with building and maintaining web-based solutions designed to improve the firm's digital reach and optimize internal operational workflows.
      </div>
      <span class="edu-badge">Internship Phase II</span>
    </div>
  </div>
</div>
    <div class="edu-item reveal reveal-delay-1">
      <div class="edu-dot"><i class="fas fa-university"></i></div>
      <div class="edu-content">
        <div class="edu-period">2022 — Present</div>
        <div class="edu-school">New Era University</div>
        <div class="edu-degree">Bachelor of Science in Information Technology</div>
        <span class="edu-badge">Graduating — 4th Year</span>
      </div>
    </div>
    <div class="edu-item reveal reveal-delay-2">
      <div class="edu-dot"><i class="fas fa-school"></i></div>
      <div class="edu-content">
        <div class="edu-period">2020 — 2022</div>
        <div class="edu-school">San Juan Senior High School Standalone</div>
        <div class="edu-degree">Senior High School — With Honors</div>
        <span class="edu-badge">Graduated With Honors</span>
      </div>
    </div>
    <div class="edu-item reveal reveal-delay-3">
      <div class="edu-dot"><i class="fas fa-school"></i></div>
      <div class="edu-content">
        <div class="edu-period">2016 — 2020</div>
        <div class="edu-school">Naguilian National High School</div>
        <div class="edu-degree">Junior High School</div>
        <span class="edu-badge">Graduated</span>
      </div>
    </div>
  </div>
</section>

<!-- ─── PROJECTS ───────────────────────────────────────────── -->
<section id="work" class="section">
  <div class="section-tag reveal">Portfolio</div>
  <h2 class="section-title reveal">Featured<br>Projects</h2>
  <div class="divider reveal"></div>
  <p class="section-sub reveal">A selection of laboratory and personal projects that demonstrate my web development skills.</p>

  <div class="projects-grid">
    <div class="project-card reveal"> <div class="project-img">
            <img src="img/websiteprev.png" alt="Company Website"> 
            <div class="project-img-overlay"></div>
        </div>

        <div class="project-body"> <h3 class="project-title">Company Website - Internship Project</h3>
            <p class="project-desc">IT Sabado and Associates CPA Website Profile.</p>
            <a href="ITSABADO.html" class="project-link">View Project <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</div>
   
     

  
  </div>
</section>

<!-- ─── CERTIFICATIONS ──────────────────────────────────────── -->
<section id="certificates" class="section">
  <div class="section-tag reveal">Credentials</div>
  <h2 class="section-title reveal">Certifications<br>&amp; Achievements</h2>
  <div class="divider reveal"></div>
  <p class="section-sub reveal">Verified professional credentials and industry-recognized certifications.</p>

  <div class="certs-grid">
    <div class="cert-card reveal">
      <div class="cert-img"><div class="cert-img-overlay-btn"><div class="lb-icon"><i class="fas fa-eye"></i></div><span>View Certificate</span></div><img src="img/certi1.png" alt="Oracle AI Cert" onerror="this.parentElement.style.background='var(--amber-dim)'"></div>
      <div>
        <div class="cert-issuer">Oracle University · 2023</div>
        <div class="cert-name">Oracle Cloud Infrastructure 2023 AI Certified Foundations Associate</div>
      </div>
      <div style="display:flex;flex-direction:column;gap:0.5rem;"><button class="cert-view-btn open-lightbox-btn"><i class="fas fa-eye"></i> View Certificate</button><a href="https://catalog-education.oracle.com/ords/certview/sharebadge?id=B0ED9FBC13237D076CD79627A208E73BA983B4963379CC03AF0DAF9E332193A6" target="_blank" class="cert-view-btn" style="background:transparent;border-color:var(--border);color:var(--muted);text-decoration:none;"><i class="fas fa-external-link-alt"></i> Verify Credential</a></div>
    </div>
    <div class="cert-card reveal reveal-delay-1">
      <div class="cert-img"><div class="cert-img-overlay-btn"><div class="lb-icon"><i class="fas fa-eye"></i></div><span>View Certificate</span></div><img src="img/certi2.png" alt="Oracle Data Cert" onerror="this.parentElement.style.background='var(--amber-dim)'"></div>
      <div>
        <div class="cert-issuer">Oracle University · 2023</div>
        <div class="cert-name">Oracle Cloud Data Management 2023 Certified Foundations Associate</div>
      </div>
      <div style="display:flex;flex-direction:column;gap:0.5rem;"><button class="cert-view-btn open-lightbox-btn"><i class="fas fa-eye"></i> View Certificate</button><a href="https://catalog-education.oracle.com/ords/certview/sharebadge?id=CFB24FFB33BD7701943B90EF117FB55D468BB6EFE9D78B2FC94BFF6A5613AD5E" target="_blank" class="cert-view-btn" style="background:transparent;border-color:var(--border);color:var(--muted);text-decoration:none;"><i class="fas fa-external-link-alt"></i> Verify Credential</a></div>
    </div>
    <div class="cert-card reveal reveal-delay-2">
      <div class="cert-img"><div class="cert-img-overlay-btn"><div class="lb-icon"><i class="fas fa-eye"></i></div><span>View Certificate</span></div><img src="img/certi3.png" alt="Oracle Infra Cert" onerror="this.parentElement.style.background='var(--amber-dim)'"></div>
      <div>
        <div class="cert-issuer">Oracle University · 2023</div>
        <div class="cert-name">Oracle Cloud Infrastructure 2023 Certified Foundations Associate</div>
      </div>
      <div style="display:flex;flex-direction:column;gap:0.5rem;"><button class="cert-view-btn open-lightbox-btn"><i class="fas fa-eye"></i> View Certificate</button><a href="https://catalog-education.oracle.com/ords/certview/sharebadge?id=EBB4BFE742387BE67DD9408B361B96752C0F8AD3ABFB9E8087A14BFCBD934D0A" target="_blank" class="cert-view-btn" style="background:transparent;border-color:var(--border);color:var(--muted);text-decoration:none;"><i class="fas fa-external-link-alt"></i> Verify Credential</a></div>
    </div>
    <div class="cert-card reveal">
      <div class="cert-img"><div class="cert-img-overlay-btn"><div class="lb-icon"><i class="fas fa-eye"></i></div><span>View Certificate</span></div><img src="img/certi4.png" alt="SQL Cert" onerror="this.parentElement.style.background='var(--amber-dim)'"></div>
      <div>
        <div class="cert-issuer">IBM Cognitive Class · 2023</div>
        <div class="cert-name">SQL and Relational Databases 101</div>
      </div>
      <div style="display:flex;flex-direction:column;gap:0.5rem;"><button class="cert-view-btn open-lightbox-btn"><i class="fas fa-eye"></i> View Certificate</button><a href="https://courses.cognitiveclass.ai/certificates/4ce64d154ba3483c8a7c7fa297cea19b" target="_blank" class="cert-view-btn" style="background:transparent;border-color:var(--border);color:var(--muted);text-decoration:none;"><i class="fas fa-external-link-alt"></i> Verify Credential</a></div>
    </div>
    <div class="cert-card reveal reveal-delay-1">
      <div class="cert-img"><div class="cert-img-overlay-btn"><div class="lb-icon"><i class="fas fa-eye"></i></div><span>View Certificate</span></div><img src="img/certi5.png" alt="Cert 5" onerror="this.parentElement.style.background='var(--amber-dim)'"></div>
      <div>
        <div class="cert-issuer">IBM Cognitive Class · 2023</div>
        <div class="cert-name">Introduction to Cloud Computing</div>
      </div>
      <div style="display:flex;flex-direction:column;gap:0.5rem;"><button class="cert-view-btn open-lightbox-btn"><i class="fas fa-eye"></i> View Certificate</button><a href="https://courses.cognitiveclass.ai/certificates/18a311579f25448db8a2bc6f373f67d0" target="_blank" class="cert-view-btn" style="background:transparent;border-color:var(--border);color:var(--muted);text-decoration:none;"><i class="fas fa-external-link-alt"></i> Verify Credential</a></div>
    </div>

    <!-- Day 1 Certificates -->
    <div class="cert-card reveal reveal-delay-2">
      <div class="cert-img"><div class="cert-img-overlay-btn"><div class="lb-icon"><i class="fas fa-eye"></i></div><span>View Certificate</span></div><img src="img/D1_T1_S107.png" alt="D1 T1 Certificate" onerror="this.parentElement.style.background='var(--amber-dim)'"></div>
      <div>
        <div class="cert-issuer">The Learning Loop to Elevate · April 22, 2025</div>
        <div class="cert-name">From Frame to Scene: I Have a Degree in Animation. Now What's Next?</div>
      </div>
      <button class="cert-view-btn open-lightbox-btn"><i class="fas fa-eye"></i> View Certificate</button>
    </div>

    <div class="cert-card reveal">
      <div class="cert-img"><div class="cert-img-overlay-btn"><div class="lb-icon"><i class="fas fa-eye"></i></div><span>View Certificate</span></div><img src="img/D1_T2_S216.png" alt="D1 T2 Certificate" onerror="this.parentElement.style.background='var(--amber-dim)'"></div>
      <div>
        <div class="cert-issuer">The Learning Loop to Elevate · April 22, 2025</div>
        <div class="cert-name">How to Earn in Animation</div>
      </div>
      <button class="cert-view-btn open-lightbox-btn"><i class="fas fa-eye"></i> View Certificate</button>
    </div>

    <div class="cert-card reveal reveal-delay-1">
      <div class="cert-img"><div class="cert-img-overlay-btn"><div class="lb-icon"><i class="fas fa-eye"></i></div><span>View Certificate</span></div><img src="img/D1_T3_S85.png" alt="D1 T3 Certificate" onerror="this.parentElement.style.background='var(--amber-dim)'"></div>
      <div>
        <div class="cert-issuer">The Learning Loop to Elevate · April 22, 2025</div>
        <div class="cert-name">Business Communication</div>
      </div>
      <button class="cert-view-btn open-lightbox-btn"><i class="fas fa-eye"></i> View Certificate</button>
    </div>

    <div class="cert-card reveal reveal-delay-2">
      <div class="cert-img"><div class="cert-img-overlay-btn"><div class="lb-icon"><i class="fas fa-eye"></i></div><span>View Certificate</span></div><img src="img/D1_T4_S89.png" alt="D1 T4 Certificate" onerror="this.parentElement.style.background='var(--amber-dim)'"></div>
      <div>
        <div class="cert-issuer">The Learning Loop to Elevate · April 22, 2025</div>
        <div class="cert-name">Rewrite Your Legacy: From Comics to Hollywood — A 2D Illustrator's Journey</div>
      </div>
      <button class="cert-view-btn open-lightbox-btn"><i class="fas fa-eye"></i> View Certificate</button>
    </div>

    <div class="cert-card reveal">
      <div class="cert-img"><div class="cert-img-overlay-btn"><div class="lb-icon"><i class="fas fa-eye"></i></div><span>View Certificate</span></div><img src="img/D1_T5_S149.png" alt="D1 T5 Certificate" onerror="this.parentElement.style.background='var(--amber-dim)'"></div>
      <div>
        <div class="cert-issuer">The Learning Loop to Elevate · April 22, 2025</div>
        <div class="cert-name">Beyond the Degree: Skills and Competencies for Your Future Tech</div>
      </div>
      <button class="cert-view-btn open-lightbox-btn"><i class="fas fa-eye"></i> View Certificate</button>
    </div>

    <div class="cert-card reveal reveal-delay-1">
      <div class="cert-img"><div class="cert-img-overlay-btn"><div class="lb-icon"><i class="fas fa-eye"></i></div><span>View Certificate</span></div><img src="img/D1_T6_S125.png" alt="D1 T6 Certificate" onerror="this.parentElement.style.background='var(--amber-dim)'"></div>
      <div>
        <div class="cert-issuer">The Learning Loop to Elevate · April 22, 2025</div>
        <div class="cert-name">Modern Web Development: How a Full Stack Web App Goes Live</div>
      </div>
      <button class="cert-view-btn open-lightbox-btn"><i class="fas fa-eye"></i> View Certificate</button>
    </div>

    <!-- Day 2 Certificates -->
    <div class="cert-card reveal reveal-delay-2">
      <div class="cert-img"><div class="cert-img-overlay-btn"><div class="lb-icon"><i class="fas fa-eye"></i></div><span>View Certificate</span></div><img src="img/D2_T1_S179.png" alt="D2 T1 Certificate" onerror="this.parentElement.style.background='var(--amber-dim)'"></div>
      <div>
        <div class="cert-issuer">The Learning Loop to Elevate · April 21, 2025</div>
        <div class="cert-name">Power UP Your PASSION: Careers in the Gaming World</div>
      </div>
      <button class="cert-view-btn open-lightbox-btn"><i class="fas fa-eye"></i> View Certificate</button>
    </div>

    <div class="cert-card reveal">
      <div class="cert-img"><div class="cert-img-overlay-btn"><div class="lb-icon"><i class="fas fa-eye"></i></div><span>View Certificate</span></div><img src="img/D2_T2_S199.png" alt="D2 T2 Certificate" onerror="this.parentElement.style.background='var(--amber-dim)'"></div>
      <div>
        <div class="cert-issuer">The Learning Loop to Elevate · April 21, 2025</div>
        <div class="cert-name">Behind the Scenes of Game QA: Testing, NDA's, and Daily Life</div>
      </div>
      <button class="cert-view-btn open-lightbox-btn"><i class="fas fa-eye"></i> View Certificate</button>
    </div>

    <div class="cert-card reveal reveal-delay-1">
      <div class="cert-img"><div class="cert-img-overlay-btn"><div class="lb-icon"><i class="fas fa-eye"></i></div><span>View Certificate</span></div><img src="img/D2_T3_S185.png" alt="D2 T3 Certificate" onerror="this.parentElement.style.background='var(--amber-dim)'"></div>
      <div>
        <div class="cert-issuer">The Learning Loop to Elevate · April 21, 2025</div>
        <div class="cert-name">Web Penetration Testing 101</div>
      </div>
      <button class="cert-view-btn open-lightbox-btn"><i class="fas fa-eye"></i> View Certificate</button>
    </div>

    <div class="cert-card reveal reveal-delay-2">
      <div class="cert-img"><div class="cert-img-overlay-btn"><div class="lb-icon"><i class="fas fa-eye"></i></div><span>View Certificate</span></div><img src="img/D2_T4_S167.png" alt="D2 T4 Certificate" onerror="this.parentElement.style.background='var(--amber-dim)'"></div>
      <div>
        <div class="cert-issuer">The Learning Loop to Elevate · April 21, 2025</div>
        <div class="cert-name">Agentic AI</div>
      </div>
      <button class="cert-view-btn open-lightbox-btn"><i class="fas fa-eye"></i> View Certificate</button>
    </div>

    <div class="cert-card reveal">
      <div class="cert-img"><div class="cert-img-overlay-btn"><div class="lb-icon"><i class="fas fa-eye"></i></div><span>View Certificate</span></div><img src="img/D2_T5_S238.png" alt="D2 T5 Certificate" onerror="this.parentElement.style.background='var(--amber-dim)'"></div>
      <div>
        <div class="cert-issuer">The Learning Loop to Elevate · April 21, 2025</div>
        <div class="cert-name">Building a Home Without Windows: A Student's Guide to Linux</div>
      </div>
      <button class="cert-view-btn open-lightbox-btn"><i class="fas fa-eye"></i> View Certificate</button>
    </div>

    <div class="cert-card reveal reveal-delay-1">
      <div class="cert-img"><div class="cert-img-overlay-btn"><div class="lb-icon"><i class="fas fa-eye"></i></div><span>View Certificate</span></div><img src="img/D2_T6_S141.png" alt="D2 T6 Certificate" onerror="this.parentElement.style.background='var(--amber-dim)'"></div>
      <div>
        <div class="cert-issuer">The Learning Loop to Elevate · April 21, 2025</div>
        <div class="cert-name">Life After Graduation: The Reality No One Talks About</div>
      </div>
      <button class="cert-view-btn open-lightbox-btn"><i class="fas fa-eye"></i> View Certificate</button>
    </div>

    <div class="cert-card reveal reveal-delay-2">
      <div class="cert-img"><div class="cert-img-overlay-btn"><div class="lb-icon"><i class="fas fa-eye"></i></div><span>View Certificate</span></div><img src="img/senpaiCert.png" alt="SENPAI Certificate" onerror="this.parentElement.style.background='var(--amber-dim)'"></div>
      <div>
        <div class="cert-issuer">NEU — Association of Computer Science Students · February 6, 2026</div>
        <div class="cert-name">Certificate of Participation — SENPAI Ver. 3.0 (Senior Programming Assistance Integration)</div>
      </div>
      <button class="cert-view-btn open-lightbox-btn"><i class="fas fa-eye"></i> View Certificate</button>
    </div>

  </div>
</section>

<!-- ─── CONTACT ─────────────────────────────────────────────── -->
<section id="contact" class="section">
  <div class="section-tag reveal">Get In Touch</div>
  <h2 class="section-title reveal">Let's work<br>together</h2>
  <div class="divider reveal"></div>
  <p class="section-sub reveal">Open to internship opportunities, freelance projects, and collaborations. Let's build something great.</p>

  <div class="contact-grid">
    <div>
      <a href="mailto:sydneyjimenez0030@gmail.com" class="contact-channel reveal">
        <div class="contact-ch-icon"><i class="fas fa-envelope"></i></div>
        <div>
          <div class="contact-ch-label">Email</div>
          <div class="contact-ch-value">sydneyjimenez0030@gmail.com</div>
        </div>
      </a>
      <a href="https://www.linkedin.com/in/sydneyjimenez3796ab2a2/" target="_blank" class="contact-channel reveal reveal-delay-1">
        <div class="contact-ch-icon"><i class="fab fa-linkedin-in"></i></div>
        <div>
          <div class="contact-ch-label">LinkedIn</div>
          <div class="contact-ch-value">Sydney Jimenez</div>
        </div>
      </a>
      <a href="https://www.facebook.com/JSydneyDS" target="_blank" class="contact-channel reveal reveal-delay-2">
        <div class="contact-ch-icon"><i class="fab fa-facebook-f"></i></div>
        <div>
          <div class="contact-ch-label">Facebook</div>
          <div class="contact-ch-value">Sydney Jimenez</div>
        </div>
      </a>
      <a href="https://www.instagram.com/sydjzcn_/" target="_blank" class="contact-channel reveal reveal-delay-3">
        <div class="contact-ch-icon"><i class="fab fa-instagram"></i></div>
        <div>
          <div class="contact-ch-label">Instagram</div>
          <div class="contact-ch-value">@_sydjzz</div>
        </div>
      </a>
    </div>

    <div class="contact-form reveal reveal-delay-2">
      <form id="contact-form" data-netlify="true" name="contact">
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Your Name</label>
            <input type="text" name="name" class="form-input" placeholder="Juan dela Cruz" required>
          </div>
          <div class="form-group">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-input" placeholder="juan@email.com" required>
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Subject</label>
          <input type="text" name="subject" class="form-input" placeholder="Internship Inquiry" required>
        </div>
        <div class="form-group">
          <label class="form-label">Message</label>
          <textarea name="message" class="form-textarea" placeholder="Tell me about your project..." required></textarea>
        </div>
        <button type="submit" id="submit-btn" class="form-submit">
            Send Message <i class="fas fa-paper-plane" style="margin-left:0.5rem;"></i>
        </button>
      </form>
    </div>
  </div>
</section>
<script>
  const contactForm = document.getElementById('contact-form');
  const submitBtn = document.getElementById('submit-btn');

  contactForm.addEventListener('submit', (e) => {
    e.preventDefault();

    // 1. Show loading state
    submitBtn.innerHTML = 'Sending... <i class="fas fa-spinner fa-spin"></i>';
    submitBtn.style.opacity = '0.7';
    submitBtn.disabled = true;

    const formData = new FormData(contactForm);

    // 2. Submit to Netlify
    fetch("/", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: new URLSearchParams(formData).toString(),
    })
      .then(() => {
        // 3. SUCCESS STATE
        submitBtn.innerHTML = 'Message Sent! <i class="fas fa-check"></i>';
        submitBtn.style.backgroundColor = '#28a745'; // Green success color
        submitBtn.style.color = '#fff';
        submitBtn.style.opacity = '1';
        
        contactForm.reset(); // Clear the form

        // Optional: Reset button back to normal after 5 seconds
        setTimeout(() => {
          submitBtn.innerHTML = 'Send Message <i class="fas fa-paper-plane"></i>';
          submitBtn.style.backgroundColor = ''; // Goes back to your CSS amber color
          submitBtn.disabled = false;
        }, 5000);
      })
      .catch((error) => {
        alert('Form submission failed. Please try again.');
        submitBtn.innerHTML = 'Send Message';
        submitBtn.disabled = false;
      });
  });
</script>
<!-- ─── FOOTER ─────────────────────────────────────────────── -->
<footer>
  <div class="footer-logo">S<span>J</span></div>
  <div class="footer-copy">&copy; <?= date('Y') ?> Sydney D. Jimenez · All rights reserved.</div>
  <div class="footer-socials">
    <a href="https://www.linkedin.com/in/sydneyjimenez3796ab2a2/" target="_blank" class="footer-social"><i class="fab fa-linkedin-in"></i></a>
    <a href="https://www.facebook.com/JSydneyDS/" target="_blank" class="footer-social"><i class="fab fa-facebook-f"></i></a>
    <a href="https://www.instagram.com/_sydjzz/" target="_blank" class="footer-social"><i class="fab fa-instagram"></i></a>
    <a href="https://github.com/SydneyJimenez" target="_blank" class="footer-social"><i class="fab fa-github"></i></a>
  </div>
</footer>

<!-- Admin FAB -->
<a href="admin.php" class="admin-fab" title="Admin Panel"><i class="fas fa-cog"></i></a>

<!-- ─── LIGHTBOX HTML ──────────────────────────────────────── -->
<div class="lightbox" id="certLightbox" role="dialog" aria-modal="true" aria-label="Certificate viewer">

  <button class="lightbox-close" id="lbClose" aria-label="Close">
    <i class="fas fa-times"></i>
  </button>
  <button class="lightbox-nav lightbox-prev" id="lbPrev" aria-label="Previous">
    <i class="fas fa-chevron-left"></i>
  </button>
  <button class="lightbox-nav lightbox-next" id="lbNext" aria-label="Next">
    <i class="fas fa-chevron-right"></i>
  </button>

  <div class="lightbox-inner">
    <div class="lightbox-img-wrap" id="lbImgWrap">
      <img id="lbImg" src="" alt="" draggable="false">
      <div class="lightbox-no-img" id="lbNoImg">
        <i class="fas fa-image"></i>
        <span>No image available for this certificate.</span>
      </div>
    </div>
    <div class="lightbox-caption" id="lbCaption"></div>
    <div class="lightbox-counter" id="lbCounter"></div>
  </div>

</div>

<script>
// ── NAV SCROLL ────────────────────────────────────────────
const nav = document.getElementById('mainNav');
window.addEventListener('scroll', () => {
  nav.classList.toggle('scrolled', window.scrollY > 30);
});

// ── HAMBURGER ─────────────────────────────────────────────
const hamburger = document.getElementById('hamburger');
const navLinks  = document.getElementById('navLinks');
hamburger.addEventListener('click', () => navLinks.classList.toggle('open'));
navLinks.querySelectorAll('a').forEach(a => a.addEventListener('click', () => navLinks.classList.remove('open')));

// ── SCROLL REVEAL ─────────────────────────────────────────
const reveals = document.querySelectorAll('.reveal');
const observer = new IntersectionObserver((entries) => {
  entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); } });
}, { threshold: 0.12 });
reveals.forEach(el => observer.observe(el));

// ── SKILL BARS ─────────────────────────────────────────────
const barObserver = new IntersectionObserver((entries) => {
  entries.forEach(e => {
    if (e.isIntersecting) {
      const fill = e.target.querySelector('.skill-fill');
      if (fill) fill.style.width = fill.dataset.width;
    }
  });
}, { threshold: 0.4 });
document.querySelectorAll('.skill-card').forEach(c => barObserver.observe(c));

// ── ACTIVE NAV LINKS ──────────────────────────────────────
const sections = document.querySelectorAll('section[id]');
const navAnchors = document.querySelectorAll('.nav-links a[href^="#"]');
window.addEventListener('scroll', () => {
  let current = '';
  sections.forEach(s => {
    if (window.scrollY >= s.offsetTop - 100) current = s.getAttribute('id');
  });
  navAnchors.forEach(a => {
    a.style.color = a.getAttribute('href') === '#' + current ? 'var(--amber)' : '';
  });
});

// ── CERTIFICATE LIGHTBOX ──────────────────────────────────
(function () {
  const lightbox  = document.getElementById('certLightbox');
  const lbImg     = document.getElementById('lbImg');
  const lbNoImg   = document.getElementById('lbNoImg');
  const lbCaption = document.getElementById('lbCaption');
  const lbClose   = document.getElementById('lbClose');
  const lbPrev    = document.getElementById('lbPrev');
  const lbNext    = document.getElementById('lbNext');
  const lbCounter = document.getElementById('lbCounter');

  const cards = Array.from(document.querySelectorAll('.cert-card'));
  const certData = cards.map(card => ({
    src:    card.querySelector('.cert-img img')?.src || null,
    alt:    card.querySelector('.cert-img img')?.alt || '',
    name:   card.querySelector('.cert-name')?.textContent?.trim() || '',
    issuer: card.querySelector('.cert-issuer')?.textContent?.trim() || ''
  }));

  let current = 0;

  function show(idx) {
    current = (idx + certData.length) % certData.length;
    const d = certData[current];
    lbCounter.textContent = `${current + 1} / ${certData.length}`;
    lbCaption.innerHTML = `<strong>${d.name}</strong><em>${d.issuer}</em>`;
    if (d.src) {
      lbNoImg.style.display = 'none';
      lbImg.style.display   = 'block';
      lbImg.src = d.src;
      lbImg.alt = d.alt;
    } else {
      lbImg.style.display   = 'none';
      lbNoImg.style.display = 'flex';
    }
    lbPrev.classList.toggle('hidden', certData.length <= 1);
    lbNext.classList.toggle('hidden', certData.length <= 1);
  }

  function open(idx) {
    show(idx);
    lightbox.classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function close() {
    lightbox.classList.remove('open');
    document.body.style.overflow = '';
    setTimeout(() => { lbImg.src = ''; }, 350);
  }

  function goNext() {
    const inner = document.querySelector('.lightbox-inner');
    inner.style.transition = 'none';
    inner.style.opacity = '0';
    inner.style.transform = 'scale(0.96) translateX(40px)';
    setTimeout(() => {
      show(current + 1);
      inner.style.transition = 'opacity 0.3s ease, transform 0.35s cubic-bezier(0.34,1.3,0.64,1)';
      inner.style.opacity = '1';
      inner.style.transform = 'scale(1) translateY(0)';
    }, 110);
  }

  function goPrev() {
    const inner = document.querySelector('.lightbox-inner');
    inner.style.transition = 'none';
    inner.style.opacity = '0';
    inner.style.transform = 'scale(0.96) translateX(-40px)';
    setTimeout(() => {
      show(current - 1);
      inner.style.transition = 'opacity 0.3s ease, transform 0.35s cubic-bezier(0.34,1.3,0.64,1)';
      inner.style.opacity = '1';
      inner.style.transform = 'scale(1) translateY(0)';
    }, 110);
  }

  // Bind View Certificate buttons and cert image clicks
  cards.forEach((card, idx) => {
    card.querySelectorAll('.open-lightbox-btn').forEach(btn => {
      btn.addEventListener('click', (e) => { e.stopPropagation(); open(idx); });
    });
    const certImgEl = card.querySelector('.cert-img');
    if (certImgEl) certImgEl.addEventListener('click', () => open(idx));
  });

  lbClose.addEventListener('click', close);
  lbPrev.addEventListener('click', goPrev);
  lbNext.addEventListener('click', goNext);
  lightbox.addEventListener('click', (e) => { if (e.target === lightbox) close(); });

  document.addEventListener('keydown', (e) => {
    if (!lightbox.classList.contains('open')) return;
    if (e.key === 'Escape')     close();
    if (e.key === 'ArrowRight') goNext();
    if (e.key === 'ArrowLeft')  goPrev();
  });

  let touchStartX = 0;
  lightbox.addEventListener('touchstart', (e) => { touchStartX = e.touches[0].clientX; }, { passive: true });
  lightbox.addEventListener('touchend', (e) => {
    const diff = touchStartX - e.changedTouches[0].clientX;
    if (Math.abs(diff) > 50) diff > 0 ? goNext() : goPrev();
  });
})();
</script>

</body>
</html>