<?php 
    include('models/product.php');
    include('components/header.php'); 
    include('components/navbar.php'); 

    if(@$_POST["submit"] == 1){
        $error = "";
        

        if(!isset($_SESSION['userId'])){
            header('Location:/Login?error=You need to login to pay');
        }

        $userID = @$_SESSION['userId'];

        $sqlQuery = "SELECT * FROM user WHERE id = $userID";
        $db = DB::getConection();
        $sqlResult = $db->query($sqlQuery);
        /* fetch object array */
        while ($row = $sqlResult->fetch_assoc()) {
            $user = $row;
        }


        $name = $user['name'];
        $email = $user['email'];
        $phone = $user['phone'];
        $postcode = $user['postcode'];
        $address = $user['address'];
        $city = $user['city'];
        $province = $user['province'];
        $card = @$_POST['card'] ? trim($_POST['card']) : false;
        $expirationMonth = @$_POST['expirationMonth'] ? strtoupper(trim($_POST['expirationMonth'])) : false;
        $expirationYear = @$_POST['expirationYear'] ? trim($_POST['expirationYear']) : false;
        $cvv = @$_POST['cvv'] ? trim($_POST['cvv']) : false;

        //Card
        $ccRegexp = "/^[0-9]{4}\-[0-9]{4}\-[0-9]{4}\-[0-9]{4}$/";
        
        if(!preg_match($ccRegexp, $card)){
            $error .= "- Card number is invalid [ 9999-9999-9999-9999 ]<br>";
        }

        $months = array("JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC");

        if(!in_array($expirationMonth, $months)){
            $error .= "- Expiration month is invalid [ Jan ] <br>";
        }

        if($expirationYear < date("Y") || $expirationYear > date("Y")+10){
            $error .= "- Expiration year is invalid [ 2024 ] <br>";
        }

        $cvvRegexp = "/^[0-9]{3}$/";
        if(!preg_match($cvvRegexp, $cvv)){
            $error .= "- CVV is invalid [ 999 ]<br>";
        }

        if($error){
            header("Location: /Payment?error=$error");
        }
    }

    $shoppingCart = new ShoppingCart();
    $shoppingCart->load();
?>
<main id="pageContac" class="w100">
    <img src="assets/images/kermit-thanks.jpg" alt="Contact kermet" class="imgCard w50">
    <div class="w50">
        <h1>Thanks for your purchase</h1>
        <h2><span class="fa fa-user"></span> User info</h2>
        <br>
        <P><strong>Name:</strong> <?php echo $name?></P>
        <P><strong>Phone:</strong> <?php echo $phone?></P>
        <P><strong>Email:</strong> <?php echo $email?></P>
        <br>
        <hr>
        <h2><span class="fa fa-truck"></span> Shipping info</h2>
        <br>
        <P><strong>Postcode:</strong> <?php echo $postcode?></P>
        <P><strong>Address:</strong> <?php echo $address?></P>
        <P><strong>City:</strong> <?php echo $city?></P>
        <P><strong>State:</strong> <?php echo $province?></P>
        <br>
        <p>Delivered by: FedEx , <strong>your purchase arrives in 5 days.</strong> </p>
        <br>
        <hr>
        <h2><span class="fa fa-shopping-basket"> Items</h2>
        <br>
        <table>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Qt</th>
                    <th>Total/Item</th>
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
                    </tr>
                <?php } ?>
        </table>
        <br>
        <?php 
            $tax = ($subtotal/100)*$provinces[$province];
            $total = $subtotal + $tax;

            $totalDecimal = number_format($total, 2, '.', '');
            $taxDecimal = number_format($provinces[$province], 2, '.', '');

            if(!$error){
                // save on db
                $sqlShoppingCart = "INSERT INTO shopping(user_id, tax, total_price) VALUES($userID, $taxDecimal, $totalDecimal)";
                $db->query($sqlShoppingCart);
                $shoppingCartID = $db->insert_id;

                foreach ($shoppingCart->products as $product) {    
                    $sqlShoppingCartProduct = "INSERT INTO items(inventory_id, shopping_id, quantity, unit_price, total_price) VALUES($product->id, $shoppingCartID, $product->quantity, $product->price, $product->quantity * $product->price)";
                    $db->query($sqlShoppingCartProduct);
                }
            }
        ?>
            <h4 style="text-align: right;">Subtotal: $<?php echo number_format($subtotal, 2, '.', ','); ?></h4>
            <h4 style="text-align: right;">Tax(<?php echo $provinces[$province]?>%): $<?php echo  number_format($tax, 2, '.', ',');?></h4>
            <h3 style="text-align: right;">Total: $<?php echo  number_format($total, 2, '.', ',');?></h3>
    </div>
</main>
<?php 
// $shoppingCart->products = [];
// $shoppingCart->save();
include('components/footer.php'); ?>