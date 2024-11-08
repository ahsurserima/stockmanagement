<?php
include '../includes/config.php';

// Fetch products and categories from the database
$sql_products = "SELECT * FROM Products";
$result_products = $conn->query($sql_products);
$sql_categories = "SELECT * FROM Categories";
$result_categories = $conn->query($sql_categories);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Products</title>
    <link rel="stylesheet" href="../frameworks/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../frameworks/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../frameworks/bootstrap/js/bootstrap.min.js"></script>
    <script src="../frameworks/fontawesome/js/all.min.js"></script>
    <script src="../frameworks/gsap/minified/gsap.min.js"></script>
    <script src="../frameworks/gsap/minified/gsap.plugins.min.js"></script>
    <script src="../frameworks/foundation/js/foundation.min.js"></script>

<style>
    
    /* Navbar Container Styling */
.custom-navbar {
    background-color: #2c3e50; /* Dark, professional blue-gray background */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15); /* Subtle shadow for depth */
    padding: 15px 30px; /* Padding for a spacious feel */
    border-bottom: 3px solid #2980b9; /* Accent border at the bottom */
}

/* Navbar Text Styling */
.custom-navbar .nav-text h1 {
    color: #ecf0f1; /* Light text for contrast */
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Modern, professional font */
    font-size: 24px; /* Larger font size for prominence */
    letter-spacing: 1px; /* Slight letter spacing for clarity */
    margin: 0; /* Remove default margin */
    display: flex;
    align-items: center; /* Center align icon and text */
}

.custom-navbar .nav-text h1 i {
    margin-right: 10px; /* Space between icon and text */
    color: #3498db; /* Highlight color for the icon */
}

/* Navbar Toggler Styling (for mobile view) */
.custom-navbar .navbar-toggler {
    border: none; /* Remove default border */
    outline: none; /* Remove default outline */
}

.custom-navbar .navbar-toggler-icon {
    background-color: #ecf0f1; /* Light icon color for contrast */
}

/* Navbar Collapse (Menu) Styling */
.custom-navbar .navbar-nav {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Consistent font family */
}

.custom-navbar .navbar-nav li {
    margin-right: 20px; /* Space between nav items */
    list-style-type: none; /* Remove default list style */
}

.custom-navbar .navbar-nav li a {
    color: #ecf0f1; /* Light text color for nav items */
    font-size: 16px; /* Standard font size */
    transition: color 0.3s ease-in-out; /* Smooth color transition */
    display: flex;
    align-items: center; /* Center align icon and text */
    text-decoration: none;
}

.custom-navbar .navbar-nav li a i {
    margin-right: 8px; /* Space between icon and text */
    color: #3498db; /* Highlight color for icons */
    font-size: 18px; /* Slightly larger icon size */
}

/* Navbar Hover Effect */
.custom-navbar .navbar-nav li a:hover {
    color: #3498db; /* Change text color on hover */
    text-decoration: none; /* Remove underline on hover */
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .custom-navbar {
        padding: 10px 20px; /* Adjust padding for smaller screens */
    }
    .custom-navbar .navbar-nav li {
        margin-right: 10px; /* Reduce space between nav items */
    }
    .custom-navbar .nav-text h1 {
        font-size: 20px; /* Adjust font size for smaller screens */
    }
}

