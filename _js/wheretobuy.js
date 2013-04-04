////
// Set the Unload for the map...
// This is currently the best way to do it
window.onbeforeunload = function() {
	GUnload();
}

////
// Setup the region info
var region_info = new Array();
region_info[1] = {
	name: 'us',
	container: false,
	obj: false,
	longitude: -94.8555,
	latitude: 38.8226,
	zoom: 4
}
region_info[2] = {
	name: 'canada',
	container: false,
	obj: false,
	longitude: -102.3047,
	latitude: 59.0857,
	zoom: 4
}
region_info[3] = {
	name: 'asia', //france
	container: false,
	obj: false,
	longitude: 100.6197, //1.3184
	latitude: 34.0479, //46.7097
	zoom: 3 //6
}
region_info[4] = {
	name: 'oceania', //germany
	container: false,
	obj: false, 
	longitude: 135.175781, //9.7559
	latitude: -23.079732, //50.6808
	zoom: 4 //6
}
region_info[5] = {
	name: 'europe', //austria
	container: false, 
	obj: false,
	longitude: 5.8248, //14.5501
	latitude: 49.6325, //47.5162
	zoom: 5 //6
}
region_info[6] = {
	name: 'south-am', //europe
	container: false,
	obj: false,  
	longitude: -58.623047, //14.8248
	latitude: -8.754795, //54.6325
	zoom: 4 //3
}
region_info[7] = {
	name: 'arabia', //asia
	container: false,
	obj: false, 
	longitude: 44.912109, //100.6197
	latitude: 24.766785, //34.0479
	zoom: 5 //3
}

////
// Where to buy class
var wheretobuy = {
	goToPage: function(e, page) {
		
		pagination.makePagination('pagination_'+wheretobuy.currentRegion.name, parseInt(wheretobuy.currentRegion.total_pages), page, 'wheretobuy.goToPage');
		$('#stores_inner_'+wheretobuy.currentRegion.name).animate({ 'bottom': ((page*590)-590)+'px' }, 500, function() {
			 wheretobuy.currentRegion.page = page;
			 wheretobuy.currentRegion.updateMarkers();
		});
		
		/*new Effect.Morph('stores_inner_'+wheretobuy.currentRegion.name,
										 {
											 style: 'bottom: '+((page*600)-600)+'px',
											 duration: 0.5,
											 queue: { position: 'end', scope: 'storepageschange' },
											 beforeStart: function() {
												 pagination.makePagination('pagination_'+wheretobuy.currentRegion.name, parseInt(wheretobuy.currentRegion.total_pages), page, 'wheretobuy.goToPage');
											 },
											 afterFinish: function() {
												 wheretobuy.currentRegion.page = page;
												 wheretobuy.currentRegion.updateMarkers();
											 }
										 });*/
		
	},
	currentRegion: false,
	currentRegionNumber: false,
	setupRegion: function(region_number) {
		
		if (region_info[region_number].obj != false) {
			this.currentRegion = region_info[region_number].obj;
			this.currentRegionNumber = region_number;
			region_info[region_number].current = true;
			region_info[region_number].container.show();
			return;
		}
		
		this.currentRegion = new region;
		this.currentRegionNumber = region_number;
		this.currentRegion.name = region_info[region_number].name;
		this.currentRegion.default_longitude = region_info[region_number].longitude;
		this.currentRegion.default_latitude = region_info[region_number].latitude;
		this.currentRegion.default_zoom = region_info[region_number].zoom;
		
		////
		// Store this region within the region info
		region_info[region_number].obj = this.currentRegion;
		region_info[region_number].current = true;
		region_info[region_number].container = $('#region_'+this.currentRegion.name);
		region_info[region_number].container.show();
		this.currentRegion.initMap();
		
	},
	changeRegion: function(region_number) {
		
		if (this.currentRegionNumber != false) {
			region_info[this.currentRegionNumber].container.hide();
			region_info[this.currentRegionNumber].current = false;
		}
		
		this.setupRegion(region_number);
		
	},
	searchStores: function() {
		this.currentRegion.searchStores();
	},
	openWindow: function(marker_number) {
				
		this.currentRegion.gmarkers[marker_number].openInfoWindowHtml(this.currentRegion.gmarkers[marker_number].window_html);
		
	}
}

