<?php
require_once(__DIR__ . '/Config/init.php');

// Menyiapkan CategoryController untuk mengambil data kategori
$categoryController = new CategoryController();
$categories = $categoryController->index(); // Mengambil semua kategori

// Handle restore kategori yang dihapus
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["restoreCategoryId"])) {
    $categoryController->restore($_POST["restoreCategoryId"]);
    header("Location: allcategory.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category List</title>
    <!-- Sertakan CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Sertakan CSS Kustom untuk tampilan -->
    <style>
        .table th {
            background-color: #000; /* Warna hitam untuk header tabel */
            color: #fff; /* Warna teks putih */
            text-align: center;
        }

        .table td{
            background-color: #d3d3d3; /* Warna grey untuk latar belakang tabel */
        }

        .table thead {
            background-color: #f8f9fa;
        }

        .action-buttons a, .action-buttons form {
            margin-right: 5px;
        }

        .action-buttons form {
            display: inline;
        }

        .table-container {
            margin-top: 30px;
        }

        .btn-group {
            display: flex;
            gap: 10px;
        }

        .btn-container {
            margin-top: 20px;
            margin-bottom: 30px;
        }

        .btn-container .btn {
            margin-left: 10px;
        }

        th {
            text-align: center;
        }

        .tdid {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Category List</h1>

        <!-- Tombol untuk menambahkan kategori baru -->
        <div class="btn-container d-flex justify-content-between">
            <a href="index.php" class="btn btn-info">Back to Product</a>
            <a href="View/category/create.php" class="btn btn-success">Add New Category</a>
        </div>

        <?php if (!empty($categories)): ?>
            <div class="table-container">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="col-1">ID</th>
                            <th>Category Name</th>
                            <th class="col-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category): ?>
                            <tr>
                                <td class="tdid"><?php echo htmlspecialchars($category['id']); ?></td>
                                <td><?php echo htmlspecialchars($category['category_name']); ?></td>
                                <td class="action-buttons">
                                    <div class="btn-group">
                                        <a href="View/category/detail.php?id=<?php echo $category['id']; ?>" class="btn btn-info btn-sm">Detail</a>
                                        <a href="View/category/update.php?id=<?php echo $category['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="View/category/delete.php?id=<?php echo $category['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>No categories found.</p>
        <?php endif; ?>

        <!-- Form untuk restore kategori yang dihapus -->
        <form method="POST">
            <input type="hidden" name="restoreCategoryId" value="<?php echo $category['id']; ?>">
            <button type="submit" class="btn btn-danger">Restore</button>
        </form>
    </div>
</body>

</html>
