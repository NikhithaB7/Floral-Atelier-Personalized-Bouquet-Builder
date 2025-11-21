<?php
session_start();
$xml = simplexml_load_file("flowers.xml");

// Fetch image & price for an item from XML
function getFlowerData($name, $xml) {
    foreach ($xml->item as $it) {
        if ((string)$it->name === $name) {
            return [
                "image" => isset($it->image) ? (string)$it->image : "",
                "price" => isset($it->price) ? (float)$it->price : 0
            ];
        }
    }
    return ["image" => "", "price" => 0];
}

// REMOVE an item
if (isset($_GET['remove'])) {
    $index = $_GET['remove'];
    unset($_SESSION['cart'][$index]);
    $_SESSION['cart'] = array_values($_SESSION['cart']);
    header("Location: cart.php");
    exit;
}

// UPDATE quantity
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_index"])) {
    $i = $_POST["update_index"];
    $_SESSION['cart'][$i]['qty'] = $_POST["qty"];
    header("Location: cart.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Your Cart</title>

<style>
    body {
        margin: 0;
        padding: 0;
        font-family: "Poppins", sans-serif;
        background: #F9F4EF;
        color: #3D2A24;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    .cart-container {
        width: 85%;
        max-width: 900px;
        background: #ffffff;
        padding: 30px;
        border-radius: 22px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.12);
        animation: fadeIn 0.7s ease-in-out;
    }

    h2 {
        margin-top: 0;
        text-align: center;
        font-weight: 700;
        font-size: 32px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }

    th, td {
        padding: 12px;
        text-align: center;
        border-bottom: 1px solid #EBD6DB;
    }

    th {
        background: #FCE6EF;
        color: #A54486;
        font-weight: 600;
    }

    .img-box img {
        width: 75px;
        height: 75px;
        object-fit: contain;
        border-radius: 12px;
        box-shadow: 0px 2px 6px rgba(0,0,0,0.08);
        padding: 4px;
        background: #fff;
    }

    .qty-input {
        width: 65px;
        padding: 6px;
        border-radius: 10px;
        border: 2px solid #E6C5D2;
        text-align: center;
        font-size: 14px;
        outline: none;
    }
    .qty-input:focus {
        border-color: #7BC47F;
        box-shadow: 0 0 5px #7BC47F;
    }

    .btn-update, .btn-remove {
        padding: 7px 14px;
        border-radius: 20px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-update {
        background: #D67CA9;
        color: white;
    }
    .btn-update:hover {
        background: #bf6a95;
    }

    .btn-remove {
        background: #F8C0C8;
        color: #450920;
    }
    .btn-remove:hover {
        background: #E59DAA;
    }

    .total-box {
        text-align: right;
        font-size: 20px;
        font-weight: 700;
        margin-top: 15px;
        color: #3D2A24;
    }

    .back-btn {
        display: inline-block;
        margin-top: 20px;
        padding: 12px 25px;
        border-radius: 24px;
        text-decoration: none;
        background: #D67CA9;
        color: #fff;
        font-weight: 600;
        transition: 0.3s;
    }
    .back-btn:hover {
        background: #bf6a95;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(18px);}
        to { opacity: 1; transform: translateY(0);}
    }
</style>
</head>

<body>

<div class="cart-container">
    <h2>Your Cart</h2>

    <?php
    if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {

        $grandTotal = 0;

        echo "<table>
                <tr>
                    <th>Image</th>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Action</th>
                </tr>";

        foreach ($_SESSION['cart'] as $i => $item) {
            $data = getFlowerData($item['item'], $xml);
            $itemTotal = $item['qty'] * $data['price'];
            $grandTotal += $itemTotal;

            echo "<tr>
                    <td class='img-box'><img src='{$data['image']}'></td>
                    <td>{$item['item']}</td>
                    <td>
                        <form method='post' style='display:inline-block;'>
                            <input type='hidden' name='update_index' value='$i'>
                            <input type='number' name='qty' class='qty-input' min='1' value='{$item['qty']}' required>
                            <button class='btn-update'>Update</button>
                        </form>
                    </td>
                    <td>₹{$itemTotal}</td>
                    <td>
                        <a href='cart.php?remove=$i'>
                            <button class='btn-remove'>Remove</button>
                        </a>
                    </td>
                </tr>";
        }
        echo "</table>";

        echo "<div class='total-box'>Grand Total: ₹$grandTotal</div>";

    } else {
        echo "<p style='text-align:center; font-size:18px; color:#6a5953;'>✨ Cart is empty! Add some beautiful blooms 💐</p>";
    }
    ?>

    <div style="text-align:center;">
        <a href='bouquet.php' class='back-btn'>Add More Flowers</a>
    </div>
</div>

</body>
</html>
