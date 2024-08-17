<?php
include 'database.php';

$search_query = isset($_GET['query']) ? $_GET['query'] : '';
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : 'title';
$order = isset($_GET['order']) ? $_GET['order'] : 'ASC';

// Số lượng sách trên mỗi trang
$books_per_page = 10;

// Trang hiện tại
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $books_per_page;

// Đếm tổng số sách thỏa mãn điều kiện tìm kiếm
$count_sql = "SELECT COUNT(*) AS total FROM books 
              JOIN authors ON books.author_id = authors.id 
              JOIN categories ON books.category_id = categories.id
              WHERE books.title LIKE '%$search_query%' 
                 OR authors.author_name LIKE '%$search_query%' 
                 OR categories.category_name LIKE '%$search_query%'";
$count_result = $conn->query($count_sql);
$total_books = $count_result->fetch_assoc()['total'];

// Tính số trang
$total_pages = ceil($total_books / $books_per_page);

// Fetch books với tìm kiếm, sắp xếp và phân trang
$sql = "SELECT books.id, books.title, authors.author_name, categories.category_name, books.publisher, books.publish_year, books.quantity 
        FROM books 
        JOIN authors ON books.author_id = authors.id 
        JOIN categories ON books.category_id = categories.id
        WHERE books.title LIKE '%$search_query%' 
           OR authors.author_name LIKE '%$search_query%' 
           OR categories.category_name LIKE '%$search_query%'
        ORDER BY $order_by $order
        LIMIT $offset, $books_per_page";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Library Management</h2>
    
    <!-- Search Form -->
    <form method="get" class="input-group mb-3">
        <input type="text" name="query" class="form-control" placeholder="Search books, authors, categories..." value="<?php echo $search_query; ?>">
        <button class="btn btn-primary" type="submit">Search</button>
    </form>
    
    <!-- Add Book Button -->
    <a href="add_book.php" class="btn btn-success mb-3">Add New Book</a>
    
    <!-- Book List -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th><a href="?order_by=title&order=<?php echo $order === 'ASC' ? 'DESC' : 'ASC'; ?>">Title</a></th>
                <th><a href="?order_by=author_name&order=<?php echo $order === 'ASC' ? 'DESC' : 'ASC'; ?>">Author</a></th>
                <th><a href="?order_by=category_name&order=<?php echo $order === 'ASC' ? 'DESC' : 'ASC'; ?>">Category</a></th>
                <th>Publisher</th>
                <th><a href="?order_by=publish_year&order=<?php echo $order === 'ASC' ? 'DESC' : 'ASC'; ?>">Year</a></th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['author_name']; ?></td>
                    <td><?php echo $row['category_name']; ?></td>
                    <td><?php echo $row['publisher']; ?></td>
                    <td><?php echo $row['publish_year']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td>
                        <a href="edit_book.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?php echo $row['id']; ?>">Delete</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    
    <!-- Pagination -->
    <nav>
        <ul class="pagination">
            <?php if ($page > 1): ?>
                <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>&query=<?php echo $search_query; ?>&order_by=<?php echo $order_by; ?>&order=<?php echo $order; ?>">Previous</a></li>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>&query=<?php echo $search_query; ?>&order_by=<?php echo $order_by; ?>&order=<?php echo $order; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
            <?php if ($page < $total_pages): ?>
                <li class="page-item"><a class="page-link" href="?page=<?php echo $page + 1; ?>&query=<?php echo $search_query; ?>&order_by=<?php echo $order_by; ?>&order=<?php echo $order; ?>">Next</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    
    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this book?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="#" id="confirmDelete" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const confirmDelete = document.getElementById('confirmDelete');
        confirmDelete.href = 'delete_book.php?id=' + id;
    });
</script>
</body>
</html>
