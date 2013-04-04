<?php

function CleanFileName( $Raw ){
	$Raw = strtolower(trim($Raw)); // (
	$RemoveChars  = array( "([\40])" , "([^a-zA-Z0-9-])", "(-{2,})" );
	$ReplaceWith = array("-", "", "-");
	return preg_replace($RemoveChars, $ReplaceWith, $Raw);
}

require_once( '../blog/wp-config.php' );
require_once( '../_includes/zipcode.php');

function col2str($a) {
 return ($a-->26?chr(($a/26+25)%26+ord('A')):'').chr($a%26+ord('A'));
}

if (empty($_POST['region']) || empty($_POST['search'])) die();

$_POST['search'] = mysql_real_escape_string ($_POST['search']);

$html = array();
$total_stores = 0;

if ($_POST['region'] == 'us') {
	
	if (ctype_digit($_POST['search'])) {
	
		$zips = array();
	
		$z = new zipcode_class;
		$zips = $z->get_zips_in_range($_POST['search'], 250, _ZIPS_SORT_BY_ZIP_ASC, true);
	
		if (!empty($zips)) {
			////
			// Build the where
			foreach (array_keys($zips) as $zip) {
				$zips_query[] = "store_zip = '".$zip."'";
			}
			
			///
			// Get the dealers
			$wpdb->query("select * from stores where store_region = 'usa' and store_longitude != '' and store_latitude != '' and (".implode(' OR ', $zips_query).")");
			$total_stores = count($wpdb->last_result);
						
			
			$i=1;
			$ii=1;
			foreach($wpdb->last_result as $store) { //html div and google maps infowindow
				
				if((int)$store->store_retail == 1) {
					$store_retail = 'on';
				} else {
					$store_retail = 'off';
				}
				if((int)$store->store_online == 1) {
					$store_online = 'on';
				} else {
					$store_online = 'off';
				} 
				if((int)$store->store_diaper == 1) {
					$store_diaper = 'on';
				} else {
					$store_diaper = 'off';
				}
				
				
				$html[] = '<div class="info">
							<span class="name">'.$store->store_name.'
								<ul class="tiny nav">
									<li id="retail" class="'.$store_retail.'">Retail Store</li>
									<li id="online" class="'.$store_online.'">Online Store</li>
									<li id="diaper" class="'.$store_diaper.'">Diaper Service</li>
								</ul>
							</span>
							<span class="address">'.$store->store_addr1.'<br />'.(!empty($store->store_city)?$store->store_city.', ':'').$store->store_state.' '.$store->store_zip.'<br />'.$store->store_phone.'<br/><a href="'.$store->store_website.'">'.$store->store_website.'</a> | <a href="'.$store->store_email.'">'.$store->store_email.'</a></span>
						   </div>
						   </div>';
				
				$markers[] = array(
													 'latitude'=>$store->store_latitude, 
													 'longitude'=>$store->store_longitude, 
													 'sid'=>$store->store_id, 
													 'window_html'=>'<div style="font-weight:bold;">'.$store->store_name.'</div>
													 				<div>'.$store->store_addr1.'<br />'.(!empty($store->store_city)?$store->store_city.', ':'').$store->store_state.' '.$store->store_zip.'<br />'.$store->store_phone.'</div>'
													 );
		
				$distance[] = $zips[$store->store_zip];
		
				$i++;
				$ii++;
				if ($i==6) $i=1;
			}
			
			////
			// Sort by the distance
			array_multisort($distance, SORT_ASC, $html, $markers);
			
			$ii=1;
			for($i=0;$i<count($html);$i++) { //html div
				$html[$i] = '<div class="store"><a href="javascript:void(0)" onclick="wheretobuy.openWindow('.$markers[$i]['sid'].');" title="'.strtoupper(col2str($ii)).'" class="letter">'.strtoupper(col2str($ii)).'</a>'.$html[$i];
				$ii++;
				if ($ii==6) $ii=1;
			}
		}
	} else {
		
		////
		// If they've put a comma, assume City, State
		if (strstr($_POST['search'], ',') || strstr($_POST['search'], ', ')) {
			
			if (strstr($_POST['search'], ',')) {
				$parts = explode(",", $_POST['search'], 2);
			} else {
				$parts = explode(", ", $_POST['search'], 2);
			}
			
			$wpdb->query("select state_prefix from state where ".(strlen($parts[1])==2?"state_prefix LIKE '".$parts[1]."'":"state_name LIKE '".$parts[1]."' LIMIT 1"));
			$state_info = $wpdb->last_result[0];
			
			///
			// Get the dealers
			$wpdb->query("select store_id, store_name, store_addr1, store_city, store_state, store_zip, store_phone, store_longitude, store_latitude from stores where store_region = 'usa' and store_city LIKE '".$parts[0]."' and store_state LIKE '".$state_info->state_prefix."'");
			$total_stores = count($wpdb->last_result);
			
			if (!empty($wpdb->last_result)) {
				
				$i=1;
				foreach($wpdb->last_result as $store) {
				
					$html[] = '<div class="store">'.($store->store_longitude!=''?'<a href="javascript:void(0)" onclick="wheretobuy.openWindow('.$store->store_id.');" title="'.strtoupper(col2str($i)).'" class="letter">'.strtoupper(col2str($i)).'</a>':'').'<div class="info"><span class="name">'.$store->store_name.'</span><span class="address">'.$store->store_addr1.'<br />'.(!empty($store->store_city)?$store->store_city.', ':'').$store->store_state.' '.$store->store_zip.'<br />'.$store->store_phone.'</span></div></div>';
					
					$markers[] = array(
														 'latitude'=>$store->store_latitude, 
														 'longitude'=>$store->store_longitude, 
														 'sid'=>$store->store_id, 
														 'window_html'=>'<div style="font-weight:bold;">'.$store->store_name.'</div><div>'.$store->store_addr1.'<br />'.$store->store_addr1.'<br />'.(!empty($store->store_city)?$store->store_city.', ':'').$store->store_state.' '.$store->store_zip.'<br />'.$store->store_phone.'</div>'
														 );
					$i++;
					if ($i==6) $i=1;
				}
				
			}
				
			
		} else {
			
			////
			// Is it a state?
			$wpdb->query("select state_prefix from state where ".(strlen($_POST['search'])==2?"state_prefix LIKE '".$_POST['search']."'":"state_name LIKE '".$_POST['search']."' LIMIT 1"));
			if (count($wpdb->last_result) > 0) {
								
				$state_info = $wpdb->last_result[0];
				
				///
				// Get the dealers
				$wpdb->query("select store_id, store_name, store_addr1, store_city, store_state, store_zip, store_phone, store_longitude, store_latitude from stores where store_region = 'usa' and store_state LIKE '".$state_info->state_prefix."'");
				$total_stores = count($wpdb->last_result);
								
				if (!empty($wpdb->last_result)) {

					$i=1;
					foreach($wpdb->last_result as $store) {
					
						$html[] = '<div class="store">'.($store->store_longitude!=''?'<a href="javascript:void(0)" onclick="wheretobuy.openWindow('.$store->store_id.');" title="'.strtoupper(col2str($i)).'" class="letter">'.strtoupper(col2str($i)).'</a>':'').'<div class="info"><span class="name">'.$store->store_name.'</span><span class="address">'.$store->store_addr1.'<br />'.(!empty($store->store_city)?$store->store_city.', ':'').$store->store_state.' '.$store->store_zip.'<br />'.$store->store_phone.'</span></div></div>';
						
						$markers[] = array(
															 'latitude'=>$store->store_latitude, 
															 'longitude'=>$store->store_longitude, 
															 'sid'=>$store->store_id, 
															 'window_html'=>'<div style="font-weight:bold;">'.$store->store_name.'</div><div>'.$store->store_addr1.'<br />'.(!empty($store->store_city)?$store->store_city.', ':'').$store->store_state.' '.$store->store_zip.'<br />'.$store->store_phone.'</div>'
															 );
						$i++;
						if ($i==6) $i=1;
					}
					
				}
				
			////
			// Must be a city, or Unknown State
			} else {
				
				///
				// Get the dealers
				$wpdb->query("select store_id, store_name, store_addr1, store_city, store_state, store_zip, store_phone, store_longitude, store_latitude from stores where store_region = 'usa' and store_city LIKE '".$_POST['search']."'");
				$total_stores = count($wpdb->last_result);
				
				if (!empty($wpdb->last_result)) {
					
					$i=1;
					foreach($wpdb->last_result as $store) {
					
						$html[] = '<div class="store">'.($store->store_longitude!=''?'<a href="javascript:void(0)" onclick="wheretobuy.openWindow('.$store->store_id.');" title="'.strtoupper(col2str($i)).'" class="letter">'.strtoupper(col2str($i)).'</a>':'').'<div class="info"><span class="name">'.$store->store_name.'</span><span class="address">'.$store->store_addr1.'<br />'.(!empty($store->store_city)?$store->store_city.', ':'').$store->store_state.' '.$store->store_zip.'<br />'.$store->store_phone.'</span></div></div>';
						
						$markers[] = array(
															 'latitude'=>$store->store_latitude, 
															 'longitude'=>$store->store_longitude, 
															 'sid'=>$store->store_id, 
															 'window_html'=>'<div style="font-weight:bold;">'.$store->store_name.'</div><div>'.$store->store_addr1.'<br />'.(!empty($store->store_city)?$store->store_city.', ':'').$store->store_state.' '.$store->store_zip.'<br />'.$store->store_phone.'</div>'
															 );
						$i++;
						if ($i==6) $i=1;
					}
					
				}
				
			}
			
			
		}
		
	}
	
} elseif ($_POST['region'] == 'canada'||$_POST['region']=='france'||$_POST['region']=='germany'||$_POST['region']=='austria') {
	
	$wpdb->query("select * from stores where store_region = '".$_POST['region']."' and store_state LIKE '".$_POST['search']."' order by store_name asc");
	
	$total_stores = count($wpdb->last_result);
	
	$i=1;
	$ii=1;
	foreach($wpdb->last_result as $store) {
		
		$html[] = '<div class="store">'.($store->store_longitude!=''?'<a href="javascript:void(0)" onclick="wheretobuy.openWindow('.$store->store_id.');" title="'.strtoupper(col2str($i)).'" class="letter">'.strtoupper(col2str($i)).'</a>':'').'<div class="info"><span class="name">'.$store->store_name.'</span><span class="address">'.$store->store_addr1.'<br />'.(!empty($store->store_city)?$store->store_city.', ':'').$store->store_state.' '.$store->store_zip.'<br />'.$store->store_phone.'</span></div></div>';
		
		$markers[] = array(
											 'latitude'=>$store->store_latitude, 
											 'longitude'=>$store->store_longitude, 
											 'sid'=>$store->store_id, 
											 'window_html'=>'<div style="font-weight:bold;">'.$store->store_name.'</div><div>'.$store->store_addr1.'<br />'.(!empty($store->store_city)?$store->store_city.', ':'').$store->store_state.' '.$store->store_zip.'<br />'.$store->store_phone.'</div>'
											 );

		$i++;
		$ii++;
		if ($i==6) $i=1;
	}
} elseif ($_POST['region'] == 'europe' || $_POST['region'] == 'asia') {

	$wpdb->query("select * from stores where (store_region = '".$_POST['region']."' or store_region = 'france' or store_region = 'germany' or store_region = 'austria') and store_country LIKE '".$_POST['search']."' order by store_name asc"); //  and store_longitude != ''
	
	$total_stores = count($wpdb->last_result);
	
	$i=1;
	$ii=1;
	foreach($wpdb->last_result as $store) {
		
		$html[] = '<div class="store">'.($store->store_longitude!=''?'<a href="javascript:void(0)" onclick="wheretobuy.openWindow('.$store->store_id.');" title="'.strtoupper(col2str($i)).'" class="letter">'.strtoupper(col2str($i)).'</a>':'').'<div class="info"><span class="name">'.$store->store_name.'</span><span class="address">'.$store->store_addr1.'<br />'.(!empty($store->store_city)?$store->store_city.', ':'').$store->store_state.' '.$store->store_zip.' '.$store->store_phone.'<br />'.$store->store_country.'</span></div></div>';
		
		$markers[] = array(
											 'latitude'=>$store->store_latitude, 
											 'longitude'=>$store->store_longitude, 
											 'sid'=>$store->store_id, 
											 'window_html'=>'<div style="font-weight:bold;">'.$store->store_name.'</div><div>'.$store->store_addr1.'<br />'.(!empty($store->store_city)?$store->store_city.', ':'').$store->store_state.' '.$store->store_zip.' '.$store->store_phone.'<br />'.$store->store_country.'</div>'
											 );

		$i++;
		$ii++;
		if ($i==6) $i=1;
	}
} else {
	die();
}

if ($total_stores > 0) {
	$json_array['error'] = false;
	$json_array['html'] = implode("", $html);
	$json_array['markers'] = $markers;
	$json_array['total_pages'] = ceil($total_stores/5);
	$json_array['total_stores'] = $total_stores;
} else {
	$json_array['error'] = 'There are no stores matching your search.';
	$json_array['total_pages'] = 0;
	$json_array['total_stores'] = 0;
}
echo json_encode($json_array);

?>