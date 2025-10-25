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

    // Ambil data user dari database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Verifikasi password (baik hash maupun plaintext lama)
        if (
            password_verify($password, $user['password']) ||
            hash('sha256', $password) === $user['password']
        ) {

            // --- Logika Role ---
            if (empty($role)) {
                // Tidak memilih "login as" → hanya admin yang bisa login
                if ($user['role'] === 'Administrator') {
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];
                    header("Location: admin/admin-dashboard.php");
                    exit;
                } else {
                    $error = "❌ Anda harus memilih 'Login as' yang sesuai!";
                }
            } else {
                // Jika user memilih role → cocokkan dengan role di database
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
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign In - Three Brother Law</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans">

  <!-- Navbar -->
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

  <!-- Background -->
  <div class="min-h-screen flex items-center justify-center bg-cover bg-center" 
       style="background-image: url('./assets/img/banner.png');">
    <div class="absolute inset-0 bg-black/50"></div>

    <div class="relative z-10 bg-white rounded-2xl shadow-xl w-full max-w-md p-8">
        <div class="text-center mb-6">
            <img src="./assets/img/logo.png" alt="Logo" class="w-16 h-16 mx-auto mb-2">
            <h2 class="text-2xl font-bold">Welcome Back!</h2>
            <p class="text-gray-600">Sign-in to your account</p>
        </div>

        <!-- Pesan error -->
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

            <!-- Dropdown Role tanpa Administrator -->
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

  <script>
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
