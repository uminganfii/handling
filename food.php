<?php
// Define the menu prices
$menu_prices = [
    'Burger' => 50,
    'Fries' => 75,
    'Steak' => 150
];

$receipt_output = '';
$error_output = '';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_order'])) {
    
    // 1. Get and sanitize inputs
    $item = filter_input(INPUT_POST, 'order_item', FILTER_SANITIZE_STRING);
    $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);
    $cash = filter_input(INPUT_POST, 'cash', FILTER_VALIDATE_FLOAT);
    
    // 2. Validate inputs and calculate total
    if (array_key_exists($item, $menu_prices) && $quantity > 0 && $cash >= 0) { // Check cash is non-negative
        
        $price = $menu_prices[$item];
        $total_price = $price * $quantity;
        
        // 3. Check for sufficient cash
        if ($cash >= $total_price) {
            
            $change = $cash - $total_price;
            $current_datetime = date("m/d/Y h:i:s a");
            
            // Generate the Receipt HTML (Success Page)
            $receipt_output = "
                <h1 style='font-size: 3em; margin-bottom: 50px;'>RECEIPT</h1>
                <p style='font-size: 2em; font-weight: bold;'>Total Price: " . number_format($total_price, 0) . "</p>
                <p style='font-size: 2em; font-weight: bold;'>You Paid: " . number_format($cash, 0) . "</p>
                <p style='font-size: 2em; font-weight: bold;'>CHANGE: " . number_format($change, 0) . "</p>
                <p style='font-size: 1.5em; margin-top: 30px;'>" . $current_datetime . "</p>
            ";
            
        } else {
            // Generate the Error HTML (Error Page)
            $error_output = "
                <p style='font-size: 2.5em; font-weight: bold; color: red;'>Sorry, balance not enough.</p>
            ";
        }
    } else {
        // Handle general input errors (e.g., negative quantity)
        $error_output = "<p style='font-size: 2.5em; font-weight: bold; color: red;'>Invalid input data. Please check quantity and cash values.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order System</title>
    <style>
        /* Base styles */
        body { font-family: 'Times New Roman', Times, serif; padding: 50px; font-size: 18px; }
        
        /* Styles used for the Menu/Form view */
        h1 { font-size: 2.5em; margin-bottom: 20px; }
        table { border-collapse: collapse; margin-bottom: 30px; }
        th, td { border: 2px double black; padding: 8px 15px; text-align: left; }
        th { font-weight: bold; background-color: #f0f0f0; }
        .form-label { margin-top: 15px; display: block; }
        input[type="number"], select {
            padding: 8px; font-size: 18px; border: 1px solid black; width: 200px; margin-top: 5px; display: block;
        }
        button {
            padding: 10px 20px; margin-top: 20px; border: 1px solid black;
            background-color: #f0f0f0; cursor: pointer; font-size: 18px;
        }
        /* Styles used for the Receipt/Error page view */
        .output-page { text-align: center; margin-top: 50px; }
    </style>
</head>
<body>

    <?php if ($receipt_output || $error_output): ?>
        
        <div class="output-page">
            <?php 
            if ($receipt_output) {
                echo $receipt_output;
            } else {
                echo $error_output;
            }
            ?>
        </div>

    <?php else: ?>
        
        <h1>Menu</h1>

        <table>
            <tr>
                <th>Order</th>
                <th>Amount</th>
            </tr>
            <?php foreach ($menu_prices as $item => $price): ?>
            <tr>
                <td><?php echo $item; ?></td>
                <td><?php echo $price; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <form action="" method="POST">
            
            <label for="order_item">Select an order</label>
            <select name="order_item" id="order_item">
                <?php foreach ($menu_prices as $item => $price): ?>
                    <option value="<?php echo $item; ?>"><?php echo $item; ?></option>
                <?php endforeach; ?>
            </select>
            
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" id="quantity" name="quantity" required min="1">
            
            <label for="cash" class="form-label">Cash</label>
            <input type="number" id="cash" name="cash" required min="0">
            
            <button type="submit" name="submit_order">Submit</button>
        </form>

    <?php endif; ?>

</body>
</html>