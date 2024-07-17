
/*
    @todo
    - Titulo para erros
*/
//shopping information
var shoppingCart = [];
let minimumOrder = 10;
var sutotal = 0;
var tax = 0;
var total = 0;
let province = "AB";
let taxRateByProvince = {
    AB:0.05,
    BC:0.05,
    MB:0.05,
    NT:0.05,
    NU:0.05,
    QC:0.05,
    SK:0.05,
    YT:0.05,
    ON:0.13,
    NB:0.15,
    NL:0.15,
    NS:0.15,
    PE:0.15
}


//Load on click event in add to cart buttons
document.addEventListener('DOMContentLoaded', (event) => {
    let cards = document.querySelectorAll('.card button');

    cards.forEach((button) => {
        button.addEventListener('click', (event) => {
            addToShoppingCart(event.target.parentElement);
        });
    });
});


//Forrmat price to decimal
function priceToDecimal(price) {
    price = price.replace("$", "");
    price = price.replace(",", "");
    return parseFloat(price);
}

//Add to shopping cart
function addToShoppingCart(product) {

    //Show checkout page
    document.getElementById("welcome").style.display = "none";
    document.getElementById("pageCheckout").style.display = "block";
    document.getElementById("pageForm").style.display = "none";
    document.getElementById("thankyou").style.display = "none";


    var id = product.id;
    var name = product.getElementsByTagName('h3')[0].innerText;
    var price = product.getElementsByTagName('div')[0].getElementsByTagName('div')[0].innerText;
    var price = priceToDecimal(price);
    var image = product.getElementsByTagName('img')[0].src;

    //product already in cart
    var obj = shoppingCart.filter(item => item.name === name);

    //if product already in cart update quantity or add 1
    var qt = 1;
    if (obj.length > 0) { 
        qt = obj[0].qt + 1;
    }

    //Removo item to avoid duplicate product from cart
    shoppingCart = shoppingCart.filter(item => item.name !== name);

    //Add product to cart
    shoppingCart.push({ id: id, name: name, price: price, image: image, qt: qt });

    updateShoppingCart();
}

//Update shopping cart
function updateShoppingCart() {
    
    //Clear the cartItens div
    let cart = document.getElementById("cartItens");
    cart.innerHTML = '';

    //Add products to cart
    shoppingCart.forEach((product) => {
        var item = document.createElement('div');
        item.className = "cartIten"
        item.innerHTML = `
            <img src="${product.image}" alt="${product.name}">
            <h4>${product.name}</h4>
            <p>${product.qt} X <strong>$${product.price}</strong></p>
            <div>
                <button class="removeToShoppingCart" onClick='removeItem(this.parentElement.parentElement)'> 
                    <span class="fa fas far fa-trash"></span> 
                </button>
            </div>
        `;
        cart.appendChild(item);

        updatePriceInShoppingCart();
    });
}

//Update price in shopping cart
function updatePriceInShoppingCart() {

    //Clear the checkout div
    var checkout = document.getElementById("checkout");
    checkout.innerHTML = "";

    //If there are products in the cart
    if (shoppingCart.length > 0) {

        subTotal = 0;

        //Calculate the subtotal price
        shoppingCart.forEach((product) => {
            subTotal += product.price * product.qt;
        });

        //Calculate the tax
        tax = subTotal * taxRateByProvince[province];

        //Calculate the total price
        total = subTotal + tax;

        //Update the checkout div
        var checkout = document.getElementById("checkout");
        checkout.innerHTML = `
            <p>Subtotal: $${parseFloat(subTotal).toFixed(2)}</p>
            <p>Shipping & Handling: $0.00</p>
            <p>Estimated GST/HST(${taxRateByProvince[province]*100}%): $${parseFloat(tax).toFixed(2)}</p>
            <p>Porvince: ${province} - <a href="#" onClick="document.querySelector('#provinceSelect').style.display = 'block'">Change province</a></p>
            <div id="provinceSelect" class="provinceSelect">
                <select name="provinceInCart" id="provinceInCart" onChange="province=this.value;updatePriceInShoppingCart();">
                    <option value="AB">Alberta</option>
                    <option value="BC">British Columbia</option>
                    <option value="MB">Manitoba</option>
                    <option value="NB">New Brunswick</option>
                    <option value="NL">Newfoundland and Labrador</option>
                    <option value="NS">Nova Scotia</option>
                    <option value="NT">Northwest Territories</option>
                    <option value="NU">Nunavut</option>
                    <option value="ON">Ontario</option>
                    <option value="PE">Prince Edward Island</option>
                    <option value="QC">Quebec</option>
                    <option value="SK">Saskatchewan</option>
                    <option value="YT">Yukon</option>
                </select>
            </div>
            <h3>TOTAL:$${parseFloat(total).toFixed(2)}</h3>
            <button class="checkoutButton" onClick='payment()'>Place order</button> `;

        //Update the province select
        document.querySelector(`#provinceInCart option[value="${province}"]`).selected = true;
        document.querySelector(`#province option[value="${province}"]`).selected = true;

    }
}

