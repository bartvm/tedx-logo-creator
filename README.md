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
generated directly using a GET request to the script (logo.php) with the following
parameters:

<table>
	<tr>
		<th>Parameter</th>
		<th>Required/optional</th>
		<th>Value</th>
		<th>Comments</th>
	</tr>
	<tr>
		<td><code>eventname</code></td>
		<td>Required</td>
		<td><code>string</code></td>
		<td>URL encoded</td>
	</tr>
	<tr>
		<td><code>color</code></td>
		<td>Required</td>
		<td><code>black</code> or <code>white</code></td>
		<td>Color of the letters; not the background.</td>
	</tr>
	<tr>
		<td><code>transparency</code></td>
		<td>Optional</td>
		<td><code>true</code> or <code>false</code></td>
		<td></td>
	</tr>
	<tr>
		<td><code>tagline</code></td>
		<td>Required</td>
		<td><code>1</code> or <code>2</code></td>
		<td><code>1</code> for a one-line tagline, <code>2</code> for the two-line version</td>
	</tr>
	<tr>
		<td><code>eventline</code></td>
		<td>Required</td>
		<td><code>1</code> or <code>2</code></td>
		<td><code>1</code> for the event name on the same line, <code>2</code> for on a separate line</td>
	</tr>
	<tr>
		<td><code>maxwidth</code></td>
		<td>Optional*</td>
		<td><code>numeric</code></td>
		<td>Maximum width of the image in pixels, must be positive.</td>
	</tr>
	<tr>
		<td><code>maxheight</code></td>
		<td>Optional*</td>
		<td><code>numeric</code></td>
		<td>Maximum height of the image in pixels, must be positive.</td>
	</tr>	
		<tr>
		<td><code>border</code></td>
		<td>Required</td>
		<td><code>numeric</code></td>
		<td>Clear space around the logo in pixels, must be non-negative.</td>
	</tr>
	<tr>
		<td><code>square</code></td>
		<td>Optional</td>
		<td><code>true</code> or <code>false</code></td>
		<td></td>
	</tr>
	<tr>
		<td><code>format</code></td>
		<td>Required</td>
		<td><code>png32</code> or <code>jpeg</code></td>
		<td>JPEG can only be chosen without a transparent background.</td>
	</tr>
</table>

\* Either `maxwidth` or `maxheight` must be set, or both.

### Example

http://bartvanmerrienboer.nl/tedxlogo/logo.php?eventname=Warwick&color=white&tagline=2&eventline=2&maxwidth=500&border=10&square=true&format=png32

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

This script was inspired by Yongho Shin's and Brian Alexander's PHP script
(http://www.tedx-sandiego.com/creator/).