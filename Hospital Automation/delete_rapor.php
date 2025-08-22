<?php
session_start(); // Oturumu başlat

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "demo";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['raporID'])) {
        $raporID = $_POST['raporID'];

        try {
            // SQL sorgusunu hazırlama
            $stmt = $conn->prepare("DELETE FROM TibbiRaporlar WHERE RaporID = :raporID");
            // Bağlama işlemi
            $stmt->bindParam(':raporID', $raporID, PDO::PARAM_INT);
            // Sorguyu çalıştır
            if ($stmt->execute()) {
                echo 'success';
            } else {
                echo 'error';
            }
        } catch(PDOException $e) {
            echo "Hata: " . $e->getMessage();
        }
    } else {
        echo "Rapor ID belirtilmedi.";
    }
}

$conn = null; // Bağlantıyı kapat
?>