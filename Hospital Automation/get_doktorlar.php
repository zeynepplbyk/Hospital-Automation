<?php
include "baglanti.php";

if (isset($_GET['hastane']) && isset($_GET['uzmanlik'])) {
    $selectedHospital = $_GET['hastane'];
    $selectedSpecialty = $_GET['uzmanlik'];
    $doktorlar_sorgu = "SELECT Ad, Soyad FROM Doktorlar WHERE CalistigiHastane = '$selectedHospital' AND UzmanlikAlani = '$selectedSpecialty'";
    $doktorlar_sonuc = mysqli_query($baglan, $doktorlar_sorgu);

    $doktorlar = array();
    while ($row = mysqli_fetch_assoc($doktorlar_sonuc)) {
        $doktorlar[] = $row['Ad'] . ' ' . $row['Soyad'];
    }

    echo json_encode($doktorlar);
}
?>