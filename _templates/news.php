<?php include('_includes/header.php'); ?>
<?php $get_page_content = mysql_query("SELECT category_slug, category_meta_description, page_title, page_content FROM cms_categories WHERE category_slug = '".$urlPath_array[0]."'")?>
<?php $page_content = mysql_fetch_assoc($get_page_content);?>

<div class="main_content">
	<div class="page_header border8">
		<div class="ind">
			<img class="left border18" src="" width="344" height="160"/>
			<div class="page_content right">
				<div class="ind">
					<h3><?php echo $page_content['page_title'];?></h3>
					<p><?php echo stripslashes($page_content['category_meta_description']);?></p>
				</div>
			</div>
		<br class="clear"/>
		</div>
	</div>
</div>

<?php echo stripslashes($page_content['page_content']);?>
<?php include('_includes/footer.php'); ?>