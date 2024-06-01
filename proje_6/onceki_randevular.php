<?php
include "baglanti.php";

session_start();
if (isset($_GET['HastaID']) && isset($_GET['page'])) {
    $HastaID = $_GET['HastaID'];
    $currentPage = (int)$_GET['page'];
    $appointmentsPerPage = 10; // Number of appointments per page

    $offset = ($currentPage - 1) * $appointmentsPerPage;

    // Fetch the appointments for the current page
    $randevular_sorgu = "SELECT Randevular.RandevuID, Randevular.RandevuTarihi, Randevular.RandevuSaati, Doktorlar.Ad AS DoktorAd, Doktorlar.Soyad AS DoktorSoyad, Doktorlar.CalistigiHastane
                         FROM Randevular
                         INNER JOIN Doktorlar ON Randevular.DoktorID = Doktorlar.DoktorID
                         WHERE Randevular.HastaID = '$HastaID'
                         LIMIT $appointmentsPerPage OFFSET $offset";

    $randevular_sonuc = mysqli_query($baglan, $randevular_sorgu);

    if (!$randevular_sonuc) {
        echo "Randevuları çekerken bir hata oluştu: " . mysqli_error($baglan);
    } else {
        if (mysqli_num_rows($randevular_sonuc) > 0) {
            echo "<h2>Randevularım</h2>";
            echo "<table>
                    <tr>
                        <th>Randevu ID</th>
                        <th>Randevu Tarihi</th>
                        <th>Randevu Saati</th>
                        <th>Doktor</th>
                        <th>Hastane</th>
                        <th>Sil</th>
                    </tr>";

            while ($row = mysqli_fetch_assoc($randevular_sonuc)) {
                echo "<tr>
                        <td>{$row['RandevuID']}</td>
                        <td>{$row['RandevuTarihi']}</td>
                        <td>{$row['RandevuSaati']}</td>
                        <td>{$row['DoktorAd']} {$row['DoktorSoyad']}</td>
                        <td>{$row['CalistigiHastane']}</td>
                        <td><button class='sil-randevu' data-id='{$row['RandevuID']}'>Sil</button></td>
                    </tr>";
            }
            echo "</table>";
        } else {
            echo "Henüz randevunuz bulunmamaktadır.";
        }

        // Get the total number of appointments for the patient
        $totalQuery = "SELECT COUNT(*) as total FROM Randevular WHERE HastaID = '$HastaID'";
        $totalResult = mysqli_query($baglan, $totalQuery);
        $totalRow = mysqli_fetch_assoc($totalResult);
        $totalAppointments = $totalRow['total'];

        // Calculate total pages
        $totalPages = ceil($totalAppointments / $appointmentsPerPage);

        // Generate pagination buttons
        echo "<div class='pagination'>";
        for ($i = 1; $i <= $totalPages; $i++) {
            echo "<button class='pagination-btn' data-page='$i'>$i</button>";
        }
        echo "</div>";
    }
}
?>