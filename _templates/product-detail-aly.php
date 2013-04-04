<?php include('_includes/header.php'); ?>

<?php $get_parent_content = mysql_query("SELECT category_id FROM cms_categories WHERE category_slug = '".$urlPath_array[1]."'")?>
<?php $parent_content = mysql_fetch_assoc($get_parent_content);?>

<?php $get_product_categories = mysql_query("SELECT * from cms_content WHERE category_id = ".$parent_content['category_id']." AND content_active = 1");?>

<?php $get_home_posts = mysql_query("SELECT wp_posts.ID, wp_posts.post_title, wp_posts.post_name, wp_posts.post_content, wp_term_relationships.object_id, wp_term_relationships.term_taxonomy_id FROM wp_posts, wp_term_relationships WHERE wp_posts.ID = wp_term_relationships.object_id AND wp_term_relationships.term_taxonomy_id != 3 LIMIT 4")?>		

<?php $get_related_articles = mysql_query("SELECT DISTINCT wp_posts.post_title, wp_posts.guid, wp_terms.name AS tag_name FROM wp_posts LEFT JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id) LEFT JOIN wp_terms ON (wp_term_relationships.term_taxonomy_id = wp_terms.term_id) LEFT JOIN wp_term_taxonomy ON (wp_terms.term_id = wp_term_taxonomy.term_id) WHERE wp_posts.post_status = 'publish' AND wp_posts.post_type = 'post' and wp_terms.name like '".mysql_real_escape_string($product['content_title'])."' ORDER BY post_date DESC limit 5"); ?>

<?php $get_awards = mysql_query("select c.content_title, c.content_title_2, c.content_image_1 from cms_content c join cms_associated_content ca on c.content_id = ca.child_content_id where ca.content_id = ".(int)$product['content_id']." and ca.child_category_id = 44 and c.content_active order by c.content_order desc"); ?>

<?php $get_babies = mysql_query("select c.content_title, c.content_title_2, c.content_image_1, c.content_f1, c.content_f2, c.content_f3 from cms_content c join cms_associated_content ca on c.content_id = ca.child_content_id where ca.content_id = ".(int)$product['content_id']." and ca.child_category_id = 43 and c.content_active order by c.content_order desc"); ?>

<?php $get_testimonials = mysql_query("SELECT * FROM cms_content WHERE category_id = 7 ORDER BY content_date DESC"); ?>

<aside class="left">
	<ul id="nav" class="nav">
	<?php while($product_cat = mysql_fetch_assoc($get_product_categories)) {?>
		<li <?php if($urlPath_array[2] == $product_cat['content_slug']) { ?>class="selected" <?php } ?>><a href="/<?php echo $urlPath_array[0]; ?>/<?php echo $urlPath_array[1]; ?>/<?php echo $product_cat['content_slug'];?>/"><?php echo $product_cat['content_title'];?></a></li>
	<?php } ?>
		<li><a href="/<?php echo $urlPath_array[0]; ?>/accessories">Accessories</a></li>
	</ul>

<!--///////////////////////////////-->

<br class="clear"/>	<!--hard-coded-->

	<ul id="related_articles" class="nav right">
		<li class="title"><h5>Related Articles</h5></li>
		<?php while($home_post = mysql_fetch_assoc($get_home_posts)) { ?>
		<li class="small"><a href="/blog/<?php echo $home_post['post_name'];?>/"><?php echo $home_post['post_title'];?></a></li>
		<?php } ?>
	</ul>

<br class="clear"/>	<!--dynamic-->

<?php if (mysql_num_rows($get_related_articles) > 0) { ?>
	<ul id="related_articles" class="nav right">
		<li class="title"><h5>Related Articles</h5></li>
	<?php while($article = mysql_fetch_assoc($get_related_articles)) { ?>
		<li class="small"><a href="<?php echo $article['guid']; ?>"><?php echo $article['post_title'];?></a></li>
	<?php } ?>
	</ul>
  <br class="clear"/>	
<?php } ?>

