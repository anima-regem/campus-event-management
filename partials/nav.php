<nav class="bg-yellow-400 hover:bg-yellow-300 shadow-lg py-4 px-8 flex items-center justify-between ">
    <a href="/dashboard/">
        <div class="flex items-center">
            <img src="/public/logo.png" alt="Logo" class="h-8 mr-4">
            <h1 class="text-black text-lg font-semibold">GEC Events</h1>
        </div>
    </a>
    <ul class="flex items-center space-x-4">
        <?php
        session_start();
        // Check user session here
        $user = $_SESSION['user'];


        if ($user) {
            echo '<li><a href="/profile/" class="text-black hover:underline">Profile</a></li>';
            echo '<li><a href="/auth/logout.php" class="text-black hover:underline">Sign Out</a></li>';
        } else {
            echo '<li><a href="/auth/signup.php" class="text-black hover:underline">Sign Up</a></li>';
            echo '<li><a href="/auth/login.php" class="text-black hover:underline">Login</a></li>';
        }
        ?>
    </ul>
</nav>