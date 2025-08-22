<?php
// Veritabanı bağlantı dosyasını dahil et
include "baglanti.php";

// Formdan gelen verileri al
$doktor_ad = $_POST['doktor_ad'];
$doktor_soyad = $_POST['doktor_soyad'];
$calistigi_hastane = $_POST['CalistigiHastane'];
$doktor_brans = $_POST['doktor_brans'];

// Benzersiz bir doktor ID oluştur
$doktorID = mt_rand(100000, 999999);

// Rastgele bir şifre oluştur (8 karakterlik bir şifre)
$sifre = substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', 8)), 0, 8);

// Veritabanına ekleme sorgusu
$ekle_sorgu = "INSERT INTO Doktorlar (DoktorID, Ad, Soyad, CalistigiHastane, UzmanlikAlani, Sifre) VALUES ('$doktorID', '$doktor_ad', '$doktor_soyad', '$calistigi_hastane', '$doktor_brans', '$sifre')";

// Sorguyu çalıştır ve sonucu kontrol et
if(mysqli_query($baglan, $ekle_sorgu)){
    echo "Doktor başarıyla eklendi. Şifre: $sifre";
} else{
    echo "Hata: $ekle_sorgu <br>" . mysqli_error($baglan);
}

// Bağlantıyı kapat
mysqli_close($baglan);
?>