////
// Region Object
var region = function() {
	this.name = '';
	this.results_div = false;
}
region.prototype.initMap = function() {
	if (GBrowserIsCompatible()) {
		this.map = new GMap2($('#map_'+this.name)[0]);
		this.map.setCenter(new GLatLng(parseInt(this.default_latitude), parseInt(this.default_longitude)), parseInt(this.default_zoom));
		this.map.setUIToDefault();
		
		this.icons = new Array();
    this.icons[1] = new GIcon();
    this.icons[1].image = BASE_HREF+"_images/layout/wheretobuy-icon_a.png";
    this.icons[1].shadow = BASE_HREF+"_images/layout/wheretobuy-icon_shadow.png";
    this.icons[1].iconSize = new GSize(20.0, 29.0);
    this.icons[1].shadowSize = new GSize(35.0, 29.0);
    this.icons[1].iconAnchor = new GPoint(10.0, 14.0);
    this.icons[1].infoWindowAnchor = new GPoint(10.0, 14.0);
    this.icons[2] = new GIcon();
    this.icons[2].image = BASE_HREF+"_images/layout/wheretobuy-icon_b.png";
    this.icons[2].shadow = BASE_HREF+"_images/layout/wheretobuy-icon_shadow.png";
    this.icons[2].iconSize = new GSize(20.0, 29.0);
    this.icons[2].shadowSize = new GSize(35.0, 29.0);
    this.icons[2].iconAnchor = new GPoint(10.0, 14.0);
    this.icons[2].infoWindowAnchor = new GPoint(10.0, 14.0);
    this.icons[3] = new GIcon();
    this.icons[3].image = BASE_HREF+"_images/layout/wheretobuy-icon_c.png";
    this.icons[3].shadow = BASE_HREF+"_images/layout/wheretobuy-icon_shadow.png";
    this.icons[3].iconSize = new GSize(20.0, 29.0);
    this.icons[3].shadowSize = new GSize(35.0, 29.0);
    this.icons[3].iconAnchor = new GPoint(10.0, 14.0);
    this.icons[3].infoWindowAnchor = new GPoint(10.0, 14.0);
    this.icons[4] = new GIcon();
    this.icons[4].image = BASE_HREF+"_images/layout/wheretobuy-icon_d.png";
    this.icons[4].shadow = BASE_HREF+"_images/layout/wheretobuy-icon_shadow.png";
    this.icons[4].iconSize = new GSize(20.0, 29.0);
    this.icons[4].shadowSize = new GSize(35.0, 29.0);
    this.icons[4].iconAnchor = new GPoint(10.0, 14.0);
    this.icons[4].infoWindowAnchor = new GPoint(10.0, 14.0);
    this.icons[5] = new GIcon();
    this.icons[5].image = BASE_HREF+"_images/layout/wheretobuy-icon_e.png";
    this.icons[5].shadow = BASE_HREF+"_images/layout/wheretobuy-icon_shadow.png";
    this.icons[5].iconSize = new GSize(20.0, 29.0);
    this.icons[5].shadowSize = new GSize(35.0, 29.0);
    this.icons[5].iconAnchor = new GPoint(10.0, 14.0);
    this.icons[5].infoWindowAnchor = new GPoint(10.0, 14.0);
		
	}
}

