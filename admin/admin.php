<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true && !isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: ../index.php');
    exit;
}

include '../assets/resources/dbConfig.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page | Timeless Elegance</title>

    <link rel="stylesheet" href="../assets/CSS/header.css">
    <link rel="stylesheet" href="../assets/CSS/admin.css">
    <link rel="stylesheet" href="../assets/CSS/footer.css">
    <link rel="stylesheet" href="../assets/CSS/adminheader.css">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/css/adminlte.min.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <?php include 'header3.php' ?>
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <?php
                $page = $_GET['page'] ?? 'home'; // Default to home page if no specific page request
                switch ($page) {
                    case 'add':
                        include 'add.php';
                        break;
                    case 'edit':
                        include 'edit.php';
                        break;
                    case 'delete':
                        include 'delete.php';
                        break;
                    case 'viewAll_Trans':
                        include 'viewAll_Trans.php';
                        break;
                    case 'view_single':
                        include 'view_single.php';
                        break;
                    default:
                        echo '<div class="alert alert-info">WELCOME BACK, ADMIN!</div>';
                        break;
                }
                ?>
            </div>
        </section>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5+5hb5g6bRVt/vp5oVhBfiIsZnFjzSKX8vNbw5P1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="../assets/JS/viewBooking.js"></script>
</body>

</html>

<?php
$conn->close();
?>