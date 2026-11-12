<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header("Location: login.php"); exit(); }
include '../includes/db.php';
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menaxho Postimet - Liza R</title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI', sans-serif;}
        body{display:flex;background:#f4f7fb;}
        
        /* SIDEBAR - I sinkronizuar me Dashboard dhe Galeria */
        .sidebar{ width:240px; height:100vh; background:#1f2937; color:#fff; position:fixed; padding:20px; }
        .sidebar h2{ text-align:center; margin-bottom:30px; font-size: 1.2rem; border-bottom: 1px solid #374151; padding-bottom: 10px; }
        .sidebar a{ display:block; color:#cbd5e1; padding:12px; margin:5px 0; text-decoration:none; border-radius:6px; transition:0.3s; }
        .sidebar a:hover, .sidebar a.active{ background:#2563eb; color:#fff; }

        /* MAIN CONTENT */
        .main{ margin-left:240px; width:100%; padding:25px; }
        
        .header-box { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .btn-add { background:#2563eb; color:#fff; padding:12px 20px; border-radius:8px; text-decoration:none; font-weight:600; transition: 0.3s; }
        .btn-add:hover { background: #1e40af; }

        /* GRID SYSTEM PËR CARDS */
        .posts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
        }

        .post-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            transition: transform 0.2s;
            display: flex;
            flex-direction: column;
        }
        
        .post-card:hover { transform: translateY(-5px); }

        .post-img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-bottom: 1px solid #eee;
        }

        .post-content { padding: 15px; flex-grow: 1; }
        .post-content h3 { font-size: 18px; margin-bottom: 10px; color: #1e293b; line-height: 1.4; }
        .post-content span { font-size: 13px; color: #64748b; font-weight: 600; display: block; margin-bottom: 5px; }

        .post-actions {
            padding: 15px;
            background: #f8fafc;
            display: flex;
            justify-content: space-between;
            border-top: 1px solid #eee;
        }

        .btn-edit { color: #2563eb; text-decoration: none; font-weight: 700; font-size: 14px; }
        .btn-delete { color: #dc2626; text-decoration: none; font-weight: 700; font-size: 14px; }
    </style>
</head>
<body>


<div class="sidebar">
    <h2>Liza-R Admin</h2>
    <a href="index.php" >📊 Dashboard</a>
    <a href="postimet.php" class="active">📋 Postimet</a>
    <a href="galeria.php">🖼️ Galeria</a>
    <a href="sponsors.php">🤝 Sponsorët</a> 
    <a href="kryesia.php">👥 Kryesia</a>
    <a href="kurset_admin.php">🤝 Kurset</a>
    <a href="kontaktet.php">📩 Mesazhet</a>
    <a href="logout.php" style="margin-top:50px; color:#f87171;">🚪 Dil</a>
</div>

<div class="main">
    <div class="header-box">
        <h1>Menaxho Postimet</h1>
        <a href="add_post.php" class="btn-add">➕ Shto Postim të Ri</a>
    </div>

    <div class="posts-grid">
        <?php
        $result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                // Formatojmë datën (p.sh. Jan 2026)
                $data_shfaqjes = date("M Y", strtotime($row['data_aktivitetit']));
                ?>
                <div class="post-card">
                    <img src="../uploads/<?php echo $row['foto']; ?>" class="post-img" alt="Foto">
                    <div class="post-content">
                        <span>📅 <?php echo $data_shfaqjes; ?></span>
                        <h3><?php echo htmlspecialchars($row['titulli']); ?></h3>
                    </div>
                    <div class="post-actions">
                        <a href="edit_post.php?id=<?php echo $row['id']; ?>" class="btn-edit">✏️ Edito</a>
                        <a href="delete_post.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('A jeni të sigurt që dëshironi ta fshini këtë postim?')">🗑️ Fshij</a>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<div style='grid-column: 1/-1; text-align: center; padding: 60px; background: #fff; border-radius: 12px; border: 1px dashed #cbd5e1;'>
                    <p style='color: #64748b; font-size: 16px;'>Nuk ka postime për të shfaqur. Filloni duke shtuar një të ri!</p>
                  </div>";
        }
        ?>
    </div>
</div>


</body>
</html>