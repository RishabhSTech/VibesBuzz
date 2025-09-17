<?php
$servername = "localhost";
$username = "thevibesbuzz";
$password = "7XmPzhGJGGKTyRRr";
$dbname = "thevibesbuzz";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $instagramID = $_POST['instagramID'];
    $phoneNumber = $_POST['phoneNumber'];

    $stmt = $conn->prepare("INSERT INTO users (instagram_id, phone_number) VALUES (?, ?)");
    $stmt->bind_param("ss", $instagramID, $phoneNumber);

    if ($stmt->execute()) {
        echo "Record inserted successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
