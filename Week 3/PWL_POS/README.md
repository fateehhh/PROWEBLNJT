<<<<<<< HEAD
# JOBSHEET 3
## MIGRATION, SEEDER, DB FAÇADE, QUERY BUILDER, dan ELOQUENT ORM
=======
# JOBSHEET 3 | MIGRATION, SEEDER, DB FAÇADE, QUERY BUILDER, dan ELOQUENT ORM
>>>>>>> 88218ec6c26b25fa1e87046e966fb7418f2d082a
2341720194/M. Fatih Al Ghifary/16/TI-2A

## Pertanyaan dan Jawaban
### 1. Pada Praktikum 1 - Tahap 5, apakah fungsi dari APP_KEY pada file setting .env Laravel?
jawab: APP_KEY di dalam file `.env` digunakan sebagai kunci enkripsi yang digunakan untuk mengamankan data sensitif, seperti session dan password hashing
### 2.  Pada Praktikum 1, bagaimana kita men-generate nilai untuk APP_KEY?
jawab: 
```command
php artisan key:generate
```
Perintah tersebut akan otomatis membuat dan menyimpan kunci baru di file .env
### 3. Pada Praktikum 2.1 - Tahap 1, secara default Laravel memiliki berapa file migrasi? dan untuk apa saja file migrasi tersebut?
jawab: Secara default, Laravel memiliki tiga file migrasi, yaitu:
   - **create_users_table.php**: File migrasi ini digunakan untuk membuat tabel users, yang menyimpan data pengguna. kemudian, tabel tersebut digunakan untuk mengelola autentikasi pengguna dalam Laravel.
   - **create_password_resets_table.php**: Digunakan untuk menyimpan token reset password.
   - **create_failed_jobs_table.php**: Digunakan untuk mencatat job yang gagal dieksekusi saat menggunakan Laravel Queue. Dengan tabel ini, developer dapat menganalisis dan memperbaiki job yang gagal secara lebih sistematis.
