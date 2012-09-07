<?php
ob_start('ob_gzhandler');
header('Content-Type: text/html; charset=utf-8');
?>
<!doctype html>
<html lang="en" xmlns:og="http://ogp.me/ns#" xmlns:fb="https://www.facebook.com/2008/fbml">
	<head>
		<meta charset="utf-8">
		<title>TEDx logo creator</title>
		<meta name="description" content="TEDx logo creator">
		<meta name="author" content="Bart van Merriënboer">
    <meta property="og:title" content="TEDx logo creator">
    <meta property="og:type" content="website">
    <meta property="og:url" content="http://bartvanmerrienboer.nl/tedxlogo/">
    <meta property="og:image" content="http://bartvanmerrienboer.nl/tedxlogo/img/facebook-thumbnail.png">
    <meta property="og:site_name" content="TEDx logo creator">
    <meta property="fb:admins" content="bart.vanmerrienboer">
    <meta property="og:description"
          content="Create your own TEDx event logo automatically.">
    <link rel="image_src" href="http://bartvanmerrienboer.nl/tedxlogo/img/facebook-thumbnail.png">
		<!--[if lt IE 9]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				/* This script hides the font color option if the background isn't set to transparent */
				if($("input[name=transparency]").prop('checked') == true) {
					$("select[name=format]").parent().parent().hide();				
				} else {
					$("select[name=format]").parent().parent().show();	
				}		
				$("input[name=transparency]").change(function() {
					if($(this).prop('checked') == true) {
						$("select[name=format]").parent().parent().hide();		
						$("option[value=png32]").attr('selected', true);		
					} else {
						$("select[name=format]").parent().parent().show();	
					}
				});
				
				/* This script keeps the height and width the same if square is selected */
				$("input[name=square]").change(function() {
					if($(this).prop('checked') == true) {
						$("input[name=maxheight]").val($("input[name=maxwidth]").val());
						$("input[name=setheight]").prop('checked', true);
						$("input[name=maxheight]").prop('disabled', false);
						$("input[name=setwidth]").prop('checked', true);
						$("input[name=maxwidth]").prop('disabled', false);
					}
				});
				$("input[name=maxwidth]").change(function() {
					if($("input[name=square]").prop("checked") == true) {
						$("input[name=maxheight]").val($("input[name=maxwidth]").val());
					}
				});
				
				$("input[name=maxheight]").change(function() {
					if($("input[name=square]").prop("checked") == true) {
						$("input[name=maxwidth]").val($("input[name=maxheight]").val());
					}
				});
				
				/* This enables the help popovers */
				$("a[rel=popover]").popover({
					trigger: 'hover',
					placement: 'right'
				});
				
				if($("input[name=setheight]").prop('checked') == false) {
						$("input[name=maxheight]").prop('disabled', true);
				}
				if($("input[name=setwidth]").prop('checked') == false) {
						$("input[name=maxwidth]").prop('disabled', true);
				}				
				
				/* This enables and disables the height and width */
				$("input[name=setheight]").change(function() {
					if($("input[name=setheight]").prop('checked') == true) {
						$("input[name=maxheight]").prop('disabled', false);
					} else {
						$("input[name=maxheight]").prop('disabled', true);
						$("input[name=setwidth]").prop('checked', true);
						$("input[name=maxwidth]").prop('disabled', false);
						$("input[name=square]").prop("checked", false);
					}
				});
				$("input[name=setwidth]").change(function() {
					if($("input[name=setwidth]").prop('checked') == true) {
						$("input[name=maxwidth]").prop('disabled', false);
					} else {
						$("input[name=maxwidth]").prop('disabled', true);
						$("input[name=setheight]").prop('checked', true);
						$("input[name=maxheight]").prop('disabled', false);
						$("input[name=square]").prop("checked", false);
					}
				});
				
				/* Create loading button */
				$('button[type=submit]').click(function() {
					$('button[type=submit]').button('loading');
				});
				
				/* Error checking */
				$('form').submit(function() {
					if($('input[name=eventname]').val() == '') {
						$('button').button('reset');
						$('input[name=eventname]').parent().parent().addClass('error');
						return false;
					} else {
						return true;
					}
				});
				$('input[name=eventname]').focus(function() {
					$(this).parent().parent().removeClass('error');
				});

				/* Form elements */		
				$('div.btn-group[data-toggle-name=*]').each(function(){
					var group   = $(this);
					var form    = group.parents('form').eq(0);
					var name    = group.attr('data-toggle-name');
					var hidden  = $('input[name="' + name + '"]', form);
					$('button', group).each(function(){
						var button = $(this);
						button.live('click', function(){
								hidden.val($(this).val());
						});
						if(button.val() == hidden.val()) {
							button.addClass('active');
						}
					});
				});
			});
		</script>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<style type="text/css">
			@media (min-width: 768px) and (max-width: 979px) {
				input, textarea, .uneditable-input, select {
					width: 140px;
				}
				
				.form-horizontal .control-label {
					width: 100px;
				}
				
				.form-horizontal .controls {
					margin-left: 120px;
				}
			}
			
			section {
				padding-top: 30px;
			}
			
			/* Jumbotrons
			-------------------------------------------------- */
			
			/* Base class
			------------------------- */
			.jumbotron {
				position: relative;
				padding: 40px 0;
				color: #fff;
				text-align: center;
				text-shadow: 0 1px 3px rgba(0,0,0,.4), 0 0 30px rgba(0,0,0,.075);
				background: #ff2b06; /* Old browsers */
				background: -moz-linear-gradient(45deg,  #ff2b06 0%, #7C1303 100%); /* FF3.6+ */
				background: -webkit-gradient(linear, left bottom, right top, color-stop(0%,#ff2b06), color-stop(100%,#7C1303)); /* Chrome,Safari4+ */
				background: -webkit-linear-gradient(45deg,  #ff2b06 0%,#7C1303 100%); /* Chrome10+,Safari5.1+ */
				background: -o-linear-gradient(45deg,  #ff2b06 0%,#7C1303 100%); /* Opera 11.10+ */
				background: -ms-linear-gradient(45deg,  #ff2b06 0%,#7C1303 100%); /* IE10+ */
				background: linear-gradient(45deg,  #ff2b06 0%,#7C1303 100%); /* W3C */
				filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ff2b06', endColorstr='#7C1303',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
				-webkit-box-shadow: inset 0 3px 7px rgba(0,0,0,.2), inset 0 -3px 7px rgba(0,0,0,.2);
					 -moz-box-shadow: inset 0 3px 7px rgba(0,0,0,.2), inset 0 -3px 7px rgba(0,0,0,.2);
								box-shadow: inset 0 3px 7px rgba(0,0,0,.2), inset 0 -3px 7px rgba(0,0,0,.2);
			}
			.jumbotron h1 {
				font-size: 80px;
				font-weight: bold;
				letter-spacing: -1px;
				line-height: 1;
			}
			.jumbotron p {
				font-size: 24px;
				font-weight: 300;
				line-height: 30px;
				margin-bottom: 30px;
			}
			
			/* Link styles (used on .masthead-links as well) */
			.jumbotron a {
				color: #fff;
				color: rgba(255,255,255,.5);
				-webkit-transition: all .2s ease-in-out;
					 -moz-transition: all .2s ease-in-out;
								transition: all .2s ease-in-out;
			}
			.jumbotron a:hover {
				color: #fff;
				text-shadow: 0 0 10px rgba(255,255,255,.25);
			}
			
			/* Pattern overlay
			------------------------- */
			.jumbotron .container {
				position: relative;
				z-index: 2;
			}
			.jumbotron:after {
				content: '';
				display: block;
				position: absolute;
				top: 0;
				right: 0;
				bottom: 0;
				left: 0;
				opacity: .4;
			}
			
			/* Subhead (other pages)
			------------------------- */
			.subhead {
				text-align: left;
				border-bottom: 1px solid #ddd;
			}
			.subhead h1 {
				font-size: 60px;
			}
			.subhead p {
				margin-bottom: 20px;
			}
			.subhead .navbar {
				display: none;
			}
			
			/* Footer
			-------------------------------------------------- */
			
			.footer {
				padding: 20px 0;
				margin-top: 20px;
				border-top: 1px solid #e5e5e5;
				border-bottom: 1px solid #e5e5e5;
				background-color: #f5f5f5;
			}
			.footer p {
				margin-bottom: 0;
				color: #777;
			}
			.footer-links {
				margin: 10px 0;
			}
			.footer-links li {
				display: inline;
				margin-right: 10px;
			}

			
			/* Tablet
			------------------------- */
			@media (max-width: 767px) {
			
				/* Widen masthead and social buttons to fill body padding */
				.jumbotron {
					padding: 40px 20px;
					margin-right: -20px;
					margin-left:  -20px;
				}
			
				/* Unfloat the back to top link in footer */
				.footer {
					margin-left: -20px;
					margin-right: -20px;
					padding-left: 20px;
					padding-right: 20px;
				}
				.footer p {
					margin-bottom: 9px;
				}
			}
			
			/* Landscape phones
			------------------------- */
			@media (max-width: 480px) {
				/* Remove padding above jumbotron */
			
				/* Downsize the jumbotrons */
				.jumbotron h1 {
					font-size: 60px;
				}
				.jumbotron p,
				.jumbotron .btn {
					font-size: 20px;
				}
				.jumbotron .btn {
					display: block;
					margin: 0 auto;
				}
			
				/* center align subhead text like the masthead */
				.subhead h1,
				.subhead p {
					text-align: center;
				}

			}
		</style>
	</head>
	<body>
		<header class="jumbotron subhead" id="overview">
			<div class="container">
				<h1>TEDx logo creator</h1>
				<p class="lead">Use the following form to create TEDx logos for your event. Read guidelines on how to use your event's logo on the <a href="http://www.ted.com/pages/creating_your_tedx_logo">TED website</a>.</p>
			</div>
		</header>
		<div class="container">
		<section>
			<div class="row show-grid">
				<div class="span12">
					<script src="js/bootstrap.min.js"></script>
					<form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="POST" class="form-horizontal row">
						<div class="span6">
						<fieldset>
							<legend>Name of your event</legend>
							<div class="control-group">
								<label class="control-label">TEDx&hellip;</label>
								<div class="controls">
									<input type="text" name="eventname" value="<?php echo ($_POST['eventname'] ? $_POST['eventname'] : ''); ?>">
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>Colors and layout</legend>
							<div class="control-group">
								<label class="control-label"><a href="#" rel="popover" data-content="A solid, all-white or all-black background must be used. (For your event's profile on TED.com, a white background is recommended.)" data-original-title="Background"><i class="icon-question-sign"></i></a> Colors</label>
								<div class="controls">
									<div class="btn-group" data-toggle="buttons-radio" data-toggle-name="color">
										<button type="button" value="black" class="btn">White</button>
										<button type="button" value="white" class="btn btn-inverse">Black</button>
									</div>
									<input type="hidden" name="color" value="<?php echo ($_POST['color'] ? $_POST['color'] : 'black'); ?>">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">
									<a href="#" rel="popover" data-content="An image with a transparent background can be created, but remember to not place your TEDx event's logo on other colors than black and white, or on photographic, patterned or illustrative backgrounds." data-original-title="Transparent background"><i class="icon-question-sign"></i></a> Transparent background
								</label>
								<div class="controls">
									<label class="checkbox">
										<input type="checkbox" name="transparency" value="true" <?php echo ($_POST['transparency'] ? 'checked="checked"' : ''); ?>>
									</label>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label"><a href="#" rel="popover" data-content="The one-line tagline logo is preferable. However in situations where there is not enough room to use a logo of this width, the two-line tagline logo may be used. Also, for place names that contain lower-case letters with descenders (p, q, g, j, y) use the two-line stacked tagline so that the descenders do not touch the tagline." data-original-title="Tagline"><i class="icon-question-sign"></i></a> Tag line</label>
								<div class="controls">
									<select name="tagline">
										<option value="1" <?php echo ($_POST['tagline'] == '1' ?  'selected="selected"' : ''); ?>>One line</option>
										<option value="2" <?php echo ($_POST['tagline'] == '2' ?  'selected="selected"' : ''); ?>>Two lines</option>
									</select>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label"><a href="#" rel="popover" data-content="Only use the 2-line template for longer place names." data-original-title="Place name"><i class="icon-question-sign"></i></a> Event text</label>
								<div class="controls">
									<select name="eventline">
										<option value="1" <?php echo ($_POST['eventline'] == '1' ?  'selected="selected"' : ''); ?>>Same line as "TEDx"</option>
										<option value="2" <?php echo ($_POST['eventline'] == '2' ?  'selected="selected"' : ''); ?>>Second line</option>
									</select>
								</div>
							</div>
						</fieldset>
						</div>
						<div class="span6">
						<fieldset>
							<legend>Size and format</legend>
							<div class="control-group">
								<label class="control-label"><a href="#" rel="popover" data-content="To ensure legibility, never use your TEDx event's logo with an overall width that is less than 2.0 inches. At widths that are smaller than 2.0 inches, the tagline will become illegible." data-original-title="Width"><i class="icon-question-sign"></i></a> Maximum width</label>
								<div class="controls">
									<div class="input-append input-prepend">
										<span class="add-on"><input type="checkbox" name="setwidth" value="true" <?php echo (!isset($_POST['setwidth']) || !is_null($_POST['setwidth']) ? 'checked="checked"' : ''); ?>> <i class="icon-resize-horizontal"></i></span>
										<input class="input-medium" type="number" name="maxwidth" value="<?php echo ($_POST['maxwidth'] ? $_POST['maxwidth'] : '550'); ?>">
										<span class="add-on">px</span>
									</div>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Maximum height</label>
								<div class="controls">
									<div class="input-append input-prepend">
										<span class="add-on"><input type="checkbox" name="setheight" value="true" <?php echo (!is_null($_POST['setheight']) ? 'checked="checked"' : ''); ?>> <i class="icon-resize-vertical"></i></span>
										<input class="input-medium" type="number" name="maxheight" value="<?php echo ($_POST['maxheight'] ? $_POST['maxheight'] : '200'); ?>">
										<span class="add-on">px</span>
									</div>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label"><a href="#" rel="popover" data-content="To remain completely legible and ensure that your TEDx event's logo is presented in the best possible manner, a minimum buffer zone of clear space should always be maintained around the entire perimeter of the logo. Other logos, graphics or copy must be kept out of this zone." data-original-title="Clear space"><i class="icon-question-sign"></i></a> Clear space</label>
								<div class="controls">
									<div class="input-append input-prepend">
										<span class="add-on"><i class="icon-fullscreen"></i></span>
										<input class="input-medium" type="number" name="border" value="<?php echo (isset($_POST['border']) ? $_POST['border'] : '20'); ?>">
										<span class="add-on">px</span>
									</div>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">
									<a href="#" rel="popover" data-content="A square image can be useful to create icons that can be used on e.g. Twitter, Facebook and Flickr." data-original-title="Square image"><i class="icon-question-sign"></i></a> Square
								</label>
								<div class="controls">
									<label class="checkbox">
										<input type="checkbox" name="square" value="true" <?php echo ($_POST['square'] ? 'checked="checked"' : ''); ?>>
									</label>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label"><a href="#" rel="popover" data-content="PNG is the recommended format. Only use JPEG when you have to." data-original-title="Image format"><i class="icon-question-sign"></i></a> Image format</label>
								<div class="controls">
									<select name="format">
										<option value="png32" <?php echo ($_POST['format'] == 'png32' ?  'selected="selected"' : ''); ?>>PNG</option>
										<option value="jpeg" <?php echo ($_POST['format'] == 'jpeg' ?  'selected="selected"' : ''); ?>>JPEG (Quality: 90)</option>
									</select>
								</div>
							</div>
						</fieldset>
						</div>
						<button type="submit" class="btn btn-large btn-block span12" data-loading-text="Loading...">Create logo</button>
					</form>
					<?php
					if (isset($_POST['eventname'])) {
						$query_string = 'logo.php?';
						foreach ($_POST as $field => $value) {
							if($field != 'setwidth' && $field != 'setheight') {
								$query_string .= urlencode($field) . '=' . urlencode($value) . '&';
							}
						}
						$query_string = substr($query_string, 0, -1);
						$path_info = pathinfo($_SERVER['SCRIPT_NAME']);
						$image_content = file_get_contents('http://' . $_SERVER['SERVER_NAME'] . htmlentities($path_info['dirname']) . '/' . $query_string);
						if($image = imagecreatefromstring($image_content)) {
							echo '<div style="text-align: center; overflow: scroll;"><p><img style="max-width: none;" src="data:image/png;base64,' . base64_encode($image_content) . '" alt="TEDx' . htmlentities($_POST['eventname']) . ' logo" class="img-polaroid"></p></div>';
						} else {
							echo '<p style="text-align: center;">Sorry, the following error occurred: ' . $image_content . '</p>';
						}
						echo '<pre style="text-align: center;">Width: ' . imagesx($image) . ' Height: ' . imagesy($image) . '<br>Please right-click to save the image to your computer.</pre>';
					}
					?>
				</div>
			</div>
			</section>
		</div>
		<footer class="footer">
			<div class="container">
				<p>By Bart van Merriënboer (<a href="mailto:bart@tedxwarwick.com">bart@tedxwarwick.com)</a></p>
			</div>
		</footer>
	</body>
</html>
<?php ob_end_flush(); ?>