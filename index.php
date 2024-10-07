<?php
// Conversion factors to meters
$conversion_factors_to_meters = array(
    'millimeter' => 0.001,
    'centimeter' => 0.01,
    'decimeter' => 0.1,
    'meter' => 1.0,
    'kilometer' => 1000.0,
    'inch' => 0.0254,
    'foot' => 0.3048,
    'yard' => 0.9144,
    'mile' => 1609.34,
    'nautical mile' => 1852.0
);

// Conversion function
function convert_length($value, $from_unit, $to_unit, $conversion_factors_to_meters) {
    // Convert from the original unit to meters
    $meters = $value * $conversion_factors_to_meters[strtolower($from_unit)];
    
    // Convert from meters to the desired unit
    $conversion_factors_from_meters = array_map(function($factor) {
        return 1 / $factor;
    }, $conversion_factors_to_meters);
    
    $result = $meters * $conversion_factors_from_meters[strtolower($to_unit)];
    
    return $result;
}

// Initialize error message
$error_message = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $value = $_POST['value'];
    $from_unit = $_POST['from_unit'];
    $to_unit = $_POST['to_unit'];
    
    // Input validation: check if input is numeric
    if (!is_numeric($value)) {
        $error_message = "Error: Please enter a valid numeric value.";
    } else {
        $value = floatval($value);
        $converted_value = convert_length($value, $from_unit, $to_unit, $conversion_factors_to_meters);
        $output = "<p>$value $from_unit is equal to " . round($converted_value, 4) . " $to_unit</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Length Measurement Converter</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .converter-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 350px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }
        input[type="text"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        p {
            font-size: 18px;
            text-align: center;
            color: #333;
        }
        .error {
            color: red;
            text-align: center;
            font-size: 16px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="converter-container">
        <h1>Length Converter</h1>
        <form method="post">
            <label for="value">Enter value to convert:</label>
            <input type="text" id="value" name="value" required>
            
            <label for="from_unit">Convert from:</label>
            <select id="from_unit" name="from_unit">
                <option value="millimeter">Millimeter</option>
                <option value="centimeter">Centimeter</option>
                <option value="decimeter">Decimeter</option>
                <option value="meter">Meter</option>
                <option value="kilometer">Kilometer</option>
                <option value="inch">Inch</option>
                <option value="foot">Foot</option>
                <option value="yard">Yard</option>
                <option value="mile">Mile</option>
                <option value="nautical mile">Nautical Mile</option>
            </select>
            
            <label for="to_unit">Convert to:</label>
            <select id="to_unit" name="to_unit">
                <option value="millimeter">Millimeter</option>
                <option value="centimeter">Centimeter</option>
                <option value="decimeter">Decimeter</option>
                <option value="meter">Meter</option>
                <option value="kilometer">Kilometer</option>
                <option value="inch">Inch</option>
                <option value="foot">Foot</option>
                <option value="yard">Yard</option>
                <option value="mile">Mile</option>
                <option value="nautical mile">Nautical Mile</option>
            </select>
            
            <input type="submit" value="Convert">
        </form>

        <!-- Display error message if invalid input -->
        <?php
        if (!empty($error_message)) {
            echo "<div class='error'>$error_message</div>";
        }

        // Display conversion result if available and no error
        if (isset($output) && empty($error_message)) {
            echo $output;
        }
        ?>
    </div>
</body>
</html>
