<?php
include '../assets/resources/dbConfig.php';

function getTransactions($conn)
{
    $sql = "
        SELECT 
            t.transact_id, t.user_id, t.transaction_date, t.transaction_amount, t.cancelled, 
            r.checkInDate, r.checkOutDate, r.room_id, r.roomtype, r.pricepernight, r.numOfNights, 
            CONCAT(u.first_name, ' ', u.last_name) AS name
        FROM 
            transaction_tb t
        JOIN 
            room_tb r ON t.room_id = r.room_id
        JOIN 
            user_tb u ON t.user_id = u.id";

    $result = $conn->query($sql);

    $transactions = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $transactions[] = $row;
        }
    }
    return $transactions;
}

$transactions = getTransactions($conn);

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Transaction Data</title>
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
        ul li {
            width: 100%;
            max-width: 120px;
            text-align: center;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Main content -->

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">All Transactions</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="transactionTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Transaction ID</th>
                                        <th>User ID</th>
                                        <th>Name</th>
                                        <th>Transaction Date</th>
                                        <th>Transaction Amount</th>
                                        <th>Check-in Date</th>
                                        <th>Check-out Date</th>
                                        <th>Room ID</th>
                                        <th>Room Type</th>
                                        <th>Price per Night</th>
                                        <th>Number of Days</th>
                                        <th>Cancelled</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (count($transactions) > 0) {
                                        foreach ($transactions as $transaction) {
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($transaction['transact_id']) . "</td>";
                                            echo "<td>" . htmlspecialchars($transaction['user_id']) . "</td>";
                                            echo "<td>" . htmlspecialchars($transaction['name']) . "</td>";
                                            echo "<td>" . htmlspecialchars($transaction['transaction_date']) . "</td>";
                                            echo "<td>$" . htmlspecialchars($transaction['transaction_amount']) . "</td>";
                                            echo "<td>" . htmlspecialchars($transaction['checkInDate']) . "</td>";
                                            echo "<td>" . htmlspecialchars($transaction['checkOutDate']) . "</td>";
                                            echo "<td>" . htmlspecialchars($transaction['room_id']) . "</td>";
                                            echo "<td>" . htmlspecialchars($transaction['roomtype']) . "</td>";
                                            echo "<td>$" . htmlspecialchars($transaction['pricepernight']) . "</td>";
                                            echo "<td>" . htmlspecialchars($transaction['numOfNights']) . "</td>";
                                            echo "<td>" . ($transaction['cancelled'] ? 'Yes' : 'No') . "</td>";
                                            echo "<td>
                                                <a href='admin.php?page=edit&id={$transaction['transact_id']}' class='btn btn-info'>Edit</a>
                                                </td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='13' class='text-center'>No transactions found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


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
            $('#transactionTable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true, // Add this line to make DataTable responsive
            });
        });
    </script>

</body>

</html>