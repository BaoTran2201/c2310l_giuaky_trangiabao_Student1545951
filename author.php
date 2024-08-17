<?php
include 'database.php';

// Thêm tác giả
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $author_name = $_POST['author_name'];
    $book_numbers = 0;

    $sql = "INSERT INTO authors (author_name, book_numbers) VALUES ('$author_name', '$book_numbers')";

    if ($conn->query($sql) === TRUE) {
        echo "Thêm tác giả thành công!";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}

// Xóa tác giả
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    $sql = "DELETE FROM authors WHERE id=$delete_id";

    if ($conn->query($sql) === TRUE) {
        echo "Xóa tác giả thành công!";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}
?>

<form method="post">
    Tên tác giả: <input type="text" name="author_name"><br>
    <input type="submit" value="Thêm tác giả">
</form>

<h3>Danh sách tác giả:</h3>
<ul>
    <?php
    $result = $conn->query("SELECT id, author_name FROM authors");
    while ($row = $result->fetch_assoc()) {
        echo "<li>" . $row['author_name'] . " <a href='author.php?delete_id=" . $row['id'] . "'>Xóa</a></li>";
    }
    ?>
</ul>
