<?php
include "baglanti.php";

session_start();
$HastaID = $_SESSION["HastaID"];
$selectedHospital = "";
$selectedSpecialty = "";

// Hastane seçimi yapıldığında
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["hastane"])) {
    $selectedHospital = $_POST["hastane"];
    $uzmanlik_sorgu = "SELECT DISTINCT UzmanlikAlani FROM Doktorlar WHERE CalistigiHastane = '$selectedHospital'";
    $uzmanlik_sonuc = mysqli_query($baglan, $uzmanlik_sorgu);
}

// Uzmanlık alanı seçimi yapıldığında
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["uzmanlik"])) {
    $selectedSpecialty = $_POST["uzmanlik"];
    $doktorlar_sorgu = "SELECT Ad, Soyad FROM Doktorlar WHERE CalistigiHastane = '$selectedHospital' AND UzmanlikAlani = '$selectedSpecialty'";
    $doktorlar_sonuc = mysqli_query($baglan, $doktorlar_sorgu);
}

// Randevu silme işlemi için POST verisi kontrol edilir
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sil"]) && isset($_POST["randevuID"])) {
    $randevuID = $_POST["randevuID"];
    $silme_sorgu = "DELETE FROM Randevular WHERE RandevuID = '$randevuID'";
    $silme_sonuc = mysqli_query($baglan, $silme_sorgu);
    
    if ($silme_sonuc) {
        echo "<script>alert('Randevu başarıyla silindi.');</script>";
    } else {
        echo "<script>alert('Randevuyu silerken bir hata oluştu.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ana Sayfa</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <!-- Hasta adresini değiştirebileceği form -->
    <h3>Hasta Adres Değiştirme</h3>
    <form id="addressForm">
        <label for="newAddress">Yeni Adres:</label>
        <input type="text" id="newAddress" name="newAddress">
        <button type="submit">Değiştir</button>
    </form>

    <!-- Sonuçların gösterileceği div -->
    <div id="addressResult"></div>

    <script>
        $(document).ready(function(){
            // Adres değiştirme formunu submit ettiğinde AJAX isteği yap
            $("#addressForm").submit(function(event){
                event.preventDefault(); // Formun normal submit işlemini engelle
                var newAddress = $("#newAddress").val(); // Yeni adresi al

                // AJAX isteği gönder
                $.ajax({
                    type: "POST",
                    url: "adres_degistir.php",
                    data: { newAddress: newAddress },
                    success: function(response){
                        $("#addressResult").html(response); // Sonucu göster
                    }
                });
            });
        });
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ana Sayfa</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <!-- Hasta telefon numarasını değiştirebileceği form -->
    <h3>Hasta Telefon Numarası Değiştirme</h3>
    <form id="phoneForm">
        <label for="newPhoneNumber">Yeni Telefon Numarası:</label>
        <input type="text" id="newPhoneNumber" name="newPhoneNumber">
        <button type="submit">Değiştir</button>
    </form>

    <!-- Sonuçların gösterileceği div -->
    <div id="phoneResult"></div>

    <script>
        $(document).ready(function(){
            // Telefon numarası değiştirme formunu submit ettiğinde AJAX isteği yap
            $("#phoneForm").submit(function(event){
                event.preventDefault(); // Formun normal submit işlemini engelle
                var newPhoneNumber = $("#newPhoneNumber").val(); // Yeni telefon numarasını al

                // AJAX isteği gönder
                $.ajax({
                    type: "POST",
                    url: "telefon_degistir.php",
                    data: { newPhoneNumber: newPhoneNumber },
                    success: function(response){
                        $("#phoneResult").html(response); // Sonucu göster
                    }
                });
            });
        });
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ana Sayfa</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <!-- Hasta şifresini değiştirebileceği form -->
    <h3>Hasta Şifre Değiştirme</h3>
    <form id="passwordForm">
        <label for="currentPassword">Mevcut Şifre:</label>
        <input type="password" id="currentPassword" name="currentPassword"><br><br>

        <label for="newPassword">Yeni Şifre:</label>
        <input type="password" id="newPassword" name="newPassword"><br><br>

        <label for="confirmPassword">Yeni Şifreyi Onayla:</label>
        <input type="password" id="confirmPassword" name="confirmPassword"><br><br>

        <button type="submit">Değiştir</button>
    </form>

    <!-- Sonuçların gösterileceği div -->
    <div id="passwordResult"></div>

    <script>
        $(document).ready(function(){
            // Şifre değiştirme formunu submit ettiğinde AJAX isteği yap
            $("#passwordForm").submit(function(event){
                event.preventDefault(); // Formun normal submit işlemini engelle
                var currentPassword = $("#currentPassword").val(); // Mevcut şifreyi al
                var newPassword = $("#newPassword").val(); // Yeni şifreyi al
                var confirmPassword = $("#confirmPassword").val(); // Yeni şifreyi tekrar al

                // Yeni şifrenin doğruluğunu kontrol et
                var passwordRegex = /^(?=.[a-z])(?=.[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
                if (!passwordRegex.test(newPassword)) {
                    $("#passwordResult").html("Yeni şifre en az 8 karakter uzunluğunda olmalı, en az bir büyük harf, bir küçük harf ve bir rakam içermelidir.");
                    return; // Şifre koşullarına uymazsa işlemi sonlandır
                }

                // Yeni şifrelerin aynı olup olmadığını kontrol et
                if (newPassword !== confirmPassword) {
                    $("#passwordResult").html("Yeni şifreler eşleşmiyor. Lütfen aynı şifreyi iki kez girin.");
                    return; // Şifreler eşleşmezse işlemi sonlandır
                }

                // AJAX isteği gönder
                $.ajax({
                    type: "POST",
                    url: "sifre_degistir.php",
                    data: {
                        currentPassword: currentPassword,
                        newPassword: newPassword
                    },
                    success: function(response){
                        $("#passwordResult").html(response); // Sonucu göster
                    }
                });
            });
        });
    </script>
</body>
</html>


<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Randevu Alma ve Görüntüleme</title>
    <link rel="stylesheet" href="hasta.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Hastaneleri yükle
            $.ajax({
                url: 'get_hastaneler.php',
                method: 'GET',
                success: function(data) {
                    var hastaneler = JSON.parse(data);
                    var hastaneSelect = $('#hastane');
                    hastaneSelect.empty();
                    hastaneSelect.append('<option value="">Hastane Seçin</option>');
                    hastaneler.forEach(function(hastane) {
                        hastaneSelect.append('<option value="' + hastane + '">' + hastane + '</option>');
                    });
                }
            });

            // Hastane seçildiğinde uzmanlık alanlarını yükle
            $('#hastane').change(function() {
                var selectedHospital = $(this).val();
                if (selectedHospital) {
                    $.ajax({
                        url: 'get_uzmanliklar.php',
                        method: 'GET',
                        data: { hastane: selectedHospital },
                        success: function(data) {
                            var uzmanliklar = JSON.parse(data);
                            var uzmanlikSelect = $('#uzmanlik');
                            uzmanlikSelect.empty();
                            uzmanlikSelect.append('<option value="">Uzmanlık Seçin</option>');
                            uzmanliklar.forEach(function(uzmanlik) {
                                uzmanlikSelect.append('<option value="' + uzmanlik + '">' + uzmanlik + '</option>');
                            });
                        }
                    });
                }
            });

            // Uzmanlık seçildiğinde doktorları yükle
            $('#uzmanlik').change(function() {
                var selectedHospital = $('#hastane').val();
                var selectedSpecialty = $(this).val();
                if (selectedHospital && selectedSpecialty) {
                    $.ajax({
                        url: 'get_doktorlar.php',
                        method: 'GET',
                        data: {
                            hastane: selectedHospital,
                            uzmanlik: selectedSpecialty
                        },
                        success: function(data) {
                            var doktorlar = JSON.parse(data);
                            var doktorSelect = $('#doktor');
                            doktorSelect.empty();
                            doktorSelect.append('<option value="">Doktor Seçin</option>');
                            doktorlar.forEach(function(doktor) {
                                doktorSelect.append('<option value="' + doktor + '">' + doktor + '</option>');
                            });
                        }
                    });
                }
            });

            // Randevu al butonuna tıklandığında
           $('#randevu-al-btn').click(function(e) {
    e.preventDefault(); // Formun otomatik olarak submit olmasını engelle
    var formData = $('form').serialize(); // Form verilerini al
    $.ajax({
        url: 'randevu_al.php',
        method: 'POST',
        data: formData,
        success: function(response) {
            alert(response); // Yanıtı alert olarak göster
            loadAppointments(currentPage);
        }
    });
});


          // Sayfalama işlemi için gerekli değişkenler
var currentPage = 1;
var appointmentsPerPage = 10;
var currentPage = 1;

// Load appointments for the first time
loadAppointments(currentPage);

// Function to load appointments
function loadAppointments(page) {
    $.ajax({
        url: 'onceki_randevular.php',
        method: 'GET',
        data: {
            HastaID: <?php echo $HastaID; ?>,
            page: page
        },
        success: function(data) {
            $('#randevular').html(data);
        }
    });
}

// Pagination button click event
$(document).on('click', '.pagination-btn', function() {
    currentPage = $(this).data('page');
    loadAppointments(currentPage);
});

            // Delete appointment
    $(document).on('click', '.sil-randevu', function() {
        var randevuID = $(this).data('id');
        if (confirm('Bu randevuyu silmek istediğinize emin misiniz?')) {
            $.ajax({
                url: 'sil_randevu.php',
                method: 'POST',
                data: { randevuID: randevuID },
                success: function(response) {
                    alert(response);
                    loadAppointments(currentPage);
                }
            });
        }
    });
});
    </script>
</head>
<body>
    <h2>Randevu Alma Formu</h2>
    <form id="randevu-form">
        <label for="hastane">Hastane Seçin:</label>
        <select name="hastane" id="hastane"></select><br><br>

        <label for="uzmanlik">Uzmanlık Alanı Seçin:</label>
        <select name="uzmanlik" id="uzmanlik"></select><br><br>

        <label for="doktor">Doktor Seçin:</label>
        <select name="doktor" id="doktor"></select><br><br>

        <label for="tarih">Tarih Seçin:</label>
        <input type="date" name="tarih" id="tarih" min="<?php echo date('Y-m-d'); ?>"><br><br>

        <label for="saat">Saat Seçin:</label>
        <select name="saat" id="saat">
            <?php
            $start_hour = 8;
            $end_hour = 16;
            for ($hour = $start_hour; $hour <= $end_hour; $hour++) {
                for ($minute = 0; $minute < 60; $minute += 10) {
                    $time = sprintf("%02d:%02d", $hour, $minute);
                    echo "<option value='$time'>$time</option>";
                }
            }
            ?>
        </select><br><br>

        <button type="button" id="randevu-al-btn">Randevu Al</button>
    </form>

  
    <div id="randevular"></div>

<div id="pagination"></div>
</body>
</html>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Hasta Raporları</title>
    <link rel="stylesheet" href="hasta.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <h3>Hasta Raporları</h3>
    <div id="hastaRaporListesi"></div>

    <h3>Rapor Ekle</h3>
    <form id="raporEkleForm">
        <label for="doktorID">Doktor ID:</label>
        <input type="number" name="doktorID" id="doktorID" required><br>

        <label for="raporTarihi">Rapor Tarihi:</label>
        <input type="date" name="raporTarihi" id="raporTarihi" required><br>

        <label for="raporIcerigi">Rapor İçeriği:</label>
        <textarea name="raporIcerigi" id="raporIcerigi" required></textarea><br>

        <label for="raporURL">Rapor URL:</label>
        <input type="url" name="raporURL" id="raporURL" required><br>

        <button type="submit">Rapor Ekle</button>
    </form>
    <div id="raporSonuc"></div>

    <script>
        $(document).ready(function() {
            // Sayfa yüklendiğinde hasta raporlarını getirmek için Ajax çağrısı yap
            getHastaRaporlari();

            // Hasta raporlarını getirmek için fonksiyon
            function getHastaRaporlari() {
                $.ajax({
                    url: 'hasta_rapor_goruntule.php',
                    type: 'POST',
                    success: function(response) {
                        $("#hastaRaporListesi").html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error("Bir hata oluştu: " + xhr.responseText);
                    }
                });
            }

            // Raporları silmek için fonksiyon
            window.deleteRapor = function(raporID) {  // Fonksiyonu global hale getir
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
                        console.error("Bir hata oluştu: " + xhr.responseText);
                    }
                });
            }

            // Rapor ekleme formu submit edildiğinde AJAX ile veriyi gönder
            $("#raporEkleForm").submit(function(event) {
                event.preventDefault();
                var formData = {
                    doktorID: $("#doktorID").val(),
                    raporTarihi: $("#raporTarihi").val(),
                    raporIcerigi: $("#raporIcerigi").val(),
                    raporURL: $("#raporURL").val()
                };

                $.ajax({
                    url: 'hasta_rapor_ekle.php',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $("#raporSonuc").html(response);
                        getHastaRaporlari(); // Raporları yeniden yükle
                    },
                    error: function(xhr, status, error) {
                        $("#raporSonuc").html(xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>
</html>


<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Hasta Raporları</title>
    <link rel="stylesheet" href="hasta.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>

<div id="randevular">
<div id="pagination"></div>
        <!-- Buraya randevuların geleceği alan -->
    </div>

    
    <script>
        $(document).ready(function() {
            // Sayfa yüklendiğinde hasta raporlarını getirmek için Ajax çağrısı yap
            getHastaRaporlari();

            // Hasta raporlarını getirmek için fonksiyon
            function getHastaRaporlari() {
                $.ajax({
                    url: 'hasta_rapor_goruntule.php',
                    type: 'POST',
                    success: function(response) {
                        $("#hastaRaporListesi").html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error("Bir hata oluştu: " + xhr.responseText);
                    }
                });
            }
          
            // Raporları silmek için fonksiyon
            window.deleteRapor = function(raporID) {  // Fonksiyonu global hale getir
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
                        console.error("Bir hata oluştu: " + xhr.responseText);
                    }
                });
            }
        });
    </script>
</body>
</html>