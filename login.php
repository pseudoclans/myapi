<?php
header('Content-Type: application/json');

$host = 'localhost'; // or your database host
$username = 'root'; // your database username
$password = 'Alex0987654321!'; // your database password
$database = 'registration_db'; // your database name

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['message' => 'Connection failed: ' . $conn->connect_error]));
}

// Get JSON input
$data = json_decode(file_get_contents('php://input'), true);
$user = $data['username'];
$pass = $data['password'];

// Perform login logic (this is a simple example)
$stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND password=?");
$stmt->bind_param("ss", $user, $pass); // Be sure to hash passwords in production
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['message' => 'Login successful']);
} else {
    echo json_encode(['message' => 'Invalid username or password']);
}

$stmt->close();
$conn->close();
?>
