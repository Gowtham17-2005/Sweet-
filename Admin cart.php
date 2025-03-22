<?php
// foods.php

// Database connection (replace with your DB details)
$conn = new mysqli('localhost', 'root', '', 'restaurant_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

?>


!D<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foods - Restaurant Website</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function addToCart(item) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];

            const existingItem = cart.find(cartItem => cartItem.title === item.title);
            if (existingItem) {
                existingItem.quantity++;
            } else {
                cart.push({ ...item, quantity: 1 });
            }

            localStorage.setItem('cart', JSON.stringify(cart));
        }
    </script>
</head>
<body>
    <section class="navbar">
        <div class="container">
            <div class="logo">
                <a href="index.html" title="Logo">
                    <img src="images/logo.png" alt="Restaurant Logo" class="img-responsive">
                </a>
            </div>
            <div class="menu text-right">
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="categories.html">Categories</a></li>
                    <li><a href="foods.html">Foods</a></li>
                    <li><a href="cart.html">Cart</a></li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
    </section>

    <!-- Food Menu Section -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="food-menu-box">
                    <div class="food-menu-img">
                        <img src="images/<?php echo $row['image']; ?>" alt="<?php echo $row['title']; ?>" class="img-responsive img-curve">
                    </div>

                    <div class="food-menu-desc">
                        <h4><?php echo $row['title']; ?></h4>
                        <p class="food-price">$<?php echo number_format($row['price'], 2); ?></p>
                        <p class="food-detail"><?php echo $row['description']; ?></p>
                        <br>
                        <button class="btn btn-primary" onclick="addToCart({ title: '<?php echo $row['title']; ?>', price: <?php echo $row['price']; ?>, image: 'images/<?php echo $row['image']; ?>' })">Add to Cart</button>
                    </div>
                </div>
            <?php endwhile; ?>

        </div>
    </section>

    <section class="footer">
        <div class="container text-center">
            <p>All rights reserved. Designed By <a href="#">Your Name</a></p>
        </div>
    </section>
</body>
</html>

<?php
$conn->close();
?>


.........................................................................................…..

database connection 
<?php
// admin.php

// Database connection (replace with your DB details)
$conn = new mysqli('localhost', 'root', '', 'restaurant_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle add, edit, delete actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        // Add product
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $image = $_FILES['image']['name'];
        
        // Upload image
        move_uploaded_file($_FILES['image']['tmp_name'], 'images/' . $image);

        $sql = "INSERT INTO products (title, description, price, image) VALUES ('$title', '$description', '$price', '$image')";
        $conn->query($sql);
    }

    if (isset($_POST['edit'])) {
        // Edit product
        $id = $_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $image = $_FILES['image']['name'];
        
        // Upload image if new image is provided
        if ($image) {
            move_uploaded_file($_FILES['image']['tmp_name'], 'images/' . $image);
            $imageQuery = ", image = '$image'";
        } else {
            $imageQuery = '';
        }

        $sql = "UPDATE products SET title = '$title', description = '$description', price = '$price' $imageQuery WHERE id = '$id'";
        $conn->query($sql);
    }

    if (isset($_POST['delete'])) {
        // Delete product
        $id = $_POST['id'];
        $sql = "DELETE FROM products WHERE id = '$id'";
        $conn->query($sql);
    }
}

// Fetch products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Products</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <section class="navbar">
        <div class="container">
            <div class="logo">
                <a href="index.html" title="Logo">
                    <img src="images/logo.png" alt="Restaurant Logo" class="img-responsive">
                </a>
            </div>
            <div class="menu text-right">
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="categories.html">Categories</a></li>
                    <li><a href="foods.html">Foods</a></li>
                    <li><a href="cart.html">Cart</a></li>
                    <li><a href="admin.php">Admin</a></li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
    </section>

    <!-- Admin Section -->
    <section class="admin-section">
        <div class="container">
            <h2 class="text-center">Admin - Manage Products</h2>
            
            <h3>Add New Product</h3>
            <form method="POST" enctype="multipart/form-data">
                <label for="title">Title</label>
                <input type="text" name="title" required><br>

                <label for="description">Description</label>
                <textarea name="description" required></textarea><br>

                <label for="price">Price</label>
                <input type="number" name="price" required><br>

                <label for="image">Image</label>
                <input type="file" name="image" required><br>

                <button type="submit" name="add">Add Product</button>
            </form>
            
            <h3>Edit/Delete Products</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td>$<?php echo number_format($row['price'], 2); ?></td>
                        <td><img src="images/<?php echo $row['image']; ?>" alt="<?php echo $row['title']; ?>" width="50"></td>
                        <td>
                            <!-- Edit Product Form -->
                            <form method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <input type="text" name="title" value="<?php echo $row['title']; ?>" required><br>
                                <textarea name="description" required><?php echo $row['description']; ?></textarea><br>
                                <input type="number" name="price" value="<?php echo $row['price']; ?>" required><br>
                                <input type="file" name="image"><br>
                                <button type="submit" name="edit">Edit</button>
                            </form>
                            <!-- Delete Product -->
                            <form method="POST">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </section>

    <section class="footer">
        <div class="container text-center">
            <p>All rights reserved. Designed By <a href="#">Your Name</a></p>
        </div>
    </section>
</body>
</html>

<?php
$conn->close();
?>


