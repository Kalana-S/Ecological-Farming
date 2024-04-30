<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["mail"]) && isset($_POST["password"])) {

        $email = $_POST["mail"];
        $passw = $_POST["password"];

        $SERVER = "localhost";
        $USERNAME = "root";
        $PASSWORD = "";
        $DB = "farm";
        $TABLE1 = "register";

        $con = new mysqli($SERVER, $USERNAME, $PASSWORD);
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        $con->select_db($DB);
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        $sql = "SELECT * FROM $TABLE1 WHERE email = ? AND password = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ss", $email, $passw);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $userType = $row['usertype'];
            echo "<script>alert('Login Successful!');</script>";
            
            switch ($userType) {
                case 'admin':
                    header("Location: admin.php");
                    break;
                case 'field officer':
                    header("Location: fieldofficer.php");
                    break;
                case 'farmer':
                    header("Location: farmer.php");
                    break;
                default:
                    
                    header("Location: login.php");
                    break;
            }
            exit(); 
        } else {
            echo "<script>alert('Invalid email or password!');</script>";
        }

        $stmt->close();
        $con->close();

    } else {
        echo "Form data is incomplete!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page-Ecological Farming</title>
    <link rel="stylesheet" href="login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <header>
        <h1>Ecological Farming</h1>
    </header>

    <section class="content">
        <h2>Welcome to the Login Page!</h2>
        
    </section>

    <div class="wrapper">
        <form action="login.php" method="post">
            <h3>Login</h3>
            <div class="inputbox">
                <input type="email" name="mail" placeholder="Mail Address" required>
                <i class='bx bxl-gmail'></i>
            </div>
            <div class="inputbox">
                <input type="password" name="password"  placeholder="Password" required>
                <i class='bx bxs-lock-alt' ></i>
            </div>
            <button type="submit" class="btn">Login</button>
            <div class="register">
                <p>Don't have an account! <a href="index.php">Register</a></p>
            </div>
        </form>
    </div>

    
    <footer>
        <p>Ecological Farming, 2024 Department of Agriculture, Sri Lanka</p>
    </footer>
</body>

</html>
