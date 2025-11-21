<?php
session_start();
$xml = simplexml_load_file("flowers.xml");

$addedMessage = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item = $_POST['item'];
    $qty = $_POST['qty'];
    if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
    $_SESSION['cart'][] = ['item' => $item, 'qty' => $qty];
    $addedMessage = "Added to cart!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Your Bouquet</title>
    <style>
        body {
            margin: 0;
            font-family: "Poppins", sans-serif;
            background: #F9F4EF; /* light beige */
            color: #3D2A24;
        }

        .builder-wrapper {
            max-width: 1100px;
            margin: 40px auto;
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .flash {
            text-align: center;
            background: #E7F8E8;
            color: #2e6130;
            padding: 10px 15px;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .builder-layout {
            display: grid;
            grid-template-columns: 2fr 1.3fr;
            gap: 25px;
            margin-bottom: 20px;
        }

        .items-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 15px;
        }

        .item-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            padding: 10px;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s, border 0.2s;
            border: 2px solid transparent;
        }

        .item-card.selected {
            border-color: #D67CA9; /* pink highlight */
            box-shadow: 0 8px 18px rgba(0,0,0,0.12);
            transform: translateY(-2px);
        }

        .item-card img {
            width: 100%;
            height: 140px;
            object-fit: contain;   /* shows full image */
            background: none;
            padding:0px;
     }


        .item-info {
            margin-top: 8px;
        }

        .item-name {
            font-weight: 600;
        }

        .item-type {
            font-size: 13px;
            color: #6a5953;
        }

        .item-price {
            margin-top: 4px;
            font-size: 14px;
            color: #D67CA9;
        }

        /* Preview panel */
        .preview-panel {
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 5px 18px rgba(0,0,0,0.08);
            padding: 20px;
        }

        .preview-title {
            font-weight: 700;
            margin-bottom: 10px;
        }

        .preview-img {
         width: 100%;
         height: 160px;       /* smaller height */
         border-radius: 14px;
         object-fit: contain; /* show full flower */
         background: #F9F4EF;
         padding: 8px;
        margin-bottom: 10px;
    }


        .preview-details {
            font-size: 14px;
            color: #6a5953;
            margin-bottom: 10px;
        }

        .preview-total {
            font-weight: 600;
            margin-bottom: 15px;
        }

        .qty-label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
        }

        .qty-input {
            width: 100%;
            padding: 8px;
            border-radius: 20px;
            border: 2px solid #E6C5D2;
            outline: none;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .qty-input:focus {
            border-color: #7BC47F; /* pastel green */
            box-shadow: 0 0 5px #7BC47F;
        }

        .btn-add {
            width: 100%;
            background: #D67CA9;
            border: none;
            color: white;
            padding: 10px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-add:hover {
            background: #bf6a95;
        }

        .cart-link {
            text-align: center;
            margin-top: 10px;
        }

        .cart-link a {
            color: #D67CA9;
            text-decoration: none;
            font-weight: 600;
        }

        /* Hide original select but keep it for POST logic */
        .hidden-select {
            display: none;
        }

        @media (max-width: 900px) {
            .builder-layout {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<div class="builder-wrapper">
    <h2>Create Your Bouquet</h2>

    <?php if ($addedMessage): ?>
        <div class="flash">
            <?php echo $addedMessage; ?> <a href="cart.php">View Cart</a>
        </div>
    <?php endif; ?>

    <div class="builder-layout">
        <!-- LEFT: Items grid -->
        <div class="items-grid" id="itemsGrid">
            <?php foreach ($xml->item as $it): ?>
                <?php
                    $name  = (string) $it->name;
                    $type  = (string) $it->type;
                    $price = (float) $it->price;
                    $img   = isset($it->image) ? (string)$it->image : '';
                ?>
                <div class="item-card"
                     data-name="<?php echo htmlspecialchars($name); ?>"
                     data-type="<?php echo htmlspecialchars($type); ?>"
                     data-price="<?php echo $price; ?>"
                     data-image="<?php echo htmlspecialchars($img); ?>">
                    <?php if ($img): ?>
                        <img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($name); ?>">
                    <?php endif; ?>
                    <div class="item-info">
                        <div class="item-name"><?php echo htmlspecialchars($name); ?></div>
                        <div class="item-type"><?php echo htmlspecialchars($type); ?></div>
                        <div class="item-price">₹<?php echo $price; ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- RIGHT: Live preview + form -->
        <div class="preview-panel">
            <div class="preview-title">Bouquet Preview</div>
            <img src="" alt="" class="preview-img" id="previewImg">
            <div class="preview-details" id="previewDetails">
                Select a flower or plant to begin.
            </div>
            <div class="preview-total" id="previewTotal"></div>

            <!-- Original form – logic unchanged -->
            <form method="post" onsubmit="return validateOrderForm();">
                <!-- Hidden select: still sends 'item' to PHP -->
                <select name="item" id="itemSelect" class="hidden-select">
                    <?php foreach ($xml->item as $it): ?>
                        <option value="<?php echo htmlspecialchars($it->name); ?>">
                            <?php echo htmlspecialchars($it->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label class="qty-label" for="qtyInput">Quantity</label>
                <input type="number" name="qty" id="qtyInput" class="qty-input" min="1" value="1" required>

                <button type="submit" class="btn-add">Add to Cart</button>
            </form>

            <div class="cart-link">
                or <a href="cart.php">Go to Cart</a>
            </div>
        </div>
    </div>
</div>

<script>
    const cards = document.querySelectorAll('.item-card');
    const previewImg = document.getElementById('previewImg');
    const previewDetails = document.getElementById('previewDetails');
    const previewTotal = document.getElementById('previewTotal');
    const qtyInput = document.getElementById('qtyInput');
    const itemSelect = document.getElementById('itemSelect');

    let selectedPrice = 0;

    function updateTotal() {
        const qty = parseInt(qtyInput.value || '1', 10);
        if (selectedPrice > 0) {
            previewTotal.textContent = 'Total: ₹' + (selectedPrice * qty);
        } else {
            previewTotal.textContent = '';
        }
    }

    cards.forEach((card, index) => {
        card.addEventListener('click', () => {
            cards.forEach(c => c.classList.remove('selected'));
            card.classList.add('selected');

            const name = card.dataset.name;
            const type = card.dataset.type;
            const price = parseFloat(card.dataset.price);
            const image = card.dataset.image;

            selectedPrice = price;

            if (image) {
                previewImg.src = image;
                previewImg.alt = name;
            }

            previewDetails.textContent = name + ' (' + type + ') • ₹' + price + ' per unit';

            // Sync hidden select for form submission
            itemSelect.selectedIndex = index;

            updateTotal();
        });
    });

    qtyInput.addEventListener('input', updateTotal);
</script>
</body>
</html>
