<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LIZA-R</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

  <style>
    /* VARIABLES */
    :root {
      --nav-bg: rgba(245, 242, 235, 0.92);
      --nav-border: rgba(13, 13, 13, 0.12);
      --ink: #0d0d0d;
      --accent: #e63946;
      --mid: #6b7280;
    }

    body {
      margin: 0;
      font-family: 'DM Sans', sans-serif;
      background: #f4f7fb;
    }

    /* NAVBAR */
    nav {
      position: fixed;
      top: 16px;
      left: 50%;
      transform: translateX(-50%);
      width: calc(100% - 64px);
      max-width: 1400px;
      height: 72px;
      background: var(--nav-bg);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border: 1px solid var(--nav-border);
      border-radius: 100px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 32px;
      z-index: 1000;
      box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    /* LOGO */
    .nav-logo {
      display: flex;
      align-items: center;
      gap: 12px;
      text-decoration: none;
    }

    .nav-logo img {
      height: 40px;
    }

    .nav-logo-text {
      font-family: 'Syne', sans-serif;
      font-weight: 800;
      font-size: 20px;
      color: var(--ink);
      letter-spacing: -0.02em;
    }

    .nav-logo-text span {
      color: var(--accent);
    }

    /* LINKS */
    .nav-links {
      display: flex;
      align-items: center;
      gap: 32px;
      list-style: none;
      margin: 0;
      padding: 0;
    }

    .nav-links a {
      text-decoration: none;
      color: var(--ink);
      font-weight: 500;
      font-size: 15px;
      transition: 0.3s;
    }

    .nav-links a:hover {
      color: var(--accent);
    }

    /* DROPDOWN */
    .dropdown { position: relative; }
    .dropdown-trigger { display: flex; align-items: center; cursor: pointer; }

    .dropdown-menu {
      position: absolute;
      top: 100%;
      left: 50%;
      transform: translateX(-50%) translateY(10px);
      background: var(--nav-bg);
      backdrop-filter: blur(15px);
      -webkit-backdrop-filter: blur(15px);
      border: 1px solid var(--nav-border);
      min-width: 220px;
      border-radius: 20px;
      padding: 12px 0;
      list-style: none;
      box-shadow: 0 15px 35px rgba(0,0,0,0.1);
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
      z-index: 1001;
    }

    .dropdown:hover .dropdown-menu {
      opacity: 1;
      visibility: visible;
      transform: translateX(-50%) translateY(15px);
    }

    .dropdown-menu li a {
      display: block;
      padding: 10px 24px;
      font-size: 0.9rem;
      color: var(--ink);
      transition: all 0.2s ease;
    }

    .dropdown-menu li a:hover {
      background: rgba(13, 13, 13, 0.05);
      color: var(--accent);
      padding-left: 28px;
    }

    /* RREGULLIMI I SEARCH (INLINE) */
    .nav-search-container {
      position: relative;
      display: flex;
      align-items: center;
      background: rgba(13, 13, 13, 0.05);
      border-radius: 100px;
      padding: 4px;
      transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
      border: 1px solid transparent;
      overflow: hidden;
    }

    .nav-search-container.active {
      background: #fff;
      border: 1px solid var(--nav-border);
      padding-left: 16px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      overflow: visible;
    }

    .nav-search-container input {
      width: 0;
      opacity: 0;
      border: none;
      outline: none;
      background: transparent;
      font-family: 'DM Sans', sans-serif;
      font-size: 14px;
      color: var(--ink);
      transition: all 0.4s ease;
      padding: 0;
    }

    .nav-search-container.active input {
      width: 180px;
      opacity: 1;
      margin-right: 8px;
      padding: 0 4px;
    }

    .nav-search-trigger {
      width: 36px;
      height: 36px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      color: var(--ink);
      border-radius: 50%;
      transition: 0.3s;
      flex-shrink: 0;
    }

    .nav-search-container.active .nav-search-trigger {
      background: var(--ink);
      color: #fff;
    }
.dropdown-submenu { position: relative; }
.dropdown-submenu .submenu { 
    display: none; 
    position: absolute; 
    left: 100%; 
    top: 0; 
    margin-top: -1px; 
}
.dropdown-submenu:hover > .submenu { display: block; }

/* DEFAULT (DESKTOP) */
.menu-toggle {
  display: none;
}

/* ================= MOBILE ================= */
@media (max-width: 768px) {

  /* HAMBURGER */
  .menu-toggle {
    display: block;
    font-size: 22px;
    cursor: pointer;
    color: var(--ink);
    margin-left: 430px;
  }
  /* NAV */
  nav {
    height: auto;
    padding: 10px 16px;
  }

  .nav-logo img {
    height: 38px;
  }

  /* NAV LINKS (HIDDEN BY DEFAULT) */
  .nav-links {
    position: absolute;
    top: 80px;
    left: 0;
    width: 100%;
    background: var(--nav-bg);
    border-radius: 20px;
    border: 1px solid var(--nav-border);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1);

    flex-direction: column;
    align-items: center;

    display: none; /* KEY */
    padding: 15px 0;
    gap: 10px;
    z-index: 999;
  }

  .nav-links.show {
    display: flex;
  }

  .nav-links li {
    width: 100%;
    text-align: center;
  }

  .nav-links a {
    display: block;
    padding: 12px 0;
    font-size: 14px;
  }
/* DROPDOWN */
.dropdown {
  position: relative;
}

.dropdown-menu {
  display: none;
  position: absolute;
  width: 220px;
  top: 100%;
  left: 200px;
  background: rgba(255,255,255,0.95);
  border-radius: 12px;
  padding: 8px 0;
  box-shadow: 0 8px 20px rgba(0,0,0,0.08);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
}

.dropdown.open > .dropdown-menu {
  display: block;
}

/* SUBMENU */
.dropdown-submenu {
  position: relative;
}

.submenu {
  display: none;
  position: absolute;
  left: 100%;
  top: 0;
  margin-left: 100px;
  width: 200px;
  background: rgba(255,255,255,0.95);
  border-radius: 12px;
  padding: 8px 0;
  box-shadow: 0 8px 20px rgba(0,0,0,0.08);
}

.dropdown-submenu.open > .submenu {
  display: block;
}
  /* SEARCH */
  .nav-search-container.active input {
    width: 100px;
  }
}
  </style>
