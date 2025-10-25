<?php
session_start();
require '../../config.php';

// Proteksi halaman
if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit;
}

// Simpan data jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lawyer = $_SESSION['username'];
    $day = $_POST['day'];
    $start = $_POST['start'];
    $finished = $_POST['finished'];

    $sql = "INSERT INTO lawyer_schedule (lawyer_username, day, start_time, end_time)
            VALUES (:lawyer, :day, :start, :finished)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            ':lawyer' => $lawyer,
            ':day' => $day,
            ':start' => $start,
            ':finished' => $finished
        ]);
        echo "<script>alert('Jadwal berhasil ditambahkan!'); window.location.href='my-schedule.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Gagal menambahkan jadwal: " . $e->getMessage() . "');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Schedule - Three Brother Law</title>
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
          <a href="../lawyer-schadule/lawyer-schedule.php" class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-100">
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
      <!-- Add Working Schedule Form -->
        <div class="bg-white shadow-lg rounded-2xl p-8 mt-6 max-w-xl">
        <h2 class="text-xl font-bold mb-6">Add Working Schedule</h2>

        <form action="" method="POST" class="space-y-6">
        <!-- Day -->
        <div>
            <label for="day" class="block text-sm font-semibold mb-2">Day</label>
            <select id="day" name="day" required
                class="w-full px-4 py-2 border rounded-lg bg-gray-100 focus:outline-none focus:ring-2 focus:ring-black">
                <option value="">-- Select Day --</option>
                <option value="Senin">Senin</option>
                <option value="Selasa">Selasa</option>
                <option value="Rabu">Rabu</option>
                <option value="Kamis">Kamis</option>
                <option value="Jumat">Jumat</option>
            </select>
        </div>

        <!-- Working Time Start -->
        <div>
            <label for="start" class="block text-sm font-semibold mb-2">Working Time - Start</label>
            <select id="start" name="start" required
                class="w-full px-4 py-2 border rounded-lg bg-gray-100 focus:outline-none focus:ring-2 focus:ring-black">
                <option value="">-- Select Start Time --</option>
                <option value="08.00">08.00</option>
                <option value="10.00">10.00</option>
                <option value="13.00">13.00</option>
                <option value="15.00">15.00</option>
            </select>
        </div>

        <!-- Working Time Finished -->
        <div>
            <label for="finished" class="block text-sm font-semibold mb-2">Working Time - Finished</label>
            <select id="finished" name="finished" required
                class="w-full px-4 py-2 border rounded-lg bg-gray-100 focus:outline-none focus:ring-2 focus:ring-black">
                <option value="">-- Select Finish Time --</option>
                <option value="10.00">10.00</option>
                <option value="12.00">12.00</option>
                <option value="15.00">15.00</option>
                <option value="17.00">17.00</option>
            </select>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="./my-schedule.php" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Cancel</a>
            <button type="submit" class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Submit</button>
        </div>
    </form>

        </div>

    </main>
  </div>

</body>
</html>
