<?php 
include 'includes/db.php'; 
include 'includes/header.php'; 


$query_text = isset($_GET['query']) ? $_GET['query'] : '';

if (!empty($query_text)) {
    // Përdor Prepared Statements për siguri
    $search_term = "%" . $query_text . "%";
    
    $stmt = $conn->prepare("SELECT * FROM posts WHERE titulli LIKE ? OR pershkrimi LIKE ?");
    
    if ($stmt === false) {
        echo "<h2>Gabim në kërkim. Ju lutem provoni përsëri më vonë.</h2>";
    } else {
        $stmt->bind_param("ss", $search_term, $search_term);
        $stmt->execute();
        
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            echo "<h2>Rezultatet për: " . htmlspecialchars($query_text) . "</h2>";
            while ($row = $result->fetch_assoc()) {
                echo "<div class='search-result'>";
                echo "<h3>" . htmlspecialchars($row['titulli']) . "</h3>";
                echo "<p>" . htmlspecialchars(substr(strip_tags($row['pershkrimi']), 0, 150)) . "...</p>";
                echo "<a href='lajmi-detaje.php?id=" . $row['id'] . "'>Lexo më shumë</a>";
                echo "</div>";
            }
        } else {
            echo "<h2>Nuk u gjet asnjë rezultat për: " . htmlspecialchars($query_text) . "</h2>";
        }
    }
} else {
    echo "Ju lutem shkruani një fjalë për të kërkuar.";
}
?>

<?php include 'includes/footer.php'; ?>