<?php
// Veritabanı bağlantı dosyasını dahil et
include "baglanti.php";

// Oturum başlat
session_start();

if (isset($_SESSION["HastaID"])) {
    // Oturumda bulunan hasta ID'sini al
    $HastaID = $_SESSION["HastaID"];

    // Yeni telefon numarasını al
    if(isset($_POST["newPhoneNumber"])){
        $newPhoneNumber = $_POST["newPhoneNumber"];

        // Yeni telefon numarasını veritabanında güncelle
        $update_query = "UPDATE Hastalar SET Telefon = '$newPhoneNumber' WHERE HastaID = '$HastaID'";
        $update_result = mysqli_query($baglan, $update_query);

        // Güncelleme işlemi başarılı olduysa
        if($update_result){
            echo "Telefon numarası başarıyla güncellendi.";
        } else {
            echo "Telefon numarası güncelleme işleminde bir hata oluştu: " . mysqli_error($baglan);
        }
    } else {
        echo "Yeni telefon numarası belirtilmedi.";
    }
} else {
    // Oturum başlatılmamışsa giriş yapma mesajı göster
    echo "Öncelikle giriş yapmalısınız.";
}
?>