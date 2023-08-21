<?php
if (isset($_POST)) {
    // $insertProgramDetails = "INSERT INTO PROGRAM_DETAILS (PublisherID, Event_Name, Organising_Body, Date, Time, Type, Mode, Description, Place, Coordinator_Ph, Registration_Link, Published_Date, Coordinator_Name) VALUES
    //                             (1, 'Conference A', 'Organizer A', '2023-09-01', '10:00:00', 'Conference', 'Physical', 'Conference about topic A', 'Venue A', 'john.jpg', 'https://confa.example.com', '2023-08-15', 'John Coordinator'),
    //                             (2, 'Workshop B', 'Organizer B', '2023-09-10', '14:00:00', 'Workshop', 'Virtual', 'Workshop on topic B', 'Online', 'jane.jpg', 'https://workshopb.example.com', '2023-08-20', 'Jane Coordinator'),
    //                             (3, 'Seminar C', 'Organizer C', '2023-09-15', '18:30:00', 'Seminar', 'Hybrid', 'Seminar discussing topic C', 'Venue C', 'test.jpg', 'https://seminarc.example.com', '2023-08-25', 'Test Coordinator')";
    $name = $_POST['programName'];
    $org = $_POST['organizer'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $mode = $_POST['mode'];
    $location = $_POST['location'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $coordname = $_POST['coordname'];
    $coordphone = $_POST['coordphone'];
    $reglink = $_POST['reglink'];
    $today = date("Y-m-d");

    include("../connect.php");
    session_start();
    $username = $_SESSION['user'];
    $query = "SELECT * FROM PUBLISHER WHERE Username='$username'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);
    $pubId = $user['ID'];
    $query = "INSERT INTO PROGRAM_DETAILS (PublisherID, Event_Name, Organising_Body, Date, Time, Type, Mode, Description, Place, Coordinator_Ph, Registration_Link, Published_Date, Coordinator_Name) VALUES($pubId, '$name', '$org', '$date', '$time', '$type', '$mode', '$description', '$location', '$coordphone', '$reglink', '$today', '$coordname')";
    $result = mysqli_query($conn, $query);
    if($result){
        header("Location:/dashboard/");
    }
    else{
        echo("Error adding Program Details");
    }

}
?>