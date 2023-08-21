<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <title>Events Dashboard</title>
</head>

<body class="bg-gray-100">
    <?php include("../partials/nav.php"); ?>
    <div class="container mx-auto py-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

            <?php
            include("../connect.php");
            
            $sql = "SELECT * FROM EventSummary";
            $result = mysqli_query($conn, $sql);
            
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $event_id = $row['P_ID'];
                    $event_name = $row['Event_Name'];
                    $organising_body = $row['Organising_Body'];
                    $description = $row['Description'];
                    $date = $row['Date'];
                    
                    // Display the data in a card format
                    echo '<div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-transform transform hover:scale-105 overflow-hidden">';
                    echo '<h2 class="text-lg font-semibold mb-2">' . $event_name . '</h2>';
                    echo '<p class="text-gray-600 mb-2">' . $organising_body . '</p>';
                    echo '<p class="text-gray-400 mb-4">' . $date . '</p>';
                    echo '<p class="text-gray-800 mb-4">' . $description . '</p>';
                    echo '<a href="/dashboard/event-details.php?id=' . $event_id . '" class="text-blue-500 hover:underline self-end">Read More</a>';
                    echo '</div>';
                }
                
                // Free the result set
                mysqli_free_result($result);
            } else {
                // Handle the error
                echo "Error: " . mysqli_error($conn);
            }
            
            // Close the database connection
            mysqli_close($conn);
            ?>

        </div>
    </div>
</body>

</html>