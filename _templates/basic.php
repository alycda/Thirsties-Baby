<?php include('_includes/header.php'); ?>
<?php $get_page_content = mysql_query("SELECT category_id, content_title, content_slug, content_title_2, content_content_1, content_content_2, content_active FROM cms_content WHERE content_slug = '".$urlPath_array[1]."'")?>
<?php $page_content = mysql_fetch_assoc($get_page_content);?>

<div class="main_content">
	<div class="page_header border8">
		<div class="ind">
			<img class="left border18" src="" width="344" height="160"/>
			<div class="page_content right">
				<div class="ind">
					<h3><?php echo $page_content['content_title'];?></h3>
					<p><?php echo stripslashes($page_content['content_content_1']);?></p>
				</div>
			</div>
		<br class="clear"/>
		</div>
	</div>
</div>

<?php echo stripslashes($page_content['content_content_2']);?>
<?php include('_includes/footer.php'); ?>