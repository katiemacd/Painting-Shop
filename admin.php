<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
<div class="header">
    <h1>Admin Page</h1>

</div>

<?php
    session_start();

    if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
        header("Location: login.php");
        exit();
    }

    $host = "devweb2023.cis.strath.ac.uk";
    $user = "dkb21162";
    $pass = "vaPhioSaish8";
    $dbname = $user;
    $conn = new mysqli($host, $user, $pass, $dbname);

    if ($conn->connect_error){
        die("Connection failed : ".$conn->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (isset($_POST["add_painting"])) {
            $newPaintingName = $_POST["painting_name"];
            $DateOfCompletion = $_POST["completion_date"];
            $width = $_POST["width"];
            $height = $_POST["height"];
            $price = $_POST["price"];
            $description = $_POST["description"];

            if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] === UPLOAD_ERR_OK) {
                $photoData = file_get_contents($_FILES["photo"]["tmp_name"]);
                $photoData = base64_encode($photoData);
            } else {
                echo "error: no file uploaded or file upload failed.";
                exit();
            }


            $paintingSql = "INSERT INTO `Paintings` (`Name`, `Date of Completion`, `Width`, `Height`, `Price`, `Description`, `Photo`)" .
                " VALUES ('$newPaintingName', '$DateOfCompletion', '$width', '$height', '$price', '$description', '$photoData');";

            if ($conn->query($paintingSql)) {
                echo "<p>New painting '$newPaintingName' has been successfully added!</p>";
            } else {
                echo "Error adding painting: " . $conn->error;
            }
        }

        if (isset($_POST["remove_order"])) {
            $orderId = $_POST["remove_order"];
            $removeSQL = "DELETE FROM `Orders` WHERE `OrderID` = '$orderId'";
            if ($conn->query($removeSQL)) {
                echo "<p>Order ID $orderId has been successflly removed. </p>";
            } else {
                echo "Error removing order: " . $conn->error;
            }
        }

    }
    $sql = "SELECT * FROM `Orders`";
    $result = $conn->query($sql);

    if (!$result) {
        die ("Query failed " .$conn->error);
    }

    ?>
<div class="table">
    <form method="post">
        <h2>Orders:</h2>
        <table>
            <tr>
                <th>OrderID</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Email</th>
                <th>Postage Address</th>
                <th>PaintingID</th>
                <th> </th>
            </tr> <?php
            if ($result->num_rows>0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>".
                        "<td>".$row["OrderID"]."</td>".
                        "<td>".$row["Name"]."</td>".
                        "<td>".$row["Phone Number"]."</td>".
                        "<td>".$row["Email"]."</td>".
                        "<td>".$row["Postage Address"]."</td>".
                        "<td>".$row["PaintingID"]."</td>".
                        "<td><button type='submit' name='remove_order' value='". $row["OrderID"]."'>Remove</button></td>" .
                        "</tr>";
                }
            }?>
        </table>
    </form>
</div>
<div class="addPainting">
    <h2>Add a New Painting</h2>
    <form method="post" enctype="multipart/form-data">
        <p>Name: <input type="text" name="painting_name"></p>
        <p>Date of Completion: <input type="text" name="completion_date"></p>
        <p>Width (mm): <input type="text" name="width"></p>
        <p>Height (mm): <input type="text" name="height"></p>
        <p>Price: <input type="text" name="price"></p>
        <p>Description: <input type="text" name="description"></p>
        <p>Photo of Painting: <input type="file" name="photo"></p>
        <input type="submit" name="add_painting" value="Add Painting">
    </form>
</div>

<div id="logout">
    <a href="logout.php" type="button">Logout</a>
</div>

<div class="home">
    <a href="index.php" type="button">⌂</a>
</div>


</body>
