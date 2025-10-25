<?php
session_start();
require_once '../../config.php';

// Cek apakah sudah login dan role adalah Customer
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Customer') {
    header("Location: ../login.php");
    exit;
}

// Ambil data konsultasi berdasarkan nama customer yang login
$customerName = $_SESSION['username'];
$stmt = $pdo->prepare("SELECT lawyer_name, profession, day, time, status 
                       FROM consultation_schedule 
                       WHERE customer_name = :customer_name 
                       ORDER BY created_at DESC");
$stmt->execute(['customer_name' => $customerName]);
$consultations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Consultation Status - Three Brother Law</title>
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
          <a href="../customer-dashboard.php" class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-100">
            <i class="fa-solid fa-house"></i>
            <span>Dashboard</span>
          </a>
          <a href="../consultation/consultation.php" class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-100">
            <i class="fa-regular fa-clipboard"></i>
            <span>Consultation</span>
          </a>
          <a href="./consultation-status.php" class="flex items-center space-x-3 px-4 py-2 rounded-lg bg-gray-100 text-red-600 font-semibold">
            <i class="fa-regular fa-inbox"></i>
            <span>Consultation Status</span>
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
      <h1 class="text-3xl font-bold mb-8">Consultation Status</h1>

      <!-- Table Card -->
      <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr class="bg-gray-200 text-gray-700">
              <th class="px-6 py-3">Lawyer Name</th>
              <th class="px-6 py-3">Profession</th>
              <th class="px-6 py-3">Day</th>
              <th class="px-6 py-3">Time</th>
              <th class="px-6 py-3">Status</th>
            </tr>
          </thead>
          <tbody>
            <?php if (count($consultations) > 0): ?>
              <?php foreach ($consultations as $row): ?>
                <tr class="border-t">
                  <td class="px-6 py-4"><?= htmlspecialchars($row['lawyer_name']) ?></td>
                  <td class="px-6 py-4"><?= htmlspecialchars($row['profession']) ?></td>
                  <td class="px-6 py-4"><?= htmlspecialchars($row['day']) ?></td>
                  <td class="px-6 py-4"><?= htmlspecialchars($row['time']) ?></td>
                  <td class="px-6 py-4">
                    <?php
                      $status = $row['status'];
                      $color = match($status) {
                          'Accepted' => 'bg-green-500',
                          'Rejected' => 'bg-red-500',
                          default => 'bg-gray-600'
                      };
                    ?>
                    <span class="px-3 py-1 rounded-md text-white text-sm <?= $color ?>">
                      <?= htmlspecialchars($status) ?>
                    </span>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="px-6 py-4 text-center text-gray-500">No consultation records found.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</body>
</html>
