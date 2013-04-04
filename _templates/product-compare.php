<?php 

if (!is_array($_POST['compare']))
  $_POST['compare'] = array(0);

$new_compare = array();
$compare_count = count($_POST['compare']);
for($i = 0, $n = $compare_count; $i < $n; $i++) {
  if ($n > 3)
    $n = 3;
  $new_compare[$i] = (int)$_POST['compare'][$i];
}

$_POST['compare'] = $new_compare;

$product_urls = array();
$product_ids = array();
$product_images = array();
$product_names = array();
$product_description = array();
$product_price = array();
$product_features = array();
$product_content = array();

$get_compare_products = mysql_query("select c.* from cms_content c join cms_categories cat on cat.category_id = c.category_id where cat.category_parent_id = 2 and c.content_id in (".implode(',', $_POST['compare']).") and c.content_active order by c.content_order desc") or die (mysql_error());
while ($compare_product = mysql_fetch_assoc($get_compare_products)) {

  $get_product_category = mysql_query("select category_slug from cms_categories where category_id = ".(int)$compare_product['category_id']." limit 1");
  $product_category = mysql_fetch_assoc($get_product_category);

  $product_urls[] = $urlPath_array[0] . '/' . $product_category['category_slug'] . '/' . $compare_product['content_slug'] . '/';
  $product_ids[] = $compare_product['content_id'];
  $product_images[] = $compare_product['content_image_1'];
  $product_names[] = stripslashes($compare_product['content_title']);
  $product_descriptions[] = stripslashes($compare_product['content_title_2']);
  $product_prices[] = stripslashes($compare_product['content_title_3']);
  $product_features[] = stripslashes($compare_product['content_content_1']);
  $product_content[] = stripslashes($compare_product['content_content_2']);
}

include('_includes/header.php'); ?>

<div class="main_content">
	<div class="page_divider border18">
		<div class="ind">
			<h2 class="left">Product Comparison</h2>
			<a id="compare" class="right small border18" href="<?php echo $urlPath_array[0]; ?>/">Back to Previous Page</a>
			<br class="clear"/>
		</div>
	</div>
