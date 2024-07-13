<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$servername = "localhost";
$username = "root"; // change this to your database username
$password = "root"; // change this to your database password
$dbname = "smilepro";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, first_name, last_name, email, service, phone, appointment_date, appointment_time, message, created_at FROM appointments";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
<title>Admin Dashboard</title>
<style>
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }
    footer {
        margin-top: auto;
        background-color: #f8f9fa;
    }
</style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-sm navbar-light bg-light px-4 py-2">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.html" style="font-size: 36px;">Smile<span class="text-primary">Pro</span></a>
                <div class="collapse navbar-collapse">
                    <div class="ms-auto">
                        <a class="nav-link" href="logout.php">
                            <button class="btn btn-primary">Logout</button>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <div class="container mt-5 table-responsive">
        <h2 class="mb-4">Staff Dashboard - Appointments</h2>
        <table class="table table-bordered">
            <thead class="">
                <tr class="table-primary">
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Service</th>
                    <th>Phone</th>
                    <th>Appointment Date</th>
                    <th>Appointment Time</th>
                    <th>Message</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['first_name']}</td>
                                <td>{$row['last_name']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['service']}</td>
                                <td>{$row['phone']}</td>
                                <td>{$row['appointment_date']}</td>
                                <td>{$row['appointment_time']}</td>
                                <td>{$row['message']}</td>
                                <td>{$row['created_at']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>No appointments found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <!--Footer-->
    <footer class="text-center p-2">
        <p>All rights reserved @Samara</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js"></script>
</body>
</html>