<?php
include_once("config.php");

if(!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

if(isset($_POST['update'])) {
    $product_name = $_POST['product_name'];
    $product_category = $_POST['product_category'];
    $description = $_POST['description'];
    $stats = $_POST['stats'];
    $price = $_POST['price'];
    $image_url = $_POST['image_url'];
    
    $errors = array();
    
    if(empty($product_name)) {
        $errors[] = "Product name cannot be empty";
    }
    
    if(empty($product_category)) {
        $errors[] = "Category cannot be empty";
    }
    
    if(empty($stats)) {
        $errors[] = "Status cannot be empty";
    }
    
    if(empty($price)) {
        $errors[] = "Price cannot be empty";
    } elseif(!is_numeric($price) || $price < 0) {
        $errors[] = "Price must be a valid positive number";
    }
    
    if(empty($errors)) {
        $result = mysqli_query($conn, "UPDATE product SET 
                                       product_name='$product_name', 
                                       product_category='$product_category', 
                                       description='$description', 
                                       stats='$stats', 
                                       price='$price',
                                       image_url='$image_url'
                                       WHERE id_product='$id'");
        
        if($result) {
            $success_message = "Product updated successfully!";
        } else {
            $error_message = "Error: " . mysqli_error($conn);
        }
    }
}

$result = mysqli_query($conn, "SELECT * FROM product WHERE id_product='$id'");

if(mysqli_num_rows($result) == 0) {
    header("Location: index.php");
    exit();
}

$row = mysqli_fetch_assoc($result);
$product_name = $row['product_name'];
$product_category = $row['product_category'];
$description = $row['description'];
$stats = $row['stats'];
$price = $row['price'];
$image_url = $row['image_url'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .header {
            background-color: white;
            padding: 15px 30px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo img {
            height: 40px;
            width: auto;
        }

        .nav-menu {
            display: flex;
            gap: 30px;
        }

        .nav-menu a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            padding: 8px 0;
        }

        .nav-menu a:hover {
            color: #ff4444;
        }

        .nav-menu a.active {
            color: #ff4444;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .welcome-title {
            font-size: 24px;
            color: #333;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .edit-icon {
            color: #4CAF50;
            font-size: 20px;
        }

        /* Message Styles */
        .message {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .message ul {
            margin: 0;
            padding-left: 20px;
        }

        .form-container {
            background-color: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            font-family: Arial, sans-serif;
            transition: border-color 0.3s ease;
            background-color: #fafafa;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #4CAF50;
            background-color: white;
        }

        .form-group textarea {
            min-height: 80px;
            resize: vertical;
        }

        .form-group select {
            cursor: pointer;
        }

        .form-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            min-width: 120px;
            text-align: center;
        }

        .btn-primary {
            background-color: #4CAF50;
            color: white;
        }

        .btn-primary:hover {
            background-color: #45a049;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
        }

        .required {
            color: #dc3545;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .image-preview {
            margin-top: 10px;
            text-align: center;
        }

        .image-preview img {
            max-width: 150px;
            max-height: 150px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #e0e0e0;
        }

        .current-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #4CAF50;
        }

        .current-info h3 {
            color: #333;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .current-info p {
            color: #666;
            margin: 5px 0;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .nav-menu {
                flex-wrap: wrap;
                justify-content: center;
                gap: 20px;
            }

            .container {
                margin: 20px auto;
                padding: 0 15px;
            }

            .form-container {
                padding: 20px;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .form-buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 200px;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo">
            <img src="sechand_logo.png" alt="SecHand Logo" />
        </div>
        <nav class="nav-menu">
            <a href="index.php">Home</a>
            <a href="#category">Category</a>
            <a href="create.php">Add</a>
            <a href="delete.php">Delete</a>
            <a href="edit.php" class="active">Edit</a>
        </nav>
    </header>

    <div class="container">
        <h1 class="welcome-title">Hello Admin, welcome to edit page <span class="edit-icon">✏️</span></h1>
        
        <?php
        if(isset($success_message)) {
            echo "<div class='message success'>";
            echo $success_message . " <a href='index.php'>View All Products</a>";
            echo "</div>";
        }
        
        if(isset($error_message)) {
            echo "<div class='message error'>";
            echo $error_message;
            echo "</div>";
        }
        
        if(isset($errors) && !empty($errors)) {
            echo "<div class='message error'>";
            echo "<ul>";
            foreach($errors as $error) {
                echo "<li>$error</li>";
            }
            echo "</ul>";
            echo "</div>";
        }
        ?>

        <div class="current-info">
            <h3>Currently Editing: <?php echo htmlspecialchars($product_name); ?></h3>
            <p><strong>Product ID:</strong> <?php echo htmlspecialchars($id); ?></p>
            <p><strong>Current Status:</strong> <?php echo htmlspecialchars($stats); ?></p>
            <p><strong>Current Price:</strong> $<?php echo number_format($price, 2); ?></p>
        </div>

        <div class="form-container">
            <form action="edit.php?id=<?php echo $id; ?>" method="post">
                
                <div class="form-group">
                    <label for="product_name">Product Name <span class="required">*</span></label>
                    <input type="text" id="product_name" name="product_name" 
                           value="<?php echo htmlspecialchars($product_name); ?>" required>
                </div>

                <div class="form-group">
                    <label for="product_category">Category <span class="required">*</span></label>
                    <input type="text" id="product_category" name="product_category" 
                           value="<?php echo htmlspecialchars($product_category); ?>" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" 
                              placeholder="Enter product description..."><?php echo htmlspecialchars($description); ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="stats">Status <span class="required">*</span></label>
                        <select id="stats" name="stats" required>
                            <option value="">Select Status</option>
                            <option value="Available" <?php echo ($stats == 'Available') ? 'selected' : ''; ?>>Available</option>
                            <option value="Sold" <?php echo ($stats == 'Sold') ? 'selected' : ''; ?>>Sold</option>
                            <option value="Pending" <?php echo ($stats == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="price">Price <span class="required">*</span></label>
                        <input type="number" id="price" name="price" step="0.01" min="0" 
                               value="<?php echo htmlspecialchars($price); ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="image_url">Picture URL</label>
                    <input type="url" id="image_url" name="image_url" 
                           value="<?php echo htmlspecialchars($image_url); ?>"
                           placeholder="https://example.com/image.jpg">
                    
                    <?php if (!empty($image_url)): ?>
                        <div class="image-preview">
                            <img src="<?php echo htmlspecialchars($image_url); ?>" 
                                 alt="Current Product Image" 
                                 onerror="this.style.display='none'">
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-buttons">
                    <input type="submit" name="update" value="Confirm" class="btn btn-primary">
                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const currentPage = window.location.pathname.split('/').pop();
            const navLinks = document.querySelectorAll('.nav-menu a');
            
            navLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href.includes('edit') || currentPage === 'edit.php') {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });

            const imageUrlInput = document.getElementById('image_url');
            const imagePreview = document.querySelector('.image-preview img');
            
            if (imageUrlInput && imagePreview) {
                imageUrlInput.addEventListener('input', function() {
                    if (this.value) {
                        imagePreview.src = this.value;
                        imagePreview.style.display = 'block';
                    }
                });
            }
        });
    </script>
</body>
</html>

<?php
mysqli_close($conn);
?>