body {
    background: linear-gradient(45deg, yellow, #cccccc, #f0f0f0);
    background-size: 600% 600%;
    animation: gradient 3s ease infinite;
    font-family: Arial, sans-serif;
    overflow-x: hidden;
    overflow-y: hidden;
}

@keyframes gradient {
    0% { background-position: 0% 0%; }
    50% { background-position: 100% 100%; }
    100% { background-position: 0% 0%; }
}

.sidebar {
    float: left;
    z-index: 1;
    background: linear-gradient(45deg, blue, #cccccc, #f0f0f0);
    animation: gradient 2s ease infinite;
    height: 700px;
    width: 30%; /* Adjust width to fit better */
    margin: 0 0 20px -130px; /* Simplified margins */
    border-radius: 5px;
    padding: 20px;
}

.inside-sidebar {
    background: #f0f0f0; /* Use a subtle, consistent background */
    height: 100%;
    width: 100%;
    border-radius: 10px;
}

.container {
    padding: 20px;
    margin-top: 20px; /* Use consistent margin */
    padding-top: 60px;
}

.filter-bar {
    margin-bottom: 20px;
    padding: 15px 5px;
    z-index: 1;
    margin-inline: 30px;
}

.filter-bar input {
    width: 90%;
    padding: 10px;
    border: 1px solid #ced4da;
    border-radius: 4px;
    font-size: 16px;
}

.product-card {
    margin: 20px;
    position: relative;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
    background: #fff;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    cursor: pointer;
    transition: transform 0.3s, box-shadow 0.3s;
}

.product-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.4);
}

.product-card-body {
    padding: 15px;
}

.product-card h5 {
    color: #333;
    font-size: 1.5em;
    margin-bottom: 10px;
}

.product-card h3 {
    color: #007bff;
    font-size: 1.2em;
}

.product-card img {
    width: 100%;
    height: 150px;
    object-fit: cover;
}

.card-details {
    display: none;
    padding: 15px;
    background-color: burlywood;
    border-top: 1px solid #dee2e6;
}

.product-card .expand-icon,
.product-card .close-icon {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 2em;
    cursor: pointer;
    color: blue;
}

.product-card .close-icon {
    display: none;
}

.custom-scroll {
    margin-top: -20px;
    border: 1px solid;
    border-radius: 1px;
    max-height: 530px;
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: #007bff #e9ecef;
    width: 85%;
    float: right;
    margin-inline-end: -100px;
}

.custom-scroll::-webkit-scrollbar {
    width: 4px;
}

.custom-scroll::-webkit-scrollbar-thumb {
    background-color: #007bff;
    border-radius: 2px;
}

.custom-scroll::-webkit-scrollbar-track {
    background-color: #e9ecef;
}

/* Fullscreen card styles */
.fullscreen-card {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    overflow: auto;
}

.fullscreen-card-content {
    background: #fff;
    border-radius: 15px;
    width: 80%;
    max-width: 800px;
    padding: 20px;
    position: relative;
}

