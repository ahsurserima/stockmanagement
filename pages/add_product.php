<?php
include '../includes/config.php'; // Include the config file where the connection is established

$sql = "SELECT category_id, name FROM categories";
$result = $conn->query($sql);
$categories = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
} else {
    echo "No categories found";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>

    <!-- Materialize CSS -->
    <link rel="stylesheet" href="../frameworks/materialize/css/materialize.min.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="../frameworks/fontawesome/css/all.min.css">
    <!-- AOS -->
    <link rel="stylesheet" href="../frameworks/aos/css/aos.css" />

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
            color: #333;
            line-height: 1.6;
        }

        .form-container {
            max-width: 800px;
            margin: 50px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.15);
        }

        .form-header {
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
            font-size: 24px;
            color: #007bff;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            background-color: #007bff;
            color: white;
            padding: 12px 25px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .variation-container {
            margin-top: 20px;
        }

        .form-step {
            display: none;
        }

        .form-step-active {
            display: block;
        }

    </style>
</head>
<body>

    <div class="container">
        <div class="form-container" data-aos="fade-up">
            <h1 class="form-header"><i class="fas fa-box-open"></i> Add Product</h1>
            <form id="productForm" action="add_product_process.php" method="post" enctype="multipart/form-data">
                <!-- Product Fields -->
                <div class="form-step form-step-active" id="step1" data-aos="fade-in">
                    <div class="input-field">
                        <input type="text" id="name" name="name" required>
                        <label for="name">Product Name</label>
                    </div>
                    <div class="input-field">
                        <textarea id="description" name="description" class="materialize-textarea" required></textarea>
                        <label for="description">Description</label>
                    </div>
                    <div class="input-field">
                        <select id="category_id" name="category_id" required>
                            <option value="" disabled selected>Choose Category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['category_id']; ?>">
                                    <?php echo $category['name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <label>Category</label>
                    </div>
                    <div class="input-field">
                        <input type="number" id="buying_price" name="buying_price" required>
                        <label for="buying_price">Buying Price</label>
                    </div>
                    <div class="input-field">
                        <input type="number" id="selling_price" name="selling_price" required>
                        <label for="selling_price">Selling Price</label>
                    </div>
                    <div class="input-field">
                        <input type="number" id="quantity" name="quantity" required>
                        <label for="quantity">Quantity</label>
                    </div>
                    <div class="file-field input-field">
                        <div class="btn">
                            <span>Product Image</span>
                            <input type="file" id="image" name="image" accept="image/*">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>
                    <button type="button" class="btn waves-effect waves-light" id="nextStep">Next Step</button>
                </div>

                <!-- Variations Fields -->
                <div class="form-step" id="step2" data-aos="fade-in">
                    <h3 class="center-align"><i class="fas fa-layer-group"></i> Product Variations</h3>
                    <div id="variationsContainer" class="variation-container">
                        <!-- Dynamic variations fields will be added here -->
                    </div>
                    <button type="button" class="btn waves-effect waves-light" id="addVariation">Add Variation</button>
                    <button type="submit" class="btn waves-effect waves-light green">Submit Product with Variations</button>
                    <button type="button" class="btn waves-effect waves-light grey" id="backStep">Back</button>
                    <button type="button" class="btn waves-effect waves-light red" id="cancelVariation">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript libraries -->
    <script src="../frameworks/jquery/jquery.min.js"></script>
    <script src="../frameworks/materialize/js/materialize.min.js"></script>
    <script src="../frameworks/aos/js/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init();

        // Initialize Materialize components
        document.addEventListener('DOMContentLoaded', function() {
            M.AutoInit();
        });

        // Handle step navigation
        document.getElementById('nextStep').addEventListener('click', function() {
            document.getElementById('step1').classList.remove('form-step-active');
            document.getElementById('step2').classList.add('form-step-active');
        });

        document.getElementById('backStep').addEventListener('click', function() {
            document.getElementById('step2').classList.remove('form-step-active');
            document.getElementById('step1').classList.add('form-step-active');
        });

        // Handle adding variations
        document.getElementById('addVariation').addEventListener('click', function() {
            const container = document.getElementById('variationsContainer');
            const index = container.children.length;

            const variationHtml = `
                <div class="variation-group">
                    <div class="input-field">
                        <input type="text" name="color[]" required>
                        <label>Color</label>
                    </div>
                    <div class="input-field">
                        <input type="text" name="size[]" required>
                        <label>Size</label>
                    </div>
                    <div class="input-field">
                        <input type="text" name="subname[]" required>
                        <label>Subname</label>
                    </div>
                    <div class="input-field">
                        <input type="number" name="variation_quantity[]" required>
                        <label>Quantity</label>
                    </div>
                    <button type="button" class="btn waves-effect waves-light red removeVariation">Remove Variation</button>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', variationHtml);

            // Initialize Materialize components for the new fields
            M.updateTextFields();
        });

        // Handle removing variations
        document.getElementById('variationsContainer').addEventListener('click', function(e) {
            if (e.target.classList.contains('removeVariation')) {
                e.target.parentElement.remove();
            }
        });

        // Handle cancel button
        document.getElementById('cancelVariation').addEventListener('click', function() {
            if (confirm("Are you sure you want to cancel? All unsaved changes will be lost.")) {
                window.location.href = 'main.php'; // Redirect to the main page
            }
        });
    </script>
</body>
</html>

