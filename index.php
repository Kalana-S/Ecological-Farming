<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST["firstName"]) &&
        isset($_POST["lastName"]) &&
        isset($_POST["mail"]) &&
        isset($_POST["password"]) &&
        isset($_POST["address"]) &&
        isset($_POST["type"])
    ) {
        $fname = $_POST["firstName"];
        $lname = $_POST["lastName"];
        $email = $_POST["mail"];
        $passw = $_POST["password"];
        $address = $_POST["address"];
        $userty = $_POST["type"];

        $SERVER = "localhost";
        $USERNAME = "root";
        $PASSWORD = "";
        $DB = "farm";
        $TABLE1 = "register";

        $con = new mysqli($SERVER, $USERNAME, $PASSWORD);
        $con->select_db($DB);

        $sql = "INSERT INTO $TABLE1 (firstname, lastname, email, password, address, usertype) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssssss", $fname, $lname, $email, $passw, $address, $userty);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Registration Successful!');
                    window.location.href = '".$_SERVER['PHP_SELF']."';
                  </script>";
            exit;
        } else {
            echo "Error inserting data: " . $stmt->error;
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
    <title>Ecological Farming</title>
    <link rel="stylesheet" href="index.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <?php
    $SERVER = "localhost";
    $USERNAME = "root";
    $PASSWORD = "";
    $DB = "farm";
    $TABLE1 = "register";
    $TABLE2 = "queries";
    $TABLE3 = "answers";

    $con = new mysqli($SERVER, $USERNAME, $PASSWORD);
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    if ($con->query("SHOW DATABASES LIKE '$DB'")->num_rows == 0){
        $sql = "CREATE DATABASE $DB";
        if (!$con->query($sql)) {
            die("Error creating database: " . $con->error);
        }

        $con->select_db($DB);
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        $sql = "CREATE TABLE $TABLE1 (
                id INT(6) UNSIGNED AUTO_INCREMENT,
                firstname VARCHAR(30) NOT NULL,
                lastname VARCHAR(30) NOT NULL,
                email VARCHAR(50),
                password VARCHAR(50),
                address VARCHAR(100),
                usertype VARCHAR(30),
                PRIMARY KEY (id, email)
            )";
        if (!$con->query($sql)) {
            die("Error creating table: " . $con->error);
        }

        $sql = "CREATE TABLE $TABLE2 (
            id INT AUTO_INCREMENT PRIMARY KEY,
            mail VARCHAR(50) NOT NULL,
            address VARCHAR(100) NOT NULL,
            query TEXT NOT NULL
        )";

        if (!$con->query($sql)) {
            die("Error creating table: " . $con->error);
        }

        $sql = "CREATE TABLE $TABLE3 (
            id INT AUTO_INCREMENT PRIMARY KEY,
            answer TEXT NOT NULL,
            mail VARCHAR(50) NOT NULL
        )";

        if (!$con->query($sql)) {
            die("Error creating table: " . $con->error);
        }

        // I directly add some data into this system to improve the first user experience
        $sql = "INSERT INTO $TABLE1 (firstname, lastname, email, password, address, usertype)
                VALUES ('admin', 'admin', 'admin@gmail.com', '111', 'colombo', 'admin')";
        $con->query($sql);
        $sql = "INSERT INTO $TABLE1 (firstname, lastname, email, password, address, usertype)
                VALUES ('field', 'officer', 'field@gmail.com', '111', 'kalutara', 'field officer')";
        $con->query($sql);
        $sql = "INSERT INTO $TABLE1 (firstname, lastname, email, password, address, usertype)
                VALUES ('farmer', 'farmer', 'farmer@gmail.com', '111', 'galle', 'farmer')";
        $con->query($sql);


        $sql = "INSERT INTO $TABLE2 (mail, address, query)
                VALUES ('farmer@gmail.com', 'galle', 'How often should I water my crops?')";
        $con->query($sql);

        
        $sql = "INSERT INTO $TABLE3 (answer, mail) 
                VALUES ('Water your crops when the soil is dry, usually every few days.', 'farmer@gmail.com')";
        $con->query($sql);
    }
    
    ?>
    <header>
        <h1>Ecological Farming</h1>
    </header>

    <nav>
        <ul>
            <li><a href="#home">Home</a></li>
            <li><a href="#aboutus">About Us</a></li>
            <li><a href="#register">Register</a></li>
            <li><a href="#login">Login</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
    </nav>

    <section class="content">
        <h2>Welcome to the Ecological Farming Web Site!</h2>
        <p>This website advances the practice of ecological farming.</p>
    </section>


    <div class="home" id="home">
        <h3>Home</h3>
        <div class="homediv">
                <p class="paragraph">
                    Welcome to the Ecological Farming Web Application, which aims 
                    to promote environmentally friendly farming methods in Sri Lanka. 
                    Our goal is to ensure that food is produced in a way that is both 
                    healthy and nutritious for current and future generations while 
                    also promoting ecological farming practices that put the health 
                    of our soil, water, and climate first. By giving agricultural 
                    stakeholders access to a variety of Department of Agriculture 
                    resources, we hope to increase their understanding of the value of
                    ecological farming. You’ll find helpful tools, information, and 
                    support here, whether you’re a farmer wishing to implement 
                    eco-friendly techniques or just a curious person interested in 
                    learning more about sustainable agriculture. You’ll find valuable 
                    resources, information, and support here. Join us in our journey towards 
                    a greener and more resilient agricultural landscape!
                </p>
         </div>            
    </div>
    

    <div class="aboutus" id="aboutus">
        <h3>About Us</h3>
        <table>
            <tr>
                <td class="col1">
                    <p class="paragraph">
                        One of the biggest government agencies, the Department of Agriculture (DOA) 
                        is housed inside the Ministry of Agriculture and comprises a distinguished 
                        group of agricultural experts as well as a network of institutions spanning 
                        various agro-ecological zones around the island.<br><br>
                        <p><a href="https://doa.gov.lk/" target="_blank"><span>Click Here To Learn More About Department Of Agriculture</span> </a></p>
                    </p>
                </td>
                <td class="col2">
                    <img src="images/img1.jpg" alt="img1" class="img">
                </td>
            </tr>
        </table>
        <br>

            <table class="tbl" >
                <tr>
                    <td class="one">
                        <img src="images/img3.jpg" alt="img3" class="img">
                    </td>
                    <td class="oneone">
                        <p class="paragraph">
                            <h4>Director General:</h4>
                            <ul>
                                <li>Mr.Aaaaa Aaaaa</i></li>
                                <li>Department of Agriculture Peradeniya</li>
                                <li>Mobile: 1111111 , 22222222</li>
                                <li>aaaa@gmail.com</li>
                            </ul>
                        </p>
                    </td>
                    <td class="one">
                        <img src="images/img4.jpg" alt="img4" class="img">
                    </td>
                    <td class="oneone">
                        <p class="paragraph">
                            <h4>Additional Director General:</h4>
                            <ul>
                                <li>Mr.Bbbbb Bbbbb</li>
                                <li>Department of Agriculture Peradeniya</li>
                                <li>Mobile: 1111111 , 22222222</li>
                                <li>bbbb@gmail.com</li>
                            </ul>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td class="one">
                        <img src="images/img5.jpeg" alt="img5" class="img">
                    </td>
                    <td class="oneone">
                        <p class="paragraph">
                            <h4>Chief Financial Officer</h4>
                            <ul>
                                <li>Mr.Ccccc Ccccc</li>
                                <li>Department of Agriculture Peradeniya</li>
                                <li>Mobile: 1111111 , 22222222</li>
                                <li>cccc@gmail.com</li>
                            </ul>
                        </p>
                    </td>
                    <td class="one">
                        <img src="images/img2.jpg" alt="img2" class="img">
                    </td>
                    <td class="oneone">
                        <p class="paragraph">
                            <h4>Chief Engineer:</h4>
                            <ul>
                                <li>Mr.Ddddd Ddddd</li>
                                <li>Department of Agriculture Peradeniya</li>
                                <li>Mobile: 1111111 , 22222222</li>
                                <li>dddd@gmail.com</li>
                            </ul>
                        </p>
                    </td>
                </tr>
            </table>
    </div>
    

        <div class="register" id="register">
            <form action="" method="post" target="" onsubmit="return validatePassword()">
            <h3>Register</h3>
            <h4>Fill Below Form To Register!</h4>
            <div>
                <fieldset>
                    <legend>User Information</legend>
                    <div class="regForm">
                        <input type="text" name="firstName" placeholder="First Name" required>
                        <i class='bx bxs-user'></i>
                    </div>
                    <div class="regForm">
                        <input type="text" name="lastName" placeholder="Last Name" required>
                        <i class='bx bxs-user'></i>
                    </div>
                    <div class="regForm">
                        <input type="email" name="mail" placeholder="Email Address" required>
                        <i class='bx bxl-gmail'></i>
                    </div>
                    <div class="regForm">
                        <input type="password" name="password" id="password"  placeholder="Password" required>
                        <i class='bx bxs-lock'></i>
                    </div>
                    <div class="regForm">
                        <input type="password" name="conpassword" id="conpassword" placeholder="Confirm Password" required>
                        <i class='bx bxs-lock'></i>
                    </div>
                    <div class="regForm">
                        <input type="text" name="address" placeholder="Current Address" required>
                        <i class='bx bxs-home'></i>
                    </div>
                    <div class="user">
                        <p>Select User Type:</p>
                    </div>
                    <div class="usertype">
                        <input type="radio" id="admin" name="type" value="admin" checked="checked">
                        <label for="admin">Admin</label><br>
                   
                        <input type="radio" id="fdOff" name="type" value="field officer">
                        <label for="fdOff">Field Officer</label><br>

                        <input type="radio" id="fam" name="type" value="farmer">
                        <label for="fam">Farmer</label>
                    </div>
                    <input type="submit" class="btn" value="Submit">
                </fieldset>
            </div>
        </form>
        </div>
        <script>
            function validatePassword(){
                var password = document.getElementById("password").value;
                var confirmPassword = document.getElementById("conpassword").value;
                if(password!=confirmPassword){
                    alert("Password do not match!");
                    return false;
                }
                return true;
            }
        </script>
      
    
        <div class="login" id="login">
            <h3>Login</h3>
            <div class="logindiv">
                <p>This is the login button for logging in to this web application. 
                    You can login to this system as an admin, field officer, or farmer. 
                    If you want to login to the system, you must use the email and password 
                    you provided in the registration form. After having logged in, you will be
                    taken to the appropriate web page based on your registration information. (Admin page, 
                    Field Officer page, Farmer page)</p><br>
                <a href="login.php" target="_blank">
                    <button type="submit" id="selad" class="btn">Login</button>
                </a>
            </div>
        </div>

        
        <div class="contact" id="contact">
            <h3>Contact</h3>
            <div class="condiv">
                <table>
                    <tr>
                        <td class="three">
                            <img src="images/img6.jpeg" alt="img6" class="img">
                        </td>
                        <td class="threethree">
                            <p class="paragraph">
                                <h4>Developed and Designed By:</h4>
                                <ul>
                                    <li>Mr.Abcd Abcd</li>
                                    <li>Web Developer and Designer</li>
                                    <li>Mobile: 1111111 , 22222222</li>
                                    <li>abcd@gmail.com</li>
                                </ul>
                            </p>
                        </td> 
                    </tr>
                </table>
            </div>
        </div>


    <footer>
        <P>Ecological Farming, 2024 Department of Agriculture, Sri Lanka</P>
    </footer>

</body>
</html>