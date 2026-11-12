<style>
  footer {
    background: #0d0d0d; /* E zezë si në foto */
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    padding: 80px 0 40px 0;
    margin-top: 100px;
    color: #ffffff; /* Teksti i bardhë për kontrast */
    font-family: 'DM Sans', sans-serif;
  }

  .footer-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 32px;
    display: grid;
    grid-template-columns: 1.5fr 1fr 1fr 1.2fr;
    gap: 60px;
  }

  .footer-col h4 {
    font-family: 'Syne', sans-serif;
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 25px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #ffffff;
  }

  .footer-logo {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
    margin-bottom: 20px;
  }

  .footer-logo img {
    height: 45px;
    filter: brightness(0) invert(1); /* E bën logon të bardhë nëse është e zezë */
  }

  .footer-logo-text {
    font-family: 'Syne', sans-serif;
    font-weight: 800;
    font-size: 24px;
    color: #ffffff;
  }

  .footer-logo-text span {
    color: #e63946; /* Ngjyra accent e kuqe */
  }

  .footer-desc {
    font-size: 15px;
    line-height: 1.6;
    color: #a0a0a0; /* Ngjyrë hiri për përshkrimin */
    max-width: 320px;
  }

  .footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .footer-links li {
    margin-bottom: 12px;
  }

  .footer-links a {
    text-decoration: none;
    color: #a0a0a0;
    font-size: 15px;
    transition: 0.3s;
    display: inline-block;
  }

  .footer-links a:hover {
    color: #e63946;
    transform: translateX(5px);
  }

  .footer-contact {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .footer-contact li {
    display: flex;
    gap: 12px;
    margin-bottom: 15px;
    color: #a0a0a0;
    font-size: 15px;
  }

  .footer-contact strong {
    color: #ffffff;
    font-weight: 600;
  }

  /* IKONAT SOCIALE */
  .footer-socials {
    display: flex;
    gap: 15px;
    margin-top: 25px;
  }

  .footer-social-link {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.05);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    text-decoration: none;
    transition: 0.3s;
    border: 1px solid rgba(255, 255, 255, 0.1);
    font-size: 18px;
  }

  .footer-social-link:hover {
    background: #e63946;
    color: #ffffff;
    transform: translateY(-5px);
    border-color: #e63946;
  }

  .footer-bottom {
    max-width: 1400px;
    margin: 80px auto 0 auto;
    padding: 30px 32px 0 32px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 14px;
    color: #666666;
    .footer-bottom {
  max-width: 1400px;
  margin: 80px auto 0 auto;
  padding: 30px 32px 0 32px;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  display: flex;
  justify-content: space-between; /* Shpërndan elementet: majtas, mes, djathtas */
  align-items: center;
  font-size: 13px;
  color: #666666;
}

.footer-legal {
  display: flex;
  align-items: center;
  gap: 15px;
}

.footer-legal a {
  color: #666666;
  text-decoration: none;
  transition: 0.3s;
}

.footer-legal a:hover {
  color: #e63946; /* Ngjyra accent kur dërgon miun sipër */
}

.footer-legal .separator {
  color: rgba(255, 255, 255, 0.1);
  font-size: 10px;
}

/* Rregullimi për pajisje mobile */
@media (max-width: 900px) {
  .footer-bottom {
    flex-direction: column;
    gap: 15px;
    text-align: center;
    padding-bottom: 30px;
  }
  
  .footer-legal {
    order: 2; /* I vendos politikat në mes në mobile */
  }
}
  }

  @media (max-width: 1024px) {
    .footer-container { grid-template-columns: 1fr 1fr; gap: 40px; }
    .footer-bottom { flex-direction: column; text-align: center; gap: 15px; }
  }

  @media (max-width: 600px) {
    .footer-container { grid-template-columns: 1fr; }
  }
</style>

<footer>
  <div class="footer-container">
    <div class="footer-col">
      <a href="index.php" class="footer-logo">
        <img src=".\images\Liza logo.png" alt="LIZA-R">
        <div class="footer-logo-text">LIZA<span>-R</span></div>
      </a>
      <p class="footer-desc">
        Lidhja me Interes Zhvillimor për të Ardhmen e Rinisë. Ne angazhohemi për fuqizimin e të rinjve përmes edukimit, kulturës dhe sportit.
      </p>
      <div class="footer-socials">
        <a href="https://www.facebook.com/lizargjilan/" class="footer-social-link"><i class="fab fa-facebook-f"></i></a>
        <a href="https://www.instagram.com/ojqliza/" class="footer-social-link"><i class="fab fa-instagram"></i></a>
      </div>
    </div>

    <div class="footer-col">
      <h4>Navigimi</h4>
      <ul class="footer-links">
        <li><a href="index.php">Ballina</a></li>
        <li><a href="rreth-nesh.php">Rreth Organizatës</a></li><li><a href="galeria.php">Galeria</a></li>
        <h4>Programet Ndërkombëtare</h4>
    <ul class="footer-links">
        <li><a href="aktivitetet.php?kat=erasmus">Erasmus+</a></li>
        <li><a href="aktivitetet.php?kat=esc">European Solidarity Corps (ESC)</a></li>
    </ul>
        
      </ul>
    </div>

  <div class="footer-col">
  <h4>Aktivitetet</h4>
  <ul class="footer-links">
    <li><a href="kurset.php?kat=it-dizajn">Trajnime IT</a></li>
    <li><a href="aktivitetet.php?kat=rinore">Projekte Rinore</a></li>
    <li><a href="aktivitetet.php?kat=kulture">Kulturë & Art</a></li>
    <li><a href="kurset.php?kat=rrobaqepesi">Rrobaqepësi</a></li>
  </ul>
</div>

    <div class="footer-col">
      <h4>Kontakti</h4>
      <ul class="footer-contact">
        <li><span><strong>Adresa:</strong> Gjilan, Kosovë</span></li>
        <li><span><strong>Email:</strong> info@liza-r.org</span></li>
        <li><span><strong>Web:</strong> www.liza-r.org</span></li>
      </ul>
    </div>
  </div>

 <div class="footer-bottom">
  <div class="footer-copy">
    &copy; <?php echo date("Y"); ?> OJQ LIZA-R. Të gjitha të drejtat e rezervuara.
  </div>
  
  <div class="footer-legal">
    <a href="politika-privatesise.php">Politika e Privatësisë</a>
    <span class="separator">|</span>
    <a href="politika-cookies.php">Politika e Cookies</a>
  </div>


</div>
</footer>