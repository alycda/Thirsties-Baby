<script src="http://jqueryui.com/jquery-1.5.1.js"></script>
	<style>
	.selected a{color:#f00;}
	</style>
	

<ul id="select_region" class="nav">
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

