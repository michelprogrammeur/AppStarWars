<html xmlns="http://www.w3.org/1999/html">
    <head>
        <meta charset="utf-8">
    </head>
    <body>

    </body>
</html>


<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Boutique Star Wars</title>
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <link rel ='stylesheet' href="<?php echo url('assets\css\skeleton.css'); ?>">
    <link rel ='stylesheet' href="<?php echo url('assets\css\normalize.css'); ?>">

    <link rel="icon" type="image/png" href="images/favicon.png">

    <style>
        body {
            background-image: url("<?php echo url('assets/images/fond.jpg'); ?>");
        }
    </style>
</head>
<body>

<header id="header">
    <div id="menu" class="clearfix">
        <img id="logo" src="<?php echo url('assets\images\star-wars-logo.png'); ?>" alt="">
        <p class="e-shop">E-shop</p>
        <nav>
            <ul>
                <?php foreach ($categories as $category): ?>
                    <li class="categories hvr-underline-reveal"><a href="<?php echo url('category', $category->id) ?>"><?php echo $category->title; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </nav>
        <a class="fa fa-shopping-cart" id="cart" href="<?php echo url('cart'); ?>"></a>
    </div>
</header>
<div class="container">
    <div class="row">

        <div class="one-half column">
            <?php echo $content; ?>
        </div>
    </div>
</div>

</body>
</html>
