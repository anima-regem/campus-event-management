<?php
session_start();

include("../connect.php");

// Check user session here
$isSignedIn = isset($_SESSION['user']);
if (!$isSignedIn) {
    header("Location: /auth/login.php");
    exit();
}

if ($_GET['event_id']) {
    $event_id = $_GET['event_id'];
    $sql = "SELECT * FROM PROGRAM_DETAILS WHERE P_ID = $event_id";
    $result = mysqli_query($conn, $sql);
    $eventDetails = mysqli_fetch_assoc($result);

    $sql = "SELECT * FROM PUBLISHER WHERE Username = '$_SESSION[user]'";
    $result = mysqli_query($conn, $sql);
    $userDetails = mysqli_fetch_assoc($result);
    if ($eventDetails['PublisherID'] != $userDetails['ID']) {
        header("Location: /dashboard/"); // Redirect if event doesn't belong to the current user
        exit();
    }

} else {
    header("Location: /dashboard/");
    exit();
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
        <?php if ($isSignedIn): ?>
            <h2 class="text-2xl font-semibold mb-4">Edit Event</h2>
            <form method="POST" enctype="multipart/form-data" action="edit.php">
                <input name="event_id" value="<?php echo $event_id?>" hidden>
                <div class="mb-4">
                    <label for="eventName" class="block text-gray-700 font-medium">Event Name</label>
                    <input type="text" id="eventName" name="eventName" value="<?php echo $eventDetails['Event_Name']; ?>"
                        class="mt-1 px-3 py-2 w-full border rounded-md">
                </div>
                <div class="mb-4">
                    <label for="organisingBody" class="block text-gray-700 font-medium">Organising Body</label>
                    <input type="text" id="organisingBody" name="organisingBody"
                        value="<?php echo $eventDetails['Organising_Body']; ?>"
                        class="mt-1 px-3 py-2 w-full border rounded-md">
                </div>
                <div class="mb-4">
                    <label for="eventDate" class="block text-gray-700 font-medium">Event Date</label>
                    <input type="date" id="eventDate" name="eventDate" value="<?php echo $eventDetails['Date']; ?>"
                        class="mt-1 px-3 py-2 w-full border rounded-md">
                </div>
                <div class="mb-4">
                    <label for="eventTime" class="block text-gray-700 font-medium">Event Time</label>
                    <input type="time" id="eventTime" name="eventTime" value="<?php echo $eventDetails['Time']; ?>"
                        class="mt-1 px-3 py-2 w-full border rounded-md">
                </div>
                <div class="mb-4">
                    <label for="eventType" class="block text-gray-700 font-medium">Event Type</label>
                    <input type="text" id="eventType" name="eventType" value="<?php echo $eventDetails['Type']; ?>"
                        class="mt-1 px-3 py-2 w-full border rounded-md">
                </div>
                <div class="mb-4">
                    <label for="eventMode" class="block text-gray-700 font-medium">Event Mode</label>
                    <input type="text" id="eventMode" name="eventMode" value="<?php echo $eventDetails['Mode']; ?>"
                        class="mt-1 px-3 py-2 w-full border rounded-md">
                </div>
                <div class="mb-4">
                    <label for="eventDescription" class="block text-gray-700 font-medium">Event Description</label>
                    <textarea id="eventDescription" name="eventDescription"
                        class="mt-1 px-3 py-2 w-full border rounded-md"><?php echo $eventDetails['Description']; ?></textarea>
                </div>
                <div class="mb-4">
                    <label for="eventPlace" class="block text-gray-700 font-medium">Event Place</label>
                    <input type="text" id="eventPlace" name="eventPlace" value="<?php echo $eventDetails['Place']; ?>"
                        class="mt-1 px-3 py-2 w-full border rounded-md">
                </div>
                <div class="mb-4">
                    <label for="coordinatorPh" class="block text-gray-700 font-medium">Coordinator Phone</label>
                    <input type="text" id="coordinatorPh" name="coordinatorPh"
                        value="<?php echo $eventDetails['Coordinator_Ph']; ?>"
                        class="mt-1 px-3 py-2 w-full border rounded-md">
                </div>
                <div class="mb-4">
                    <label for="registrationLink" class="block text-gray-700 font-medium">Registration Link</label>
                    <input type="text" id="registrationLink" name="registrationLink"
                        value="<?php echo $eventDetails['Registration_Link']; ?>"
                        class="mt-1 px-3 py-2 w-full border rounded-md">
                </div>
                <div class="mb-4">
                    <label for="publishedDate" class="block text-gray-700 font-medium">Published Date</label>
                    <input type="date" id="publishedDate" name="publishedDate"
                        value="<?php echo $eventDetails['Published_Date']; ?>"
                        class="mt-1 px-3 py-2 w-full border rounded-md">
                </div>
                <div class="mb-4">
                    <label for="coordinatorName" class="block text-gray-700 font-medium">Coordinator Name</label>
                    <input type="text" id="coordinatorName" name="coordinatorName"
                        value="<?php echo $eventDetails['Coordinator_Name']; ?>"
                        class="mt-1 px-3 py-2 w-full border rounded-md">
                </div>
                <div class="mb-4">
                    <label for="eventImages" class="block text-gray-700 font-medium">Event Images</label>
                    <input type="file" id="eventImages" name="eventImages[]" multiple
                        class="mt-1 px-3 py-2 w-full border rounded-md">
                </div>
                <input type="submit" name="updateEvent"
                    class="text-yellow-500 border border-yellow-500 hover:bg-yellow-500 hover:text-white active:bg-yellow-600 font-bold uppercase px-8 py-3 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                    value="Update">

            </form>
            <form method="POST" action="delete.php">
                <input type="hidden" name="eventId" value="<?php echo $eventDetails['P_ID']; ?>">
                <input type="submit" name="deleteEvent"
                    class="text-red-500 border border-red-500 hover:bg-red-500 hover:text-white active:bg-red-600 font-bold uppercase px-8 py-3 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                    value="Delete">
            </form>
        <?php endif; ?>
    </div>
</body>

</html>