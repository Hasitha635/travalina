<?php include '../includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include '../inc/head.php'; ?>
  <style>
    /* Style for star ratings */
    .stars { color: #FFC107; }
  </style>
</head>
<body class="text-gray-200">

  <div class="container mx-auto px-4 py-10">
    <main class="w-full max-w-6xl mx-auto p-6 sm:p-10 rounded-2xl shadow-2xl glass-container">
      
      <?php include '../inc/header.php'; ?>

      <section class="mt-10">
        <header class="text-center">
          <h1 class="text-4xl font-bold text-white">🏨 Luxury Hotels</h1>
          <p class="text-gray-300 mt-2">Discover our handpicked collection of luxury hotels with the best prices.</p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-10">
        <?php
          $hotels_result = $conn->query("SELECT * FROM hotels ORDER BY name ASC");
          
          if ($hotels_result->num_rows > 0) {
            while($hotel = $hotels_result->fetch_assoc()) {
                // --- Start of Review Calculation ---
                $item_id = $hotel['id'];
                $item_type = 'hotel';
                $avg_rating = 0;
                $review_count = 0;

                $review_stmt = $conn->prepare("SELECT rating FROM reviews WHERE item_id = ? AND item_type = ?");
                $review_stmt->bind_param("is", $item_id, $item_type);
                $review_stmt->execute();
                $review_result = $review_stmt->get_result();
                
                if ($review_result->num_rows > 0) {
                    $total_rating = 0;
                    while($review_row = $review_result->fetch_assoc()) {
                        $total_rating += $review_row['rating'];
                    }
                    $review_count = $review_result->num_rows;
                    $avg_rating = round($total_rating / $review_count, 1);
                }
                $review_stmt->close();
                // --- End of Review Calculation ---
        ?>
                <div class='bg-white/5 backdrop-blur-md border border-white/10 rounded-xl shadow-lg flex flex-col'>
                  <img src='../images/<?= htmlspecialchars($hotel['image'] ?? '') ?>' class='w-full h-56 object-cover rounded-t-xl' alt='<?= htmlspecialchars($hotel['name'] ?? '') ?>'>
                  <div class='p-4 flex flex-col flex-grow'>
                    <h3 class='font-semibold text-lg text-blue-300'><?= htmlspecialchars($hotel['name'] ?? '') ?></h3>
                    <p class='text-sm text-gray-400 mt-1'><?= htmlspecialchars($hotel['location'] ?? '') ?></p>
                    
                    <div class='my-2'>
                        <span class="stars">
                            <?php
                            for ($i = 1; $i <= 5; $i++) {
                                echo $i <= $avg_rating ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                            }
                            ?>
                        </span>
                        <a href="../reviews.php?type=hotel&id=<?= $hotel['id'] ?>" class='text-xs text-blue-300 hover:underline ml-2'>(<?= $review_count ?> reviews)</a>
                    </div>
                    
                    <p class='text-gray-300 mt-2 font-bold text-xl'>From $<?= htmlspecialchars($hotel['price'] ?? '0.00') ?>/night</p>
                    <div class='mt-auto pt-4'>
                      <a href='../booking.php?type=hotel&id=<?= $hotel['id'] ?>' class='block w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg text-center transition'>
                        Book Now
                      </a>
                    </div>
                  </div>
                </div>
        <?php
            } // End of while loop
          } else {
            echo "<p class='col-span-full text-center text-gray-400'>No hotels have been added yet.</p>";
          }
        ?>
        </div>
      </section>
    </main>
  </div>

  <?php include '../footer.php'; ?>
</body>
</html>