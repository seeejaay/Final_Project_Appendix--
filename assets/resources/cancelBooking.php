<?php
include 'dbConfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transact_id = $_POST['transact_id'];

    // Update cancellation status
    $sql = "UPDATE transaction_tb SET cancelled = 1 WHERE transact_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $transact_id);


    // Check if the transaction is cancelled
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
            echo 'alert("Failed to cancel booking.");';
            echo 'window.location.href = "../../client/viewBooking.php";';
            echo '</script>';
            exit;
        }
    }



    // Close the statement
    $stmt->close();
}
