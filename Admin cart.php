<?php include('partials-font/menu.php'); ?>

<!-- Food Search Section -->
<section class="food-search text-center">
    <div class="container">
        <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
            <input type="search" name="search" placeholder="Search for Food.." required>
            <input type="submit" name="submit" value="Search" class="btn btn-primary">
        </form>
    </div>
</section>

<!-- Food Filter Section (Button Style) -->
<section class="food-filter text-center">
    <div class="container">
        <form action="" method="POST">
            <button type="submit" name="category" value="" class="btn btn-secondary">All</button>
            <button type="submit" name="category" value="Dessert" class="btn btn-secondary">Desserts</button>
            <button type="submit" name="category" value="Cakes" class="btn btn-secondary">Cakes</button>
            <button type="submit" name="category" value="Pastries" class="btn btn-secondary">Pastries</button>
        </form>
    </div>
</section>

<!-- Food Menu Section -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Sweet Menu</h2>

        <?php 
            include('config.php');

            $sql2 = "SELECT * FROM tbl_food WHERE active='Yes'";

            if(isset($_POST['category']) && $_POST['category'] != ""){
                $category = $_POST['category'];
                $sql2 .= " AND category='$category'";
            }

            $res2 = mysqli_query($conn, $sql2);
            $count2 = mysqli_num_rows($res2);

            if($count2 > 0){
                while($row = mysqli_fetch_assoc($res2)){
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $description = $row['description'];
                    $image_name = $row['image_name'];
                    $image_url = SITEURL . "images/sweet/" . $image_name;
                    ?>

                    <div class="food-menu-box">
                        <div class="food-menu-img">
                        <?php 
                            if($image_name == ""){
                                echo "<div class='error'>Image Not Available.</div>";
                            } else {
                                ?>
                                <img src="<?php echo $image_url; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">
                                <?php
                            }
                        ?>
                        </div>

                        <div class="food-menu-desc">
                            <h4><?php echo $title; ?></h4>
                            <p class="food-price">$<?php echo $price; ?></p>
                            <p class="food-detail"><?php echo $description; ?></p>
                            <br>

                            <!-- Add to Cart Button -->
                            <button class="btn btn-primary" onclick="addToCart({ title: '<?php echo $title; ?>', price: <?php echo $price; ?>, image: '<?php echo $image_url; ?>' })">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<div class='error'>Food Not Available.</div>";
            }
        ?>

        <div class="clearfix"></div>
    </div>
</section>

<?php include('partials-font/footer.php'); ?>

<!-- JavaScript for Add to Cart -->
<script>
    function addToCart(item) {
        let cart = localStorage.getItem('cart') ? JSON.parse(localStorage.getItem('cart')) : [];
        cart.push(item);
        localStorage.setItem('cart', JSON.stringify(cart));
        alert(item.title + " has been added to your cart!");
    }
</script>
