<?php include '../includes/config.php'; ?>
<!DOCTYPE html>
<html lang-="en">
<head>
  <?php include '../inc/head.php'; ?>
</head>
<body class="bg-gradient-to-br from-blue-900 via-blue-800 to-blue-600 min-h-screen text-black">

  <div class="flex items-center justify-center px-4 py-10">
    <main class="w-full max-w-5xl p-6 sm:p-10 bg-white/90 rounded-2xl shadow-2xl space-y-8">
      
      <header class="text-center">
        <h1 class="text-3xl font-bold text-blue-800">🚐 Transport Services</h1>
        <p class="text-gray-600 mt-2">Choose from our range of vehicles for a safe and stylish journey.</p>
      </header>

      <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        
        <?php
          // Fetch all vehicles from the database
          $result = $conn->query("SELECT * FROM vehicles ORDER BY name ASC");
          
          if ($result->num_rows > 0) {
            // Loop through each vehicle and display it
            // Loop through each vehicle and display it
while($row = $result->fetch_assoc()) {
    echo "
    <div class='bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 flex flex-col'>
      <img src='../images/{$row['image']}' class='w-full h-48 object-cover' alt='" . htmlspecialchars($row['name']) . "'>
      <div class='p-4 flex flex-col flex-grow'>
        <h3 class='font-semibold text-lg text-blue-700'>" . htmlspecialchars($row['name']) . "</h3>
        <p class='text-sm text-gray-500 mt-1'>Type: " . htmlspecialchars($row['type']) . "</p>
        <p class='text-gray-700 mt-2 font-bold'>From $" . htmlspecialchars($row['price']) . "/day</p>
        <p class='text-sm text-gray-600 mt-2 flex-grow'>" . htmlspecialchars($row['description']) . "</p>
        <a href='../booking.php?type=vehicle&id={$row['id']}' class='mt-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg text-center transition'>
          Book Now
        </a>
      </div>
    </div>";
}
          } else {
            // Show a message if no vehicles are found
            echo "<p class='col-span-full text-center text-gray-500'>No vehicles have been added yet.</p>";
          }
        ?>

      </section>

      <div class="text-center">
        <a href="../service.php" class="text-blue-700 hover:underline">← Back to All Services</a>
      </div>

    </main>
  </div>

  <?php include '../footer.php'; ?>
</body>
</html>