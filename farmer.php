<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["mail"]) && isset($_POST["address"]) && isset($_POST["query"])) {
        $mail = $_POST["mail"];
        $address = $_POST["address"];
        $query = $_POST["query"];

        $SERVER = "localhost";
        $USERNAME = "root";
        $PASSWORD = "";
        $DB = "farm";
        $TABLE2 = "queries";

        $con = new mysqli($SERVER, $USERNAME, $PASSWORD, $DB);
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        $sql = "INSERT INTO $TABLE2 (mail, address, query) VALUES (?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sss", $mail, $address, $query);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Query submitted successfully!');
                    window.location.href = '".$_SERVER['PHP_SELF']."';
                  </script>";
            exit;
        } else {
            echo "Error inserting data: " . $stmt->error;
        }

        $stmt->close();
        $con->close();
    } else {
        echo "<script>alert('Form data is incomplete!');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">        
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer-Ecological Farming</title>
    <link rel="stylesheet" href="farmer.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <header>
        <h1>Ecological Farming</h1>
    </header>

    <nav>
        <ul>
            <li><a href="#description">Description</a></li>
            <li><a href="#query">Query</a></li>
            <li><a href="#answers">Answers</a></li>
        </ul>
    </nav>
    
    <div class="topic">
        <h2>Farmer Page</h2>
    </div>

    <section class="content">
        <h2>Welcome to the Ecological Farming Web Site!</h2>
        <p>This website advances the practice of ecological farming.</p>
    </section>


    <div class="description" id="description">
        <h3>Description</h3>
        <div class="desdiv">
            <p class="paragraph">
                This page allows farmers to submit their queries. 
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


    <div class="query" id="query">
        <form action="farmer.php" method="post">
            <h3>Compose Queries</h3>
            <div class="qryform">
                <h4>Compose Your Query!</h4>
                <div class="inputbox">
                    <input type="email" name="mail" placeholder="Your Email" required>
                    <i class='bx bxl-gmail'></i>
                </div>
                <div class="inputbox">
                    <input type="text" name="address" placeholder="Your Address" required>
                    <i class='bx bxs-home'></i>
                </div>
                <div class="inputbox">
                    <textarea class="textarea" name="query" placeholder="Write Your Query" rows="4" cols="40" required></textarea>
                    <i class='bx bxs-notepad'></i>
                </div>
                <button type="submit" class="btn">Compose</button>
            </div>
        </form>
    </div>


    <div class="answers" id="answers">
        <h3>Field Officer Answers</h3>

        <?php
        $SERVER = "localhost";
        $USERNAME = "root";
        $PASSWORD = "";
        $DB = "farm";
        $TABLE3 = "answers";

        $con = new mysqli($SERVER, $USERNAME, $PASSWORD, $DB);
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        $sql = "SELECT * FROM $TABLE3";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>Answer</th><th>Email</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["answer"] . "</td>";
                echo "<td>" . $row["mail"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No data found";
        }
        $con->close();
        ?>
    </div>


    <footer>
        <P>Ecological Farming, 2024 Department of Agriculture, Sri Lanka</P>
    </footer>

</body>
</html>
