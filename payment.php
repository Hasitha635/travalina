<?php
include 'includes/config.php';
session_start();

// Use Composer's autoloader
require 'vendor/autoload.php';

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

// Fetch booking details from the database
$stmt = $conn->prepare("SELECT * FROM bookings WHERE id = ? AND payment_status = 'unpaid'");
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

if (!$booking) {
    die("Error: Invalid booking or booking has already been paid.");
}

// --- Stripe Integration ---
// Replace with your SECRET Stripe API key
$stripeSecretKey = 'sk_test_YOUR_SECRET_KEY';
\Stripe\Stripe::setApiKey($stripeSecretKey);

try {
    // Create a PaymentIntent with the order amount and currency
    $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => $booking['total_price'] * 100, // Amount in cents
        'currency' => 'usd',
        'description' => 'Booking #' . $booking['id'] . ' for ' . $booking['customer_name'],
        'metadata' => ['booking_id' => $booking['id']]
    ]);

    $output = [
        'clientSecret' => $paymentIntent->client_secret,
    ];

    $clientSecret = $output['clientSecret'];

} catch (Error $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'inc/head.php'; ?>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body class="text-gray-200">
<div class="container mx-auto px-4 py-10">
    <main class="w-full max-w-lg mx-auto p-6 sm:p-10 rounded-2xl shadow-2xl glass-container">
        <?php include 'inc/header.php'; ?>
        <section class="mt-10">
            <header class="text-center">
                <h1 class="text-3xl font-bold text-white">Complete Your Payment</h1>
                <p class="text-gray-300 mt-2">Booking ID: #<?php echo htmlspecialchars($booking['id']); ?></p>
                <p class="text-2xl font-bold text-white mt-4">Total: $<?php echo htmlspecialchars($booking['total_price']); ?></p>
            </header>

            <form id="payment-form" class="mt-8">
                <div id="payment-element" class="bg-white/10 p-3 rounded-lg"></div>

                <button id="submit" class="w-full mt-6 bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg shadow-lg font-semibold transition">
                    <div class="spinner hidden" id="spinner"></div>
                    <span id="button-text">Pay Now</span>
                </button>
                <div id="payment-message" class="hidden text-center text-red-400 mt-2"></div>
            </form>
        </section>
    </main>
</div>

<script>
    // Replace with your PUBLISHABLE Stripe API key
    const stripe = Stripe('pk_test_YOUR_PUBLISHABLE_KEY');
    
    const options = {
        clientSecret: '<?php echo $clientSecret; ?>',
        appearance: {
            theme: 'night',
            labels: 'floating'
        },
    };

    const elements = stripe.elements(options);
    const paymentElement = elements.create('payment');
    paymentElement.mount('#payment-element');

    const form = document.getElementById('payment-form');
    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        setLoading(true);

        const { error } = await stripe.confirmPayment({
            elements,
            confirmParams: {
                return_url: `http://localhost/travelina/payment_success.php?booking_id=<?php echo $booking_id; ?>`,
            },
        });

        if (error) {
            const messageContainer = document.querySelector('#payment-message');
            messageContainer.classList.remove('hidden');
            messageContainer.textContent = error.message;
        }
        setLoading(false);
    });

    function setLoading(isLoading) {
        if (isLoading) {
            document.querySelector("#submit").disabled = true;
            document.querySelector("#spinner").classList.remove("hidden");
            document.querySelector("#button-text").classList.add("hidden");
        } else {
            document.querySelector("#submit").disabled = false;
            document.querySelector("#spinner").classList.add("hidden");
            document.querySelector("#button-text").classList.remove("hidden");
        }
    }
</script>
</body>
</html>