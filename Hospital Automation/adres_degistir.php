<?php
// Veritabanı bağlantı dosyasını dahil et
include "baglanti.php";

// Oturum başlat
session_start();

if (isset($_SESSION["HastaID"])) {
    // Oturumda bulunan hasta ID'sini al
    $HastaID = $_SESSION["HastaID"];

    // Yeni adresi al
    if(isset($_POST["newAddress"])){
        $newAddress = $_POST["newAddress"];

        // Yeni adresi veritabanına güncelle
        $update_query = "UPDATE Hastalar SET Adres = '$newAddress' WHERE HastaID = '$HastaID'";
        $update_result = mysqli_query($baglan, $update_query);

        // Güncelleme işlemi başarılı olduysa
        if($update_result){
            echo "Adres başarıyla güncellendi.";
        } else {
            echo "Adres güncelleme işleminde bir hata oluştu: " . mysqli_error($baglan);
        }
    } else {
        echo "Yeni adres belirtilmedi.";
    }
} else {
    // Oturum başlatılmamışsa giriş yapma mesajı göster
    echo "Öncelikle giriş yapmalısınız.";
}
?>