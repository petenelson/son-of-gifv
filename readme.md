# Son of GIFV #
**Contributors:** gungeekatx  
**Tags:** gif, gifv, animated gif, mp4  
**Donate link:** https://petenelson.io/  
**Requires at least:** 4.4  
**Tested up to:** 4.7  
**Stable tag:** 1.0.0  
**License:** GPLv2 or later  
**License URI:** http://www.gnu.org/licenses/gpl-2.0.html  

Convert animated GIFs to GIFV format

## Description ##

Animated GIFs are large.  The GIFV format introduced by [Imgur](https://blog.imgur.com/2014/10/09/introducing-gifv/)
solves this problem by converting animated GIFs to MP4 and embedding them in an HTML page.  This plugin
leverages the [Imgur API](https://api.imgur.com/) to convert animated GIFs hosted on your WordPress site
into locally hosted GIFV URLs.

* Adds "Convert to GIFV" to the Media Library
* Creates URLs for converted GIFV files (ex: mysite.com/animated.gifv)
* Twitter card and Facebook opengraph support for sharing
* WP-CLI support via "gifv"

Plugin name inspired by [Son of Clippy](https://wordpress.org/plugins/son-of-clippy/)

Find us on [GitHub](https://github.com/petenelson/son-of-gifv)


## Installation ##

1. Upload the son-of-gifv directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Visit Settings > Son of GIFV to configure plugin settings

## Changelog ##

### v1.0.0 October 5, 2016 ###
* Initial release


## Upgrade Notice ##

### v1.0.0 October 5, 2016 ###
* Initial release


## Frequently Asked Questions ##

### How does it work? ###

1. "Convert GIFV" is selected.
2. The animated GIF is upload to the Imgur API.
3. The Imgur API converts it to MP4 format.
4. The MP4 and a thumbnail are downloaded back into your WordPress site.
5. The original GIF is flagged with the GIFV information.


## Screenshots ##

### 1. "Convert to GIFV" on a media admin screen ###
!["Convert to GIFV" on a media admin screen](https://raw.githubusercontent.com/petenelson/son-of-gifv/master/wp-repo-assets/screenshot-1.png)

### 2. "View GIFV" link for a GIF that has been converted ###
!["View GIFV" link for a GIF that has been converted](https://raw.githubusercontent.com/petenelson/son-of-gifv/master/wp-repo-assets/screenshot-2.png)

### 3. "View GIFV" link when viewing a GIF in the media grid ###
!["View GIFV" link when viewing a GIF in the media grid](https://raw.githubusercontent.com/petenelson/son-of-gifv/master/wp-repo-assets/screenshot-3.png)

### 4. Inline "View GIFV" link when viewing the media list ###
![Inline "View GIFV" link when viewing the media list](https://raw.githubusercontent.com/petenelson/son-of-gifv/master/wp-repo-assets/screenshot-4.png)

### 5. Example of the .gifv extension displaying the converted GIF ###
![Example of the .gifv extension displaying the converted GIF](https://raw.githubusercontent.com/petenelson/son-of-gifv/master/wp-repo-assets/screenshot-5.png)

