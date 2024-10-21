<?php
session_start();

if (!isset($_SESSION['basket'])) {
    $_SESSION['basket'] = array();
}

if (isset($_GET["paintingID"])) {
    $paintingID = $_GET["paintingID"];

    //check for duplicate painting
    if (!in_array($paintingID, $_SESSION['basket'])) {
        $_SESSION['basket'][] = $paintingID;
        echo "Painting was added to your basket!";
    } else {
        echo "Painting is already in your basket.";
    }
} else {
    echo "Invalid request";
}

header("Location: index.php");
exit();

?>
