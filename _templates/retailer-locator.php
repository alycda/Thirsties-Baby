<?php include('_includes/header.php'); ?>

<?php $get_page_content = mysql_query("SELECT category_slug, category_meta_description, page_title, page_content FROM cms_categories WHERE category_slug = '".$urlPath_array[1]."'")?>
<?php $page_content = mysql_fetch_assoc($get_page_content);?>

<div class="main_content">
	<div class="page_header border8">
		<div class="ind">
			<div class="page_content left">
				<h3><?php echo $page_content['page_title'];?></h3>
			</div>
            <ul id="legend" class="right nav">
           	  <li id="retail">Retail Location</li>
                        <li class="separator">|</li>
              <li id="online">Online Store</li>
                        <li class="separator">|</li>
              <li id="diaper">Diaper Service</li>
          </ul>
		<br class="clear"/>
		</div>
  </div>
</div>
<?php //echo stripslashes($page_content['page_content']);?>

<!-- Below is the best way to show navigation, and use jQuery to dynamically change the 'selected' class, however, it does not function with _js/wheretobuy.js -->

<!--ul id="select_region" class="nav"> 
	<li class="selected"><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(1);" title="United States">USA</a></li>
	<li class=""><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(2);" title="Canada">Canada</a></li>
	<li class=""><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(3);" title="Asia">Asia</a></li>
	<li class=""><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(4);" title="Oceania">Oceania</a></li>
	<li class=""><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(5);" title="Europe">Europe</a></li>
	<li class=""><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(6);" title="SouthAmerica">South America</a></li>
	<li class=""><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(7);" title="Arabia">Arabian Peninsula</a></li>
</ul>

<script>
	$(function() {
		$( "#select_region li a" ).click(function() {
			$( "#select_region li" ).removeClass( "selected" );
			$( this ).parent().toggleClass( "selected" );
			return false;
		});
	});
</script>

<br class="clear"/-->

