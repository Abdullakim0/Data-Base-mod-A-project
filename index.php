<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agriculture Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0; /* Light background color */
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .buttons {
            display: flex;
            flex-direction: column;
            gap: 15px; /* Reduced gap for tighter spacing */
            background-color: #ffffff; /* White background for buttons container */
            padding: 20px; /* Padding around buttons */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Drop shadow for a subtle effect */
        }
        .buttons button {
            padding: 12px 24px; /* Increased padding for better button size */
            font-size: 18px;
            cursor: pointer;
            border: none;
            background-color: #4CAF50; /* Green background color */
            color: white; /* White text color */
            border-radius: 4px; /* Rounded corners for buttons */
            transition: background-color 0.3s ease; /* Smooth hover effect */
        }
        .buttons button:hover {
            background-color: #45a049; /* Darker green on hover */
        }
        h1 {
            margin-bottom: 20px; /* Added margin below heading */
            color: #333333; /* Dark text color */
        }
    </style>
</head>
<body>
<div class="container">
    <div class="buttons">
        <h1>The Plants</h1>
        <button onclick="location.href='medical_purpose.php'">Medical Purpose</button>
        <button onclick="location.href='industry_purpose.php'">Industry Purpose</button>
        <button onclick="location.href='environmental_damage.php'">Environmental Damage</button>
    </div>
</div>
</body>
</html>
