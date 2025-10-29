<?php
session_start();
include "config.php";

// Jika sudah login
if (isset($_SESSION['username'])) {
    if ($_SESSION['role'] === 'Administrator') {
        header("Location: admin/admin-dashboard.php");
    } elseif ($_SESSION['role'] === 'Lawyer') {
        header("Location: pengacara/lawyer-dashboard.php");
    } else {
        header("Location: customer/customer-dashboard.php");
    }
    exit;
}

// Proses login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = isset($_POST['role']) ? trim($_POST['role']) : null;

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (
            password_verify($password, $user['password']) ||
            hash('sha256', $password) === $user['password']
        ) {
            if (empty($role)) {
                if ($user['role'] === 'Administrator') {
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];
                    header("Location: admin/admin-dashboard.php");
                    exit;
                } else {
                    $error = "❌ Anda harus memilih 'Login as' yang sesuai!";
                }
            } else {
                if ($user['role'] === $role) {
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];
                    if ($role === 'Lawyer') {
                        header("Location: pengacara/lawyer-dashboard.php");
                    } elseif ($role === 'Customer') {
                        header("Location: customer/customer-dashboard.php");
                    }
                    exit;
                } else {
                    $error = "❌ Role tidak sesuai! Pastikan memilih peran yang benar.";
                }
            }
        } else {
            $error = "❌ Password salah!";
        }
    } else {
        $error = "❌ Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Three Brother Law</title>
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

  <!-- Background Section -->
  <div class="min-h-screen flex items-center justify-center bg-cover bg-center" 
       style="background-image: url('./assets/img/banner.png');">
    <div class="absolute inset-0 bg-black/50"></div>

    <div class="relative z-10 bg-white rounded-2xl shadow-xl w-full max-w-md p-8 mx-4 animate-fade-in-up">
        <div class="text-center mb-6">
            <img src="./assets/img/logo.png" alt="Logo" class="w-16 h-16 mx-auto mb-2">
            <h2 class="text-2xl font-bold">Welcome Back!</h2>
            <p class="text-gray-600">Masuk ke akun Anda</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-center">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST" class="space-y-4">
            <div class="flex items-center border rounded-lg px-3 py-2">
                <i class="fa-regular fa-user text-gray-500 mr-3"></i>
                <input type="text" name="username" placeholder="Username" required class="w-full outline-none">
            </div>

            <div class="flex items-center border rounded-lg px-3 py-2 relative">
                <i class="fa-solid fa-lock text-gray-500 mr-3"></i>
                <input type="password" id="password" name="password" placeholder="Password" required class="w-full outline-none">
                <i class="fa-regular fa-eye absolute right-3 cursor-pointer text-gray-500" id="togglePassword"></i>
            </div>

            <div class="border rounded-lg px-3 py-2">
                <select name="role" class="w-full outline-none bg-transparent text-gray-700">
                    <option value="" disabled selected>Login as...</option>
                    <option value="Customer">Customer</option>
                    <option value="Lawyer">Lawyer</option>
                </select>
            </div>

            <button type="submit" class="w-full py-3 bg-gray-800 text-white font-semibold rounded-lg hover:bg-gray-700 transition">
                Login
            </button>
        </form>
    </div>
  </div>

  <!-- Footer -->
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

    // Toggle password visibility
    const togglePassword = document.getElementById("togglePassword");
    const passwordInput = document.getElementById("password");
    togglePassword.addEventListener("click", () => {
        const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
        passwordInput.setAttribute("type", type);
        togglePassword.classList.toggle("fa-eye");
        togglePassword.classList.toggle("fa-eye-slash");
    });
  </script>

</body>
</html>
