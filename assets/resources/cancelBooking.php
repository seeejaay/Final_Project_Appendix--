<?php
include 'dbConfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transact_id = $_POST['transact_id'];

    $sql = "SELECT room_tb.pricePerNight, room_tb.numOfNights, room_tb.checkInDate, room_tb.room_id 
            FROM room_tb 
            JOIN transaction_tb ON transaction_tb.room_id = room_tb.room_id 
            WHERE transaction_tb.transact_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $transact_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $pricePerNight = $row['pricePerNight'];
        $numOfNights = $row['numOfNights'];
        $checkInDate = new DateTime($row['checkInDate']);
        $room_id = $row['room_id'];

        // Calculate cancellation fee based on current date and check-in date
        $currentDate = new DateTime();
        $daysDiff = $currentDate->diff($checkInDate)->days;

        $cancellationFee = 0;
        if ($daysDiff >= 5) {
            $cancellationFee = 0.1;
        } else if ($daysDiff == 4) {
            $cancellationFee = 0.15;
        } else if ($daysDiff >= 2 && $daysDiff <= 3) {
            $cancellationFee = 0.2;
        } else if ($daysDiff == 1) {
            // Alert the user that cancellation is not allowed one day before check-in
            echo '<script>alert("Cannot cancel the reservation 1 day before check-in date.");';
            echo 'window.location.href = "../../client/viewBooking.php";';
            echo '</script>';
            exit; // Stop execution here to prevent further processing
        }

        // Calculate refund amount
        $totalAmount = $pricePerNight * $numOfNights;
        $feeAmount = $totalAmount * $cancellationFee;
        $refundAmount = $totalAmount - $feeAmount;

        // Proceed with cancellation only if not within 1 day of check-in
        if ($daysDiff > 1) {
            $sql = "UPDATE transaction_tb SET cancelled = 1 WHERE transact_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $transact_id);
            if ($stmt->execute()) {
                // Update room status
                $stmt = $conn->prepare('UPDATE room_tb SET booked = 0, dateBooked = NULL, checkInDate = NULL, checkOutDate = NULL, numOfNights = 0, bookedBy = NULL WHERE room_id = ?');
                $stmt->bind_param('i', $room_id);
                if ($stmt->execute()) {
                    echo '<script>';
                    echo 'alert("Cancellation Successful");';
                    echo 'window.location.href = "../../client/viewBooking.php";'; // Redirect using JavaScript
                    echo '</script>';
                    exit; // Stop execution after displaying alert and redirecting
                } else {
                    echo '<script>';
                    echo 'alert("Failed to update room status.");';
                    echo 'window.location.href = "../../client/viewBooking.php";'; // Redirect using JavaScript
                    echo '</script>';
                    exit; // Stop execution after displaying alert and redirecting
                }
            } else {
                echo '<script>';
                echo 'alert("Failed to cancel booking.");';
                echo 'window.location.href = "../../client/viewBooking.php";'; // Redirect using JavaScript
                echo '</script>';
                exit; // Stop execution after displaying alert and redirecting
            }
        } else {
            // Redirect if cancellation is not allowed
            echo '<script>alert("Already Cancelled.");</script>';
            echo '<script>window.location.href = "../../client/viewBooking.php";</script>';
            exit; // Stop execution after displaying alert and redirecting
        }
    } else {
        // Handle case where transaction is not found
        echo '<script>alert("No Transaction Found.");</script>';
        echo '<script>window.location.href = "../client/viewBooking.php";</script>';
        exit; // Stop execution after displaying alert and redirecting
    }

    // Close the statement
    $stmt->close();
}
