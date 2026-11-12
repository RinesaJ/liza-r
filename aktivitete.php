<?php 
include 'includes/db.php'; 
include 'includes/header.php'; 

// Mapimi i kategorive që do të shfaqen në faqe
$kategorite_faqes = [
    'trajnimet'            => 'Trajnimet tona',
    'konferenca'           => 'Konferenca & Seminare',
    'sport'                => 'Aktivitete Sportive',
    'rini'                 => 'Rinia dhe Angazhimi',
    'kulture'              => 'Kulturë dhe Art',
    'trashegimi'           => 'Trashëgimi Kulturore'
];
?>

<style>
    :root {
        --accent: #ff6b35;
        --dark: #1a1a1a;
    }
    .main-wrapper { padding: 120px 0 80px; background: #f9f9f9; }
    .container-custom { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
    
    .hero-box { text-align: center; margin-bottom: 80px; }
    .hero-box h1 { font-family: 'Syne', sans-serif; font-size: 48px; font-weight: 800; color: var(--dark); }
    
    /* Seksioni i Kategorisë */
    .category-block { margin-bottom: 100px; }
    .category-header { 
        display: flex; 
        justify-content: space-between; 
        align-items: flex-end; 
        margin-bottom: 30px; 
        border-bottom: 2px solid #eee; 
        padding-bottom: 15px;
    }
    .category-header h2 { font-family: 'Syne', sans-serif; font-size: 28px; font-weight: 800; color: var(--dark); margin: 0; }
    
    .view-all-btn { 
        color: var(--accent); 
        text-decoration: none; 
        font-weight: 700; 
        font-size: 14px; 
        text-transform: uppercase;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: 0.3s;
    }
    .view-all-btn:hover { gap: 12px; }

    /* Grid i fotove */
    .images-preview-grid { 
        display: grid; 
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); 
        gap: 20px; 
    }

    .preview-card { 
        background: #fff; 
        border-radius: 12px; 
        overflow: hidden; 
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        height: 200px;
    }
    .preview-card img { width: 100%; height: 100%; object-fit: cover; transition: 0.5s; }
    .preview-card:hover img { transform: scale(1.1); }

    .no-data { color: #888; font-style: italic; padding: 20px 0; }
</style>

<div class="main-wrapper">
    <div class="container-custom">
        
        <div class="hero-box">
            <span style="color: var(--accent); font-weight: 700; letter-spacing: 2px; text-transform: uppercase;">Eksploro Galerinë</span>
            <h1>Aktivitetet tona</h1>
        </div>

        <?php foreach ($kategorite_faqes as $slug => $emri): ?>
            <section class="category-block">
                <div class="category-header">
                    <h2><?php echo $emri; ?></h2>
                    <a href="aktivitetet-detaje.php?kat=<?php echo $slug; ?>" class="view-all-btn">
                        Shiko të gjitha <span>→</span>
                    </a>
                </div>

                <div class="images-preview-grid">
                    <?php
                    // Marrim vetëm 4 fotot e fundit për çdo kategori si preview
                    $stmt = $conn->prepare("SELECT image_path FROM galeria WHERE kategoria = ? ORDER BY id DESC LIMIT 4");
                    $stmt->bind_param("s", $slug);
                    $stmt->execute();
                    $res = $stmt->get_result();

                    if($res && $res->num_rows > 0):
                        while($img = $res->fetch_assoc()): ?>
                            <div class="preview-card">
                                <img src="uploads/galeria/<?= htmlspecialchars($img['image_path']) ?>" alt="Preview">
                            </div>
                        <?php endwhile; 
                    else: ?>
                        <p class="no-data">Nuk ka ende foto në këtë kategori.</p>
                    <?php endif; ?>
                </div>
            </section>
        <?php endforeach; ?>

    </div>
</div>

<?php include 'includes/footer.php'; ?>