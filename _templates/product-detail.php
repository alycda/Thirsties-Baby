<?php 
include('_includes/header.php');

$get_page_content = mysql_query("SELECT category_parent_id, category_slug, category_meta_description, page_title, page_content FROM cms_categories WHERE category_slug = '".$urlPath_array[1]."'");
$page_content = mysql_fetch_assoc($get_page_content);

$get_product_categories = mysql_query("SELECT * from cms_categories WHERE category_parent_id = ".$page_content['category_parent_id']);
$get_related_articles = mysql_query("");

//$get_home_posts = mysql_query("SELECT wp_posts.ID, wp_posts.post_title, wp_posts.post_name, wp_posts.post_content, wp_term_relationships.object_id, wp_term_relationships.term_taxonomy_id FROM wp_posts, wp_term_relationships WHERE wp_posts.ID = wp_term_relationships.object_id AND wp_term_relationships.term_taxonomy_id != 3 LIMIT 4");

$get_related_articles = mysql_query("SELECT DISTINCT wp_posts.post_title, wp_posts.guid, wp_terms.name AS tag_name FROM wp_posts LEFT JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id) LEFT JOIN wp_terms ON (wp_term_relationships.term_taxonomy_id = wp_terms.term_id) LEFT JOIN wp_term_taxonomy ON (wp_terms.term_id = wp_term_taxonomy.term_id) WHERE wp_posts.post_status = 'publish' AND wp_posts.post_type = 'post' and wp_terms.name like '".mysql_real_escape_string($product['content_title'])."' ORDER BY post_date DESC limit 5");

$get_testimonials = mysql_query("SELECT * FROM cms_content WHERE category_id = 7 ORDER BY content_date DESC");
?>
<aside class="left">
	<ul id="nav" class="nav">
<?php
while($product_cat = mysql_fetch_assoc($get_product_categories)) {
?>
    <li<?php echo($urlPath_array[2] == $product_cat['category_slug']?' class="selected"':''); ?>><a href="/<?php echo $urlPath_array[0]; ?>/<?php echo $product_cat['category_slug'];?>"><?php echo $product_cat['category_name'];?></a>
<?php
  $get_nav_products = mysql_query("select content_id, content_title, content_slug from cms_content where category_id = ".(int)$product_cat['category_id']." and content_active order by content_order desc");
  if (mysql_num_rows($get_nav_products) > 0) {
?>
      <ul>
<?php
    while ($nav_product = mysql_fetch_assoc($get_nav_products)) {
?>
        <li<?php echo($urlPath_array[2] == $nav_product['content_slug']?' class="selected"':''); ?>><a href="/<?php echo $urlPath_array[0]; ?>/<?php echo $product_cat['category_slug'];?>/<?php echo $nav_product['content_slug'];?>/"><?php echo $nav_product['content_title'];?></a></li>
<?php
    }
?>
      </ul>
<?php
  }
?>
    </li>
<?php
}
?>
	</ul>

  <br class="clear"/>	
<?php
if (mysql_num_rows($get_related_articles) > 0) {
?>
	<ul id="related_articles" class="nav right">
		<li class="title"><h5>Related Articles</h5></li>
		<?php while($home_post = mysql_fetch_assoc($get_related_articles)) { ?>
		<li class="small"><a href="<?php echo $home_post['guid']; ?>"><?php echo $home_post['post_title'];?></a></li>
		<?php } ?>
	</ul>
  <br class="clear"/>	
<?php
}
?>
<?php
$get_awards = mysql_query("select c.content_title, c.content_title_2, c.content_image_1 from cms_content c join cms_associated_content ca on c.content_id = ca.child_content_id where ca.content_id = ".(int)$product['content_id']." and ca.child_category_id = 44 and c.content_active order by c.content_order desc");
if (mysql_num_rows($get_awards) > 0) {
?>
	<ul id="awards" class="">
<?php
  while ($award = mysql_fetch_assoc($get_awards)) {
?>
		<li><a href="<?php echo stripslashes($award['content_title_2']); ?>" target="_blank"><img src="<?php echo $_IMAGE_FOLDERS['products_awards100x100'] . $award['content_image_1']; ?>" title="<?php echo stripslashes($award['content_title']); ?>" /></a></li>
<?php
  }
?>
	</ul>

<br class="clear"/>	
<?php
}
?>
<?php
$get_babies = mysql_query("select c.content_title, c.content_title_2, c.content_image_1, c.content_f1, c.content_f2, c.content_f3 from cms_content c join cms_associated_content ca on c.content_id = ca.child_content_id where ca.content_id = ".(int)$product['content_id']." and ca.child_category_id = 43 and c.content_active order by c.content_order desc");
if (mysql_num_rows($get_babies) > 0) {
?>
	<ul id="babies" class="">
<?php
  while ($baby = mysql_fetch_assoc($get_babies)) {
?>
		<li class="baby <?php echo $baby['content_title_2']; ?>">
			<strong><?php echo stripslashes($baby['content_title']); ?></strong><br/>
			<img src="<?php echo $_IMAGE_FOLDERS['products_babies140x90'] . $baby['content_image_1']; ?>" width="140" height="90"/>
			<ul class="small">
				<li><?php echo stripslashes($baby['content_f1']); ?></li>
				<li><?php echo stripslashes($baby['content_f2']); ?></li>
				<li><?php echo stripslashes($baby['content_f3']); ?></li>
			</ul>
		</li>
<?php
  }
?>
	</ul>
  <br class="clear"/>	
<?php
}
?>
</aside><!--END aside-->
<div id="main_content" class="right">


