<?php include 'includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include 'inc/head.php'; ?>
</head>
<body class="text-gray-200">

  <div class="container mx-auto px-4 py-10">
    <main class="w-full max-w-5xl mx-auto p-6 sm:p-10 rounded-2xl shadow-2xl glass-container">
    
      <?php include 'inc/header.php'; ?>

      <section class="mt-10">
        <header class="text-center">
            <h1 class="text-4xl font-bold text-white">Our Services</h1>
            <p class="text-gray-300 mt-2">Discover the exclusive services TRAVElina offers for your next adventure.</p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-10">
          
          <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-xl shadow-lg hover:bg-white/20 transition flex flex-col">
            <img src="images/hotel.webp" class="w-full h-48 object-cover rounded-t-xl" alt="Luxury Hotels">
            <div class="p-6 flex flex-col flex-grow">
              <h3 class="font-semibold text-xl text-blue-300">Luxury Hotels</h3>
              <p class="text-sm text-gray-300 mt-2 flex-grow">Handpicked luxury hotels from beachfront resorts to 5-star city stays.</p>
              <a href="services/hotels.php" class="mt-4 font-semibold text-blue-300 hover:text-white">
                Explore Hotels &rarr;
              </a>
            </div>
          </div>

          <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-xl shadow-lg hover:bg-white/20 transition flex flex-col">
            <img src="images/vehical.webp" class="w-full h-48 object-cover rounded-t-xl" alt="Transport Services">
            <div class="p-6 flex flex-col flex-grow">
              <h3 class="font-semibold text-xl text-blue-300">Transport Services</h3>
              <p class="text-sm text-gray-300 mt-2 flex-grow">Choose from cars, vans, and luxury buses with professional drivers.</p>
              <a href="services/vehicles.php" class="mt-4 font-semibold text-blue-300 hover:text-white">
                View Vehicles &rarr;
              </a>
            </div>
          </div>
          
          <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-xl shadow-lg hover:bg-white/20 transition flex flex-col">
            <img src="images/packages.webp" class="w-full h-48 object-cover rounded-t-xl" alt="Exclusive Deals">
            <div class="p-6 flex flex-col flex-grow">
              <h3 class="font-semibold text-xl text-blue-300">Exclusive Deals</h3>
              <p class="text-sm text-gray-300 mt-2 flex-grow">Curated packages combining culture, adventure, and relaxation.</p>
              <a href="services/deals.php" class="mt-4 font-semibold text-blue-300 hover:text-white">
                See Deals &rarr;
              </a>
            </div>
          </div>

        </div>
      </section>
      
    </main>
  </div>

  <?php include 'footer.php'; ?>
</body>
</html>