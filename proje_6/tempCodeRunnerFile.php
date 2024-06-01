<?php
session_start(); // Oturumu başlat

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "demo";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    

    // Doktor bilgilerini çek
    $stmt = $conn->prepare("SELECT DoktorID, CalistigiHastane, UzmanlikAlani FROM doktorlar");
    $stmt->execute();
    $doktorlar = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Doktor bilgileri rastgele randevular oluştururken kullanılacak
    $faker = Faker\Factory::create('tr_TR');

    $randevuListesi = [];  // Randevuları saklamak için boş bir dizi oluştur

    for ($hastaID = 28; $hastaID <= 1029; $hastaID++) {  // Hasta ID'lerini 28 ile 1029 arasında döngü
        for ($i = 0; $i < 100; $i++) {  // Her hasta için 100 rastgele randevu oluştur
            $randevu = [
                'RandevuID' => null,  // Randevu ID'si atanmayacak
                'RandevuTarihi' => $faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'),  // Rastgele bir tarih seç
                'RandevuSaati' => $faker->time('H:i'),  // Rastgele bir saat seç
                'HastaID' => $hastaID,  // Hasta ID'si belirlenmiş
                'DoktorID' => $faker->randomElement($doktorlar)['DoktorID'],  // Rastgele bir doktor ID seç
                'YoneticiID' => 1,  // Yönetici ID'si her zaman 1
                'CalistigiHastane' => null,  // Doktorun çalıştığı hastane bilgisi
                'UzmanlikAlani' => null  // Doktorun uzmanlık alanı bilgisi
            ];

            // Doktor bilgilerini eşleştir
            foreach ($doktorlar as $doktor) {
                if ($doktor['DoktorID'] == $randevu['DoktorID']) {
                    $randevu['CalistigiHastane'] = $doktor['CalistigiHastane'];
                    $randevu['UzmanlikAlani'] = $doktor['UzmanlikAlani'];
                    break;
                }
            }

            $randevuListesi[] = $randevu;  // Oluşturulan randevuyu diziye ekle
        }
    }

    // Verileri JSON formatına dönüştür
    $jsonData = json_encode($randevuListesi, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);  // JSON formatına dönüştür

    // JSON dosyasına yaz
    $file = '/Applications/XAMPP/xamppfiles/htdocs/proje_6/randevu_listesi.json';  // JSON dosyasının yolu
    file_put_contents($file, $jsonData);  // JSON verilerini dosyaya kaydet

    echo "100 rastgele randevu JSON dosyasına kaydedildi: $file\n";  // Başarılı kaydı doğrula
} catch(PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
}
?>