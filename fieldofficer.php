<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["answer"]) && 
    isset($_POST["mail"])) {

        $answer = $_POST["answer"];
        $mail = $_POST["mail"];

        $SERVER = "localhost";
        $USERNAME = "root";
        $PASSWORD = "";
        $DB = "farm";
        $TABLE3 = "answers";

        $con = new mysqli($SERVER, $USERNAME, $PASSWORD);
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        $con->select_db($DB);
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        $sql = "INSERT INTO $TABLE3 (answer, mail) VALUES (?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ss", $answer, $mail);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Answer submitted successfully!');
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
    <title>Feild Officer-Ecological Farming</title>
    <link rel="stylesheet" href="fieldofficer.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <header>
        <h1>Ecological Farming</h1>
    </header>

    <nav>
        <ul>
            <li><a href="#description">Description</a></li>
            <li><a href="#queries">Queries</a></li>
            <li><a href="#answer">Answer</a></li>
        </ul>
    </nav>

    <div class="topic">
        <h2>Feild Officer Page</h2>
    </div>

    <section class="content">
        <h2>Welcome to the Ecological Farming Web Site!</h2>
        <p>This website advances the practice of ecological farming.</p>
    </section>


    <div class="description" id="description">
        <h3>Description</h3>
        <div class="desdiv">
                <p class="paragraph">
                    This page allows field officers to submit their answers to farmer's queries. 
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


    <div class="queries" id="queries">
        <h3>Farmer Queries</h3>

        <?php
        $SERVER = "localhost";
        $USERNAME = "root";
        $PASSWORD = "";
        $DB = "farm";
        $TABLE2 = "queries";

        $con = new mysqli($SERVER, $USERNAME, $PASSWORD);
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        $con->select_db($DB);
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        $sql = "SELECT * FROM $TABLE2";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>Email</th><th>Current Address</th><th>Query</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["mail"] . "</td>";
                echo "<td>" . $row["address"] . "</td>";
                echo "<td>" . $row["query"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No data found";
        }
        $con->close();
        ?>
    </div>


    <div class="answer" id="answer">
        <form action="" method="post" target="">
            <h3>Compose Answer</h3>
            <div class="anwform">
                <h4>Compose Your Answer!</h4>
                <div class="inputbox">
                    <textarea class="textarea"  name="answer" placeholder="Write Your Answer" rows="4" cols="40" required></textarea>
                    <i class='bx bxs-notepad'></i>
                </div>
                <div class="inputbox">
                    <input type="email" name="mail" placeholder="Email Address - Farmer" required>
                    <i class='bx bxl-gmail'></i>
                </div>
                <button type="submit" class="btn">Compose</button>
            </div>
        </form>
    </div>


    <footer>
        <P>Ecological Farming, 2024 Department of Agriculture, Sri Lanka</P>
    </footer>

</body>
</html>