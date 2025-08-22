<?php
session_start();
include "baglanti.php";

$HastaID = $_SESSION["HastaID"];
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$records_per_page = 10;

$count_query = "SELECT COUNT(*) as total_records FROM Randevular WHERE HastaID = '$HastaID'";
$count_result = mysqli_query($baglan, $count_query);
$count_row = mysqli_fetch_assoc($count_result);
$total_records = $count_row['total_records'];
$total_pages = ceil($total_records / $records_per_page);
$start_from = ($page - 1) * $records_per_page;

$randevu_sorgu = "SELECT Randevular.RandevuID, Randevular.RandevuTarihi, Randevular.RandevuSaati, Randevular.DoktorID, 
Doktorlar.Ad AS DoktorAd, Doktorlar.Soyad AS DoktorSoyad, Hastaneler.HastaneAdi 
FROM Randevular 
INNER JOIN Doktorlar ON Randevular.DoktorID = Doktorlar.DoktorID 
INNER JOIN Hastaneler ON Randevular.HastaneID = Hastaneler.HastaneID 
WHERE Randevular.HastaID = '$HastaID' 
LIMIT $start_from, $records_per_page";

$randevu_sonuc = mysqli_query($baglan, $randevu_sorgu);

if (!$randevu_sonuc) {
    echo "Randevuları çekerken bir hata oluştu: " . mysqli_error($baglan);
} else {
    if (mysqli_num_rows($randevu_sonuc) > 0) {
        echo '<table>
                <tr>
                    <th>Randevu ID</th>
                    <th>Randevu Tarihi</th>
                    <th>Randevu Saati</th>
                    <th>Doktor</th>
                    <th>Hastane</th>
                    <th>Sil</th>
                </tr>';
        while ($row = mysqli_fetch_assoc($randevu_sonuc)) {
            echo '<tr>
                    <td>' . $row['RandevuID'] . '</td>
                    <td>' . $row['RandevuTarihi'] . '</td>
                    <td>' . $row['RandevuSaati'] . '</td>
                    <td>' . $row['DoktorAd'] . ' ' . $row['DoktorSoyad'] . '</td>
                    <td>' . $row['HastaneAdi'] . '</td>
                    <td><button onclick="deleteRandevu(' . $row['RandevuID'] . ')">Sil</button></td>
                </tr>';
        }
        echo '</table>';

        echo '<div class="pagination">';
        if ($page > 1) {
            echo '<a href="#" data-page="' . ($page - 1) . '"> < </a>';
        }
        echo '<a href="#" data-page="' . $page . '" class="active">' . $page . '</a>';
        if ($page < $total_pages) {
            echo '<a href="#" data-page="' . ($page + 1) . '"> > </a>';
        }
        echo '</div>';
    } else {
        echo "Henüz randevunuz bulunmamaktadır.";
    }
}
?>
