<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    
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
            border-color: #4CAF50;
        }

        .search-btn {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .search-btn:hover {
            background-color: #45a049;
        }

        .welcome-title {
            font-size: 24px;
            color: #333;
            margin-bottom: 30px;
        }

        .action-buttons {
            display: flex;
            gap: 20px;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }

        .action-btn {
            background-color: #4CAF50;
            color: white;
            padding: 20px 40px;
            border: none;
            border-radius: 12px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            min-width: 120px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .action-btn:hover {
            background-color: #45a049;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
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

        .empty-row {
            height: 80px;
        }

        .no-data {
            text-align: center;
            font-style: italic;
            color: #999;
        }

        .btn {
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
            margin-right: 5px;
            transition: all 0.3s ease;
        }

        .btn-edit {
            background-color: #007bff;
            color: white;
        }

        .btn-edit:hover {
            background-color: #0056b3;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background-color: #c82333;
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

            .action-buttons {
                justify-content: center;
            }

            .action-btn {
                flex: 1;
                min-width: 100px;
                max-width: 150px;
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

        @media (max-width: 480px) {
            .action-buttons {
                flex-direction: column;
            }

            .action-btn {
                max-width: none;
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
            <a href="index.php" class="active">Home</a>
            <a href="#category">Category</a>
            <a href="create.php">Add</a>
            <a href="delete.php">Delete</a>
            <a href="edit.php">Edit</a>
        </nav>
    </header>

    <div class="container">
        <div class="search-section">
            <div class="search-container">
                <form method="GET" action="index.php">
                    <input type="text" class="search-input" name="search" placeholder="Search products..." 
                           value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    <button type="submit" class="search-btn">find</button>
                </form>
            </div>
        </div>

        <h1 class="welcome-title">Hello Admin, what you are gonna do</h1>
        
        <div class="action-buttons">
            <a href="create.php" class="action-btn">Add</a>
            <a href="delete.php" class="action-btn">Delete</a>
            <a href="edit.php" class="action-btn">Edit</a>
        </div>

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
                            <th>Actions</th>
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
                                echo "<a href='edit.php?id=" . $row['id_product'] . "' class='btn btn-edit'>Edit</a>";
                                echo "<a href='delete.php?id=" . $row['id_product'] . "' class='btn btn-delete' onclick='return confirm(\"Are you sure you want to delete this product?\")'>Delete</a>";
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
        document.addEventListener('DOMContentLoaded', function() {
            const currentPage = window.location.pathname.split('/').pop();
            const navLinks = document.querySelectorAll('.nav-menu a');
            
            navLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href === currentPage || (currentPage === '' && href === 'index.php')) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>