<!--///////////////////////////////-->

<br class="clear"/>	<!--hard-coded-->

	<!--ul id="awards" class="">
		<li><a href="http://mactawards.com/"><img src="/_images/products_awards100x100/excellence-award.png" title="Tested and Trusted, Excellence award from MACTawards.com" alt="Excellence Award"/></a></li>
		<li><a href="http://nappaawards.parenthood.com/"><img src="/_images/products_awards100x100/nappa-gold.png" alt="NAPPA Gold Award" title="NAPPA Gold Award, 2010"/></a></li>
	</ul-->

<br class="clear"/>	<!--dynamic-->

<?php if (mysql_num_rows($get_awards) > 0) { ?>
	<ul id="awards" class="">
<?php while ($award = mysql_fetch_assoc($get_awards)) { ?>
		<li><a href="<?php echo stripslashes($award['content_title_2']); ?>" target="_blank"><img src="<?php echo $_IMAGE_FOLDERS['products_awards100x100'] . $award['content_image_1']; ?>" title="<?php echo stripslashes($award['content_title']); ?>" /></a></li>
<?php } ?>
	</ul>
<?php } ?>


<!--///////////////////////////////-->

<br class="clear"/>	<!--hard-coded-->

	<ul id="babies" class="">
		<li class="baby meadow">
			<strong>Bella :: 9 mo</strong><br/>
			<img src="/_images/products_babies140x90/shanny140x90.png" width="140" height="90"/>
			<ul class="small">
				<li>14 lbs, size 1</li>
				<li>Orchid Duo Diaper</li>
				<li>size one with rise on middle setting</li>
			</ul>
		</li>
		<li class="baby ocean">
			<strong>Penny :: 16 mo</strong><br/>
			<img src="/_images/products_babies140x90/bella140x90.png" width="140" height="90"/>
			<ul class="small">
				<li>14 lbs, size 1</li>
				<li>Alice Brights Duo Wrap</li>
				<li>size one with rise on largest setting</li>
			</ul>
		</li>
		<li class="baby orchid">
			<strong>Maggie :: 8 mo</strong><br/>
			<img src="/_images/products_babies140x90/shanny140x90.png" width="140" height="90"/>
			<ul class="small">
				<li>23 lbs, size 2</li>
				<li>Ocean Duo Wrap</li>
				<li>size two with rise on middle setting</li>
			</ul>
		</li>
		<li class="baby storm">
			<strong>Shanny :: 18 mo</strong><br/>
			<img src="/_images/products_babies140x90/bella140x90.png" width="140" height="90"/>
			<ul class="small">
				<li>20 lbs, size 2</li>
				<li>Storm Duo Wrap</li>
				<li>size two with rise on smallest setting</li>
			</ul>
		</li>
	</ul>


<br class="clear"/>	<!--dynamic-->


<?php if (mysql_num_rows($get_babies) > 0) { ?>
	<ul id="babies" class="">
<?php while ($baby = mysql_fetch_assoc($get_babies)) { ?>
		<li class="baby <?php echo $baby['content_title_2']; ?>">
			<strong><?php echo stripslashes($baby['content_title']); ?></strong><br/>
			<img src="<?php echo $_IMAGE_FOLDERS['products_babies140x90'] . $baby['content_image_1']; ?>" width="140" height="90"/>
			<ul class="small">
				<li><?php echo stripslashes($baby['content_f1']); ?></li>
				<li><?php echo stripslashes($baby['content_f2']); ?></li>
				<li><?php echo stripslashes($baby['content_f3']); ?></li>
			</ul>
		</li>
<?php } ?>
	</ul>
<?php } ?>




<!--///////////////////////////////-->



<br class="clear"/>	
</aside><!--END aside-->
<div id="main_content" class="right">

