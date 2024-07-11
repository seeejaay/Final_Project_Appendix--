<?php

include '../assets/resources/dbConfig.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: ../index.php');
    exit;
}

if (isset($_GET['id'])) {
    $transact_id = $_GET['id'];

    $stmt = $conn->prepare('SELECT * FROM transaction_tb WHERE transact_id = ?');
    $stmt->bind_param('i', $transact_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $transaction = $result->fetch_assoc();

    $stmt = $conn->prepare('SELECT checkInDate, checkOutDate, roomtype, pricePerNight, numOfNights FROM room_tb WHERE room_id = ?');
    $stmt->bind_param('i', $transaction['room_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $room = $result->fetch_assoc();
} else {
    echo "No transaction ID provided.";
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $checkindate = $_POST['checkindate'];
    $checkoutdate = $_POST['checkoutdate'];
    $cancelled = $_POST['cancelled'];
    $transact_amount = $_POST['transaction_amount'];
    $room_id = $transaction['room_id'];
    $transact_id = $_POST['transact_id'];
    $numNights = $_POST['number_of_days'];
    $stmt = $conn->prepare('UPDATE room_tb SET checkInDate = ?, checkOutDate = ?, numOfNights = ? WHERE room_id = ?');
    $stmt->bind_param('ssii', $checkindate, $checkoutdate, $numNights, $room_id);
    $stmt->execute();



    $stmt = $conn->prepare('UPDATE transaction_tb SET transaction_amount = ?, cancelled = ? WHERE transact_id = ?');
    $stmt->bind_param('dis', $transact_amount, $cancelled, $transact_id);
    $stmt->execute();
    $stmt->close();

    // Redirect to the page after updating the transaction
    header('Location: admin.php?page=edit&id=' . $transact_id);
    exit;
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Transaction</title>
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Add your custom CSS styles here */
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Content Wrapper. Contains page content -->

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Transaction</h1>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <form action="admin.php?page=edit&id=<?php echo $transaction['transact_id']; ?>" method="post">
                            <!-- Form inputs -->
                            <div class="form-group">
                                <label for="transact_id">Transaction ID:</label>
                                <input type="text" name="transact_id" id="transact_id" value="<?php echo $transact_id ?>" readonly class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="user_id">User ID:</label>
                                <input type="text" name="user_id" id="user_id" value="<?php echo $transaction['user_id'] ?>" readonly class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="transaction_amount">Transaction Amount:</label>
                                <input type="number" name="transaction_amount" id="transaction_amount" value="<?php echo $transaction['transaction_amount'] ?>" readonly class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="checkindate">Check-in Date:</label>
                                <input type="date" name="checkindate" id="checkindate" value="<?php echo $room['checkInDate'] ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="checkoutdate">Check-out Date:</label>
                                <input type="date" name="checkoutdate" id="checkoutdate" value="<?php echo $room['checkOutDate'] ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="roomtype">Room Type:</label>
                                <input name="roomtype" id="roomtype" class="form-control" value="<?php echo $room['roomtype'] ?>" readonly />
                            </div>
                            <div class="form-group">
                                <label for="price_per_night">Price per Night:</label>
                                <input type="number" name="price_per_night" id="price_per_night" value="<?php echo $room['pricePerNight'] ?>" readonly class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="number_of_days">Number of Days:</label>
                                <input type="text" name="number_of_days" id="number_of_days" value="<?php echo $room['numOfNights'] ?>" readonly class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="cancelled">Cancelled:</label>
                                <select name="cancelled" id="cancelled" class="form-control">
                                    <option value="0" <?php echo $transaction['cancelled'] == 0 ? 'selected' : '' ?>>No</option>
                                    <option value="1" <?php echo $transaction['cancelled'] == 1 ? 'selected' : '' ?>>Yes</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Save Changes" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content -->


    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            function calculateNumberOfDays() {
                var checkinDate = new Date($('#checkindate').val());
                var checkoutDate = new Date($('#checkoutdate').val());
                if (checkinDate && checkoutDate && checkinDate <= checkoutDate) {
                    var timeDifference = checkoutDate.getTime() - checkinDate.getTime();
                    var daysDifference = timeDifference / (1000 * 3600 * 24);
                    $('#number_of_days').val(daysDifference);
                    <?php

                    $_SESSION['numofNights'] = "<script>document.write(daysDifference)</script>";
                    ?>
                } else {
                    $('#number_of_days').val('');
                    <?php $numofNights = ""; ?>
                }
                calculatePrice();
            }

            function selectPrice() {
                const roomType = $('#roomtype').val();
                let price = 0;
                if (roomType === 'Standard') {
                    price = 500;
                } else if (roomType === 'Deluxe') {
                    price = 800;
                } else if (roomType === 'Premium') {
                    price = 1200;
                } else if (roomType === 'Executive') {
                    price = 1900;
                }
                $('#price_per_night').val(price);
                calculatePrice();
            }

            function calculatePrice() {
                const price_per_night = parseFloat($('#price_per_night').val());
                const number_of_days = parseInt($('#number_of_days').val(), 10);

                if (!isNaN(price_per_night) && !isNaN(number_of_days)) {
                    const total = price_per_night * number_of_days;
                    $('#transaction_amount').val(total);
                } else {
                    $('#transaction_amount').val('');
                }
            }

            function resetDatesIfCancelled() {
                const cancelled = $('#cancelled').val();
                if (cancelled == 1) {
                    $('#checkindate').val('');
                    $('#checkoutdate').val('');
                    $('#number_of_days').val('');
                    $('#transaction_amount').val('');
                }
            }

            $('#checkindate, #checkoutdate').on('change', calculateNumberOfDays);
            $('#roomtype').on('change', selectPrice);
            $('#cancelled').on('change', resetDatesIfCancelled);

            // Trigger the price update and number of days calculation on page load
            calculateNumberOfDays();
            selectPrice();
        });
    </script>

</body>

</html>