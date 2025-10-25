<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['role'] !== 'Administrator') {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Three Brother Law</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans">

  <div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg flex flex-col justify-between">
      <div>
        <div class="p-6 text-center">
          <img src="../assets/img/logo.png" alt="Logo" class="w-20 mx-auto mb-2">
          <h2 class="text-lg font-bold">Three Brother Law</h2>
        </div>

        <nav class="px-4 space-y-2">
          <a href="../admin/admin-dashboard.php" class="flex items-center space-x-3 px-4 py-2 rounded-lg bg-gray-100 text-red-600 font-semibold">
            <i class="fa-solid fa-house"></i>
            <span>Dashboard</span>
          </a>
          <a href="../admin/lawyer-data/lwyer-data.php" class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-100">
            <i class="fa-solid fa-user"></i>
            <span>Lawyer Data</span>
          </a>
          <a href="../admin/customer-data/customer-data.php" class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-100">
            <i class="fa-solid fa-users"></i>
            <span>Customer Data</span>
          </a>
          <a href="../admin/consultation/consultation.php" class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-100">
            <i class="fa-solid fa-file-lines"></i>
            <span>Consultation</span>
          </a>
        </nav>
      </div>

      <div class="p-6">
        <button onclick="window.location.href='../logout.php'" 
          class="w-full py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 font-semibold">
          Log-out
        </button>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-12">
      <h1 class="text-3xl font-bold mb-2">Welcome Back!</h1>
      <p class="text-xl text-gray-600 mb-10">My beloved <span class="font-semibold">Administrator</span></p>

      <div class="grid md:grid-cols-3 gap-10 max-w-5xl">
        <!-- Card 1 -->
        <a href="../admin/lawyer-data/lwyer-data.php" 
           class="block bg-gray-200 rounded-lg overflow-hidden shadow hover:shadow-lg transition cursor-pointer">
          <div class="flex justify-center items-center h-48 text-7xl text-gray-600">
            <i class="fa-solid fa-user"></i>
          </div>
          <div class="bg-gray-700 text-white p-4 text-center">
            <h3 class="font-bold">Lawyer Data</h3>
            <p>Lawyer</p>
          </div>
        </a>

        <!-- Card 2 -->
        <a href="../admin/customer-data/customer-data.php" 
           class="block bg-gray-200 rounded-lg overflow-hidden shadow hover:shadow-lg transition cursor-pointer">
          <div class="flex justify-center items-center h-48 text-7xl text-gray-600">
            <i class="fa-solid fa-users"></i>
          </div>
          <div class="bg-gray-700 text-white p-4 text-center">
            <h3 class="font-bold">Customer Data</h3>
            <p>Customer</p>
          </div>
        </a>

        <!-- Card 3 -->
        <a href="../admin/consultation/consultation.php" 
           class="block bg-gray-200 rounded-lg overflow-hidden shadow hover:shadow-lg transition cursor-pointer">
          <div class="flex justify-center items-center h-48 text-7xl text-gray-600">
            <i class="fa-solid fa-file-lines"></i>
          </div>
          <div class="bg-gray-700 text-white p-4 text-center">
            <h3 class="font-bold">Consultation</h3>
            <p>Services</p>
          </div>
        </a>
      </div>
    </main>
  </div>

</body>
</html>
