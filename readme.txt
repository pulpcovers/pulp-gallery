=== Pulp Gallery ===
Contributors: pulpcovers
Requires at least: 5.0
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 1.1.0
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
3. Save the post  
4. Insert [pulp_gallery]

== Features ==

* Responsive layout
* Swipe + drag navigation on touch devices
* Keyboard navigation (Left/Right arrows)
* Lightweight thumbnail strip
* No jQuery or external dependencies
* RSS‑safe fallback (static images, no scripts)

== RSS Fallback ==

When viewed in RSS readers, the plugin outputs medium‑sized images, each linking to the full image, with no JavaScript or UI elements.

== Installation ==

1. Upload the plugin folder to /wp-content/plugins/
2. Activate Pulp Gallery
3. Add the shortcode to any post or page

== License ==

Released under CC0 1.0 Universal (public domain).  
Free to use, modify, or redistribute without restriction.

