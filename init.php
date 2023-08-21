<?php

$l = "localhost";
$u = "root";
$p = "Vi@290503";
$d = "GECPE";

$conn = mysqli_connect($l, $u, $p, $d);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connected successfully\n";
}

$sql = "CREATE TABLE IF NOT EXISTS USER (
        U_Name VARCHAR(255) PRIMARY KEY,
        Password VARCHAR(255) NOT NULL
        )";


if (mysqli_query($conn, $sql)) {
    echo "Table user created successfully";

} else {
    echo "Error creating table: " . mysqli_error($conn);

}

$sql = "CREATE TABLE IF NOT EXISTS PUBLISHER (
            ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            Name VARCHAR(255) NOT NULL,
            Picture VARCHAR(255) NOT NULL,
            Email VARCHAR(255) NOT NULL,
            Phonenumber VARCHAR(255) NOT NULL,
            Username VARCHAR(255) NOT NULL,
            FOREIGN KEY (Username) REFERENCES USER(U_Name)
            )";


if (mysqli_query($conn, $sql)) {
    echo "Table publisher created successfully";

} else {
    echo "Error creating table: " . mysqli_error($conn);

}


$sql = "CREATE TABLE IF NOT EXISTS PROGRAM_DETAILS (
    PublisherID INT UNSIGNED NOT NULL,
    P_ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Event_Name VARCHAR(255) NOT NULL,
    Organising_Body VARCHAR(255) NOT NULL,
    Date DATE NOT NULL,
    Time TIME NOT NULL,
    Type VARCHAR(255) NOT NULL,
    Mode VARCHAR(255) NOT NULL,
    Description TEXT NOT NULL,
    Place VARCHAR(255) NOT NULL,
    Coordinator_Ph VARCHAR(255) NOT NULL,
    Registration_Link VARCHAR(1000) NOT NULL,
    Published_Date DATE NOT NULL,
    Coordinator_Name VARCHAR(255) NOT NULL,
    FOREIGN KEY (PublisherID) REFERENCES PUBLISHER(ID)
    )";


if (mysqli_query($conn, $sql)) {
    echo "Program Details created successfully\n";

} else {
    echo "Error creating table: " . mysqli_error($conn);

}





$sql = "CREATE TABLE IF NOT EXISTS GALLERY (
    P_ID INT NOT NULL,
    Image VARCHAR(255) NOT NULL,
    Post_Date DATE NOT NULL,
    FOREIGN KEY (P_ID) REFERENCES PROGRAM_DETAILS(P_ID),
    PRIMARY KEY (P_ID, Image)
    )";


if (mysqli_query($conn, $sql)) {
    echo "Table gallery created successfully";

} else {
    echo "Error creating table: " . mysqli_error($conn);

}

$sql = "CREATE VIEW EventSummary AS
    SELECT P_ID, Event_Name, Organising_Body, Description, Date
    FROM PROGRAM_DETAILS
    ORDER BY Date DESC";

if (mysqli_query($conn, $sql)) {
    echo "View Created successfully\n";

} else {
    echo "Error creating table: " . mysqli_error($conn);

}


$sql = "CREATE VIEW EventWithPublisher AS
    SELECT
        pd.P_ID,
        pd.Event_Name,
        pd.Organising_Body,
        pd.Date,
        pd.Time,
        pd.Type,
        pd.Mode,
        pd.Description,
        pd.Place,
        pd.Coordinator_Ph,
        pd.Registration_Link,
        pd.Published_Date,
        pd.Coordinator_Name,
        pub.Name AS Publisher_Name,
        pub.Email AS Publisher_Email,
        pub.Phonenumber AS Publisher_Phonenumber
    FROM PROGRAM_DETAILS pd
    INNER JOIN PUBLISHER pub ON pd.PublisherID = pub.ID";

if (mysqli_query($conn, $sql)) {
    echo "View Created successfully\n";

} else {
    echo "Error creating table: " . mysqli_error($conn);
}

$triggerSQL = "
CREATE TRIGGER DeleteEventImages
BEFORE DELETE ON PROGRAM_DETAILS
FOR EACH ROW
BEGIN
    DELETE FROM GALLERY WHERE P_ID = OLD.P_ID;
END
";

if (mysqli_query($conn, $triggerSQL)) {
    echo "Trigger created successfully\n";
} else {
    echo "Error creating trigger: " . mysqli_error($conn);
}



$insertUser = "INSERT INTO USER (U_Name, Password) VALUES
                    ('john_doe', 'password123'),
                    ('jane_smith', 'secure456'),
                    ('test_user', 'testpass789')";

if (mysqli_query($conn, $insertUser)) {
    echo "Dummy data added to USER table\n";
} else {
    echo "Error inserting data into USER table: " . mysqli_error($conn) . "\n";
}

// Insert data into the PUBLISHER table
$insertPublisher = "INSERT INTO PUBLISHER (Name, Picture, Email, Phonenumber, Username) VALUES
                        ('John Doe', 'john.jpg', 'john@example.com', '1234567890', 'john_doe'),
                        ('Jane Smith', 'jane.jpg', 'jane@example.com', '9876543210', 'jane_smith'),
                        ('Test Publisher', 'test.jpg', 'test@example.com', '5555555555', 'test_user')";

if (mysqli_query($conn, $insertPublisher)) {
    echo "Dummy data added to PUBLISHER table\n";
} else {
    echo "Error inserting data into PUBLISHER table: " . mysqli_error($conn) . "\n";
}

// Insert data into the PROGRAM_DETAILS table
$insertProgramDetails = "INSERT INTO PROGRAM_DETAILS (PublisherID, Event_Name, Organising_Body, Date, Time, Type, Mode, Description, Place, Coordinator_Ph, Registration_Link, Published_Date, Coordinator_Name) VALUES
                            (1, 'Conference A', 'Organizer A', '2023-09-01', '10:00:00', 'Conference', 'Physical', 'Conference about topic A', 'Venue A', 'john.jpg', 'https://confa.example.com', '2023-08-15', 'John Coordinator'),
                            (2, 'Workshop B', 'Organizer B', '2023-09-10', '14:00:00', 'Workshop', 'Virtual', 'Workshop on topic B', 'Online', 'jane.jpg', 'https://workshopb.example.com', '2023-08-20', 'Jane Coordinator'),
                            (3, 'Seminar C', 'Organizer C', '2023-09-15', '18:30:00', 'Seminar', 'Hybrid', 'Seminar discussing topic C', 'Venue C', 'test.jpg', 'https://seminarc.example.com', '2023-08-25', 'Test Coordinator')";

if (mysqli_query($conn, $insertProgramDetails)) {
    echo "Dummy data added to PROGRAM_DETAILS table\n";
} else {
    echo "Error inserting data into PROGRAM_DETAILS table: " . mysqli_error($conn) . "\n";
}

// Insert data into the gallery table
$insertGallery = "INSERT INTO GALLERY (P_ID, Image, Post_Date) VALUES
                    (1, 'image1.jpg', '2023-08-16'),
                    (1, 'image2.jpg', '2023-08-17'),
                    (2, 'image3.jpg', '2023-08-18')";

if (mysqli_query($conn, $insertGallery)) {
    echo "Dummy data added to gallery table\n";
} else {
    echo "Error inserting data into gallery table: " . mysqli_error($conn) . "\n";
}



mysqli_close($conn);

?>