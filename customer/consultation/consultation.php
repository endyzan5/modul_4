<?php
session_start();
require_once '../../config.php';


if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Customer') {
    header("Location: ../login.php");
    exit;
}

// Ambil semua profesi unik dari tabel lawyers
$stmt = $pdo->query("SELECT DISTINCT profession FROM lawyers WHERE profession IS NOT NULL");
$professions = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Consultation - Three Brother Law</title>
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
        <a href="./consultation.php" class="flex items-center space-x-3 px-4 py-2 rounded-lg bg-gray-100 text-red-600 font-semibold">
          <i class="fa-regular fa-clipboard"></i>
          <span>Consultation</span>
        </a>
        <a href="../consultation-status/consultation-status.php" class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-100">
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
    <h1 class="text-3xl font-bold mb-8">Add Consultation</h1>

    <div class="bg-white shadow-lg rounded-lg p-8">
      <form class="space-y-6" method="POST" action="process-consultation.php">
        <div class="flex flex-wrap gap-4">
          <!-- Profession Dropdown -->
          <div class="relative inline-block w-40">
            <button type="button" id="professionBtn" onclick="toggleDropdown('professionDropdown')" 
              class="w-full flex justify-between items-center px-4 py-2 bg-gray-300 rounded-lg shadow hover:bg-gray-400">
              Profession
              <i class="fa-solid fa-chevron-down ml-2"></i>
            </button>
            <div id="professionDropdown" class="absolute hidden w-full mt-2 bg-gray-200 rounded-lg shadow-lg z-10">
              <?php foreach ($professions as $profession): ?>
                <button type="button" onclick="selectProfession('<?php echo $profession; ?>')" 
                  class="w-full px-4 py-2 text-left hover:bg-gray-300">
                  <?= htmlspecialchars($profession) ?>
                </button>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- Lawyer Dropdown -->
          <div class="relative inline-block w-40">
            <button type="button" id="lawyerBtn" disabled 
              onclick="toggleDropdown('lawyerDropdown')" 
              class="w-full flex justify-between items-center px-4 py-2 bg-gray-200 rounded-lg shadow cursor-not-allowed">
              Lawyer
              <i class="fa-solid fa-chevron-down ml-2"></i>
            </button>
            <div id="lawyerDropdown" class="absolute hidden w-full mt-2 bg-gray-200 rounded-lg shadow-lg z-10"></div>
          </div>

          <!-- Day Dropdown -->
          <div class="relative inline-block w-40">
            <button type="button" id="dayBtn" disabled 
              onclick="toggleDropdown('dayDropdown')" 
              class="w-full flex justify-between items-center px-4 py-2 bg-gray-200 rounded-lg shadow cursor-not-allowed">
              Day
              <i class="fa-solid fa-chevron-down ml-2"></i>
            </button>
            <div id="dayDropdown" class="absolute hidden w-full mt-2 bg-gray-200 rounded-lg shadow-lg z-10"></div>
          </div>

          <!-- Time Dropdown -->
          <div class="relative inline-block w-40">
            <button type="button" id="timeBtn" disabled 
              onclick="toggleDropdown('timeDropdown')" 
              class="w-full flex justify-between items-center px-4 py-2 bg-gray-200 rounded-lg shadow cursor-not-allowed">
              Time
              <i class="fa-solid fa-chevron-down ml-2"></i>
            </button>
            <div id="timeDropdown" class="absolute hidden w-full mt-2 bg-gray-200 rounded-lg shadow-lg z-10"></div>
          </div>
        </div>

        <!-- Hidden input untuk menyimpan pilihan -->
        <input type="hidden" name="profession" id="hiddenProfession">
        <input type="hidden" name="lawyer" id="hiddenLawyer">
        <input type="hidden" name="day" id="hiddenDay">
        <input type="hidden" name="time" id="hiddenTime">

        <div class="flex justify-end">
          <button type="submit" class="px-6 py-2 bg-gradient-to-r from-gray-400 to-gray-600 text-white font-semibold rounded shadow hover:opacity-90">
            Submit
          </button>
        </div>
      </form>
    </div>
  </main>