### 4. Secara default, file migrasi terdapat kode `$table->timestamps();`, apa tujuan/output dari fungsi tersebut?
jawab: 
```
$table->timestamps(); 
```
digunakan untuk otomatis menambahkan kolom created_at dan updated_at di tabel, yang merekam waktu pembuatan dan perubahan data.
### 5. Pada File Migrasi, terdapat fungsi `$table->id();` Tipe data apa yang dihasilkan dari fungsi tersebut?
jawab: 
```
$table->id();
``` 
menghasilkan kolom primary key bertipe unsignedBigInteger, yang secara default bernama id dengan fitur auto-increment.
### 6. Apa bedanya hasil migrasi pada table m_level, antara menggunakan `$table->id();` dengan menggunakan `$table->id('level_id');` ?
jawab: 
```
$table->id();
``` 
- digunakan untuk membuat kolom primary key dengan nama id.
```
$table->id('level_id');
```
- digunakan untuk membuat primary key dengan nama level_id sebagai pengganti default id.
### 7. Pada migration, Fungsi `->unique()` digunakan untuk apa?
jawab: Fungsi **->unique()** digunakan untuk memastikan bahwa nilai dalam kolom tertentu menjadi unik, tidak boleh ada data yang sama. Hal ini sangat membantu agar data tidak ada yang terduplikasi. Contohnya seperti ketika membuat tabel m_user:
```
Schema::create('m_user', function (Blueprint $table) {
            $table->id('user_id');
            $table->unsignedBigInteger('level_id')->index();
            $table->string('username', 20)->unique();
            ...
        });
```
dari contoh diatas, terdapat kode unique() seperti ini:
```
$table->string('username', 20)->unique();
```
- disini dapat diartikan bahwa kolom username dalam tabel m_user akan memiliki unique constraint, yang berarti setiap pengguna harus memiliki username yang berbeda.
### 8. Pada Praktikum 2.2 - Tahap 2, kenapa kolom level_id pada tabel m_user menggunakan `$tabel->unsignedBigInteger('level_id')`, sedangkan kolom level_id pada tabel m_level menggunakan `$tabel->id('level_id')` ?
jawab: Perbedaan tipe data level_id di m_user dan m_level:
- pada m_level: **`$table->id('level_id');** membuat kolom level_id sebagai primary key bertipe unsignedBigInteger dengan auto-increment.
- sedangkan pada m_user: **$table->unsignedBigInteger('level_id');** digunakan untuk membuat kolom level_id tanpa auto-increment, karena bertindak sebagai foreign key yang merujuk ke m_level.
### 9. Pada Praktikum 3 - Tahap 6, apa tujuan dari Class Hash? dan apa maksud dari kode program Hash::make('1234');?
jawab: Class Hash digunakan untuk mengenkripsi data, terutama password.
- **Hash::make('1234');** berarti mengenkripsi string 1234 menggunakan algoritma hashing bawaan Laravel. seperti pada file UserSeeder.php yang menggunakan hashing, antara password di kode dengan yang sudah di hashing di database berbeda.
- di dalam kode
```
'password' => Hash::make('12345')
```
- di dalam database
```
$2y$12$bctFqxgxqTA.1RRhHTlD5efl1u8xPJNTO8F5z4TmVy1...
```
### 10.Pada Praktikum 4 - Tahap 3/5/7, pada query builder terdapat tanda tanya (?), apa kegunaan dari tanda tanya (?) tersebut?
jawab: **Tanda tanya (?)** dalam Query Builder digunakan sebagai placeholder untuk menghindari SQL Injection. Data yang dimasukkan akan diproses sebagai parameter terpisah dari query SQL.
### 11. Pada Praktikum 6 - Tahap 3, apa tujuan penulisan kode protected $table = ‘m_user’; dan protected $primaryKey = ‘user_id’; ?
jawab: Tujuan penulisan protected $table = 'm_user'; dan protected $primaryKey = 'user_id'; adalah:
- protected $table = 'm_user'; → untuk menentukan nama tabel yang digunakan model.
- protected $primaryKey = 'user_id'; → untuk menentukan primary key tabel jika tidak menggunakan id sebagai default.
### 12. Menurut kalian, lebih mudah menggunakan mana dalam melakukan operasi CRUD ke database (DB Façade / Query Builder / Eloquent ORM) ? jelaskan
- **DB Facade (Raw Query)**: Sebenarnya enak menggunakan DB Facade untuk query yang kompleks, karena lebih flexibel dan menggunakan Query seperti pada umumnya. Namun, Kode sulit terbaca karena panjang, sehingga harus teliti dalam memasukkan Query. DB Facade juga tidak aman jika tidak menggunakan parameter binding, raw SQL rentan terhadap SQL Injection
- **Query Builder**: Jelas lebih aman ketimbang DB Facade karena sudah menggunakan parameter binding, sehingga lebih melindungi dari SQL Injection. Kodenya lebih mudah dibaca karena terstruktur dan simple, serta Bisa digunakan untuk berbagai jenis database tanpa mengubah kode. Jika dibandingkan dengan Eloquent ORM, Query Builder masih membutuhkan lebih banyak kode
- **Eloquent ORM (Object-Relational Mapping)**: Paling mudah dan singkat dari lainnya. Memanfaatkan fitur Model untuk mengelola data dengan lebih baik. Mendukung relationship antar tabel secara otomatis. Lebih mudah dibaca dan mempermudah maintanance.
<<<<<<< HEAD
- **Jadi mana yang lebih mudah?**Eloquent ORM paling mudah karena sintaksnya mirip dengan cara kita bekerja dengan objek dalam PHP.
=======
- **Jadi mana yang lebih mudah?** Eloquent ORM paling mudah karena sintaksnya mirip dengan cara kita bekerja dengan objek dalam PHP.
>>>>>>> 88218ec6c26b25fa1e87046e966fb7418f2d082a
