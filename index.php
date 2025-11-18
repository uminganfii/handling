<!DOCTYPE html>
<html>
<head>
    <title>Discriminant of a Quadratic Equation</title>
    <style>
        body {
            font-family: Georgia, serif;
            padding: 30px;
        }
        h1 {
            font-size: 40px;
            font-weight: bold;
        }
        label {
            font-size: 24px;
            display: block;
            margin-top: 15px;
        }
        input[type="text"] {
            width: 300px;
            height: 35px;
            font-size: 20px;
            margin-left: 10px;
        }
        input[type="submit"] {
            margin-top: 25px;
            padding: 10px 20px;
            font-size: 20px;
        }
    </style>
</head>
<body>

<h1>Discriminant of a quadratic equation</h1>

<form method="post">
    <label>A <input type="text" name="a"></label>
    <label>B <input type="text" name="b"></label>
    <label>C <input type="text" name="c"></label>

    <input type="submit" value="Submit">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $a = $_POST["a"];
    $b = $_POST["b"];
    $c = $_POST["c"];

    if ($a !== "" && $b !== "" && $c !== "") {
        // Discriminant formula: b^2 - 4ac
        $disc = ($b * $b) - (4 * $a * $c);
        echo "<h2>Discriminant = $disc</h2>";
    } else {
        echo "<h2 style='color:red;'>Please enter values for A, B, and C.</h2>";
    }
}
?>

</body>
</html>