</head>
<body>

<nav>
  <a href="index.php" class="nav-logo">
    <img src=".\images\Liza logo.png" alt="LIZA-R">
<!-- <div class="nav-logo-text">LIZA<span>-R</span></div>-->
  </a>

  <ul class="nav-links">
    <li><a href="index.php">Ballina</a></li>
    <li class="dropdown">
      <a href="rreth-nesh.php" class="dropdown-trigger">
        Rreth Organizatës 
        <svg width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-left:6px;">
          <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </a>
      <ul class="dropdown-menu">
        <li><a href="kryesia.php">Kryesia & Stafi</a></li>
        <li><a href="strategjia.php">Strategjia 2024-2027</a></li>
       

        <li><a href="strategjiaV.php">Strategjia e Vjetër</a></li>
      </ul>
    </li>
    <li><a href="lajmet.php">Lajmet</a></li>
    <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#">Galeria  <svg width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-left:6px;">
          <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg></a>
    <ul class="dropdown-menu">
        <li><a href="galeria.php?kat=te-pergjithshme">Foto të përgjithshme</a></li>
        <li><a href="galeria.php?kat=vizita">Vizita studentore</a></li>
        <li><a href="galeria.php?kat=delegacionet">Pritje e delegacioneve</a></li>
        <li><a href="galeria.php?kat=evente">Evente</a></li>
        <li><a href="galeria.php?kat=trajnime">Trajnime të mbajtura</a></li>
        <li><a href="galeria.php?kat=trajnime2020/24">Trajnimet 2020-2024</a></li>
    </ul>

</li>
    <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#">Aktivitetet <svg width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-left:6px;">
          <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></a>
    <ul class="dropdown-menu">
        <li class="dropdown-submenu">
            <a class="dropdown-item dropdown-toggle" href="aktivitetet.php?kat=trajnimet">Trajnimet &raquo;</a>
            <ul class="dropdown-menu submenu">
                <li><a class="dropdown-item" href="aktivitetet.php?kat=menaxhimi-strategjik">Menagjimi Strategjik</a></li>
                <li><a class="dropdown-item" href="aktivitetet.php?kat=lidership">Lidership</a></li>
                <li><a class="dropdown-item" href="aktivitetet.php?kat=hartim-projektesh">Hartim dhe Menaxhim Projektesh</a></li>
                <li><a class="dropdown-item" href="aktivitetet.php?kat=administrim-biznesi">Administrim Biznesi</a></li>
                <li><a class="dropdown-item" href="aktivitetet.php?kat=organizim-trajnimeve">Organizimi i Trajnimeve Profesionale</a></li>
            </ul>
        </li>
        <li><a href="aktivitetet.php?kat=konferenca">Konferenca</a></li>
        <li><a href="aktivitetet.php?kat=sport">Sport</a></li>
        <li><a href="aktivitetet.php?kat=rini">Rini</a></li>
        <li><a href="aktivitetet.php?kat=kulture">Kulturë</a></li>
        <li><a href="aktivitetet.php?kat=trashegimi">Trashëgimi Kulturore</a></li>
        <li><a href="aktivitetet.php?kat=verlt">VERLT</a></li>