<div id="wheretobuycontainer">
	<div id="regions">
    
		<div id="region_us">
			<ul id="select_region" class="nav">
				<li class="selected"><a href="javascript:void(0)" title="United States">United States</a></li>
                <li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(2);" title="Canada">Canada</a></li>
                <li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(3);" title="Asia">Asia</a></li>
                <li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(4);" title="Oceania">Oceania</a></li>
                <li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(5);" title="Austria">Europe</a></li>
                <li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(6);" title="Europe">South America</a></li>
                <li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(7);" title="Asia">Arabian Peninsula</a></li>
			</ul>
      
			<div id="info" class="left">
      			<form action="javascript:;" onsubmit="wheretobuy.searchStores(); return false;">
            		<input type="text" id="field_us" class="textfield border18" onfocus="core.swapText(this, 'City, State or Zip')" onblur="core.swapText(this, 'City, State or Zip')" alt="City, State or Zip" value="City, State or Zip" />
            		<input type="submit" class="btn-locate border18" alt="Find" title="Find" value="Find" name="submit" />
          		</form>
          		<div class="stores" id="stores_us">
            		<div class="stores_inner" id="stores_inner_us"></div>
          		</div>
          		<ul class="pagination" id="pagination_us">
          		</ul>
      		</div><!--END #info-->
	        
      		<div id="map" class="right border18">
            	<div class="mapcontainer border18">
            		<div class="mapinner" id="map_us"></div>
            		<script type="text/javascript">
					<!--
					wheretobuy.changeRegion(1);
					-->
					</script> 
          		</div>
                
                <div class="corner" id="tr"></div>
        		<div class="corner" id="tl"></div>
        		<div class="corner" id="br"></div>
        		<div class="corner" id="bl"></div>
                
        	</div>
            <br class="clear"/>    
      	</div><!--END #region_us-->
    
    
		<div id="region_canada" style="display: none;">
      		<ul id="select_region" class="nav">
        		<li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(1);" title="United States">United States</a></li>
        		<li class="selected"><a href="javascript:void(0)" title="Canada">Canada</a></li>
        		<li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(3);" title="Asia">Asia</a></li>
        		<li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(4);" title="Oceania">Oceania</a></li>
        		<li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(5);" title="Austria">Europe</a></li>
        		<li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(6);" title="Europe">South America</a></li>
        		<li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(7);" title="Asia">Arabian Peninsula</a></li>
      		</ul>
      
      		<div id="info" class="left">
      			<form action="javascript:;" onsubmit="wheretobuy.searchStores(); return false;">
            		<select class="selectfield" id="field_canada">
              			<option value="">Please choose a Province</option>
              			<option value="AB"> AB </option>
              			<option value="BC"> BC </option>
              			<option value="MB"> MB </option>
              			<option value="NB"> NB </option>
              			<option value="NF"> NF </option>
              			<option value="ON"> ON </option>
              			<option value="QC"> QC </option>
            		</select>
            		<input type="submit" class="btn-locate border18" alt="Find" title="Find" value="Find" name="submit" />
          		</form>
          		<div class="stores" id="stores_canada">
            		<div class="stores_inner" id="stores_inner_canada"></div>
          		</div>
          		<ul class="pagination" id="pagination_canada">
          		</ul>
      		</div><!--END #info-->
	        
      		<div id="map" class="right border18">
            	<div class="mapcontainer border18">
            		<div class="mapinner" id="map_canada"></div>
          		</div>
                               
                <div class="corner" id="tr"></div>
        		<div class="corner" id="tl"></div>
        		<div class="corner" id="br"></div>
        		<div class="corner" id="bl"></div>
                
        	</div>
            <br class="clear"/>
    	</div><!--END #region_canada-->
        
        
		<div id="region_asia" style="display: none;">
      		<ul id="select_region" class="nav">
        		<li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(1);" title="United States">United States</a></li>
        		<li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(2);" title="Canada">Canada</a></li>
        		<li class="selected"><a href="javascript:void(0)" title="Asia">Asia</a></li>
        		<li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(4);" title="Oceania">Oceania</a></li>
        		<li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(5);" title="Austria">Europe</a></li>
        		<li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(6);" title="Europe">South America</a></li>
        		<li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(7);" title="Asia">Arabian Peninsula</a></li>
      		</ul>
      
      		<div id="info" class="left">
      			<form action="javascript:;" onsubmit="wheretobuy.searchStores(); return false;">
            		<select class="selectfield" id="field_asia">
              			<option value="">Please choose a Region</option>
            		</select>
            		<input type="submit" class="btn-locate border18" alt="Find" title="Find" value="Find" name="submit" />
          		</form>
          		<div class="stores" id="stores_asia">
            		<div class="stores_inner" id="stores_inner_asia"></div>
          		</div>
          		<ul class="pagination" id="pagination_asia">
          		</ul>
      		</div><!--END #info-->
	        
      		<div id="map" class="right border18">
            	<div class="mapcontainer border18">
            		<div class="mapinner" id="map_asia"></div>
          		</div>             
                <div class="corner" id="tr"></div>
        		<div class="corner" id="tl"></div>
        		<div class="corner" id="br"></div>
        		<div class="corner" id="bl"></div>
        	</div>
            <br class="clear"/>
    	</div><!--END #region_asia-->

    
		<div id="region_oceania" style="display: none;">
      		<ul id="select_region" class="nav">
        		<li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(1);" title="United States">United States</a></li>
        		<li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(2);" title="Canada">Canada</a></li>
        		<li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(3);" title="Asia">Asia</a></li>
        		<li class="selected"><a href="javascript:void(0)" title="Oceania">Oceania</a></li>
        		<li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(5);" title="Austria">Europe</a></li>
        		<li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(6);" title="Europe">South America</a></li>
        		<li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(7);" title="Asia">Arabian Peninsula</a></li>
      		</ul>
      
      		<div id="info" class="left">
      			<form action="javascript:;" onsubmit="wheretobuy.searchStores(); return false;">
            		<select class="selectfield" id="field_oceania">
              			<option value="">Please choose a Region</option>
            		</select>
            		<input type="submit" class="btn-locate border18" alt="Find" title="Find" value="Find" name="submit" />
          		</form>
          		<div class="stores" id="stores_oceania">
            		<div class="stores_inner" id="stores_inner_oceania"></div>
          		</div>
          		<ul class="pagination" id="pagination_oceania">
          		</ul>
      		</div><!--END #info-->
	        
      		<div id="map" class="right border18">
            	<div class="mapcontainer border18">
            		<div class="mapinner" id="map_oceania"></div>
          		</div>             
                <div class="corner" id="tr"></div>
        		<div class="corner" id="tl"></div>
        		<div class="corner" id="br"></div>
        		<div class="corner" id="bl"></div>
        	</div>
            <br class="clear"/>    
        </div><!--END #region_oceania-->
		
        <div id="region_europe" style="display: none;">
      		<ul id="select_region" class="nav">
        		<li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(1);" title="United States">United States</a></li>
        		<li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(2);" title="Canada">Canada</a></li>
        		<li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(3);" title="Asia">Asia</a></li>
        		<li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(4);" title="Oceania">Oceania</a></li>
        		<li class="selected"><a href="javascript:void(0)" title="Austria">Europe</a></li>
        		<li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(6);" title="Europe">South America</a></li>
        		<li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(7);" title="Asia">Arabian Peninsula</a></li>
      		</ul>
            
            <div id="info" class="left">
      			<form action="javascript:;" onsubmit="wheretobuy.searchStores(); return false;">
            		<select class="selectfield" id="field_europe">
              			<option value="">Please choose a Region</option>
            		</select>
            		<input type="submit" class="btn-locate border18" alt="Find" title="Find" value="Find" name="submit" />
          		</form>
          		<div class="stores" id="stores_europe">
            		<div class="stores_inner" id="stores_inner_europe"></div>
          		</div>
          		<ul class="pagination" id="pagination_europe">
          		</ul>
      		</div><!--END #info-->
	        
      		<div id="map" class="right border18">
            	<div class="mapcontainer border18">
            		<div class="mapinner" id="map_europe"></div>
          		</div>             
                <div class="corner" id="tr"></div>
        		<div class="corner" id="tl"></div>
        		<div class="corner" id="br"></div>
        		<div class="corner" id="bl"></div>
        	</div>
            <br class="clear"/> 
        
    	</div><!--END #region_europe-->
    
    	<div id="region_south-am" style="display: none;">
      		<ul id="select_region" class="nav">
        		<li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(1);" title="United States">United States</a></li>
        		<li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(2);" title="Canada">Canada</a></li>
        		<li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(3);" title="Asia">Asia</a></li>
        		<li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(4);" title="Oceania">Oceania</a></li>
        		<li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(5);" title="Austria">Europe</a></li>
        		<li class="selected"><a href="javascript:void(0)" title="Europe">South America</a></li>
        		<li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(7);" title="Asia">Arabian Peninsula</a></li>
        	</ul>
      
      		<div id="info" class="left">
      			<form action="javascript:;" onsubmit="wheretobuy.searchStores(); return false;">
            		<select class="selectfield" id="field_south-am">
                        <option value="">Please choose a Country</option>
                        <option value="AUSTRIA"> Austria </option>
                        <option value="Belgium"> Belgium </option>
                        <option value="Bulgaria"> Bulgaria </option>
                        <option value="Czech Republic"> Czech Republic </option>
                        <option value="Finland"> Finland </option>
                        <option value="France"> France </option>
                        <option value="Germany"> Germany </option>
                        <option value="Greece"> Greece </option>
                        <option value="Hungary"> Hungary </option>
                        <option value="Iceland"> Iceland </option>
                        <option value="Iran"> Iran </option>
                        <option value="Israel"> Israel </option>
                        <option value="Italy"> Italy </option>
                        <option value="Norway"> Norway </option>
                        <option value="Poland"> Poland </option>
                        <option value="Russia"> Russia </option>
                        <option value="Slovenia"> Slovenia </option>
                        <option value="Spain"> Spain </option>
                        <option value="Sweden"> Sweden </option>
                        <option value="Switzerland"> Switzerland </option>
                        <option value="The Netherlands"> The Netherlands </option>
              			<option value="Ukraine"> Ukraine </option>
              			<option value="United Kingdom"> United Kingdom </option>
            		</select>
            		<input type="submit" class="btn-locate border18" alt="Find" title="Find" value="Find" name="submit" />
          		</form>
          		<div class="stores" id="stores_south-am">
            		<div class="stores_inner" id="stores_inner_south-am"></div>
          		</div>
          		<ul class="pagination" id="pagination_south-am">
          		</ul>
      		</div><!--END #info-->
	        
      		<div id="map" class="right border18">
            	<div class="mapcontainer border18">
            		<div class="mapinner" id="map_south-am"></div>
          		</div>             
                <div class="corner" id="tr"></div>
        		<div class="corner" id="tl"></div>
        		<div class="corner" id="br"></div>
        		<div class="corner" id="bl"></div>
        	</div>
            <br class="clear"/>
    	</div><!--END #region_south-am-->

    	<div id="region_arabia" style="display: none;">
      		<ul id="select_region" class="nav">
        		<li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(1);" title="United States">United States</a></li>
        		<li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(2);" title="Canada">Canada</a></li>
        		<li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(3);" title="Asia">Asia</a></li>
        		<li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(4);" title="Oceania">Oceania</a></li>
        		<li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(5);" title="Austria">Europe</a></li>
        		<li><a href="javascript:void(0)" onclick="wheretobuy.changeRegion(6);" title="Europe">South America</a></li>
        		<li class="selected"><a href="javascript:void(0)" title="Asia">Arabian Peninsula</a></li>
            </ul>
            
            <div id="info" class="left">
      			<form action="javascript:;" onsubmit="wheretobuy.searchStores(); return false;">
            		<select class="selectfield" id="field_arabia">
		            	<option value="">Please choose a Country</option>
              			<option value="Australia"> Australia </option>
              			<option value="Japan"> Japan </option>
              			<option value="Korea"> Korea </option>
              			<option value="New Zealand"> New Zealand </option>
            		</select>
            		<input type="submit" class="btn-locate border18" alt="Find" title="Find" value="Find" name="submit" />
          		</form>
          		<div class="stores" id="stores_arabia">
            		<div class="stores_inner" id="stores_inner_arabia"></div>
          		</div>
          		<ul class="pagination" id="pagination_arabia">
          		</ul>
      		</div><!--END #info-->
	        
      		<div id="map" class="right border18">
            	<div class="mapcontainer border18">
            		<div class="mapinner" id="map_arabia"></div>
          		</div>             
                <div class="corner" id="tr"></div>
        		<div class="corner" id="tl"></div>
        		<div class="corner" id="br"></div>
        		<div class="corner" id="bl"></div>
        	</div>
            <br class="clear"/>
    	</div><!--END #region_arabia-->
  </div><!--END #regions-->
</div><!--END #wheretobuycontainer-->

<?php include('_includes/footer.php'); ?>