<?php
session_start();
if($_POST){
    include("../connect.php");
    $user = $_SESSION['user'];
    $event = $_POST['eventId'];
    $sql = "SELECT * FROM PROGRAM_DETAILS WHERE P_ID = $event";
    $result = mysqli_query($conn, $sql);
    $eventDetails = mysqli_fetch_assoc($result);
    $sql = "SELECT * FROM PUBLISHER WHERE Username = '$user'";
    $result = mysqli_query($conn, $sql);
    $userDetails = mysqli_fetch_assoc($result);
    if ($eventDetails['PublisherID'] != $userDetails['ID']) {
        header("Location: /dashboard/"); // Redirect if event doesn't belong to the current user
        echo "<script>alert('You do not have the permission to delete the event: " . mysqli_error($conn) . "')</script>";

        exit();
    }else{
        $sql = "DELETE FROM PROGRAM_DETAILS WHERE P_ID = $event";
        $result = mysqli_query($conn, $sql);
        if($result){
            echo "<script>alert('Event deleted successfully!')</script>";
            header("Location: /dashboard/");
            exit();
        }else{
            echo "<script>alert('Error deleting event: " . mysqli_error($conn) . "')</script>";
        }
    }
}
?>