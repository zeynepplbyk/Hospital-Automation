<?php
session_start(); // Oturumu başlat

// Bu örnekte, hasta ID'sinin oturumda tutulduğu varsayılmıştır.
if (!isset($_SESSION['HastaID'])) {
    echo "Hasta ID oturumda bulunamadı.";
    exit;
}

$hastaID = $_SESSION['HastaID'];

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
    try {
        $stmt = $conn->prepare("SELECT r.*, h.Ad AS HastaAd, h.Soyad AS HastaSoyad, d.Ad AS DoktorAd, d.Soyad AS DoktorSoyad FROM TibbiRaporlar r
                                INNER JOIN Hastalar h ON r.HastaID = h.HastaID
                                INNER JOIN Doktorlar d ON r.DoktorID = d.DoktorID
                                WHERE r.HastaID = :hastaID");
        $stmt->bindParam(':hastaID', $hastaID, PDO::PARAM_INT);
        $stmt->execute();
        $raporlar = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<h2>Hasta ID: $hastaID</h2>";
        echo "<h3>Raporlar:</h3>";
        echo "<table border='1'>";
        echo "<tr><th>Rapor ID</th><th>Rapor Tarihi</th><th>Rapor İçeriği</th><th>Hasta Adı</th><th>Hasta Soyadı</th><th>Doktor Adı</th><th>Doktor Soyadı</th><th>Rapor URL</th><th>İşlem</th></tr>";
        foreach ($raporlar as $rapor) {
            echo "<tr id='rapor-" . $rapor['RaporID'] . "'>";
            echo "<td>" . $rapor['RaporID'] . "</td>";
            echo "<td>" . $rapor['RaporTarihi'] . "</td>";
            echo "<td>" . $rapor['RaporIcerigi'] . "</td>";
            echo "<td>" . $rapor['HastaAd'] . "</td>";
            echo "<td>" . $rapor['HastaSoyad'] . "</td>";
            echo "<td>" . $rapor['DoktorAd'] . "</td>";
            echo "<td>" . $rapor['DoktorSoyad'] . "</td>";
            echo "<td><a href='" . $rapor['RaporURL'] . "' target='_blank'>Görüntüle</a></td>";
            echo "<td><button onclick='deleteRapor(" . $rapor['RaporID'] . ")'>Sil</button></td>";
            echo "</tr>";
        }
        echo "</table>";
    } catch(PDOException $e) {
        echo "Hata: " . $e->getMessage();
    }
}

$conn = null; // Bağlantıyı kapat
?>