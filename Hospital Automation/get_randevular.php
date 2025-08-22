<?php
// Öncelikle doktorun ID'sini almak için oturumu başlat
session_start();
include "baglanti.php";
// Doktorun ID'si oturumdan alınıyor
$DoktorID = $_SESSION["DoktorID"];

// Sayfa numarasını al
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Sayfa başına gösterilecek randevu sayısı
$records_per_page = 10;

// Randevuları saymak için sorguyu oluştur
$count_query = "SELECT COUNT(*) as total_records FROM Randevular WHERE DoktorID = '$DoktorID'";
$count_result = mysqli_query($baglan, $count_query);
$count_row = mysqli_fetch_assoc($count_result);
$total_records = $count_row['total_records'];

// Toplam sayfa sayısını hesapla
$total_pages = ceil($total_records / $records_per_page);

// Geçerli sayfa numarasına göre başlangıç kaydını belirle
$start_from = ($page - 1) * $records_per_page;

// Randevuları çekmek için sorguyu oluştur
$randevu_sorgu = "SELECT Randevular.RandevuID, Randevular.RandevuTarihi, Randevular.RandevuSaati, Randevular.HastaID, Hastalar.Ad, Hastalar.Soyad 
                  FROM Randevular 
                  INNER JOIN Hastalar ON Randevular.HastaID = Hastalar.HastaID 
                  WHERE Randevular.DoktorID = '$DoktorID'
                  LIMIT $start_from, $records_per_page";

// Sorguyu çalıştır ve sonucu al
$randevu_sonuc = mysqli_query($baglan, $randevu_sorgu);

// Sorguda hata var mı kontrol et
if (!$randevu_sonuc) {
    // Hata oluştuğunda ekrana yazdır
    echo "Randevuları çekerken bir hata oluştu: " . mysqli_error($baglan);
} else {
    // Eğer hata yoksa, randevuları ekrana göster
    if(mysqli_num_rows($randevu_sonuc) > 0) {
        ?>
        
        <h2>Randevular</h2>
        <table>
            <tr>
                <th>Randevu ID</th>
                <th>Hasta Adı</th>
                <th>Hasta Soyadı</th>
                <th>Hasta ID</th>
                <th>Randevu Tarihi</th>
                <th>Randevu Saati</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($randevu_sonuc)) { ?>
                <tr>
                    <td><?php echo $row['RandevuID']; ?></td>
                    <td><?php echo $row['Ad']; ?></td>
                    <td><?php echo $row['Soyad']; ?></td>
                    <td><?php echo $row['HastaID']; ?></td>
                    <td><?php echo $row['RandevuTarihi']; ?></td>
                    <td><?php echo $row['RandevuSaati']; ?></td>
                </tr>
            <?php } ?>
        </table>

        <!-- Sayfalama düğmeleri -->
        <div class="pagination"></div>

    <?php } else {
        // Randevu bulunamadıysa bir mesaj göster
        echo "Doktorunuzun henüz randevusu bulunmamaktadır.";
    }
}
?>