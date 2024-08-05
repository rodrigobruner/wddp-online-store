<?php 
    include('components/header.php'); 
    include('components/navbar.php'); 


    if(!isset($_SESSION['userId'])){
        header('Location:/Login?error=You need to login to view your orders');
    }

    $userID = @$_SESSION['userId'];
    $sqlQuery = "SELECT * FROM user WHERE id = $userID";
    $db = DB::getConection();
    $sqlResult = $db->query($sqlQuery);
    while ($row = $sqlResult->fetch_assoc()) {
        $user = $row;
    }
?>
<main id="pageContac" class="w100">
    <h1>My orders</h1>
    <?php 
        $db = DB::getConection();
        $userId = $_SESSION['userId'];
        $sqlQuery = "SELECT * FROM shopping WHERE user_id = $userId ORDER BY date_time DESC";
        $sqlResult = $db->query($sqlQuery);
        if($sqlResult->num_rows > 0) {
            while($row = $sqlResult->fetch_assoc()){
                $date = new DateTime($row['date_time']);
                ?>
                <div class="card">
                    <h3>Order number: <?php echo $row['id'] ?></h3>
                    <p style="text-align: right;"><?php echo $date->format('Y-m-d H:i:s'); ?></p>
                    <h2>&nbsp;&nbsp;<span class="fa fa-truck"></span> Shipping info</h2>
                    <div style="margin:10px">
                        <P><strong>Postcode:</strong> <?php echo $user['postcode'] ?></P>
                        <P><strong>Address:</strong> <?php echo $user['address']?></P>
                        <P><strong>City:</strong> <?php echo $user['city']?></P>
                        <P><strong>State:</strong> <?php echo $user['province']?></P>
                    </div>
                    <div>
                        <h2><span class="fa fa-shopping-basket"> Items</h2>
                        <?php 
                            $sqlQuery = "SELECT * FROM items JOIN inventory ON items.inventory_id = inventory.id WHERE shopping_id = ".$row['id'];
                            $sqlResultDetail = $db->query($sqlQuery);
                            while($rowDetail = $sqlResultDetail->fetch_assoc()){
                                echo "<br><hr><br><img src='assets/images/".$rowDetail['image']."' class='imgCard' style='width:150px;float:left;margin:10px;'>";
                                echo "  <br><h4>".$rowDetail['name']."</h4><br>
                                        <p>Amount: ".$rowDetail['quantity']." unit(s)</p>
                                        <p>Unit price: $".$rowDetail['unit_price']."</p>
                                        <p>Total price: $".$rowDetail['total_price']."</p><br><br>";
                            }
                        ?>
                    </div>
                    <div style="text-align: right;font-size:14pt;">Total: $<?php echo $row['total_price'] ?> with <?php echo $row['tax'] ?>% tax</div>
                </div> 
            <?php
            }
        } else { ?>
            <img src="assets/images/kermit-cart.jpg" alt="cart kermet" class="imgCard w50">
            <div class="w50">
            <h1>Orders not found</h1><br>
            <h3>Don't miss out on our special and limited products for your Kermet!</h3><br><br>
            <button class='greenButton w100' onClick='window.location.href=`/`'>Go to home</button>
        <?php } ?>
    </div>
    <?php}?>
</main>
<?php include('components/footer.php'); ?>