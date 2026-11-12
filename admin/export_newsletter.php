<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['admin_id'])) { exit("Access Denied"); }

// Emri i skedarit që do të shkarkohet
$filename = "newsletter_emails_" . date('Y-m-d') . ".csv";

// Vendosja e headers për shkarkim
header("Content-Type: text/csv; charset=utf-8");
header("Content-Disposition: attachment; filename=$filename");

// Hapim "output stream"
$output = fopen("php://output", "w");

// Shtojmë rreshtin e parë (Kokat e kolonave)
fputcsv($output, array('ID', 'Email', 'Data e Regjistrimit'));

// Marrim të dhënat nga databaza
$query = "SELECT id, email, sub_date FROM newsletter ORDER BY sub_date DESC";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, $row);
}

fclose($output);
exit();
?>