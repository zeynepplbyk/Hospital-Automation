<!DOCTYPE html>
<html lang="tr">
<head>
    <title>Hastane Yönetim Sistemi Giriş</title>
    <link rel="stylesheet" href="index1.css"> <!-- CSS dosyasına göreli bağlantı -->
</head>
<body>
    <div class="center-container"> <!-- Sayfanın ortalanması için kapsayıcı -->
        <div class="login-container"> <!-- Formun kapsayıcısı -->
            <h2>Hastane Yönetim Sistemi</h2> <!-- Başlık -->
            <form action="index.php" method="post"> <!-- Giriş formu -->
                <label for="user-type">Kullanıcı Türü:</label>
                <select id="user-type" name="userType">
                    <option value="hasta">Hasta</option>
                    <option value="doktor">Doktor</option>
                    <option value="yonetici">Yönetici</option>
                </select>

                <label for="username">Kullanıcı Adı:</label>
                <input type="text" id="username" name="username" required> 

                <label for="password">Şifre:</label>
                <input type="password" id="password" name="password" required> 

                <button type="submit">Giriş Yap</button>
            </form>
            <!-- Yeni Hasta Oluşturma Butonu ve Formu -->
            <button onclick="showNewPatientForm()">Yeni Hasta Oluştur</button>
            <div id="newPatientForm" style="display:none;">
                <h2>Yeni Hasta Oluştur</h2>
                <form action="register.php" method="post">
                    <label for="ad">Ad:</label>
                    <input type="text" id="ad" name="ad" required> 

                    <label for="soyad">Soyad:</label>
                    <input type="text" id="soyad" name="soyad" required> 

                    <label for="dogumTarihi">Doğum Tarihi:</label>
                    <input type="date" id="dogumTarihi" name="dogumTarihi" required> 

                    <label for="cinsiyet">Cinsiyet:</label>
                    <select id="cinsiyet" name="cinsiyet" required>
                        <option value="erkek">Erkek</option>
                        <option value="kadın">Kadın</option>
                        <option value="diğer">Diğer</option>
                    </select>

                    <label for="telefon">Telefon:</label>
                    <input type="tel" id="telefon" name="telefon" required> 

                    <label for="adres">Adres:</label>
                    <textarea id="adres" name="adres" required></textarea> 

                    <label for="sifre">Şifre:</label>
                    <input type="password" id="sifre" name="sifre" required> 

                    <button type="submit" name="submit">Ekle</button>
                </form>
            </div>
            <script>
                function showNewPatientForm() {
                    var form = document.getElementById("newPatientForm");
                    form.style.display = "block";
                }
            </script>
        </div> <!-- login-container kapanışı -->
    </div> <!-- center-container kapanışı -->
</body>
</html>

<?php
include("baglanti.php"); // Veritabanı bağlantısını içe aktar

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // POST ile gelen verileri al
    $userType = strtolower($_POST["userType"]); // Kullanıcı türü küçük harf
    $username = $_POST["username"]; // Kullanıcı ID'si
    $password = $_POST["password"]; // Şifre

    // Kullanıcı türüne göre tablo seç
    $table = "";
    if ($userType == "hasta") {
        $table = "Hastalar"; 
    } elseif ($userType == "doktor") {
        $table = "Doktorlar"; 
    } elseif ($userType == "yonetici") {
        $table = "Yonetici"; 
    }

    // SQL enjeksiyonlarına karşı korunmak için güvenli sorgu
    $username = mysqli_real_escape_string($baglan, $username);
    $password = mysqli_real_escape_string($baglan, $password);

    // Tabloyu sorgula
    $sql = "SELECT * FROM $table WHERE " . ($userType == 'hasta' ? 'HastaID' : ($userType == 'doktor' ? 'DoktorID' : 'YoneticiID')) . " = '$username' AND Sifre = '$password'";
    
    $result = $baglan->query($sql);

    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();
        $_SESSION["HastaID"] = $row['HastaID'];
        $_SESSION["DoktorID"] = $row['DoktorID'];
        // Giriş başarılı - Yönlendirme
        if ($userType == "yonetici") {
            header("Location: YoneticiSayfa.php"); // Yönetici sayfasına yönlendir
        } elseif ($userType == "doktor") {
            header("Location: DoktorSayfa.php"); // Doktor sayfasına yönlendir
        } elseif ($userType == "hasta") {
            header("Location: HastaSayfa.php"); // Hasta sayfasına yönlendir
        }
    } else {
        // Giriş başarısız
        echo "Hatalı kullanıcı adı veya şifre. Lütfen tekrar deneyin.";
    }
} else {
    echo "Lütfen formu kullanarak giriş yapın.";
}
?>