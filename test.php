<?php
// Include your database connection code
include_once 'config.php';

// Test a database query
$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);

// Print the results
while ($row = mysqli_fetch_assoc($result)) {
    echo "name: " . $row['name']."<br>","description: ". $row['description']. "<br>";
}
?>