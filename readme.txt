=== Pulp Gallery ===
Contributors: pulpcovers
Requires at least: 5.0
Tested up to: 7.0
Requires PHP: 7.4
Stable tag: 1.1.1
License: GPLv2 or later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html

A lightweight, zero‑bloat WordPress gallery plugin designed for clean, responsive image browsing with swipe navigation on mobile.

== Description ==

Pulp Gallery displays post‑attached images in a simple, touch‑friendly gallery using a single shortcode. It is fast, dependency‑free, and ideal for multi‑page scans, magazines, comics, and archival image sets.

Features include swipe navigation, keyboard support, a thumbnail strip, and an RSS‑safe fallback for feed readers.

== Shortcode ==

Use the shortcode:

    [pulp_gallery]

This displays all image attachments for the current post.

Optional attributes:

    [pulp_gallery size="medium" thumbsize="thumbnail"]

Attributes:

* size — main image size (default: medium)
* thumbsize — thumbnail size (default: thumbnail)

== How It Works ==

1. Edit a post  
2. Upload images via the Media Library  
3. Insert [pulp_gallery] shortcode
4. Save the post  

== Features ==

* Responsive layout
* Swipe + drag navigation on touch devices
* Keyboard navigation (Left/Right arrows)
* Lightweight thumbnail strip
* No jQuery or external dependencies
* RSS‑safe fallback (static images, no scripts)

== RSS Fallback ==

When viewed in RSS readers, the plugin outputs medium‑sized images, each linking to the full image, with no JavaScript or UI elements.

== Frequently Asked Questions ==

= How do I add images to the gallery? =
Edit the post, upload images via the Media Library while editing, 
then save. WordPress automatically attaches those images to the 
post and the shortcode displays them.

= Can I use the gallery more than once on a page? =
Yes. Each [pulp_gallery] shortcode displays the images attached 
to the current post.

= Can I change the image sizes? =
Yes. Use the size and thumbsize attributes:
[pulp_gallery size="medium" thumbsize="thumbnail"]
Any registered WordPress image size is supported.

= Does it work on mobile? =
Yes. The gallery supports swipe and drag navigation on touch 
devices.

= Does it work with keyboard navigation? =
Yes. Use the Left and Right arrow keys to navigate between images.

= Does it work in RSS feeds? =
Yes. When viewed in a feed reader, the plugin outputs a 
simplified static version with medium-sized images linking to 
the full image. No JavaScript or interactive elements are 
included.

= Does it require jQuery or any other libraries? =
No. The plugin has zero external dependencies.

= What post types does it support? =
Any post type that supports media attachments.

== Installation ==

1. Upload the plugin folder to /wp-content/plugins/
2. Activate Pulp Gallery
3. Add the shortcode to any post or page

== Changelog ==

= 1.1.1 =
* Updated WordPress compatibility to 7.0

= 1.1.0 =
* Previous release

