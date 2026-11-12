<?php 
include 'includes/header.php'; 
?>

<style>
    :root {
        --side-padding: 80px;
        --accent: #ff6b35;
        --ink: #0d0d0d;
        --warm-white: #fdfcf9;
        --glass-bg: rgba(255,255,255,0.95);
        --glass-border: rgba(255,255,255,0.8);
    }

    body {
        background: linear-gradient(135deg, var(--warm-white) 0%, #f8f7f4 100%);
        font-family: 'DM Sans', sans-serif;
    }

    /* 🔥 STRATEGY HERO */
    .strategy-hero {
        background: linear-gradient(135deg, var(--glass-bg) 0%, rgba(248,247,244,0.8) 100%);
        backdrop-filter: blur(20px);
        padding: 160px var(--side-padding) 100px;
        text-align: center;
        position: relative;
        border-bottom: 1px solid rgba(229,229,229,0.5);
    }

    .strategy-hero::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--glass-border), transparent);
    }

    .hero-eyebrow {
        color: var(--accent);
        font-family: 'Syne', sans-serif;
        font-weight: 800;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 3px;
        margin-bottom: 20px;
        display: block;
        animation: fadeInUp 0.8s ease;
    }

    .strategy-hero h1 {
        font-family: 'Syne', sans-serif;
        font-size: 4rem;
        font-weight: 800;
        line-height: 0.95;
        background: linear-gradient(135deg, var(--ink) 0%, #333 70%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0 0 28px 0;
        letter-spacing: -0.04em;
        animation: fadeInUp 1s ease 0.2s both;
    }

    /* STRATEGY CONTAINER */
    .strategy-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 0 var(--side-padding) 140px;
    }

    .strategy-content {
        background: var(--glass-bg);
        backdrop-filter: blur(20px);
        border-radius: 32px;
        border: 1px solid var(--glass-border);
        padding: 80px;
        box-shadow: 0 32px 100px rgba(0,0,0,0.08);
        position: relative;
        overflow: hidden;
    }

    .strategy-content::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, var(--accent), transparent, var(--accent));
    }

    /* TITLES */
    .strategy-subtitle {
        font-family: 'Syne', sans-serif;
        font-size: 2.4rem;
        font-weight: 800;
        color: var(--ink);
        margin: 80px 0 32px 0;
        position: relative;
        padding-bottom: 16px;
    }

    .strategy-subtitle::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, var(--accent), transparent);
        border-radius: 2px;
    }

    .strategy-subsubtitle {
        font-family: 'Syne', sans-serif;
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--ink);
        margin: 48px 0 24px 0;
        padding-left: 24px;
        position: relative;
        display: flex;
        align-items: center;
    }

    .strategy-subsubtitle::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        width: 6px;
        height: 6px;
        background: var(--accent);
        border-radius: 50%;
        transform: translateY(-50%);
        box-shadow: 0 0 0 4px rgba(255,107,53,0.2);
    }

    /* CONTENT */
    .strategy-text {
        font-size: 1.15rem;
        line-height: 1.85;
        color: #444;
        margin-bottom: 32px;
        font-weight: 400;
    }

    .strategy-intro {
        font-size: 1.2rem;
        font-weight: 500;
        color: var(--ink);
        margin-bottom: 40px;
        text-align: center;
        opacity: 0.9;
    }

    /* LISTS */
    .strategy-list {
        list-style: none;
        padding: 0;
        margin: 0 0 40px 0;
    }

    .strategy-list li {
        position: relative;
        padding-left: 32px;
        margin-bottom: 20px;
        font-size: 1.1rem;
        line-height: 1.7;
        color: #555;
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .strategy-list li::before {
        content: "➤";
        position: absolute;
        left: 0;
        top: 2px;
        color: var(--accent);
        font-weight: bold;
        font-size: 1.1rem;
    }

    .strategy-list.bullet li::before {
        content: "●";
        font-size: 0.8rem;
        top: 4px;
    }

    /* RESPONSIVE */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 1024px) {
        .strategy-hero h1 { font-size: 3.2rem; }
        .strategy-content { padding: 60px 40px; margin: 0 20px; }
        .strategy-subtitle { font-size: 2rem; }
    }

    @media (max-width: 768px) {
        .strategy-hero { padding: 100px 20px 60px; }
        .strategy-hero h1 { font-size: 2.4rem; }
        .strategy-content { padding: 40px 24px; margin: 0 12px; border-radius: 20px; }
        .strategy-subtitle { font-size: 1.7rem; margin-top: 48px; }
        .strategy-subsubtitle { font-size: 1.4rem; padding-left: 20px; }
        .strategy-text { font-size: 1.05rem; }
    }
