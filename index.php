<?php
require_once "config/database.php";

$sql = "SELECT * FROM books";

$stmt = $conn->query($sql);





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
    <h1>Books  in Oven</h1>
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
                    </div>
                <?php } ?>


        </div>
    <?php } else { ?>
        <div class="empty-message">
            <p>You haven't added any books yet.</p>
        </div>


    <?php }  ?>
</body>
</html>