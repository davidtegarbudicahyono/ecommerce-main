<?php
require_once(__DIR__ . '/../../Config/init.php');

$productController = new ProductController();
$categoryController = new CategoryController();  // Menambahkan categoryController
$productDetails = [];

// Get the product ID from the URL
if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    $productDetails = $productController->show($productId);
    
    // Retrieve category name using the category ID from the product details
    $categoryName = '';
    if (isset($productDetails['category_id'])) {
        $categoryDetails = $categoryController->show($productDetails['category_id']);
        $categoryName = $categoryDetails['category_name'] ?? 'N/A';  // Menambahkan kategori jika ada
    }
}

// Handle deletion if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmDelete'])) {
    if ($productController->destroy($productId)) {
        echo "<script>
                alert('Product deleted successfully!');
                window.location.href = '../../index.php';
              </script>";
        exit();
    } else {
        echo "<script>alert('Failed to delete product. Please try again later.')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Product</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
        }

        .tdid {
            text-align: center;
        }
    </style>
</head>

<body class="container mt-4">

    <h1>Delete Product</h1>

    <?php if (!empty($productDetails)): ?>
        <p>Are you sure you want to delete the product "<strong><?php echo htmlspecialchars($productDetails['product_name']); ?></strong>"?</p>
        <table>
            <!-- First TR for Headers -->
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
            </tr>

            <!-- Second TR for Data -->
            <tr>
                <td class="tdid"><?php echo htmlspecialchars($productDetails['id']); ?></td>
                <td><?php echo htmlspecialchars($productDetails['product_name']); ?></td>
                <td><?php echo htmlspecialchars($categoryName); ?></td>
                <td><?php echo htmlspecialchars($productDetails['price']); ?></td>
                <td><?php echo htmlspecialchars($productDetails['stock']); ?></td>
            </tr>
        </table>
        <form method="POST" class="my-3">
            <button type="submit" name="confirmDelete" class="btn btn-danger">Confirm Delete</button>
            <a href="../../index.php" class="btn btn-secondary">Cancel</a>
        </form>
    <?php else: ?>
        <p>Product not found.</p>
        <a href="../../index.php" class="btn btn-secondary">Back to Product List</a>
    <?php endif; ?>

</body>

</html>
