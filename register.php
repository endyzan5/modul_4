<?php
session_start();
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password_plain = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = "Customer"; // Default role

    // Validasi username (hanya huruf dan angka)
    if (!preg_match('/^[A-Za-z0-9]+$/', $username)) {
        echo "<script>alert('❌ Username hanya boleh berisi huruf dan angka tanpa spasi atau karakter khusus!'); window.history.back();</script>";
        exit;
    }

    // Validasi konfirmasi password
    if ($password_plain !== $confirm_password) {
        echo "<script>alert('❌ Password dan konfirmasi password tidak cocok!'); window.history.back();</script>";
        exit;
    }

    // Cek apakah username atau email sudah terdaftar
    $check = $pdo->prepare("SELECT * FROM users WHERE username = :username OR email = :email LIMIT 1");
    $check->execute(['username' => $username, 'email' => $email]);
    $existing = $check->fetch(PDO::FETCH_ASSOC);

    if ($existing) {
        if ($existing['username'] === $username && $existing['email'] === $email) {
            echo "<script>alert('⚠️ Username dan Email sudah digunakan! Silakan gunakan yang lain.'); window.history.back();</script>";
        } elseif ($existing['username'] === $username) {
            echo "<script>alert('⚠️ Username sudah digunakan! Silakan pilih nama lain.'); window.history.back();</script>";
        } else {
            echo "<script>alert('⚠️ Email sudah digunakan! Silakan gunakan email lain.'); window.history.back();</script>";
        }
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

        header("Location: login.php");
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Three Brother Law</title>
  <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
  <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="preload" as="image" href="./assets/img/banner.webp" fetchpriority="high">
  <link rel="stylesheet" href="./public/output.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- CSS utama -->
  <link rel="preload" href="./public/output.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="./public/output.css"></noscript>
  <!-- Font Awesome -->
  <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></noscript>


  <style>
    body { font-family: sans-serif; background-color: #fff; color: #333; margin:0; }
	  header { position:fixed; top:0; width:100%; background:#fff; z-index:50; }
	  .hero { min-height:600px; display:flex; align-items:center; justify-content:center; }
    /* Animasi Hero */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    .animate-fade-in-up {
      animation: fadeInUp 1s ease-out forwards;
    }

    /* 🔧 Responsif Khusus untuk HP ≤ 400px */
    @media (max-width: 400px) {
      h1 {
        font-size: 1.8rem; /* ~29px */
        line-height: 2.2rem;
      }
      h2 {
        font-size: 1.25rem; /* ~20px */
      }
      p {
        font-size: 0.9rem;
        line-height: 1.4rem;
      }
      .container {
        padding-left: 1rem;
        padding-right: 1rem;
      }
      .hero-buttons a {
        display: block;
        width: 100%;
        margin-bottom: 0.75rem;
      }
      nav a {
        padding: 0.6rem 1rem;
        font-size: 0.9rem;
      }
      img {
        max-width: 100%;
        height: auto;
      }
      .w-28 {
        width: 5rem !important;
        height: 4.5rem !important;
      }
    }
    /* 🔧 Responsif tambahan untuk layar 401px - 430px */
    @media (max-width: 430px) {
      .hero-buttons {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.75rem; /* jarak antar tombol */
      }

      .hero-buttons a {
        width: 100%;
        max-width: 280px;
        margin: 0 auto;
        display: block;
      }

      h1 {
        font-size: 2rem;
      }

      p {
        font-size: 1rem;
      }
    }
    @font-face {
      font-family: 'Font Awesome 6 Free';
      font-display: swap;
    }
    @font-face {
      font-family: 'Font Awesome 6 Brands';
      font-display: swap;
    }

  </style>
</head>
<body class="bg-white text-gray-800 font-sans">

  <!-- Navbar -->
  <header class="fixed w-full bg-white shadow z-50">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
      <div class="flex items-center space-x-2">
        <a href="index.php" class="flex items-center space-x-2">
          <img src="./assets/img/logo.png" alt="Logo" class="w-10 h-10">
        </a>
      </div>

      <nav
        id="menu"
        class="absolute top-16 left-0 w-full bg-white shadow-md flex flex-col items-center space-y-4 py-4 transform scale-y-0 origin-top transition-transform duration-300 md:transform-none md:scale-y-100 md:flex md:flex-row md:space-y-0 md:space-x-6 md:static md:bg-transparent md:shadow-none md:justify-center flex-1"
      >
        <a href="index.php#about" class="py-2 px-6 hover:text-gray-900 transition">Tentang Kami</a>
        <a href="index.php#services" class="py-2 px-6 hover:text-gray-900 transition">Layanan</a>
        <a href="index.php#testimony" class="py-2 px-6 hover:text-gray-900 transition">Testimoni</a>
        <a href="index.php#contact" class="py-2 px-6 hover:text-gray-900 transition">Kontak</a>

        <div class="flex flex-col space-y-2 md:hidden w-4/5 text-center">
          <a href="login.php" class="px-4 py-2 border rounded hover:bg-gray-100 transition">Masuk</a>
          <a href="register.php" class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 transition">Daftar</a>
        </div>
      </nav>

      <!-- Tombol hamburger -->
      <button id="menu-btn" class="md:hidden text-2xl focus:outline-none transition-transform duration-300">
        <i class="fas fa-bars"></i>
      </button>

      <!-- Tombol login/daftar di desktop -->
      <div class="hidden md:flex space-x-3">
        <a href="login.php" class="px-4 py-2 border rounded hover:bg-gray-100 transition">Masuk</a>
        <a href="register.php" class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 transition">Daftar</a>
      </div>
    </div>
  </header>

  <div class="min-h-screen flex items-center justify-center bg-cover bg-center" 
        style="background-image: url('./assets/img/banner.png');">
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative z-10 bg-white rounded-2xl shadow-xl w-full max-w-md p-8 mx-4 animate-fade-in-up">
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

  <footer class="bg-gray-100 text-gray-800 py-12">
    <div class="container mx-auto grid md:grid-cols-4 gap-8 text-sm">
      <div>
        <div class="flex items-center mb-4">
          <img src="./assets/img/logo.png" alt="Logo" class="w-10 h-10 mr-3">
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
          <li><a href="index.php#services" class="hover:text-gray-600">Hukum Perceraian</a></li>
          <li><a href="index.php#services" class="hover:text-gray-600">Sengketa Properti</a></li>
          <li><a href="index.php#services" class="hover:text-gray-600">Kasus Kecelakaan</a></li>
          <li><a href="index.php#services" class="hover:text-gray-600">Hukum Keluarga</a></li>
          <li><a href="index.php#services" class="hover:text-gray-600">Hukum Pidana</a></li>
          <li><a href="index.php#services" class="hover:text-gray-600">Hukum Bisnis</a></li>
        </ul>
      </div>

      <div>
        <h4 class="font-bold mb-4 text-lg">Tautan Cepat</h4>
        <ul class="space-y-2">
          <li><a href="index.php#about" class="hover:text-gray-600">Tentang Kami</a></li>
          <li><a href="index.php#services" class="hover:text-gray-600">Layanan</a></li>
          <li><a href="index.php#testimony" class="hover:text-gray-600">Testimoni</a></li>
          <li><a href="index.php#contact" class="hover:text-gray-600">Kontak</a></li>
          <li><a href="login.php" class="hover:text-gray-600">Login</a></li>
          <li><a href="register.php" class="hover:text-gray-600">Daftar</a></li>
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

  <script defer>
    // Hamburger menu
    const menuBtn = document.getElementById('menu-btn');
    const menu = document.getElementById('menu');
    let isOpen = false;
    menuBtn.addEventListener('click', () => {
    isOpen = !isOpen;
    menu.style.transform = isOpen ? 'scaleY(1)' : 'scaleY(0)';
    menuBtn.innerHTML = isOpen ? '<i class="fas fa-times"></i>' : '<i class="fas fa-bars"></i>';
    });
    const form = document.getElementById('registerForm');

    form.addEventListener('submit', function (e) {
        const username = form.querySelector("input[name='username']").value.trim();
        const usernamePattern = /^[A-Za-z0-9]+$/;

        if (!usernamePattern.test(username)) {
            e.preventDefault();
            alert("❌ Username hanya boleh berisi huruf dan angka tanpa spasi atau karakter khusus!");
            return;
        }
    });
  </script>

</body>
</html>
