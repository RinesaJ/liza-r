<?php 
include 'includes/header.php'; 
include 'includes/db.php';
?>

<style>
    :root {
        --side-padding: 80px;
        --accent: #ff6b35;
        --ink: #0d0d0d;
        --glass-bg: rgba(255,255,255,0.95);
        --glass-border: rgba(255,255,255,0.8);
    }

    .lajmet-hero {
        background: linear-gradient(135deg, #fdfcf9 0%, #f8f7f4 100%);
        padding: 100px var(--side-padding) 40px;
        text-align: center;
    }

    .lajmet-hero h1 {
        font-family: 'Syne', sans-serif;
        font-size: 3rem;
        font-weight: 800;
        color: var(--ink);
        margin: 0;
    }

    .lajmet-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 var(--side-padding) 80px;
    }

    .filter-bar {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-bottom: 40px;
        flex-wrap: wrap;
    }

    .filter-btn {
        padding: 10px 20px;
        border-radius: 50px;
        background: var(--glass-bg);
        font-family: 'Syne', sans-serif;
        font-weight: 700;
        font-size: 0.75rem;
        text-decoration: none;
        color: var(--ink);
        border: 1px solid #eee;
        transition: 0.3s;
    }

    .filter-btn:hover, .filter-btn.active {
        background: var(--accent);
        color: #fff;
        border-color: var(--accent);
    }

    /* 🔥 NEWS GRID - CARDS KOMPAKTE */
    .news-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
    }

    .news-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid var(--glass-border);
        overflow: hidden;
        transition: 0.3s;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .news-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.1);
    }

    .card-image {
        height: 180px;
        overflow: hidden;
    }

    .card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .card-body {
        padding: 24px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .card-date {
        font-size: 0.7rem;
        color: var(--accent);
        font-weight: 700;
        margin-bottom: 10px;
        display: block;
    }

    .card-body h3 {
        font-family: 'Syne', sans-serif;
        font-size: 1.15rem;
        font-weight: 800;
        line-height: 1.3;
        margin-bottom: 12px;
        color: var(--ink);
    }

    .card-text {
        font-size: 0.88rem;
        color: #666;
        line-height: 1.5;
        margin-bottom: 20px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* LEXO MË SHUMË BUTTON */
    .read-more {
        font-family: 'Syne', sans-serif;
        font-weight: 800;
        font-size: 0.65rem;
        text-transform: uppercase;
        color: var(--accent);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 18px;
        background: rgba(255,107,53,0.08);
        border-radius: 50px;
        border: 1px solid rgba(255,107,53,0.15);
        transition: 0.3s;
        margin-top: auto;
        width: fit-content;
    }

    .news-card:hover .read-more {
        background: var(--accent);
        color: #fff;
    }

    /* DROPDOWN */
    .filter-group { position: relative; display: inline-block; }
    .dropdown-content {
        display: none;
        position: absolute;
        top: 105%;
        left: 0;
        background: #fff;
        min-width: 190px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border-radius: 12px;
        z-index: 100;
        padding: 8px;
        border: 1px solid #eee;
    }
    .dropdown-content a {
        color: var(--ink);
        padding: 10px 14px;
        text-decoration: none;
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        border-radius: 8px;
    }
    .dropdown-content a:hover { background: #fff5f2; color: var(--accent); }
    .filter-group:hover .dropdown-content { display: block; }

    @media (max-width: 1024px) { .news-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 768px) { .news-grid { grid-template-columns: 1fr; } .lajmet-container { --side-padding: 20px; } }
</style>

<section class="lajmet-hero">
    <h1>Lajmet</h1>
</section>

<div class="lajmet-container">
    <div class="filter-bar">
        <a href="lajmet.php" class="filter-btn <?php echo !isset($_GET['kat']) ? 'active' : ''; ?>">Të Gjitha</a>
        <a href="lajmet.php?kat=Aktivitet" class="filter-btn <?php echo (isset($_GET['kat']) && $_GET['kat'] == 'Aktivitet') ? 'active' : ''; ?>">Aktivitete</a>
        <a href="lajmet.php?kat=Lajm" class="filter-btn <?php echo (isset($_GET['kat']) && $_GET['kat'] == 'Lajm') ? 'active' : ''; ?>">Lajme</a>

        <div class="filter-group">
            <?php 
                $kurset_vargu = ['it-dizajn', 'rrobaqepesi', 'serra-bujqesi', 'makina-qepjeje', 'bursa-ekselence'];
                $is_kurs_active = (isset($_GET['kat']) && (in_array($_GET['kat'], $kurset_vargu) || $_GET['kat'] == 'Konkurs'));
            ?>
            <a href="#" class="filter-btn <?php echo $is_kurs_active ? 'active' : ''; ?>">Konkurset ▾</a>
            <div class="dropdown-content">
                <a href="lajmet.php?kat=it-dizajn">IT & Dizajn</a>
                <a href="lajmet.php?kat=rrobaqepesi">Rrobaqepësi</a>
                <a href="lajmet.php?kat=serra-bujqesi">Serra & Bujqësi</a>
                <a href="lajmet.php?kat=makina-qepjeje">Makina Qepjeje</a>
                <a href="lajmet.php?kat=bursa-ekselence">Bursa Ekselence</a>
                <hr style="border:0; border-top:1px solid #eee; margin:5px 0;">
                <a href="lajmet.php?kat=Konkurs">Të gjitha Konkurset</a>
            </div>
        </div>
        <a href="lajmet.php?kat=Trajnim" class="filter-btn <?php echo (isset($_GET['kat']) && $_GET['kat'] == 'Trajnim') ? 'active' : ''; ?>">Trajnime</a>
    </div>

    <div class="news-grid">
        <?php
        if (isset($conn)) {
            $filter = "";
            if(isset($_GET['kat'])) {
                $kat = mysqli_real_escape_string($conn, $_GET['kat']);
                if ($kat == 'Konkurs') {
                    $lista = "'" . implode("','", $kurset_vargu) . "', 'Konkurs'";
                    $filter = " WHERE kategoria IN ($lista) ";
                } else {
                    $filter = " WHERE kategoria = '$kat' ";
                }
            }

            $query = "SELECT * FROM posts $filter ORDER BY COALESCE(data_aktivitetit, data) DESC";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $kategorite_kurseve = ['rrobaqepesi', 'it-dizajn', 'serra-bujqesi', 'makina-qepjeje', 'bursa-ekselence'];
                    $folder = (in_array($row['kategoria'], $kategorite_kurseve)) ? 'uploads/posts/' : 'uploads/';
                    $img = !empty($row['foto']) ? $folder . $row['foto'] : 'assets/img/default.jpg';
                    
                    $data_val = !empty($row['data_aktivitetit']) ? $row['data_aktivitetit'] : $row['data'];
                    $data_shfaqjes = date('d M Y', strtotime($data_val));
                    
                    $pershkrimi = strip_tags($row['pershkrimi']);
                    ?>
                    
                    <a href="lajmi-detaje.php?id=<?php echo $row['id']; ?>" class="news-card">
                        <div class="card-image">
                            <img src="<?php echo $img; ?>" alt="">
                        </div>
                        <div class="card-body">
                            <span class="card-date">📅 <?php echo $data_shfaqjes; ?></span>
                            <h3><?php echo htmlspecialchars($row['titulli']); ?></h3>
                            <p class="card-text"><?php echo $pershkrimi; ?></p>
                            <div class="read-more">Lexo më shumë</div>
                        </div>
                    </a>
                    <?php
                }
            } else {
                echo "<div style='grid-column: 1/-1; text-align:center; padding: 50px;'><h4>Nuk u gjet asnjë postim.</h4></div>";
            }
        }
        ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>