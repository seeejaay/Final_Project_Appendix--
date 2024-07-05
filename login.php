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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }
        .modal-content {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            margin: 5% auto;
            padding: 20px;
            width: 80%;
            max-width: 400px;
        }
        .top_container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
        }
        .close {
            color: #fff;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 90%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: block;
            margin: 0 auto;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            margin-top: 10px;
            text-align: center;
        }
        .signup-link {
            color: blue;
            text-decoration: none;
        }
        p{
            text-align: center;
        }
        .signup-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<!-- Trigger/Open The Modal -->
<button id="myBtn" class="btn">Login</button>

<!-- The Modal -->
<div id="myModal" class="modal">
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
            <button type="submit" class="btn">Login</button>
            <?php if (!empty($login_err)): ?>
                <div class="error"><?php echo $login_err; ?></div>
            <?php endif; ?>
        </form>
        <p>Don't have an account?  <a href="signup.php" class="signup-link">Signup here</a></p>
    </div>
</div>

<script>
    var modal = document.getElementById("myModal");
    var btn = document.getElementById("myBtn");
    var span = document.getElementsByClassName("close")[0];

    btn.onclick = function() {
        modal.style.display = "block";
    }

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

</body>
</html>
