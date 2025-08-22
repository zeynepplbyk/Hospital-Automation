<?php
// Veritabanı bağlantı dosyasını dahil et
include "baglanti.php";

session_start();
$HastaID = $_SESSION["HastaID"];
// Randevu alma formundan veri alındığında
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["doktor"]) && isset($_POST["tarih"]) && isset($_POST["saat"])) {
    // Formdan gelen verileri al
    $selectedDoctorFullName = $_POST["doktor"];
    $selectedDate = $_POST["tarih"];
    $selectedTime = $_POST["saat"];

    // Doktor adını ve soyadını ayır
    $selectedDoctorNameParts = explode(" ", $selectedDoctorFullName);
    $selectedDoctorFirstName = $selectedDoctorNameParts[0];
    $selectedDoctorLastName = $selectedDoctorNameParts[1];

    // Doktorun ID'sini, uzmanlık alanını ve çalıştığı hastaneyi al
    $doktor_sorgu = "SELECT DoktorID, UzmanlikAlani, CalistigiHastane FROM Doktorlar WHERE Ad = '$selectedDoctorFirstName' AND Soyad = '$selectedDoctorLastName'";
    $doktor_sonuc = mysqli_query($baglan, $doktor_sorgu);

    if (mysqli_num_rows($doktor_sonuc) > 0) {
        $row = mysqli_fetch_assoc($doktor_sonuc);
        $doktorID = $row["DoktorID"];
        $uzmanlikAlani = $row["UzmanlikAlani"];
        $calistigiHastane = $row["CalistigiHastane"];

        // Aynı saatte, tarih ve hastanede başka bir randevu var mı kontrol et
        $randevu_kontrol_sorgu = "SELECT * FROM Randevular WHERE RandevuTarihi = '$selectedDate' AND RandevuSaati = '$selectedTime' AND CalistigiHastane = '$calistigiHastane'";
        $randevu_kontrol_sonuc = mysqli_query($baglan, $randevu_kontrol_sorgu);

        if (mysqli_num_rows($randevu_kontrol_sonuc) > 0) {
            echo "Üzgünüz, seçtiğiniz tarihte ve saatte bu hastanede başka bir randevu mevcut.";
        } else {
            // Benzersiz bir randevu ID oluştur
            $randevuID = mt_rand(100000, 999999); // Örnek aralık, ihtiyaca göre ayarlayabilirsiniz

            // Veritabanına randevu kaydı ekle
            $randevu_ekle_sorgu = "INSERT INTO Randevular (RandevuID, RandevuTarihi, RandevuSaati, DoktorID, HastaID, YoneticiID, CalistigiHastane, UzmanlikAlani) 
                                   VALUES ('$randevuID', '$selectedDate', '$selectedTime', '$doktorID', '$HastaID', 1, '$calistigiHastane', '$uzmanlikAlani')";
            
            // Sorguyu çalıştır ve sonucu kontrol et
            if (mysqli_query($baglan, $randevu_ekle_sorgu)) {
                echo "Randevu başarıyla oluşturuldu.";
            } else {
                echo "Hata: " . $randevu_ekle_sorgu . "<br>" . mysqli_error($baglan);
            }
        }
    } else {
        echo "Hata: Seçilen doktor bulunamadı.";
    }
}
?>