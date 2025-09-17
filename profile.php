<?php
session_start();
include 'includes/config.php';

// 1. Protect this page: if user is not logged in, redirect
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id']; // Get the user's ID

// --- START: Password Change Logic ---
$error_message = '';
$success_message = '';
if (isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch the user's current hashed password
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_data = $result->fetch_assoc();
    $stmt->close();

    // Verify the current password
    if (password_verify($current_password, $user_data['password'])) {
        if ($new_password === $confirm_password) {
            // Hash the new password
            $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update the password in the database
            $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $update_stmt->bind_param("si", $new_hashed_password, $user_id);
            if ($update_stmt->execute()) {
                $success_message = "Your password has been updated successfully!";
            } else {
                $error_message = "An error occurred. Please try again.";
            }
            $update_stmt->close();
        } else {
            $error_message = "The new passwords do not match.";
        }
    } else {
        $error_message = "Your current password is incorrect.";
    }
}
// --- END: Password Change Logic ---


// --- FINALLY: Fetch user's data to display on the page ---
// This block must run on every page load to get the name and email
$stmt = $conn->prepare("SELECT name, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <?php include 'inc/head.php'; ?>
</head>
<body class="text-gray-200">

  <div class="container mx-auto px-4 py-10">
    <main class="w-full max-w-2xl mx-auto p-6 sm:p-10 rounded-2xl shadow-2xl space-y-8 glass-container">

      <?php include 'inc/header.php'; ?>

      <section>
        <header class="text-center">
            <h1 class="text-4xl font-bold text-white">My Profile</h1>
            <p class="text-gray-300 mt-2">Manage your account details.</p>
        </header>

        <div class="mt-8 bg-white/5 p-6 rounded-lg">
            <h2 class="text-2xl font-semibold text-white mb-4">Your Information</h2>
            <div class="space-y-4">
                <div>
                    <label class="text-sm font-medium text-gray-400">Full Name</label>
                    <p class="text-lg text-white"><?php echo htmlspecialchars($user['name']); ?></p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-400">Email Address</label>
                    <p class="text-lg text-white"><?php echo htmlspecialchars($user['email']); ?></p>
                </div>
            </div>
        </div>

      </section>
      </section> <section class="mt-8">
        <div class="bg-white/5 p-6 rounded-lg">
            <h2 class="text-2xl font-semibold text-white mb-4">Change Your Password</h2>
            
            <form action="profile.php" method="post" class="space-y-6">
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-300">Current Password</label>
                    <input type="password" id="current_password" name="current_password" required
                           class="mt-1 block w-full bg-white/10 border border-white/20 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-blue-400 outline-none">
                </div>
                <div>
                    <label for="new_password" class="block text-sm font-medium text-gray-300">New Password</label>
                    <input type="password" id="new_password" name="new_password" required
                           class="mt-1 block w-full bg-white/10 border border-white/20 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-blue-400 outline-none">
                </div>
                <div>
                    <label for="confirm_password" class="block text-sm font-medium text-gray-300">Confirm New Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required
                           class="mt-1 block w-full bg-white/10 border border-white/20 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-blue-400 outline-none">
                </div>
                <button type="submit" name="change_password" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg shadow-lg font-semibold transition">
                    Update Password
                </button>
            </form>
        </div>
      </section>

    </main> 



    </main>
  </div>

  <?php include 'footer.php'; ?>
</body>
</html>