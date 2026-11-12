<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$admin_user = htmlspecialchars($_SESSION['admin_user']);

// Statistikat
$count_posts = $conn->query("SELECT COUNT(id) as total FROM posts")->fetch_assoc()['total'];
$count_galeria = $conn->query("SELECT COUNT(id) as total FROM galeria")->fetch_assoc()['total'];

// Numërimi i mesazheve
$check_table = $conn->query("SHOW TABLES LIKE 'kontaktet'");
$count_mesazhe = ($check_table->num_rows > 0) ? $conn->query("SELECT COUNT(id) as total FROM kontaktet")->fetch_assoc()['total'] : 0;

// Numërimi i Newsletter
$check_news = $conn->query("SHOW TABLES LIKE 'newsletter'");
$count_news = ($check_news->num_rows > 0) ? $conn->query("SELECT COUNT(id) as total FROM newsletter")->fetch_assoc()['total'] : 0;

// Numërimi i Anëtarëve të Kryesisë
$count_kryesia = $conn->query("SELECT COUNT(id) as total FROM kryesia")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Liza-R</title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI', sans-serif;}
        body{display:flex;background:#f4f7fb;}
        
        /* SIDEBAR */
        .sidebar{ width:240px; height:100vh; background:#1f2937; color:#fff; position:fixed; padding:20px; }
        .sidebar h2{ text-align:center; margin-bottom:30px; font-size: 1.2rem; border-bottom: 1px solid #374151; padding-bottom: 10px; }
        .sidebar a{ display:block; color:#cbd5e1; padding:12px; margin:5px 0; text-decoration:none; border-radius:6px; transition:0.3s; }
        .sidebar a:hover, .sidebar a.active{ background:#2563eb; color:#fff; }
        
        /* MAIN CONTENT */
        .main{ margin-left:240px; width:100%; padding:25px; }
        .header{ display:flex; justify-content:space-between; align-items:center; margin-bottom:25px; }
        
        /* STATS CARDS */
        .cards{ display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:20px; }
        .card{ background:#fff; padding:20px; border-radius:12px; box-shadow:0 4px 6px rgba(0,0,0,0.05); border-top: 4px solid #2563eb; }
        .card h3{ font-size:12px; color:#64748b; text-transform: uppercase; letter-spacing: 1px; }
        .card p{ font-size:28px; font-weight:bold; margin-top:10px; color: #1e293b; }
        .card.msg { border-top-color: #10b981; }
        .card.news { border-top-color: #f59e0b; } /* Portokalli për Newsletter */

        /* TABLES AREA */
        .grid-tables { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-top: 30px; }
        .table-box{ background:#fff; border-radius:12px; padding:20px; box-shadow:0 4px 6px rgba(0,0,0,0.05); }
        .table-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        
        table{ width:100%; border-collapse:collapse; }
        th,td{ padding:12px; text-align:left; border-bottom:1px solid #f1f5f9; font-size: 14px; }
        th{ background:#f8fafc; color:#475569; font-size: 11px; text-transform: uppercase; }
        
        .btn-add{ background:#2563eb; color:#fff; padding:8px 14px; border-radius:6px; text-decoration:none; font-size:12px; font-weight: 600; }
        .actions a{ text-decoration:none; font-size:12px; font-weight: bold; margin-right: 10px;}
        .edit{color:#2563eb;}
        .delete{color:#dc2626;}

        @media (max-width: 1100px) { .grid-tables { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Liza-R Admin</h2>
    <a href="index.php" class="active">📊 Dashboard</a>
    <a href="postimet.php">📋 Postimet</a>
    <a href="galeria.php">🖼️ Galeria</a>
    <a href="sponsors.php">🤝 Sponsorët</a> 
    <a href="kryesia.php">👥 Kryesia</a>
    <a href="kurset_admin.php">🤝 Kurset</a>
    <a href="kontaktet.php">📩 Mesazhet</a>
    <a href="logout.php" style="margin-top:50px; color:#f87171;">🚪 Dil</a>
</div>

<div class="main">
    <div class="header">
        <h1>Dashboard 👋</h1>
        <div style="color: #64748b; font-weight: 500;"><?php echo date('d.m.Y'); ?></div>
    </div>

    <div class="cards">
        <div class="card">
            <h3>Postime</h3>
            <p><?php echo $count_posts; ?></p>
        </div>
        <div class="card">
            <h3>Galeria</h3>
            <p><?php echo $count_galeria; ?></p>
        </div>
        <div class="card msg">
            <h3>Mesazhe</h3>
            <p><?php echo $count_mesazhe; ?></p>
        </div>
        <div class="card news">
            <h3>Newsletter</h3>
            <p><?php echo $count_news; ?></p>
        </div>
    </div>

    <div class="grid-tables">
        <div class="table-box">
            <div class="table-header">
                <h3>Postimet e fundit</h3>
                <a href="add_post.php" class="btn-add">➕ Shto Postim</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Titulli</th>
                        <th>Data</th>
                        <th>Veprime</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $result = $conn->query("SELECT id, titulli, data_aktivitetit FROM posts ORDER BY created_at DESC LIMIT 5");
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        echo "<tr>
                            <td><strong>".htmlspecialchars($row['titulli'])."</strong></td>
                            <td>".date('d.m.Y', strtotime($row['data_aktivitetit']))."</td>
                            <td class='actions'>
                                <a class='edit' href='edit_post.php?id={$row['id']}'>Edito</a>
                                <a class='delete' href='delete_post.php?id={$row['id']}' onclick='return confirm(\"A jeni të sigurt?\")'>Fshij</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' style='text-align:center;'>Nuk ka postime.</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>

        <div class="table-box">
            <div class="table-header">
    <h3>Newsletter 📩</h3>
    <a href="export_newsletter.php" class="btn-add" style="background:#10b981;">📥 Shkarko (CSV)</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if ($check_news->num_rows > 0) {
                    $news_res = $conn->query("SELECT email, sub_date FROM newsletter ORDER BY sub_date DESC LIMIT 6");
                    while($n = $news_res->fetch_assoc()){
                        echo "<tr>
                            <td style='font-size:13px;'>".htmlspecialchars($n['email'])."</td>
                            <td style='font-size:11px; color:#94a3b8;'>".date('d/m/y', strtotime($n['sub_date']))."</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='2' style='text-align:center;'>Bosh</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>