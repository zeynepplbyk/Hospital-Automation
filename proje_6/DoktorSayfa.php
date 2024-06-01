<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Doktor Randevuları ve Tıbbi Raporlar</title>
    <link rel="stylesheet" href="hasta.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div id="randevular">
        <!-- Buraya randevuların geleceği alan -->
        <?php include_once 'get_randevular.php'; ?>
    </div>
    <!-- Sayfalama düğmeleri -->
    <div class="pagination"></div>

    <script>
        function generatePagination(page, total_pages) {
            var pagination_html = '<div class="pagination">';
            if (page > 1) {
                pagination_html += '<a href="#" onclick="getRandevular(1)">&laquo;</a>';
                pagination_html += '<a href="#" onclick="getRandevular(' + (page - 1) + ')">&lsaquo;</a>';
            }
            for (var i = Math.max(1, page - 2); i <= Math.min(page + 2, total_pages); i++) {
                pagination_html += '<a href="#" onclick="getRandevular(' + i + ')"';
                if (i == page) {
                    pagination_html += ' class="active"';
                }
                pagination_html += '>' + i + '</a>';
            }
            if (page < total_pages) {
                pagination_html += '<a href="#" onclick="getRandevular(' + (page + 1) + ')">&rsaquo;</a>';
                pagination_html += '<a href="#" onclick="getRandevular(' + total_pages + ')">&raquo;</a>';
            }
            pagination_html += '</div>';

            $('.pagination').html(pagination_html);
        }

        function getRandevular(page) {
            $.ajax({
                url: 'get_randevular.php?page=' + page,
                type: 'GET',
                success: function(response){
                    $('#randevular').html(response); // Sadece randevuları güncelle
                    generatePagination(page, <?php echo $total_pages; ?>); // Sayfalama düğmelerini oluştur
                },
                error: function(xhr, status, error){
                    console.error(xhr.responseText);
                }
            });
        }
        
        $(document).ready(function(){
            // Sayfa yüklendiğinde randevuları almak için AJAX çağrısı yap
            getRandevular(<?php echo $page; ?>);
        });
    </script>

    <h3>Tıbbi Rapor Ekle</h3>
    <form id="raporForm">
        <label for="hastaID">Hasta ID:</label>
        <input type="text" name="hastaID" id="hastaID" required><br>

        <label for="raporTarihi">Rapor Tarihi:</label>
        <input type="date" name="raporTarihi" id="raporTarihi" required><br>

        <label for="raporIcerigi">Rapor İçeriği:</label>
        <textarea name="raporIcerigi" id="raporIcerigi" required></textarea><br>

        <label for="raporURL">Rapor URL:</label>
        <input type="text" name="raporURL" id="raporURL" required><br>

        <button type="submit">Rapor Ekle</button>
    </form>

    <div id="raporSonuc"></div>

    <h3>Doktor Şifre Değiştirme</h3>
    <form id="passwordForm">
        <label for="currentPassword">Mevcut Şifre:</label>
        <input type="password" id="currentPassword" name="currentPassword"><br><br>

        <label for="newPassword">Yeni Şifre:</label>
        <input type="password" id="newPassword" name="newPassword"><br><br>

        <label for="confirmPassword">Yeni Şifreyi Onayla:</label>
        <input type="password" id="confirmPassword" name="confirmPassword"><br><br>

        <button type="submit">Değiştir</button>
    </form>

    <div id="passwordResult"></div>

    <h3>Hasta Raporlarını Görüntüle</h3>
    <label for="HastaID">Hasta ID:</label>
    <input type="number" id="HastaID" name="HastaID" required>
    <button onclick="getRaporlar()">Raporları Görüntüle</button>
    <button onclick="deleteRapor()">Sil</button>
    <div id="raporListesi"></div>

    <script>
        function getRaporlar() {
            var hastaID = document.getElementById("HastaID").value;
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        document.getElementById("raporListesi").innerHTML = xhr.responseText;
                    } else {
                        console.error("Bir hata oluştu.");
                    }
                }
            };
            xhr.open("POST", "rapor_goruntule.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("HastaID=" + hastaID);
        }
        
        // Raporları silmek için fonksiyon
        function deleteRapor(raporID) {
            $.ajax({
                url: 'delete_rapor.php',
                type: 'POST',
                data: { raporID: raporID },
                success: function(response) {
                    if (response == 'success') {
                        $("#rapor-" + raporID).remove(); // Raporu DOM'dan kaldır
                    } else {
                        console.error("Rapor silinemedi.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    </script>
</body>
</html>

    <h3>Hasta Raporlarını Görüntüle</h3>
    <label for="HastaID">Hasta ID:</label>
    <input type="number" id="HastaID" name="HastaID" required>
    <button onclick="getRaporlar()">Raporları Görüntüle</button>
    <button onclick="deleteRapor()">Sil</button>
    <div id="raporListesi"></div>

    <script>
        function getRaporlar() {
            var hastaID = document.getElementById("HastaID").value;
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        document.getElementById("raporListesi").innerHTML = xhr.responseText;
                    } else {
                        console.error("Bir hata oluştu.");
                    }
                }
            };
            xhr.open("POST", "rapor_goruntule.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("HastaID=" + hastaID);
        }
        
          // Raporları silmek için fonksiyon
          window.deleteRapor = function(raporID) {
                $.ajax({
                    url: 'delete_rapor.php',
                    type: 'POST',
                    data: { raporID: raporID },
                    success: function(response) {
                        if (response == 'success') {
                            $("#rapor-" + raporID).remove(); // Raporu DOM'dan kaldır
                        } else {
                            console.error("Rapor silinemedi.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
    </script>
</body>
</html>