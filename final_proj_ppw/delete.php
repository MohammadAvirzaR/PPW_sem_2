<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Products</title>
    
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
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .search-section {
            margin-bottom: 40px;
        }

        .search-container {
            position: relative;
            max-width: 600px;
        }

        .search-input {
            width: 100%;
            padding: 12px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 25px;
            font-size: 16px;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .search-input:focus {
            border-color: #dc3545;
        }

        .search-btn {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .search-btn:hover {
            background-color: #c82333;
        }

        .welcome-title {
            font-size: 24px;
            color: #333;
            margin-bottom: 30px;
        }

        .data-table {
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            background-color: #f8f9fa;
            padding: 15px 20px;
            text-align: left;
            font-weight: 600;
            color: #333;
            border-bottom: 1px solid #e0e0e0;
            font-size: 14px;
        }

        .table td {
            padding: 15px 20px;
            border-bottom: 1px solid #f0f0f0;
            color: #666;
            vertical-align: middle;
        }

        .table tr:hover {
            background-color: #f8f9fa;
        }

        .table tr:nth-child(even) {
            background-color: #fafafa;
        }

        .table tr:nth-child(even):hover {
            background-color: #f0f0f0;
        }

        .no-data {
            text-align: center;
            font-style: italic;
            color: #999;
        }

        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 500;
            text-transform: uppercase;
        }

        .status-available {
            background-color: #d4edda;
            color: #155724;
        }

        .status-sold {
            background-color: #f8d7da;
            color: #721c24;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .delete-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: all 0.3s ease;
        }

        .delete-btn:hover {
            background-color: #c82333;
            transform: scale(1.05);
        }

        .trash-icon {
            width: 16px;
            height: 16px;
        }

        /* Alert/Notification Styles */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .alert-warning {
            color: #856404;
            background-color: #fff3cd;
            border-color: #ffeaa7;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
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

            .table-container {
                overflow-x: auto;
            }

            .table th,
            .table td {
                padding: 10px 8px;
                font-size: 12px;
            }

            .table th:nth-child(4),
            .table td:nth-child(4) {
                display: none; 
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
            <a href="delete.php" class="active">Delete</a>
            <a href="edit.php">Edit</a>
        </nav>
    </header>

    <div class="container">
        <?php
        session_start();
        if(isset($_SESSION['message'])) {
            $message_class = '';
            switch($_SESSION['message_type']) {
                case 'success': $message_class = 'alert-success'; break;
                case 'warning': $message_class = 'alert-warning'; break;
                case 'error': $message_class = 'alert-danger'; break;
            }
            echo '<div class="alert ' . $message_class . '">' . $_SESSION['message'] . '</div>';
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
        }
        ?>

        <div class="search-section">
            <div class="search-container">
                <form method="GET" action="delete.php">
                    <input type="text" class="search-input" name="search" placeholder="Search products to delete..." 
                           value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    <button type="submit" class="search-btn">find</button>
                </form>
            </div>
        </div>

        <h1 class="welcome-title">Hello Admin, welcome to delete page</h1>

        <div class="data-table">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Product ID</th>
                            <th>Category</th>
                            <th>Picture</th>
                            <th>Status</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include_once("config.php");
                        
                        $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
                        
                        if (!empty($search)) {
                            $query = "SELECT * FROM product WHERE 
                                     product_name LIKE '%$search%' OR 
                                     product_category LIKE '%$search%' OR 
                                     stats LIKE '%$search%' 
                                     ORDER BY id_product DESC";
                        } else {
                            $query = "SELECT * FROM product ORDER BY id_product DESC";
                        }
                        
                        $result = mysqli_query($conn, $query);
                        
                        if ($result && mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['id_product']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['product_category']) . "</td>";
                                
                                if (!empty($row['image_url'])) {
                                    echo "<td><img src='" . htmlspecialchars($row['image_url']) . "' alt='Product Image' class='product-image' onerror='this.src=\"placeholder.jpg\"'></td>";
                                } else {
                                    echo "<td>No Image</td>";
                                }
                                
                                $statusClass = 'status-' . strtolower($row['stats']);
                                echo "<td><span class='status-badge $statusClass'>" . htmlspecialchars($row['stats']) . "</span></td>";
                                
                                echo "<td>$" . number_format($row['price'], 2) . "</td>";
                                
                                echo "<td>";
                                echo "<button class='delete-btn' onclick='confirmDelete(" . $row['id_product'] . ", \"" . htmlspecialchars($row['product_name'], ENT_QUOTES) . "\")'>";
                                echo "<svg class='trash-icon' fill='currentColor' viewBox='0 0 20 20'>";
                                echo "<path fill-rule='evenodd' d='M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z' clip-rule='evenodd'></path>";
                                echo "</svg>";
                                echo "</button>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            if (!empty($search)) {
                                echo "<tr><td colspan='7' class='no-data'>No products found matching '$search'</td></tr>";
                            } else {
                                echo "<tr><td colspan='7' class='no-data'>No products available</td></tr>";
                            }
                        }
                        
                        mysqli_close($conn);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(productId, productName) {
            if (confirm('Apakah kamu yakin mau menghapus produk "' + productName + '"?')) {
                // Redirect to your delete script
                window.location.href = 'process_delete.php?id=' + productId;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const currentPage = window.location.pathname.split('/').pop();
            const navLinks = document.querySelectorAll('.nav-menu a');
            
            navLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href === currentPage || (currentPage === 'delete.php' && href === 'delete.php')) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>