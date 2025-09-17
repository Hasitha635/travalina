<?php
include 'includes/config.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if booking_id is provided
if (!isset($_GET['booking_id'])) {
    die("Error: No booking ID provided.");
}

$booking_id = $_GET['booking_id'];

// Fetch booking details
$stmt = $conn->prepare("SELECT * FROM bookings WHERE id = ?");
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

if (!$booking) {
    die("Error: Invalid booking.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'inc/head.php'; ?>
</head>
<body class="text-gray-200">
<div class="container mx-auto px-4 py-10">
    <main class="w-full max-w-lg mx-auto p-6 sm:p-10 rounded-2xl shadow-2xl glass-container">
        <?php include 'inc/header.php'; ?>
        <section class="mt-10 text-center">
            <h1 class="text-3xl font-bold text-white">Simulated Payment</h1>
            <p class="text-gray-300 mt-2">Booking ID: #<?php echo htmlspecialchars($booking['id']); ?></p>
            <p class="text-2xl font-bold text-white mt-4">Total Amount: LKR <?php echo number_format($booking['total_price'], 2); ?></p>
            <p class="text-xs text-yellow-400 mt-4">(This is a simulation for a university project. No real payment will be processed.)</p>

            <form method="post" action="mock_payment_process.php">   
                <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">
                <button type="submit" class="w-full mt-6 btn btn-primary">Confirm and Pay</button>
            </form>
        </section>
    </main>
</div>
</body>
</html>