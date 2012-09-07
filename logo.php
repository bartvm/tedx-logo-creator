<?php
/**
 * This script creates TEDx logos. It uses an SVG base file, transforms it using XSLT if
 * necessary, and then exports it to a JPEG, PNG or GIF file using ImageMagick.
 *
 * ImageMagick >= 6.2.9, SimpleXML and xsl required
 *
 * @author Bart van Merriënboer <bart@tedxwarwick.com>
 */ 

/* Load the SVG file */
switch ($_GET['eventline']) {
	case '1':
	case '2':
		break;
	default:
		exit('Invalid or no event line format provided. Must be \'1\' or \'2\'.');
}

switch ($_GET['tagline']) {
	case '1':
	case '2':
		break;
	default:
		exit('Invalid or no tagline format provided. Must be \'1\' or \'2\'.');
}
	
$svg = simplexml_load_file('./' . $_GET['eventline'] . $_GET['tagline'] . '.svg');

/* Change the event name */
if (!isset($_GET['eventname'])) {
	exit('No event name provided');
} else {
	$svg->text = urldecode($_GET['eventname']);
}

/* Determine background color */
switch ($_GET['color']) {
	case 'black':
		$background = 'white';
		break;
	case 'white':
		$background = 'black';
		break;
	default:
		exit('Invalid or no color provided. Must be \'black\' or \'white\'.');
}

if (isset($_GET['transparency'])) {
	if ($_GET['transparency'] == 'true') {
		$background = 'transparent';
	} elseif ($_GET['transparency'] != 'false') {
		exit('Invalid transparency value provided. Must be \'true\', \'false\', or empty.');
	} 
}

/* Change font color if needed */
if ($_GET['color'] == 'black') { // If font color is black, use XSL to change font color in SVG
	$xsl = simplexml_load_file('color.xsl');
	$proc = new XSLTProcessor;
	$proc->importStyleSheet($xsl);
	$svg = simplexml_load_string($proc->transformToXML($svg));
}

/* Determine the scaling of the SVG file */
$im = new Imagick();
$im->setBackgroundColor(new ImagickPixel($background));
$im->readImageBlob($svg->asXML());
$im->setImageFormat("png32");
$im->trimImage(0);

if (!isset($_GET['maxwidth']) && !isset($_GET['maxheight'])) {
	exit('No maximum height and maximum width provided. At least one must be given.');
} else {
	if (isset($_GET['maxwidth']) && (!is_numeric($_GET['maxwidth']) || $_GET['maxwidth'] <= 0)) {
		exit('Invalid maximum width value provided. Must be numeric and positive.');
	}
	if (isset($_GET['maxheight']) && (!is_numeric($_GET['maxheight']) || $_GET['maxheight'] <= 0)) {
		exit('Invalid maximum height value provided. Must be numeric and positive.');
	}
}

if (!is_numeric($_GET['border']) || $_GET['border'] < 0) {
	exit('No or invalid clear space value provided. Must be numeric and non-negative.');
}

if (isset($_GET['square']) && $_GET['square'] == 'true') {
		if (isset($_GET['maxheight']) && isset($_GET['maxwidth'])) {
			$scaling = min(($_GET['maxwidth'] - 2*$_GET['border'])/$im->getImageWidth(), ($_GET['maxheight'] - 2*$_GET['border'])/$im->getImageHeight());
		} elseif (isset($_GET['maxwidth'])) {
			$scaling = min(($_GET['maxwidth'] - 2*$_GET['border'])/$im->getImageWidth(), ($_GET['maxwidth'] - 2*$_GET['border'])/$im->getImageHeight());
		} else {
			$scaling = min(($_GET['maxheight'] - 2*$_GET['border'])/$im->getImageWidth(), ($_GET['maxheight'] - 2*$_GET['border'])/$im->getImageHeight());
		}
} elseif ((isset($_GET['square']) && $_GET['square'] == 'false') || !isset($_GET['square'])) {
	if (isset($_GET['maxwidth']) && isset($_GET['maxheight'])) {
		$scaling = min(($_GET['maxwidth'] - 2*$_GET['border'])/$im->getImageWidth(), ($_GET['maxheight'] - 2*$_GET['border'])/$im->getImageHeight());
	} elseif (isset($_GET['maxwidth'])) {
		$scaling = ($_GET['maxwidth'] - 2*$_GET['border'])/$im->getImageWidth();
	} else {
		$scaling = ($_GET['maxheight'] - 2*$_GET['border'])/$im->getImageHeight();
	}
}	else {
	exit('Invalid square value provided. Must be \'true\', \'false\', or empty.');
}

