<?php
include "baglanti.php";

$hastaneler_sorgu = "SELECT DISTINCT CalistigiHastane FROM Doktorlar";
$hastaneler_sonuc = mysqli_query($baglan, $hastaneler_sorgu);

$hastaneler = array();
while ($row = mysqli_fetch_assoc($hastaneler_sonuc)) {
    $hastaneler[] = $row['CalistigiHastane'];
}

echo json_encode($hastaneler);
?>