<div id="pdp-big" style="position: absolute; left: 0px; top: 85px;"></div>


	<span class="price right small"><?php echo stripslashes($product['content_title_3']); ?></span>
	<h2 class="huge"><?php echo stripslashes($product['content_title']);?></h2>
	
	<div class="col left">
		<h3 class="big"><?php echo stripslashes($product['content_title_2']); ?></h3>
<?php
$notags = strip_tags($product['content_content_1']);
if (!empty($notags)) {
  $product['content_content_1'] = str_replace('<ul>', '<ul id="features" class="right">', $product['content_content_1']);
?>
		<h4>Features</h4>
		<?php echo stripslashes($product['content_content_1']); ?>
		<br class="clear"/>
<?php
}
?>
<?php
$get_sizes = mysql_query("select c.content_title, c.content_title_2, c.content_title_3 from cms_content c join cms_associated_content ca on c.content_id = ca.child_content_id where ca.content_id = ".(int)$product['content_id']." and ca.child_category_id = 45 and c.content_active order by c.content_order");
$count_sizes = mysql_num_rows($get_sizes);
if ($count_sizes > 0) {
?>
		<h4>Sizing</h4>
		<div class="border9">
		<table class="small">
			<tr><th>Size</th><th>Weight Range</th><th style="border-right:none">Age Range</th></tr>
<?php
  $i = 1;
  while ($size = mysql_fetch_assoc($get_sizes)) {
?>
			<tr>
			  <td<?php echo ($i < $count_sizes?' style="border-bottom: 1px solid #ccc;"':''); ?>><?php echo stripslashes($size['content_title']); ?></td>
			  <td<?php echo ($i < $count_sizes?' style="border-bottom: 1px solid #ccc;"':''); ?>><?php echo stripslashes($size['content_title_2']); ?></td>
			  <td<?php echo ($i < $count_sizes?' style="border-right:none; border-bottom: 1px solid #ccc;"':' style="border:none"'); ?>><?php echo stripslashes($size['content_title_3']); ?></td>
			</tr>
<?php
    $i++;
  }
?>
		</table>
		</div>
		<br class="clear"/>
<?php
}
?>
<?php
$notags = strip_tags($product['content_content_2']);
if (!empty($notags)) {
?>
		<h4>Content</h4>
		<?php echo stripslashes($product['content_content_2']); ?>
<?php
}
?>
	</div><!--END .left-->
	<div class="col right">
		<div class="sociallinks center">
			<a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="thirstiesinc" data-related="<?php echo $page_content['page_title'];?>">Tweet</a>
			<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
    		<iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo curPageURL(); ?>&amp;layout=button_count&amp;show_faces=false&amp;width=100&amp;action=like&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>
		</div><!--END .sociallinks-->

		<div class="product_image">
			<a href="<?php echo $_IMAGE_FOLDERS['products_zoom_1600x1600'] . $product['content_image_1']; ?>" class="MagicZoomPlus" id="pdp" title="" target="_blank">
				<img id="main_img" class="center" src="<?php echo $_IMAGE_FOLDERS['products_main_300x300'] . $product['content_image_1']; ?>" width="300" />
			</a>
			<a class="view_larger" href="">View Larger</a>
		</div>
