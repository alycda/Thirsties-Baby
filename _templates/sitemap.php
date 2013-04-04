<?php include('_includes/header.php'); ?>
<?php $get_page_content = mysql_query("SELECT category_slug, page_title, page_content FROM cms_categories WHERE category_slug = '".$urlPath_array[0]."'")?>
<?php $page_content = mysql_fetch_assoc($get_page_content);?>
<?php echo 'this is the sitemap'; ?>
<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
<?php include('_includes/footer.php'); ?>