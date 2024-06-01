<?php
require 'vendor/autoload.php';  // Composer otomatik yükleme dosyasını dahil et

$host = 'localhost';
$db = 'demo';  // Veritabanı adı
$user = 'root';  // Kullanıcı adı
$password = 'sifre';  // Şifre

// PDO kullanarak veritabanı bağlantısı oluştur
$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  // Hata modunu ayarla

// Doktor JSON verilerini oku
$doktorJsonPath = '/Users/zeynep/yeni_proje/doktor_listesi.json';  // Doktor JSON dosyasının yolu
$doktorJson = file_get_contents($doktorJsonPath);
$doktorlar = json_decode($doktorJson, true);  // JSON'u diziye dönüştür

// Doktorlar tablosuna veri eklemek için SQL komutunu oluştur
foreach ($doktorlar as $doktor) {
    // Doğru sütun adlarını kullanarak SQL komutunu oluştur
    $sql = "INSERT INTO Doktorlar (DoktorID, Ad, Soyad, UzmanlikAlani, Sifre, CalistigiHastane) 
            VALUES (:DoktorID, :Ad, :Soyad, :UzmanlikAlani, :Sifre, :CalistigiHastane)";

    $stmt = $pdo->prepare($sql);  // SQL komutunu hazırla
    $stmt->execute([  // Parametreleri SQL komutuna bağla
        ':DoktorID' => $doktor['DoktorID'],
        ':Ad' => $doktor['Ad'],
        ':Soyad' => $doktor['Soyad'],
        ':UzmanlikAlani' => $doktor['Uzmanlık Alanı'],
        ':Sifre' => $doktor['Şifre'],
        ':CalistigiHastane' => $doktor['Çalıştığı Hastane'],
    ]);
}

echo "Doktorlar tablosuna veri başarıyla eklendi.\n";
