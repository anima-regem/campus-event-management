<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <title>Publisher</title>
</head>

<body class="bg-gray-100">
    <?php include("../partials/nav.php"); ?>

    <div class="container mx-auto py-8">
        <?php
        include("../connect.php");


        if (isset($_GET['id'])) {
            $publisher_id = $_GET['id'];
            $sql_publisher = "SELECT * FROM PUBLISHER WHERE ID = $publisher_id";
            $result_publisher = mysqli_query($conn, $sql_publisher);

            if ($result_publisher && mysqli_num_rows($result_publisher) > 0) {
                $row_publisher = mysqli_fetch_assoc($result_publisher);

                echo '<div class="bg-white p-6 rounded-lg shadow-md">';
                echo '<img src="' . $row_publisher['Picture'] . '" alt="Publisher Image" class="mb-4 rounded-lg">';
                echo '<h2 class="text-2xl font-semibold mb-4">' . $row_publisher['Name'] . '</h2>';
                echo '<p class="text-gray-600 mb-2">Email: ' . $row_publisher['Email'] . '</p>';
                echo '<p class="text-gray-600 mb-2">Phone: ' . $row_publisher['Phonenumber'] . '</p>';
                echo '</div>';

                // List events by the same publisher
                $sql_events = "SELECT * FROM PROGRAM_DETAILS WHERE PublisherID = $publisher_id";
                $result_events = mysqli_query($conn, $sql_events);

                if ($result_events && mysqli_num_rows($result_events) > 0) {
                    echo '<h3 class="text-xl font-semibold my-4">Events by ' . $row_publisher['Name'] . '</h3>';
                    echo '<div class="container mx-auto py-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    ';
                    while ($row_event = mysqli_fetch_assoc($result_events)) {
                        echo '<div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-transform transform hover:scale-105 overflow-hidden">';
                        echo '<h2 class="text-lg font-semibold mb-2">' . $row_event["Event_Name"] . '</h2>';
                        echo '<p class="text-gray-600 mb-2">' . $row_event["Organising_Body"] . '</p>';
                        echo '<p class="text-gray-400 mb-4">' . $row_event["Date"] . '</p>';
                        echo '<p class="text-gray-800 mb-4">' . $row_event["Description"] . '</p>';
                        echo '<a href="./event-details.php?id=' . $row_event["P_ID"] . '" class="text-blue-500 hover:underline self-end">Read More</a>';
                        echo '</div>';
                    }
                } else {
                    echo '<p class="text-gray-600">No events by this publisher.</p>';
                }

                // Free the result sets
                mysqli_free_result($result_publisher);
                mysqli_free_result($result_events);
            } else {
                echo '<p class="text-red-600">Publisher not found.</p>';
            }
        } else {
            echo '<p class="text-red-600">Publisher ID not provided.</p>';
        }

        // Close the database connection
        mysqli_close($conn);

        ?>
    </div>
</body>

</html>