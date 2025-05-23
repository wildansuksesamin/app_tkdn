<p align="center"><a href="https://app.tkdn-scisba.web.id/" target="_blank"><img src="https://app.tkdn-scisba.web.id/assets/images/logo_sambung.png" width="400" alt="E-TKDN SBA"></a></p>

  
# E-TKDN SBA - Sucofindo Surabaya

## Instalasi Aplikasi

1. Clone repositori ini ke local komputer Anda.

```
git clone https://github.com/sucofindo-sba/etkdn-sba.git
```

2. Arahkan terminal Anda ke folder `e-tkdn-sba`.

```
cd e-tkdn-sba
```

3. Copy file env.example.php ke file env.php dan ganti informasi sesuai kebutuhan Anda.

```
cp application/config/env.example.php application/config/env.php
```

Jika OS Anda adalah windows, gunakan perintah `copy` untuk mengcopy file.

```
copy application/config/env.example.php application/config/env.php
```

4. Buat database di MySQL sesuai dengan nama yang sudah Anda atur dalam file database.

5. Selanjutnya, import databasenya.

6. Jika proses import database telah selesai, Anda dapat mengakses aplikasi melalui url berikut:

```
http://localhost/e-tkdn-sba
```

## Workflow Update Aplikasi

Aplikasi memiliki berapa branch yaitu:
- **master**: Untuk website production
- **development**: Untuk pengembangan fitur-fitur baru dan belum pernah di delivery ke production.
- **hotfix**: Untuk perbaikan error atau penyesuaian (modifikasi) pada website production
### Perbaikan Error / Penyesuaian Aplikasi

1. Masuk ke branch `hotfix`:

```
git checkout hotfix
```

2. Pastikan branch `hotfix` sudah memiliki versi terbaru yang sama dengan repository. Jalankan perintah ini untuk mengupdate branch dari repository:

```
git pull origin hotfix
```

3. Buat branch baru berdasarkan dari branch sumber. ***PERHATIAN!** 1 branch 1 isu agar mudah untuk di lacak*.

```
git checkout -b hotfix-<USERNAME>-<NAMA-ISU>
```
Contoh: 
```
git checkout -b hotfix-bhaga-perbaikan-perhitungan-bom
```

4. Lakukan perubahan kode sesuai kebutuhan pada branch yang baru dibuat.
5. Lakukan perintah ini untuk add semua file yang telah di update:

```
git add -A
```

6. Lakukan perintah ini untuk mengcommit semua file yang telah di update:

```
git commit -m "catatan commit"
```

7. Lakukan perintah ini untuk melakukan push

```
git push -u origin <nama_branch>
```

8. Lakukan pull request (PR) di bitbucket antar branch yang baru dibuat dengan branch sumber. **Jangan merge sendiri**. Contoh: PR dari branch `hotfix-bhaga-perbaikan-perhitungan-bom` ke `hotfix`.

- [https://zapier.com/blog/bitbucket-pull-request/](https://zapier.com/blog/bitbucket-pull-request/)
- [https://guides.co/g/bitbucket-101/11166](https://guides.co/g/bitbucket-101/11166)

### Penambahan Fitur Baru Pada Aplikasi

1. Masuk ke branch `development`:

```
git checkout development
```

2. Pastikan branch `development` sudah memiliki versi terbaru yang sama dengan repository. Jalankan perintah ini untuk mengupdate branch dari repository:

```
git pull origin development
```

3. Buat branch baru berdasarkan dari branch sumber. ***PERHATIAN!** 1 branch 1 fitur agar mudah untuk di lacak*.

```
git checkout -b development-<USERNAME>-<NAMA-FITUR>
```
Contoh: 
```
git checkout -b development-bhaga-closing-order
```

4. Lakukan perubahan kode sesuai kebutuhan pada branch yang baru dibuat.
5. Lakukan perintah ini untuk add semua file yang telah di update:

```
git add -A
```

6. Lakukan perintah ini untuk mengcommit semua file yang telah di update:

```
git commit -m "catatan commit"
```

7. Lakukan perintah ini untuk melakukan push

```
git push -u origin <nama_branch>
```

8. Lakukan pull request (PR) di bitbucket antar branch yang baru dibuat dengan branch sumber. **Jangan merge sendiri**. Contoh: PR dari branch `development-bhaga-closing-order` ke `development`.
- [https://zapier.com/blog/bitbucket-pull-request/](https://zapier.com/blog/bitbucket-pull-request/)
- [https://guides.co/g/bitbucket-101/11166](https://guides.co/g/bitbucket-101/11166)
#   t k d n _ s c i _ s b a  
 #   a p p _ t k d n  
 #   a p p _ t k d n  
 