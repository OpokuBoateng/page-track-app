<?php
require_once "config/database.php";

if($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit("Something went wrong,  please try again!");
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

if(!$id || $id  < 1)  {
    exit;
}

$stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
$stmt->bind_param("i", $id);

if($stmt->execute()) {
    if($stmt->affected_rows > 0) {
      header("Location: index.php");
      exit;
    }

    echo "The book does not exist or this has already been deleted";
    $stmt->close();
}

error_log("Book deletion failed: " .  $stmt->error);



$stmt->close();
exit("An error occurred. Please try again");