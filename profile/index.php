<?php
session_start();

include("../connect.php");

// Check user session here
$isSignedIn = isset($_SESSION['user']);
if (!$isSignedIn) {
    header("Location: /auth/login.php");
    exit();
}

$sql = "SELECT * FROM PUBLISHER WHERE Username = '$_SESSION[user]'";
$result = mysqli_query($conn, $sql);
$userDetails = mysqli_fetch_assoc($result);

// Simulated events (replace with actual events retrieval logic)
$sql = "SELECT * FROM PROGRAM_DETAILS WHERE PublisherID = $userDetails[ID]";
$result = mysqli_query($conn, $sql);
$events = mysqli_fetch_all($result, MYSQLI_ASSOC);

if ($_POST) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phonenumber = $_POST['phone'];

    $sql = "UPDATE PUBLISHER SET Name = '$name', Email = '$email', Phonenumber = '$phonenumber' WHERE ID = '$userDetails[ID]'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "<script>alert('Profile updated successfully!')</script>";
    } else {
        echo "<script>alert('Error updating profile!')</script>";
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- ... (Head section) ... -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Additional CSS styles (if needed) */
    </style>
</head>

<body class="bg-gray-100">
    <?php
    include("../partials/nav.php");
    ?>

    <div class="container mx-auto py-8">
        <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md mb-8">
            <?php if ($isSignedIn): ?>
                <h2 class="text-2xl font-semibold mb-4">User Profile</h2>
                <form method="POST">
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-medium">Name</label>
                        <input type="text" id="name" name="name" value="<?php echo $userDetails['Name']; ?>"
                            class="mt-1 px-3 py-2 w-full border rounded-md">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 font-medium">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo $userDetails['Email']; ?>"
                            class="mt-1 px-3 py-2 w-full border rounded-md">
                    </div>
                    <div class="mb-4">
                        <label for="phone" class="block text-gray-700 font-medium">Phone</label>
                        <input type="text" id="phone" name="phone" value="<?php echo $userDetails['Phonenumber']; ?>"
                            class="mt-1 px-3 py-2 w-full border rounded-md">
                    </div>
                    <button type="submit" name="updateProfile"
                        class="text-yellow-500 border border-yellow-500 hover:bg-yellow-500 hover:text-white active:bg-yellow-600 font-bold uppercase px-8 py-3 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">
                        Update Profile
                    </button>
                </form>
            <?php endif; ?>
        </div>

        <?php if ($isSignedIn): ?>
            <h2 class="text-2xl font-semibold mb-4">Your Events</h2>
            <?php foreach ($events as $event): ?>
                <div class="bg-white p-4 rounded-lg shadow-md mb-4">
                    <h3 class="text-lg font-semibold mb-2">
                        <?php echo $event['Event_Name']; ?>
                    </h3>
                    <p class="text-gray-600 mb-2">
                        <?php echo $event['Date']; ?>
                        <?php echo $event['Time']; ?>
                    </p>
                    <p class="text-gray-800">
                        <?php echo $event['Description']; ?>
                    </p>
                    <a href="/profile/events.php?event_id=<?php echo $event['P_ID']?>" class="text-blue-500 hover:underline self-end">More Actions</a>

                </div>
            <?php endforeach; ?>
            <a class="text-yellow-500 border border-yellow-500 hover:bg-yellow-500 hover:text-white active:bg-yellow-600 font-bold uppercase px-8 py-3 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" href="./add.html">
                Add New Event
            </a>
        <?php endif; ?>
    </div>

</body>

</html>