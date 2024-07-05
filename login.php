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
                }
        } else {
                $login_err = "No account found with that username.";
        }

        $stmt->close();
        $conn->close();
}
?>
