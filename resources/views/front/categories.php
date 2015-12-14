<?php ob_start() ?>
    <ul>
        <?php foreach ($products as $product): ?>
            <li class="list_product">
                <h2><a href="<?php echo url('product', $product->id); ?>"><?php echo $product->title; ?></a></h2>

                <div class="content_tags">
                    <span>Tags:</span>
                    <?php if($tags = $tag->productTags($product->id)): ?>
                        <?php foreach($tags as $t): ?>
                            <p class="tags"><?php echo $t->name; ?></p>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <?php if($image->productImage($product->id)): ?>
                    <img src="<?php echo url('uploads', $image->productImage($product->id)->uri); ?>">
                <?php endif; ?>

                <p class="abstract"><?php echo $product->abstract; ?></p>
                <p class="price"><?php echo $product->price; ?> €</p>
            </li>
        <?php endforeach; ?>
    </ul>
<?php $content = ob_get_clean() ?>
<?php include __DIR__ . '/../layouts/master.php' ?>