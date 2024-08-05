<?php
class Product{
    public $id;
    public $image;
    public $name;
    public $description;
    public $price;
    public $quantity;

    function __construct($id, $image, $name, $description, $price){
        $this->id = $id;
        $this->image = $image;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
    }
}

class ShoppingCart{

    public $products = array();

    function addProduct($product){
        if(isset($this->products[$product->id])){
            $this->products[$product->id]->quantity++;
        }else{
            $product->quantity = 1;
            $this->products[$product->id] = $product;
        }
    }

    function removeProduct($id){
        if(isset($this->products[$id])){
            $this->products[$id]->quantity--;
            if ($this->products[$id]->quantity == 0) {
                unset($this->products[$id]);
            }
        }
    }

    function save(){
        $_SESSION["shoppingCart"] =  serialize($this->products);
    }

    function load(){
        if(@$_SESSION["shoppingCart"] != null){ 
            $this->products = unserialize($_SESSION["shoppingCart"]);
        }
    }
}



class Inventary{

    static function getProducts(){

        $list[0] = false;
        $count = 0;
        $sqlQuery = "SELECT * FROM inventory";
        $db = DB::getConection();
        $sqlResult = $db->query($sqlQuery);
        while ($row = $sqlResult->fetch_assoc()) {
            $count++;
            $list[$count] = new Product($row["id"], $row["image"], $row["name"], $row["description"], $row["price"]);
        }

        // $list[1] = new Product(
        //         1,
        //         "product01.jpg", 
        //         "Dumper toy", 
        //         "Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit sint voluptate temporibus ad qui consequuntur voluptatem ducimus quis fugiat sequi et esse quidem eveniet culpa, consequatur, doloribus dignissimos quibusdam perspiciatis!", 
        //         450.99);
        // $list[2] = new Product(
        //         2,
        //         "product02.jpg", 
        //         "Tractor toy", 
        //         "Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit sint voluptate temporibus ad qui consequuntur voluptatem ducimus quis fugiat sequi et esse quidem eveniet culpa, consequatur, doloribus dignissimos quibusdam perspiciatis!", 
        //         564.55);
        // $list[3] = new Product(
        //         3,
        //         "product03.jpg", 
        //         "Teddy dragon", 
        //         "Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit sint voluptate temporibus ad qui consequuntur voluptatem ducimus quis fugiat sequi et esse quidem eveniet culpa, consequatur, doloribus dignissimos quibusdam perspiciatis!", 
        //         60.95);
        // $list[4] = new Product(
        //         4,
        //         "product04.jpg", 
        //         "Summer clothing set", 
        //         "Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit sint voluptate temporibus ad qui consequuntur voluptatem ducimus quis fugiat sequi et esse quidem eveniet culpa, consequatur, doloribus dignissimos quibusdam perspiciatis!", 
        //         35.95);
        // $list[5] = new Product(
        //         5,
        //         "product05.jpg", 
        //         "Winter clothing set", 
        //         "Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit sint voluptate temporibus ad qui consequuntur voluptatem ducimus quis fugiat sequi et esse quidem eveniet culpa, consequatur, doloribus dignissimos quibusdam perspiciatis!", 
        //         29.99);
        // $list[6] = new Product(
        //         6,
        //         "product06.jpg", 
        //         "Octoberfast clothing set", 
        //         "Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit sint voluptate temporibus ad qui consequuntur voluptatem ducimus quis fugiat sequi et esse quidem eveniet culpa, consequatur, doloribus dignissimos quibusdam perspiciatis!", 
        //         101.55);

        return $list;
    }
}


    $provinces["Alberta"] = 5;
    $provinces["British Columbia"] = 5;
    $provinces["Manitoba"] = 5;
    $provinces["Northwest Territories"] = 5;
    $provinces["Nunavut"] = 5;
    $provinces["Quebec"] = 5;
    $provinces["Saskatchewan"] = 5;
    $provinces["Yukon"] = 5;
    $provinces["Ontario"] = 13;
    $provinces["New Brunswick"] = 15;
    $provinces["Newfoundland and Labrador"] = 15;
    $provinces["Nova Scotia"] = 15;
    $provinces["Prince Edward Island"] = 15;
?>