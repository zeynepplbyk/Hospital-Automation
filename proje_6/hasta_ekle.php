<?php
// Veritabanı bağlantı dosyasını dahil et
include "baglanti.php";

// Formdan gelen verileri al
$hasta_ad = $_POST['hasta_ad'];
$hasta_soyad = $_POST['hasta_soyad'];
$hasta_tc = $_POST['hasta_tc'];
$hasta_tel = $_POST['hasta_tel'];
$hasta_adres = $_POST['hasta_adres'];
$hasta_dogum = $_POST['hasta_dogum'];
$hasta_cinsiyet = $_POST['hasta_cinsiyet'];



// Rastgele bir şifre oluştur (8 karakterlik bir şifre)
$sifre = substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', 8)), 0, 8);

// Veritabanına ekleme sorgusu
$ekle_sorgu = "INSERT INTO Hastalar (HastaID, Ad, Soyad, Telefon, Adres, DogumTarihi, Cinsiyet,Sifre) VALUES ('$hasta_tc', '$hasta_ad', '$hasta_soyad', '$hasta_tel', '$hasta_adres', '$hasta_dogum', '$hasta_cinsiyet', '$sifre')";

// Sorguyu çalıştır ve sonucu kontrol et
if(mysqli_query($baglan, $ekle_sorgu)){
    echo "Hasta başarıyla eklendi.";
} else{
    echo "Hata: $ekle_sorgu <br>" . mysqli_error($baglan);
}

// Bağlantıyı kapat
mysqli_close($baglan);
?>