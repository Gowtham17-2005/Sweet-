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
