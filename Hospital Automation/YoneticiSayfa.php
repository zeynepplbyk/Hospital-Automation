<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doktor ve Hasta Yönetimi</title>
    <link rel="stylesheet" href="Yntc.css"> <!-- CSS dosyasına göreli bağlantı -->
    <script>
        function submitForm(formId, actionURL) {
            var form = document.getElementById(formId);
            var formData = new FormData(form);
            var xhr = new XMLHttpRequest();
            xhr.open("POST", actionURL, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // İşlem başarılı
                        console.log(xhr.responseText);
                        // Burada başka bir işlem yapabilirsiniz, örneğin geri dönen veriyi işleyebilir veya kullanıcıya bir mesaj gösterebilirsiniz.
                    } else {
                        // İşlem başarısız
                        console.error('Form gönderilirken bir hata oluştu.');
                    }
                }
            };
            xhr.send(formData);
        }
    </script>
</head>
<body>
    <h2>Yönetici</h2>
    
    <!-- Doktor Ekleme Formu -->
    <h3>Doktor Ekle</h3>
    <form id="doktor_ekle_form" onsubmit="event.preventDefault(); submitForm('doktor_ekle_form', 'doktor_ekle.php')" method="POST">
        <label for="doktor_ad">Doktor Adı:</label><br>
        <input type="text" id="doktor_ad" name="doktor_ad" required><br><br>
        <label for="doktor_soyad">Doktor Soyadı:</label><br>
        <input type="text" id="doktor_soyad" name="doktor_soyad" required><br><br>
        <label for="CalistigiHastane">Çalıştığı Hastane:</label><br>
        <input type="text" id="CalistigiHastane" name="CalistigiHastane" required><br><br>
        <label for="doktor_brans">Doktor Branşı:</label><br>
        <input type="text" id="doktor_brans" name="doktor_brans" required><br><br>
        <input type="submit" value="Doktor Ekle">
    </form>
    
    <!-- Doktor Silme Formu -->
    <h3>Doktor Sil</h3>
    <form id="doktor_sil_form" onsubmit="event.preventDefault(); submitForm('doktor_sil_form', 'doktor_sil.php')" method="POST">
        <label for="doktor_id">Doktor ID:</label><br>
        <input type="number" id="doktor_id" name="doktor_id" required><br><br>
        <input type="submit" value="Doktor Sil">
    </form>
    
    <!-- Hasta Ekleme Formu -->
    <h3>Hasta Ekle</h3>
    <form id="hasta_ekle_form" onsubmit="event.preventDefault(); submitForm('hasta_ekle_form', 'hasta_ekle.php')" method="POST">
        <label for="hasta_ad">Hasta Adı:</label><br>
        <input type="text" id="hasta_ad" name="hasta_ad" required><br><br>
        <label for="hasta_soyad">Hasta Soyadı:</label><br>
        <input type="text" id="hasta_soyad" name="hasta_soyad" required><br><br>
        <label for="hasta_tc">TC Kimlik No:</label><br>
        <input type="text" id="hasta_tc" name="hasta_tc" required><br><br>
        <label for="hasta_tel">Telefon Numarası:</label><br>
        <input type="text" id="hasta_tel" name="hasta_tel" required><br><br>
        <label for="hasta_adres">Adres:</label><br>
        <input type="text" id="hasta_adres" name="hasta_adres" required><br><br>
        <label for="hasta_dogum">Doğum Tarihi:</label><br>
        <input type="date" id="hasta_dogum" name="hasta_dogum" required><br><br>
        <label for="hasta_cinsiyet">Cinsiyet:</label><br>
        <select id="hasta_cinsiyet" name="hasta_cinsiyet" required>
            <option value="Erkek">Erkek</option>
            <option value="Kadın">Kadın</option>
        </select><br><br>
        <input type="submit" value="Hasta Ekle">
    </form>
    
    <!-- Hasta Silme Formu -->
    <h3>Hasta Sil</h3>
    <form id="hasta_sil_form" onsubmit="event.preventDefault(); submitForm('hasta_sil_form', 'hasta_sil.php')" method="POST">
        <label for="hasta_id">Hastanın TC'si:</label><br>
        <input type="number" id="hasta_id" name="hasta_id" required><br><br>
        <input type="submit" value="Hastayı Sil">
    </form>
</body>
</html>
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
    </div>

    <h3>Tıbbi Rapor Ekle</h3>
    <form id="raporForm">
        <label for="hastaID">Hasta ID:</label>
        <input type="text" name="hastaID" id="hastaID" required><br>

        <label for="doktorID">Doktor ID:</label>
        <input type="text" name="doktorID" id="doktorID" required><br>

        <label for="raporTarihi">Rapor Tarihi:</label>
        <input type="date" name="raporTarihi" id="raporTarihi" required><br>

        <label for="raporIcerigi">Rapor İçeriği:</label>
        <textarea name="raporIcerigi" id="raporIcerigi" required></textarea><br>

        <label for="raporURL">Rapor URL:</label>
        <input type="text" name="raporURL" id="raporURL" required><br>

        <button type="submit">Rapor Ekle</button>
    </form>

    <div id="raporSonuc"></div>
    <script>
        $(document).ready(function(){
            // Sayfa yüklendiğinde randevuları almak için Ajax çağrısı yap
            $.ajax({
                url: 'get_randevular.php',
                type: 'GET',
                success: function(response){
                    $('#randevular').html(response);
                },
                error: function(xhr, status, error){
                    console.error(xhr.responseText);
                }
            });

            // Tıbbi rapor ekleme formunu submit ettiğinde AJAX isteği yap
            $("#raporForm").submit(function(event){
                event.preventDefault(); // Formun normal submit işlemini engelle

                var formData = {
                    hastaID: $("#hastaID").val(),
                    doktorID: $("#doktorID").val(),
                    raporTarihi: $("#raporTarihi").val(),
                    raporIcerigi: $("#raporIcerigi").val(),
                    raporURL: $("#raporURL").val()
                };

                $.ajax({
                    url: 'yupload_rapor.php',
                    type: 'POST',
                    data: formData,
                    success: function(response){
                        $("#raporSonuc").html(response); // Sonucu göster
                    },
                    error: function(xhr, status, error){
                        $("#raporSonuc").html(xhr.responseText); // Hata mesajını göster
                    }
                });
            });

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

            // Hasta raporlarını görüntülemek için fonksiyon
            window.getRaporlar = function() {
                var hastaID = document.getElementById("HastaID").value;
                $.ajax({
                    url: 'rapor_goruntule.php',
                    type: 'POST',
                    data: { HastaID: hastaID },
                    success: function(response) {
                        $("#raporListesi").html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error("Bir hata oluştu.");
                    }
                });
            }
        });
    </script>

    <h3>Hasta Raporlarını Görüntüle</h3>
    <label for="HastaID">Hasta ID:</label>
    <input type="number" id="HastaID" name="HastaID" required>
    <button onclick="getRaporlar()">Raporları Görüntüle</button>

    <div id="raporListesi"></div>
</body>
</html>