<?php include('_includes/header.php'); ?>
<?php $get_page_content = mysql_query("SELECT category_slug, category_meta_description, page_title, page_content FROM cms_categories WHERE category_slug = '".$urlPath_array[1]."'")?>
<?php $page_content = mysql_fetch_assoc($get_page_content);?>

<div class="main_content">
	<div class="page_header border8">
		<div class="ind">
			<img class="left border18" src="" width="344" height="160"/>
			<div class="page_content right">
				<div class="ind">
					<h3><?php echo $page_content['page_title'];?></h3>
					<p><?php echo stripslashes($page_content['category_meta_description']);?></p>
				</div>
			</div>
		<br class="clear"/>
		</div>
	</div>
</div>
<div id="page_content"><?php echo empty($_POST)?stripslashes($page_content['page_content']):'';?></div>

<?php //if($_POST) {?>
<!--h3>What to Expect Next:</h3>

<p>Thank you for your interest in opening a Thirsties Wholesale Account! We have received your initial application.</p>

<p>We will verify your Tax ID resale license. Please note, this is not the same as an EIN. If you have provided your EIN number rather than a state issued business number or resale Tax ID, we cannot proceed any further with your application. Please resubmit with the proper information
Next we will look to see that you have a personally hosted, fully-activated website or a brick and mortar location.
So long as these first steps check out, you will hear back from us via email within 2-3 days.</p>

<p>Thanks again for your interest!</p-->

<?php //} else { ?>
<script src="_js/submitform.js" type="text/javascript"></script>

<form id="sendEmail" action="<?php echo curPageURL();?>" enctype="multipart/form-data" method="post">
<table>
	<tr>
    	<td colspan="4"><h3>Wholesale Info Request:</h3></td>
    </tr>
    
    <tr>
    	<td colspan="4"><p class="alert">* Required field</p></td>
    </tr>
    <tr>
    	<td></td>
        <td colspan="2"><input type="hidden" name="emailTo" id="emailTo" value="wholesale@thirstiesbaby.com" /></td>
        <!--td colspan="2"><input type="hidden" name="emailTo" id="emailTo" value="alyssa@nikkelkrome.com" /></td-->
        <td><?php if(isset($emailToError)) echo '<span class="error">'.$emailToError.'</span>'; ?></td>
    </tr>
    <tr>
    	<td><label for="business-name">business name</label>*</td>
        <td colspan="2"><input type="text" name="business-name" id="business-name" value="<?php echo stripslashes(!empty($_POST['business-name'])?$_POST['business-name']:'') ?>"/></td>
        <td><?php if(isset($businessNameError)) echo '<span class="error">'.$businessNameError.'</span>'; ?></td>
    </tr>
    <tr>
    	<td><label for="contact-name">contact name</label>*</td>
        <td colspan="2"><input type="text" name="contact-name" id="contact-name" value="<?php echo stripslashes(!empty($_POST['contact-name'])?$_POST['contact-name']:'') ?>"/></td>
        <td><?php if(isset($contactNameError)) echo '<span class="error">'.$contactNameError.'</span>'; ?></td>
    </tr>
    <tr>
    	<td><label for="business-address">city, state, zip</label>*</td>
        <td colspan="2"><input type="text" name="business-address" id="business-address" value="<?php echo stripslashes(!empty($_POST['business-address'])?$_POST['business-address']:'') ?>"/></td>
        <td><?php if(isset($businessAddressError)) echo '<span class="error">'.$businessAddressError.'</span>'; ?></td>
    </tr>
    <tr>
    	<td><label for="business-email">email</label>*</td>
        <td colspan="2"><input type="text" name="business-email" id="business-email" value="<?php echo stripslashes(!empty($_POST['business-email'])?$_POST['business-email']:'') ?>"/></td>
        <td><?php if(isset($businessEmailError)) echo '<span class="error">'.$businessEmailError.'</span>'; ?></td>
    </tr>
    <tr>
    	<td><label for="business-license">resale license #*<br/>
<span class="tiny">(not your EIN)</span></label></td>
        <td colspan="2"><input type="text" name="business-license" id="business-license" value="<?php echo stripslashes(!empty($_POST['business-license'])?$_POST['business-license']:'') ?>"/></td>
        <td><?php if(isset($businessLicenseError)) echo '<span class="error">'.$businessLicenseError.'</span>'; ?></td>
    </tr>
    <tr>
    	<td><label for="business-url">website url</label></td>
        <td colspan="2"><input type="text" name="business-url" id="business-url" value="<?php echo stripslashes(!empty($_POST['business-url'])?$_POST['business-url']:'') ?>"/></td>
    </tr>
    <tr>
    	<td class="buttons"></td>
    	<td><button type="submit" id="submit">Submit Request &raquo;</button><input type="hidden" name="submitted" id="submitted" value="true" /></td>
        <td><button type="reset" value="clear this form">clear form</button></td>
        <td></td>
    </tr>
</table>
</form>

<?php //} ?>


<?php include('_includes/footer.php'); ?>