</style>

<main>
    <!-- Hero -->
    <section class="strategy-hero">
        <span class="hero-eyebrow">Strategjia e Vjetër</span>
        <h1>Strategjia 2015-2020</h1>
    </section>

    <!-- Content -->
    <div class="strategy-container">
        <div class="strategy-content">
            <!-- Vizioni, Misioni -->
            <div class="strategy-intro">
                Organizata është themeluar me qëllim të integrimit, fuqizimit dhe ngritjes së kapaciteteve të rinisë në procese demokratike.
            </div>

            <h2 class="strategy-subtitle">Vizioni, Misioni dhe Qëllimi</h2>
            <p class="strategy-text">
                Për t'i përmbushur qëllimet e saj, organizata do t'i ndërmarrë, por nuk do të kufizohet vetëm në këto aktivitete të mëposhtme:
            </p>

            <ul class="strategy-list">
                <li>Trajnime (edukim jo formal), në lidhje me demokratizimin, të drejtave të rinisë, planifikimin dhe menaxhimin e projekteve, lidershipin, edukimin shëndetësor, sëmundje virusale, dukuri negative.</li>
                <li>Për t'i ndihmuar të varfërve (ndihmë sociale të të rinjve).</li>
                <li>Në integrimin e personave me aftësi të kufizuara në shoqëri.</li>
                <li>Organizojmë shfaqje për t'i mbledhur së bashku studentët dhe etnitete të ndryshme.</li>
                <li>Organizoj mbledhje/debate për t'i diskutuar ose adresuar çështjet e interesave të grupeve rinore të ndryshme: hulumton për t'i identifikuar çështjet me interes apo që i brengosin të rinjtë në bashkësinë e tyre.</li>
                <li>Organizimin e ngjarjeve/garave/lojërave sportive.</li>
                <li>Krijimi i broshurave, posterave, për të bërë publike një ide/ngjarje/aksion.</li>
                <li>Takime me përfaqësues të institucioneve publike, organizata lokale dhe ndërkombëtare, media.</li>
                <li>Organizon ngjarje së bashku me rininë si psh: dita e pastrimit në komunë, pastrimi i parkut, rrugëve, shkollave, ekspozita të qytetit.</li>
                <li>Prodhon material informativë.</li>
                <li>Udhtëheqjen e fushatave për ngritjen e vetëdijes.</li>
                <li>Udhtëheqjen e fushatave avokuese.</li>
            </ul>

            <h2 class="strategy-subtitle">Projektet paraprake</h2>
            <ul class="strategy-list">
                <li>LIZA-R është formuar në vitin 2007. Prej atëherë e deri më sot ka realizuar dhe është duke realizuar këto projekte: Projektin "Pajtimin ndër-etnik dhe zhvillimi i komunitetit" të financuar nga Ministria e Bujqësisë, Pylltarisë dhe Zhvillimit Rural, Kuvendi Komunal i Gjilanit, Ministria e Kulturës, Rinisë dhe Sporteve; Projektin "Idea për themelimin e Universitetit Publik të Gjilanit" nga Ministria e Arsimit, Shkencës dhe Teknologjisë. Projekte me Qendrën Rinore të financuara nga Banka Botërore, Projektin në involvimin e të rinjve me nevoja të veçanta nga Ambasada Italiane, projekte që janë në partneritet të implementimit me programet e USAID dhe SIDA me OJQ vendore.</li>
                <li>Aktivitete dhe fushata avokuese për ngritjen e nivelit të vendimmarrjes së të rinjve në institucione, projekte për ngritje të kapaciteteve funksionuese, projekti për të rinjtë e zonave rurale të financuar nga "Kuvendi Komunal dhe MKRS", dhe shumë projekte të tjera të rëndësishme për të rinjtë e Komunës sonë.</li>
            </ul>

            <h2 class="strategy-subtitle">Klientët dhe partnerët</h2>
            <p class="strategy-text">
                Klientët e LIZA-R janë të rinjtë pa dallim feje, etnije, gjinie, race a ndonjë përcaktim tjetër. Partnerët tanë janë: Organizatat joqeveritare që merren me të rinjtë, Institucionet komunale dhe qendrore si dhe donatorët e ndryshëm.
            </p>

            <h2 class="strategy-subtitle">Stafi (personeli)</h2>
            <p class