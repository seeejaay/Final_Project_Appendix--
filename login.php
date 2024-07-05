<?php
session_start();

$login_err = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $servername = "localhost";
        $db_username = "root";
        $db_password = "";
        $dbname = "db_hotelresv";

        $conn = new mysqli($servername, $db_username, $db_password, $dbname);

        if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("SELECT id, username, password, admin FROM user_tb WHERE username = ?");
        $stmt->bind_param("s", $username);

        // Execute the statement
        $stmt->execute();

        $stmt->bind_result($id, $db_username, $db_password, $admin);

        // Fetch the value
        if ($stmt->fetch()) {
                if ($password === $db_password) {
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["username"] = $db_username;

                        if ($admin) {
                                header("location: admin.php");
                                exit();
                        } else {
                                header("location: welcome.php");
                                exit();
                        }
                } else {
                        $login_err = "The password you entered was not valid.";
                        echo '<script>';

                        echo 'alert("' . $login_err . '")';

                        echo '</script>';
                }
        } else {
                $login_err = "No account found with that username.";
                echo '<script>';

                echo 'alert("' . $login_err . '")';

                echo '</script>';
        }

        $stmt->close();
        $conn->close();
}
?>
<!-- Login Modal -->
<div id="loginModal" class="modal">
        <div class="modal-content">
                <div class="top_container">
                        <h1>Login</h1>
                        <div class="close">&times;</div>
                </div>
                <form id="loginForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn-login">Login</button>

                </form>
                <p>Don't have an account? <a href="#" id="showSignup" class="signup-link">Signup here</a></p>
        </div>
</div>