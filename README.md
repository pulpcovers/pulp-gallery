# Pulp Gallery

A lightweight, fast, zero-bloat WordPress gallery plugin built for PulpCovers.com.
Pulp Gallery displays post-attached images in a clean, responsive, swipe-friendly layout using a simple shortcode.

## Features

- Simple shortcode — insert galleries anywhere with [pulp_gallery]
- Responsive layout — adapts cleanly to all screen sizes
- Touch gestures — swipe + drag navigation on mobile
- Keyboard navigation — Left/Right arrow support
- Lightweight thumbnail strip — fast, minimal UI
- Zero dependencies — no jQuery, no frameworks
- RSS-safe fallback — clean, non-interactive markup for feeds
- Ideal for multi-page scans — magazines, comics, pulp archives

## Installation

- Download the latest release ZIP
- Upload to wp-content/plugins/
- Activate “Pulp Gallery” in Plugins → Installed Plugins
- Insert the shortcode into any post or page:

```
[pulp_gallery]
```

No configuration required.

## Usage

### Basic Shortcode

```
[pulp_gallery]
```

Displays all image attachments for the current post, sorted by menu order.

### Optional Attributes

```
[pulp_gallery size="medium" thumbsize="thumbnail"]
```

- size — main image size (default: medium)
- thumbsize — thumbnail size (default: thumbnail)

## Attaching Images

Pulp Gallery displays images attached to the post.

- Edit the post
- Upload images via the Media Library while editing
- Save the post

WordPress automatically associates those images with the post, and the shortcode displays them.

## RSS Fallback

RSS readers don’t support JavaScript or interactive UI.
When a feed is generated, Pulp Gallery outputs a simplified, RSS-safe version:

- Medium-sized images
- Each linking to the full image
- No buttons or scripts

This keeps feeds clean and readable.

## 📁 File Structure

```
pulp-gallery/
    pulp-gallery.php
    readme.txt
    README.md
    uninstall.php

    includes/
        class-pulp-gallery-assets.php
        class-pulp-gallery-shortcode.php
        class-pulp-gallery-settings.php
        rss-fallback.php
        helpers.php

    templates/
        gallery.php

    assets/
        css/
            pulp-gallery.css
        js/
            pulp-gallery.js
```

## Development

- Clone the repository
  ```
  git clone https://github.com/pulpcovers/pulp-gallery.git
  ```

## License

Creative Commons CC0 1.0 Universal  
https://creativecommons.org/publicdomain/zero/1.0/

This plugin is dedicated to the public domain.
You may use, modify, redistribute, or incorporate it into any project without restriction.
