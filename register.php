<?php
session_start();
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password_plain = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = "Customer"; // Default role

    // Validasi konfirmasi password
    if ($password_plain !== $confirm_password) {
        echo "<script>alert('❌ Password dan konfirmasi password tidak cocok!'); window.history.back();</script>";
        exit;
    }

    // Cek apakah username atau email sudah terdaftar
    $check = $pdo->prepare("SELECT * FROM users WHERE username = :username OR email = :email LIMIT 1");
    $check->execute(['username' => $username, 'email' => $email]);
    if ($check->fetch()) {
        echo "<script>alert('⚠️ Username atau Email sudah terdaftar! Silakan gunakan yang lain.'); window.history.back();</script>";
        exit;
    }

    // Hash password
    $hashed_password = password_hash($password_plain, PASSWORD_BCRYPT);

    // Simpan ke database
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) 
                           VALUES (:username, :email, :password, :role)");

    try {
        $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => $hashed_password,
            'role' => $role
        ]);

        // Setelah register sukses → login otomatis
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;

        // Redirect ke login
        header("Location: login.php");
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Three Brother Law</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans">

  <header class="fixed w-full bg-white shadow z-50">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
      <div class="flex items-center space-x-2">
        <a href="index.php">
          <img src="./assets/img/logo.png" alt="Logo" class="w-10 h-10">
        </a>
      </div>
      <nav class="space-x-6 hidden md:flex text-gray-700">
        <a href="index.php#about" class="hover:text-gray-900">Tentang Kami</a>
        <a href="index.php#services" class="hover:text-gray-900">Layanan</a>
        <a href="index.php#testimony" class="hover:text-gray-900">Testimoni</a>
        <a href="index.php#location" class="hover:text-gray-900">Lokasi</a>
        <a href="index.php#contact" class="hover:text-gray-900">Kontak</a>
      </nav>
      <div class="space-x-3">
        <a href="login.php" class="px-4 py-2 border rounded hover:bg-gray-100">Masuk</a>
        <a href="register.php" class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700">Daftar</a>
      </div>
    </div>
  </header>

    <div class="min-h-screen flex items-center justify-center bg-cover bg-center" 
        style="background-image: url('./assets/img/banner.png');">
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative z-10 bg-white rounded-2xl shadow-xl w-full max-w-md p-8">
            <div class="text-center mb-6">
                <img src="./assets/img/logo.png" alt="Logo" class="w-16 h-16 mx-auto mb-2">
                <h2 class="text-2xl font-bold">Three Brother Law</h2>
            </div>
            <form action="register.php" method="POST" id="registerForm" class="space-y-4">
            <div class="flex items-center border rounded-lg px-3 py-2">
                <i class="fa-regular fa-user text-gray-500 mr-3"></i>
                <input type="text" name="username" placeholder="Username" required class="w-full outline-none">
            </div>
            <div class="flex items-center border rounded-lg px-3 py-2">
                <i class="fa-regular fa-envelope text-gray-500 mr-3"></i>
                <input type="email" name="email" placeholder="Email" required class="w-full outline-none">
            </div>
            <div class="flex items-center border rounded-lg px-3 py-2 relative">
                <i class="fa-solid fa-lock text-gray-500 mr-3"></i>
                <input type="password" id="password" name="password" placeholder="Password" required class="w-full outline-none">
            </div>
            <div class="flex items-center border rounded-lg px-3 py-2 relative">
                <i class="fa-solid fa-lock text-gray-500 mr-3"></i>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required class="w-full outline-none">
            </div>
            <button type="submit" class="w-full py-3 bg-gray-800 text-white font-semibold rounded-lg hover:bg-gray-700 transition">
                Register
            </button>
            </form>
        <p class="text-center text-sm text-gray-600 mt-4">
            Already have an account?
            <a href="login.php" class="text-blue-600 hover:underline">Sign in</a>
        </p>
        </div>
    </div>

    <div id="successPopup" class="hidden fixed inset-0 flex items-center justify-center bg-black/50 z-50">
        <div class="bg-white rounded-xl shadow-lg p-6 w-96 text-center">
        <div class="flex items-center justify-center mb-3 text-blue-600">
            <i class="fa-solid fa-circle-info text-2xl"></i>
        </div>
        <h3 class="text-lg font-semibold mb-2">Account successfully created</h3>
        <p class="text-gray-600 text-sm mb-4">
            Now you can access our services, feel free to roam around our website. 
            All regards from Three Brother Law
        </p>
        <button onclick="closePopup()" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
            Close
        </button>
        </div>
    </div>

  <!-- Footer -->
  <footer class="bg-gray-100 text-gray-800 py-12">
    <div class="container mx-auto grid md:grid-cols-4 gap-8 text-sm">
      <div>
        <div class="flex items-center mb-4">
          <img src="./assets/img/logo.png" alt="Logo Three Brother Law" class="w-10 h-10 mr-3">
          <h3 class="font-bold text-xl">Three Brother Law</h3>
        </div>
        <p class="mb-4">Firma hukum profesional yang siap membantu menyelesaikan masalah hukum Anda dengan integritas dan keahlian.</p>
        <div class="flex space-x-4 text-lg">
          <a href="https://www.instagram.com/three_brother_law/" class="hover:text-gray-600"><i class="fab fa-instagram"></i></a>
          <a href="https://www.youtube.com/@threebrotherlaw" class="hover:text-gray-600"><i class="fab fa-youtube"></i></a>
          <a href="https://wa.me/6289652003013" class="hover:text-gray-600"><i class="fab fa-whatsapp"></i></a>
        </div>
      </div>
      <div>
        <h4 class="font-bold mb-4 text-lg">Layanan Kami</h4>
        <ul class="space-y-2">
          <li class="hover:text-gray-600"><a href="#services">Hukum Perceraian</a></li>
          <li class="hover:text-gray-600"><a href="#services">Sengketa Properti</a></li>
          <li class="hover:text-gray-600"><a href="#services">Kasus Kecelakaan</a></li>
          <li class="hover:text-gray-600"><a href="#services">Hukum Keluarga</a></li>
          <li class="hover:text-gray-600"><a href="#services">Hukum Pidana</a></li>
          <li class="hover:text-gray-600"><a href="#services">Hukum Bisnis</a></li>
        </ul>
      </div>
      <div>
        <h4 class="font-bold mb-4 text-lg">Tautan Cepat</h4>
        <ul class="space-y-2">
          <li class="hover:text-gray-600"><a href="#about">Tentang Kami</a></li>
          <li class="hover:text-gray-600"><a href="#services">Layanan</a></li>
          <li class="hover:text-gray-600"><a href="#testimony">Testimoni</a></li>
          <li class="hover:text-gray-600"><a href="#contact">Kontak</a></li>
          <li class="hover:text-gray-600"><a href="login.php">Login</a></li>
          <li class="hover:text-gray-600"><a href="register.php">Daftar</a></li>
        </ul>
      </div>
      <div>
        <h4 class="font-bold mb-4 text-lg">Jam Operasional</h4>
        <ul class="space-y-2">
          <li>Senin - Sabtu: 08:00 - 15:00</li>
          <li>Minggu: Tutup</li>
        </ul>
        <div class="mt-6 p-4 bg-gray-200 rounded-lg">
          <h5 class="font-bold mb-2">Konsultasi Gratis</h5>
          <p class="text-sm">Jadwalkan konsultasi gratis dengan pengacara kami untuk membahas kasus Anda.</p>
          <a href="https://wa.me/089652003013" class="inline-block mt-3 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Hubungi via WhatsApp</a>
        </div>
      </div>
    </div>
    <div class="container mx-auto mt-8 pt-6 border-t border-gray-300 text-center">
      <p>&copy; 2025 Three Brother Law.</p>
    </div>
  </footer>

    <!-- Script -->
    <script>
        const form = document.getElementById('registerForm');
        const popup = document.getElementById('successPopup');

        form.addEventListener('submit', function(e) {
            // jangan block permanen
            if (!form.dataset.submitted) {
                e.preventDefault();
                popup.classList.remove('hidden');
            }
        });

        function closePopup() {
            popup.classList.add('hidden');
            form.dataset.submitted = true; // flag biar gak ke-block
            form.submit(); // kirim form ke PHP
        }

    </script>
</body>
</html>
