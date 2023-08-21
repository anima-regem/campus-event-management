<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <title>Event Details</title>
</head>

<body class="bg-gray-100">
    <?php include("../partials/nav.php"); ?>
    <div class="container mx-auto py-8">
        <?php
        include("../connect.php");
        // Your database conn code here
// Query to retrieve data from the EventWithPublisher view
        $sql = "SELECT * FROM EventWithPublisher WHERE P_ID = " . $_GET['id'] . "";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $event_id = $row['P_ID'];
                $event_name = $row['Event_Name'];
                $organising_body = $row['Organising_Body'];
                $description = $row['Description'];
                $date = $row['Date'];
                $time = $row['Time'];
                $type = $row['Type'];
                $mode = $row['Mode'];
                $place = $row['Place'];
                $coordinator_ph = $row['Coordinator_Ph'];
                $registration_link = $row['Registration_Link'];
                $published_date = $row['Published_Date'];
                $coordinator_name = $row['Coordinator_Name'];
                $publisher_name = $row['Publisher_Name'];
                $publisher_email = $row['Publisher_Email'];
                $publisher_phonenumber = $row['Publisher_Phonenumber'];

                // Display the data in a card format
                echo '<div class="bg-white p-6 rounded-lg shadow-md">';
                echo '<h2 class="text-2xl font-semibold mb-2">' . $event_name . '</h2>';
                echo '<p class="text-gray-600 mb-2">' . $organising_body . '</p>';
                echo '<p class="text-gray-400 mb-2">' . $date . ' ' . $time . '</p>';
                echo '<p class="text-gray-400 mb-2">Type: ' . $type . '</p>';
                echo '<p class="text-gray-400 mb-2">Mode: ' . $mode . '</p>';
                echo '<p class="text-gray-800 mb-4">' . $description . '</p>';
                echo '<p class="text-gray-400 mb-2">Place: ' . $place . '</p>';
                echo '<p class="text-gray-400 mb-2">Coordinator Phone: ' . $coordinator_ph . '</p>';
                echo '<p class="text-gray-400 mb-2">Registration Link: <a href="' . $registration_link . '" class="text-blue-500 hover:underline">' . $registration_link . '</a></p>';
                echo '<p class="text-gray-400 mb-2">Published Date: ' . $published_date . '</p>';
                echo '<p class="text-gray-400 mb-2">Coordinator Name: ' . $coordinator_name . '</p>';
                echo '<p class="text-gray-600 mb-2">Published by: <a href="publisher-details.php?id=' . $event_id . '" class="text-blue-500 hover:underline">' . $publisher_name . '</a></p>';
                echo '<p class="text-gray-600 mb-2">Publisher Email: ' . $publisher_email . '</p>';
                echo '<p class="text-gray-600 mb-2">Publisher Phone: ' . $publisher_phonenumber . '</p>';
                echo '</div>';
            }

            $imageSql = "SELECT Image FROM GALLERY WHERE P_ID = " . $event_id;
            $imageResult = mysqli_query($conn, $imageSql);

            if ($imageResult) {
                echo '<div class="mt-4">';
                echo '<h3 class="text-xl font-semibold mb-2">Event Images</h3>';
                
                if (mysqli_num_rows($imageResult) == 0) {
                    echo '<p class="text-gray-600 mb-2">No images available</p>';
                }
                
                echo '<div class="flex flex-wrap">';
                
                while ($imageRow = mysqli_fetch_assoc($imageResult)) {
                    $image = $imageRow['Image'];
                    echo '<img src="/public/images/' . $image . '" alt="Event Image" class="mb-2 mr-2 w-24 h-24 object-cover">';
                }
                
                echo '</div>';
                echo '</div>';          


                echo '</div>';

                // Free the result set
                mysqli_free_result($imageResult);
            } else {
                // Handle the error
                echo "Error: " . mysqli_error($conn);
            }

            // Free the result set
            mysqli_free_result($result);
        } else {
            // Handle the error
            echo "Error: " . mysqli_error($connection);
        }

        // Close the connection
        mysqli_close($conn);


        ?>
    </div>
</body>

</html>