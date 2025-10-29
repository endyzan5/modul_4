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

// Pastikan ada ID
if (!isset($_GET['id'])) {
  header("Location: ../lawyer-data/lwyer-data.php");
  exit;
}

$id = $_GET['id'];

// Ambil data lawyer
$stmt = $pdo->prepare("SELECT l.*, u.username, u.email AS user_email, u.id AS user_id
                       FROM lawyers l
                       JOIN users u ON l.user_id = u.id
                       WHERE l.id = ?");
$stmt->execute([$id]);
$lawyer = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$lawyer) {
  die("Data lawyer tidak ditemukan!");
}

// Update data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
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
        // Validasi username
        if (!preg_match('/^[A-Za-z0-9]+$/', $username)) {
            echo "<script>alert('Username hanya boleh berisi huruf dan angka tanpa spasi atau karakter spesial!');</script>";
        } else {
            // Update tabel users
            if (!empty($password)) {
                $hashed_password = hash('sha256', $password);
                $stmtUser = $pdo->prepare("UPDATE users SET username=?, email=?, password=? WHERE id=?");
                $stmtUser->execute([$username, $email, $hashed_password, $lawyer['user_id']]);
            } else {
                $stmtUser = $pdo->prepare("UPDATE users SET username=?, email=? WHERE id=?");
                $stmtUser->execute([$username, $email, $lawyer['user_id']]);
            }

            // Update tabel lawyers
            $stmtLawyer = $pdo->prepare("UPDATE lawyers 
                                         SET full_name=?, email=?, address=?, birth_place=?, birth_date=?, profession=?, phone=? 
                                         WHERE id=?");
            $stmtLawyer->execute([$full_name, $email, $address, $birth_place, $birth_date, $profession, $phone, $id]);

            echo "<script>alert('Data lawyer berhasil diperbarui!'); window.location.href='../lawyer-data/lwyer-data.php';</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Lawyer - Three Brother Law</title>
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
      <h1 class="text-3xl font-bold mb-6">Edit Lawyer</h1>

      <form method="POST" class="bg-white p-6 rounded-xl shadow-lg space-y-4 max-w-2xl">
        <div>
          <label class="block font-semibold">Full Name</label>
          <input type="text" name="full_name" value="<?= htmlspecialchars($lawyer['full_name']) ?>" required class="w-full px-3 py-2 border rounded bg-gray-200">
        </div>

        <div>
          <label class="block font-semibold">Username</label>
          <input type="text" name="username" value="<?= htmlspecialchars($lawyer['username']) ?>" required class="w-full px-3 py-2 border rounded bg-gray-200">
        </div>

        <div>
          <label class="block font-semibold">Email Address</label>
          <input type="email" name="email" value="<?= htmlspecialchars($lawyer['user_email']) ?>" required class="w-full px-3 py-2 border rounded bg-gray-200">
          <p class="text-xs text-gray-500">Please use Gmail to register an account.</p>
        </div>

        <div>
          <label class="block font-semibold">Address</label>
          <input type="text" name="address" value="<?= htmlspecialchars($lawyer['address']) ?>" class="w-full px-3 py-2 border rounded bg-gray-200">
        </div>

        <div>
          <label class="block font-semibold">Place of Birth</label>
          <input type="text" name="birth_place" value="<?= htmlspecialchars($lawyer['birth_place']) ?>" class="w-full px-3 py-2 border rounded bg-gray-200">
        </div>

        <div>
          <label class="block font-semibold">Date of Birth</label>
          <input type="date" name="birth_date" value="<?= htmlspecialchars($lawyer['birth_date']) ?>" class="w-full px-3 py-2 border rounded bg-gray-200">
        </div>

        <div>
          <label class="block font-semibold">Lawyer Profession</label>
          <select name="profession" required class="w-full px-3 py-2 border rounded bg-gray-200">
            <option value="" disabled>-- Pilih Profesi --</option>
            <option value="Advokat" <?= $lawyer['profession'] === 'Advokat' ? 'selected' : '' ?>>Advokat</option>
            <option value="Pidana" <?= $lawyer['profession'] === 'Pidana' ? 'selected' : '' ?>>Pidana</option>
            <option value="Koorporasi" <?= $lawyer['profession'] === 'Koorporasi' ? 'selected' : '' ?>>Koorporasi</option>
            <option value="Sengketa" <?= $lawyer['profession'] === 'Sengketa' ? 'selected' : '' ?>>Sengketa</option>
          </select>
        </div>

        <div>
          <label class="block font-semibold">Phone Number</label>
          <input type="text" name="phone" value="<?= htmlspecialchars($lawyer['phone']) ?>" class="w-full px-3 py-2 border rounded bg-gray-200">
        </div>

        <div class="relative">
          <label class="block font-semibold">Password</label>
          <input type="password" id="password" name="password" class="w-full px-3 py-2 border rounded bg-gray-200 pr-10" placeholder="Isi jika ingin mengganti password">
          <i class="fa-solid fa-eye absolute right-3 top-9 text-gray-600 cursor-pointer" onclick="togglePassword('password', this)"></i>
        </div>

        <div class="relative">
          <label class="block font-semibold">Confirm Password</label>
          <input type="password" id="confirmPassword" name="confirm_password" class="w-full px-3 py-2 border rounded bg-gray-200 pr-10" placeholder="Ulangi password baru">
          <i class="fa-solid fa-eye absolute right-3 top-9 text-gray-600 cursor-pointer" onclick="togglePassword('confirmPassword', this)"></i>
        </div>

        <div class="flex justify-end space-x-3 pt-4">
          <a href="../lawyer-data/lwyer-data.php" class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700">Cancel</a>
          <button type="submit" class="bg-gray-600 text-white px-6 py-2 rounded hover:bg-gray-700">Update</button>
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

    // ✅ Validasi username (hanya huruf dan angka)
    document.querySelector("form").addEventListener("submit", function(e) {
      const username = document.querySelector("input[name='username']").value;
      const usernamePattern = /^[A-Za-z0-9]+$/;
      if (!usernamePattern.test(username)) {
        e.preventDefault();
        alert("Username hanya boleh berisi huruf dan angka tanpa spasi atau karakter spesial!");
      }
    });
  </script>

</body>
</html>
