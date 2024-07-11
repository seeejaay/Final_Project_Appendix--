<?php
include 'dbConfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roomId = $_POST['room_id'];
    $checkInDate = $_POST['checkin'];
    $checkOutDate = $_POST['checkout'];

    // Add validation: Check-in date must be onwards from the current date
    $today = new DateTime();
    $checkInDateTime = new DateTime($checkInDate);

    if ($checkInDateTime <= $today) {
        echo json_encode(['success' => false, 'message' => 'Check-in date must be onwards from today.']);
        exit;
    }

    // Calculate the number of days
    $checkOutDateTime = new DateTime($checkOutDate);
    $numDays = $checkOutDateTime->diff($checkInDateTime)->days;

    // Check if the booking is cancelled before allowing updates
    $stmt = $conn->prepare('SELECT cancelled FROM transaction_tb WHERE room_id = ?');
    $stmt->bind_param('i', $roomId);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($cancelled);
        $stmt->fetch();

        if ($cancelled == 1) {
            // Booking is cancelled, prevent editing and notify the user
            echo '<script>';
            echo 'alert("Booking has been cancelled. Please make a new booking.");';
            echo 'window.location.reload();';
            echo '</script>';

            exit;
        } else {
            // Booking is active, proceed with updating room details
            $stmt = $conn->prepare("UPDATE room_tb SET checkInDate = ?, checkOutDate = ?, numOfNights = ? WHERE room_id = ?");
            $stmt->bind_param("ssii", $checkInDate, $checkOutDate, $numDays, $roomId);

            if ($stmt->execute()) {
                echo '<script>';
                echo 'alert("Booking details updated successfully.");';
                echo '</script>';
                header('Location: ../client/viewBooking.php');
                exit;
            } else {
                echo '<script>';
                echo 'alert("Failed to update booking details.");';
                echo '</script>';
                header('Location: ../client/viewBooking.php');
                exit;
            }
        }
    } else {
        // Handle case where no booking found for the given room ID
        echo json_encode(['success' => false, 'message' => 'Booking not found for the specified room ID.']);
        exit;
    }
}