region.prototype.searchStores = function() {
	if (this.getSearch() == '') return;
	
	 if (wheretobuy.currentRegion.results_div == false) {
	   //new Element('div').addClassName('searchedfor');
		 wheretobuy.currentRegion.results_div = $('<div class="searchedfor"></div>')
		 //insert({ before: wheretobuy.currentRegion.results_div });
		 $('#stores_'+wheretobuy.currentRegion.name).prepend(wheretobuy.currentRegion.results_div);
	 }
			 
	wheretobuy.currentRegion.results_div.html('Locating...');
	
	$.post(BASE_HREF+'_ajax/wheretobuy_region_search.php', { 'region': this.name, 'search': this.getSearch() }, function(json) {
		 wheretobuy.currentRegion.results_div.html('Retail stores near '+wheretobuy.currentRegion.getSearch()+': <span>'+json.total_stores+' RESULT'+(json.total_stores!=1?'S':'')+'</span>');
					 
		 if (json.error != false) {
					 
			 wheretobuy.currentRegion.page = 1;
			 wheretobuy.currentRegion.resetMap();
			 pagination.makePagination('pagination_'+wheretobuy.currentRegion.name, 1, 1, 'wheretobuy.goToPage');
			 $('#stores_inner_'+wheretobuy.currentRegion.name).css({ bottom: '0px' }).html(json.error);
			 
		 } else {
			 wheretobuy.currentRegion.page = 1;
			 wheretobuy.currentRegion.markers = json.markers;
			 wheretobuy.currentRegion.last_search = wheretobuy.currentRegion.getSearch();
			 wheretobuy.currentRegion.total_pages = json.total_pages;
			 wheretobuy.currentRegion.updateMarkers();
			 pagination.makePagination('pagination_'+wheretobuy.currentRegion.name, parseInt(json.total_pages), 1, 'wheretobuy.goToPage');
			 $('#stores_inner_'+wheretobuy.currentRegion.name).css({ bottom: '0px' }).html(json.html); 
		 }

	}, 'json');
	
	/*new Ajax.Request(BASE_HREF+'_ajax/wheretobuy_region_search.php', {
		method:'post',
		parameters: 'region='+this.name+'&search='+this.getSearch(),
		onSuccess: function(transport){
			 var json = transport.responseText.evalJSON();
			 
			 wheretobuy.currentRegion.results_div.update('Retail stores near '+wheretobuy.currentRegion.getSearch()+': <span>'+json.total_stores+' RESULT'+(json.total_stores!=1?'S':'')+'</span>');
						 
			 if (json.error != false) {
						 
				 wheretobuy.currentRegion.page = 1;
				 wheretobuy.currentRegion.resetMap();
				 pagination.makePagination('pagination_'+wheretobuy.currentRegion.name, 1, 1, 'wheretobuy.goToPage');
				 $('stores_inner_'+wheretobuy.currentRegion.name).setStyle({ bottom: '0px' }).update(json.error);
				 
			 } else {
				 wheretobuy.currentRegion.page = 1;
				 wheretobuy.currentRegion.markers = json.markers;
				 wheretobuy.currentRegion.last_search = wheretobuy.currentRegion.getSearch();
				 wheretobuy.currentRegion.total_pages = json.total_pages;
				 wheretobuy.currentRegion.updateMarkers();
				 pagination.makePagination('pagination_'+wheretobuy.currentRegion.name, parseInt(json.total_pages), 1, 'wheretobuy.goToPage');
				 $('stores_inner_'+wheretobuy.currentRegion.name).setStyle({ bottom: '0px' }).update(json.html); 
			 }
			 
		 }
	});*/
}
region.prototype.getSearch = function() {
	return $('#field_'+this.name).val();
}
region.prototype.updateMarkers = function() {

	this.map.clearOverlays();
	this.gmarkers = new Array();
	var bounds = new GLatLngBounds();
	var ii = 1;
	
	var marker_latitude, marker_longitude, marker_sid, marker_html;
	
	for(var i=((this.page*5)-5);i<(this.page*5);i++) {
		if ((i+1) > this.markers.length) break;
		
		if (this.markers[i].latitude != '') {
		
			marker_latitude = parseFloat(this.markers[i].latitude);
			marker_longitude = parseFloat(this.markers[i].longitude);
			marker_sid = parseInt(this.markers[i].sid);
			marker_html = this.markers[i].window_html;
			
			
			if (marker_latitude != '') {
			
				var marker_point = new GLatLng(marker_longitude,marker_latitude);
				bounds.extend(marker_point);
				
				var marker = this.createMarker(marker_point, marker_sid, marker_html, ii);
				this.map.addOverlay(marker);
				
			}

		}
				
		ii++;
		if (ii==6) ii = 1;
	}
		
	//this.map.setCenter(new GLatLng(0,0), 0);
	this.map.setCenter(new GLatLng(parseInt(this.default_latitude), parseInt(this.default_longitude)), parseInt(this.default_zoom));

	if(i<2) {
		this.map.setZoom(this.map.getBoundsZoomLevel(bounds)-7); //-1 is too small for maps showing only 1 result.
	} else {
		this.map.setZoom(this.map.getBoundsZoomLevel(bounds)-1); //-1 is too small for maps showing only 1 result.
	}

	this.map.setCenter(bounds.getCenter());
	//this.map.checkResize();
}
region.prototype.createMarker = function(marker_point, marker_sid, marker_html, ii) {
	var marker = new GMarker(marker_point, {icon:this.icons[ii]});
	GEvent.addListener(marker, "click", function() {
		marker.openInfoWindowHtml(marker_html);
	});
	marker.window_html = marker_html;
	this.gmarkers[marker_sid] = marker;
	return marker;
}
region.prototype.resetMap = function() {
	this.map.clearOverlays();
	this.map.setCenter(new GLatLng(parseInt(this.default_latitude), parseInt(this.default_longitude)), parseInt(this.default_zoom));
}
////
// Pagination Class
var pagination = {
	pageItem: $('<li></li>'), //new Element('li'),
	extraPageItem: $('<li>...</li>'), //new Element('li').update('...'),
	pageItemInner: $('<a href="javascript:void(0)"></a>'), //new Element('a', { href: 'javascript:void(0)' }),
	makePagination: function(container, total_pages, current_page, callback) {
		$('#'+container).html('');
		if (total_pages == 1) return;
		if (current_page < 7) {
			var pageli;
			var pagea;
			var goto = (total_pages>=9?9:total_pages);
			for(var i=1;i<=goto;i++) {
				this.makePaginationNumber(i, current_page, container, callback);
			}
			if (total_pages > 9) {
				//$(container).insert({ bottom: this.extraPageItem.cloneNode(true) });
				$('#'+container).append(this.extraPageItem[0].cloneNode(true));
			}
		} else if (current_page > (total_pages-7)) {
			if ((total_pages-9) > 0) {
				///$(container).insert({ bottom: this.extraPageItem.cloneNode(true) });
				$('#'+container).append(this.extraPageItem[0].cloneNode(true));
			}
			var pageli;
			var pagea;
			var start = ((total_pages-8)>0?(total_pages-8):1);
			for(var i=start;i<=total_pages;i++) {
				this.makePaginationNumber(i, current_page, container, callback);
			}
		} else {
			//$(container).insert({ bottom: this.extraPageItem.cloneNode(true) });
			$('#'+container).append(this.extraPageItem[0].cloneNode(true));
			var pageli;
			var pagea;
			for(var i=(current_page-3);i<=(current_page+3);i++) {
				this.makePaginationNumber(i, current_page, container, callback);
			}
			//$(container).insert({ bottom: this.extraPageItem.cloneNode(true) });
			$('#'+container).append(this.extraPageItem[0].cloneNode(true));
		}
	},
	makePaginationNumber: function(i, current_page, container, callback) {
		pageli =  $(this.pageItem[0].cloneNode(false));
		pagea = $(this.pageItemInner[0].cloneNode(true));
		if (i == current_page) $(pageli).addClass('current');
		pagea.html(i);
		pageli.html(pagea);
		//$(container).insert({ bottom: pageli });
		$('#'+container).append(pageli);
		$(pagea).click(function() {
		  wheretobuy.goToPage(this, i);
		});
		//$(pagea).observe('click', eval(callback+'.bindAsEventListener(this, i)'));
	}
}