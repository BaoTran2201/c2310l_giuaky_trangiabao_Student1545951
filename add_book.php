<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $author_id = $_POST['author_id'];
    $category_id = $_POST['category_id'];
    $publisher = $_POST['publisher'];
    $publish_year = $_POST['publish_year'];
    $quantity = $_POST['quantity'];

    $sql = "INSERT INTO books (title, author_id, category_id, publisher, publish_year, quantity) 
            VALUES ('$title', $author_id, $category_id, '$publisher', $publish_year, $quantity)";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Add New Book</h2>
    
    <form method="post">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="author_id" class="form-label">Author</label>
            <select class="form-select" id="author_id" name="author_id" required>
                <?php
                $result = $conn->query("SELECT id, author_name FROM authors");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['author_name'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select class="form-select" id="category_id" name="category_id" required>
                <?php
                $result = $conn->query("SELECT id, category_name FROM categories");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['category_name'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="publisher" class="form-label">Publisher</label>
            <input type="text" class="form-control" id="publisher" name="publisher" required>
        </div>
        <div class="mb-3">
            <label for="publish_year" class="form-label">Year</label>
            <input type="number" class="form-control" id="publish_year" name="publish_year" required>
        </div>
        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" class="form-control" id="quantity" name="quantity" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Book</button>
    </form>
</div>
</body>
</html>
