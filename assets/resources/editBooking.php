<?php
session_start();
include 'dbConfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roomId = $_POST['room_id'];
    $checkInDate = $_POST['checkin'];
    $checkOutDate = $_POST['checkout'];

    // Add validation: Check-in date must be onwards the current date
    $today = date('Y-m-d');
    if ($checkInDate <= $today) {
        echo json_encode(['success' => false, 'message' => 'Check-in date must be onwards from today.']);
        exit;
    }

    // Calculate the number of days
    $checkInTimestamp = strtotime($checkInDate);
    $checkOutTimestamp = strtotime($checkOutDate);
    $numDays = ($checkOutTimestamp - $checkInTimestamp) / 86400;

    $stmt = $conn->prepare("UPDATE room_tb SET checkInDate = ?, checkOutDate = ?, numOfNights = ? WHERE room_id = ?");
    $stmt->bind_param("ssis", $checkInDate, $checkOutDate, $numDays, $roomId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating booking: ' . $conn->error]);
    }
    $stmt->close();
    $conn->close();
}
?>
