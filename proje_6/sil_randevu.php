<?php
include "baglanti.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['randevuID'])) {
    $randevuID = $_POST['randevuID'];

    // Ensure that randevuID is an integer to prevent SQL injection
    $randevuID = intval($randevuID);

    // Delete the specific appointment
    $sil_sorgu = "DELETE FROM Randevular WHERE RandevuID = $randevuID";
    $sonuc = mysqli_query($baglan, $sil_sorgu);

    if ($sonuc) {
        echo "Randevu başarıyla silindi.";
    } else {
        echo "Randevuyu silerken bir hata oluştu: " . mysqli_error($baglan);
    }
}
?>