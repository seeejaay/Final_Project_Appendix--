<?php
include '../assets/resources/dbConfig.php';

if (isset($_GET['transact_id'])) {
    $transact_id = $_GET['transact_id'];
    $sql = "SELECT t.*, r.roomtype, r.checkInDate, r.checkOutDate, r.numOfNights
            FROM transaction_tb t
            JOIN room_tb r ON t.room_id = r.room_id
            WHERE t.transact_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $transact_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $booking = $result->fetch_assoc();
    echo json_encode($booking);
}
?>
