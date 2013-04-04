<?php include('_includes/header.php'); ?>

<script type="text/javascript">
function doSearch(field, defaultValue) {
	if ((field) != defaultValue) {
		window.location.href = BASE_HREF+'search/'+(field);
	}
}
</script>

<?php if(empty($urlPath_array[1])) {?>
	<!--p class="error border9">There was an error, please try your search again using the search box above.</p-->
<?php } else { ?>
	<div id="searchbox" class="right">
		<form action="#" onsubmit="doSearch(document.getElementById('s2').value, 'Search Thirsties');return false;" method="post"> <!--change this back to 's'-->
			<input class="border18" type="text" value="Search Thirsties" onfocus="if (this.value == 'Search Thirsties') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Search Thirsties';}" name="s" id="s2" /> <!--change this back to 's'-->
		</form>
	</div><!--END #searchbox-->
	<h2>search results for: <?php echo urldecode($searchFor); //this variable is set in ./index.php ?></h2>
<?php } ?>

<h2>Search Results <?php //echo 'for: '.$_POST['q'];?></h2>

<div id="cse-search-results"></div>
<script type="text/javascript">
  var googleSearchIframeName = "cse-search-results";
  var googleSearchFormName = "cse-search-box";
  var googleSearchFrameWidth = 600;
  var googleSearchDomain = "www.google.com";
  var googleSearchPath = "/cse";
</script>
<script type="text/javascript" src="http://www.google.com/afsonline/show_afs_search.js"></script>

      
<?php include('_includes/footer.php'); ?> 