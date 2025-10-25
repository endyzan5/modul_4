<?php
session_start();
require_once '../../config.php';

// Proteksi akses login
if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit;
}

try {
    // Ambil data jadwal lawyer beserta profesinya
    $stmt = $pdo->query("
        SELECT 
            ls.lawyer_username, 
            l.profession,
            ls.day, 
            ls.start_time, 
            ls.end_time
        FROM lawyer_schedule ls
        JOIN lawyers l ON l.full_name = ls.lawyer_username
        ORDER BY ls.id DESC
    ");
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Terjadi kesalahan: " . $e->getMessage());
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lawyer Schedule - Three Brother Law</title>
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
          <a href="./lawyer-schedule.php" class="flex items-center space-x-3 px-4 py-2 rounded-lg bg-gray-100 text-red-600 font-semibold">
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
          <a href="../my-schadule/my-schedule.php" class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-100">
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
      <h1 class="text-3xl font-bold mb-8">Lawyer Schedule</h1>

      <!-- Table -->
      <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
        <table class="w-full text-left border-collapse">
          <thead class="bg-gray-200">
            <tr>
              <th class="px-6 py-3 font-semibold">Lawyer Name</th>
              <th class="px-6 py-3 font-semibold">Profession</th>
              <th class="px-6 py-3 font-semibold">Day</th>
              <th class="px-6 py-3 font-semibold">Time</th>
            </tr>
          </thead>
          <tbody>
        <?php if (count($result) > 0): ?>
            <?php foreach ($result as $row): ?>
                <tr class="border-t">
                    <td class="px-6 py-4"><?= htmlspecialchars($row['lawyer_username']) ?></td>
                    <td class="px-6 py-4"><?= htmlspecialchars($row['profession']) ?></td>
                    <td class="px-6 py-4"><?= htmlspecialchars($row['day']) ?></td>
                    <td class="px-6 py-4"><?= htmlspecialchars($row['start_time']) ?> - <?= htmlspecialchars($row['end_time']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada jadwal.</td>
            </tr>
        <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <!-- <div class="flex items-center justify-between mt-6">
        <button class="flex items-center px-3 py-1 text-sm bg-black text-white rounded hover:opacity-80">
          <span class="mr-1">&lt;</span> Previous
        </button>

        <div class="flex items-center space-x-2 text-gray-700">
          <span class="px-3 py-1 rounded bg-black text-white text-sm">1</span>
          <span class="px-2">2</span>
          <span class="px-2">3</span>
          <span class="px-2">...</span>
          <span class="px-2">67</span>
          <span class="px-2">68</span>
        </div>

        <button class="flex items-center px-3 py-1 text-sm bg-black text-white rounded hover:opacity-80">
          Next <span class="ml-1">&gt;</span>
        </button>
      </div> -->
    </main>
  </div>

</body>
</html>
