<?php
    function selectedMenu($option){
        $router = new Router();
        if($router->getURI() == $option){
            return "class='selectedMenu'";
        }
    }
?>

<nav>
    <ul>
        <li><a <?php echo selectedMenu("/") ?>href="/">Home</a></li>
        <li><a <?php echo selectedMenu("/About") ?> href="/About">About</a></li>
        <li><a <?php echo selectedMenu("/Contact") ?> href="/Contact">Contact</a></li>
        <?php if(isset($_SESSION["userId"])) { ?>
            <li><a <?php echo selectedMenu("/Logout") ?> href="/Logout">Logout</a></li>
        <?php } else { ?>
            <li><a <?php echo selectedMenu("/Login") ?> href="/Login">Login</a></li>
        <?php } ?>
        <li class='shoppingCart' style="float:right">
            <a <?php echo selectedMenu("/ShoppingCart") ?> href="/ShoppingCart">
                <i class="fa fa-shopping-basket" ></i>  Shopping cart
            </a>
        </li>
    </ul>
</nav>