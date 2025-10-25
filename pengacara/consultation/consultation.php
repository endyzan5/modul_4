<?php
session_start();
require_once '../../config.php';

// Proteksi halaman (pastikan hanya lawyer yang bisa mengakses)
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Lawyer') {
    header("Location: ../../login.php");
    exit;
}

// Ambil semua data konsultasi berdasarkan nama lawyer login
$stmt = $pdo->prepare("
    SELECT id, customer_name, consultation_date, day, time, status 
    FROM consultation_schedule 
    WHERE lawyer_name = :lawyer_name 
    ORDER BY id DESC
");
$stmt->execute(['lawyer_name' => $_SESSION['username']]);
$consultations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Consultation - Three Brother Law</title>
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
          <a href="./consultation.php" class="flex items-center space-x-3 px-4 py-2 rounded-lg bg-gray-100 text-red-600 font-semibold">
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
      <h1 class="text-3xl font-bold mb-8">Consultation Schedule</h1>

      <!-- Table -->
      <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
        <table class="w-full text-left border-collapse">
          <thead class="bg-gray-200">
            <tr>
              <th class="px-6 py-3 font-semibold">ID</th>
              <th class="px-6 py-3 font-semibold">Customer Name</th>
              <th class="px-6 py-3 font-semibold">Date</th>
              <th class="px-6 py-3 font-semibold">Day</th>
              <th class="px-6 py-3 font-semibold">Time</th>
              <th class="px-6 py-3 font-semibold">Status</th>
              <th class="px-6 py-3 font-semibold">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (count($consultations) > 0): ?>
              <?php foreach ($consultations as $row): ?>
                <tr class="border-t hover:bg-gray-50">
                  <td class="px-6 py-4"><?= htmlspecialchars($row['id']) ?></td>
                  <td class="px-6 py-4"><?= htmlspecialchars($row['customer_name']) ?></td>
                  <td class="px-6 py-4"><?= htmlspecialchars($row['consultation_date']) ?></td>
                  <td class="px-6 py-4"><?= htmlspecialchars($row['day']) ?></td>
                  <td class="px-6 py-4"><?= htmlspecialchars($row['time']) ?></td>
                  <td class="px-6 py-4">
                    <span class="<?= $row['status'] == 'Accepted' ? 'text-green-600' : ($row['status'] == 'Rejected' ? 'text-red-600' : 'text-yellow-600') ?>">
                      <?= htmlspecialchars($row['status']) ?>
                    </span>
                  </td>
                  <td class="px-6 py-4 flex space-x-2">
                    <form method="POST" action="update-status.php">
                      <input type="hidden" name="id" value="<?= $row['id'] ?>">
                      <button name="action" value="accept" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">Yes</button>
                      <button name="action" value="reject" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">No</button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
                <tr>
                  <td colspan="7" class="text-center py-4 text-gray-500">No consultation schedule yet.</td>
                </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</body>
</html>
