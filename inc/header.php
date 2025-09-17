<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header class="flex flex-col sm:flex-row items-center justify-between">
  <h1 class="text-3xl sm:text-4xl font-bold text-white">
    <a href="index.php">TRAVElina</a>
  </h1>
 <nav class="flex flex-wrap gap-x-6 gap-y-2 mt-4 sm:mt-0 text-sm font-medium items-center">
    <a href="/travelina/index.php" class="hover:text-blue-300 transition">HOME</a>
    <a href="/travelina/about.php" class="hover:text-blue-300 transition">ABOUT</a>
    <a href="/travelina/blog.php" class="hover:text-blue-300 transition">BLOG</a>
    <a href="/travelina/service.php" class="hover:text-blue-300 transition">SERVICES</a>
    <a href="/travelina/contact.php" class="hover:text-blue-300 transition">CONTACT</a>
    
    <?php if (isset($_SESSION['user_id'])): ?>
      <span class="text-blue-300">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</span>
      <a href="/travelina/my_bookings.php" class="hover:text-blue-300 transition">MY BOOKINGS</a>
      <a href="/travelina/logout.php" class="bg-red-500/50 hover:bg-red-500/80 text-white px-3 py-1 rounded-md transition">LOGOUT</a>
    <?php else: ?>
      <a href="/travelina/login.php" class="bg-blue-500/50 hover:bg-blue-500/80 text-white px-3 py-1 rounded-md transition">LOG IN</a>
    <?php endif; ?>
    
</nav>
    

    

</header>