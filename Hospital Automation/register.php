<?php
include("baglanti.php"); // Veritabanı bağlantısını içe aktar

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // POST ile gelen verileri al
    $ad = $_POST["ad"];
    $soyad = $_POST["soyad"];
    $dogumTarihi = $_POST["dogumTarihi"];
    $cinsiyet = $_POST["cinsiyet"];
    $telefon = $_POST["telefon"];
    $adres = $_POST["adres"];
    $sifre = $_POST["sifre"];

    // HastaID otomatik olarak artırılacak

    // SQL enjeksiyonlarına karşı korunmak için güvenli sorgu
    $ad = mysqli_real_escape_string($baglan, $ad);
    $soyad = mysqli_real_escape_string($baglan, $soyad);
    $dogumTarihi = mysqli_real_escape_string($baglan, $dogumTarihi);
    $cinsiyet = mysqli_real_escape_string($baglan, $cinsiyet);
    $telefon = mysqli_real_escape_string($baglan, $telefon);
    $adres = mysqli_real_escape_string($baglan, $adres);
    $sifre = mysqli_real_escape_string($baglan, $sifre);

    // Yeni kullanıcıyı veritabanına ekleme
    $sql = "INSERT INTO Hastalar (Ad, Soyad, DogumTarihi, Cinsiyet, Telefon, Adres, Sifre) 
            VALUES ('$ad', '$soyad', '$dogumTarihi', '$cinsiyet', '$telefon', '$adres', '$sifre')";
    
    if ($baglan->query($sql) === TRUE) {
        echo "Yeni kullanıcı başarıyla eklendi.";
        // Burada isterseniz başarıyla eklendikten sonra kullanıcıyı bir sayfaya yönlendirebilirsiniz.
        // Örneğin:
        // header("Location: index.php");
    } else {
        echo "Hata: " . $sql . "<br>" . $baglan->error;
    }
} else {
    echo "Geçersiz istek.";
}
?>
