<?php

include "config.php";
include "auth.php";

requireCustomer();


$search = "";

if (isset($_GET["search"])) {

    $search = trim($_GET["search"]);

}


if ($search !== "") {

    $term = "%" . $search . "%";


    $stmt = $conn->prepare(
        "SELECT *
         FROM products
         WHERE
            name LIKE ?
            OR category LIKE ?
            OR description LIKE ?
         ORDER BY id DESC"
    );


    $stmt->bind_param(
        "sss",
        $term,
        $term,
        $term
    );


    $stmt->execute();

    $products = $stmt->get_result();

} else {

    $products = $conn->query(
        "SELECT *
         FROM products
         ORDER BY id DESC"
    );

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Yazzea - Shop</title>

<link rel="stylesheet" href="style.css">

</head>

<body>

<nav class="navbar">

<div class="brand">
    Yazzea
</div>


<div class="nav-right">

<span>
    Welcome,
    <?php
    echo htmlspecialchars(
        $_SESSION["fullname"]
    );
    ?>
</span>


<a
    href="my_orders.php"
    class="orders-button"
>
    My Orders
</a>


<a
    href="logout.php"
    class="logout"
>
    Logout
</a>

</div>

</nav>


<main class="container">


<div class="page-header">

<div>

<h1>
    Yazzea Shop
</h1>

<p>
    Choose your favorite products.
</p>

</div>

</div>


<form
    method="GET"
    class="search-box"
>

<input
    type="text"
    name="search"
    placeholder="Search products..."
    value="<?php
    echo htmlspecialchars($search);
    ?>"
>

<button type="submit">
    Search
</button>


<?php if ($search !== ""): ?>

<a
    href="shop.php"
    class="clear-button"
>
    Clear
</a>

<?php endif; ?>

</form>


<div class="product-grid">

<?php if ($products->num_rows > 0): ?>


<?php while ($product = $products->fetch_assoc()): ?>


<div class="product-card">


<div class="product-icon">
    🛍️
</div>


<span class="category">

<?php
echo htmlspecialchars(
    $product["category"]
);
?>

</span>


<h2>

<?php
echo htmlspecialchars(
    $product["name"]
);
?>

</h2>


<p class="product-description">

<?php
echo htmlspecialchars(
    $product["description"]
);
?>

</p>


<div class="product-bottom">

<strong class="price">

₱<?php
echo number_format(
    $product["price"],
    2
);
?>

</strong>


<span class="stock">

<?php

if ($product["quantity"] > 0) {

    echo $product["quantity"] .
        " available";

} else {

    echo "Out of stock";

}

?>

</span>

</div>


<?php if ($product["quantity"] > 0): ?>


<form
    action="buy.php"
    method="POST"
    class="buy-form"
>

<input
    type="hidden"
    name="product_id"
    value="<?php
    echo $product["id"];
    ?>"
>


<label>
    Quantity
</label>


<input
    type="number"
    name="quantity"
    min="1"
    max="<?php
    echo $product["quantity"];
    ?>"
    value="1"
    required
>


<button
    type="submit"
    class="buy-button"
>
    🛒 Buy Now
</button>

</form>


<?php else: ?>


<button
    class="buy-button disabled"
    disabled
>
    Out of Stock
</button>


<?php endif; ?>


</div>


<?php endwhile; ?>


<?php else: ?>


<div class="no-products">

<h2>
    No products found
</h2>

<p>
    Try searching for another product.
</p>

</div>


<?php endif; ?>

</div>

</main>

</body>
</html>