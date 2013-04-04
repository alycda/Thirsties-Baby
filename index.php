<?php
include('_includes/application_top.php');

ob_start();

////
// Strip get from Request URI
if (strstr($_SERVER['REQUEST_URI'], '?')) {
	$request_split = explode('?', $_SERVER['REQUEST_URI'], 2);
	$_SERVER['REQUEST_URI'] = $request_split[0];
}

////
// Make the cat path to this file...
if ($PATH_FROM_ROOT != '/') {
	$PATH_FROM_ROOT = str_replace($PATH_FROM_ROOT, '/', $_SERVER['REQUEST_URI']);
} else {
	$PATH_FROM_ROOT = $_SERVER['REQUEST_URI'];
}
$urlPath_array = explode("/", $PATH_FROM_ROOT);

////
// Get rid of any duplicates and blanks
$tmp_array = array();
$n = sizeof($urlPath_array);
for ($i=0; $i<$n; $i++) {
	if (!empty($urlPath_array[$i])) {
		
		////
		// While we're at it, make sure it is in our clean filename format
		$tmp_array[] = clean_url($urlPath_array[$i]);
				
	}
}

$urlPath_array = $tmp_array;

if (empty($urlPath_array[0])) $urlPath_array[0] = 'home';

switch($urlPath_array[0]) {
	case 'home':
		include('_templates/home.php');
		break;
	case 'products':
		//if (!empty($urlPath_array[1]) && $urlPath_array[1] != 'compare') {
		//	include('_templates/product-detail.php');
		//} else if ($urlPath_array[1] == 'compare') {
		//	include('_templates/product-compare.php');
		//} else {
		//	include('_templates/products.php');
		//}
		//break;
		switch (true) {
	    	case ($urlPath_array[1] == 'compare'):
	      		include('_templates/product-compare.php');
	      	break;

			case ($urlPath_array[1] == 'diapers' && empty($urlPath_array[2])): //there should be a better syntax than this, please fix
	      		include('_templates/products.php');
	      	break;

			case ($urlPath_array[1] == 'accessories' && empty($urlPath_array[2])): //please fix syntax
	      		include('_templates/products.php');
	      	break;
	      
	    	case (!empty($urlPath_array[1])):
	    
	      		$get_product_category = mysql_query("select category_id, category_slug, category_name from cms_categories where category_parent_id = 2 and category_slug = '".mysql_real_escape_string($urlPath_array[1])."' limit 1");
	      		$product_category = mysql_fetch_assoc($get_product_category);
	      
	      		if (!empty($product_category['category_id'])) {
	        		$get_product = mysql_query("select * from cms_content where category_id = ".(int)$product_category['category_id']." and content_slug = '".mysql_real_escape_string($urlPath_array[2])."' limit 1");
	        		$product = mysql_fetch_assoc($get_product);
	        		if (!empty($product['content_id'])) {
    	      			include('_templates/product-detail.php');
    	    		} else {
    	      			send404();
    	    		}
	      		} else {
	        		send404();
	      		}
	    	break;
	      
	    	default:
	      		include('_templates/products.php');
	    	break;
	  	}
		break;
	case 'news':
		if (!empty($urlPath_array[1])) {
			switch($urlPath_array[1]) {
				case 'testimonials':
					include('_templates/testimonials.php');
				break;
				case 'blog':
					header("Location: /blog/", true, 301);
					exit();
					//include('_templates/default.php');
				break;
				case 'press':
					header("Location: /blog/category/press/", true, 301);
					exit();
					/*include('_templates/press.php');*/
				break;
			}
		} else {
			include('_templates/news.php');
		}
		break;
	case 'about-us':
		if (!empty($urlPath_array[1])) {
			if($urlPath_array[1] == 'staff') {
				include('_templates/staff.php'); /*testimonials.php*/
			} else {
				include('_templates/default.php');
			}
		} else {
			include('_templates/about-us.php');
		}
		break;
	case 'where-to-buy':
		if (!empty($urlPath_array[1])) {
			switch($urlPath_array[1]) {
				case 'retailer-locator':
					include('_templates/retailer-locator.php');
				break;
				case 'wholesale':
					include('_templates/wholesale.php');
				break;
				case 'outlet':
					include('_templates/default.php');
				break;
			}
		} else {
			include('_templates/where-to-buy.php');
		}
		break;
	case 'customer-center':
		if (!empty($urlPath_array[1])) {
			switch($urlPath_array[1]) {
				case 'faqs':
					include('_templates/faqs.php');
					break;
				case 'care-use':
					include('_templates/care-use.php');
					break;
				case 'privacy-policy':
					include('_templates/basic.php');	
					break;
				case 'terms-conditions':
					include('_templates/basic.php');	
					break;
				default:
					include('_templates/default.php');
					break;
			}
		} else {
			include('_templates/customer-center.php');
		}
		break;
	case 'search':
		include('_templates/search.php');
		break;	
	case 'test':
		if (!empty($urlPath_array[1])) {
			include('_templates/default.php');
		} else {
			include('_templates/test.php');
		}
		break;
	default:
		send404();
		break;
}

include('_includes/application_bottom.php');

/* ?> */