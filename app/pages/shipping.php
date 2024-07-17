<?php 
    include('models/product.php');
    include('components/header.php'); 
    include('components/navbar.php'); 

    if(@$_POST["submit"] == 1){
        $error = "";
        
        $name = @$_POST['name'] ? trim($_POST['name']) : false;
        $email = @$_POST['email'] ? trim($_POST['email']) : false;
        $phone = @$_POST['phone'] ? trim($_POST['phone']) : false;
        $password = @$_POST['password'] ? trim($_POST['password']) : false;
        $cpassword = @$_POST['cpassword'] ? trim($_POST['cpassword']) : false;
        $postcode = @$_POST['postcode'] ? trim($_POST['postcode']) : false;
        $address = @$_POST['address'] ? trim($_POST['address']) : false;
        $city = @$_POST['city'] ? trim($_POST['city']) : false;
        $province = @$_POST['province'] ? $_POST['province'] : false;
        $card = @$_POST['card'] ? trim($_POST['card']) : false;
        $expirationMonth = @$_POST['expirationMonth'] ? strtoupper(trim($_POST['expirationMonth'])) : false;
        $expirationYear = @$_POST['expirationYear'] ? trim($_POST['expirationYear']) : false;
        $cvv = @$_POST['cvv'] ? trim($_POST['cvv']) : false;

        //Name
        if($name == ""){
            $error .= "- Name is required<br>";
        }

        //Phone
        $phoneRegexp = "/^[0-9]{3}\-[0-9]{3}\-[0-9]{4}$/";
        if(!preg_match($phoneRegexp, $phone)){
            $error .= "- Phone number is invalid [ 999-999-9999 ]<br>";
        }

        //Email
        if($email == ""){
            $error .= "- Email is required<br>";
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error .= "- Invalid email format<br>";
        }

        //Password
        if($password != $cpassword) {
            $error .= "- Password differs from password confirmation<br>";
        }

        //Postcode
        $postcodeRegexp = "/^[A-Za-z]\d[A-Za-z][ -]?\d[A-Za-z]\d$/";
        if(!preg_match($postcodeRegexp, $postcode)){
            $error .= "- Postcode is invalid [ A0A 0A0 ]<br>";
        }

        //Address
        if($address == ""){
            $error .= "- Address is required<br>";
        }

        //City
        if($city == ""){
            $error .= "- City is required<br>";
        }

        if($province == ""){
            $error .= "- State is required<br>";
        }

        //Card
        $ccRegexp = "/^[0-9]{4}\-[0-9]{4}\-[0-9]{4}\-[0-9]{4}$/";
       
        if(!preg_match($ccRegexp, $card)){
            $error .= "- Card number is invalid [ 9999-9999-9999-9999 ]<br>";
        }

        $months = array("JAN", "FAB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC");
        // var_dump($months);
        // var_dump( $expirationMonth);
        // var_dump(in_array($expirationMonth, $months));
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
        <h2><span class="fa fa-shopping-basket"> Itens</h2>
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