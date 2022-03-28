<?php
session_start();
require "functions.php";


if (isConnected()) {
    if (!isset($_GET['userId'])) {
        echo "no user set";

        return;
    }

    $pdo = connectDB();

    $userId = $_GET['userId'];
    $idCurrent = $_SESSION['id'];

    $queryPrepared = $pdo->prepare("DELETE FROM iw_user WHERE id=:id");
    $queryPrepared->execute(["id" => $userId]);


    if ($userId == $idCurrent) {
        // logout the user if he is deleting himself
        header("Location: logout.php");
    }
}
