<?php

session_start();
include 'dbConfig.php'; // Include database connection
include 'genTransID.php'; // Include the transaction ID generation script

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ../index.php');
    exit;
}

global $checkinDate;
global $checkoutDate;
global $numDays;
global $roomType;
global $roomId;
global $pricePerNight;
global $totalPrice;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['id'];
    $checkinDate = $_POST['checkin'];
    $checkoutDate = $_POST['checkout'];
    $numDays = $_POST['numDays'];
    $roomType = $_POST['room'];
    $paymentMethod = $_POST['payment'];

    $cardNumber = $_POST['cardNumber'];
    $expiryDate = $_POST['expiry'];
    $securityCode = $_POST['securityCode'];

    $paypalEmail = $_POST['paypalEmail'];
    $today = date('Y-m-d');
    $minCheckinDate = date('Y-m-d', strtotime($today . ' + 2 days'));
    $minexpirydate = date('Y-m-d', strtotime($today . ' + 3 months'));

    if ($paymentMethod == 'paypal') {
        if (empty($paypalEmail)) {
            echo "<script>";
            echo "alert('Please add Paypal Email');";
            echo "window.location.href = 'booking.php';";
            echo "</script>";
            exit;
        }
    } else {
        if ((empty($cardNumber) && empty($expiryDate) && empty($securityCode))) {
            echo "<script>";
            echo "alert('Please Fill All Fields');";
            echo "window.location.href = 'booking.php';";
            echo "</script>";
            exit;
        } elseif ($expiryDate <= $today || $expiryDate <= $minexpirydate) {
            echo "<script>";
            echo "alert('Card should not expire for another 3 months');";
            echo "window.location.href = 'booking.php';";
            echo "</script>";
            exit;
        }
    }


    // Validate check-in date at least 2 days in advance
    $today = date('Y-m-d');
    $minCheckinDate = date('Y-m-d', strtotime($today . ' + 2 days'));

    if ($checkinDate < $minCheckinDate) {
        echo "<script>";
        echo "alert('Reservations must be made at least 2 days in advance.');";
        echo "window.location.href = 'booking.php';";
        echo "</script>";
        exit;
    }

    // Validate that check-in date is before checkout date
    if ($checkinDate >= $checkoutDate) {
        echo "<script>";
        echo "alert('Check-out date must be after check-in date.');";
        echo "window.location.href = 'booking.php';";
        echo "</script>";
        exit;
    }

    // Get all available rooms of the selected type
    $stmt = $conn->prepare("SELECT * FROM room_tb WHERE roomtype = ? AND room_id NOT IN (SELECT room_id FROM room_tb WHERE checkInDate <= ? AND checkOutDate >= ?)");
    $stmt->bind_param('sss', $roomType, $checkoutDate, $checkinDate);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch all available rooms
        $availableRooms = $result->fetch_all(MYSQLI_ASSOC);

        // Randomly select a room from the available rooms
        $selectedRoom = $availableRooms[array_rand($availableRooms)];
        $roomId = $selectedRoom['room_id'];
        $pricePerNight = $selectedRoom['pricePerNight'];
        $totalPrice = $numDays * $pricePerNight;


        // Update the room with booking information
        $stmt = $conn->prepare("UPDATE room_tb SET booked = 1, dateBooked = CURDATE(), checkInDate = ?, checkOutDate = ?, numOfNights = ?, bookedBy = ? WHERE room_id = ?");
        $stmt->bind_param('ssiii', $checkinDate, $checkoutDate, $numDays, $userId, $roomId);

        if ($stmt->execute()) {
            // Store booking details in transaction_tb
            $transactionType = $paymentMethod;
            $transactionAmount = $totalPrice;
            $transactionDate = date('Y-m-d');

            $stmt = $conn->prepare("INSERT INTO transaction_tb (transact_id, user_id, room_id, transaction_type, transaction_amount, transaction_date) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('siisss', $transactionID, $userId, $roomId, $transactionType, $transactionAmount, $transactionDate);

            if ($stmt->execute()) {
                // Booking successful, show the success modal with transaction ID
                echo "<script>";
                echo "window.onload = function() {";
                echo "showSuccessModal('{$transactionID}');";
                echo "};";
                echo "</script>";
            } else {
                echo "<script>";
                echo "alert('Error: " . $stmt->error . "');";
                echo "window.location.href = 'booking.php';";
                echo "</script>";
            }
        } else {
            echo "<script>";
            echo "alert('Error: " . $stmt->error . "');";
            echo "window.location.href = 'booking.php';";
            echo "</script>";
        }
    } else {
        // Room is not available
        echo "<script>";
        echo "alert('The selected room type is not available for the chosen dates.');";
        echo "window.location.href = 'booking.php';";
        echo "</script>";
    }

    $stmt->close();
    $conn->close();
}
