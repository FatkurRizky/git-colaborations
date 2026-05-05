# Menambahkan Fitur Output Operasional pada kalkulator rekon

## Frontend

1. UI Tombol & Layout Membuat komponen tombol Download/Export di halaman Kalkulator Rekon menggunakan Tailwind CSS v3 agar selaras dengan desain project saat ini.

2. Modal Pop-up & Advanced Filtering: Membuat modal pop-up yang muncul saat tombol export ditekan, berisi opsi format file (PDF, Excel, CSV) dan opsi filter lanjutan (tanggal/kategori) sebelum proses unduh dimulai

3. Mobile Responsiveness: Menyesuaikan tata letak komponen filter dan modal agar tetap rapi, tidak terpotong, dan mudah ditekan (touch-friendly) saat dibuka melalui layar smartphone.

4. User Feedback (Loading State): Menambahkan animasi loading atau meredupkan tombol (disabled state) saat proses generate file sedang berjalan di server agar user tidak menekan tombol berkali-kali.

## Backend

1. Library Setup: Melakukan instalasi dan konfigurasi package Laravel untuk export dokumen untuk Excel & PDF.

2. Data Query & Filtering: Membuat fungsi di Controller untuk menarik data operasional dari database. Pastikan query bisa menerima parameter advanced filtering (misalnya filter berdasarkan rentang tanggal atau status rekon) dari Front-End.

3. Export Logic (Excel & PDF) Membuat class Export khusus untuk memetakan kolom data database menjadi format .xlsx dan .pdf yang rapi.

4. Routing Menyiapkan endpoint(misal: GET /rekon/export/{format}) untuk memicu proses download file.