/* Clean up */
$im->clear();
$im->destroy();

/* Scale the SVG image */
$svg['width'] = substr($svg['width'], 0, -2) * $scaling;
$svg['height'] = substr($svg['height'], 0, -2) * $scaling;

/* Reload the scaled SVG data as image */
$im = new Imagick();
$im->setBackgroundColor(new ImagickPixel($background));
$im->readImageBlob($svg->asXML());

/* Choose the image format */

switch ($_GET['format']) {
	case 'png32':
		$header = 'png';
		break;
	case 'jpeg':
		if ($background == 'transparent') {
			exit('Image format \'jpeg\' is not allowed with a transparent background.');
		}
		$header = 'jpg';
		$im->setImageCompressionQuality(90);
		break;
	default:
		exit('Invalid image format provided. Must be \'png32\' or \'jpeg\'.');
}

$im->setImageFormat($_GET['format']);

/* Add the clear space */
$im->trimImage(0);
if ($_GET['square'] == 'true') {
	if ($im->getImageWidth() > $im->getImageHeight()) {
		$im->borderImage($background, $_GET['border'], $_GET['border'] + ($im->getImageWidth() - $im->getImageHeight())/2);
	} else {
		$im->borderImage($background, $_GET['border'] + ($im->getImageHeight() - $im->getImageWidth())/2, $_GET['border']);
	}
} else {
	$im->borderImage($background, $_GET['border'], $_GET['border']);
}

/* Sometimes the resolution doesn't exactly match because of rounding errors, 
 * so add a few pixels to the right or bottom to make it fit */

if ($_GET['square'] == 'true') { // Square image
	if (isset($_GET['maxwidth']) && isset($_GET['maxheight'])) {
		$im->extentImage(min($_GET['maxwidth'], $_GET['maxheight']), min($_GET['maxwidth'], $_GET['maxheight']), 0, 0);
	} elseif (isset($_GET['maxwidth'])) {
		$im->extentImage($_GET['maxwidth'], $_GET['maxwidth'], 0, 0);
	} else {
		$im->extentImage($_GET['maxheight'], $_GET['maxheight'], 0, 0);
	}
} else { // Rectangular
	
	$xFill = (isset($_GET['maxwidth']) ? $_GET['maxwidth'] - $im->getImageWidth() : PHP_INT_MAX);
	$yFill = (isset($_GET['maxheight']) ? $_GET['maxheight'] - $im->getImageHeight() : PHP_INT_MAX);
		
	if ($xFill > 0 && $yFill > 0) { // The image is too small, both sides
		if ($xFill <= $yFill) {
			$im->extentImage($_GET['maxwidth'], $im->getImageHeight(), 0, 0);
		} else {
			$im->extentImage($im->getImageWidth(), $_GET['maxheight'], 0, 0);
		}
	} else { // It either fits, or is too big
		if ($xFill < 0) { // The image is too wide
			$im->extentImage($_GET['maxwidth'], $im->getImageHeight(), 0, 0);
		}
		if ($yFill < 0) { // The image is too tall
			$im->extentImage($im->getImageWidth(), $_GET['maxheight'], 0, 0);
		}
	}
}

/* Save and display image */

$im->writeImage('assets/' . time() . '-' . urldecode($_GET['eventname']) . '.' . $header);
header("Content-Type: image/" . $header);
echo $im;

/* Clean up */

$im->clear();
$im->destroy();
?>