<div id="pdp-big" style="position: absolute; left: 0px; top: 85px;"></div>

	<span class="price right small">Suggested Price: <?php echo stripslashes($product['content_title_3']); ?></span>
	<h2 class="huge"><?php echo stripslashes($product['content_title']);?></h2>
	
	<div class="col left">
		<h3 class="big"><?php echo stripslashes($product['content_title_2']); ?></h3>
<?php $notags = strip_tags($product['content_content_1']); ?>
<?php if (!empty($notags)) { ?>
	<?php $product['content_content_1'] = str_replace('<ul>', '<ul id="features" class="right small">', $product['content_content_1']); ?>
		<h4>Features</h4>
		<?php echo stripslashes($product['content_content_1']); ?>
<?php } ?>
		<br class="clear"/>




<?php $get_sizes = mysql_query("select c.content_title, c.content_title_2, c.content_title_3 from cms_content c join cms_associated_content ca on c.content_id = ca.child_content_id where ca.content_id = ".(int)$product['content_id']." and ca.child_category_id = 45 and c.content_active order by c.content_order"); ?>
<?php $count_sizes = mysql_num_rows($get_sizes); ?>
<?php if ($count_sizes > 0) { ?>
		<h4>Sizing</h4>
		<div class="border9">
		<table class="small">
			<tr><th>Size</th><th>Weight Range</th><th style="border-right:none">Age Range</th></tr>
<?php $i = 1; ?>
<?php while ($size = mysql_fetch_assoc($get_sizes)) { ?>
			<tr>
			  <td<?php echo ($i < $count_sizes?' style="border-bottom: 1px solid #ccc;"':''); ?>><?php echo stripslashes($size['content_title']); ?></td>
			  <td<?php echo ($i < $count_sizes?' style="border-bottom: 1px solid #ccc;"':''); ?>><?php echo stripslashes($size['content_title_2']); ?></td>
			  <td<?php echo ($i < $count_sizes?' style="border-right:none; border-bottom: 1px solid #ccc;"':' style="border:none"'); ?>><?php echo stripslashes($size['content_title_3']); ?></td>
			</tr>
<?php $i++; ?>
<?php } ?>
		</table>
		</div>
<?php } ?>
		<br class="clear"/>

<?php $notags = strip_tags($product['content_content_2']); ?>
<?php if (!empty($notags)) { ?>
		<h4>Content</h4>
		<?php echo stripslashes($product['content_content_2']); ?>
<?php } ?>
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


			<li class=""><a href="_images/products_zoom_1600x1600/aplix_honeydew_1300.jpg" rel="zoom-id:pdp" rev="_images/products_main_300x300/aplix_honeydew_500.jpg" onclick="selectSkuImage(this)" style="background:#f3f2af;" title="Honeydew" class="border9">honeydew</a></li>
			<li class=""><a href="_images/products_zoom_1600x1600/aplix_mango_1300.jpg" rel="zoom-id:pdp" rev="_images/products_main_300x300/aplix_mango_500.jpg" onclick="selectSkuImage(this)" style="background:#f99e58;" title="Mango" class="border9">mango</a></li>
			




			<li class=""><a href="<?php echo $_IMAGE_FOLDERS['products_zoom_1600x1600'] . $swatch['field_1']; ?>" rel="zoom-id:pdp" rev="<?php echo $_IMAGE_FOLDERS['products_main_300x300'] . $swatch['field_1']; ?>" onclick="selectSkuImage(this)" style="background:<?php echo $background; ?>;" title="<?php echo stripslashes($swatch['content_title']); ?>" class="border9"><?php echo stripslashes($swatch['content_title']); ?></a></li>

<?php } ?>

		</ul>
<?php } ?>

