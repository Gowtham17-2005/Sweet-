
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Restaurant Website</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function displayCart() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const cartContainer = document.getElementById('cart-items');
            const totalPriceContainer = document.getElementById('total-price');

            cartContainer.innerHTML = '';
            let totalPrice = 0;

            cart.forEach((item, index) => {
                const cartItem = document.createElement('div');
                cartItem.classList.add('cart-item');

                // Calculate the price based on quantity and weight
                const itemPrice = item.price * item.quantity * (item.weight / 250); // Assuming 250g is the base weight

                cartItem.innerHTML = `
                    <div class="cart-item-img">
                        <img src="${item.image}" alt="${item.title}" class="img-responsive img-curve">
                    </div>
                    <div class="cart-item-desc">
                        <h4>${item.title}</h4>
                        <p class="food-price">$${itemPrice.toFixed(2)}</p>
                    </div>
                    <div class="cart-item-quantity">
                        <button class="btn btn-secondary" onclick="updateQuantity(${index}, 'decrease')">-</button>
                        <span id="quantity-${index}">${item.quantity}</span>
                        <button class="btn btn-secondary" onclick="updateQuantity(${index}, 'increase')">+</button>
                    </div>
                    <div class="cart-item-weight">
                        <label for="weight-${index}">Weight:</label>
                        <select id="weight-${index}" onchange="updateWeight(${index})">
                            <option value="250" ${item.weight === 250 ? 'selected' : ''}>250g</option>
                            <option value="500" ${item.weight === 500 ? 'selected' : ''}>500g</option>
                            <option value="1000" ${item.weight === 1000 ? 'selected' : ''}>1kg</option>
                        </select>
                    </div>
                    <div class="cart-item-remove">
                        <button class="btn btn-danger" onclick="removeFromCart(${index})">Remove</button>
                    </div>
                `;

                cartContainer.appendChild(cartItem);
                totalPrice += itemPrice; // Add the calculated price to the total
            });

            totalPriceContainer.textContent = '$' + totalPrice.toFixed(2);
        }

        function updateQuantity(index, action) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];

            if (action === 'increase') {
                cart[index].quantity++;
            } else if (action === 'decrease' && cart[index].quantity > 1) {
                cart[index].quantity--;
            }

            localStorage.setItem('cart', JSON.stringify(cart));
            displayCart();
        }

        function updateWeight(index) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            const weight = document.getElementById(`weight-${index}`).value;

            cart[index].weight = parseInt(weight);
            localStorage.setItem('cart', JSON.stringify(cart));
            displayCart();
        }

        function removeFromCart(index) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart.splice(index, 1);
            localStorage.setItem('cart', JSON.stringify(cart));
            displayCart();
        }

        function placeOrder() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const totalPrice = cart.reduce((acc, item) => acc + item.price * item.quantity * (item.weight / 250), 0); // Calculate total price based on quantity and weight
            localStorage.setItem('order', JSON.stringify({ cart, totalPrice }));
            window.location.href = 'order.html';  // Redirect to the order page
        }

        window.onload = displayCart;
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
        </div>
    </section>

    
    <section class="cart">
        <div class="container">
            <h2 class="text-center">Your Cart</h2>
            <div id="cart-items"></div>
            <div class="total-price">
                <h3>Total: <span id="total-price">$0.00</span></h3>
            </div>
            <div class="cart-buttons">
                <button class="btn btn-primary" onclick="window.location.href='checkout.html'">Checkout</button>
                <button class="btn btn-success" onclick="placeOrder()">Place Order</button>
            </div>
        </div>
    </section>

    
    <section class="footer">
        <div class="container text-center">
            <p>All rights reserved. Designed By <a href="#">Your Name</a></p>
        </div>
    </section>
</body>
</html>


