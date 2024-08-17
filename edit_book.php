<?php
// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy ID sách từ URL
$book_id = $_GET['id'];

// Kiểm tra xem form đã được submit chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $title = $_POST['title'];
    $author_id = $_POST['author_id'];
    $category_id = $_POST['category_id'];
    $publisher = $_POST['publisher'];
    $publish_year = $_POST['publish_year'];
    $quantity = $_POST['quantity'];

    // Cập nhật thông tin sách trong cơ sở dữ liệu
    $sql = "UPDATE books SET title=?, author_id=?, category_id=?, publisher=?, publish_year=?, quantity=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siissii", $title, $author_id, $category_id, $publisher, $publish_year, $quantity, $book_id);

    if ($stmt->execute()) {
        echo "Cập nhật thông tin sách thành công!";
        header("Location: index.php");
        exit();
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

// Lấy thông tin sách hiện tại
$sql = "SELECT * FROM books WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $book_id);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();

// Lấy danh sách tác giả
$authors = $conn->query("SELECT * FROM authors");

// Lấy danh sách thể loại sách
$categories = $conn->query("SELECT * FROM categories");

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa thông tin sách</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2 class="mt-4">Sửa thông tin sách</h2>
    <form method="POST">
        <div class="form-group">
            <label for="title">Tên sách:</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required>
        </div>
        <div class="form-group">
            <label for="author_id">Tác giả:</label>
            <select class="form-control" id="author_id" name="author_id" required>
                <?php while ($author = $authors->fetch_assoc()): ?>
                    <option value="<?php echo $author['id']; ?>" <?php if ($author['id'] == $book['author_id']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($author['author_name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="category_id">Thể loại:</label>
            <select class="form-control" id="category_id" name="category_id" required>
                <?php while ($category = $categories->fetch_assoc()): ?>
                    <option value="<?php echo $category['id']; ?>" <?php if ($category['id'] == $book['category_id']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($category['category_name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="publisher">Nhà xuất bản:</label>
            <input type="text" class="form-control" id="publisher" name="publisher" value="<?php echo htmlspecialchars($book['publisher']); ?>" required>
        </div>
        <div class="form-group">
            <label for="publish_year">Năm xuất bản:</label>
            <input type="number" class="form-control" id="publish_year" name="publish_year" value="<?php echo $book['publish_year']; ?>" required>
        </div>
        <div class="form-group">
            <label for="quantity">Số lượng:</label>
            <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo $book['quantity']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="index.php" class="btn btn-secondary">Hủy</a>
    </form>
</div>
</body>
</html>
