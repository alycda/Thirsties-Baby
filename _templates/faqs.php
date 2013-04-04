<?php include('_includes/header.php'); ?>

<?php $get_page_content = mysql_query("SELECT category_id, category_slug, category_meta_description, page_title, page_content FROM cms_categories WHERE category_slug = '".$urlPath_array[1]."' LIMIT 1")?>
<?php $page_content = mysql_fetch_assoc($get_page_content);?>

<?php $get_faq_categories = mysql_query("SELECT * FROM cms_categories WHERE category_parent_id = ".$page_content['category_id']." ORDER BY category_order");?>

<div id="<?php echo $urlPath_array[1]; ?>" class="main_content">
	<div class="page_header border8">
		<div class="ind">
			<img class="left" src="" width="344" height="160"/>
			<div class="page_content right">
				<div class="ind">
					<h3><?php echo $page_content['page_title'];?></h3>
					<p><?php echo stripslashes($page_content['category_meta_description']);?></p>
				</div>
			</div>
		<br class="clear"/>
		</div>
	</div>
<?php echo stripslashes($page_content['page_content']);?>

<?php while($faq_cat = mysql_fetch_assoc($get_faq_categories)) {?>
    <div class="page_divider border18 <?php echo $faq_cat['category_bg_class'];?>" >
		<div class="ind">
			<h2><?php echo $faq_cat['category_name'];?></h2>
		</div>
	</div>
	<?php if($faq_cat['page_content']) {?><h5 class="clear left"><?php echo $faq_cat['page_content'];?></h5><?php } ?>
	<!-- <img src="" class="left clear" width="340" height="200"/> -->
	<?php $get_faqs = mysql_query("SELECT * FROM cms_content WHERE category_id = ".$faq_cat['category_id']." ORDER BY content_date DESC"); ?>
	<ul id="<?php echo clean_url($faq_cat['category_name']);?>" class="q-a left <?php echo $faq_cat['category_bg_class'];?>">
	<?php while($faq = mysql_fetch_assoc($get_faqs)) { ?>	
		<li class="question" id="q_<?php echo $faq_cat['category_id']; ?><?php echo $faq['content_id']; ?>"><strong><a class="q" href="javascript:void(0);" onclick="showFaq('<?php echo $faq['content_id']; ?>', '<?php echo $faq_cat['category_id']; ?>')"><?php echo $faq['content_title'];?></a></strong></li>
		<li class="answer" style="display:none;" id="a_<?php echo $faq_cat['category_id']; ?><?php echo $faq['content_id']; ?>"><?php echo $faq['content_content_1'];?></li>
	<?php } ?>
	</ul>
<br class="clear"/>
<?php } ?>	


</div>
<?php include('_includes/footer.php'); ?>