<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ../index.php');
    exit;
}

include '../assets/resources/dbConfig.php';
include '../assets/resources/getBooking.php';
include '../assets/resources/cancelBooking.php';
include '../assets/resources/editBooking.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Booking | Timeless Elegance</title>

    <link rel="stylesheet" href="../assets/CSS/header.css">
    <link rel="stylesheet" href="../assets/CSS/viewBooking.css">
    <link rel="stylesheet" href="../assets/CSS/footer.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <!-- Navbar FOR ALL-->
    <?php include '../assets/resources/header2.php'; ?>

    <main class="container-wrapper">
        <div class="top">
            <div class="title">
                <h1>View Booking</h1>
            </div>
        </div>
        <div class="container mt-5">
            <h2 class="mb-4">Your Reservations</h2>
            <div class="table-responsive">
                <?php
                $user_id = $_SESSION['id'];
                // Fetch booking data from the database
                $sql = "SELECT transaction_tb.*, room_tb.roomtype, room_tb.checkInDate, room_tb.checkOutDate, room_tb.bookedBy, room_tb.room_id,
                    CASE WHEN transaction_tb.cancelled = 0 THEN 'Processing' ELSE 'Cancelled' END as status
                    FROM transaction_tb
                    JOIN room_tb ON transaction_tb.room_id = room_tb.room_id
                    WHERE user_id = $user_id
                    ORDER BY transaction_tb.transact_id ASC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) : ?>
                    <table class="table table-bordered">
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()) : ?>
                                <tr data-transact-id="<?php echo $row['transact_id']; ?>" data-check-in-date="<?php echo $row['checkInDate']; ?>" data-check-out-date="<?php echo $row['checkOutDate']; ?>" data-num-days="<?php echo (strtotime($row['checkOutDate']) - strtotime($row['checkInDate'])) / 86400; ?>" data-room-type="<?php echo $row['roomtype']; ?>" data-payment-mode="<?php echo $row['transaction_type']; ?>" data-room-id="<?php echo $row['room_id']; ?>">
                                    <td>
                                        <?php echo $row['roomtype']; ?><br>
                                        <?php echo $row['transact_id']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['checkInDate']; ?> - <?php echo $row['checkOutDate']; ?> of year 2024<br>
                                        Booked by: <?php echo $row['bookedBy']; ?><br>
                                        Room #: <?php echo $row['room_id']; ?><br>
                                        Status: <?php echo $row['status']; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary view-booking" data-room-id="<?php echo $row['room_id']; ?>" data-toggle="modal" data-target="#viewModal">View</button>
                                        <button class="btn btn-success edit-booking" data-room-id="<?php echo $row['room_id']; ?>" data-toggle="modal" data-target="#editModal">Edit</button>
                                        <button class="btn btn-danger cancel-booking" data-room-id="<?php echo $row['room_id']; ?>" data-toggle="modal" data-target="#cancelModal">Cancel Reservation</button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <p>No bookings found.</p>
                <?php endif; ?>
            </div>

            <!-- View Modal -->
            <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewModalLabel">View Booking</h5>
                        </div>
                        <div class="modal-body">
                            <p>Check-In Date: <span id="viewCheckInDate"></span></p>
                            <p>Check-Out Date: <span id="viewCheckOutDate"></span></p>
                            <p>Number of Days: <span id="viewNumDays"></span></p>
                            <p>Check-In Time: 10:00 AM</p>
                            <p>Check-Out Time: 10:00 AM</p>
                            <p>Room #: <span id="viewRoomID"></span></p>
                            <p>Room Type: <span id="viewRoomType"></span></p>
                            <p>Mode of Payment: <span id="viewPaymentMode"></span></p>
                            <button type="button" class="btn btn-secondary" onclick="window.location.href='viewBooking.php'">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Booking</h5>
                        </div>
                        <div class="modal-body">
                            <form id="editForm" method="post">
                                <div class="form-group">
                                    <label for="editCheckInDate">Check-In Date</label>
                                    <input type="date" class="form-control" id="editCheckInDate" name="checkin" required>
                                </div>
                                <div class="form-group">
                                    <label for="editCheckOutDate">Check-Out Date</label>
                                    <input type="date" class="form-control" id="editCheckOutDate" name="checkout" required>
                                </div>
                                <div class="form-group">
                                    <label for="editNumDays">Number of Days</label>
                                    <input type="text" class="form-control" id="editNumDays" name="numDays" readonly>
                                </div>
                                <input type="hidden" id="editRoomId" name="room_id">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cancel Modal -->
            <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cancelModalLabel">Cancel Booking</h5>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to cancel this booking?</p>
                            <form id="cancelForm" method="post" action="../assets/resources/cancelBooking.php">
                                <input type="hidden" id="cancelTransactId" name="transact_id">
                                <button type="button" class="btn btn-secondary" onclick="window.location.href='viewBooking.php'">Cancel</button>
                                <button type="submit" class="btn btn-danger">Confirm Cancellation</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <img class="footer-logo" src="../assets/images/logo_bg.png" alt="Logo">
                </div>
                <div class="col-md-4">
                    <h3>Contact Us</h3>
                    <p>123 Main Street, City, Country</p>
                    <p>Email: info@example.com</p>
                    <p>Phone: +1 123 456 7890</p>
                </div>
                <div class="col-md-4">
                    <h3>Follow Us</h3>
                    <ul class="social-media">
                        <li><a href="#"><i class="fab fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5+5hb5g6bRVt/vp5oVhBfiIsZnFjzSKX8vNbw5P1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="../assets/JS/viewBooking.js"></script>
</body>

</html>

<?php
$conn->close();
?>
