<?php include('_includes/header.php'); ?>

<?php $get_page_content = mysql_query("SELECT category_id, category_slug, category_meta_description, page_title, page_content FROM cms_categories WHERE category_slug = '".$urlPath_array[1]."' LIMIT 1")?>
<?php $page_content = mysql_fetch_assoc($get_page_content);?>

<div id="<?php echo $urlPath_array[1]; ?>" class="main_content">
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

	<?php $get_faqs = mysql_query("SELECT * FROM cms_content WHERE category_id = ".$page_content['category_id']." ORDER BY content_date DESC"); ?>
	<ul id="<?php echo clean_url($faq_cat['category_name']);?>" class="q-a">
	<?php while($faq = mysql_fetch_assoc($get_faqs)) { ?>	
		<li class="question" id="q_<?php echo $faq_cat['category_id']; ?><?php echo $faq['content_id']; ?>"><strong><a class="q" href="javascript:void(0);" onclick="showFaq('<?php echo $faq['content_id']; ?>', '<?php echo $faq_cat['category_id']; ?>')"><?php echo $faq['content_title'];?></a></strong></li>
		<li class="answer" style="display:none;" id="a_<?php echo $faq_cat['category_id']; ?><?php echo $faq['content_id']; ?>"><?php echo $faq['content_content_1'];?></li>
	<?php } ?>
	</ul>
<br class="clear"/>


</div>
<?php include('_includes/footer.php'); ?>