<?php
// Të dhënat e serverit (Nëse je në localhost)
$host = "localhost";
$user = "root";       // Përdoruesi i paracaktuar i XAMPP/MAMP
$pass = "";           // Zakonisht është bosh në localhost
$db_name = "liza-r"; // Emri që i ke vënë database-it në phpMyAdmin

// Krijimi i lidhjes duke përdorur MySQLi (Object Oriented)
$conn = new mysqli($host, $user, $pass, $db_name);

// Kontrolli nëse lidhja dështoi
if ($conn->connect_error) {
    die("Lidhja dështoi: " . $conn->connect_error);
}

// Vendosja e karakterve në UTF-8 për të suportuar shkronjat shqipe (ë, ç)
$conn->set_charset("utf8mb4");
?>