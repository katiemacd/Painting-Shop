<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Art Shop</title>
    <link rel="stylesheet" href="stylesheet.css">

</head>
<body>
    <div class="header">
        <h1>Cara's Art Shop</h1>
    </div>

    <?php
    session_start();


    $host = "devweb2023.cis.strath.ac.uk";
    $user = "dkb21162";
    $pass = "vaPhioSaish8";
    $dbname = $user;
    $conn = new mysqli($host, $user, $pass, $dbname);

    if ($conn->connect_error){
        die("Connection failed : ".$conn->connect_error);
    }

    $itemsPerPage = 12;
    $currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;
    $offset = ($currentPage - 1) * $itemsPerPage;

    $sql = "SELECT * FROM `Paintings` LIMIT $offset, $itemsPerPage";
    $result = $conn->query($sql);

    if (!$result){
        die("Query failed ".$conn->error);
    }

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="painting">';
            echo "<p>".'<img src="data:image/jpeg;base64,' . base64_encode($row["Photo"]) . '" alt="Thumbnail">'."</p>";
            echo '<div class="hidden">';
            echo "<h2>" . $row["Name"] . "</h2>";
            echo "<p><strong>Date of Completion: </strong> " . $row["Date of Completion"] . "</p>";
            echo "<p><strong>Width: </strong> " . $row["Width"] . "</p>";
            echo "<p><strong>Height: </strong> " . $row["Height"] . "</p>";
            echo "<p><strong>Price: </strong> " . $row["Price"] . "</p>";
            echo "<p><strong>Description: </strong> " . $row["Description"] . "</p>";
            echo "<p>".'<a href=order.php?paintingID=' . $row["ID"] . '">'."</p>";
            echo '<button id="order-button">Order</button>';
            echo "<p>".'<a href=addToBasket.php?paintingID=' . $row["ID"] . '">'."</p>";
            echo '<button>Add to Basket</button>';
            echo '</a>';
            echo '</div>';
            echo '</div>';
        }
    }

    ?>

    <div class="pagination">
        <?php
        $sql = "SELECT COUNT(*) as total FROM `Paintings`";
        $result = $conn->query($sql);
        $totalItems = $result->fetch_assoc()['total'];
        $totalPages = ceil($totalItems / $itemsPerPage);

        if ($currentPage > 1) {
            echo "<p><a href='?page=" . ($currentPage - 1) . "'>Previous</a></p>";
        }

        for ($i = 1; $i <= $totalPages; $i++) {
            echo "<p><a href='?page=" . $i . "'>" . $i . "</a></p>";
        }

        if ($currentPage < $totalPages) {
            echo "<p><a href='?page=" . ($currentPage + 1) . "'>Next</a></p>";
        }
        ?>
    </div>

    <div class="basket">
        <a href="viewBasket.php" type="button">Basket</a>
    </div>

    <div class="admin-button">
        <a href="admin.php" type="button">Admin</a>
    </div>



</body>

</html>
