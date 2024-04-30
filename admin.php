<?php
function connectToDatabase() {
    $SERVER = "localhost";
    $USERNAME = "root";
    $PASSWORD = "";
    $DB = "farm";
    
    $conn = new mysqli($SERVER, $USERNAME, $PASSWORD, $DB);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

function deleteRecord($table, $id) {
    $conn = connectToDatabase();

    $sql = "DELETE FROM $table WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<script>alert('Record deleted successfully!');</script>";
    } else {
        echo "Error deleting record: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_user_id"])) {
    $user_id = $_POST["delete_user_id"];
    deleteRecord("register", $user_id);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_query_id"])) {
    $query_id = $_POST["delete_query_id"];
    deleteRecord("queries", $query_id);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_answer_id"])) {
    $answer_id = $_POST["delete_answer_id"];
    deleteRecord("answers", $answer_id);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-Ecological Farming</title>
    <link rel="stylesheet" href="admin.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <header>
        <h1>Ecological Farming</h1>
    </header>

    <nav>
        <ul>
            <li><a href="#description">Description</a></li>
            <li><a href="#userdata">Manage User Information</a></li>
            <li><a href="#managequr">Manage Queries</a></li>
            <li><a href="#manageanw">Manage Answers</a></li>
        </ul>
    </nav>

    <div class="topic">
        <h2>Admin Page</h2>
    </div>

    <section class="content">
        <h2>Welcome to the Ecological Farming Web Site!</h2>
        <p>This website advances the practice of ecological farming.</p>
    </section>
    
    
    <div class="description" id="description">
        <h3>Description</h3>
        <div class="desdiv">
                <p class="paragraph">
                    This page allows admins to manage users. 
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


    <div class="tabledata" id="userdata">
        <h3>User Information</h3>

        <?php
            
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

            $sql = "SELECT * FROM $TABLE1 ORDER BY ID ASC;";
            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                echo "<table border='1'>";
                echo "<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Password</th><th>Address</th><th>User Type</th><th>Action</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["firstname"] . "</td>";
                    echo "<td>" . $row["lastname"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td>" . $row["password"] . "</td>";
                    echo "<td>" . $row["address"] . "</td>";
                    echo "<td>" . $row["usertype"] . "</td>";
                    echo "<td>";
                    echo "<form method='post'>";
                    echo "<input type='hidden' name='delete_user_id' value='" . $row["id"] . "'>";
                    echo "<button type='submit'>Delete</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "No data found";
            }
            $con->close();
            ?>
        </div>



    <div class="tabledata" id="managequr">
        <h3>Manage Queries</h3>

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

        $sql = "SELECT * FROM $TABLE2 ORDER BY ID ASC";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>Email</th><th>Address</th><th>Query</th><th>Action</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["mail"] . "</td>";
                echo "<td>" . $row["address"] . "</td>";
                echo "<td>" . $row["query"] . "</td>";
                echo "<td>";
                echo "<form method='post'>";
                echo "<input type='hidden' name='delete_query_id' value='" . $row["id"] . "'>";
                echo "<button type='submit'>Delete</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No data found";
        }
        $con->close();
        ?>

    </div>
    
<div class="tabledata" id="manageanw">
    <h3>Manage Answers</h3>
    
    <?php

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

        $sql = "SELECT * FROM $TABLE3 ORDER BY ID ASC";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>Answer</th><th>Email</th><th>Action</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["answer"] . "</td>";
                echo "<td>" . $row["mail"] . "</td>";
                echo "<td>";
                echo "<form method='post'>";
                echo "<input type='hidden' name='delete_answer_id' value='" . $row["id"] . "'>";
                echo "<button type='submit'>Delete</button>";
                echo "</form>";
                echo "</td>";
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