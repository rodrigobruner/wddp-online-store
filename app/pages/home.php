<?php 
include('models/product.php');
include('components/header.php');
include('components/navbar.php'); 
?>
<main class="w100">
    <?php 
        if(isset($_SESSION["userName"])){
            echo "<h3>Welcome ".$_SESSION["userName"]."!</h3>";
        }
        $products = Inventary::getProducts();
        foreach ($products as $product) {
            if($product != false) { ?>
                <div class="card">
                    <img src="assets/images/<?php echo $product->image ?>" alt="Kermit" class="imgCard w70">
                    <h3><?php echo $product->name ?></h3>
                    <p><?php echo $product->description ?></p>
                    <div>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star checked"></span>
                        <span class="fa fa-star"></span>
                        <a href="#">10 Reviews</a>
                        <div><?php echo $product->price ?></div>
                    </div>
                    <button onClick="window.location.href='/ShoppingCart?product=<?php echo $product->id?>'">Buy now</button>
                </div>
    <?php } 
    }?>
<?php include('components/footer.php'); ?>