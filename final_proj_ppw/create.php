<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Add Product</title>
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

        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .page-title {
            font-size: 24px;
            color: #333;
            margin-bottom: 40px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #ff4444;
        }

        .form-textarea {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            min-height: 80px;
            resize: vertical;
            font-family: Arial, sans-serif;
            transition: border-color 0.3s ease;
        }

        .form-textarea:focus {
            outline: none;
            border-color: #ff4444;
        }

        .submit-btn {
            background-color: #4CAF50;
            color: white;
            padding: 12px 40px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            float: right;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #45a049;
        }

        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-weight: 500;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert ul {
            margin: 0;
            padding-left: 20px;
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
                margin: 20px;
                padding: 30px 20px;
            }

            .submit-btn {
                float: none;
                width: 100%;
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
            <a href="#delete">Delete</a>
            <a href="#edit">Edit</a>
        </nav>
    </header>

<?php
include_once("config.php");

if(isset($_POST['submit'])) {
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $stats = mysqli_real_escape_string($conn, $_POST['stats']);
    $product_description = mysqli_real_escape_string($conn, $_POST['product_description']);
    $product_category = mysqli_real_escape_string($conn, $_POST['product_category']);
    $image_url = mysqli_real_escape_string($conn, $_POST['image_url']);
    
    $errors = array();
    
    if(empty($product_name)) {
        $errors[] = "Product name cannot be empty";
    }
    
    if(empty($price)) {
        $errors[] = "Product price cannot be empty";
    } elseif(!is_numeric($price) || $price <= 0) {
        $errors[] = "Product price must be a valid positive number";
    }
    
    if(empty($stats)) {
        $errors[] = "Product status cannot be empty";
    }
    
    if(empty($product_description)) {
        $errors[] = "Product description cannot be empty";
    }
    
    if(empty($product_category)) {
        $errors[] = "Product category cannot be empty";
    }
    
    if(empty($image_url)) {
        $errors[] = "Product image URL cannot be empty";
    }
    
    if(empty($errors)) {
        $result = mysqli_query($conn, "INSERT INTO product(product_name, price, stats, product_description, product_category, image_url) 
                                       VALUES('$product_name', '$price', '$stats', '$product_description', '$product_category', '$image_url')");
        
        if($result) {
            echo "<div class='alert alert-success'>";
            echo "Product successfully added! <a href='index.php'>View Products</a>";
            echo "</div>";
        } else {
            echo "<div class='alert alert-error'>";
            echo "Error: " . mysqli_error($conn);
            echo "</div>";
        }
    } else {
        echo "<div class='alert alert-error'>";
        echo "<ul>";
        foreach($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
        echo "</div>";
    }
}
?>

    <div class="container">
        <h1 class="page-title">Hello Admin, welcome to add page</h1>
        
        <form action="create.php" method="post">
            <div class="form-group">
                <label for="product_name" class="form-label">Product Name</label>
                <input type="text" id="product_name" name="product_name" class="form-input" 
                       value="<?php echo isset($_POST['product_name']) ? htmlspecialchars($_POST['product_name']) : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="product_category" class="form-label">Category</label>
                <input type="text" id="product_category" name="product_category" class="form-input" 
                       value="<?php echo isset($_POST['product_category']) ? htmlspecialchars($_POST['product_category']) : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="product_description" class="form-label">Description</label>
                <textarea id="product_description" name="product_description" class="form-textarea" required><?php echo isset($_POST['product_description']) ? htmlspecialchars($_POST['product_description']) : ''; ?></textarea>
            </div>

            <div class="form-group">
                <label for="stats" class="form-label">Status</label>
                <select id="stats" name="stats" class="form-input" required>
                    <option value="">Select Status</option>
                    <option value="available" <?php echo (isset($_POST['stats']) && $_POST['stats'] == 'available') ? 'selected' : ''; ?>>Available</option>
                    <option value="sold" <?php echo (isset($_POST['stats']) && $_POST['stats'] == 'sold') ? 'selected' : ''; ?>>Sold</option>
                    <option value="pending" <?php echo (isset($_POST['stats']) && $_POST['stats'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                </select>
            </div>

            <div class="form-group">
                <label for="price" class="form-label">Price</label>
                <input type="number" id="price" name="price" class="form-input" step="0.01" min="0" 
                       value="<?php echo isset($_POST['price']) ? htmlspecialchars($_POST['price']) : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="image_url" class="form-label">Picture URL</label>
                <input type="url" id="image_url" name="image_url" class="form-input" 
                       placeholder="https://example.com/image.jpg"
                       value="<?php echo isset($_POST['image_url']) ? htmlspecialchars($_POST['image_url']) : ''; ?>" required>
            </div>

            <div class="clearfix">
                <button type="submit" name="submit" class="submit-btn">Add</button>
            </div>
        </form>
    </div>
</body>
</html>