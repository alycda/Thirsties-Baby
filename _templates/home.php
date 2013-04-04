<?php include('_includes/header.php'); ?>

<?php $get_page_content = mysql_query("SELECT category_slug, page_title, page_content FROM cms_categories WHERE category_slug = '".$urlPath_array[0]."'")?>
<?php $page_content = mysql_fetch_assoc($get_page_content);?>

<?php $get_slides = mysql_query("SELECT category_id, content_title_2, content_image_1, content_active, content_order FROM cms_content WHERE category_id = 10 AND content_active = 1 ORDER BY content_order ASC")?>
<?php $get_home_posts = mysql_query("SELECT wp_posts.ID, 
											wp_posts.post_date,
											wp_posts.post_content, 
											wp_posts.post_title, 
											wp_posts.post_status, 
											wp_posts.post_name, 
											wp_posts.post_parent = 0,	
											wp_posts.post_type = 'post',

											wp_term_relationships.object_id, 
											wp_term_relationships.term_taxonomy_id 
									FROM wp_posts, wp_term_relationships 
									WHERE wp_posts.ID = wp_term_relationships.object_id 
									AND wp_term_relationships.term_taxonomy_id != 3 
									AND wp_posts.post_status = 'publish'
									ORDER BY wp_posts.post_date DESC
									LIMIT 5 ")?>
<?php $get_callouts = mysql_query("SELECT category_id, content_title_2, content_image_1, content_active, content_order FROM cms_content WHERE category_id = 9 AND content_active = 1 ORDER BY content_order ASC")?>

<div id="photos_slider" class="center"> <!-- Begin Photos -->
	<div class="slider clear"> <!-- Start Slider -->
    	<div class="slides-container border18">
        	<div class="slides">
				<?php while ($slide = mysql_fetch_assoc($get_slides)) {?>
				<div class="slide">
					<a href="<?php echo $slide['content_title_2'];?>" target="_blank"><img src="<?php echo $_IMAGE_FOLDERS['home_slides980x350'] . $slide['content_image_1'];?>" title="" width="896" /></a>			
				</div><!--END .slide-->	
				<?php } ?>
			</div><!--END .slides-->
			<a href="#" class="previous">Previous</a>
            <a href="#" class="next">Next</a>
            <div class="viewing-container">
            	<div class="viewing-caption hide"></div>
                <div class="viewing-boxes ind"></div>
            </div><!--END .viewing-container-->
        </div><!--END .slides-container-->
        <div class="corner" id="tr"></div>
        <div class="corner" id="tl"></div>
        <div class="corner" id="br"></div>
        <div class="corner" id="bl"></div>
    </div> <!--END .slider-->
</div><!--END #photos_slider-->

<div id="main_content" class="">
	<h2><?php echo $page_content['page_title'];?></h2>
	<?php echo stripslashes($page_content['page_content']);?>
</div>
<div id="sub_content" class="">
	<div id="latest-news" class="left">
		<?php while($home_post = mysql_fetch_assoc($get_home_posts)) { ?>
	<?php $get_thumb_id = mysql_query("SELECT * FROM wp_postmeta WHERE meta_key = '_thumbnail_id' AND post_id = ".$home_post['ID']." LIMIT 1"); ?>
	<?php $thumb_id = mysql_fetch_assoc($get_thumb_id);?>
<?php if ($thumb_id['meta_value']) {?>
	<?php $get_image = mysql_query("SELECT * FROM wp_postmeta WHERE meta_key = '_wp_attached_file' AND post_id = ".$thumb_id['meta_value']." LIMIT 1");?>
	<?php $image = mysql_fetch_assoc($get_image);?>
<?php } ?>

		<div class="item small border8">
			<?php echo !empty($image)?'<a href="/blog/'.$home_post['post_name'].'" class="thumb left"><img src="/blog/wp-content/uploads/'.substr($image['meta_value'],0,strlen($image['meta_value'])-4)."-150x150".substr($image['meta_value'],strlen($image['meta_value'])-4,strlen($image['meta_value'])).'" width="90" height="90"/></a>':'';?>

      		<a href="/blog/<?php echo $home_post['post_name'];?>/" class="title right big"><?php echo $home_post['post_title'];?></a>
      		<div class="content right"><?php echo stripslashes(substr($home_post['post_content'],0,310));?>...</div>
      		<a href="/blog/<?php echo $home_post['post_name'];?>/" class="btn-readmore tiny">Read More</a>
    	</div>
	<?php unset($image);?>
<?php }?>

	</div>
	<aside id="callouts" class="right">
		<?php while ($callout = mysql_fetch_assoc($get_callouts)) {?>
			<a class="img_box" href="<?php echo $callout['content_title_2'];?>"><img src="<?php echo $_IMAGE_FOLDERS['home_callout215x140'] . $callout['content_image_1'];?>" /></a>
		<?php } ?>
	</aside>
</div>
<br class="clear"/>

<?php include('_includes/footer.php'); ?>