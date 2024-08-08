<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.userway.org/widget.js" data-account="yHxBfPK57z"></script>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> Signup</title>
    <link rel="stylesheet" href="../css/login_style.css" />
</head>
<style>
.radio {
    height: 60px;
    width: 100%;
    padding: 10px 15px 0;
    font-size: 17px;
    margin-bottom: 1.3rem;
    border: 1px solid #ddd;
    border-radius: 6px;
    outline: none;
}

.radio-container {
    display: inline;
    align-items: center;
}

.radio-container input[type="radio"] {
    appearance: none;
    display: inline;
    -webkit-appearance: none;
    -moz-appearance: none;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 2px solid #753900;
    outline: none;
    cursor: pointer;
    position: relative;
    margin-right: 10px;
    padding-bottom: 5px;
}

.radio-container input[type="radio"]:checked::before {
    content: '';
    width: 10px;
    height: 10px;
    background-color: #753900;
    border-radius: 50%;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.radio-container label {
    color: gray;
    font-size: 16px;
}

.radio-container label:hover {
    cursor: pointer;
}
</style>

<body>
    <div class="container">
        <div class="login form">
            <header>Signup</header>
            <form action="../actions/signup_action.php" method="post">
                <?php
                if (isset($_GET['error'])) { ?>
                    <p class="error" style="color:red"><?php echo $_GET['error'] ?></p>
                <?php } ?>
                <input type="text" name="username" id="username" pattern="[A-Za-z0-9]{2,50}" placeholder="Username" required>

                <input type="email" name="email" id="email" placeholder="Email" required>

                <input type="password" name="password" id="password" placeholder="Password" required>

                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>

                <?php
                include "../settings/connection.php";

                $sql = "SELECT * FROM Roles ORDER BY RoleID ASC";
                $result = mysqli_query($conn, $sql);

                if ($result->num_rows > 0) {
                    $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
                }
                ?>
                <label style="color:gray;">Role </label>
                <select name="role_id" id="role_id" required>
                    <?php
                    foreach ($options as $option) {
                        if ($option['RoleName'] != 'superadmin') {
                            echo "<option value='" . $option['RoleID'] . "'>" . $option['RoleName'] . "</option>";
                        }
                    }
                    ?>
                </select>

                <input type="submit" class="button" name="submit_button" id="submit_button" value="Signup">

            </form>
            <div class="signup">
                <span class="signup">Already have an account?
                    <label for="check" style="color:#1C402E;"><a href="../login/login_view.php">Login</a></label>
                </span>
            </div>
        </div>
    </div>
</body>

</html>