<?php 
include 'includes/db.php'; 
include 'includes/header.php'; 

// 1. Lexojmë kategorinë nga URL (psh: galeria.php?kat=vizita)
// Nëse nuk ka kategori në URL, shfaqim 'te-pergjithshme' si default
$kategoria_zgjedhur = isset($_GET['kat']) ? $_GET['kat'] : 'te-pergjithshme';

// 2. Mapimi i titujve që të shfaqen bukur në faqe sipas asaj që klikon përdoruesi
$titujt = [
    'te-pergjithshme' => 'Foto të Përgjithshme',
    'vizita'          => 'Vizita Studentore',
    'delegacionet'    => 'Pritje e Delegacioneve',
    'evente'          => 'Eventet tona',
    'trajnime'        => 'Trajnime të Mbajtura',
    'trajnime2020/24'          => 'Trajnimet 2020-2024'
];

$titulli_aktual = isset($titujt[$kategoria_zgjedhur]) ? $titujt[$kategoria_zgjedhur] : 'Galeria';
?>

<style>
    .gallery-page-section { padding: 140px 0 80px; background: #f8f7f2; min-height: 80vh; }
    .container-custom { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
    .gallery-intro { text-align: center; margin-bottom: 50px; }
    .gallery-intro h1 { font-size: 48px; font-weight: 900; color: #000; margin-top: 10px; }
    .sub-red { color: #e63946; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; font-size: 14px; }
    
    .full-gallery-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 25px; }
    .gallery-card { width: 100%; height: 300px; overflow: hidden; border-radius: 12px; box-shadow: 0 10px 20px rgba(0,0,0,0.05); background: #fff; }
    .gallery-card img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; display: block; }
    .gallery-card:hover img { transform: scale(1.1); }
    .back-link { display: inline-block; margin-bottom: 30px; text-decoration: none; color: #666; font-weight: 600; transition: 0.3s; }
    .back-link:hover { color: #e63946; }
</style>

<div class="gallery-page-section">
    <div class="container-custom">
        <a href="index.php" class="back-link">← Kthehu në Ballinë</a>

        <div class="gallery-intro">
            <span class="sub-red">— <?php echo $titulli_aktual; ?></span>
            <h1>Galeria e Plotë</h1>
        </div>

        <div class="full-gallery-grid">
            <?php
            // 3. NDRYSHIMI KRYESOR: Shtojmë WHERE kategoria = ?
            // Kjo bën që të shfaqen vetëm fotot që i përkasin kategorisë së klikuar
            $stmt = $conn->prepare("SELECT image_path FROM galeria WHERE kategoria = ? ORDER BY id DESC");
            $stmt->bind_param("s", $kategoria_zgjedhur);
            $stmt->execute();
            $res = $stmt->get_result();
            
            if($res && $res->num_rows > 0):
                while($row = $res->fetch_assoc()): ?>
                    <div class="gallery-card">
                        <img src="uploads/galeria/<?= htmlspecialchars($row['image_path']) ?>" alt="Liza-R Moment">
                    </div>
                <?php endwhile; 
            else: ?>
                <div style="grid-column: 1/-1; text-align: center; padding: 50px;">
                    <p>Nuk ka foto në këtë kategori për momentin.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>