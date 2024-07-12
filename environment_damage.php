<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Environmental Damage Reports</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px; /* Added padding to give some space around the content */
        }
        .form-container {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            max-width: 600px; /* Adjusted width for responsiveness */
            margin: 0 auto; /* Center aligning the form container */
            background-color: #fff;
            margin-bottom: 20px;
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
        .report-container {
            max-width: 800px;
            margin: 0 auto; /* Center aligning the report container */
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            text-align: left;
        }
        .report-container h3 {
            margin-bottom: 10px;
        }
        .report-container p {
            margin-bottom: 5px;
        }
        .report-container a {
            text-decoration: none;
            color: #333;
            border: 1px solid #ccc;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .report-container a:hover {
            background-color: #ddd;
        }
        h2 {
            margin-bottom: 20px;
        }
        .error-message {
            color: red;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<h2>Environmental Damage Reports from plant harvesting </h2>

<div class="form-container">
    <h3>Submit Your Report</h3>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <label for="scientist_name">Scientist Name:</label>
        <input type="text" id="scientist_name" name="scientist_name" required><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        <label for="report_title">Report Title:</label>
        <input type="text" id="report_title" name="report_title" required><br>
        <label for="report_description">Report Description:</label>
        <textarea id="report_description" name="report_description" rows="3" required></textarea><br>
        <label for="report_file">Upload Report File (PDF, DOC, DOCX):</label>
        <input type="file" id="report_file" name="report_file" accept=".pdf,.doc,.docx" required><br>
        <input type="submit" value="Submit Report">
    </form>
</div>

<div class="report-container">
    <h3>Existing Reports</h3>
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

    // SQL query to retrieve existing reports
    $sql = "SELECT * FROM environment_damage";
    $result = $conn->query($sql);

    // Display reports if there are results
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div>";
            echo "<h3>" . htmlspecialchars($row["report_title"]) . "</h3>";
            echo "<p><strong>Scientist:</strong> " . htmlspecialchars($row["scientist_name"]) . "</p>";
            echo "<p><strong>Email:</strong> " . htmlspecialchars($row["email"]) . "</p>";
            echo "<p>" . htmlspecialchars($row["report_description"]) . "</p>";
            echo "<p><a href='" . htmlspecialchars($row["file_path"]) . "' target='_blank'>Download Report</a></p>";
            echo "</div>";
        }
    } else {
        echo "<p>No reports found.</p>";
    }

    // Close connection
    $conn->close();
    ?>
</div>

<a href="index.php">Back to Home</a>

<?php
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if form fields are filled and file is uploaded
    if (isset($_POST['scientist_name']) && isset($_POST['email']) && isset($_POST['report_title']) && isset($_POST['report_description']) && isset($_FILES['report_file'])) {

        // Database connection settings
        $servername = "localhost";
        $username = "root"; //MySQL username
        $password = ""; // MySQL password
        $dbname = "agriculture_products"; // database name

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Handle form data
        $scientist_name = $_POST['scientist_name'];
        $email = $_POST['email'];
        $report_title = $_POST['report_title'];
        $report_description = $_POST['report_description'];

        // File upload handling
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["report_file"]["name"]);
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // If file already exists
        if (file_exists($target_file)) {
            echo "<div class='error-message'>Sorry, file already exists.</div>";
            $uploadOk = 0;
        }

        // File size (max 5MB)
        if ($_FILES["report_file"]["size"] > 5 * 1024 * 1024) {
            echo "<div class='error-message'>Sorry, your file is too large.</div>";
            $uploadOk = 0;
        }

        // Certain file formats
        if($fileType != "pdf" && $fileType != "doc" && $fileType != "docx") {
            echo "<div class='error-message'>Sorry, only PDF, DOC, and DOCX files are allowed.</div>";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "<div class='error-message'>Sorry, your file was not uploaded.</div>";
        } else {
            if (move_uploaded_file($_FILES["report_file"]["tmp_name"], $target_file)) {
                // Insert data into database
                $file_path = $target_file;
                $sql = "INSERT INTO environment_damage (scientist_name, email, report_title, report_description, file_path) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssss", $scientist_name, $email, $report_title, $report_description, $file_path);
                if ($stmt->execute()) {
                    echo "<div class='error-message'>Report submitted successfully.</div>";
                } else {
                    echo "<div class='error-message'>Error: " . $stmt->error . "</div>";
                }
                $stmt->close();
            } else {
                echo "<div class='error-message'>Sorry, there was an error uploading your file.</div>";
            }
        }

        // Close connection
        $conn->close();
    } else {
        echo "<div class='error-message'>Please fill in all required fields.</div>";
    }
}
?>
</body>
</html>
