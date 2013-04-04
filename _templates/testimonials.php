<?php include('_includes/header.php'); ?>

<?php $get_page_content = mysql_query("SELECT category_id, category_slug, page_title, page_content FROM cms_categories WHERE category_slug = '".$urlPath_array[1]."' LIMIT 1")?>
<?php $page_content = mysql_fetch_assoc($get_page_content);?>

<?php $get_testimonials = mysql_query("SELECT * FROM cms_content WHERE category_id = ".$page_content['category_id']." ORDER BY content_date DESC"); ?>

<div class="main_content">
	<div class="page_header border8">
		<div class="ind">
			<img class="left" src="" width="344" height="160"/>
			<div class="page_content right">
				<div class="ind">
					<h3><?php echo $page_content['page_title'];?></h3>
					<?php echo stripslashes($page_content['page_content']);?>
				</div>
			</div>
		<br class="clear"/>
		</div>
	</div>

	<?php $i = 1; ?>

	<?php while($testimonial = mysql_fetch_assoc($get_testimonials)) { ?>
		<div class="speech_bubble small <?php if($i % 2 == 0) {echo "right"; } else { echo "left"; } ?>">
			<em><?php echo $testimonial['content_content_1']?></em>
			<?php if($testimonial['content_image_1']) { ?> <div class="border8"><img class="border8" src="<?php echo $_IMAGE_FOLDERS['about_staff90x130'] . $testimonial['content_image_1'];?>"/></div><?php }?>
		</div>
			<span class="by-line <?php if($i % 2 == 0) {echo "right"; } else { echo "left"; } ?> clear"><?php echo $testimonial['content_title']?></span>
		<br class="clear"/>
		<?php $i++; ?>
	<?php } ?>		

	<br class="clear"/>
</div>

<?php include('_includes/footer.php'); ?>