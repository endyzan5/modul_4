<?php
session_start();
require_once '../../config.php';

// Proteksi halaman: hanya admin yang boleh akses
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Administrator') {
    header("Location: ../../login.php");
    exit;
}

$stmt = $pdo->query("
  SELECT 
    c.customer_name,
    c.consultation_date,
    COALESCE(l.full_name, c.lawyer_name) AS lawyer_name,
    COALESCE(l.profession, c.profession) AS profession,
    c.day,
    c.time
  FROM consultation_schedule c
  LEFT JOIN lawyers l ON c.lawyer_id = l.id
  ORDER BY c.consultation_date DESC
");
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
          <a href="../admin-dashboard.php" class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-100">
            <i class="fa-solid fa-house"></i>
            <span>Dashboard</span>
          </a>
          <a href="../lawyer-data/lwyer-data.php" class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-100">
            <i class="fa-solid fa-user"></i>
            <span>Lawyer Data</span>
          </a>
          <a href="../customer-data/customer-data.php" class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-100">
            <i class="fa-solid fa-users"></i>
            <span>Customer Data</span>
          </a>
          <a href="./consultation.php" class="flex items-center space-x-3 px-4 py-2 rounded-lg bg-gray-100 text-red-600 font-semibold">
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
      <h1 class="text-3xl font-bold mb-6">Consultation Schedule</h1>

      <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        <table class="w-full text-left border-collapse">
          <thead class="bg-gray-200">
            <tr>
              <th class="py-3 px-4">No</th>
              <th class="py-3 px-4">Customer Name</th>
              <th class="py-3 px-4">Consultation Date</th>
              <th class="py-3 px-4">Lawyer</th>
              <th class="py-3 px-4">Profession</th>
              <th class="py-3 px-4">Day</th>
              <th class="py-3 px-4">Time</th>
            </tr>
          </thead>
          <tbody>
            <?php if (count($consultations) > 0): ?>
              <?php foreach ($consultations as $index => $row): ?>
                <tr class="border-b hover:bg-gray-50">
                  <td class="py-3 px-4"><?= $index + 1 ?></td>
                  <td class="py-3 px-4"><?= htmlspecialchars((string)($row['customer_name'] ?? '')) ?></td>
                  <td class="py-3 px-4">
                    <?= htmlspecialchars((string)(!empty($row['consultation_date']) ? date("d F Y", strtotime($row['consultation_date'])) : '')) ?>
                  </td>
                  <td class="py-3 px-4"><?= htmlspecialchars((string)($row['lawyer_name'] ?? '')) ?></td>
                  <td class="py-3 px-4"><?= htmlspecialchars((string)($row['profession'] ?? '')) ?></td>
                  <td class="py-3 px-4"><?= htmlspecialchars((string)($row['day'] ?? '')) ?></td>
                  <td class="py-3 px-4"><?= htmlspecialchars((string)($row['time'] ?? '')) ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="7" class="py-4 text-center text-gray-500">No consultation data available.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>

</body>
</html>
