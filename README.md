# 🏥 Hospital Automation - Hasta Takip ve Yönetim Sistemi

<img src="https://github.com/zeynepplbyk/Hospital-Automation/assets/125740535/520d12d3-4fd2-4a0b-a479-ca69da170eab" alt="Giriş Sayfası" width="80%" align="center">

---

## 👩‍💻 Proje Hakkında
**Hospital Automation**, bir hastane yönetim sistemi olarak tasarlanmış web uygulamasıdır. Sistem, hastaların kayıt oluşturabileceği, doktorlarla randevu alabileceği, tıbbi raporları saklayabileceği ve sağlıkla ilgili tüm işlemleri yönetebileceği bir platform sunmaktadır.

---

## 📊 Veri Tabanı Tasarımı

Projede temel tablolar ve ilişkileri şunlardır:  

1. **Hastalar**  
   - HastaID, Ad, Soyad, Doğum Tarihi, Cinsiyet, Telefon, Adres  

2. **Doktorlar**  
   - DoktorID, Ad, Soyad, Uzmanlık Alanı, Çalıştığı Hastane  

3. **Yönetici**  
   - YöneticiID  
   - Yetkiler: Hasta ekleme/silme, doktor ekleme/silme, tıbbi rapor ekleme  

4. **Randevular**  
   - RandevuID, Tarih, Saat  

5. **Tıbbi Raporlar**  
   - RaporID, Rapor Tarihi, Rapor İçeriği  
   - Dosya ve JSON formatında saklanır  

> Veri tabanında primary key ve foreign key kullanılmış, normalizasyon (1NF, 2NF, 3NF) uygulanmıştır.

---

## 🛠️ Kullanılan Teknolojiler
- **Programlama Dilleri:** Python, PHP, JavaScript (Node.js)  
- **Veri Tabanları:** MSSQL, PostgreSQL, MySQL, SQLite  
- **Güvenlik:** HTTPS, şifreleme ile hassas verilerin korunması  
- **Arayüz:** Dinamik dashboardlar, AJAX ile sayfa yenilenmeden işlem  

---

## 📝 Proje Özellikleri

### Hasta Modülü
- Kayıt oluşturma ve bilgilerini güncelleme  
- Randevu alma ve iptal etme  
- Tıbbi raporları görüntüleme ve indirme  

<img src="https://github.com/zeynepplbyk/Hospital-Automation/assets/125740535/8744a71c-eb43-4bb2-8766-d011ac260c66" alt="Hasta Giriş 1" width="70%">
<img src="https://github.com/zeynepplbyk/Hospital-Automation/assets/125740535/1563d8cc-a336-4ca7-ba20-d9552d62081d" alt="Hasta Giriş 2" width="70%">

### Doktor Modülü
- Hastalarını listeleme  
- Belirli hastalara ait tıbbi raporları görüntüleme  

<img src="https://github.com/zeynepplbyk/Hospital-Automation/assets/125740535/e834146a-1af6-4b26-b751-992c7b1a0dd2" alt="Doktor Giriş 1" width="70%">
<img src="https://github.com/zeynepplbyk/Hospital-Automation/assets/125740535/f54d24cb-c942-4e7e-833e-cd65be4fe8c8" alt="Doktor Giriş 2" width="70%">

### Yönetici Modülü
- Hasta ve doktor ekleme/silme  
- Tıbbi rapor ekleme ve silme  
- Veri tabanında değişikliklerin anlık kontrolü  

<img src="https://github.com/zeynepplbyk/Hospital-Automation/assets/125740535/baf27fcd-43ce-4c14-abd9-d1d4a8253832" alt="Yönetici Giriş 1" width="70%">
<img src="https://github.com/zeynepplbyk/Hospital-Automation/assets/125740535/ee6b1786-68b3-4a8a-b23e-20982c6cda37" alt="Yönetici Giriş 2" width="70%">
<img src="https://github.com/zeynepplbyk/Hospital-Automation/assets/125740535/2ca72547-1226-449a-a0e2-95e565e3c685" alt="Yönetici Giriş 3" width="70%">

---

## ⚙️ Özellikler
- Hasta, doktor ve yönetici arayüzleri  
- Dinamik bildirim sistemi  
- Dosya yükleme ve indirme işlemleri AJAX ile  
- Tüm CRUD işlemleri arayüzden yönetilebilir  
- Normalizasyon ve veri güvenliği sağlanmış veri tabanı  

---

## 📚 Kaynaklar
1. Python, PHP, JavaScript dökümantasyonları  
2. SQL ve veri tabanı yönetim kaynakları  
3. Web geliştirme dökümantasyonları (AJAX, dashboard)  
