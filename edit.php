<?php

require_once "config/database.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    exit("Invalid ID");
}

$stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$books = $result->fetch_assoc();

$stmt->close();

if (!$books) {
    exit("The ID does not correspond to any book.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST["title"] ??  "");
    $author = trim($_POST["author"] ?? "");
    $status = $_POST["status"];
    $current_page = filter_var($_POST["current_page"], FILTER_VALIDATE_INT);


    if(!$title || $title === "") {
        $error  = "Book title  must be provided";
    }

    if(!$author || $author === "") {
        $error = "Author of the book should be provided";
    }

    if ($current_page < 0) {
        $error = "Current page number must not be a negative number";
    }

    if (empty($current_page)) {
        $error  = "Current page cannot be empty";

    }

    if ($status === "") {
        exit("Status cannot be empty");
    }

    $stmt = $conn->prepare("UPDATE books SET title = ?,  author = ?, status = ?, current_page = ? WHERE id = ?");
    $stmt->bind_param("sssii", $title ,$author, $status, $current_page, $id);
    if ( $stmt->execute()){
        $stmt->close();
        header("Location: index.php");
        exit;
    }
    error_log("Book update failed: " .  $stmt->error);
    $stmt->close();

    exit("Unable to update book. Please try again.");

}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Books</title>
</head>
<body>
    <h1>Edit a Book</h1>

    <?php
        $statusOptions = ["ongiong", "completed", "abandoned"];
     ?>

     <div class="edit-container">
        <form action=""  method="POST">
        <label for="title">Title:</label>
        <input type="text" name="title" id="name" value="<?php echo $books["title"]; ?>" required >

        <label for="author">Author:</label>
        <input type="text" name="author"  id="author" value="<?php echo $books["author"]; ?>" required>

        <label for="status">Status:</label>
        <select name="status" id="status" required>
            <?php foreach ($statusOptions as $status) : ?>
                <option value="<?php echo $books["status"]; ?>"
                <?php if ($books["status"] === $status) {echo "selected";}?>
                ><?php  echo $status; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="current_page">Current Page:</label>
        <input type="number" name="current_page" id="current_page"   value="<?php echo $books["current_page"]; ?>">
        <button type="submit">Edit</button>

        </form>
     </div>
</body>
</html>

