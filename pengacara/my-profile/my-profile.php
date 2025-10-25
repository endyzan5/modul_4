<?php
session_start();
require_once '../../config.php';

// Proteksi akses
if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit;
}

$current_username = $_SESSION['username'];

// Ambil data lawyer berdasarkan username session
try {
    $stmt = $pdo->prepare("
        SELECT l.*, u.username, u.profile_picture 
        FROM lawyers l 
        JOIN users u ON l.user_id = u.id 
        WHERE u.username = :username
    ");
    $stmt->execute(['username' => $current_username]);
    $lawyer = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Kesalahan: " . $e->getMessage());
}

// Handle update profile
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $data = [
        'full_name'   => $_POST['full_name'],
        'email'       => $_POST['email'],
        'address'     => $_POST['address'],
        'birth_place' => $_POST['birth_place'],
        'birth_date'  => $_POST['birth_date'],
        'profession'  => $_POST['profession'],
        'phone'       => $_POST['phone'],
        'username'    => $current_username
    ];

    try {
        $stmt = $pdo->prepare("
            UPDATE lawyers 
            SET full_name = :full_name, email = :email, address = :address, 
                birth_place = :birth_place, birth_date = :birth_date, 
                profession = :profession, phone = :phone, updated_at = NOW()
            WHERE user_id = (SELECT id FROM users WHERE username = :username)
        ");
        $stmt->execute($data);
        $success_message = "Profile updated successfully!";

        // Refresh data
        $stmt = $pdo->prepare("
            SELECT l.*, u.username, u.profile_picture 
            FROM lawyers l 
            JOIN users u ON l.user_id = u.id 
            WHERE u.username = :username
        ");
        $stmt->execute(['username' => $current_username]);
        $lawyer = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error_message = "Error updating profile: " . $e->getMessage();
    }
}

// Handle photo upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] != UPLOAD_ERR_NO_FILE) {
    $upload_dir = "../../assets/uploads/profiles/";

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $file_name = time() . '_' . basename($_FILES['profile_picture']['name']);
    $target_file = $upload_dir . $file_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($imageFileType, $allowed_types)) {
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
            $relative_path = "assets/uploads/profiles/" . $file_name;

            try {
                $stmt = $pdo->prepare("UPDATE users SET profile_picture = :path WHERE username = :username");
                $stmt->execute(['path' => $relative_path, 'username' => $current_username]);
                $success_message = "Profile picture updated successfully!";
                $_SESSION['profile_picture'] = $relative_path;
                $lawyer['profile_picture'] = $relative_path;
            } catch (PDOException $e) {
                $error_message = "Error updating profile picture: " . $e->getMessage();
            }
        } else {
            $error_message = "Error uploading file.";
        }
    } else {
        $error_message = "Only JPG, JPEG, PNG & GIF files are allowed.";
    }
}

// Handle change password
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $error_message = "New password and confirm password do not match!";
    } elseif (strlen($new_password) < 6) {
        $error_message = "New password must be at least 6 characters long!";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT password FROM users WHERE username = :username");
            $stmt->execute(['username' => $current_username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $stored_password = $user['password'];
                $hashed_old_password = hash('sha256', $old_password);

                if ($hashed_old_password === $stored_password) {
                    $hashed_new_password = hash('sha256', $new_password);
                    $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE username = :username");
                    $stmt->execute([
                        'password' => $hashed_new_password,
                        'username' => $current_username
                    ]);
                    $success_message = "Password changed successfully!";
                } else {
                    $error_message = "Old password is incorrect!";
                }
            } else {
                $error_message = "User not found!";
            }
        } catch (PDOException $e) {
            $error_message = "Error changing password: " . $e->getMessage();
        }
    }
}

// Format tanggal lahir
$formatted_birth_date = '';
if (!empty($lawyer['birth_date']) && $lawyer['birth_date'] != '0000-00-00') {
    $formatted_birth_date = date('d F Y', strtotime($lawyer['birth_date']));
}

