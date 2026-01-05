Pulp Gallery

A lightweight, fast, zero‑bloat WordPress gallery plugin built for PulpCovers.com. Pulp Gallery displays image attachments using a clean, responsive, swipe‑friendly gallery powered entirely by a simple shortcode.

Features

Simple [pulp_gallery] shortcode for inserting galleries anywhere in post content

Clean, responsive layout

Swipe + drag support on touch devices

Keyboard navigation (Left/Right arrows)

Lightweight thumbnail strip

Zero dependencies, zero jQuery

RSS‑safe fallback (no JavaScript, no buttons, no broken markup)

Designed for multi‑page scans, magazines, comics, and pulp archives

Installation

Download the latest release ZIP

Upload it to wp-content/plugins/

Activate Pulp Gallery in Plugins → Installed Plugins

Insert the shortcode into any post or page:

[pulp_gallery]

No configuration required.

Usage

Basic Shortcode

[pulp_gallery]

This displays all image attachments for the current post, sorted by menu order.

Optional Attributes

[pulp_gallery size="medium" thumbsize="thumbnail"]

size — main image size (default: medium)

thumbsize — thumbnail size (default: thumbnail)

Attaching Images

Pulp Gallery displays images attached to the post. To attach images:

Edit the post

Upload images using the Media Library while editing that post

Save the post

WordPress automatically associates those images with the post, and the shortcode displays them.

RSS Fallback

RSS readers do not support JavaScript or interactive elements.When a feed is generated, Pulp Gallery automatically outputs a simplified, RSS‑safe version:

Medium‑sized images

Each linking to the full image

No buttons, no scripts, no interactive UI

This keeps feeds clean and readable.

📁 File Structure

pulp-gallery/
│
├── pulp-gallery.php
├── includes/
│   ├── class-pulp-gallery-assets.php
│   ├── class-pulp-gallery-shortcode.php
│   ├── rss-fallback.php
│   └── helpers.php
├── templates/
│   └── gallery.php
└── assets/
    ├── css/
    └── js/

Development

Clone the repository:

git clone https://github.com/pulpcovers/pulp-gallery.git

GitHub Actions automatically builds a ZIP on every push to main.You can download it from the Actions tab.

License

Creative Commons CC0 1.0 Universalhttps://creativecommons.org/publicdomain/zero/1.0/

This plugin is dedicated to the public domain.You may use, modify, redistribute, or incorporate it into other projects without restriction.

