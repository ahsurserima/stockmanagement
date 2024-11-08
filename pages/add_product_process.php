<?php
include '../includes/config.php';

$name = $_POST['name'];
$description = $_POST['description'];
$category_id = $_POST['category_id'];
$buying_price = $_POST['buying_price'];
$selling_price = $_POST['selling_price'];
$quantity = $_POST['quantity'];

// Handle file upload
$image_filename = '';
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $target_dir = "../images/";
    $image_filename = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $image_filename;

    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $image_filename = ''; // Set to an empty string if upload fails
    }
}

// Insert product into the database
$sql = "INSERT INTO Products (name, description, category_id, buying_price, selling_price, quantity, image)
        VALUES ('$name', '$description', '$category_id', '$buying_price', '$selling_price', '$quantity', '$image_filename')";

if ($conn->query($sql) === TRUE) {
    $product_id = $conn->insert_id; // Get the last inserted product ID

    // Insert variations into the database
    if (!empty($_POST['color'])) {
        for ($i = 0; $i < count($_POST['color']); $i++) {
            $color = $_POST['color'][$i];
            $size = $_POST['size'][$i];
            $subname = $_POST['subname'][$i];
            $variation_quantity = $_POST['variation_quantity'][$i];

            $sql_variation = "INSERT INTO productvariations (product_id, color, size, subname, quantity)
                              VALUES ('$product_id', '$color', '$size', '$subname', '$variation_quantity')";
            $conn->query($sql_variation);
        }
    }

    // Redirect to a success page
    header("Location: main.php");
    exit();

} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>