.loading-ring {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    border: 8px solid #f3f3f3;
    border-radius: 50%;
    border-top: 8px solid #007bff;
    width: 50px;
    height: 50px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.fullscreen-card-content h2 {
    color: #333;
}

.fullscreen-card-content p {
    color: #666;
}

/* Responsive styles for mobile */
@media (max-width: 768px) {
    .sidebar {
        width: 100%;
        height: auto;
        margin: 0;
    }

    .inside-sidebar {
        width: 100%;
        height: auto;
        margin: 0;
        border-radius: 0;
    }

    .product-card {
        margin: 10px 0;
        flex: 1 1 100%;
    }
}

.inside-sidebar ul li {
    padding: 10px;
    background-color: gainsboro;
    border-radius: 2px;
    margin-bottom: 10px;
    transition: background-color 0.3s ease;
}

.inside-sidebar ul li:hover {
    background-color: whitesmoke;
}

h4 {
    padding: 12px 20px;
    font-size: 33px;
    margin-inline-end: -100px;
}

/* Custom Loading Ring Styling */
.custom-loading-ring {
    display: none;
    width: 30px;
    height: 30px;
    border: 6px solid #f3f3f3; /* Light gray background */
    border-radius: 50%;
    border-top: 6px solid #3498db; /* Blue top */
    animation: spin 1s linear infinite;
    position: fixed;
    top: 4%;
    left: 85%;
    transform: translate(-50%, -50%);
    z-index: 10000;
}

/* Spin Animation */
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Content Styles */
.content {
    padding: 20px;
    font-size: 1.2em;
    line-height: 1.6;
    color: #333;
}
</style>
</head>
<body>

<div class="custom-navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="custom-container">
        <div class="nav-text">
            <h1><i class="fas fa-cogs"></i> Stock Management System</h1>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                 <li><a href="#users"><i class="fas fa-user"></i> Users</a></li>
        <li><a href="#products"><i class="fas fa-box"></i> Products</a></li>
        <li><a href="#stock-entries"><i class="fas fa-warehouse"></i> Stock Entries</a></li>
        <li><a href="#sales"><i class="fas fa-chart-line"></i> Sales</a></li>
        <li><a href="#credits"><i class="fas fa-credit-card"></i> Credits</a></li>
        <li><a href="#returns"><i class="fas fa-undo-alt"></i> Returns</a></li>
        <li><a href="#notifications"><i class="fas fa-bell"></i> Notifications</a></li>
        <li><a href="#expenses"><i class="fas fa-money-bill-wave"></i> Expenses</a></li>
        <li><a href="#income-statement"><i class="fas fa-file-invoice-dollar"></i> Income Statement</a></li>
        <li><a href="#transaction-history"><i class="fas fa-history"></i> Transaction History</a></li>
            </ul>
        </div>
    </div>
</div>
<div id="custom-loading-ring" class="custom-loading-ring"></div>


    <div class="everything">
        <div class="container">
            <h4 style="color: blue; ">Products in Your Stock</h4>
            <div class="sidebar">
                <div class="filter-bar">
                    <input type="text" id="searchInput" placeholder="Search products...">
                    
                    <h3 style="font-size: 25px; color: grey; text-align:center;">Filter by Category</h3>
                    <hr>
                    <div class="inside-sidebar">
                        <ul id="categoryList" class="list-group">
                            <?php while ($category = $result_categories->fetch_assoc()) : ?>
                                <li class="list-group-item">
                                    <a href="#" class="category-filter" data-id="<?php echo htmlspecialchars($category['category_id']); ?>">
                                        <i class="fas fa-tags"></i> <?php echo htmlspecialchars($category['name']); ?>
                                    </a>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row custom-scroll" id="productContainer">
                <?php while ($row = $result_products->fetch_assoc()) : ?>
                    <div class="col-md-4">
                        <div class="product-card" data-id="<?php echo htmlspecialchars($row['product_id']); ?>" data-category-id="<?php echo htmlspecialchars($row['category_id']); ?>">
                            <img src="../images/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
                            <div class="product-card-body">
                                <h5 style="color: white; font-size: 37px; margin-block-start: -62px; text-shadow: 4px 4px 8px #333333">
                                    <b><?php echo htmlspecialchars($row['name']); ?></b>
                                </h5>
                                <h3 style="color: #007bff; font-size: 18px">Price: $<?php echo htmlspecialchars($row['selling_price']); ?></h3>
                                <h3 style="color: #007bff; font-size: 18px">Quantity: x<?php echo htmlspecialchars($row['quantity']); ?></h3>
                                <span class="expand-icon" onclick="toggleDetails(this)"><i class="fas fa-caret-down"></i></span>
                                <span class="close-icon" onclick="toggleDetails(this)" style="display: none;"><i class="fas fa-caret-up"></i></span>
                            </div>
                            <div class="card-details" style="display: none;">
                                <!-- Product details will be loaded here -->
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

        <!-- Fullscreen card modal -->
        <div id="fullscreenCard" class="fullscreen-card">
            <div class="fullscreen-card-content">
                <div class="loading-ring"></div>
                <div id="fullscreenCardContent">
                    <!-- Dynamic content will be loaded here -->
                </div>
                <span class="close-fullscreen" onclick="closeFullscreen()"><i class="fas fa-times"></i></span>
            </div>
        </div>
    </div>

    <script>

       // Show loading ring on nav link click
document.querySelectorAll('.custom-navbar .navbar-nav li a').forEach(link => {
    link.addEventListener('click', () => {
        document.querySelector('.custom-loading-ring').style.display = 'inline-block';
        setTimeout(() => {
            document.querySelector('.custom-loading-ring').style.display = 'none';
        }, 2000); // Hide after 2 seconds
    });
});




        // Function to toggle the product card details
        function toggleDetails(element) {
            const cardBody = element.closest('.product-card');
            const details = cardBody.querySelector('.card-details');
            const expandIcon = cardBody.querySelector('.expand-icon');
            const closeIcon = cardBody.querySelector('.close-icon');

            if (details.style.display === 'block') {
                // Hide the details without showing the loading ring again
                details.style.display = 'none';
                expandIcon.style.display = 'inline';
                closeIcon.style.display = 'none';
            } else {
                // Show the loading ring and then the details after 2 seconds
                details.innerHTML = "<div class='loading-ring'></div>";
                details.style.display = 'block';
                expandIcon.style.display = 'none';
                closeIcon.style.display = 'inline';

                setTimeout(function() {
                    // Replace the loading ring with the actual product details
                    details.innerHTML = `
                        <p style="color: green; font-size: 18px">Description: ${cardBody.getAttribute('data-description')}</p>
                        <p style="color: green; font-size: 18px">Buying Price: $${cardBody.getAttribute('data-buying-price')}</p>
                        <p style="color: green; font-size: 18px">Items Sold: none</p>
                        <p style="color: green; font-size: 18px">Initial Stock: unknown</p>
                        <p style="color: green; font-size: 18px">Profit: $0.00</p>
                        <p style="color: green; font-size: 18px">Variations: none</p>`;
                }, 2000); // Delay before displaying the details
            }
        }

        // Function to handle category filtering
        document.querySelectorAll('.category-filter').forEach(function(categoryLink) {
            categoryLink.addEventListener('click', function(e) {
                e.preventDefault();
                const categoryId = this.getAttribute('data-id');

                document.querySelectorAll('.product-card').forEach(function(productCard) {
                    if (categoryId === 'all' || productCard.getAttribute('data-category-id') === categoryId) {
                        productCard.style.display = 'block';
                    } else {
                        productCard.style.display = 'none';
                    }
                });
            });
        });

        // Function to handle search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();

            document.querySelectorAll('.product-card').forEach(function(productCard) {
                const productName = productCard.querySelector('h5').innerText.toLowerCase();
                if (productName.includes(searchTerm)) {
                    productCard.style.display = 'block';
                } else {
                    productCard.style.display = 'none';
                }
            });
        });

        // Function to open fullscreen card view
        function openFullscreen(cardId) {
            const fullscreenCard = document.getElementById('fullscreenCard');
            const fullscreenCardContent = document.getElementById('fullscreenCardContent');
            
            // Initially hide the content and display the loading ring after 2 seconds
            fullscreenCardContent.innerHTML
            fullscreenCardContent.innerHTML = "<div class='loading-ring'></div>";
            fullscreenCard.style.display = 'flex';

            // Fetch full card details from the server
            fetch(`fetch_card_details.php?id=${cardId}`)
                .then(response => response.json())
                .then(data => {
                    fullscreenCardContent.innerHTML = `
                        <h2>${data.name}</h2>
                        <img src="../images/${data.image}" alt="${data.name}" style="width: 100%; height: auto;">
                        <p><strong>Description:</strong> ${data.description}</p>
                        <p><strong>Buying Price:</strong> $${data.buying_price}</p>
                        <p><strong>Selling Price:</strong> $${data.selling_price}</p>
                        <p><strong>Quantity:</strong> x${data.quantity}</p>
                        <p><strong>Initial Stock:</strong> ${data.initial_stock}</p>
                        <p><strong>Profit:</strong> $${data.profit}</p>
                        <p><strong>Variations:</strong> ${data.variations}</p>
                    `;
                })
                .catch(error => {
                    console.error('Error fetching card details:', error);
                    fullscreenCardContent.innerHTML = "<p>Error loading details.</p>";
                });
        }

        // Function to close fullscreen card view
        function closeFullscreen() {
            document.getElementById('fullscreenCard').style.display = 'none';
        }
    </script>
</body>
</html>
