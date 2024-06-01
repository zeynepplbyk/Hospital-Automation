<?php
// Veritabanı bağlantı dosyasını dahil et
include "baglanti.php";

// Oturum başlat
session_start();

if (isset($_SESSION["DoktorID"])) {
    // Oturumda bulunan Doktor ID'sini al
    $DoktorID = $_SESSION["DoktorID"];

    // Mevcut ve yeni şifreleri al
    if(isset($_POST["currentPassword"]) && isset($_POST["newPassword"])){
        $currentPassword = $_POST["currentPassword"];
        $newPassword = $_POST["newPassword"];

        // Yeni şifrenin uygunluğunu kontrol et
        $passwordRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/';
        if (!preg_match($passwordRegex, $newPassword)) {
            echo "Yeni şifre en az 8 karakter uzunluğunda olmalı, en az bir büyük harf, bir küçük harf ve bir rakam içermelidir.";
            exit;
        }

        // Mevcut şifrenin doğruluğunu kontrol et
        $check_query = "SELECT * FROM Doktorlar WHERE DoktorID = '$DoktorID' AND Sifre = '$currentPassword'";
        $check_result = mysqli_query($baglan, $check_query);

        if(mysqli_num_rows($check_result) > 0){
            // Yeni şifreyi güncelle
            $update_query = "UPDATE Doktorlar SET Sifre = '$newPassword' WHERE DoktorID = '$DoktorID'";
            $update_result = mysqli_query($baglan, $update_query);

            // Güncelleme işlemi başarılı olduysa
            if($update_result){
                echo "Şifre başarıyla güncellendi.";
            } else {
                echo "Şifre güncelleme işleminde bir hata oluştu: " . mysqli_error($baglan);
            }
        } else {
            echo "Mevcut şifre yanlış.";
        }
    } else {
        echo "Mevcut veya yeni şifre belirtilmedi.";
    }
} else {
    // Oturum başlatılmamışsa giriş yapma mesajı göster
    echo "Öncelikle giriş yapmalısınız.";
}
?>