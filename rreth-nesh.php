<?php 
include 'includes/header.php'; 
include 'includes/db.php';
?>

<style>
    :root {
        --side-padding: 80px;
        --accent: #ff6b35;
        --ink: #0d0d0d;
    }

    .about-page-hero {
        background: linear-gradient(135deg, #fdfcf9 0%, #f8f7f4 100%);
        padding: 140px var(--side-padding) 60px;
        text-align: center;
    }

    .about-section {
        padding: 80px var(--side-padding);
        max-width: 1300px;
        margin: 0 auto;
    }

    .about-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
    }

    .about-eyebrow {
        color: var(--accent);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 0.8rem;
        margin-bottom: 15px;
    }

    .about-title {
        font-family: 'Syne', sans-serif;
        font-size: 3.5rem;
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 30px;
        color: var(--ink);
    }

    .about-title em {
        color: var(--accent);
        font-style: normal;
    }

    .about-text {
        font-size: 1.1rem;
        line-height: 1.7;
        color: #444;
        margin-bottom: 20px;
    }

    .pillar-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .pillar {
        background: #fff;
        padding: 30px;
        border-radius: 20px;
        border: 1px solid #eee;
        transition: 0.3s;
    }

    .pillar:hover {
        transform: translateY(-5px);
        border-color: var(--accent);
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .pillar-icon {
        font-size: 2rem;
        margin-bottom: 15px;
        display: block;
    }

    .pillar-name {
        font-weight: 800;
        font-size: 1.2rem;
        margin-bottom: 10px;
        font-family: 'Syne', sans-serif;
    }

    .pillar-desc {
        font-size: 0.9rem;
        color: #666;
        line-height: 1.5;
    }

    @media (max-width: 992px) {
        .about-container { grid-template-columns: 1fr; }
        .about-title { font-size: 2.5rem; }
        .about-section { --side-padding: 30px; }
    }
</style>

<section class="about-page-hero">
    <div class="about-eyebrow">Njihuni me ne</div>
    <h1 style="font-family: 'Syne', sans-serif; font-size: 3rem; font-weight: 800;">Rreth Organizatës</h1>
</section>

<section class="about-section">
    <div class="about-container">
        <div class="about-left">
            <h2 class="about-title">Investojmë në<br><em>të ardhmen</em><br>e rinisë</h2>
            <p class="about-text">
                LIZA-R — Lidhja me Interes Zhvillimor për të Ardhmen e Rinisë — është një organizatë joqeveritare e themeluar në Gjilan, Kosovë. Misioni ynë është fuqizimi i të rinjve nëpërmjet edukimit, trajnimeve profesionale dhe bashkëpunimit ndërkombëtar.
            </p>
            <p class="about-text">
                Punojmë ngushtë me institucione vendore dhe ndërkombëtare si IOM, UNICEF, dhe Bashkimi Europian për të krijuar programe gjithëpërfshirëse dhe ndikuese.
            </p>
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

<?php include 'includes/footer.php'; ?>