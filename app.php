<?php

require_once __DIR__. '/vendor/autoload.php';

define('SALT', '1fJxj0yZigmMNCAq');
define('DEBUG', false); // debug et permet de voir les requetes utilisé
define('VALID_TIME_TOKEN', 2);
/*-----------------------*\
     helpers
\*-----------------------*/
//view('front.partials.index', $data); // __DIR__./resources/views/front/partials/index.php
function view($path, array $data, $status = '200 Ok')
{
    $fileName = __DIR__.'/resources/views/'. str_replace('.', '/', $path). '.php';
    //var_dump($fileName);
    if(!file_exists($fileName)) die(printf('this file doesn\'t exists %S', $fileName));

    header("HTTP/1.1 $status");
    header('Content-type: text/html; charset=UTF-8');

    extract($data);
    include $fileName;
}

function url($path='', $params="") {
    if(!empty($params)) {
        $params = "/$params";
    }
    return 'http://localhost:8000/'.$path.$params;
}
// Token verification
function token()
{
    $token = md5(date('Y-m-d h:i:00') . SALT);
    return '<input type="hidden" name="_token" value="' . $token . '">';
}
function checked_token($token)
{
    if (!empty($token)) {
        foreach (range(0, VALID_TIME_TOKEN) as $v) {
            if (($token == md5(date('Y-m-d h:i:00', time() - $v * 60) . SALT))) {
                return true;
            }
        }
        return false;
    }
    throw new RuntimeException('no _token checked');
}

/*-----------------------*\
          Request
\*-----------------------*/

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = strtolower($_SERVER["REQUEST_METHOD"]);

//var_dump($uri);
//var_dump($method);

//die;

/*--------------------------------*\
    Controller
\*--------------------------------*/

use Controllers\FrontController;

/*--------------------------------*\
    Connect database
\*--------------------------------*/
\Connect::set([
    'dsn' => 'mysql:host=localhost;dbname=db_starwars',
    'username' => 'root',
    'password' => ''
]);



/*--------------------------------*\
    Router
\*--------------------------------*/

if($method=='get')
{
    switch($uri)
    {
        case "/":
            //echo "page d'accueil";
            $frontController = new Controllers\FrontController;
            $frontController->index();
            break;

        // /casque/1 ou laser/2 ou laser/1 ...
        case preg_match('/\/product\/([1-9][0-9]*)/', $uri, $m) == 1:
            $front = new Controllers\FrontController;
            $front->Show($m[1]);
            break;

        // catégories
        case preg_match('/\/category\/([1-9][0-9]*)/', $uri, $m) == 1:
            $frontController = new Controllers\FrontController;
            $frontController->showCategory($m[1]);

            break;

        /* formulaire */
        case "/cart":
            $frontController = new Controllers\FrontController;
            $frontController->showCart();
            break;

        default:
            $message = 'Page Not Found';
            view('front.404', compact('message'), '404 Not Found');
    }
}

if($method=='post')
{
    switch($uri)
    {
        case "/command":
            $frontController = new Controllers\FrontController;
            $frontController->command();
            break;

        case "/store":
            $frontController = new Controllers\FrontController;
            $frontController->store();
            break;
    }
}

