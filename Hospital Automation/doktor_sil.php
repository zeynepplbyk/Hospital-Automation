<?php
// Veritabanı bağlantı dosyasını dahil et
include "baglanti.php";

// Formdan gelen veriyi al
$doktor_id = $_POST['doktor_id'];

// Doktorun hastası olup olmadığını kontrol et
$kontrol_sorgu = "SELECT COUNT(*) AS randevu_sayisi FROM Randevular WHERE DoktorID = '$doktor_id'";
$sonuc = mysqli_query($baglan, $kontrol_sorgu);
$row = mysqli_fetch_assoc($sonuc);

if ($row['randevu_sayisi'] == 0) {
    // Eğer randevu sayısı 0 ise doktoru sil
    $sil_sorgu = "DELETE FROM Doktorlar WHERE DoktorID = '$doktor_id'";
    if (mysqli_query($baglan, $sil_sorgu)) {
        echo "Doktor başarıyla silindi.";
    } else {
        echo "Hata: $sil_sorgu <br>" . mysqli_error($baglan);
    }
} else {
    echo "Bu doktora ait randevular olduğu için doktor silinemedi.";
}

// Bağlantıyı kapat
mysqli_close($baglan);
?>