<?php
include "baglanti.php"; // Veritabanı bağlantı dosyasını dahil et

// Dosyayı al
$dosyaAdi = $_FILES['dosya']['name'];
$geciciDosyaYolu = $_FILES['dosya']['tmp_name'];
$hedefDosyaYolu = "uploads/" . $dosyaAdi;

// Dosyayı sunucuya kaydet
if (move_uploaded_file($geciciDosyaYolu, $hedefDosyaYolu)) {
    echo "Dosya başarıyla yüklendi.";
} else {
    echo "Dosya yüklenirken bir hata oluştu.";
}

// Dosya URL'sini ve ilişkili raporun ID'sini veritabanına kaydet
$dosyaURL = "http://example.com/" . $hedefDosyaYolu; // Örnek URL, kendi alan adınıza göre değiştirin
$raporID = $_POST['raporID']; // Eğer bir rapor ID'si formdan gelmiyorsa, gerekirse burada alınmalıdır

$sql = "INSERT INTO ResimDosyalari (DosyaURL, RaporID) VALUES ('$dosyaURL', $raporID)";

if (mysqli_query($baglan, $sql)) {
    echo "Dosya URL'si başarıyla veritabanına eklendi.";
} else {
    echo "Dosya URL'si eklenirken bir hata oluştu: " . mysqli_error($baglan);
}

mysqli_close($baglan); // Veritabanı bağlantısını kapat
?>
