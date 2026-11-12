<?php 
include 'includes/db.php'; 
include 'includes/header.php'; 

// 1. Marrja e kategorisë nga URL
$kategoria_zgjedhur = isset($_GET['kat']) ? $_GET['kat'] : 'rrobaqepesi';

// Mapimi i titujve për Kurset
$titujt_kurseve = [
    'rrobaqepesi'      => 'Kursi i Rrobaqepësisë',
    'it-dizajn'        => 'IT, Dizajn Grafik dhe Ndërmarrësi',
    'serra-bujqesi'    => 'Mbështetje me Serra për Bujqësi',
    'makina-qepjeje'   => 'Mbështetje me Makina të Qepjes',
    'bursa-ekselence'  => 'Mbështetje me Bursa të Ekselencës'
];

$titulli_aktual = isset($titujt_kurseve[$kategoria_zgjedhur]) ? $titujt_kurseve[$kategoria_zgjedhur] : 'Kursi Profesional';
?>

<style>
    .course-page { padding: 100px 0; background: #f9f9f9; }
    .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
    .course-header { border-left: 5px solid #2563eb; padding-left: 20px; margin-bottom: 50px; }
    .course-header h1 { font-size: 36px; color: #1e2937; text-transform: uppercase; }
    .news-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 25px; margin-bottom: 60px; }
    .news-card { background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.08); border-top: 4px solid #dc2626; }
    .news-content { padding: 20px; }
    .badge-konkurs { background: #dc2626; color: #fff; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: bold; }
    .media-section { margin-top: 50px; }
    .gallery-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 15px; }
    .media-item { border-radius: 10px; overflow: hidden; height: 200px; box-shadow: 0 3px 10px rgba(0,0,0,0.1); }
    .media-item img, .media-item video { width: 100%; height: 100%; object-fit: cover; }
    .section-title { font-size: 24px; margin-bottom: 25px; color: #334155; display: flex; align-items: center; gap: 10px; }
    .section-title::after { content: ""; height: 2px; flex: 1; background: #e2e8f0; }
</style>

<div class="course-page">
    <div class="container">
        
        <div class="course-header">
            <p style="color: #64748b; font-weight: 600; margin-bottom: 5px;">Kurset Profesionale</p>
            <h1><?php echo $titulli_aktual; ?></h1>
        </div>

        <h2 class="section-title">Lajmet & Konkurset</h2>
        <div class="news-grid">
            <?php
            // KORRIGJIM: Ndryshuar nga 'image' në 'foto'
            $stmt_news = $conn->prepare("SELECT * FROM posts WHERE kategoria = ? ORDER BY id DESC");
            $stmt_news->bind_param("s", $kategoria_zgjedhur);
            $stmt_news->execute();
            $news_res = $stmt_news->get_result();

            if($news_res->num_rows > 0):
                while($post = $news_res->fetch_assoc()): ?>
                    <div class="news-card">
                        <?php if(!empty($post['foto'])): ?>
                            <img src="uploads/posts/<?php echo $post['foto']; ?>" style="width:100%; height:200px; object-fit:cover;">
                        <?php endif; ?>
                        <div class="news-content">
                            <span class="badge-konkurs">KONKURS / LAJM</span>
                            <h3 style="margin: 15px 0 10px;"><?php echo $post['titulli']; ?></h3>
                            <p style="color: #475569; font-size: 14px; line-height: 1.6;">
                                <?php echo substr(strip_tags($post['pershkrimi']), 0, 150); ?>...
                            </p>
                            <a href="postimi_detaje.php?id=<?php echo $post['id']; ?>" style="display:inline-block; margin-top:15px; color:#2563eb; font-weight:bold; text-decoration:none;">Lexo më shumë &rarr;</a>
                        </div>
                    </div>
                <?php endwhile;
            else:
                echo "<p style='color:#94a3b8;'>Nuk ka lajme apo konkurse të reja për këtë kurs.</p>";
            endif; ?>
        </div>

        <div class="media-section">
            <h2 class="section-title">Galeria & Media</h2>
            <div class="gallery-grid">
                <?php
                $stmt_gal = $conn->prepare("SELECT * FROM galeria WHERE kategoria = ? ORDER BY id DESC");
                $stmt_gal->bind_param("s", $kategoria_zgjedhur);
                $stmt_gal->execute();
                $gal_res = $stmt_gal->get_result();

                if($gal_res->num_rows > 0):
                    while($media = $gal_res->fetch_assoc()): ?>
                        <div class="media-item">
                            <?php 
                            $ext = strtolower(pathinfo($media['image_path'], PATHINFO_EXTENSION));
                            if(in_array($ext, ['mp4', 'webm'])): ?>
                                <video controls style="width:100%; height:100%; object-fit:cover;">
                                    <source src="uploads/galeria/<?php echo $media['image_path']; ?>" type="video/<?php echo $ext; ?>">
                                </video>
                            <?php else: ?>
                                <img src="uploads/galeria/<?php echo $media['image_path']; ?>" alt="Foto nga Kursi">
                            <?php endif; ?>
                        </div>
                    <?php endwhile;
                else:
                    echo "<p style='color:#94a3b8;'>Galeria është duke u përditësuar...</p>";
                endif; ?>
            </div>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>