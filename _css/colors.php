<?php include('../_includes/application_top.php'); ?><?php include_once("../_includes/csscolor.php");?>
<?php function getContrastYIQ($hexcolor){
	$r = hexdec(substr($hexcolor,0,2));
	$g = hexdec(substr($hexcolor,2,2));
	$b = hexdec(substr($hexcolor,4,2));
	$yiq = (($r*299)+($g*587)+($b*114))/1000;
	return ($yiq >= 230) ? '#acacac' : 'white'; //1-2-4-8-16-32-64-128-256 (200-235)
} 	function goDarker($hexcolor) {
		$r = hexdec(substr($hexcolor,0,2));
		$g = hexdec(substr($hexcolor,2,2));
		$b = hexdec(substr($hexcolor,4,2));
		$yiq = (($r*299)+($g*587)+($b*114))/1000;
		return ($yiq >= 230) ? true : false;
	} ?>
<?php $get_colors = mysql_query("SELECT * FROM cms_content WHERE category_id = 42 AND content_active = 1"); ?>
<?php header("Content-type: text/css"); ?>
@charset "UTF-8";
<?php while($color = mysql_fetch_assoc($get_colors)) {?> <?php $base = new CSS_Color($color['content_title_2']);?>

html.<?php echo $color['content_slug'];?> {
	<?php echo(!empty($color['content_image_1']))?'background: url(../_images/products_prints200x200/'.$color['content_image_1'].')':'background-color:#'.$color['content_title_2'];?>; /*<?php echo $color['content_slug'];?>*/ 
}	html.<?php echo $color['content_slug'];?> a, 
	.<?php echo $color['content_slug'];?> header form input, 
	.<?php echo $color['content_slug'];?> #products #main_content h2, 
	.<?php echo $color['content_slug'];?> #products aside #nav a,
	.<?php echo $color['content_slug'];?> #mailingList input.email_home:hover,
	.<?php echo $color['content_slug'];?> #mailingList input.email_home:focus,
	h2.faqs.<?php echo $color['content_slug'];?> { 
		color:#<?php if(goDarker($color['content_title_2'])) {?><?=$base->bg['-1']?><?php } else { echo $color['content_title_2'];}?>;
	}	.<?php echo $color['content_slug'];?> header a#logo { 
			background: #<?php echo $color['content_title_2']; ?> url(img/thirsties-logo.png) 0px 0px;  
} 	.<?php echo $color['content_slug'];?> #top-nav li.selected a.tab, 
	.<?php echo $color['content_slug'];?> #top-nav li a.tab:hover, 
	.<?php echo $color['content_slug'];?> #top-nav li:hover ul.sub li a:hover, 
	.<?php echo $color['content_slug'];?> #top-nav li:hover ul.sub li a:active, 
	.<?php echo $color['content_slug'];?> header form input:focus, 
	.<?php echo $color['content_slug'];?> header form input:hover {
		color: #fff; /*pure white*/
}	.<?php echo $color['content_slug'];?> #top-nav li.selected a.tab, 
	.<?php echo $color['content_slug'];?> #top-nav li a.tab:hover, 
	.<?php echo $color['content_slug'];?> #top-nav li:hover ul.sub li a:hover, 
	.<?php echo $color['content_slug'];?> #top-nav li:hover ul.sub li a:active, 
	.<?php echo $color['content_slug'];?> header form input:focus, 
	.<?php echo $color['content_slug'];?> header form input:hover,
	.<?php echo $color['content_slug'];?> .content .page_header, 
	.<?php echo $color['content_slug'];?> .content .page_divider, 
	.<?php echo $color['content_slug'];?> .item_list .item .item_info h4 a,
	.<?php echo $color['content_slug'];?> #products table tr.product-titles th, 
	.<?php echo $color['content_slug'];?> #products table tr.product-titles td, 
	#customer-center .<?php echo $color['content_slug'];?> li.question:hover, 
	#customer-center .<?php echo $color['content_slug'];?> li.on { 
		background:#<?php if(goDarker($color['content_title_2'])) {?><?=$base->bg['-1']?><?php } else { echo $color['content_title_2'];}?>;
}	.<?php echo $color['content_slug'];?> #products aside #nav li a.top_level, 
	.<?php echo $color['content_slug'];?> #products aside #nav a.top_level {
		border-bottom: 1px dotted #<?php if(goDarker($color['content_title_2'])) {?><?= $base->bg['-1'] ?><?php } else { echo $color['content_title_2'];}?>;
}	.<?php echo $color['content_slug'];?> #products aside #nav li li a:hover, 
	.<?php echo $color['content_slug'];?> #products aside #nav li li.selected a {
		background: url('img/selected-<?php echo $color['content_slug'];?>.png') no-repeat;
		color:<?php echo getContrastYIQ($color['content_title_2']);?>;					
}	.<?php echo $color['content_slug'];?> #products #main_content .col #features li {
	background: url('img/check-<?php echo $color['content_slug'];?>.png') no-repeat left center;
}	html.<?php echo $color['content_slug'];?> footer a, 
	html.<?php echo $color['content_slug'];?> #footer-bottom a
	html.<?php echo $color['content_slug'];?> #products footer.center ul#bottom-nav li a:hover {
		border-bottom: 1px dotted <?php echo getContrastYIQ($color['content_title_2']);?>;
}	<?php if(!empty($color['content_image_1'])) {?>
	.<?php echo $color['content_slug'];?> footer {background:url(img/bg-pattern-bottom992.png) no-repeat top center;}
	.<?php echo $color['content_slug'];?> #footer-bottom {background:/*url('img/bg-black-30.png')repeat*/#fff;}

	html.<?php echo $color['content_slug'];?> footer, 
	html.<?php echo $color['content_slug'];?> footer a, 
	html.<?php echo $color['content_slug'];?> #products footer.center ul#bottom-nav li a:hover, 
	html.<?php echo $color['content_slug'];?> #footer-bottom, 
	html.<?php echo $color['content_slug'];?> #footer-bottom p,
	html.<?php echo $color['content_slug'];?> #footer-bottom a,
	html.<?php echo $color['content_slug'];?> #mailingList input.email_home {
		color:#<?php echo $color['content_title_2'];?>;
	}	html.<?php echo $color['content_slug'];?> #mailingList input.email_home {
			background: #f0f0f0;
}	html.<?php echo $color['content_slug'];?> footer a, 
	html.<?php echo $color['content_slug'];?> #footer-bottom a
	html.<?php echo $color['content_slug'];?> #products footer.center ul#bottom-nav li a:hover {
		border-bottom: 1px dotted #<?php echo $color['content_title_2'];?>;
}	html.<?php echo $color['content_slug'];?> #mailingList input.submit, 
	html.<?php echo $color['content_slug'];?> #mailingList input.email_home:hover,
	html.<?php echo $color['content_slug'];?> #mailingList input.email_home:focus {
		color:<?php echo getContrastYIQ($color['content_title_2']);?>;
		background:#<?php echo $color['content_title_2'];?>;
}	<?php } else { ?>
html.<?php echo $color['content_slug'];?> footer, 
	html.<?php echo $color['content_slug'];?> footer a, 
	html.<?php echo $color['content_slug'];?> #products footer.center ul#bottom-nav li a:hover, 
	html.<?php echo $color['content_slug'];?> #footer-bottom, 
	html.<?php echo $color['content_slug'];?> #footer-bottom p,
	html.<?php echo $color['content_slug'];?> #footer-bottom a {
		color:<?php echo getContrastYIQ($color['content_title_2']);?>;
}<?php } ?>
.<?php echo $color['content_slug'];?> #products table tr.description th, 
.<?php echo $color['content_slug'];?> #products table tr.price th, 
.<?php echo $color['content_slug'];?> #products table tr.product_features th, 
.<?php echo $color['content_slug'];?> #products table tr.product_sizes th, 
.<?php echo $color['content_slug'];?> #products table tr.product_content th {
	background:#<?=$base->bg['+3']?>;
}


