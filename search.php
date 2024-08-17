<?php
include 'database.php';

$search_query = $_GET['query'];

$result = $conn->query("SELECT books.id, books.title, authors.author_name, categories.category_name, books.publisher, books.publish_year, books.quantity 
                        FROM books 
                        JOIN authors ON books.author_id = authors.id 
                        JOIN categories ON books.category_id = categories.id
                        WHERE books.title LIKE '%$search_query%' 
                           OR authors.author_name LIKE '%$search_query%' 
                           OR categories.category_name LIKE '%$search_query%'");

?>

<h3>Kết quả tìm kiếm:</h3>
<table border="1">
    <tr>
        <th>Tên sách</th>
        <th>Tác giả</th>
        <th>Thể loại</th>
        <th>Nhà xuất bản</th>
        <th>Năm xuất bản</th>
        <th>Số lượng</th>
        <th>Hành động</th>
    </tr>
    <?php
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['title']}</td>
                <td>{$row['author_name']}</td>
                <td>{$row['category_name']}</td>
                <td>{$row['publisher']}</td>
                <td>{$row['publish_year']}</td>
                <td>{$row['quantity']}</td>
                <td>
                    <a href='edit_book.php?id={$row['id']}'>Sửa</a> |
                    <a href='delete_book.php?id={$row['id']}'>Xóa</a>
                </td>
              </tr>";
    }
    ?>
</table>
