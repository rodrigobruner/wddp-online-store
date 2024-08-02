<?php 
    include('components/header.php'); 
    include('components/navbar.php'); 
?>
<main id="pageContac" class="w100">
    
    <div class="w30">
        <h1>Login</h1>
        <form action="/New" id="createUser" method="POST">
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
            <p id="formError" class='error' style="display:none;"></p>
            <input type="submit" value="Create account">
        </form>
        <div id="formResult" class="success text-center" style="display:none;"></div>
        <div class="text-center" >
            <a href="/Login">Login to the system</a>
        </div>
        
    </div>
    <img src="assets/images/kermit-new.jpg" alt="Contact kermet" class="imgCard w70">
</main>
<?php include('components/footer.php'); ?>