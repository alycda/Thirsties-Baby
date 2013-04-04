</section>
<footer class="center">
<?php $get_nav = mysql_query("SELECT category_id, category_parent_id, category_name, category_slug, external_link, category_order, category_active FROM cms_categories WHERE category_parent_id = 0 AND category_active = 1 ORDER BY category_order ASC"); ?>
	<ul id="footerLeft" class="nav left">
	<?php while ($nav2 = mysql_fetch_assoc($get_nav)) {?>
		<li id="<?php echo $nav2['category_slug'];?>_nav" <?php if($nav2['category_slug'] == 'home') { echo 'class="hide"';}?>>
			<h5><a href="<?php echo $nav2['category_slug'];?>"><?php echo $nav2['category_name'];?></a></h5>
			<?php $get_sub = mysql_query("select category_id, category_parent_id, category_name, category_slug, external_link, category_active, category_order from cms_categories where category_parent_id = ".$nav2['category_id']." and category_active = 1 order by category_order asc"); ?>
			<ul class="footerNav nav small">
			<?php while($sub2 = mysql_fetch_assoc($get_sub)) {?>
                <li><a <?php echo !empty($sub2['external_link'])?'href="'.$sub2['external_link'].'"':'href="'.$nav2['category_slug']."/".$sub2['category_slug'].'"';?> <?php echo stristr($sub2['external_link'],'http')?'target="_blank"':'';?>><?php echo stripslashes($sub2['category_name']);?> <?php //echo !empty($sub['external_link'])?'<span class="right">[img]</span>':'';?></a></li>
				<?php if($nav2['category_slug'] == 'products') {?>
                	<?php $get_prod_nav2 = mysql_query("SELECT * FROM cms_content WHERE category_id = ".$sub2['category_id']." AND content_active = 1");?>
                	<?php while($prod_nav2 = mysql_fetch_assoc($get_prod_nav2)) {?>
                	<li><a href="/<?php echo $nav2['category_slug']; ?>/<?php echo $sub2['category_slug']; ?>/<?php echo $prod_nav2['content_slug']; ?>"><?php echo $prod_nav2['content_title']; ?></a></li>
                	<?php } ?>
                <?php } ?>
			<?php } ?>
			</ul><!--END .footerNav-->
		</li><!--END #<?php echo $nav2['category_slug'];?>_nav-->
	<?php } ?>
	</ul>
	<ul id="footerRight" class="nav right"> 
    		<div id="mailingList" class="right">
            <span class="mail_head center">Sign Up For Our Mailing List:</span>
            <!-- <span class="descrip2">enter your email below</span><br /> -->

            <form method="post" action="http://www.aweber.com/scripts/addlead.pl"  >
                <div style="display: none;">
                <input type="hidden" name="meta_web_form_id" value="855614887" />
                <input type="hidden" name="meta_split_id" value="" />
                <input type="hidden" name="listname" value="rarchitecture" />
                <input type="hidden" name="redirect" value="http://relationship-architecture.com/newsletter-confirm.php" id="redirect_dadb7c20bac280ded93ff8c5b4f71d75" />
                <input type="hidden" name="meta_redirect_onlist" value="http://relationship-architecture.com/newsletter-subscribed.php" />
                <input type="hidden" name="meta_adtracking" value="My_Web_Form" />
                <input type="hidden" name="meta_message" value="1" />
                
                <input type="hidden" name="meta_required" value="email" />
                <input type="hidden" name="meta_forward_vars" value="" />
                <input type="hidden" name="meta_tooltip" value="" />
                </div>
            	<input name="email" size="15" class="email_home" value="Enter your email address" onFocus="this.value = (this.value == 'Enter your email address') ? '' : this.value;" onBlur="this.value = (this.value == '') ? 'Enter your email address' : this.value;"/>

    			<input type="submit" value="submit" class="submit"/>
			</form>
            
            </div>

		<li class="green"><a href="#" target="_blank" title="Green America">green america</a></li>
        <li class="usa"><a href="#" target="_blank" title="Made in the USA">made in the usa</a></li>
	</ul>
	<br class="clear"/>
</footer>

<div id="footer-bottom">
	<div class="block"> 
		<span class="right small"><a href="/customer-center/privacy-policy">privacy policy</a> | <a href="/customer-center/terms-conditions">terms and conditions</a></span>
		<div id="nk"><span>developed by </span><a href="http://nikkelkrome.com" id="nk-logo" target="_blank">nikkelkrome</a></div>
		<div id="copyright">
			<p>&copy; 2011 Thirsties Inc. // Thirsties, Inc.  | 436 West 67th St. | Loveland, CO 80538</p>
        </div>
	 </div>
</div><!-- // footer-bottom -->

<script type="text/javascript">
$(document).ready(function(){
	$('ul#topNav').superfish({
		delay:500,
		animation:{opacity:'show',height:'show'},
		speed:'fast',
		autoArrows:false,
		dropShadows:false
	});
	
});


	/* <![CDATA[ */
			$(window).load(function () {
				$('#VolusionLiveChat a').append("Live Chat");
				$('#VolusionLiveChat img').hide();$('#volusion').show();
			});
		/* ]]> */

</script>

<?php if ($urlPath_array[0] == 'home') {?>
<script type="text/javascript" src="_js/ashworth.js"></script>
<script type="text/javascript" src="_js/slider.js"></script>
<script type="text/javascript" src="_js/slider_init.js"></script>
<?php } ?>

<script type="text/javascript">
	//curvyCorners.init();

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-17359695-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
	</body>	
</html>