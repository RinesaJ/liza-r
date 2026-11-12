<?php 
// Përfshijmë header-in dhe lidhjen me DB
include 'includes/header.php'; 
include 'includes/db.php';

// Marrja e ID dhe siguria
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$query = "SELECT * FROM posts WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($res) === 0) {
    header("Location: lajmet.php");
    exit();
}

$lajmi = mysqli_fetch_assoc($res);

// --- LOGJIKA E DINAMIKE E FOLDEREVE ---
$kategorite_kurseve = ['rrobaqepesi', 'it-dizajn', 'serra-bujqesi', 'makina-qepjeje', 'bursa-ekselence'];
$folder = (in_array($lajmi['kategoria'], $kategorite_kurseve)) ? 'uploads/posts/' : 'uploads/';

$img_path = !empty($lajmi['foto']) ? $folder . $lajmi['foto'] : 'assets/img/default.jpg';

// Rregullimi i datës (kontrollon të dyja kolonat e mundshme)
$data_raw = !empty($lajmi['data_aktivitetit']) ? $lajmi['data_aktivitetit'] : $lajmi['data'];
$data_formatuar = date('d M Y', strtotime($data_raw));

$kategoria = !empty($lajmi['kategoria']) ? $lajmi['kategoria'] : 'Lajm';
?>

<style>
    :root {
        --accent: #ff6b35; 
        --ink: #0d0d0d;
        --blue-accent: #1e40af; 
        --glass-bg: rgba(255,255,255,0.95);
        --glass-border: rgba(255,255,255,0.8);
        --side-padding: 80px;
    }

    body {
        background: linear-gradient(135deg, #fdfcf9 0%, #f8f7f4 100%);
        font-family: 'DM Sans', sans-serif;
    }

    .post-hero {
        background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
        padding: 140px var(--side-padding) 80px;
        position: relative;
        overflow: hidden;
    }

    .post-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--glass-border), transparent);
    }

    .post-container {
        max-width: 900px;
        margin: 0 auto;
        position: relative;
        z-index: 2;
    }

    .post-category {
        display: inline-flex;
        align-items: center;
        background: linear-gradient(135deg, var(--accent), #e55a2b);
        color: #fff;
        font-family: 'Syne', sans-serif;
        font-size: 0.75rem;
        font-weight: 800;
        padding: 10px 20px;
        border-radius: 50px;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        box-shadow: 0 8px 24px rgba(255,107,53,0.4);
        margin-bottom: 24px;
    }

    .post-title {
        font-family: 'Syne', sans-serif;
        font-size: 3.5rem;
        font-weight: 800;
        line-height: 1.1;
        color: var(--ink);
        margin: 0 0 32px 0;
        letter-spacing: -0.04em;
    }

    .post-meta {
        display: flex;
        align-items: center;
        gap: 24px;
        margin-bottom: 48px;
        font-size: 0.9rem;
        color: #666;
    }

    .post-date {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .post-featured-image {
        width: 100%;
        height: auto;
        max-height: 600px;
        object-fit: cover;
        border-radius: 24px;
        box-shadow: 0 40px 120px rgba(0,0,0,0.15);
        margin-bottom: 60px;
    }

    .post-content {
        font-size: 1.15rem;
        line-height: 1.85;
        color: #333;
        max-width: 800px;
        margin: 0 auto;
        padding-bottom: 100px;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        padding: 16px 32px;
        background: var(--glass-bg);
        border: 2px solid var(--glass-border);
        border-radius: 50px;
        color: var(--ink);
        font-family: 'Syne', sans-serif;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.3s;
        margin-top: 40px;
    }

    .back-btn:hover {
        background: var(--accent);
        color: #fff;
        transform: translateY(-4px);
    }

@media (max-width: 768px) {
    /* Rregullimi i hero section */
    .post-hero { 
        padding: 120px 20px 40px; /* Shtojmë hapësirë lart që të mos mbivendoset me navbar */
    }

    /* Rregullimi i titullit */
    .post-title { 
        font-size: 2.2rem; 
        line-height: 1.2;
        margin-bottom: 20px;
    }

    /* KËTU ËSHTË RREGULLIMI PËR PËRSHKRIMIN (CONTENT) */
    .post-content {
        font-size: 1.05rem; /* Zvogëlojmë pak madhësinë e shkronjave */
        line-height: 1.7;    /* Ngushtojmë pak hapësirën mes rreshtave */
        padding: 0 5px 60px; /* I japim pak frymëmarrje anash */
        text-align: left;    /* Sigurohemi që është i rreshtuar majtas */
    }

    /* Rregullimi i imazhit kryesor */
    .post-featured-image {
        border-radius: 16px; /* Kthesa më të vogla në mobile */
        margin-bottom: 30px;
    }

    /* Meta të dhënat (data, kategoria) */
    .post-meta {
        flex-direction: column; /* I vendosim njëra nën tjetrën nëse janë shumë */
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 30px;
    }

    .back-btn {
        width: 100%; /* Butoni "Kthehu" zë të gjithë gjerësinë për t'u klikuar më lehtë */
        justify-content: center;
        padding: 14px 24px;
    }
}
</style>

<main>
    <section class="post-hero">
        <div class="post-container">
            <div class="post-category"><?php echo htmlspecialchars($kategoria); ?></div>
            
            <h1 class="post-title"><?php echo htmlspecialchars($lajmi['titulli']); ?></h1>
            
            <div class="post-meta">
                <div class="post-date">
                    <span style="color: var(--accent);">📅</span> <?php echo $data_formatuar; ?>
                </div>
            </div>
            
            <img src="<?php echo $img_path; ?>" alt="<?php echo htmlspecialchars($lajmi['titulli']); ?>" class="post-featured-image">
        </div>
    </section>

    <div class="post-container">
        <article class="post-content">
            <?php echo $lajmi['pershkrimi']; ?>
            
            <br>
            <a href="lajmet.php" class="back-btn">
                ← Kthehu te Lajmet
            </a>
        </article>
    </div>
</main>

<?php include 'includes/footer.php'; ?>