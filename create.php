<?php

require_once "config/database.php";


$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $bk_title = trim($_POST["title"] ?? "");
    $bk_author = trim($_POST["author"] ?? "");
    $status = $_POST["status"] ??  "";
    $current_page = filter_var($_POST["current-page"] ?? 1, FILTER_VALIDATE_INT);


    if(!$bk_title || $bk_title === "") {
        $error  = "Book title  must be provided";
    }

    if(!$bk_author || $bk_author === "") {
        $error = "Author of the book should be provided";
    }

    if ($current_page < 0) {
        $error = "Current page number must not be a negative number";
    }

    if (empty($current_page)) {
        $error  = "Current page cannot be empty";
    }



    $stmt = $conn->prepare("INSERT INTO books (title, author,  status, current_page)
    VALUES (?, ?, ?, ?)");

    $stmt->bind_param("sssi", $bk_title, $bk_author, $status, $current_page);

    if (!$error) {
        if ($stmt->execute()) {
             $stmt->close();

            header("Location: index.php");
            exit;

        }



        }

    error_log("Book addition: " . $stmt->error);
    echo $error;
    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Add a Book</title>
</head>
<body>
    <h1>Add a book</h1>
    <p><a href="index.php" title="Go to Dashboard">Dashboard</a></p>

    <div class="create-container">
        <h2>Add a New Book</h2>
        <form action="" method="POST">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" required>

            <label for="author">Author:</label>
            <input type="text" name="author" id="author" required>

            <label for="status">Choose the status:</label>
            <select name="status" id="status">
                <option value="">Select an status</option>
                <option value="ongoing">Ongoing</option>
                <option value="completed">Completed</option>
                <option value="abandoned">Abandoned</option>
            </select>

            <label for="current-page">Current Page:</label>
            <input type="number" name="current-page" id="current-page" required>

            <button type="submit">Add</button>
        </form>
</div>


</body>
</html>