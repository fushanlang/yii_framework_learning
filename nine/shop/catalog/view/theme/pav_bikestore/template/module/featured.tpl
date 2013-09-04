<?php 
	$cols = 4;
	$span = 100/$cols; 
?>
<div class="box box-produce featured">
  <div class="box-heading"><h3><span><?php echo $heading_title; ?></span></h3></div>
  <div class="box-content">
    <div class="box-product" style="width:100%">
			  <?php foreach ($products as $i => $product) {   ?>
				<!-- <?php if( $i++%$cols == 0) { ?>
				  <div class="row-fluid">
				<?php } ?> -->
			  <div class="product-block" style="width:<?php echo $span;?>%"><div class="product-inner">
				<?php if ($product['thumb']) { ?>
				<div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
				<?php } ?>
				<div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
				<?php if ($product['rating']) { ?>
				<div class="rating"><img src="catalog/view/theme/pav_bikestore/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
				<?php } ?>
				<?php if ($product['price']) { ?>
				<div class="price">
				  <?php if (!$product['special']) { ?>
				  <?php echo $product['price']; ?>
				  <?php } else { ?>
				  <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
				  <?php } ?>
				</div>
				<div class="wishlist-compare">
					  <a class="wishlist" onclick="addToWishList('<?php echo $product['product_id']; ?>');" title="<?php echo $this->language->get("button_wishlist"); ?>" ><?php echo $this->language->get("button_wishlist"); ?></a>
					  <a class="compare"  onclick="addToCompare('<?php echo $product['product_id']; ?>');" title="<?php echo $this->language->get("button_compare"); ?>" ><?php echo $this->language->get("button_compare"); ?></a>
			 </div>				<?php } ?>
				
				<div class="cart"><input type="button" value="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button" /></div>
			  
			  </div></div>
			  
			  <!--<?php if( $i%$cols == 0 || $i==count($products) ) { ?>
				 </div>
				<?php } ?> -->
				
			  <?php } ?>

    </div>
  </div>
</div>
