<?php 
    $pageTitle = "Kryesia dhe Ekipi"; 
    include 'includes/db.php';
    include 'includes/header.php'; 
?>

<style>
    .page-content { padding: 120px 20px 80px; max-width: 1200px; margin: 0 auto; }
    
    .section-header { text-align: center; margin-bottom: 50px; }
    .section-title { font-family: 'Syne', sans-serif; font-size: 2.8rem; font-weight: 800; color: #1f2937; margin-bottom: 10px; }
    .section-subtitle { font-size: 1.1rem; color: #2563eb; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; }

    /* Stili për Kryesinë (Bordin) - Karta më të mëdha */
    .kryesia-wrapper { display: flex; flex-wrap: wrap; justify-content: center; gap: 40px; margin-bottom: 100px; }
    .leader-card { background: #fff; width: 340px; padding: 40px 30px; border-radius: 30px; text-align: center; box-shadow: 0 20px 40px rgba(37, 99, 235, 0.08); border: 1px solid #e2e8f0; transition: 0.4s; }
    .leader-card:hover { transform: translateY(-12px); border-color: #2563eb; }
    .leader-card img { width: 180px; height: 180px; border-radius: 50%; object-fit: cover; margin-bottom: 25px; border: 6px solid #f8fafc; box-shadow: 0 10px 20px rgba(0,0,0,0.05); }

    /* Stili për Ekipin - Grid standard */
    .team-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 30px; }
    .member-card { background: #fff; padding: 30px; border-radius: 20px; text-align: center; box-shadow: 0 10px 25px rgba(0,0,0,0.04); transition: 0.3s; border: 1px solid #f1f5f9; }
    .member-card:hover { transform: translateY(-8px); box-shadow: 0 15px 30px rgba(0,0,0,0.08); }
    .member-card img { width: 130px; height: 130px; border-radius: 50%; object-fit: cover; margin-bottom: 20px; border: 4px solid #f8fafc; }

    /* Elementet e përbashkëta */
    .name { font-size: 1.4rem; font-weight: 700; color: #1e293b; margin-bottom: 8px; }
    .position { color: #2563eb; font-weight: 600; font-size: 0.95rem; margin-bottom: 20px; display: block; }
    
    .cv-btn { 
        display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; 
        background: #f1f5f9; color: #1e293b; text-decoration: none; border-radius: 12px; 
        font-size: 14px; font-weight: 600; transition: 0.3s; 
    }
    .cv-btn:hover { background: #2563eb; color: #fff; }

    .divider { height: 1px; background: linear-gradient(to right, transparent, #e2e8f0, transparent); margin: 80px 0; }
</style>

<main class="page-content">

    <div class="section-header">
        <p class="section-subtitle">Udhëheqësit tanë</p>
        <h1 class="section-title">Bordi Drejtues</h1>
    </div>

    <div class="kryesia-wrapper">
        <?php
        $kryesia_query = $conn->query("SELECT * FROM kryesia WHERE lloji = 'kryesia' ORDER BY renditja ASC");
        if($kryesia_query->num_rows > 0):
            while($row = $kryesia_query->fetch_assoc()):
        ?>
            <div class="leader-card">
                <img src="images/anetaret/<?php echo $row['foto']; ?>" alt="<?php echo $row['emri']; ?>">
                <div class="name"><?php echo htmlspecialchars($row['emri'] . " " . $row['mbiemri']); ?></div>
                <span class="position"><?php echo htmlspecialchars($row['pozita']); ?></span>
                <a href="uploads/cv/<?php echo $row['cv_pdf']; ?>" target="_blank" class="cv-btn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                    Shiko CV-në
                </a>
            </div>
        <?php 
            endwhile;
        else:
            echo "<p style='color:#94a3b8;'>Nuk ka anëtarë të kryesisë të regjistruar.</p>";
        endif; 
        ?>
    </div>

    <div class="divider"></div>

    <div class="section-header">
        <p class="section-subtitle">Forca jonë punëtore</p>
        <h2 class="section-title">Ekipi Ekzekutiv</h2>
    </div>

    <div class="team-grid">
        <?php
        $ekipi_query = $conn->query("SELECT * FROM kryesia WHERE lloji = 'ekipi' ORDER BY renditja ASC");
        if($ekipi_query->num_rows > 0):
            while($row = $ekipi_query->fetch_assoc()):
        ?>
            <div class="member-card">
                <img src="images/anetaret/<?php echo $row['foto']; ?>" alt="<?php echo $row['emri']; ?>">
                <div class="name" style="font-size: 1.2rem;"><?php echo htmlspecialchars($row['emri'] . " " . $row['mbiemri']); ?></div>
                <span class="position"><?php echo htmlspecialchars($row['pozita']); ?></span>
                <a href="uploads/cv/<?php echo $row['cv_pdf']; ?>" target="_blank" class="cv-btn">
                    Shiko CV-në
                </a>
            </div>
        <?php 
            endwhile;
        else:
            echo "<p style='color:#94a3b8; grid-column: 1/-1;'>Nuk ka anëtarë të ekipit të regjistruar.</p>";
        endif; 
        ?>
    </div>

</main>

<?php include 'includes/footer.php'; ?>