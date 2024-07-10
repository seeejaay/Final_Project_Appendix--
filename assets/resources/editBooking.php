<?php
include 'dbConfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roomId = $_POST['room_id'];
    $checkInDate = $_POST['checkin'];
    $checkOutDate = $_POST['checkout'];

    // Add validation: Check-in date must be onwards the current date
    $today = new DateTime();
    $checkInDateTime = new DateTime($checkInDate);

    if ($checkInDateTime <= $today) {
        echo json_encode(['success' => false, 'message' => 'Check-in date must be onwards from today.']);
        exit;
    }

    // Calculate the number of days
    $checkOutDateTime = new DateTime($checkOutDate);
    $numDays = $checkOutDateTime->diff($checkInDateTime)->days;

    $stmt = $conn->prepare("UPDATE room_tb SET checkInDate = ?, checkOutDate = ?, numOfNights = ? WHERE room_id = ?");
    $stmt->bind_param("ssis", $checkInDate, $checkOutDate, $numDays, $roomId);

    $stmt->execute(); // Execute the update statement

    $stmt = $conn->prepare('SELECT cancelled FROM transaction_tb WHERE transact_id = ?');
    $stmt->bind_param('s', $transact_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($cancelled);
        $stmt->fetch();
        if ($cancelled == 1) {
            echo '<script>';
            echo 'alert("Booking has been cancelled. Please make a new booking.");';
            echo 'window.location.href = "../../client/viewBooking.php";';
            echo '</script>';
            exit;
        } else {
            echo '<script>';
            echo 'alert("Failed to Edit booking.");';
            echo 'window.location.href = "../../client/viewBooking.php";';
            echo '</script>';
            exit;
        }
    }
}
