<?php include '../includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include '../inc/head.php'; ?>
</head>
<body class="text-gray-200">

  <div class="container mx-auto px-4 py-10">
    <main class="w-full max-w-6xl mx-auto p-6 sm:p-10 rounded-2xl shadow-2xl glass-container">
    
      <?php include '../inc/header.php'; ?>

      <section class="mt-10">
        <header class="text-center">
            <h1 class="text-4xl font-bold text-white">Exclusive Travel Packages</h1>
            <p class="text-gray-300 mt-2">All-inclusive packages designed for the perfect getaway.</p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-10">
        <?php
          $today = date('Y-m-d');
          $stmt = $conn->prepare("SELECT * FROM deals WHERE valid_until >= ? ORDER BY price ASC");
          $stmt->bind_param("s", $today);
          $stmt->execute();
          $result = $stmt->get_result();
          
          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "
                <div class='bg-white/5 backdrop-blur-md border border-white/10 rounded-xl shadow-lg flex flex-col'>
                  <img src='../images/" . htmlspecialchars($row['image'] ?? '') . "' class='w-full h-48 object-cover rounded-t-xl' alt='" . htmlspecialchars($row['title'] ?? '') . "'>
                  <div class='p-6 flex flex-col flex-grow'>
                    <h3 class='font-semibold text-xl text-blue-300'>" . htmlspecialchars($row['title'] ?? '') . "</h3>
                    <p class='text-xs text-gray-400 mt-1'>" . htmlspecialchars($row['duration'] ?? '') . "</p>
                    <p class='text-gray-300 my-4 text-sm'>" . htmlspecialchars($row['description'] ?? '') . "</p>
                    
                    <div class='mt-auto'>
                      <p class='font-bold text-2xl text-white'>$" . htmlspecialchars($row['price'] ?? '0.00') . "</p>
                      <p class='text-xs text-gray-400'>per person</p>
                      <a href='../booking.php?type=deal&id={$row['id']}' class='mt-4 block w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg text-center transition'>
                        Book This Deal
                      </a>
                    </div>
                  </div>
                </div>";
            }
          } else {
            echo "<p class='col-span-full text-center text-gray-400'>There are no active deals at the moment.</p>";
          }
          $stmt->close();
        ?>
        </div>
      </section>

    </main>
  </div>

  <?php include '../footer.php'; ?>
</body>
</html>