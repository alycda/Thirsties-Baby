<!DOCTYPE html>
<?php $get_meta = mysql_query("SELECT * FROM cms_categories WHERE category_slug = '".$urlPath_array[1]."'"); ?>
<?php $meta = mysql_fetch_assoc($get_meta); ?>
<?php if(!empty($urlPath_array[1])) {
	$get_bg_color = mysql_query("SELECT category_slug, category_bg_class from cms_categories WHERE category_slug = '".$urlPath_array[1]."'");
} else {
	$get_bg_color = mysql_query("SELECT category_slug, category_bg_class from cms_categories WHERE category_slug = '".$urlPath_array[0]."'");
}?>
<?php $bg_color = mysql_fetch_assoc($get_bg_color);?>
<?php if(empty($bg_color)) {$bg_color = array('category_bg_class' => 'white');} ?>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7 ]> <html class="no-js ie6 <?php echo $bg_color['category_bg_class'];?>" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7 <?php echo $bg_color['category_bg_class'];?>" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8 <?php echo $bg_color['category_bg_class'];?>" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js <?php echo $bg_color['category_bg_class'];?>" lang="en"> <!--<![endif]-->
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>
<?php if(!empty($meta['browser_title'])) {?>
		<?php echo $meta['browser_title'];?>
<?php } else {?>
	<?php //get_title($urlPath_array); ?>
<?php } ?>
</title>
	<meta name="robots" content="all" />
	<meta name="author" content="Thirsties, Inc" />
	<meta name="copyright" content="<?php echo date('Y'); ?> Thirsties, Inc." />
	<meta name="company" content="Thirsties, Inc" />
	<meta name="description" content="<?php echo $meta['category_meta_description'];?>" />
	<meta name="keywords" content="Thirsties, Cloth Diapers, Diaper Covers, Reusable Diapers, Cloth Diapering, Baby Cloth Diapers, Prefolds, Fitted Diapers" />
	
	<base href="<?=URL_BASE;?>" />
	<script type="text/javascript">
	<!--
		var BASE_HREF = "<?=URL_BASE;?>";
	//-->
	</script>

	<link rel="icon" href="favicon.ico" type="image/x-icon">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"> 
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<link rel="stylesheet" media="all" href="_css/style.css"/>

<script>
function changeMe($color) {
	$("html").attr('class', $color)
}</script>
<link rel="stylesheet" media="screen" href="_css/colors.php"/>

<?php if ($urlPath_array[0] == 'home') {?>
	<link rel="stylesheet" media="screen" href="_css/slider.min.css" /> 
<?php } ?>
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>

	<script src="_js/hoverIntent.js"></script> 
	<script src="_js/superfish.min.js"></script> 
	<script src="_js/supersubs.min.js"></script>  

<?php if ($urlPath_array[1] == 'faqs' || $urlPath_array[1] == 'care-use' ) {?>
	<!--script src='http://ajax.googleapis.com/ajax/libs/prototype/1.6.0.3/prototype.js' type='text/javascript'></script>
	<script src='http://ajax.googleapis.com/ajax/libs/scriptaculous/1.8.2/scriptaculous.js' type='text/javascript'></script-->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js"></script>
	<script src='_js/faqs.js' type='text/javascript'></script>
<?php } ?>

<?php if ($urlPath_array[0] == 'products' ) {?>
	<script src='_js/magiczoomplus.min.js' type='text/javascript'></script>
	<link rel="stylesheet" media="screen" href="_css/magiczoomplus.min.css"/>
	<script src='_js/products.js' type='text/javascript'></script>
<?php } ?>

<?php if($urlPath_array[1] == 'retailer-locator') {?>
	<script type="text/javascript">
	var core = {
		swapText: function(field, defaultValue) {
			if ($(field).val() == defaultValue) {
				$(field).val('');
			} else if ($(field).val() == '') {
				$(field).val(defaultValue);
			}
		}
	}</script>
    <!--http://174.121.171.142: ABQIAAAAfUOiE0LKmIu9wPYpRMJx7RTwUQkcPIm0sWTDfZa2AAWrVFC2fBSdI9GXtnapi6Doe6pLaFsBn7xkgA
 -->
	<!--http://thirsties.local/: ABQIAAAAfUOiE0LKmIu9wPYpRMJx7RSGFEaARufR36Fkw4qElMek4h3uFxR1_AQiCD2JGwEVYI0nTaIbWPa9tg -->
    <script type="text/javascript" src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=ABQIAAAAYPe8B2-6-yxWYrpTt_0rvRRvFoXqfLBTyT7-O2thvULsiE7_ORSAKeM6nCO0ejdCePxSRtlc0XWReg"></script>
	<script type="text/javascript" src="_js/wheretobuy.js"></script>
<?php }?>

	<!--link rel="stylesheet" media="all" href="_css/prettyForms.css"/>
	<script type="text/javascript" src="_js/prettyForms.js"></script-->

</head>
<body id="<?php echo $urlPath_array[0]; ?>" class="center" > <!--onload="prettyForms()"-->
	<section <?php if($urlPath_array[1]) {?>id="<?php echo $urlPath_array[1]; ?>"<?php }?> class="content center">
	<header class="">
		<h1 class="left"><a href="" id="logo">Thirsties Baby</a></h1>

		<div id="phone_chat" class="center border9 big">
    		<div id="phone">1-888-315-2330</div>
        	<div id="volusion" style="display:none;"><!-- Begin Volusion Live Chat -->
			<div id="VolusionLiveChat">
            	<a href="http://www.volusion.com/livechat_software.asp">Live Chat</a>
            </div>
			<script defer type="text/javascript" src="https://livechat.volusion.com/script.aspx?id=123260&amp;AutoPrompt=2&amp;DeptID=4"></script>
		<!-- End Volusion Live Chat --></div>
    	</div><!--END #phone_chat-->

		<ul id="sociallinks" class="right">
        	Follow Us
            <li class="rss"><a href="/blog/feed/rss/" target="_blank" title="rss">rss</a></li>
            <li class="twitter"><a href="http://twitter.com/thirstiesinc" target="_blank" title="twitter">twitter</a></li>
            <li class="facebook"><a href="http://www.facebook.com/Thirsties" target="_blank" title="Facebook">facebook</a></li>
            <li class="clear"></li>
         </ul><!--END #sociallinks-->

<?php include('_includes/nav.php'); ?>
<?php nav($urlPath_array[0]); ?>

<form action="http://www.thirstiesbaby.com/search/" id="cse-search-box" class="right">
  <div>
    <input type="hidden" name="cx" value="017078821949441841517:-cl5azk7joi" />
    <input type="hidden" name="cof" value="FORID:10" />
    <input type="hidden" name="ie" value="UTF-8" />
    <input type="text" name="q" value="Search Thirsties" onfocus="if (this.value == 'Search Thirsties') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Search Thirsties';}" />
    <input type="submit" name="sa" value="Search" class="hide"/>
  </div>
</form>
<script type="text/javascript" src="http://www.google.com/cse/brand?form=cse-search-box&lang=en&sitesearch=true"></script>


	</header><!--END #header-->