</div>

<script>
function toggleDropdown(id) {
  document.getElementById(id).classList.toggle("hidden");
}

// pilih profesi
function selectProfession(profession) {
  document.getElementById("hiddenProfession").value = profession;
  const btn = document.getElementById("professionBtn");
  btn.childNodes[0].nodeValue = profession + " ";
  document.getElementById("professionDropdown").classList.add("hidden");

  // aktifkan dropdown lawyer
  const lawyerBtn = document.getElementById("lawyerBtn");
  lawyerBtn.disabled = false;
  lawyerBtn.classList.remove("bg-gray-200", "cursor-not-allowed");
  lawyerBtn.classList.add("bg-gray-300", "hover:bg-gray-400");

  // ambil data lawyer sesuai profesi
  fetch('get-lawyers.php?profession=' + encodeURIComponent(profession))
    .then(res => res.json())
    .then(data => {
      const dropdown = document.getElementById("lawyerDropdown");
      dropdown.innerHTML = "";
      data.forEach(lawyer => {
        const btn = document.createElement("button");
        btn.type = "button";
        btn.className = "w-full px-4 py-2 text-left hover:bg-gray-300";
        btn.textContent = lawyer.full_name;
        btn.onclick = function() {
          selectLawyer(lawyer.full_name, lawyer.id);
        };
        dropdown.appendChild(btn);
      });
    });
}

// setelah pilih lawyer
function selectLawyer(lawyerName, lawyerId) {
  document.getElementById("hiddenLawyer").value = lawyerName;
  selectOption('lawyerBtn', lawyerName, 'lawyerDropdown');

  const dayBtn = document.getElementById("dayBtn");
  dayBtn.disabled = false;
  dayBtn.classList.remove("bg-gray-200", "cursor-not-allowed");
  dayBtn.classList.add("bg-gray-300", "hover:bg-gray-400");

  // Ambil jadwal lawyer
  fetch('get-schedule.php?lawyer_id=' + encodeURIComponent(lawyerId))
    .then(res => res.json())
    .then(data => {
      const uniqueDays = [...new Set(data.map(item => item.day))];
      const dayDropdown = document.getElementById("dayDropdown");
      dayDropdown.innerHTML = "";

      uniqueDays.forEach(day => {
        const btn = document.createElement("button");
        btn.type = "button";
        btn.className = "w-full px-4 py-2 text-left hover:bg-gray-300";
        btn.textContent = day;
        btn.onclick = function() {
          selectDay(day, data);
        };
        dayDropdown.appendChild(btn);
      });
    });
}

// setelah pilih hari
function selectDay(day, scheduleData) {
  document.getElementById("hiddenDay").value = day;
  selectOption('dayBtn', day, 'dayDropdown');

  const timeBtn = document.getElementById("timeBtn");
  timeBtn.disabled = false;
  timeBtn.classList.remove("bg-gray-200", "cursor-not-allowed");
  timeBtn.classList.add("bg-gray-300", "hover:bg-gray-400");

  const timeDropdown = document.getElementById("timeDropdown");
  timeDropdown.innerHTML = "";

  const times = scheduleData
    .filter(item => item.day === day)
    .map(item => `${item.start_time} - ${item.end_time}`);

  times.forEach(time => {
    const btn = document.createElement("button");
    btn.type = "button";
    btn.className = "w-full px-4 py-2 text-left hover:bg-gray-300";
    btn.textContent = time;
    btn.onclick = function() {
      selectTime(time);
    };
    timeDropdown.appendChild(btn);
  });
}

function selectTime(time) {
  document.getElementById("hiddenTime").value = time;
  selectOption('timeBtn', time, 'timeDropdown');
}

function selectOption(buttonId, value, dropdownId) {
  document.getElementById(buttonId).childNodes[0].nodeValue = value + " "; 
  document.getElementById(dropdownId).classList.add("hidden");
}
</script>

</body>
</html>
