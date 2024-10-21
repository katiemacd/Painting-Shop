<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
<div class="header">
    <h1>Order</h1>
</div>

    <?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $name = $_POST["name"];
        $phoneNumber = $_POST["phone_number"];
        $email = $_POST["email"];
        $address = $_POST["postal_address"];
        $paintingID = $_POST['paintingID'];

        $host = "devweb2023.cis.strath.ac.uk";
        $user = "dkb21162";
        $pass = "vaPhioSaish8";
        $dbname = $user;
        $conn = new mysqli($host, $user, $pass, $dbname);

        if ($conn->connect_error){
            die("Connection failed : ".$conn->connect_error);
        }

        $sql = "INSERT INTO `Orders` (`Name`, `Phone Number`, `Email`, `Postage Address`, `PaintingID`)" .
            " VALUES ('$name', '$phoneNumber', '$email', '$address', '$paintingID');";


        if ($conn->query($sql)) {
            echo " Your order has been successfully placed! Thank you for your order, " . $name . ".";
            //echo "<p><a href='index.php'>Continue Shopping</a></p>";
        } else {
            echo "QUERY ERROR: Your order has not been stored. ".$conn->error;
        }
    } else {

    $host = "devweb2023.cis.strath.ac.uk";
    $user = "dkb21162";
    $pass = "vaPhioSaish8";
    $dbname = $user;
    $conn = new mysqli($host, $user, $pass, $dbname);

    if ($conn->connect_error){
        die("Connection failed : ".$conn->connect_error);
    }

    $paintingID = $_GET['paintingID'];

    $sql = "SELECT * FROM Paintings WHERE ID = '$paintingID'";
    $result = $conn->query($sql);
    $painting = mysqli_fetch_array($result);

    if (!$result){
        die("Query failed ".$conn->error);
    }

    ?>
    <div class="container">
    <div class="orderPainting">
    <form action="order.php" method="post" onsubmit="return check()">
        <input type="hidden" name="paintingID" value="<?php echo $paintingID; ?>">
        <img src="data:image/jpeg;base64,<?php echo base64_encode($painting['Photo']); ?>" alt="Thumbnail">
        <p> <strong><?php echo $painting['Name']; ?> </strong></p>
        <p> Date of Completion: <?php echo $painting['Date of Completion']; ?> </p>
        <p> Size: <?php echo $painting['Width']; ?> x <?php echo $painting['Height']; ?> mm</p>
        <p> Price: £ <?php echo $painting['Price']; ?> </p>
        <p> Description: <?php echo $painting['Description']; ?></p>
    </div>
    <div class="form">
        <p>
            <label for="name">Your Name: </label><br>
            <input type="text" name="name" id="name" ><br>

            <label for="phone_number">Phone Number: </label><br>
            <input type="text" name="phone_number" id="phone_number" ><br>

            <label for="email">Email Address:</label><br>
            <input type="text" name="email" id="email" ><br>

            <label for="postal_address">Postal Address:</label><br>
            <textarea name="postal_address" id="postal_address" ></textarea><br>
        </p>

        <input type="submit" name="submit" value="Submit order">
    </div>
    </div>
    </form>


    <script>
        const DEBUG = true;
        function debug(s) {
            if (DEBUG) {
                console.log(s);
            }
        }

        function check() {
            debug("Checking form");

            let errs = "";
            const name = document.getElementById("name");
            const phoneNumber = document.getElementById("phone_number");
            const email = document.getElementById("email");
            const address = document.getElementById("postal_address");

            if (name.value==="") {
                errs += "Fill in the name field.\n";
            }
            if (phoneNumber.value==="") {
                errs += "Fill in the phone number field.\n";

            }
            if (email.value==="") {
                errs += "Fill in the email field.\n";
            }
            if (address.value==="") {
                errs += "Fill in the address field.\n";
            }
            //checks for valid email address
            const emailRegex = /^\S+@\S+\.\S+$/; // https://stackoverflow.com/questions/201323/how-can-i-validate-an-email-address-using-a-regular-expression
            if (!emailRegex.test(email.value) && email.value !== "") {
                errs += "Enter a valid email address.\n";
            }
            //checks for valid phone number (11 digits)
            const phoneRegex = /^\d{11}$/;
            if (!phoneRegex.test(phoneNumber.value) && phoneNumber !== "") {
                errs += "Enter a valid phone number.";
            }

            if (errs !== "") {
                window.alert(errs);
            }
            return (errs==="");
        }
    </script>
    <?php
    }
    ?>
<div class="home">
    <a href="index.php" type="button">⌂</a>
</div>

</body>
