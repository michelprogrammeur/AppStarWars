<?php ob_start(); ?>
<h1>Page Produit</h1>

<section class="product clearfix">
    <?php foreach ($product as $p): ?>
        <h2 class="title_product"><?php echo $p->title; ?><span><?php echo $p->published_at; ?></span></h2>

        <div class="content_tags_product">
            <span>Tags:</span>
            <?php if($tags = $tag->productTags($p->id)): ?>
                <?php foreach($tags as $t): ?>
                    <p class="tags"><?php echo $t->name; ?></p>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <?php if($image->productImage($p->id)): ?>
        <img class="image_product" src="<?php echo url('uploads', $image->productImage($p->id)->uri); ?>">
        <?php endif; ?>
        <div class="content_price_quantity">
            <p class="product_price"><?php echo $p->price ?> €</p>
            <form action="<?php echo url('command'); ?>" method="post">
                <input type="hidden" name="price" value="<?php echo $p->price; ?>"/>
                <input type="hidden" name="name" value="<?php echo $p->id; ?>"/>
                <p class="quantity">Quantity</p>
                <select name="quantity" id="quantity">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                <input class="btn_primary" type="submit" value="Submit">
            </form>
        </div>
        <h3 class="description_title"><?php echo $p->title; ?></h3>
        <p class="description_product"><?php echo $p->content; ?></p>
    <?php endforeach; ?>
</section>

<?php
$content = ob_get_clean();
include __DIR__.'/../layouts/master.php';