…..............................................

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order - Restaurant Website</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function loadOrder() {
            const order = JSON.parse(localStorage.getItem('order'));
            if (order) {
                const cart = order.cart;
                const totalPrice = order.totalPrice;
                const orderDetailsContainer = document.getElementById('order-details');
                
                cart.forEach(item => {
                    const orderItem = document.createElement('div');
                    orderItem.classList.add('order-item');
                    orderItem.innerHTML = `
                        <h4>${item.title}</h4>
                        <p>Price: $${item.price.toFixed(2)}</p>
                        <p>Quantity: ${item.quantity}</p>
                        <p>Weight: ${item.weight}g</p>
                    `;
                    orderDetailsContainer.appendChild(orderItem);
                });

                document.getElementById('order-total-price').textContent = '$' + totalPrice.toFixed(2);
            }
        }

        window.onload = loadOrder;
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

    <!-- Order Section -->
    <section class="order">
        <div class="container">
            <h2 class="text-center">Order Summary</h2>

            <div id="order-details"></div>

            <div class="total-price">
                <h3>Total: <span id="order-total-price">$0.00</span></h3>
            </div>

            <h3>Enter Your Details</h3>
            <form action="submit_order.html" method="POST">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>
                
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" required>
                
                <input type="hidden" name="cart" id="cart">
                <input type="hidden" name="totalPrice" id="totalPrice">
                
                <button type="submit" class="btn btn-primary">Submit Order</button>
            </form>
        </div>
    </section>

    <!-- Footer Section -->
    <section class="footer">
        <div class="container text-center">
            <p>All rights reserved. Designed By <a href="#">Your Name</a></p>
        </div>
    </section>

    <script>
        document.querySelector('form').onsubmit = function() {
            const order = JSON.parse(localStorage.getItem('order'));
            if (order) {
                document.getElementById('cart').value = JSON.stringify(order.cart);
                document.getElementById('totalPrice').value = order.totalPrice.toFixed(2);
            }
        };
    </script>
</body>
</html>
....................................................
order php 


<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "restaurant"; 

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $cart = $_POST['cart']; // JSON string
    $totalPrice = $_POST['totalPrice'];

    
    $sql = "INSERT INTO orders (name, address, phone, cart, totalPrice) 
            VALUES ('$name', '$address', '$phone', '$cart', '$totalPrice')";

    
    if ($conn->query($sql) === TRUE) {
        echo "Order submitted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>

....................,.................................


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .contact-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .contact-info {
            list-style-type: none;
            padding: 0;
        }
        .contact-info li {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .contact-info li i {
            font-size: 20px;
            margin-right: 10px;
            color: #4CAF50;
        }
        .contact-info li span {
            font-size: 16px;
            color: #333;
        }
        .contact-info li a {
            color: #333;
            text-decoration: none;
        }
        .contact-form {
            margin-top: 30px;
        }
        .contact-form label {
            display: block;
            margin-bottom: 10px;
            color: #333;
        }
        .contact-form input, .contact-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .contact-form button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .contact-form button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <div class="contact-container">
        <h2>Contact Us</h2>
        <ul class="contact-info">
            <li><i class="fas fa-map-marker-alt"></i><span>Location: Srivi Busstand, Opposite</span></li>
            <li><i class="fas fa-phone-alt"></i><span>Phone: <a href="tel:+91234567890">1234567890</a></span></li>
            <li><i class="fas fa-envelope"></i><span>Email: <a href="mailto:BombaySweets@gmail.com">BombaySweets@gmail.com</a></span></li>
        </ul>

        <div class="contact-form">
            <h3>Send us a Message</h3>
            <form action="your-server-side-script.php" method="POST">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Your Email</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Your Message</label>
                <textarea id="message" name="message" rows="4" required></textarea>

                <button type="submit">Send Message</button>
            </form>
        </div>
    </div>

</body>
</html>
................................................................
contact php

<?php
// Database connection
$servername = "localhost";
$username = "root";  
$password = "";      
$dbname = "contact_form";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    
    if (empty($name) || empty($email) || empty($message)) {
        die("All fields are required.");
    }

    
    $stmt = $conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

  
    if ($stmt->execute()) {
        echo "Message sent successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
