<?php
// Ndrysho rrugën për te db.php (duhet të dalësh një folder jashtë me ../)
include '../includes/db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emri = mysqli_real_escape_string($conn, $_POST['emri']);
    $mbiemri = mysqli_real_escape_string($conn, $_POST['mbiemri']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $telefoni = mysqli_real_escape_string($conn, $_POST['telefoni']);
    $programi = mysqli_real_escape_string($conn, $_POST['programi'] ?? '');
    $mesazhi = mysqli_real_escape_string($conn, $_POST['mesazhi']);

    $sql = "INSERT INTO kontaktet (emri, mbiemri, email, telefoni, programi, mesazhi) 
            VALUES ('$emri', '$mbiemri', '$email', '$telefoni', '$programi', '$mesazhi')";

    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>