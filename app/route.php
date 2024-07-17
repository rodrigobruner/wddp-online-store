<?php
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