<?php

if ($_POST['updateEvent']) {
    include("../connect.php");
    // Get updated event details from POST data
    $event_id = $_POST['event_id'];
    $updatedEventName = $_POST['eventName'];
    $updatedOrganisingBody = $_POST['organisingBody'];
    $updatedDate = $_POST['eventDate'];
    $updatedTime = $_POST['eventTime'];
    $updatedType = $_POST['eventType'];
    $updatedMode = $_POST['eventMode'];
    $updatedDescription = $_POST['eventDescription'];
    $updatedPlace = $_POST['eventPlace'];
    $updatedCoordinatorPh = $_POST['coordinatorPh'];
    $updatedRegistrationLink = $_POST['registrationLink'];
    $updatedPublishedDate = $_POST['publishedDate'];
    $updatedCoordinatorName = $_POST['coordinatorName'];

    // Update the event in the database
    $updateSql = "UPDATE PROGRAM_DETAILS SET Event_Name = '$updatedEventName', Organising_Body = '$updatedOrganisingBody', Date = '$updatedDate', Time = '$updatedTime', Type = '$updatedType', Mode = '$updatedMode', Description = '$updatedDescription', Place = '$updatedPlace', Coordinator_Ph = '$updatedCoordinatorPh', Registration_Link = '$updatedRegistrationLink', Published_Date = '$updatedPublishedDate', Coordinator_Name = '$updatedCoordinatorName' WHERE P_ID = $event_id";
    $updateResult = mysqli_query($conn, $updateSql);
    if (isset($_FILES["eventImages"])) {
        $uploadDirectory = "../public/images/";
    
        // Establish database connection here
    
        foreach ($_FILES["eventImages"]["tmp_name"] as $index => $imageTmpPath) {
            $imageName = basename($_FILES["eventImages"]["name"][$index]);
            $targetPath = $uploadDirectory . $imageName;
    
            if (move_uploaded_file($imageTmpPath, $targetPath)) {
                // Insert image details into the GALLERY table
                $insertImageSql = "INSERT INTO GALLERY (P_ID, Image, Post_Date) VALUES ($event_id, '$imageName', NOW())";
                $insertImageResult = mysqli_query($conn, $insertImageSql);
    
                if (!$insertImageResult) {
                    echo "Error inserting image into gallery: " . mysqli_error($conn);
                }else{
                    header("Location : /dashboard/");
                }
            } else {
                echo "Error uploading image";
            }
        }
    
        // Close the database connection
        mysqli_close($conn);
    }
    
    
}
?>