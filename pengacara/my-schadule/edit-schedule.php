<?php
session_start();
require '../../config.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    echo "<script>alert('Jadwal tidak ditemukan!'); window.location.href='my-schedule.php';</script>";
    exit;
}

$id = $_GET['id'];

// Ambil data jadwal berdasarkan ID dan username
$stmt = $pdo->prepare("SELECT * FROM lawyer_schedule WHERE id = :id AND lawyer_username = :lawyer");
$stmt->execute([':id' => $id, ':lawyer' => $_SESSION['username']]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    echo "<script>alert('Data tidak ditemukan atau bukan milik Anda!'); window.location.href='my-schedule.php';</script>";
    exit;
}

// Proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $day = $_POST['day'];
    $start = $_POST['start'];
    $finished = $_POST['finished'];

    $update = $pdo->prepare("UPDATE lawyer_schedule 
                             SET day = :day, start_time = :start, end_time = :finished 
                             WHERE id = :id AND lawyer_username = :lawyer");
    try {
        $update->execute([
            ':day' => $day,
            ':start' => $start,
            ':finished' => $finished,
            ':id' => $id,
            ':lawyer' => $_SESSION['username']
        ]);
        echo "<script>alert('Jadwal berhasil diperbarui!'); window.location.href='my-schedule.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Gagal memperbarui jadwal: " . $e->getMessage() . "');</script>";
    }
}
?>
<!-- (lanjutan HTML sama seperti sebelumnya) -->


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Schedule - Three Brother Law</title>
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
          <a href="../lawyer-dashboard.php" class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-100">
            <i class="fa-solid fa-house"></i>
            <span>Dashboard</span>
          </a>
          <a href="../lawyer-schedule/lawyer-schedule.php" class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-100">
            <i class="fa-regular fa-calendar"></i>
            <span>Lawyer Schedule</span>
          </a>
          <a href="../consultation/consultation.php" class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-100">
            <i class="fa-regular fa-clipboard"></i>
            <span>Consultation</span>
          </a>
          <a href="../consultation-history/consultation-history.php" class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-100">
            <i class="fa-solid fa-database"></i>
            <span>Consultation History</span>
          </a>
          <a href="./my-schedule.php" class="flex items-center space-x-3 px-4 py-2 rounded-lg bg-gray-100 text-red-600 font-semibold">
            <i class="fa-solid fa-server"></i>
            <span>My Schedule</span>
          </a>
          <a href="../my-profile/my-profile.php" class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-100">
            <i class="fa-regular fa-user"></i>
            <span>My Profile</span>
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
    <main class="flex-1 p-12">
      <!-- Edit Working Schedule Form -->
      <div class="bg-white shadow-lg rounded-2xl p-8 mt-6 max-w-xl">
        <h2 class="text-xl font-bold mb-6">Edit Working Schedule</h2>

        <form action="" method="POST" class="space-y-6">
          <!-- Day -->
          <div>
            <label for="day" class="block text-sm font-semibold mb-2">Day</label>
            <select id="day" name="day" required
                class="w-full px-4 py-2 border rounded-lg bg-gray-100 focus:outline-none focus:ring-2 focus:ring-black">
                <option value="">-- Select Day --</option>
                <option value="Senin" <?= ($row['day'] == 'Senin') ? 'selected' : '' ?>>Senin</option>
                <option value="Selasa" <?= ($row['day'] == 'Selasa') ? 'selected' : '' ?>>Selasa</option>
                <option value="Rabu" <?= ($row['day'] == 'Rabu') ? 'selected' : '' ?>>Rabu</option>
                <option value="Kamis" <?= ($row['day'] == 'Kamis') ? 'selected' : '' ?>>Kamis</option>
                <option value="Jumat" <?= ($row['day'] == 'Jumat') ? 'selected' : '' ?>>Jumat</option>
            </select>
          </div>

          <!-- Working Time Start -->
          <div>
            <label for="start" class="block text-sm font-semibold mb-2">Working Time - Start</label>
            <select id="start" name="start" required
                class="w-full px-4 py-2 border rounded-lg bg-gray-100 focus:outline-none focus:ring-2 focus:ring-black">
                <option value="">-- Select Start Time --</option>
                <option value="08.00" <?= ($row['start_time'] == '08.00') ? 'selected' : '' ?>>08.00</option>
                <option value="10.00" <?= ($row['start_time'] == '10.00') ? 'selected' : '' ?>>10.00</option>
                <option value="13.00" <?= ($row['start_time'] == '13.00') ? 'selected' : '' ?>>13.00</option>
                <option value="15.00" <?= ($row['start_time'] == '15.00') ? 'selected' : '' ?>>15.00</option>
            </select>
          </div>

          <!-- Working Time Finished -->
          <div>
            <label for="finished" class="block text-sm font-semibold mb-2">Working Time - Finished</label>
            <select id="finished" name="finished" required
                class="w-full px-4 py-2 border rounded-lg bg-gray-100 focus:outline-none focus:ring-2 focus:ring-black">
                <option value="">-- Select Finish Time --</option>
                <option value="10.00" <?= ($row['end_time'] == '10.00') ? 'selected' : '' ?>>10.00</option>
                <option value="12.00" <?= ($row['end_time'] == '12.00') ? 'selected' : '' ?>>12.00</option>
                <option value="15.00" <?= ($row['end_time'] == '15.00') ? 'selected' : '' ?>>15.00</option>
                <option value="17.00" <?= ($row['end_time'] == '17.00') ? 'selected' : '' ?>>17.00</option>
            </select>
          </div>

          <div class="flex justify-end space-x-4">
            <a href="./my-schedule.php" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Cancel</a>
            <button type="submit" class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Update</button>
          </div>
        </form>

      </div>
    </main>
  </div>

</body>
</html>
