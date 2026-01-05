=== Pulp Gallery ===
Contributors: pulpcovers
Tags: gallery, images, attachments, pulp, magazines, comics
Requires at least: 5.0
Tested up to: 6.7
Stable tag: 1.0.0
License: CC0 1.0 Universal
License URI: https://creativecommons.org/publicdomain/zero/1.0/

A lightweight, fast gallery plugin designed for PulpCovers.com. Automatically displays all image attachments for a post as a clean, swipe‑friendly gallery with keyboard navigation and RSS‑safe fallbacks.

== Description ==

Pulp Gallery is a minimal, performance‑focused WordPress plugin that automatically turns a post’s attached images into a responsive, touch‑friendly gallery. It was built for PulpCovers.com, where each post contains a full magazine or book scanned into multiple images.

**Features:**

- Simple `[pulp_gallery]` shortcode for inserting galleries anywhere in post content  
- Clean, responsive layout  
- Swipe + drag support on touch devices  
- Keyboard navigation (Left/Right arrows)  
- Lightweight thumbnail strip  
- Zero dependencies, zero jQuery  
- RSS‑safe fallback (no JavaScript, no buttons, no broken markup)  
- Designed for multi‑page scans, magazines, comics, and pulp archives  
 

This plugin is ideal for sites that publish multi‑page scans, magazines, comics, or image‑heavy posts.

== Installation ==

1. Upload the plugin folder to `/wp-content/plugins/pulp-gallery/`
2. Activate the plugin through **Plugins → Installed Plugins**
3. Attach images to any post using the WordPress Media Library
4. Insert the shortcode into any post or page: [pulp_gallery]
5. View the post — the gallery appears automatically

No configuration required.

== Usage ==

If you want to place the gallery manually inside post content:
[pulp_gallery]

Optional attributes:
[pulp_gallery size="medium" thumbsize="thumbnail"]


### **RSS Fallback**

RSS readers do not support JavaScript or interactive elements.  
Pulp Gallery automatically outputs a simplified, RSS‑safe version:

- Medium‑sized images  
- Each linking to the full image  
- No buttons or JS hooks  

This ensures feeds remain clean and readable.

== Frequently Asked Questions ==

= Why aren’t my images showing? =  
Make sure the images are **attached** to the post, not just inserted.  
WordPress attaches images when you upload them *from the post editor*.

= Does it work with Gutenberg? =  
Yes. The gallery appears automatically below the post content unless you place the shortcode manually.

= Does it work with Classic Editor? =  
Yes.

= Does it require JavaScript? =  
The interactive gallery does, but RSS fallback does not.

= Can I customize the template? =  
Yes. Templates live in `/templates/gallery.php`.  
You may override them in your theme if desired.

== Changelog ==

= 1.0.0 =
* Initial public release
* Automatic gallery rendering
* Swipe + keyboard navigation
* RSS fallback support
* Shortcode support

== Upgrade Notice ==

= 1.0.0 =
Initial release.