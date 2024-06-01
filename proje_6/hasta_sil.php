<?php
// Veritabanı bağlantı dosyasını dahil et
include "baglanti.php";

// Formdan gelen veriyi al
$hasta_id = $_POST['hasta_id'];

// Hasta randevusu olup olmadığını kontrol et
$kontrol_sorgu = "SELECT COUNT(*) AS randevu_sayisi FROM Randevular WHERE HastaID = '$hasta_id'";
$sonuc = mysqli_query($baglan, $kontrol_sorgu);
$row = mysqli_fetch_assoc($sonuc);

if ($row['randevu_sayisi'] == 0) {
    // Eğer randevu sayısı 0 ise hasta sil
    $sil_sorgu = "DELETE FROM Hastalar WHERE HastaID = '$hasta_id'";
    if (mysqli_query($baglan, $sil_sorgu)) {
        echo "Hasta başarıyla silindi.";
    } else {
        echo "Hata: $sil_sorgu <br>" . mysqli_error($baglan);
    }
} else {
    echo "Bu hastaya ait randevular olduğu için hasta silinemedi.";
}

// Bağlantıyı kapat
mysqli_close($baglan);
?>