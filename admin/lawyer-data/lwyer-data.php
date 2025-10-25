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

// Ambil seluruh data lawyer
$stmt = $pdo->query("SELECT * FROM lawyers ORDER BY id DESC");
$lawyers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lawyer Data - Three Brother Law</title>
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
          <a href="./lawyer-data.php" class="flex items-center space-x-3 px-4 py-2 rounded-lg bg-gray-100 text-red-600 font-semibold">
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
        <form action="../../logout.php" method="POST">
          <button type="submit" 
            class="w-full py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 font-semibold">
            Log-out
          </button>
        </form>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Lawyer Data</h1>
        <a href="./add-lawyer.php" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
          Add +
        </a>
      </div>

      <!-- Table -->
      <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <table class="w-full text-left">
          <thead class="bg-gray-200">
            <tr>
              <th class="px-6 py-3">#</th>
              <th class="px-6 py-3">Full Name</th>
              <th class="px-6 py-3">Profession</th>
              <th class="px-6 py-3">Email</th>
              <th class="px-6 py-3">Phone</th>
              <th class="px-6 py-3">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (count($lawyers) > 0): ?>
              <?php foreach ($lawyers as $index => $lawyer): ?>
                <tr class="border-b hover:bg-gray-50">
                  <td class="px-6 py-3"><?= $index + 1 ?></td>
                  <td class="px-6 py-3"><?= htmlspecialchars($lawyer['full_name']) ?></td>
                  <td class="px-6 py-3"><?= htmlspecialchars($lawyer['profession']) ?></td>
                  <td class="px-6 py-3"><?= htmlspecialchars($lawyer['email']) ?></td>
                  <td class="px-6 py-3"><?= htmlspecialchars($lawyer['phone']) ?></td>
                  <td class="px-6 py-3 flex space-x-2">
                    <button onclick="window.location.href='./edit-lawyer.php?id=<?= $lawyer['id'] ?>'" 
                      class="bg-black text-white px-3 py-1 rounded hover:bg-gray-800">
                      Edit
                    </button>
                    <button onclick="confirmDelete(<?= $lawyer['id'] ?>)" 
                      class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                      Delete
                    </button>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center py-6 text-gray-500">No lawyer data found.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>

  <script>
    function confirmDelete(id) {
      if (confirm("Are you sure you want to delete this lawyer?")) {
        window.location.href = "delete-lawyer.php?id=" + id;
      }
    }
  </script>

</body>
</html>
