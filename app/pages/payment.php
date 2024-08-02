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