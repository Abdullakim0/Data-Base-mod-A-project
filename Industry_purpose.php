<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Local Planters and Companies</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: 0;
            background-color: #f0f0f0;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
        }
        .product {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 10px;
            width: 300px;
            background-color: #fff;
        }
        .product img {
            max-width: 100%;
            border-radius: 8px;
        }
        .form-container {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            width: 300px;
            margin-top: 20px;
            background-color: #fff;
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
        h2 {
            margin-bottom: 20px;
        }
        a {
            margin-top: 20px;
            text-decoration: none;
            color: #333;
            border: 1px solid #ccc;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        a:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
<h2>Local Planters and Companies</h2>

<!-- Search form -->
<div class="form-container">
    <h3>Search</h3>
    <form action="" method="get">
        <label for="search_keyword">Search by Name:</label>
        <input type="text" id="search_keyword" name="search_keyword" required>
        <input type="submit" value="Search">
    </form>
</div>

<div class="container">
    <?php
    // Database connection settings
    $servername = "localhost";
    $username = "root"; // MySQL username
    $password = ""; // MySQL password
    $dbname = "agriculture_products"; // database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Default SQL query to retrieve all industry purpose products (local planters and companies)
    $sql = "SELECT * FROM industry_products";

    // Process search query if keyword is provided
    if (isset($_GET['search_keyword']) && !empty($_GET['search_keyword'])) {
        $search_keyword = $_GET['search_keyword'];
        // SQL query with search filter
        $sql = "SELECT * FROM industry_products WHERE company_name LIKE '%$search_keyword%'";
    }

    // Execute SQL query
    $result = $conn->query($sql);

    // Display products if there are results
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div class='product'>";
            echo "<h3>" . $row["company_name"] . "</h3>";
            echo "<img src='" . $row["image_url"] . "' alt='" . $row["company_name"] . "'>";
            echo "<p>" . $row["description"] . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No local planters or companies found.</p>";
    }

    // Close connection
    $conn->close();
    ?>
</div>

<a href="index.php">Back to Home</a>
</body>
</html>
