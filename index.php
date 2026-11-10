<?php
require_once "config/database.php";

$sql = "SELECT * FROM books";

$stmt = $conn->query($sql);
// $books = $stmt->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Book</title>
</head>
<body>
    <h1>Books  in the Oven</h1>
    <p><a href="create.php" title="Add a book">Add a book</a></p>
    <?php if($stmt->num_rows > 0) {?>
        <div class="book_container">

                <?php while ($books = $stmt->fetch_assoc()){ ?>
                    <div class="book_item">
                        <span> <?php echo "Serial Number:  "  .  $books["id"]; ?> </span> <br>
                        <span> <?php echo "Title: " . $books["title"]; ?> </span> <br>
                        <span> <?php echo "Author: "  . $books["author"]; ?> </span> <br>
                        <span> <?php echo "Status: ". $books["status"]; ?> </span> <br>
                        <span> <?php echo "Current Page: " . $books["current_page"]; ?> </span> <br>
                        <a href="edit.php?id=<?php echo $books["id"]; ?>">Edit</a>
                        <form
                             action="delete.php"
                             method="POST"
                             onsubmit="return confirm('Are you sure you want to delete this book?')"
                            >
                            <input type="number" value="<?php echo $books["id"] ?>" name="id" id="id" hidden>
                            <button type="submit">Delete</button>
                        </form>
                    </div>
                <?php } ?>



        </div>

    <?php } else { ?>
        <div class="empty-message">
            <p> <?php echo "You haven't added any books yet. Books tha you add will appear here" ?></p>
        </div>


    <?php }  ?>

</body>
</html>