//Remove item from shopping cart
function removeItem(item) {

    var product = item.getElementsByTagName('h4')[0].innerText;
    var msg = `Do you want to remove product "${product}" from your shopping cart?`;
    //If user want to remove the product
    if (confirm(msg)) {
        //Remove product from cart
        shoppingCart = shoppingCart.filter(item => item.name !== product);
        //Update the cart
        updateShoppingCart();
        //Update the price
        updatePriceInShoppingCart();
        //If the cart is empty show the welcome page
        if(shoppingCart.length == 0){
            document.getElementById("welcome").style.display = "block";
            document.getElementById("pageCheckout").style.display = "none";
            document.getElementById("pageForm").style.display = "none";
            document.getElementById("thankyou").style.display = "none";
        }
    }
}

//Payment page
function payment() {
    //Check if the total is greater than the minimum order price before going to the payment page
    if (total >= minimumOrder) {
        document.getElementById("welcome").style.display = "none";
        document.getElementById("pageCheckout").style.display = "none";
        document.getElementById("pageForm").style.display = "block";
        document.getElementById("thankyou").style.display = "none";
    } else {
        //Inform user about the minimum order price
        alert(`Minimum order is ${parseFloat(minimumOrder).toFixed(2)}`);
    }
}



//Form validation
function validateForm() {
    var errors = "";

    //Name
    var name = document.getElementById("name");
    name.style.borderColor = "green";
    if (name.value.trim().length <= 1) {
        name.style.borderColor = "red";
        errors += "Please enter the name<br>";
    }

    // //Phone format (111) 111-1111
    var phoneregex = /^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$/;
    var phone = document.getElementById("phone");
    phone.style.borderColor = "green";
    if (!phoneregex.test(phone.value.trim())) {
        phone.style.borderColor = "red";
        errors += "Please enter the phone<br>";
    }

    //Email format name@domain.com
    var emailregex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    var email = document.getElementById("email");
    email.style.borderColor = "green";
    if (!emailregex.test(email.value.trim())) {
        email.style.borderColor = "red";
        errors += "Please enter a valid email<br>";
    }


    /* 
        Password strength at least:
        - one digit
        - a lowercase letter
        - an uppercase letter
        - a special character
        - at least 8 characters.    
    */
    var passwordregex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$!%*?&])[A-Za-z\d@#$!%*?&]{8,}$/;

    var password = document.getElementById("password");
    password.style.borderColor = "green";

    var cpassword = document.getElementById("cpassword");
    cpassword.style.borderColor = "green";

    if (!passwordregex.test(password.value.trim())) {
        password.style.borderColor = "red";
        errors += `Your password must contain at least:<br>
                    - one digit<br>
                    - a lowercase letter<br>
                    - an uppercase letter<br>
                    - a special character<br>
                    - at least 8 characters.<br>`;
    }

    //Password match
    if (password.value.trim() != cpassword.value.trim()) {
        cpassword.style.borderColor = "red";
        errors += "Passwords do not match<br>";
    }

    // //Postcode format
    var postcoderegex = /^[A-Z][0-9][A-Z]\s[0-9][A-Z][0-9]$/;

    var postcode = document.getElementById("postcode");
    postcode.style.borderColor = "green";

    if (!postcoderegex.test(postcode.value.toUpperCase())) {
        postcode.style.borderColor = "red";
        errors += "Post code should be in correct format.<br>";
    }

    //City
    var city = document.getElementById("city");
    city.style.borderColor = "green";
    if (city.value.trim().length <= 1) {
        city.style.borderColor = "red";
        errors += "Please enter the city name<br>";
    }

    //Address
    var address = document.getElementById("address");
    address.style.borderColor = "green";
    if (address.value.trim().length <= 1) {
        address.style.borderColor = "red";
        errors += "Please enter the address<br>";
    }

    //Card number format
    var cardregex = /^[0-9]{4}\s[0-9]{4}\s[0-9]{4}\s[0-9]{4}$/;

    var card = document.getElementById("card");
    card.style.borderColor = "green";

    if (!cardregex.test(card.value)) {
        card.style.borderColor = "red";
        errors += "Card number should be in correct format.<br>";
    }

    //Card date format
    var carddateregex = /^[0-9]{2}\/[0-9]{2}$/;

    var cardDate = document.getElementById("date");
    cardDate.style.borderColor = "green";

    if (!carddateregex.test(cardDate.value.toUpperCase())) {
        cardDate.style.borderColor = "red";
        errors += "Card date should be in correct format.<br>";
    }

    //Card date validation
    var cd = cardDate.value.split("/");
    var month = parseInt(cd[0]);
    var year = parseInt(cd[1]) + 2000;
    const current_year = new Date().getFullYear();

    if ((month < 1 || month > 12) || (year < current_year || year > current_year + 10)) {
        cardDate.style.borderColor = "red";
        errors += "Card date should be in correct format.<br>";
    }

    var today, someday;
    today = new Date();
    someday = new Date();
    someday.setFullYear(year, month, 1);

    if (someday < today) {
        cardDate.style.borderColor = "red";
        errors += "The expiry date is before today's date. Please select a valid expiry date";
    }

    //CCV
    var ccvregex = /^[0-9]{3}$/;

    var cardccv = document.getElementById("ccv");
    cardccv.style.borderColor = "green";

    if (!ccvregex.test(cardccv.value.toUpperCase())) {
        cardccv.style.borderColor = "red";
        errors += "CCV should be in correct format.<br>";
    }

    if (errors != "") {
        document.getElementById("formErrors").innerHTML = "<h4>Ops! Check the errors below.</h4>"+errors;
        return false;
    } else {
        thankyou();
    }

    return false;
}