// Default profile picture
$profile_picture = !empty($lawyer['profile_picture'])
    ? '../../' . $lawyer['profile_picture']
    : '../../assets/img/profiletbl.png';
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Profile - Three Brother Law</title>
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
          <a href="../my-schadule/my-schedule.php" class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-100">
            <i class="fa-solid fa-server"></i>
            <span>My Schedule</span>
          </a>
          <a href="../my-profile/my-profile.php" class="flex items-center space-x-3 px-4 py-2 rounded-lg bg-gray-100 text-red-600 font-semibold">
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
      <!-- Notifications -->
      <?php if (isset($success_message)): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
          <?= htmlspecialchars($success_message) ?>
        </div>
      <?php endif; ?>
      
      <?php if (isset($error_message)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
          <?= htmlspecialchars($error_message) ?>
        </div>
      <?php endif; ?>

      <!-- My Profile Section -->
      <div class="bg-white shadow-lg rounded-2xl p-8 mt-6">
        <h1 class="text-3xl font-bold mb-8">My Profile</h1>

        <form method="POST" enctype="multipart/form-data">
          <div class="grid grid-cols-3 gap-8">
            <!-- Left: Profile Form -->
            <div class="col-span-2 space-y-6">
              <!-- Name -->
              <div>
                <label for="full_name" class="block text-sm font-semibold mb-2">Name</label>
                <input type="text" id="full_name" name="full_name" 
                    value="<?= htmlspecialchars($lawyer['full_name'] ?? '') ?>" 
                    class="w-full px-4 py-2 border rounded-lg">
              </div>

              <!-- Email -->
              <div>
                <label for="email" class="block text-sm font-semibold mb-2">Email Address</label>
                <input type="email" id="email" name="email" 
                    value="<?= htmlspecialchars($lawyer['email'] ?? '') ?>" 
                    class="w-full px-4 py-2 border rounded-lg">
              </div>

              <!-- Address -->
              <div>
                <label for="address" class="block text-sm font-semibold mb-2">Address</label>
                <input type="text" id="address" name="address" 
                    value="<?= htmlspecialchars($lawyer['address'] ?? '') ?>" 
                    class="w-full px-4 py-2 border rounded-lg">
              </div>

              <!-- Place of Birth -->
              <div>
                <label for="birth_place" class="block text-sm font-semibold mb-2">Place of Birth</label>
                <input type="text" id="birth_place" name="birth_place" 
                    value="<?= htmlspecialchars($lawyer['birth_place'] ?? '') ?>" 
                    class="w-full px-4 py-2 border rounded-lg">
              </div>

              <!-- Date of Birth -->
              <div>
                <label for="birth_date" class="block text-sm font-semibold mb-2">Date of Birth</label>
                <input type="date" id="birth_date" name="birth_date" 
                    value="<?= htmlspecialchars($lawyer['birth_date'] ?? '') ?>" 
                    class="w-full px-4 py-2 border rounded-lg">
              </div>

              <!-- Profession -->
              <div>
                <label for="profession" class="block text-sm font-semibold mb-2">Profession</label>
                <select id="profession" name="profession" class="w-full px-4 py-2 border rounded-lg">
                  <option value="Koorporasi" <?= ($lawyer['profession'] ?? '') == 'Koorporasi' ? 'selected' : '' ?>>Koorporasi</option>
                  <option value="Advokat" <?= ($lawyer['profession'] ?? '') == 'Advokat' ? 'selected' : '' ?>>Advokat</option>
                  <option value="Litigasi" <?= ($lawyer['profession'] ?? '') == 'Litigasi' ? 'selected' : '' ?>>Litigasi</option>
                </select>
              </div>

              <!-- Phone -->
              <div>
                <label for="phone" class="block text-sm font-semibold mb-2">Phone Number</label>
                <input type="text" id="phone" name="phone" 
                    value="<?= htmlspecialchars($lawyer['phone'] ?? '') ?>" 
                    class="w-full px-4 py-2 border rounded-lg">
              </div>

              <!-- Submit Button -->
              <div>
                <button type="submit" name="update_profile" 
                    class="w-full py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold">
                  Update Profile
                </button>
              </div>
            </div>

            <!-- Right: Profile Photo -->
            <div class="text-center">
              <h2 class="text-xl font-bold mb-4">Profile Photo</h2>
              
              <!-- Profile Image dengan Preview -->
              <div class="relative inline-block mb-4">
                <img id="profilePreview" src="<?= htmlspecialchars($profile_picture) ?>" 
                    alt="Profile" class="w-40 h-40 mx-auto rounded-md object-cover border-2 border-gray-300">
                
                <!-- Upload Overlay -->
                <label for="profile_picture" class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center rounded-md opacity-0 hover:opacity-100 transition-opacity cursor-pointer">
                  <span class="text-white text-sm font-semibold">
                    <i class="fas fa-camera mr-1"></i> Change Photo
                  </span>
                </label>
                
                <input type="file" id="profile_picture" name="profile_picture" 
                    accept="image/*" class="hidden" onchange="previewImage(this)">
              </div>

              <!-- Upload Button -->
              <button type="submit" name="upload_photo" 
                  class="w-full py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 mb-3">
                Upload Photo
              </button>

              <p class="bg-gray-200 px-4 py-2 rounded-lg mb-3">
                <?= htmlspecialchars($lawyer['full_name'] ?? '') ?> 
              </p>
              
              <div class="flex justify-center space-x-2 mb-4">
                <span class="px-4 py-2 bg-gray-200 rounded-lg">
                  <?= htmlspecialchars($lawyer['profession'] ?? 'Not Set') ?>
                </span>
                <span class="px-4 py-2 bg-gray-800 text-white rounded-lg">Active</span>
              </div>

              <!-- Change Password Button -->
              <button type="button" onclick="openChangePasswordModal()"
                  class="w-full py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                Change Password
              </button>
            </div>
          </div>
        </form>
      </div>

      <!-- Modal Change Password -->
      <div id="changePasswordModal" 
          class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-lg w-96 p-6 relative">
          <h2 class="text-xl font-bold mb-2">Change Password</h2>
          <p class="text-sm text-gray-500 mb-6">New password can't be same as the old password</p>

          <form method="POST" id="changePasswordForm">
            <!-- Old Password -->
            <div class="mb-4">
              <label for="oldPassword" class="block text-sm font-semibold mb-2">Old Password</label>
              <div class="relative">
                <input type="password" id="oldPassword" name="old_password"
                    class="w-full px-4 py-2 border rounded-lg pr-10" required />
                <button type="button" data-target="oldPassword"
                        class="absolute right-2 top-2.5 text-gray-500">
                  <i class="fa-regular fa-eye"></i>
                </button>
              </div>
            </div>

            <!-- New Password -->
            <div class="mb-4">
              <label for="newPassword" class="block text-sm font-semibold mb-2">New Password</label>
              <div class="relative">
                <input type="password" id="newPassword" name="new_password"
                    class="w-full px-4 py-2 border rounded-lg pr-10" required 
                    minlength="6" />
                <button type="button" data-target="newPassword"
                        class="absolute right-2 top-2.5 text-gray-500">
                  <i class="fa-regular fa-eye"></i>
                </button>
              </div>
            </div>

            <div class="mb-4">
              <label for="confirmPassword" class="block text-sm font-semibold mb-2">Confirm Password</label>
              <div class="relative">
                <input type="password" id="confirmPassword" name="confirm_password"
                    class="w-full px-4 py-2 border rounded-lg pr-10" required 
                    minlength="6" />
                <button type="button" data-target="confirmPassword"
                        class="absolute right-2 top-2.5 text-gray-500">
                  <i class="fa-regular fa-eye"></i>
                </button>
              </div>
            </div>

            <!-- Checkbox -->
            <div class="flex items-center mb-4">
              <input type="checkbox" id="acceptTerms" name="accept_terms" class="mr-2" required>
              <label for="acceptTerms" class="text-sm">I accept the terms 
                <a href="#" class="text-blue-500 underline">Read our T&Cs</a>
              </label>
            </div>

            <!-- Action Buttons -->
            <button type="submit" name="change_password"
                    class="w-full py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900">
              Change Password
            </button>
          </form>

          <!-- Close Button -->
          <button onclick="closeModal()" 
                  class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
            <i class="fa-solid fa-xmark"></i>
          </button>
        </div>
      </div>
    </main>
  </div>

  <script>
    // Image Preview Function
    function previewImage(input) {
      const preview = document.getElementById('profilePreview');
      const file = input.files[0];
      
      if (file) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
          preview.src = e.target.result;
        }
        
        reader.readAsDataURL(file);
      }
    }

    // Password Toggle Functionality
    document.addEventListener('DOMContentLoaded', () => {
      // Event delegation untuk semua tombol show/hide password
      document.body.addEventListener('click', (e) => {
        const btn = e.target.closest('button[data-target]');
        if (!btn) return;

        const targetId = btn.getAttribute('data-target');
        const input = document.getElementById(targetId);
        if (!input) return;

        // Toggle tipe input
        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';

        // Ganti ikon
        const icon = btn.querySelector('i');
        if (icon) {
          icon.classList.remove(isPassword ? 'fa-eye' : 'fa-eye-slash');
          icon.classList.add(isPassword ? 'fa-eye-slash' : 'fa-eye');
        }

        // Update aksesibilitas
        btn.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
        btn.setAttribute('title', isPassword ? 'Hide password' : 'Show password');
      });

      // Real-time password validation
      const newPassword = document.getElementById('newPassword');
      const confirmPassword = document.getElementById('confirmPassword');
      
      function validatePasswords() {
        if (newPassword.value && confirmPassword.value) {
          if (newPassword.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Passwords do not match');
          } else {
            confirmPassword.setCustomValidity('');
          }
        }
      }
      
      if (newPassword && confirmPassword) {
        newPassword.addEventListener('input', validatePasswords);
        confirmPassword.addEventListener('input', validatePasswords);
      }
    });

    // Modal Functions
    function openChangePasswordModal() {
      document.getElementById('changePasswordModal').classList.remove('hidden');
      document.getElementById('changePasswordModal').classList.add('flex');
      // Reset form ketika modal dibuka
      document.getElementById('changePasswordForm').reset();
    }

    function closeModal() {
      document.getElementById('changePasswordModal').classList.add('hidden');
      document.getElementById('changePasswordModal').classList.remove('flex');
    }

    // Close modal ketika klik di luar
    document.addEventListener('click', (e) => {
      const modal = document.getElementById('changePasswordModal');
      if (modal && e.target === modal) {
        closeModal();
      }
    });
  </script>
</body>
</html>