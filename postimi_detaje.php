<?php 
include 'includes/db.php'; 
include 'includes/header.php'; 

// Marrim ID-në nga URL
if(isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    $stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $post = $result->fetch_assoc();
    } else {
        header("Location: lajmet.php");
        exit();
    }
} else {
    header("Location: lajmet.php");
    exit();
}
?>

<style>
    .post-details { padding: 120px 0 80px; background: #fff; }
    .post-container { max-width: 800px; margin: 0 auto; padding: 0 20px; }
    .post-meta { color: #64748b; font-size: 14px; margin-bottom: 20px; display: flex; gap: 15px; }
    .post-title { font-size: 32px; color: #1e2937; margin-bottom: 25px; line-height: 1.3; }
    .post-image { width: 100%; border-radius: 15px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
    .post-text { font-size: 18px; line-height: 1.8; color: #334155; white-space: pre-line; }
    .back-btn { display: inline-block; margin-bottom: 30px; color: #2563eb; text-decoration: none; font-weight: 600; }
</style>

<div class="post-details">
    <div class="post-container">
        <a href="javascript:history.back()" class="back-btn">&larr; Kthehu mbrapa</a>
        
<div class="post-meta">
    <span>📅 
        <?php 
        // Kontrollojmë nëse ekziston 'data' në array, nëse jo përdorim kohën aktuale
        $data_postimit = isset($post['data']) ? $post['data'] : 'now';
        echo date('d.m.Y', strtotime($data_postimit)); 
        ?>
    </span>
    <span style="text-transform: uppercase; color: #2563eb; font-weight: bold;">
        📂 <?php echo isset($post['kategoria']) ? $post['kategoria'] : 'Lajm'; ?>
    </span>
</div>
        <h1 class="post-title"><?php echo $post['titulli']; ?></h1>

        <?php if(!empty($post['foto'])): ?>
            <img src="uploads/posts/<?php echo $post['foto']; ?>" class="post-image" alt="<?php echo $post['titulli']; ?>">
        <?php endif; ?>

        <div class="post-text">
            <?php echo $post['pershkrimi']; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>