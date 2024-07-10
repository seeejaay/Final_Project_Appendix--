<?php
include '../assets/resources/dbConfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transact_id = $_POST['transact_id'];
    // Update cancellation status
    $sql = "UPDATE transaction_tb SET cancelled = 1 WHERE transact_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $transact_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        // Error handling for SQL execution failure
        echo json_encode(['success' => false, 'message' => 'Failed to cancel booking.']);
    }

    // Close the statement
    $stmt->close();

    header('Location: ../client/viewBooking.php');
}
