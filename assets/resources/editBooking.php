<?php
include 'dbConfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transactId = $_POST['transact_id'];
    $checkInDate = $_POST['checkin'];
    $checkOutDate = $_POST['checkout'];

    // Add validation: Check-in date must be onwards the current date
    $today = date('Y-m-d');
    if ($checkInDate <= $today) {
        echo json_encode(['success' => false, 'message' => 'Check-in date must be onwards from today.']);
        exit;
    }

    $stmt = $conn->prepare("UPDATE room_tb SET checkInDate = ?, checkOutDate = ? WHERE transact_id = ?");
    $stmt->bind_param("ssi", $checkInDate, $checkOutDate, $transactId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating booking: ' . $conn->error]);
    }

    $stmt->close();
}
?>
