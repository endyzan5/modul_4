# tubes_umam

repositori ini digunakan untuk menyimpan projek web Three Law Brother

## info login

1. customer default
- username: customer1
- password: customer1
2. admin default
- username: adminsatu
- password: adminsatu
3. lawyer default
- username: lawyersatu
- password: lawyersatu1

## fitur unggulan

1. Jika user tidak memilih “Login as…”, sistem akan menganggap percobaan login hanya untuk Administrator.
2. Jika user memilih “Customer” atau “Lawyer”, maka login hanya akan berhasil jika role di database cocok.
3. Jika role di database tidak sesuai dengan pilihan (atau kosong padahal user bukan admin), login gagal dengan pesan error.

**logika dasar**

1. Jika $role kosong → berarti user tidak memilih login as, maka sistem cek apakah user tersebut Administrator.
- Kalau iya → masuk ke dashboard admin.
- Kalau bukan → muncul pesan error “Anda harus memilih 'Login as' yang sesuai!”
2. Jika $role diisi → cocokkan $user['role'] dengan $role.
- Kalau cocok → diarahkan ke dashboard sesuai peran.
- Kalau tidak cocok → pesan “Role tidak sesuai! Pastikan memilih peran yang benar.”