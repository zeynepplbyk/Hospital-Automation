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
    $json_data = file_get_contents('hasta_listesi.json');
    // JSON verisini diziye dönüştür
    $veriler = json_decode($json_data, true);

    // Veritabanına verileri ekleyin
    foreach ($veriler as $index => $veri) {
        // Veri öğelerini al
        $Ad = $veri['Ad'];
        $Soyad = $veri['Soyad'];
        $DogumTarihi = $veri['DogumTarihi'];
        $Cinsiyet = $veri['Cinsiyet'];
        $Telefon = $veri['Telefon'];
        $Adres = $veri['Adres'];
        $Sifre = $veri['Sifre'];

        // SQL sorgusunu hazırla
        $sql = "INSERT INTO Hastalar (Ad, Soyad, DogumTarihi, Cinsiyet, Telefon, Adres, Sifre) 
                VALUES (:Ad, :Soyad, :DogumTarihi, :Cinsiyet, :Telefon, :Adres, :Sifre)";
        
        // SQL sorgusunu hazırla
        $stmt = $conn->prepare($sql);

        // Bağlantıyı yapılandır
        $stmt->bindParam(':Ad', $Ad);
        $stmt->bindParam(':Soyad', $Soyad);
        $stmt->bindParam(':DogumTarihi', $DogumTarihi);
        $stmt->bindParam(':Cinsiyet', $Cinsiyet);
        $stmt->bindParam(':Telefon', $Telefon);
        $stmt->bindParam(':Adres', $Adres);
        $stmt->bindParam(':Sifre', $Sifre);

        // SQL sorgusunu çalıştır
        $stmt->execute();

        echo "Yeni kullanıcı başarıyla eklendi: $Ad $Soyad\n";
    }
} catch(PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
}
?>