//Thank you page
function thankyou() {
    //Show the thank you page
    document.getElementById("welcome").style.display = "none";
    document.getElementById("pageCheckout").style.display = "none";
    document.getElementById("pageForm").style.display = "none";
    document.getElementById("thankyou").style.display = "block";

    //Get the form values
    var name = document.getElementById("name");
    var address = document.getElementById("address");
    var province = document.getElementById("province");
    var city = document.getElementById("city");
    var postcode = document.getElementById("postcode");
    var orderNumber = Math.floor(Math.random() * (99999 - 100 + 1) + 100);;

    //Get the product list
    var productList = "";
    shoppingCart.forEach((product) => {
        productList += `<li>${product.qt} X ${product.name} ($${parseFloat(product.price).toFixed(2)} each) 
                        <Br> Total: $${parseFloat(product.qt*product.price).toFixed(2)}</li>`;
    });

    //Create the thank you page
    var page = `
        <h2>3/3 Thank you ${name.value} for your purchase</h2>
        <br>
        <img src="./assets/images/delivery.png"><br><br>
        <p>Your order will be delivered within 5 days:<p>
        <dl>
            <dd><strong>Shipping address:</strong> ${address.value}, ${city.value}, ${province.value}, ${postcode.value}</dd>
        </dl>
        <p>Your package will be delivered by: Super Fast transportation. <strong>Your tracking code is #${orderNumber}</strong></p><br>
        <hr>
        <h3>Order details:</h3>
        <ul>
            ${productList}
        </ul>
        <hr>
        <h3>Payment details:</h3><br>
        <p>Subtotal: $${parseFloat(subTotal).toFixed(2)}</p>
        <p>Shipping & Handling: $0.00</p>
        <p>Estimated GST/HST(${taxRateByProvince[province.value]*100}%): $${parseFloat(tax).toFixed(2)}</p>
        <h4>TOTAL:$${parseFloat(total).toFixed(2)}</h4><br>
        <p>Thank you for shopping with us!</p><br>
        <button class="checkoutButton" onClick='location.reload()'>Back to shopping</button>
    `;
    document.getElementById("thankyou").innerHTML = page;
}