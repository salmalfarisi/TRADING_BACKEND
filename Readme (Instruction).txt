1. migrate database terlebih dahulu berdasarkan isi file .env
2. lakukan command berikut ini : 
php artisan config:clear
php artisan key:generate
php artisan config:clear
php artisan passport:install --force
php artisan passport:client --personal (isi dengan "--personal")
2. registrasikan akun users terlebih dahulu sebanyak 4kali berdasarkan test nomor 1
3. lakukan command berikut ini : php artisan db:seed
4. pastikan xampp sudah menyala dan database berhasil dimigrasi 
5. nyalakan project dengan menggunakan perintah berikut ini : php artisan serve --port=8000