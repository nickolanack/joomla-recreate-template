
<?php

if(!defined('DS'))define('DS', DIRECTORY_SEPARATOR); //Joomla 3 doesn't define this but I really like it.

/**
 * check for component specific css file.
*/
if($component=JRequest::getVar('option',false)){
	$component=str_replace(array('com_',' '), '', $component);


	//checks for existing css file
	$file='css'.DS.'com'.DS.$component.'.css';
	if(!file_exists(dirname(__FILE__).DS.$file)){
		//die(dirname(__FILE__).DS.$file);
		$file=false;
	}

	//checks for the same file as above, but with .php extension.
	//this allows for dynamic css to be generated, to support
	//theme setting controls.
	//note* I am importing controls from com_geolive so that must exist!
	$filep='css'.DS.'com'.DS.$component.'.php';
	if(!file_exists(dirname(__FILE__).DS.$filep)){
		//die(dirname(__FILE__).DS.$file);
		$filep=false;
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
	xml:lang="<?php echo $this->language; ?>"
	lang="<?php echo $this->language; ?>">
<head>
<link
	href='http://fonts.googleapis.com/css?family=Oswald:300,400|Open+Sans:300,600,700'
	rel='stylesheet' type='text/css'>
<meta http-equiv="X-UA-Compatible" content="IE=100" />

<link rel="stylesheet"
	href="templates/<?php echo $this->template ?>/css/system.css"
	type="text/css" />
<link rel="stylesheet"
	href="templates/<?php echo $this->template ?>/css/template.css"
	type="text/css" />

<?php 
if($file){
	?>
<link rel="stylesheet"
	href="<?php 
		//DS might not match url directory seperator
		echo $this->baseurl.'/templates/'.$this->template.'/'.str_replace(DS, '/', $file); ?>"
	type="text/css" />

<?php 
}
if($filep){
	//including the dynamic css.
	//look at /css/com/content.php for an example of how this is working.
	include $filep;
}
?>

<jdoc:include type="head" />


</head>
<body class="<?php echo $component?$component:""; ?> BGColor_Background"
	hint="<?php echo ($file?'found: ':'missing: ').'com'.DS.$component.'.css'; ?>">
	<?php if(count(JFactory::getApplication()->getMessageQueue())){?>
	<jdoc:include type="message" />
	<?php } ?>
	
	<div id="gt_banner" class="gt_bgc BordersLinesColor">

		<div class="gt_pos">
			<div class="displayPic">
				<jdoc:include type="modules" name="userPhoto" />
			</div>
			<div class="login">

				<li><a href="#loginmenu"
					onclick="jQuery('popfrommenu').trigger('click');" id="test"> <?php echo (JFactory::getUser()->guest==1)?"Login":"Logout"; ?>
				</a></li>

				<div id="loginWidth">
					<div id="loginPopContent" style="display: none">
						<?php if(JFactory::getUser()->guest){
							//guest code
							?>
						<jdoc:include type="modules" name="login" />
						<hr />
						<table>
							<tr>
								<td><img
									src="templates/<?php echo $this->template ?>/images/user.png"
									alt="User" title="User" width="16" class="userimage" /></td>
								<td><jdoc:include type="modules" name="register" /></td>
							</tr>
							<tr>
								<td></td>
								<td>
									<p class="loginRegisterText">
										<a href="/index.php/component/users/?view=remind">Forgot your
											username?</a>
									</p>
									<p class="loginRegisterText">
										<a href="/index.php/component/users/?view=reset">Forgot your
											password?</a>
									</p>
								</td>
							</tr>
						</table>

						<hr />
						<table>
							<tr>
								<td><a href="/index.php/component/hs_users/?view=registration"><img
										src="templates/<?php echo $this->template ?>/images/registerUser.png"
										alt="Register" title="Register" width="16"
										class="registerimage" /> </a></td>
								<td><p class="loginRegisterText">
										<a href="/index.php/component/users/?view=registration">Register
											as a new user</a>
									</p></td>
							</tr>
						</table>

						<?php 
						}else{

				//member code
				?>
						<script type="text/javascript">
				jQuery('#loginPopContent').height('90px');
				</script>
						<jdoc:include type="modules" name="login" />

						<?php 				
			}?>

					</div>
				</div>
				<?php JHtml::_('jquery.framework'); ?>
				<script type="text/javascript">
		 jQuery('#test').on('click',function(e){
			if (jQuery('#loginPopContent').css('display')=="none"){
				jQuery('#loginPopContnet').css("visibility", "visible");
				jQuery('#loginPopContent').slideDown();
				jQuery('#searchPopContent').slideUp(600);
				e.stopPropagation();
			}else{
				jQuery('#loginPopContent').slideUp();
			}	
		});
	 
		 
	 </script>
			</div>
			<jdoc:include type="modules" name="top" />
		</div>


	</div>
	
	<div class="gt_c" id="gt_banner_toggle">
		<h1 onclick="window.location='http://recreate.geolive.ca';">
			<?php 

			//creates a site name string with first word enclosed in span.first-word
			$sitename=JFactory::getApplication()->getCfg( 'sitename' );
			$sitenameParts=explode(' ', $sitename);
			$sitenameParts[0]='<span class="first-word">'.$sitenameParts[0].'</span>';
			echo implode(' ', $sitenameParts);

			?>
		</h1>
		<a href="/" style="position: absolute; left: 0; top: -50px; z-index: 1;"><img src="/templates/shimatheme/images/recreate.png" style="width: 100px;"></a>
	</div>
	<div id="gt_top" class="gt_bgc gt_bdrc"></div>
	<div class="gt_space"></div>


	<div id="gt_middle">
		<div id="mapContainer">
			<jdoc:include type="component" />
		</div>
		<?php if($component=='geolive'){?><div style=" float: right; margin-top: 10px; margin-right: 10px; font-size: 12px; ">This mapping project and spatial data was created by <span style="color: steelblue;
		">Alastair Wilson</span> at the <a href="http://ubc.ca">University of British Columbia</a></div><?php }?>
		<div id="module_bottom">
			<jdoc:include type="modules" name="bottom" /> 
		</div>
		<!-- insert social meida here -->
		
	</div>

	
	<div class="gt_space"></div>
	<div id="gt_bottom">
		
		<a href="http://spice.geolive.ca" target="_blank"  style="width: 150px; margin-right: 120px;"><img title="Geolive" src="/templates/shimatheme/images/spice.png" alt="The Spice Lab" height="63" style="height: 32px; width: auto;" />
		<span>Created by the spice lab at the University of British Columbia</span>
		</a>
		
		<a href="http://www.geolive.ca" target="_blank" style=" margin-right: 180px;"><img title="Geolive" src="/templates/shimatheme/images/geoliveLogo.png" alt="Geolive" height="63" style="height: 32px; width: auto;" />
		<span>This website uses Geolive the interactive mapping tool created by the spice lab</span>
		</a>
		
		
		
		<a href="http://mapicons.nicolasmollet.com/" target="_blank"><img src="/templates/shimatheme/images/logo.gif" alt="" width="153" height="55"  style="top:-10px;" />
		<span>Iconset used under Creative Commons 3.0 BY-SA Courtesy of Nicolas Mollet</span>
		</a>
		
		
	</div>
	<jdoc:include type="message" />
</body>
</html>