<?php if ($compare_count > 3) { ?>
	<div class="error border9">You can only compare 3 products at a time. ".($compare_count - 3)." products were removed from the comparison.</div>
<?php } elseif (empty($compare_count)) { ?>
  <div class="error border9">You can must choose atleast 2 products to compare.</div>
<?php } ?>
<?php if ($compare_count >= 2 || true) { ?>
	<div class="table border18">
	<table id="compare">
		<tr><!--class="product-images"-->
			<th style="border-top:0; border-bottom: 0; border-left:0; background:#f0f0f0;"><h4 style="color: #b4b4b4;">Product Images</h4></th> 

		<?php for($i = 0, $n = $compare_count; $i < $n; $i++) { ?>
			<td style="border-top:0;border-bottom:0;<?php echo ($i == 2?'border-right:0; ':''); ?>">
				<a href="<?php echo $product_urls[$i]; ?>" id="<?php echo $product_ids[$i]; ?>" title="<?php echo $product_names[$i]; ?>">
					<img id="main_img" class="center" src="<?php echo $_IMAGE_FOLDERS['products_main_300x300'] . $product_images[$i]; ?>" width="225" height="200" title="<?php echo $product_names[$i]; ?>"/>
				</a>
			</td>
		<?php } //end for ?>
		</tr> <!--END Product Images-->		

<!--////////////////////////////////////////////-->

		<tr> <!--class="product-swatches"-->
			<th style="border-top:0; border-left:0; background:#e6e6e6;">
				<h4 style="color: #b4b4b4;">Available Colors</h4>
			</th>
		<?php for($i = 0, $n = $compare_count; $i < $n; $i++) { ?>
			<td style="border-top:0;<?php echo ($i == 2?'border-right:0; ':''); ?>">
		<?php $get_swatches = mysql_query("select c.content_id, c.content_title, c.content_title_2, c.content_image_1, ca.field_1 from cms_content c join cms_associated_content ca on c.content_id = ca.child_content_id where ca.child_category_id = 42 and ca.content_id = ".(int)$product_ids[$i]." order by c.content_order desc"); ?>
		<?php if (mysql_num_rows($get_swatches) > 0) { ?>
				<ul class="swatches nav">
		<?php while ($swatch = mysql_fetch_assoc($get_swatches)) {
      			$background = '#'.$swatch['content_title_2'];
      			if (!empty($swatch['content_image_1'])) {
        			$background = 'url('.$_IMAGE_FOLDERS['products_prints34x34'] . $swatch['content_image_1'].')';
      			} ?>
			    <li class="">
					<a href="<?php echo $_IMAGE_FOLDERS['products_main_300x300'] . $swatch['field_1']; ?>" rel="zoom-id:<?php echo $product_ids[$i]; ?>" rev="_images/products_main_300x300/aplix_honeydew_500.jpg" onclick="selectSkuImage(this)" style="background:<?php echo $background; ?>;" title="<?php echo stripslashes($swatch['content_title']); ?>" class="border9">
						<?php echo stripslashes($swatch['content_title']); ?>
					</a>
				</li>
		<?php } //end if ?>
				</ul>
		<?php } //end while ?>
			</td>
		<?php } //end for ?>
		</tr> <!--END Available Colors-->

<!--////////////////////////////////////////////-->

		<tr><!--class="product-titles"-->
			<th style="border-left:0; background: #4dc8e9;"><h4 class="white">Product</h4></th>
		<?php for($i = 0, $n = $compare_count; $i < $n; $i++) { ?>
			<td style="<?php echo ($i == 2?'border-right:0; ':''); ?>background: #4dc8e9;"><h3 class="big"><a href="<?php echo $product_urls[$i]; ?>"><?php echo $product_names[$i]; ?></a></h3></td>
		<?php } //end for ?>

		</tr> <!--END Product title-->

<!--////////////////////////////////////////////-->

		<tr class="chocolate">
			<th style="border-left:0; background:#c1edf8; border-color:#fff;"><h4 class="oceanblue">Description</h4></th>
		<?php for($i = 0, $n = $compare_count; $i < $n; $i++) { ?>
			<td<?php echo ($i == 2?' style="border-right:0;"':''); ?>><p><?php echo stripslashes($product_descriptions[$i]); ?></p></td>
		<?php } //end for ?>

		</tr> <!--END Description-->

<!--////////////////////////////////////////////-->

		<tr class="meadow">
			<th style="border-left:0; background:#c1edf8; border-color:#fff;"><h4 class="oceanblue">Price</h4></th>
		<?php for($i = 0, $n = $compare_count; $i < $n; $i++) { ?>
			<td<?php echo ($i == 2?' style="border-right:0;"':''); ?>><p>Suggested Price:<br/><?php echo stripslashes($product_prices[$i]); ?></p></td>
		<?php } // end for ?>

		</tr> <!--END Price-->


<!--////////////////////////////////////////////-->


		<tr><!--class="product_features"-->
			<th style="border-left:0; background:#c1edf8; border-color:#fff;"><h4 class="oceanblue">Features</h4></th>

		<?php for($i = 0, $n = $compare_count; $i < $n; $i++) { ?>
			<td<?php echo ($i == 2?' style="border-right:0;"':''); ?>><?php echo stripslashes($product_features[$i]); ?></td>
<?php } //end for ?>


		</tr> <!--END Features-->

<!--////////////////////////////////////////////-->

		<tr><!--class="product_sizes"-->
			<th style="border-left:0; background:#c1edf8; border-color:#fff;"><h4 class="oceanblue">Available Sizes</h4></th>


		<?php for($i = 0, $n = $compare_count; $i < $n; $i++) { ?>
		<?php $get_sizes = mysql_query("select c.content_title, c.content_title_2, c.content_title_3 from cms_content c join cms_associated_content ca on c.content_id = ca.child_content_id where ca.content_id = ".(int)$product_ids[$i]." and ca.child_category_id = 45 and c.content_active order by c.content_order");
  $count_sizes = mysql_num_rows($get_sizes); ?>
			<td style="border:0;">
		<?php if ($count_sizes > 0) { ?>
				<table class="tiny">
					<tr><th>Size</th><th>Weight Range</th><th style="border-right:none">Age Range</th></tr>
		<?php $ii = 1; ?>
		<?php while ($size = mysql_fetch_assoc($get_sizes)) { ?>
					<tr>
    			  		<td<?php echo ($ii < $count_sizes?' style="border-bottom: 1px solid #ccc;"':''); ?>><?php echo stripslashes($size['content_title']); ?></td>
    			  <td<?php echo ($ii < $count_sizes?' style="border-bottom: 1px solid #ccc;"':''); ?>><?php echo stripslashes($size['content_title_2']); ?></td>
    			  <td<?php echo ($ii < $count_sizes?' style="border-right:none; border-bottom: 1px solid #ccc;"':''); ?>><?php echo stripslashes($size['content_title_3']); ?></td>
    			</tr>
		<?php $i++; ?>
		<?php } //end while ?>
				</table>
		<?php } //end if ?>
			</td>
		<?php } //end for ?>







			<!--td style="border:0">
				<table class="tiny">
					<tr><th>Size</th><th>Weight Range</th><th style="border-right:none">Age Range</th></tr>
					<tr>
						<td style="border-bottom: 1px solid #ccc;">one</td>
						<td style="border-bottom: 1px solid #ccc;">6-18 lbs (3-8 kg) </td>
						<td style="border-right:none; border-bottom: 1px solid #ccc;">0-9 months</td>
					</tr>
					<tr>
						<td>two</td>
						<td>18-40 lbs (8-18 kg)</td>
						<td style="">9-36 months</td>
					</tr>
				</table>
			</td>
			<td style="border:0">
				<table class="tiny">
					<tr><th>Size</th><th>Weight Range</th><th style="border-right:none">Age Range</th></tr>
					<tr>
						<td style="border-bottom: 1px solid #ccc;">one</td>
						<td style="border-bottom: 1px solid #ccc;">6-18 lbs (3-8 kg) </td>
						<td style="border-right:none; border-bottom: 1px solid #ccc;">0-9 months</td>
					</tr>
					<tr>
						<td>two</td>
						<td>18-40 lbs (8-18 kg)</td>
						<td style="">9-36 months</td>
					</tr>
				</table>
			</td>
			<td style="border:0;">
				<table class="tiny">
					<tr><th>Size</th><th>Weight Range</th><th style="border-right:none">Age Range</th></tr>
					<tr>
						<td style="border-bottom: 1px solid #ccc;">one</td>
						<td style="border-bottom: 1px solid #ccc;">6-18 lbs (3-8 kg) </td>
						<td style="border-right:none; border-bottom: 1px solid #ccc;">0-9 months</td>
					</tr>
					<tr>
						<td>two</td>
						<td>18-40 lbs (8-18 kg)</td>
						<td style="">9-36 months</td>
					</tr>
				</table>
			</td-->


		</tr> <!--END Available Sizes-->

<!--////////////////////////////////////////////-->

		<tr><!--style="product_content"-->
			<th style="border-left:0; border-bottom:0; background:#c1edf8; border-color:#fff;"><h4 class="oceanblue">Product Content</h4></th>

		<?php for($i = 0, $n = $compare_count; $i < $n; $i++) { ?>
			<td style="<?php echo ($i == 2?'border-right:0; ':''); ?>border-bottom:0;"><p style="text-align:left;"><?php echo stripslashes($product_content[$i]); ?></p></td>
		<?php } //end for ?>




			<!--td style="border-bottom:0;"><p style="text-align:left;">Dyed with low-impact dyes; Inner layers: 100% polyester; Outer layer: 15% polyester, 85% cotton. Made in USA.</p></td>
			<td style="border-bottom:0;"><p style="text-align:left;">Dyed with low-impact dyes; Inner layers: 100% polyester; Outer layer: 15% polyester, 85% cotton. Made in USA.</p></td>
			<td style="border-right:0; border-bottom:0;"><p style="text-align:left;">Dyed with low-impact dyes; Inner layers: 100% polyester; Outer layer: 15% polyester, 85% cotton. Made in USA.</p></td-->



		</tr> <!--END Product Content-->

<!--////////////////////////////////////////////-->

	</table>
	</div><!--END .border18-->
<?php } ?>

</div><!--END #main_content-->
<script type="text/javascript" src="/_js/product_compare.js"></script>
<?php include('_includes/footer.php'); ?>