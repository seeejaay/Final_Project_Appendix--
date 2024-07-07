<?php

$login_err = '';
$signup_err = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['action']) && $_POST['action'] == 'login') {
                // Login logic
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
                $stmt->execute();
                $stmt->bind_result($id, $db_username, $db_password, $admin);

                if ($stmt->fetch()) {
                if ($password === $db_password) { // In production, use password_verify($password, $db_password)
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
                        echo '<script>alert("' . $login_err . '")</script>';
                }
                } else {
                $login_err = "No account found with that username.";
                echo '<script>alert("' . $login_err . '")</script>';
                }

                $stmt->close();
                $conn->close();
        } elseif (isset($_POST['action']) && $_POST['action'] == 'signup') {
                // Signup logic
                $name = $_POST['name'];
                $username = $_POST['username'];
                $email = $_POST['email'];
                $password = $_POST['password'];

                $servername = "localhost";
                $db_username = "root";
                $db_password = "";
                $dbname = "db_hotelresv";

                $conn = new mysqli($servername, $db_username, $db_password, $dbname);

                if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
                }

                $stmt = $conn->prepare("INSERT INTO user_tb (name, username, email, password) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss",$name, $username, $email, $password);

                if ($stmt->execute()) {
                echo '<script>alert("Signup successful! You can now log in.")</script>';
                } else {
                $signup_err = "Something went wrong. Please try again later.";
                echo '<script>alert("' . $signup_err . '")</script>';
                }

                $stmt->close();
                $conn->close();
        }
}
?>

<!-- Login Modal -->
<div class="cd-signin-modal js-signin-modal">
        <div class="cd-signin-modal__container">
                <ul class="cd-signin-modal__switcher js-signin-modal-switcher js-signin-modal-trigger">
                <li><a href="#0" data-signin="login" data-type="login">Login</a></li>
                <li><a href="#0" data-signin="signup" data-type="signup">New account</a></li>
                </ul>

                <div class="cd-signin-modal__block js-signin-modal-block" data-type="login">
                <form class="cd-signin-modal__form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <input type="hidden" name="action" value="login">
                        <p class="cd-signin-modal__fieldset">
                        <label class="cd-signin-modal__label cd-signin-modal__label--username cd-signin-modal__label--image-replace" for="signin-username">Username</label>
                        <input class="cd-signin-modal__input cd-signin-modal__input--full-width cd-signin-modal__input--has-padding cd-signin-modal__input--has-border" id="signin-username" type="text" name="username" placeholder="Username" required>
                        </p>

                        <p class="cd-signin-modal__fieldset">
                        <label class="cd-signin-modal__label cd-signin-modal__label--password cd-signin-modal__label--image-replace" for="signin-password">Password</label>
                        <input class="cd-signin-modal__input cd-signin-modal__input--full-width cd-signin-modal__input--has-padding cd-signin-modal__input--has-border" id="signin-password" type="password" name="password" placeholder="Password" required>
                        <a href="#0" class="cd-signin-modal__hide-password js-hide-password">Hide</a>
                        </p>

                        <p class="cd-signin-modal__fieldset">
                        <input type="checkbox" id="remember-me" checked class="cd-signin-modal__input ">
                        <label for="remember-me">Remember me</label>
                        </p>

                        <p class="cd-signin-modal__fieldset">
                        <input class="cd-signin-modal__input cd-signin-modal__input--full-width" type="submit" value="Login">
                        </p>
                </form>
                </div> <!-- cd-signin-modal__block -->

                <div class="cd-signin-modal__block js-signin-modal-block" data-type="signup">
                <form class="cd-signin-modal__form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <input type="hidden" name="action" value="signup">
                        <p class="cd-signin-modal__fieldset">
                        <label class="cd-signin-modal__label cd-signin-modal__label--username cd-signin-modal__label--image-replace" for="signup-username">Name</label>
                        <input class="cd-signin-modal__input cd-signin-modal__input--full-width cd-signin-modal__input--has-padding cd-signin-modal__input--has-border" id="signup-name" type="text" name="name" placeholder="Name" required>
                        </p>
                        <p class="cd-signin-modal__fieldset">
                        <label class="cd-signin-modal__label cd-signin-modal__label--username cd-signin-modal__label--image-replace" for="signup-username">Username</label>
                        <input class="cd-signin-modal__input cd-signin-modal__input--full-width cd-signin-modal__input--has-padding cd-signin-modal__input--has-border" id="signup-username" type="text" name="username" placeholder="Username" required>
                        </p>

                        <p class="cd-signin-modal__fieldset">
                        <label class="cd-signin-modal__label cd-signin-modal__label--email cd-signin-modal__label--image-replace" for="signup-email">E-mail</label>
                        <input class="cd-signin-modal__input cd-signin-modal__input--full-width cd-signin-modal__input--has-padding cd-signin-modal__input--has-border" id="signup-email" type="email" name="email" placeholder="E-mail" required>
                        </p>

                        <p class="cd-signin-modal__fieldset">
                        <label class="cd-signin-modal__label cd-signin-modal__label--password cd-signin-modal__label--image-replace" for="signup-password">Password</label>
                        <input class="cd-signin-modal__input cd-signin-modal__input--full-width cd-signin-modal__input--has-padding cd-signin-modal__input--has-border" id="signup-password" type="password" name="password" placeholder="Password" required>
                        <a href="#0" class="cd-signin-modal__hide-password js-hide-password">Hide</a>
                        </p>

                        <p class="cd-signin-modal__fieldset">
                        <input type="checkbox" id="accept-terms" class="cd-signin-modal__input ">
                        <label for="accept-terms">I agree to the <a href="#0">Terms</a></label>
                        </p>

                        <p class="cd-signin-modal__fieldset">
                        <input class="cd-signin-modal__input cd-signin-modal__input--full-width cd-signin-modal__input--has-padding" type="submit" value="Create account">
                        </p>
                </form>
                </div> <!-- cd-signin-modal__block -->

                <a href="#0" class="cd-signin-modal__close js-close">Close</a>
        </div> 
</div> <!-- cd-signin-modal -->
