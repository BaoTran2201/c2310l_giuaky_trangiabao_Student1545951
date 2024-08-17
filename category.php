<?php
include 'database.php';

// Thêm thể loại
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_name = $_POST['category_name'];

    $sql = "INSERT INTO categories (category_name) VALUES ('$category_name')";

    if ($conn->query($sql) === TRUE) {
        echo "Thêm thể loại thành công!";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}

// Xóa thể loại
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    $sql = "DELETE FROM categories WHERE id=$delete_id";

    if ($conn->query($sql) === TRUE) {
        echo "Xóa thể loại thành công!";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}
?>

<form method="post">
    Tên thể loại: <input type="text" name="category_name"><br>
    <input type="submit" value="Thêm thể loại">
</form>

<h3>Danh sách thể loại:</h3>
<ul>
    <?php
    $result = $conn->query("SELECT id, category_name FROM categories");
    while ($row = $result->fetch_assoc()) {
        echo "<li>" . $row['category_name'] . " <a href='category.php?delete_id=" . $row['id'] . "'>Xóa</a></li>";
    }
    ?>
</ul>
