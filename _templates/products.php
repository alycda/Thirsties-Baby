<?php include('_includes/header.php'); ?>



<?php if($urlPath_array[1]) { ?>
	<?php $get_page_content = mysql_query("SELECT category_slug, page_title, page_content FROM cms_categories WHERE category_slug = '".$urlPath_array[1]."'")?>
	<?php $page_content = mysql_fetch_assoc($get_page_content);?>

	<?php $get_product_categories = mysql_query("SELECT * FROM cms_categories WHERE category_slug = '".$urlPath_array[1]."' AND category_active ORDER BY category_order ASC ")?>

<?php } else { ?>
	<?php $get_page_content = mysql_query("SELECT category_slug, page_title, page_content FROM cms_categories WHERE category_slug = '".$urlPath_array[0]."'")?>
	<?php $page_content = mysql_fetch_assoc($get_page_content);?>

	<?php $get_product_categories = mysql_query("SELECT * FROM cms_categories WHERE category_parent_id = 2 AND category_active ORDER BY category_order ASC ")?>

<?php } ?>

<div class="main_content">
	<div class="page_header border8">
		<div class="ind">
			<img class="left border18" src="/_images/header_image334x252/products_header.jpg" width="334" height="252"/>
			<div class="page_content right">
				<div class="ind">
					<h3><?php echo $page_content['page_title'];?></h3>
					<?php echo stripslashes($page_content['page_content']);?>
				</div>
			</div>
		<br class="clear"/>
		</div>
	</div>


<?php while ($product_category = mysql_fetch_assoc($get_product_categories)) {
  $get_products = mysql_query("select content_id, content_title, content_slug, content_content_5, content_image_1 from cms_content where category_id = ".(int)$product_category['category_id']." and content_active order by content_order desc"); ?>

  <form action="<?php echo $urlPath_array[0]; ?>/compare/" method="post">
  <input type="hidden" name="compare_category_id" value="<?php echo $product_category['category_id']; ?>" />
	<div class="page_divider border18">
		<div class="ind">
		  <a name="<?php echo $product_category['category_slug']; ?>"></a>
			<h2 class="left"><?php echo stripslashes($product_category['category_name']); ?></h2>
			<input type="submit" class="right small border18 compare" value="Compare Selected" />
			<br class="clear"/>
		</div>
	</div>





	<ul id="item_list" class="nav">
<?php while($product = mysql_fetch_assoc($get_products)) { ?>
<?php $get_swatches = mysql_query("select c.content_id, c.content_title, c.content_title_2, c.content_image_1, ca.field_1 from cms_content c join cms_associated_content ca on c.content_id = ca.child_content_id where ca.child_category_id = 42 and ca.content_id = ".(int)$product['content_id']." order by c.content_order desc"); ?>
		<li id="" class="item">
			<a href="/<?php echo $urlPath_array[0] . '/' . $product_category['category_slug'] . '/' . $product['content_slug'] ?>/"><img src="<?php echo $_IMAGE_FOLDERS['products_main_300x300'] . $product['content_image_1']; ?>" width="252" /></a>
			<ul class="swatches">
<?php
    $i = 1;
    while ($swatch = mysql_fetch_assoc($get_swatches)) {
      $background = '#'.$swatch['content_title_2'];
      if (!empty($swatch['content_image_1'])) {
        $background = 'url('.$_IMAGE_FOLDERS['products_prints100x100'] . $swatch['content_image_1'].')';
      }
?>
				<li<?php echo ($i == 1?' class="selected"':''); ?>><a href="<?php echo $_IMAGE_FOLDERS['products_main_300x300'] . $swatch['field_1']; ?>" style="background:<?php echo $background; ?>;" title="<?php echo stripslashes($swatch['content_title']); ?>" class="border9"><?php echo stripslashes($swatch['content_title']); ?></a></li>
<?php
      $i++;
    }
?>
			</ul>
			<div class="item_info border18">
				<h4><a href="/<?php echo $urlPath_array[0] . '/' . $product_category['category_slug'] . '/' . $product['content_slug'] ?>/"><?php echo $product['content_title']; ?></a></h4>
				<!--p class="small"><?php echo stripslashes($product['content_content_5']); ?></p-->
				<p class="small">Thirsties <strong>Duo Diapers</strong> are waterproof yet remain completely breatheable, pliable and very comfortable.</p>
				<hr/>
				<span class="compare_check center"><input type="checkbox" name="compare[]" value="<?php echo $product['content_id']; ?>" />compare</span>
			</div>
		</li>
	<?php } ?>
	</ul>
	</form>
<?php } //end while ?>


	<br class="clear"/>
</div>

<?php include('_includes/footer.php'); ?>