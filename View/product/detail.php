<?php
require(__DIR__ . '/../../Config/init.php');

// Get the product ID from the URL
$id = $_GET['id'];

$productController = new ProductController();
$categoryController = new CategoryController(); // Menambahkan categoryController

// Fetch product details using the controller
$productDetails = $productController->show($id);

// Fetch category details based on the product's category_id
if (!empty($productDetails)) {
    $categoryDetails = $categoryController->show($productDetails['category_id']); // Mengambil kategori berdasarkan category_id
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: none;
            border-radius: 10px;
            overflow: hidden;
        }

        .card-header {
            background-color: black;
            color: #fff;
            font-size: 1.5rem;
            text-align: center;
            padding: 15px;
        }

        .card-body {
            padding: 20px;
            background-color: #f2f2f3;
        }

        .card-body table {
            width: 100%;
            margin-top: 10px;
            
        }

        .card-body table td {
            padding: 10px;
        }

        .card-body table th {
            
            text-align: left;
            padding: 10px;
            width: 30%;
        }

        .btn-back {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Tombol kembali -->
        <a href="../../index.php" class="btn btn-secondary btn-back">Back to Product List</a>

        <?php if (!empty($productDetails)): ?>
            <div class="card">
                <div class="card-header">Product Details</div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>ID</th>
                            <td><?php echo htmlspecialchars($productDetails['id']); ?></td>
                        </tr>
                        <tr>
                            <th>Product Name</th>
                            <td><?php echo htmlspecialchars($productDetails['product_name']); ?></td>
                        </tr>
                        <tr>
                            <th>Category</th>
                            <td><?php echo htmlspecialchars($categoryDetails['category_name'] ?? 'Unknown'); ?></td>
                        </tr>
                        <tr>
                            <th>Price</th>
                            <td>Rp <?php echo number_format($productDetails['price'], 0, ',', '.'); ?></td>
                        </tr>
                        <tr>
                            <th>Stock</th>
                            <td><?php echo htmlspecialchars($productDetails['stock']); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-danger" role="alert">
                Product not found.
            </div>
        <?php endif; ?>
    </div>
</body>

</html>
