<?php
session_start(); // Oturumu başlat

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "demo";

try {
    // PDO üzerinden veritabanına bağlanma
    $conn = new PDO("mysql:host=$servername;port=3308;unix_socket=/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock;dbname=$dbname;charset=utf8mb4", $username, $password);
    // PDO hata modunu istisna olarak ayarla
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // JSON dosyasını oku
    $json_data = file_get_contents('randevu_listesi.json');
    // JSON verisini diziye dönüştür
    $randevular = json_decode($json_data, true);

    // Veritabanına randevuları ekleyin
    foreach ($randevular as $randevu) {
        // Veri öğelerini al
        $RandevuTarihi = $randevu['RandevuTarihi'];
        $RandevuSaati = $randevu['RandevuSaati'];
        $HastaID = $randevu['HastaID'];
        $DoktorID = $randevu['DoktorID'];
        $YoneticiID = $randevu['YoneticiID'];

        // SQL sorgusunu hazırla
        $sql = "INSERT INTO randevular (RandevuTarihi, RandevuSaati, HastaID, DoktorID, YoneticiID) 
                VALUES (:RandevuTarihi, :RandevuSaati, :HastaID, :DoktorID, :YoneticiID)";
        
        // SQL sorgusunu hazırla
        $stmt = $conn->prepare($sql);

        // Bağlantıyı yapılandır
        $stmt->bindParam(':RandevuTarihi', $RandevuTarihi);
        $stmt->bindParam(':RandevuSaati', $RandevuSaati);
        $stmt->bindParam(':HastaID', $HastaID);
        $stmt->bindParam(':DoktorID', $DoktorID);
        $stmt->bindParam(':YoneticiID', $YoneticiID);

        // SQL sorgusunu çalıştır
        $stmt->execute();
    }

    // Doktor bilgilerini al
    $stmt = $conn->prepare("SELECT DoktorID, CalistigiHastane, UzmanlikAlani FROM doktorlar");
    $stmt->execute();
    $doktorlar = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Randevular tablosunu doktor bilgilerine göre güncelle
    foreach ($doktorlar as $doktor) {
        $sql = "UPDATE randevular SET CalistigiHastane = :CalistigiHastane, UzmanlikAlani = :UzmanlikAlani WHERE DoktorID = :DoktorID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':CalistigiHastane', $doktor['CalistigiHastane']);
        $stmt->bindParam(':UzmanlikAlani', $doktor['UzmanlikAlani']);
        $stmt->bindParam(':DoktorID', $doktor['DoktorID']);
        $stmt->execute();
    }

    echo "Randevular başarıyla eklendi ve güncellendi.\n";
} catch(PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
}
?>
