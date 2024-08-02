<?php 
    include('components/header.php'); 
    include('components/navbar.php'); 
?>
<script>
    submitForm("Login", "/Login", target, method="POST");
</script>
<main id="pageContac" class="w100">
    
    <div class="w30">
        <h1>Login</h1>
        <form action="" id="Login" method="POST">
            <label for="email">E-mail</label>
            <input type="text" name="email">

            <label for="password">Password</label>
            <input type="password" name="password">

            <?php 
                if(! is_null(@$_GET["error"])){
                    echo "<p class='error'>".@$_GET["error"]."</p>";
                }
            ?>
            
            <input type="submit" value="Login">

        </form>
        <div id="target"></div>
        <div class="text-center">
            <a href="/New">Create a new account</a>
        </div>
        
    </div>
    <img src="assets/images/kermit-login.jpg" alt="Contact kermet" class="imgCard w70">
</main>
<?php include('components/footer.php'); ?>