<?php } ?>	
html.white a:hover, 
.white #mailingList input.email_home:hover, 
.white #mailingList input.email_home:focus {
	color:#4dc8e9; /*oceanblue*/
}	html.white section a {
	text-decoration: none;
	color:#4dc8e9; /*oceanblue*/
	}	html.white section a:hover {
		color: #8cc63e; /*meadow*/
}	.white header a#logo {
		background-color:#4dc8e9; /*oceanblue*/
}	.white #products header a#logo {
		background-color:#cfcfcf; /*light gray*/
}	.white #top-nav li.selected a.tab, .white #top-nav li a.tab:hover, .white #top-nav li:hover ul.sub li a:hover, .white #top-nav li:hover ul.sub li a:active {
		background-color:#4dc8e9; /*oceanblue*/
}	.white #products #top-nav li.selected a.tab, .white #products #top-nav li a.tab:hover, .white #products #top-nav li:hover ul.sub li a:hover, .white #products #top-nav li:hover ul.sub li a:active {
		color: #fff;
		background: #cfcfcf; /*light gray*/ 
}	.white #products #main_content h2, .white #products aside #nav li a.top_level, 
.white #products aside #nav a.top_level {
	color: #acacac;
}	.white #products aside #nav li li a {
	color: #cfcfcf;
}	.white #products header form input { 
		color: #acacac; /*light gray*/
	}	.white #products header form input:hover, .white #products header form input:focus {
			color: #fff;	
}.white header form input { 
		color: #4dc8e9; /*ocean-blue*/
	}	.white header form input:focus, .white header form input:hover { 
			color:#4dc8e9; /*background-color:#4dc8e9;*/ /*ocean-blue*/
}	.white #products .content .page_header, .white #products .content .page_divider, .white #products .item_list .item .item_info h4 a {
		background-color:#cfcfcf; /*light gray*/
	}	.white .content .page_header, .white .content .page_divider {
			background-color:#4dc8e9; /*ocean-blue*/
}	html.white footer a, html.white footer p {
		color: #acacac;
}	html.white footer a:hover {
		color: #4dc8e9; /*oceanblue*/
	}