<?php
if (!empty($_POST)) {
    include("../connect.php");

    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    $file_extension = pathinfo($_FILES['profilepicture']['name'], PATHINFO_EXTENSION);
    $target_path = "../public/profiles/"; 
    $target_file = "$target_path$username.$file_extension";
    $picture = "$username.$file_extension";
    if (move_uploaded_file($_FILES['profilepicture']['tmp_name'], $target_file)) {
        echo "File uploaded successfully!";
        $query = "INSERT INTO USER VALUES ('$username', '$password')";
        $result = mysqli_query($conn, $query);
        if (!$result) {
            echo "Error: " . mysqli_error($conn);
        } else {
            $query = "INSERT INTO PUBLISHER (Name, Email, Phonenumber, Picture, Username) VALUES ('$name', '$email', '$phone', '$picture', '$username')";
            $result = mysqli_query($conn, $query);
            if (!$result) {
                echo "Error: " . mysqli_error($conn);
            } else {
                header("Location: ../auth/login.html");
                exit();
            }
        }
    } else {
        echo "Sorry, file not uploaded, please try again!";
    }
}
?>
