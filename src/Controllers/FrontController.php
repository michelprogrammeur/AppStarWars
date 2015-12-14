<?php namespace Controllers;

use Models\Product;
use Models\Image;
use Models\Tag;
use Models\Category;
use Models\Customer;
use Models\History;
use Cart\Cart;
use Cart\SessionStorage;


class FrontController
{
    protected $cart;

    public function __construct()
    {
        $cart = new Cart(new SessionStorage('starwars'));
        $this->cart = $cart;

    }



    public function index()
    {
        $product = new Product;
        $image = new Image;
        $tag = new Tag;
        $products = $product->all();
        $category = new Category();
        $categories = $category->all();
        view('front.index', compact('products', 'image', 'tag', 'categories'));
    }

    public function show($id)
    {
        $image = new Image;
        $tag = new Tag;
        $products = new Product;
        $product = $products->productId($id);
        $category = new Category();
        $categories = $category->all();
        view('front.single', compact('product', 'image', 'tag', 'categories'));
    }

    public function showCategory($id)
    {
        $category = new Category;
        $products = $category->products($id);
        $image = new Image;
        $tag = new Tag;
        $category = new Category();
        $categories = $category->all();
        view('front.categories', compact('products', 'image', 'tag', 'categories'));
    }

    public function allCategory()
    {
        $category = new Category;
        $categories = $category->all();
        view('front.index', compact('categories'));
    }


    public function command()
    {

        $rules = [
            'name' => FILTER_VALIDATE_INT,
            'price' => FILTER_VALIDATE_FLOAT,
            'quantity' => FILTER_VALIDATE_INT
        ];

        $sanitize = filter_input_array(INPUT_POST, $rules);


        $product = new Product;
        $p = $product->find($sanitize['id']);

        $productCart = new \Cart\Product($sanitize['name'], $sanitize['price']);
        $this->cart->buy($productCart, $sanitize['quantity']);

        $this->redirect(url());
    }


    public function showCart()
    {
        $image = new Image;
        $category = new Category();
        $categories = $category->all();
        $storage = $this->cart->all();
        $products = [];

        foreach ($storage as $id => $total) {
            $p = new Product;
            $stmt = $p->find($id);

            $products[$stmt->title]['price'] = $stmt->price;
            $products[$stmt->title]['total'] = $total;
            $products[$stmt->title]['quantity'] = $total/$stmt->price; // todo price = 0
            $products[$stmt->title]['product_id'] = $id;
        }

        view('front.cart', compact('products', 'image', 'categories'));
    }


    private function redirect($path, $status='200 Ok')
    {
        header("HTTP/1.1 $status");
        header('Content-Type: html/text charset=UTF-8');
        header("Location: $path");
        exit;
    }

    public function store() {
        if(!checked_token($_POST[' token'])) {
            $this->redirect(url('cart'));
        }

        if (empty($_SESSION)) session_start();

        if(!empty($_SESSION['old'])) $_SESSION['old'] = [];
        if(!empty($_SESSION['error'])) $_SESSION['error'] = [];

        $rules = [
            'email'   => FILTER_VALIDATE_EMAIL,
            'number'  => [
                'filter'  => FILTER_CALLBACK,
                'options' => function ($nb) {
                    if (preg_match('/[0-9]{16}/', $nb))
                        return (int)$nb;
                    return false;
                }
            ],
            'address' => FILTER_SANITIZE_STRING,
        ];
        $sanitize = filter_input_array(INPUT_POST, $rules);
        var_dump($sanitize);
        $error = false;

        if (!$sanitize['email']) {
            $_SESSION['error']['email'] = 'your email is invalid';
            $error = true;
        }
        if (!$sanitize['number']) {
            $_SESSION['error']['number'] = 'your number blue card is invalid';
            $error = true;
        }
        if (!$sanitize['address']) {
            $_SESSION['error']['address'] = 'you must given your address';
            $error = true;
        }

        if ($error) {
            $_SESSION['old']['email'] = $sanitize['email'];
            $_SESSION['old']['address'] = $sanitize['address'];
            $this->redirect(url('cart'));
        }

        try {
            \Connect::$pdo->beginTransaction();

            $history = new History;
            $customer = new Customer;

            $customer->create([
                'email' => $sanitize['email'],
                'number' => $sanitize['number'],
                'address' => $sanitize['address']
            ]);
            $customerId = \Connet::$pdo->lastInsertId();

            $storage = $this->cart->all();

            foreach ($storage as $id => $total) {
                $p = new Product;
                $stmt = $p->find($id);

                $history->create([
                    'product_id' => $id,
                    'customer_id' => $customerId,
                    'price' => $stmt->price,
                    'total' => $total,
                    'quantity' => $total/$stmt->price,
                    'commanded_at' => date('Y-m-s h:i:s')
                ]);

            }
            \Connect::$pdo->commit();

            $this->cart->reset();
            $this->redirect(url());

        }catch (\PDOException $e)
        {
            \Connect::$pdo->rollback();
        }
    }
}