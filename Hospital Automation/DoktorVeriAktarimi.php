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
    $json_data = file_get_contents('doktor_listesi.json');
    // JSON verisini diziye dönüştür
    $veriler = json_decode($json_data, true);

    // Veritabanına verileri ekleyin
    foreach ($veriler as $index => $veri) {
        // JSON dosyasındaki DoktorID değerini atla
        // Veri öğelerini al
        $Ad = $veri['Ad'];
        $Soyad = $veri['Soyad'];
        $Cinsiyet = $veri['Cinsiyet'];
        $UzmanlikAlani = $veri['Uzmanlık Alanı'];
        $CalistigiHastane = $veri['Çalıştığı Hastane'];
        $Sifre = $veri['Şifre'];

        // SQL sorgusunu hazırla
        $sql = "INSERT INTO Doktorlar (Ad, Soyad, UzmanlikAlani, CalistigiHastane, Sifre) 
                VALUES (:Ad, :Soyad, :UzmanlikAlani, :CalistigiHastane, :Sifre)";
        
        // SQL sorgusunu hazırla
        $stmt = $conn->prepare($sql);

        // Bağlantıyı yapılandır
        $stmt->bindParam(':Ad', $Ad);
        $stmt->bindParam(':Soyad', $Soyad);
        $stmt->bindParam(':UzmanlikAlani', $UzmanlikAlani);
        $stmt->bindParam(':CalistigiHastane', $CalistigiHastane);
        $stmt->bindParam(':Sifre', $Sifre);

        // SQL sorgusunu çalıştır
        $stmt->execute();

        echo "Yeni doktor başarıyla eklendi: $Ad $Soyad\n";
    }
} catch(PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
}
?>
