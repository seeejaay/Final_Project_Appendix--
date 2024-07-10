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
        <div>
            <h2>WELCOME BACK, ADMIN!</h2>
        </div>
        <div class="container-fluid">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Edit Video</h3>
                </div>
                <form action="index.php?page=edit&id=<?php echo $video['id']; ?>" method="post">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($video['title']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Director</label>
                            <input type="text" class="form-control" name="director" value="<?php echo htmlspecialchars($video['director']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Release Year</label>
                            <input type="number" class="form-control" name="release_year" value="<?php echo htmlspecialchars($video['release_year']); ?>" min="1000" max="9999" required>
                        </div>
                        <div class="form-group">
                            <label>Casting</label>
                            <input type="text" class="form-control" name="casting" value="<?php echo htmlspecialchars($video['casting']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Genre</label>
                            <input type="text" class="form-control" name="genre" value="<?php echo htmlspecialchars($video['genre']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="description" required><?php echo htmlspecialchars($video['description']); ?></textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" name="submit" class="btn btn-info">Update Video</button>
                        <button type="button" class="btn btn-default" onclick="window.location.href='index.php?page=view';">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
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