TEDx logo creator
=================

This PHP script generates TEDx logos, with the following options:

* White on black, or black on white
* Optional transparent background (PNG only)
* One- or two-line tagline
* Event name on same line or separate line
* Maximum height and/or maximum width
* Custom clear space around the logo
* Generate square images
* Export to PNG or JPEG

The script is currently hosted at http://bartvanmerrienboer.nl/tedxlogo/

GET HTTP requests
-----------------

The script can either be used with the provided form (index.php) or images can be
generated directly using a HTTP request with the following parameters:

<table>
	<tr>
		<th>Parameter</th>
		<th>Required/optional</th>
		<th>Value</th>
		<th>Comments</th>
	</tr>
	<tr>
		<td>`eventname`</td>
		<td>Required</td>
		<td>`string`</td>
		<td>URL encoded</td>
	</tr>
	<tr>
		<td>color</td>
		<td>Required</td>
		<td>`black` or `white`</td>
		<td>Color of the letters; not the background.</td>
	</tr>
	<tr>
		<td>`transparency`</td>
		<td>Optional</td>
		<td>`true` or `false`</td>
		<td></td>
	</tr>
	<tr>
		<td>`tagline`</td>
		<td>Required</td>
		<td>`1` or `2`</td>
		<td>`1` for a one-line tagline, `2` for the two-line version</td>
	</tr>
</table>

Working
-------

The script uses SVG files, which are based on the EPS files provided by TED. Note that all
shapes of the original EPS have been thinned by 0.5 points because ImageMagick's SVG
rasterization produces fairly thick edges. SimpleXML and XSLT are used to edit the SVG
files before using the ImageMagick library to create the images.

Requirements
------------

* PHP 5
* ImageMagick >= 6.3 (http://www.imagemagick.org/)
* Imagick PHP wrapper (http://pecl.php.net/package/imagick)
* SimpleXML
* xsl

Credits
-------

This TEDx logo creator was inspired by Yongho Shin's and Brian Alexander's PHP script
(http://www.tedx-sandiego.com/creator/).