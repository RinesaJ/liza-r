<?php 
include 'includes/header.php'; 
?>

<style>
    :root {
        --side-padding: 80px;
        --accent: #ff6b35;
        --ink: #0d0d0d;
        --glass-bg: rgba(255,255,255,0.95);
        --glass-border: rgba(255,255,255,0.8);
        --blue-accent: #1e40af;
    }

    body {
        background: linear-gradient(135deg, #fdfcf9 0%, #f5f3ee 50%, #e8e5dc 100%);
        font-family: 'DM Sans', sans-serif;
    }

    /* HERO */
    .contact-hero {
        background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(248,247,244,0.8) 100%);
        backdrop-filter: blur(20px);
        padding: 160px var(--side-padding) 80px;
        text-align: center;
        position: relative;
    }

    .hero-eyebrow {
        color: var(--accent);
        font-family: 'Syne', sans-serif;
        font-weight: 800;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 2.5px;
        margin-bottom: 16px;
        display: block;
    }

    .contact-hero h1 {
        font-family: 'Syne', sans-serif;
        font-size: 4rem;
        font-weight: 800;
        color: var(--ink);
        margin-bottom: 20px;
        letter-spacing: -0.04em;
    }

    /* GRID */
    .contact-grid {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 var(--side-padding) 120px;
        display: grid;
        grid-template-columns: 1fr 1.5fr;
        gap: 60px;
        align-items: start;
    }

    /* INFO CARDS */
    .info-card {
        background: var(--glass-bg);
        border-radius: 24px;
        border: 1px solid var(--glass-border);
        padding: 40px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.05);
        margin-bottom: 25px;
    }

    .info-icon {
        width: 60px; height: 60px; border-radius: 18px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.8rem; margin-bottom: 20px;
        background: linear-gradient(135deg, var(--accent), var(--blue-accent));
        color: #fff;
    }

    .info-title { font-family: 'Syne', sans-serif; font-size: 1.3rem; font-weight: 800; margin-bottom: 10px; }
    .info-text { color: #666; line-height: 1.6; }

    /* FORM */
    .contact-form {
        background: #fff;
        border-radius: 32px;
        padding: 50px;
        box-shadow: 0 30px 70px rgba(0,0,0,0.08);
    }

    .form-title { font-family: 'Syne', sans-serif; font-size: 1.8rem; margin-bottom: 35px; }
    .form-group { margin-bottom: 25px; margin-right: 40px; }

    .form-group input, .form-group textarea {
        width: 100%; padding: 18px 22px;
        border: 2px solid #f1f5f9; border-radius: 15px;
        background: #f8fafc; font-size: 1rem; transition: 0.3s;
    }

    .form-group input:focus, .form-group textarea:focus {
        outline: none; border-color: var(--accent); background: #fff;
    }

    .submit-btn {
        width: 100%; padding: 18px;
        background: linear-gradient(135deg, var(--accent), var(--blue-accent));
        color: #fff; border: none; border-radius: 15px;
        font-family: 'Syne', sans-serif; font-weight: 800; font-size: 1rem;
        text-transform: uppercase; cursor: pointer; transition: 0.4s;
    }

    .submit-btn:hover { transform: translateY(-3px); box-shadow: 0 15px 35px rgba(255,107,53,0.3); }

    .alert { padding: 15px; border-radius: 12px; margin-bottom: 25px; text-align: center; font-weight: 600; }
    .alert-success { background: #dcfce7; color: #166534; }
    .alert-error { background: #fee2e2; color: #991b1b; }
/* IKONAT SOCIALE - RREGULLIMI I DUKSHMËRISË */
.footer-socials {
  display: flex;
  gap: 15px;
  margin-top: 25px;
  flex-wrap: wrap;
}

.footer-social-link {
  width: 44px;
  height: 44px;
  border-radius: 50%;
  background: #f1f5f9; /* Një gri shumë e lehtë që të dallohet rrethi */
  display: flex;
  align-items: center;
  justify-content: center;
  color: #e63946 !important; /* NGJYRA E IKONËS (E KUQE) - E bëjmë !important që të mos dalë e bardhë */
  text-decoration: none;
  transition: all 0.3s ease;
  border: 1px solid #e2e8f0;
}

.footer-social-link i {
  font-size: 18px;
  display: block;
}

/* EFEKTI HOVER */
.footer-social-link:hover {
  background: #e63946; /* Sfondi bëhet i kuq */
  color: #ffffff !important; /* Ikona bëhet e bardhë vetëm tani */
  transform: translateY(-5px);
  border-color: #e63946;
  box-shadow: 0 8px 20px rgba(230, 57, 70, 0.3);
}
@media (max-width: 768px) {
  .footer-socials {
    justify-content: center;
  }
}
    @media (max-width: 992px) { .contact-grid { grid-template-columns: 1fr; } }
</style>

<main>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <section class="contact-hero">
        <span class="hero-eyebrow">Na Kontaktoni</span>
        <h1>Le të bisedojmë</h1>
    </section>

    <div class="contact-grid">
        <div class="info-sidebar">
            <div class="info-card">
                <div class="info-icon">📍</div>
                <h3 class="info-title">Adresa Jonë</h3>
                <p class="info-text">Rruga Gjinollët98, "Rezidenca Daku" Kati VI, nr. 504<br>Gjilan, 60000, Kosovë</p>
                <div class="footer-socials">
    <a href="https://www.facebook.com/lizargjilan/" class="footer-social-link" target="_blank">
        <i class="fab fa-facebook-f"></i>
    </a>
    <a href="https://www.instagram.com/ojqliza/" class="footer-social-link" target="_blank">
        <i class="fab fa-instagram"></i>
    </a>
</div>
            </div>

            <div class="info-card">
                <div class="info-icon">✉️</div>
                <h3 class="info-title">Email Zyrtar</h3>
                <p class="info-text">info@liza-r.org<br>Shtypni formularin për mesazh.</p>
            </div>
        </div>

        <div class="contact-form">
            <h3 class="form-title">Dërgo një mesazh</h3>

            <?php if(isset($_GET['status'])): ?>
                <?php if($_GET['status'] == 'success'): ?>
                    <div class="alert alert-success">✅ Mesazhi juaj u dërgua me sukses!</div>
                <?php else: ?>
                    <div class="alert alert-error">❌ Pati një problem. Ju lutem provoni përsëri.</div>
                <?php endif; ?>
            <?php endif; ?>

            <form action="send-email.php" method="POST" id="contactForm">
                <div class="form-group">
                    <input type="text" name="name" placeholder="Emri dhe Mbiemri" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="Adresa juaj email" required>
                </div>
                <div class="form-group">
                    <input type="text" name="subject" placeholder="Subjekti i mesazhit" required>
                </div>
                <div class="form-group">
                    <textarea name="message" rows="5" placeholder="Si mund t'ju ndihmojmë?" required></textarea>
                </div>
                <button type="submit" class="submit-btn" id="btnSubmit">Dërgo Mesazhin</button>
            </form>
        </div>
    </div>
</main>

<script>
    document.getElementById('contactForm').addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmit');
        btn.innerHTML = 'Duke u dërguar...';
        btn.style.opacity = '0.7';
        btn.style.pointerEvents = 'none';
    });
</script>

<?php include 'includes/footer.php'; ?>