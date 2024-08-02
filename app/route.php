<?php
include("app/Library/db_conection.php");
class Router {

    protected $routes = []; 

    public function getURI() {
        $uri = $_SERVER['REQUEST_URI'];
        $uri = explode('?', $uri);
        return $uri[0];
    }

    public function getMETHOD() {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function get(string $url, closure $target) {
        $this->routes['GET'][$url] = $target;
    }

    public function post(string $url, closure $target) {
        $this->routes['POST'][$url] = $target;
    }

    public function checkRoute() {
        $method = $this->getMETHOD();
        $uri = $this->getURI();

        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $routeUrl => $target) {
                if ($routeUrl === $uri) {
                    call_user_func($target);
                }
            }
        }
        include('pages/system/404.php');
    }
}


$router = new Router();

$router->get('/', function () {
    include('pages/home.php');	
    exit;
});

$router->get('/About', function () {
    include('pages/about.php');	
    exit;
});

$router->get('/Contact', function () {
    include('pages/contact.php');	
    exit;
});

$router->get('/New', function () {
    include('pages/create.php');	
    exit;
});

$router->get('/Login', function () {
    include('pages/login.php');	
    exit;
});

$router->get('/Logout', function () {
    session_destroy();
    header('Location:/');	
    exit;
});

$router->post('/Login', function () {
    $username = strtolower($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $sqlQuery = "SELECT * FROM `user` WHERE `email` = '$username'";
    $db = DB::getConection();
    $sqlResult = $db->query($sqlQuery);
    if($sqlResult->num_rows == 1) {
        while($row = $sqlResult->fetch_assoc()){
            if(! password_verify($password, $row['password'])){
                header('Location:/Login?error=Invalid user or password');
            }
            $_SESSION['userName'] = $row['name'];
            $_SESSION['userId'] = $row['id'];
        break;
        }
        header('Location:/');
    } else {
        header('Location:/Login?error=Invalid user or password');
    }
    exit;
});

// Create new User
$router->post('/New', function () {
    header('Content-Type: application/json');
    
    $username = strtolower(trim($_POST["name"]));
    $email = strtolower($_POST["email"]);
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];

    $error="";
    if($username == "") {
        $error .= "* Name field required<br>"; 
    }

    if(is_null($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error .= "* Invalid email<br>"; 
    }

    $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/";
    if (!preg_match($pattern, $password)) { 
        $error .= "* The password must be at least 8 characters long, containing at least one uppercase letter, one lowercase letter and one digit. <br>";
    }

    if($password != $cpassword){
        $error .= "* Password confirmation different from password $password != $cpassword <br>"; 
    }

    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    if($error != ""){
        $response = [
            "status" => "error",
            "msg" => $error
        ];
        echo json_encode($response);
        die;
    }

    $sqlQuery = "INSERT INTO user (name, email, password) VALUES('$username', '$email', '$password')";

    $db = DB::getConection();
    if ($db->query($sqlQuery) === TRUE) {
        $response = [
            "status" => "success",
            "msg" => "User created successfully"
        ];
        echo json_encode($response);
    } else {
        $response = [
            "status" => "error",
            "msg" => "Unable to create a new user, check that you don't already have an account."
        ];
        echo json_encode($response);
    }
    exit;
});

$router->get('/ShoppingCart', function () {
    include('pages/shoppingCart.php');	
    exit;
});

$router->get('/Payment', function () {
    include('pages/payment.php');	
    exit;
});

$router->post('/Shipping', function () {
    include('pages/shipping.php');	
    exit;
});

$router->checkRoute();
?>