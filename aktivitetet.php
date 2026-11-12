<?php 
include 'includes/db.php'; 
include 'includes/header.php'; 

// 1. Marrja e kategorisë nga URL (psh: ?kat=konferenca)
$kategoria_zgjedhur = isset($_GET['kat']) ? $_GET['kat'] : 'trajnimet';

// 2. Mapimi i titujve për t'i shfaqur bukur
$titujt = [
    'trajnimet'             => 'Trajnimet tona',
    'menaxhimi-strategjik'  => 'Menaxhimi Strategjik',
    'lidership'             => 'Lidership',
    'hartim-projektesh'     => 'Hartim dhe Menaxhim Projektesh',
    'administrim-biznesi'   => 'Administrim Biznesi',
    'organizim-trajnimeve'  => 'Organizim i Trajnimeve Profesionale',
    'konferenca'            => 'Konferenca & Seminare',
    'sport'                 => 'Aktivitete Sportive',
    'rini'                  => 'Rinia dhe Angazhimi',
    'kulture'               => 'Kulturë dhe Art',
    'trashegimi'            => 'Trashëgimi Kulturore',
    'verlt'                 => 'Aktivitete Verlt', // Shtova presjen këtu
    'erasmus'               => 'Erasmus+',
    'esc'                   => 'European Solidarity Corps (ESC)' // SHTEZA E RE
];

$titulli_aktual = isset($titujt[$kategoria_zgjedhur]) ? $titujt[$kategoria_zgjedhur] : 'Aktivitetet';
?>

<style>
    .activities-section { padding: 120px 0 80px; background: #fdfdfd; min-height: 80vh; }
    .container-custom { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
    
    .section-header { text-align: center; margin-bottom: 60px; }
    .section-header h1 { font-size: 42px; font-weight: 900; color: #1a1a1a; margin-top: 10px; text-transform: uppercase; }
    .sub-red { color: #e63946; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; font-size: 14px; }

    .activities-grid { 
        display: grid; 
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); 
        gap: 30px; 
    }

    .activity-card { 
        background: #fff; 
        border-radius: 15px; 
        overflow: hidden; 
        box-shadow: 0 10px 30px rgba(0,0,0,0.05); 
        transition: 0.3s ease;
        border: 1px solid #eee;
    }

    .activity-card:hover { transform: translateY(-10px); box-shadow: 0 15px 40px rgba(0,0,0,0.1); }

    .activity-img { width: 100%; height: 230px; object-fit: cover; }

    .activity-body { padding: 25px; }
    .activity-body h3 { font-size: 22px; margin-bottom: 15px; color: #111; line-height: 1.4; }
    
    .back-btn { 
        display: inline-block; 
        margin-bottom: 20px; 
        text-decoration: none; 
        color: #e63946; 
        font-weight: 700; 
        font-size: 14px;
    }
</style>

<div class="activities-section">
    <div class="container-custom">
        <a href="index.php" class="back-btn">← Kthehu Mbrapa</a>

        <div class="section-header">
            <span class="sub-red">— <?php echo $titulli_aktual; ?></span>
            <h1>Eksploro Aktivitetet</h1>
        </div>

        <div class="activities-grid">
            <?php
            // 3. QUERY SQL: Marrim fotot nga 'galeria' ku kategoria është ajo që klikuam
            $stmt = $conn->prepare("SELECT image_path FROM galeria WHERE kategoria = ? ORDER BY id DESC");
            $stmt->bind_param("s", $kategoria_zgjedhur);
            $stmt->execute();
            $res = $stmt->get_result();

            if($res && $res->num_rows > 0):
                while($row = $res->fetch_assoc()): ?>
                    <div class="activity-card">
                        <img src="uploads/galeria/<?= htmlspecialchars($row['image_path']) ?>" class="activity-img" alt="Aktiviteti">
                        <div class="activity-body">
                            <h3>Moment nga <?php echo $titulli_aktual; ?></h3>
                        </div>
                    </div>
                <?php endwhile; 
            else: ?>
                <div style="grid-column: 1/-1; text-align: center; padding: 100px 20px;">
                    <img src="assets/img/empty.svg" alt="" style="width: 150px; opacity: 0.3; margin-bottom: 20px;">
                    <p style="color: #888; font-size: 18px;">Nuk u gjet asnjë material në kategorinë <strong><?php echo $titulli_aktual; ?></strong>.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>