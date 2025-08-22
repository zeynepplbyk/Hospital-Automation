<?php
include "baglanti.php";

if (isset($_GET['hastane'])) {
    $selectedHospital = $_GET['hastane'];
    $uzmanlik_sorgu = "SELECT DISTINCT UzmanlikAlani FROM Doktorlar WHERE CalistigiHastane = '$selectedHospital'";
    $uzmanlik_sonuc = mysqli_query($baglan, $uzmanlik_sorgu);

    $uzmanliklar = array();
    while ($row = mysqli_fetch_assoc($uzmanlik_sonuc)) {
        $uzmanliklar[] = $row['UzmanlikAlani'];
    }

    echo json_encode($uzmanliklar);
}
?>