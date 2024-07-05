<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Database credentials
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "db_hotelresv";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO user_tb (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $email);

    if ($stmt->execute()) {
        echo '<script>';
        echo 'alert("Signup successful! Please login to continue.");';
        echo '</script>';
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
<!-- Signup Modal -->

<div class="modal-content">
    <div class="top_container">
        <h1>Signup</h1>
        <div class="close">&times;</div>
    </div>
    <form id="signupForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <button type="submit" class="btn-signup">Signup</button>
        <?php if (!empty($signup_err)) : ?>
            <div class="error"><?php echo $signup_err; ?></div>
        <?php endif; ?>
    </form>
    <p>Already have an account? <a href="#" id="showLogin" class="signup-link">Login here</a></p>
</div>