<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

$servername = "localhost";
$username = "root"; // change this to your database username
$password = ""; // change this to your database password
$dbname = "smilepro";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['fname'];
    $lastName = $_POST['lname'];
    $patientEmail = $_POST['email'];
    $service = $_POST['service'];
    $phone = $_POST['phone'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $message = $_POST['message'];

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO appointments (first_name, last_name, email, service, phone, appointment_date, appointment_time, message) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $firstName, $lastName, $patientEmail, $service, $phone, $date, $time, $message);

    // Execute the statement
    if ($stmt->execute()) {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'ideagap200@gmail.com';
            $mail->Password = 'nrrz wvir nqxs cjyp';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('ideagap200@gmail.com', 'SmilePro');
            $mail->addAddress('nyarkosamara@gmail.com');
            $mail->addAddress($patientEmail);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'New Appointment Request';
            $mail->Body    = "
                <h3>New Appointment Request</h3>
                <p><strong>First Name:</strong> {$firstName}</p>
                <p><strong>Last Name:</strong> {$lastName}</p>
                <p><strong>Email:</strong> {$patientEmail}</p>
                <p><strong>Service:</strong> {$service}</p>
                <p><strong>Phone:</strong> {$phone}</p>
                <p><strong>Date:</strong> {$date}</p>
                <p><strong>Time:</strong> {$time}</p>
                <p><strong>Message:</strong> {$message}</p>
            ";

            $mail->send();
            echo "<script>alert('Appointment request sent successfully!');</script>";
            echo "<script>window.location.href='index.html';</script>";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}