<li><a href="aktivitetet.php?kat=erasmus">Erasmus+</a></li>
        <li><a href="aktivitetet.php?kat=esc">European Solidarity Corps (ESC)</a></li>
    </ul>
</li>
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#">
        Kurset Profesionale 
        <svg width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-left:6px;">
            <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </a>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="kurset.php?kat=rrobaqepesi">Rrobaqepësi</a></li>
        
        <li><a class="dropdown-item" href="kurset.php?kat=it-dizajn">IT, Dizajn Grafik dhe Ndërmarrësi</a></li>
        
        <li class="dropdown-submenu">
            <a class="dropdown-item dropdown-toggle" href="#">Zhvillim Ekonomik &raquo;</a>
            <ul class="dropdown-menu submenu">
                <li><a class="dropdown-item" href="kurset.php?kat=serra-bujqesi">Mbështetje me Serra për Bujqësi</a></li>
                <li><a class="dropdown-item" href="kurset.php?kat=makina-qepjeje">Mbështetje me Makina të Qepjes</a></li>
            </ul>
        </li>
        
        <li class="dropdown-submenu">
            <a class="dropdown-item dropdown-toggle" href="#">Arsim / Edukim &raquo;</a>
            <ul class="dropdown-menu submenu">
                <li><a class="dropdown-item" href="kurset.php?kat=bursa-ekselence">Mbështetje me Bursa të Ekselencës</a></li>
            </ul>
        </li>
    </ul>
</li>
    <li><a href="kontakti.php">Kontakti</a></li>
  </ul>
   <!--hamburger menu-->
  <div class="menu-toggle">
  <i class="fas fa-bars"></i>
</div>
<!--serch-->
  <div class="nav-search-container" id="searchContainer">
    <input type="text" id="searchInput" placeholder="Kërko..." autocomplete="off">
    <div class="nav-search-trigger" onclick="toggleSearch(event)">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="11" cy="11" r="8"></circle>
        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
      </svg>
    </div>
  </div>
 
</nav>
</body>
<script>
  function toggleSearch(e) {
    if(e) e.stopPropagation();
    const container = document.getElementById('searchContainer');
    const input = document.getElementById('searchInput');
    
    if (!container.classList.contains('active')) {
      container.classList.add('active');
      setTimeout(() => input.focus(), 100);
    } else {
      if (input.value.trim() !== "") {
        window.location.href = "search.php?query=" + encodeURIComponent(input.value);
      } else {
        container.classList.remove('active');
      }
    }
  }

  // Klikimi brenda containerit mos ta mbyllë search-in
  document.getElementById('searchContainer').addEventListener('click', function(e) {
    e.stopPropagation();
  });

  // Mbyll kërkimin nëse klikon jashtë tij
  document.addEventListener('click', function(e) {
    const container = document.getElementById('searchContainer');
    if (container.classList.contains('active')) {
      container.classList.remove('active');
    }
  });

  // Kërko me butonin Enter
  document.getElementById('searchInput').addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
      if (this.value.trim() !== "") {
        window.location.href = "search.php?query=" + encodeURIComponent(this.value);
      }
    }
  });

  // Mbylle me butonin Escape
  document.addEventListener('keydown', (e) => {
    if (e.key === "Escape") {
      document.getElementById('searchContainer').classList.remove('active');
    }
  });
// Toggle menu mobile
const menuBtn = document.querySelector('.menu-toggle');
const navLinks = document.querySelector('.nav-links');

if (menuBtn && navLinks) {

  menuBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    navLinks.classList.toggle('show');
  });

  // mbylle kur klikon jashtë
  document.addEventListener('click', (e) => {
    if (!navLinks.contains(e.target) && !menuBtn.contains(e.target)) {
      navLinks.classList.remove('show');
    }
  });

}
document.querySelectorAll('.dropdown > a').forEach(item => {
  item.addEventListener('click', function(e) {
    e.preventDefault();
    this.parentElement.classList.toggle('open');
  });
});

document.querySelectorAll('.dropdown-submenu > a').forEach(item => {
  item.addEventListener('click', function(e) {
    e.preventDefault();
    this.parentElement.classList.toggle('open');
  });
});
</script>


</html>