# BencanaTracker
<pre>
Dibuat oleh:
M. Andra Fadhillah (2110817310013)
M. Azhar Muhaimin  (2110817310019)
M. Farid Pebrian   (2110817210015)
</pre>

# Penjelasan Aplikasi
BencanaTracker merupakan aplikasi berbasis web yang berfungsi untuk melihat dan melaporkan bencana yang sedang terjadi.

## Catatan Mengenai Fitur Notifikasi Web Push
Project ini menggunakan OneSignal untuk mengirimkan notifikasi web push. Pada dashboard OneSignal, kami telah memasukkan http://localhost:8080 sebagai site url nya. Disarankan untuk menggunakan perintah `php spark serve` untuk melakukan hosting server pada port 8080 agar notifikasi web push berfungsi dengan baik. 

Jika ingin melakukan hosting server pada port atau domain lain, kami menyarankan untuk melakukan langkah-langkah berikut untuk memastikan notifikasi web push tetap bekerja.
1. Buat akun atau login (jika sudah memiliki akun) di [OneSignal](https://onesignal.com/).
2. Buat 'App' baru dengan 'Web' sebagai platformnya.
3. Pada App > Settings, pilih Typical Site.
4. Lakukan konfigurasi sesuai keperluan dan pastikan `SITE URL` diisi dengan benar.
5. Salin OneSignal App ID pada App > Settings > Keys & IDs.
6. Ganti value `appId` pada baris 22 di file `/Views/landing.php` dengan App ID yang disalin.
```javascript
        window.OneSignal = window.OneSignal || [];
        OneSignal.push(function() {
            OneSignal.init({
            appId: "b2a2b678-e517-474d-9e66-f23ab88930b2", // ganti dengan App ID dari App > Settings > Keys & IDs pada dashboard OneSgnal
            });
        });
```
7. Ganti value `appId` pada baris 23 di file `/Views/notifikasi.php` dengan App ID yang disalin.
```javascript
        window.OneSignal = window.OneSignal || [];
        OneSignal.push(function() {
            OneSignal.init({
            appId: "b2a2b678-e517-474d-9e66-f23ab88930b2", // ganti dengan App ID dari App > Settings > Keys & IDs pada dashboard OneSgnal
            });
        });
```
8. Ganti value `app_id` pada baris 149 di file `/Controllers/BuatLaporanController.php` dengan App ID yang disalin.
```php
        $fields = array(
            'app_id' => "b2a2b678-e517-474d-9e66-f23ab88930b2", // ganti dengan App ID dari App > Settings > Keys & IDs pada dashboard OneSgnal
            'include_player_ids' => $playerIds,
            'headings' => array(
                'en' => $title
            ),
            'contents' => $content,
            'url' => $url
        );
```
9. Salin Rest API Key pada App > Settings > Keys & IDs.
10. Ganti string setelah `Authorization: Basic ` pada baris 164 di file `/Controllers/BuatLaporanController.php` dengan Rest API Key yang disalin.
```php
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic MGQyOGMxYmItNDA1OC00NWYyLThlYjUtMTVkYzA2MTI2NjZh' // ganti dengan Rest API Key dari App > Settings > Keys & IDs pada dashboard OneSgnal
        ));
```