<?php
$get_swatches = mysql_query("select c.content_id, c.content_title, c.content_title_2, c.content_image_1, ca.field_1 from cms_content c join cms_associated_content ca on c.content_id = ca.child_content_id where ca.child_category_id = 42 and ca.content_id = ".(int)$product['content_id']." order by c.content_order desc");
if (mysql_num_rows($get_swatches) > 0) {
?>
		<h4 class="center color-name"></h4>
		<ul class="magicThumbBox swatches nav">
<?php
  while ($swatch = mysql_fetch_assoc($get_swatches)) {
    $background = '#'.$swatch['content_title_2'];
    if (!empty($swatch['content_image_1'])) {
      $background = 'url('.$_IMAGE_FOLDERS['products_prints100x100'] . $swatch['content_image_1'].')';
    }
?>
			<li><a href="<?php echo $_IMAGE_FOLDERS['products_zoom_1600x1600'] . $swatch['field_1']; ?>" rel="zoom-id:pdp" rev="<?php echo $_IMAGE_FOLDERS['products_main_300x300'] . $swatch['field_1']; ?>" style="background:<?php echo $background; ?>;" title="<?php echo stripslashes($swatch['content_title']); ?>" class="border9"><?php echo stripslashes($swatch['content_title']); ?></a></li>
<?php
  }
?>
		</ul>
<?php
}
?>
<?php
$get_pair_products = mysql_query("select c.content_id, c.category_id, c.content_title, c.content_slug, c.content_image_1 from cms_content c join cms_associated_content ca on c.content_id = ca.child_content_id where ca.child_category_id = 2 and ca.content_id = ".(int)$product['content_id']." order by rand() limit 3");
if (mysql_num_rows($get_pair_products) > 0) {
?>

		<h4>Pair With</h4>
		<ul id="pair_with" class="nav">
<?php
  while ($pair_product = mysql_fetch_assoc($get_pair_products)) {
    $get_pair_category = mysql_query("select category_slug from cms_categories where category_id = ".(int)$pair_product['category_id']." limit 1");
    $pair_category = mysql_fetch_assoc($get_pair_category);
?>
			<li><a href="/<?php echo $urlPath_array[0] . '/' . $pair_category['category_slug'] . '/' . $pair_product['content_slug'] ;?>/"><br/><img src="<?php echo $_IMAGE_FOLDERS['products_thumb85x85'] . $pair_product['content_image_1']; ?>" height="65" /><br/><br/><?php echo stripslashes($pair_product['content_title']); ?></a></li>
<?php
  }
?>
		</ul>
<?php
}
?>
	</div> <!--END .right-->

	<br class="clear"/>
<?php
$notags = strip_tags($product['content_content_3']);
if (!empty($notags)) {
?>
	<h4>Details</h4>
	<hr/>
	<?php echo stripslashes($product['content_content_3']); ?>
<?php
}
?>
<?php
$notags = strip_tags($product['content_content_4']);
if (!empty($notags)) {
?>
	<h4 class="blue_special">Care &amp; Use</h4>
	<?php echo stripslashes($product['content_content_4']); ?>
<?php
}
?>
<br class="clear"/>
<br class="clear"/>
<?php
$get_testimonials = mysql_query("select c.content_title, c.content_content_1, c.content_image_1 from cms_content c join cms_associated_content ca on c.content_id = ca.child_content_id where ca.content_id = ".(int)$product['content_id']." and ca.child_category_id = 7 and c.content_active order by c.content_order desc");
if (mysql_num_rows($get_testimonials) > 0) {
?>
	<span class="butterflies right"></span>
	<h4 class="">Testimonials</h4>
	<hr class="clear"/>
	<div id="testimonials">
<?php
  $i = 1;
  while ($testimonial = mysql_fetch_assoc($get_testimonials)) {
?>

		<div class="speech_bubble small <?php echo (($i % 2) == 0?"right":"left"); ?>">
			<em><?php echo $testimonial['content_content_1']?></em>
			<?php if($testimonial['content_image_1']) { ?> <div class="border8"><img class="border8" src="<?php echo $_IMAGE_FOLDERS['about_staff90x130'] . $testimonial['content_image_1'];?>"/></div><?php }?>
		</div>
			<span class="by-line <?php echo (($i % 2) == 0?"right":"left"); ?> clear"><?php echo $testimonial['content_title']?></span>
		<br class="clear"/>
<?php 
    $i++;
  }
?>		
	</div>

	<br class="clear"/>
<?php
}
?>
</div><!--END #main_content-->
<br class="clear"/>
<script type="text/javascript" src="/_js/product_details.js"></script>

<?php include('_includes/footer.php'); ?>