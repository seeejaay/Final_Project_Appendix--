<?php
include 'dbConfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transact_id = $_POST['transact_id'];

    // Fetch room details from the database
    $sql = "SELECT room_tb.pricePerNight, room_tb.numOfNights, room_tb.checkInDate FROM room_tb JOIN transaction_tb ON transaction_tb.room_id = room_tb.room_id WHERE transaction_tb.transact_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $transact_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $pricePerNight = $row['pricePerNight'];
        $numOfNights = $row['numOfNights'];
        $checkInDate = $row['checkInDate'];
        
        // Calculate cancellation fee based on current date and check-in date
        $currentDate = new DateTime();
        $checkInDate = new DateTime($checkInDate);
        $daysDiff = $currentDate->diff($checkInDate)->days;

        $cancellationFee = 0;
        if ($daysDiff >= 5) {
            $cancellationFee = 0.1;
        } else if ($daysDiff == 4) {
            $cancellationFee = 0.15;
        } else if ($daysDiff >= 2 && $daysDiff <= 3) {
            $cancellationFee = 0.2;
        } else if ($daysDiff == 1) {
            echo json_encode(['success' => false, 'message' => 'Cannot cancel the reservation 1 day before check-in date.']);
            exit;
        }

        $totalAmount = $pricePerNight * $numOfNights;
        $feeAmount = $totalAmount * $cancellationFee;
        $refundAmount = $totalAmount - $feeAmount;

        // Update cancellation status and transaction amount in the database
        $sql = "UPDATE transaction_tb SET cancelled = 1, transaction_amount = ? WHERE transact_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ds', $refundAmount, $transact_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'refundAmount' => $refundAmount]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to cancel booking.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Booking not found.']);
    }

    header('Location: ../../client/viewBooking.php');
}
?>
