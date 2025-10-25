<?php
session_start();
require_once '../../config.php';

// Proteksi halaman
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit;
}
if ($_SESSION['role'] !== 'Administrator') {
    header("Location: ../login.php");
    exit;
}

// Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $birth_place = $_POST['birth_place'];
    $birth_date = $_POST['birth_date'];
    $profession = $_POST['profession'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        echo "<script>alert('Password tidak sama!');</script>";
    } else {
        // Buat username otomatis dari nama
        $username = strtolower(str_replace(' ', '', $full_name)); 
        $hashed_password = hash('sha256', $password);

        // Cek apakah username atau email sudah terdaftar
        $stmt_check = $pdo->prepare("SELECT username, email FROM users WHERE username = ? OR email = ?");
        $stmt_check->execute([$username, $email]);
        $existing = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            // Jika username atau email sudah ada
            if ($existing['username'] === $username && $existing['email'] === $email) {
                echo "<script>alert('Username dan Email sudah digunakan! Silakan gunakan yang lain.');</script>";
            } elseif ($existing['username'] === $username) {
                echo "<script>alert('Username sudah digunakan! Silakan pilih nama lain.');</script>";
            } else {
                echo "<script>alert('Email sudah digunakan! Silakan gunakan email lain.');</script>";
            }
        } else {
            // Tambahkan user ke tabel users
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'Lawyer')");
            $stmt->execute([$username, $email, $hashed_password]);

            $user_id = $pdo->lastInsertId();

            // Tambahkan data ke tabel lawyers
            $stmt2 = $pdo->prepare("INSERT INTO lawyers (user_id, full_name, email, address, birth_place, birth_date, profession, phone) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt2->execute([$user_id, $full_name, $email, $address, $birth_place, $birth_date, $profession, $phone]);

            echo "<script>alert('Data lawyer berhasil ditambahkan!'); window.location.href='../lawyer-data/lwyer-data.php';</script>";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add New Lawyer - Three Brother Law</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans">

  <div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg flex flex-col justify-between">
      <div>
        <div class="p-6 text-center">
          <img src="../../assets/img/logo.png" alt="Logo" class="w-20 mx-auto mb-2">
          <h2 class="text-lg font-bold">Three Brother Law</h2>
        </div>

        <nav class="px-4 space-y-2">
          <a href="../admin-dashboard.php" class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-100">
            <i class="fa-solid fa-house"></i>
            <span>Dashboard</span>
          </a>
          <a href="../lawyer-data/lwyer-data.php" class="flex items-center space-x-3 px-4 py-2 rounded-lg bg-gray-100 text-red-600 font-semibold">
            <i class="fa-solid fa-user"></i>
            <span>Lawyer Data</span>
          </a>
          <a href="../customer-data/customer-data.php" class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-100">
            <i class="fa-solid fa-users"></i>
            <span>Customer Data</span>
          </a>
          <a href="../consultation/consultation.php" class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-100">
            <i class="fa-solid fa-file-lines"></i>
            <span>Consultation</span>
          </a>
        </nav>
      </div>

      <div class="p-6">
        <button onclick="window.location.href='../../logout.php'" 
          class="w-full py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 font-semibold">
          Log-out
        </button>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8">
      <h1 class="text-3xl font-bold mb-6">Add New Lawyer</h1>

      <form method="POST" class="bg-white p-6 rounded-xl shadow-lg space-y-4 max-w-2xl">
        <div>
          <label class="block font-semibold">Full Name</label>
          <input type="text" name="full_name" required class="w-full px-3 py-2 border rounded bg-gray-200">
        </div>
        
        <div>
          <label class="block font-semibold">Email Address</label>
          <input type="email" name="email" required class="w-full px-3 py-2 border rounded bg-gray-200">
          <p class="text-xs text-gray-500">Please use Gmail to register an account.</p>
        </div>

        <div>
          <label class="block font-semibold">Address</label>
          <input type="text" name="address" class="w-full px-3 py-2 border rounded bg-gray-200">
        </div>

        <div>
          <label class="block font-semibold">Place of Birth</label>
          <input type="text" name="birth_place" class="w-full px-3 py-2 border rounded bg-gray-200">
        </div>

        <div>
          <label class="block font-semibold">Date of Birth</label>
          <input type="date" name="birth_date" class="w-full px-3 py-2 border rounded bg-gray-200">
        </div>

        <div>
          <label class="block font-semibold">Lawyer Profession</label>
          <select name="profession" required class="w-full px-3 py-2 border rounded bg-gray-200">
            <option value="" disabled selected>-- Pilih Profesi --</option>
            <option value="Advokat">Advokat</option>
            <option value="Pidana">Pidana</option>
            <option value="Koorporasi">Koorporasi</option>
            <option value="Sengketa">Sengketa</option>
          </select>
        </div>

        <div>
          <label class="block font-semibold">Phone Number</label>
          <input type="text" name="phone" class="w-full px-3 py-2 border rounded bg-gray-200">
        </div>

        <div class="relative">
          <label class="block font-semibold">Password</label>
          <input type="password" id="password" name="password" class="w-full px-3 py-2 border rounded bg-gray-200 pr-10" required>
          <i class="fa-solid fa-eye absolute right-3 top-9 text-gray-600 cursor-pointer" onclick="togglePassword('password', this)"></i>
        </div>

        <div class="relative">
          <label class="block font-semibold">Confirm Password</label>
          <input type="password" id="confirmPassword" name="confirm_password" class="w-full px-3 py-2 border rounded bg-gray-200 pr-10" required>
          <i class="fa-solid fa-eye absolute right-3 top-9 text-gray-600 cursor-pointer" onclick="togglePassword('confirmPassword', this)"></i>
        </div>

        <div class="flex justify-end space-x-3 pt-4">
          <a href="../lawyer-data/lwyer-data.php" class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700">Cancel</a>
          <button type="submit" class="bg-gray-600 text-white px-6 py-2 rounded hover:bg-gray-700">Submit</button>
        </div>
      </form>
    </main>
  </div>

  <script>
    function togglePassword(id, el) {
      const input = document.getElementById(id);
      if (input.type === "password") {
        input.type = "text";
        el.classList.remove("fa-eye");
        el.classList.add("fa-eye-slash");
      } else {
        input.type = "password";
        el.classList.remove("fa-eye-slash");
        el.classList.add("fa-eye");
      }
    }
  </script>

</body>
</html>
