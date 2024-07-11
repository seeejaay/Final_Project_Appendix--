<?php
include 'dbConfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roomId = $_POST['room_id'];
    $checkInDate = $_POST['checkin'];
    $checkOutDate = $_POST['checkout'];
    $transact_id = $_POST['transact_id'];

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

    // Assume you need to update based on transact_id
    $stmt = $conn->prepare("UPDATE room_tb SET checkInDate = ?, checkOutDate = ?, numOfNights = ? WHERE room_id = ? AND transact_id = ?");
    $stmt->bind_param("ssiss", $checkInDate, $checkOutDate, $numDays, $roomId, $transact_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Booking updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update booking.']);
    }

    $stmt->close();
    $conn->close();
}
