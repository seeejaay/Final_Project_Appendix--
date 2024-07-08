<?php
function genTransID($userId, $checkinDate, $roomType, $conn) {
    // Fetch user details
    $stmt = $conn->prepare("SELECT first_name FROM user_tb WHERE id = ?");
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $firstName = $user['first_name'];

    // Fetch the highest transaction ID from transaction_tb
    $stmt = $conn->prepare("SELECT MAX(transact_id) as maxTransID FROM transaction_tb");
    $stmt->execute();
    $result = $stmt->get_result();
    $maxTransID = $result->fetch_assoc()['maxTransID'];

    // Extract the numeric part of the transaction ID and increment it
    if ($maxTransID) {
        preg_match('/(\d+)$/', $maxTransID, $matches);
        $reservationCount = (int)$matches[1] + 1;
    } else {
        $reservationCount = 1;
    }

    // Generate parts of the transaction ID
    $firstLetters = strtoupper(substr($firstName, 0, 2));
    $month = strtoupper(date('M', strtotime($checkinDate)));
    $day = date('d', strtotime($checkinDate));
    $numericMonthYear = date('my', strtotime($checkinDate));

    // Room type code
    $roomTypeCode = '';
    switch (strtolower($roomType)) {
        case 'deluxe':
            $roomTypeCode = 'DEL';
            break;
        case 'standard':
            $roomTypeCode = 'STA';
            break;
        case 'premium':
            $roomTypeCode = 'PRE';
            break;
        case 'executive':
            $roomTypeCode = 'EXE';
            break;
    }

    // Format the transaction count
    $formattedCount = str_pad($reservationCount, 5, '0', STR_PAD_LEFT);

    // Combine all parts to form the transaction ID
    $transactionID = "{$firstLetters}{$month}{$day}{$numericMonthYear}-{$roomTypeCode}{$formattedCount}";

    return $transactionID;
}
?>
