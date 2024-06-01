<?php
session_start(); // Oturumu başlat

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "demo";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    // PDO hata modunu istisna olarak ayarla
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hastaID = $_POST['hastaID'];
    $doktorID = $_POST['doktorID'];
    $raporTarihi = $_POST['raporTarihi'];
    $raporIcerigi = $_POST['raporIcerigi'];
    $raporURL = $_POST['raporURL'];
    $yoneticiID = 1; // Yönetici ID'si eğer varsa dinamik olarak alınabilir

    // JSON formatında veri hazırlama
    $raporJSON = json_encode(array(
        'RaporTarihi' => $raporTarihi,
        'RaporIcerigi' => $raporIcerigi,
        'HastaID' => $hastaID,
        'DoktorID' => $doktorID,
        'YoneticiID' => $yoneticiID,
        'RaporURL' => $raporURL
    ));

    $sql = "INSERT INTO TibbiRaporlar (RaporTarihi, RaporIcerigi, HastaID, DoktorID, YoneticiID, RaporURL, RaporJSON)
            VALUES (:raporTarihi, :raporIcerigi, :hastaID, :doktorID, :yoneticiID, :raporURL, :raporJSON)";
            
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':raporTarihi', $raporTarihi);
    $stmt->bindParam(':raporIcerigi', $raporIcerigi);
    $stmt->bindParam(':hastaID', $hastaID);
    $stmt->bindParam(':doktorID', $doktorID);
    $stmt->bindParam(':yoneticiID', $yoneticiID);
    $stmt->bindParam(':raporURL', $raporURL);
    $stmt->bindParam(':raporJSON', $raporJSON);

    try {
        $stmt->execute();
        echo "Rapor başarıyla eklendi.";
    } catch(PDOException $e) {
        echo "Veritabanına kaydedilirken hata oluştu: " . $e->getMessage();
    }
}
?>