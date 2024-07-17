<?php 
include('models/product.php');
include('components/header.php'); 
include('components/navbar.php'); 

//If there is a province parameter save if not default
$province = $_GET["province"] ?? "Ontario";

//Create a list of available products
$inventory = new Inventary();
$productsAvaliable = $inventory->getProducts();

//Start a new shopping cart
$shoppingCart = new ShoppingCart();
$shoppingCart->load();

//Add product to shopping cart
$productId = isset($_GET['product']) ? $_GET['product'] : false;
if ($productId) {
    $product = isset($productsAvaliable[$productId]) ? $productsAvaliable[$productId] : false;
    if ($product) {
        $shoppingCart->addProduct($product);
        $shoppingCart->save();
    }
}

//Remove product from shopping cart
$removeProductId = isset($_GET['removeProducts']) ? $_GET['removeProducts'] : false;
if ($removeProductId) {
    if ($removeProductId == 'all') {
        $shoppingCart->products = [];
    }else{
        $shoppingCart->removeProduct($removeProductId);
    }
    $shoppingCart->save();
}
?>
<main id="pageContac" class="w100">
    <img src="assets/images/kermit-cart.jpg" alt="cart kermet" class="imgCard w50">
    <div class="w50">
        <?php if (count($shoppingCart->products)) { ?>
            <h1>Shopping Cart</h1>
            <label for="province">Which province will the delivery be in?</label>
            <select id="province" name="province" onChange="window.location.href='/ShoppingCart?province='+this.value">
                <?php 
                    foreach ($provinces as $key => $value) {
                        $selected = $key == $province ? "selected" : "";
                        echo "<option value='$key' $selected>$key</option>";
                    }
                    $taxRate = $provinces[$province];
                ?>
            </select>
            <br><br>
            <table>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Qt</th>
                    <th>Total/Item</th>
                    <th>Remove</th>
                </tr>
                <?php 
                $subtotal = 0;
                foreach ($shoppingCart->products as $product) {    
                    $subtotal += $product->quantity*$product->price;
                    ?>
                    <tr>
                        <td><?php echo $product->name ?></td>
                        <td>$<?php echo $product->price ?></td>
                        <td><?php echo $product->quantity ?></td>
                        <td>$<?php echo $product->quantity*$product->price ?></td>
                        <td>
                        <button class="greenButton"
                        onClick="window.location.href='/ShoppingCart?product=<?php echo $product->id ?>'">+</button>
                        &nbsp;
                        <button class="redButton"
                        onClick="window.location.href='/ShoppingCart?removeProducts=<?php echo $product->id ?>'">-</button>
                    </td>
                    </tr>
                <?php } ?>
            </table>
            <br>
            <?php 
                $tax = ($subtotal/100)*$provinces[$province];
                $total = $subtotal + $tax;
            ?>
            <h4 style="text-align: right;">Subtotal: $<?php echo number_format($subtotal, 2, '.', ','); ?></h4>
            <h4 style="text-align: right;">Tax(<?php echo $provinces[$province]?>%): $<?php echo  number_format($tax, 2, '.', ',');?></h4>
            <h3 style="text-align: right;">Total: $<?php echo  number_format($total, 2, '.', ',');?></h3>
            <br><br>
            <button class="greenButton w100" 
            onClick="window.location.href='/Payment?province=<?php echo  $province;?>'"><i class="fa fa-credit-card"></i> &nbsp; Place order</button>
            <br>
            <hr>
            <button class="redButton w100"
            onClick="window.location.href='/ShoppingCart?removeProducts=all'"><i class="fa fa-trash-o"></i> &nbsp; Remove all products</button>
            
        <?php 
        }else{
        ?>
        <h1>Shopping Cart is empty</h1><br>
        <h3>Don't miss out on our special and limited products for your Kermet!</h3><br><br>
        <button class='greenButton w100' onClick='window.location.href=`/`'>Go to home</button>
        <?php } ?>
    </div>
</main>
<?php include('components/footer.php'); ?>