<?php
$get_pair_products = mysql_query("select c.content_id, c.category_id, c.content_title, c.content_slug, c.content_image_1 from cms_content c join cms_associated_content ca on c.content_id = ca.child_content_id where ca.child_category_id = 2 and ca.content_id = ".(int)$product['content_id']." order by rand() limit 3");
if (mysql_num_rows($get_pair_products) > 0) {
?>

		<h4>Pair With</h4>
		<ul id="pair_with" class="nav">
			<!--li><a href="/<?php echo $urlPath_array[0] ;?>/duo_wraps/"><br/><img src="/_images/products_thumb85x85/duo_wrap_thumb85x85.png" height="65"/><br/><br/>Duo Wraps</a></li>
			<li><a href="/<?php echo $urlPath_array[0] ;?>/duo_fab_fitteds/"><br/><img src="/_images/products_thumb85x85/duo_fab_fitted_thumb85x85.png" height="65"/><br/><br/>Duo Fab Fitteds</a></li>
			<li><a href="/<?php echo $urlPath_array[0] ;?>/diaper_covers/"><br/><img src="/_images/products_thumb85x85/diaper_cover_thumb85x85.png" height="65"/><br/><br/>Duo Diaper Covers</a></li-->

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

<?php $notags = strip_tags($product['content_content_3']); ?>
<?php if (!empty($notags)) { ?>
	<h4>Details</h4>
	<hr/>
	<?php echo stripslashes($product['content_content_3']); ?>
<?php } ?>

	<img class="instructions" src="/_images/products_instructions700x400/duo-hemp-prefold-instructions.png" alt="prefold instructions" title="Duo Hemp Prefold Instructions"/>


<?php $notags = strip_tags($product['content_content_4']); ?>
<?php if (!empty($notags)) { ?>
	<h4 class="blue_special">Care &amp; Use</h4>
	<?php echo stripslashes($product['content_content_4']); ?>
<?php } ?>


<!--///////////////////////////////-->

	<h4 class="blue_special">Care &amp; Use</h4>  <!--hard coded-->
	<p>Machine wash warm or hot. Dry in dryer or hang to dry.<br/>
	55% hemp, 45% cotton<br/>
	Made in the USA. </p>

<?php $notags = strip_tags($product['content_content_4']); ?> <!--dynamic-->
<?php if (!empty($notags)) { ?>
	<h4 class="blue_special">Care &amp; Use</h4>
	<?php echo stripslashes($product['content_content_4']); ?>
<?php } ?>


<!--///////////////////////////////-->





	<img src="/_images/products_instructions700x400/fold.png" alt="" title=""/>
<br class="clear"/>
<br class="clear"/>

<?php
$get_testimonials = mysql_query("select c.content_title, c.content_content_1, c.content_image_1 from cms_content c join cms_associated_content ca on c.content_id = ca.child_content_id where ca.content_id = ".(int)$product['content_id']." and ca.child_category_id = 7 and c.content_active order by c.content_order desc"); ?>
<?php if (mysql_num_rows($get_testimonials) > 0) { ?>


	<span class="butterflies right"></span>
	<h4 class="">Testimonials</h4>
	<hr class="clear"/>
	<div id="testimonials">
<?php $i = 1; ?>
<?php while ($testimonial = mysql_fetch_assoc($get_testimonials)) { ?>
		<div class="speech_bubble small <?php echo (($i % 2) == 0?"right":"left"); ?>">
			<em><?php echo $testimonial['content_content_1']?></em>
			<?php if($testimonial['content_image_1']) { ?> <div class="border8"><img class="border8" src="<?php echo $_IMAGE_FOLDERS['about_staff90x130'] . $testimonial['content_image_1'];?>"/></div><?php }?>
		</div>
			<span class="by-line <?php echo (($i % 2) == 0?"right":"left"); ?> clear"><?php echo $testimonial['content_title']?></span>
		<br class="clear"/>
<?php $i++; ?>
<?php } ?>			
	</div>

<?php } ?>


	<br class="clear"/>


</div><!--END #main_content-->
<br class="clear"/>
<script type="text/javascript" src="/_js/product_details.js"></script>
<?php include('_includes/footer.php'); ?>