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

// Proses hapus data
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id AND role = 'Customer'");
    $stmt->execute(['id' => $id]);
    header("Location: customer-data.php");
    exit;
}

// Ambil data customer
$stmt = $pdo->query("SELECT id, username, email, created_at FROM users WHERE role = 'Customer' ORDER BY id DESC");
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Customer Data - Three Brother Law</title>
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
          <a href="./customer-data.php" class="flex items-center space-x-3 px-4 py-2 rounded-lg bg-gray-100 text-red-600 font-semibold">
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
      <h1 class="text-3xl font-bold mb-6">Customer Data</h1>

      <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        <table class="w-full text-left border-collapse">
          <thead class="bg-gray-200">
            <tr>
              <th class="py-3 px-4">#</th>
              <th class="py-3 px-4">Username</th>
              <th class="py-3 px-4">Email</th>
              <th class="py-3 px-4">Created At</th>
              <th class="py-3 px-4 text-center">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (count($customers) > 0): ?>
              <?php foreach ($customers as $index => $customer): ?>
                <tr class="border-b hover:bg-gray-50">
                  <td class="py-3 px-4"><?= $index + 1 ?></td>
                  <td class="py-3 px-4"><?= htmlspecialchars($customer['username']) ?></td>
                  <td class="py-3 px-4"><?= htmlspecialchars($customer['email']) ?></td>
                  <td class="py-3 px-4"><?= htmlspecialchars($customer['created_at']) ?></td>
                  <td class="py-3 px-4 text-center">
                    <button onclick="confirmDelete(<?= $customer['id'] ?>)" 
                      class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                      Delete
                    </button>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="py-4 text-center text-gray-500">No customer data found.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>

  <script>
    function confirmDelete(id) {
      if (confirm("Are you sure you want to delete this customer?")) {
        window.location.href = "customer-data.php?delete_id=" + id;
      }
    }
  </script>

</body>
</html>
