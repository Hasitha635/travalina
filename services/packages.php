<?php include '../includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include '../inc/head.php'; ?>
</head>
<body class="bg-gradient-to-br from-blue-900 via-blue-800 to-blue-600 min-h-screen text-black">

  <div class="flex items-center justify-center px-4 py-10">
    <main class="w-full max-w-5xl p-6 sm:p-10 bg-white/90 rounded-2xl shadow-2xl space-y-8">
      
      <header class="text-center">
        <h1 class="text-3xl font-bold text-blue-800">🎁 Travel Packages</h1>
        <p class="text-gray-600 mt-2">Exclusive holiday packages tailored for you.</p>
      </header>

      <section class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
          <img src="../images/adventure.webp" class="w-full h-48 object-cover">
          <div class="p-4">
            <h3 class="font-semibold text-lg text-blue-700">Adventure Package</h3>
            <p class="text-gray-600">Hiking, rafting, safaris and adrenaline experiences.</p>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
          <img src="../images/relax.webp" class="w-full h-48 object-cover">
          <div class="p-4">
            <h3 class="font-semibold text-lg text-blue-700">Relaxation Package</h3>
            <p class="text-gray-600">Spa retreats, beach resorts and slow travel vibes.</p>
          </div>
        </div>
      </section>

      <div class="text-center">
        <a href="../service.php" class="text-blue-700 hover:underline">← Back to Services</a>
      </div>

    </main>
  </div>

  <?php include '../footer.php'; ?>
</body>
</html>
