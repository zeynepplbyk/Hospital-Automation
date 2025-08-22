<?php
session_start();
include "baglanti.php";

// Kullanıcı oturumu açık mı kontrol et
if(!isset($_SESSION["DoktorID"])) {
    header("Location: giris.php");
    exit();
}

// Formdan gelen verileri al
$ad = $_POST["ad"];
$soyad = $_POST["soyad"];
$telefon = $_POST["telefon"];
$adres = $_POST["adres"];

// Doktorun ID'sini al
$doktorID = $_SESSION["DoktorID"];

// Bilgileri güncelle
$guncelle_sorgu = "UPDATE Doktorlar 
                   SET Ad = '$ad', Soyad = '$soyad', Telefon = '$telefon', Adres = '$adres' 
                   WHERE DoktorID = '$doktorID'";
$guncelle_sonuc = mysqli_query($baglan, $guncelle_sorgu);

if($guncelle_sonuc) {
    echo "Bilgiler başarıyla güncellendi.";
} else {
    echo "Bilgiler güncellenirken bir hata oluştu: " . mysqli_error($baglan);
}
?>
