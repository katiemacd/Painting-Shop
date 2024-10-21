<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Shopping Basket</title>
    <link rel="stylesheet" href="stylesheet.css">

</head>
<body>
    <div class="header">
        <h1>Your Shopping Basket</h1>
    </div>
<?php
    session_start();

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
        foreach ($_POST['paintingID'] as $paintingID) {
            $sql = "INSERT INTO `Orders` (`Name`, `Phone Number`, `Email`, `Postage Address`, `PaintingID`)" .
                " VALUES ('$name', '$phoneNumber', '$email', '$address', '$paintingID');";

        }
        if ($conn->query($sql)) {
            echo " Your order has been successfully placed! Thank you for your order, " . $name . ".";
        } else {
            echo "QUERY ERROR: Your order has not been stored. ".$conn->error;
        }

    } else {
        if (isset($_SESSION['basket']) && !empty($_SESSION['basket'])) {
            foreach ($_SESSION['basket'] as $paintingID) {
                $host = "devweb2023.cis.strath.ac.uk";
                $user = "dkb21162";
                $pass = "vaPhioSaish8";
                $dbname = $user;
                $conn = new mysqli($host, $user, $pass, $dbname);

                if ($conn->connect_error){
                    die("Connection failed: " . $conn->connect_error);
                }



                $sql = "SELECT * FROM Paintings WHERE ID = '$paintingID'";
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    $painting = $result->fetch_assoc();

                    echo '<div class="painting">';
                    echo "<p>".'<img src="data:image/jpeg;base64,' . base64_encode($painting["Photo"]) . '" alt="Thumbnail">'."</p>";
                    echo "<h2>" . $painting["Name"] . "</h2>";
                    echo "<p><strong>Date of Completion: </strong> " . $painting["Date of Completion"] . "</p>";
                    echo "<p><strong>Width: </strong> " . $painting["Width"] . "</p>";
                    echo "<p><strong>Height: </strong> " . $painting["Height"] . "</p>";
                    echo "<p><strong>Price: </strong> " . $painting["Price"] . "</p>";
                    echo "<p><strong>Description: </strong> " . $painting["Description"] . "</p>";
                    echo "<p><strong>Painting ID: </strong> " . $paintingID . "</p>";
                    echo '</div>';
                }
                $conn->close();
            }
            ?>
            <div class="form">
                <form method="post" onsubmit="return check()">
                    <p>
                        <label for="name">Your Name: </label><br>
                        <input type="text" name="name" id="name" ><br>

                        <label for="phone_number">Phone Number: </label><br>
                        <input type="text" name="phone_number" id="phone_number" ><br>

                        <label for="email">Email Address:</label><br>
                        <input type="text" name="email" id="email" ><br>

                        <label for="postal_address">Postal Address:</label><br>
                        <textarea name="postal_address" id="postal_address" ></textarea><br>

                        <?php
                        // Display checkboxes for each painting in the basket
                        echo"Please select the painting(s) in your basket you would like to order:";
                        foreach ($_SESSION['basket'] as $paintingID) {
                            echo '<p>';
                            echo '<input type="checkbox" name="paintingID[]" value="' . $paintingID . '">';
                            echo $paintingID;
                            echo '</p>';
                        }
                        ?>
                    </p>

                    <input type="submit" name="submit" value="Submit order">
                </form>

            </div>
            <?php
        } else {
            echo "Your shopping basket is empty.";
        }

    }
?>
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
            const checkboxes = document.querySelectorAll('input[name="paintingID[]"]:checked');


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
            const emailRegex = /^\S+@\S+\.\S+$/; //https:stackoverflow.com/questions/201323/how-can-i-validate-an-email-address-using-a-regular-expression
            if (!emailRegex.test(email.value) && email.value !== "") {
                errs += "Enter a valid email address.\n";
            }
            //checks for valid phone number (11 digits)
            const phoneRegex = /^\d{11}$/;
            if (!phoneRegex.test(phoneNumber.value) && phoneNumber !== "") {
                errs += "Enter a valid phone number.\n";
            }
            if (checkboxes.length === 0) {
                errs += "Select at least one painting.";
            }

            if (errs !== "") {
                window.alert(errs);
            }
            return (errs==="");
        }
    </script>
    <div class="home">
        <a href="index.php" type="button">⌂</a>
    </div>
</body>
</html>
