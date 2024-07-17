<?php 
    include('models/product.php');
    include('components/header.php'); 
    include('components/navbar.php'); 

    $province = $_GET["province"] ?? "Ontario";
    $error = @$_GET['error'] ?? false;
?>
<main id="pageContac" class="w100">
    <div class="w50">
    <?php if ($error) { ?>
        <div class="error w100">
            <h3><span class="fa fa-exclamation"></span> Error:</h3> 
            <hr>
            <ul>
                <?php echo $error ?>
            </ul>
        </div>
    <?php } ?>
    <h3>User info</h3>
    <form action="/Shipping" method="POST">
        <label for="name">Name</label>
        <input type="text" id="name" name="name">

        <label for="phone">Phone number</label>
        <input type="text" id="phone" name="phone">

        <label for="email">Email</label>
        <input type="text" id="email" name="email">

        <label for="password">Password</label>
        <input type="password" id="password" name="password">

        <label for="cpassword">Confirm password</label>
        <input type="password" id="cpassword" name="cpassword">

        <hr>
        <h3>Address</h3>
        <label for="postcode">Postcode </label>
        <input type="text" id="postcode" name="postcode" placeholder="A0A 0A0">

        <label for="address">Address</label>
        <input type="text" id="address" name="address">

        <label for="city">City</label>
        <input type="text" id="city" name="city">

        <label for="province">Province</label>
        <select id="province" name="province">
            <option value="">Select a state</option>
            <?php 
                    foreach ($provinces as $key => $value) {
                        $selected = $key == $province ? "selected" : "";
                        echo "<option value='$key' $selected>$key</option>";
                    }
                ?>
        </select>
        <hr>
        <h3>Payment</h3>
        <label for="card">Card</label>
        <input type="text" id="card" name="card"  placeholder="9999-9999-9999-9999">
        <label for="expirationMonth" class="w30">Month</label>
        <label for="expirationYear" class="w30">Year</label>
        <label for="cvv"  class="w30">CVV</label>
        <input type="text" id="expirationMonth" name="expirationMonth" class="w30" placeholder="Jan">    
        <input type="text" id="expirationYear" name="expirationYear" class="w30" placeholder="2024">  
        <input type="text" id="cvv" name="cvv" class="w30" placeholder="999">
        <br>
        <button type="submit" name="submit" value="1" class="greenButton w100"><i class="fa fa-credit-card" ></i>  Pay</button>
    </form>
    </div>

    <img src="assets/images/kermit-payment.jpg" alt="Contact kermet" class="imgCard w50">
</main>
<?php include('components/footer.php'); ?>