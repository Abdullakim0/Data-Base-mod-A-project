<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Purpose Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            display: flex;
            justify-content: space-around;
            align-items: flex-start;
            gap: 20px;
            padding: 20px;
            flex-wrap: wrap;
        }
        .product {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 10px;
            width: 300px;
        }
        .product img {
            max-width: 100%;
            border-radius: 8px;
        }
        .form-container {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 10px;
            width: 300px;
            margin-top: 20px;
            align-self: center;
        }
        .form-container label,
        .form-container input,
        .form-container textarea {
            display: block;
            margin-bottom: 10px;
            width: 100%;
            box-sizing: border-box;
        }
        .form-container input[type="submit"] {
            padding: 8px 20px;
            font-size: 16px;
            cursor: pointer;
        }
        .form-container textarea {
            resize: vertical;
        }
    </style>
</head>
<body>
<h2>Medical Purpose Products</h2>

<div class="container">
    <?php
    $servername = "localhost";
    $username = "root"; 
    $password = ""; 
    $dbname = "agriculture_products"; 

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM medical_products";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div class='product'>";
            echo "<h3>" . $row["product_name"] . "</h3>";
            echo "<img src='" . $row["image_url"] . "' alt='" . $row["product_name"] . "'>";
            echo "<p>" . $row["description"] . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No products found.</p>";
    }

    $conn->close();
    ?>
</div>

<!-- Form to add new medical product -->
<div class="form-container">
    <h3>Add New Product</h3>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="new_product_name">Product Name:</label>
        <input type="text" id="new_product_name" name="new_product_name" required><br>
        <label for="new_description">Description:</label>
        <textarea id="new_description" name="new_description" rows="3" required></textarea><br>
        <label for="new_image">Product Image:</label>
        <input type="file" id="new_image" name="new_image" accept="image/*" required><br>
        <input type="submit" value="Add Product">
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Process form submission to add new product
        $new_product_name = $_POST['new_product_name'];
        $new_description = $_POST['new_description'];

        // File upload handling
        $target_dir = "uploads/"; // Directory where images will be stored
        $target_file = $target_dir . basename($_FILES["new_image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["new_image"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["new_image"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["new_image"]["tmp_name"], $target_file)) {
                echo "The file ". htmlspecialchars( basename( $_FILES["new_image"]["name"])). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

        // Database connection (again for form submission handling)
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and execute SQL INSERT statement
        $sql_insert = "INSERT INTO medical_products (product_name, description, image_url) VALUES ('$new_product_name', '$new_description', '$target_file')";
        if ($conn->query($sql_insert) === TRUE) {
            echo "<p>New product added successfully!</p>";
        } else {
            echo "Error: " . $sql_insert . "<br>" . $conn->error;
        }

        // Close connection
        $conn->close();
    }
    ?>
</div>

<a href="index.php">Back to Home</a>
</body>
</html>
